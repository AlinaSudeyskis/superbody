<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use YandexCheckout\Client;

/**
 * Класс Store_model
 *
 * Класс для выборки, сохранения, изменения данных интернет магазина, товаров, категорий товаров, корзины пользователя
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Store_model extends CI_Model
{
    const SHOPID = 188363;
    const SHOP_SECRET = 'live_yB_n1qwrD5q3SPgdu3EtwzINTrpL8Tmn7bFCYG-eBd4';
    const SCID = 715012;
    const TEST_SCID = 561490;

    /**
     * Выборка всех категорий
     *
     * @return array
     */
    public function getECategories()
    {
        $result = array();

        $sel_cats = $this->db->query('SELECT `cat_id`, `cat_name` FROM `categories` ORDER BY `cat_id` ASC');

        if ($sel_cats !== false and 0 < $sel_cats->num_rows())
        {
            $i = 0;
            foreach ($sel_cats->result() as $row)
            {
                $result['categories'][$i]['id']   = $row->cat_id;
                $result['categories'][$i]['name'] = $row->cat_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_cats === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных категории и список её подкатегорий (закомментировано)
     *
     * @param $category_id
     * @return array
     */
    public function getECategory($category_id)
    {
        $result = array();

        $sel_cat = $this->db->query('
            SELECT `cat_id`, `cat_name`, `cat_description`, `cat_blocked`, `cat_date_add`, `cat_date_update`
            FROM `categories`
            WHERE `cat_id`=? LIMIT 1', $category_id);

        if ($sel_cat !== false and 1 == $sel_cat->num_rows())
        {
            $row = $sel_cat->row();

            $result['category']['id']      = $row->cat_id;
            $result['category']['name']    = $row->cat_name;
            $result['category']['desc']    = $row->cat_description;
            $result['category']['blocked'] = $row->cat_blocked;

            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cat_date_add);
            $date_add = ($row->cat_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->cat_date_add))
                : '';
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cat_date_update);
            $date_update = ($row->cat_date_update != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->cat_date_update))
                : '';

            $result['category']['date_add'] = $date_add;
            $result['category']['date_update'] = $date_update;

            unset($row);
            $sel_cat->free_result();

            // Выборка подкатегорий
            /*$sel_subcats = $this->db->query('
                SELECT `subcat_id`, `subcat_name`
                FROM `subcategories`
                WHERE `subcat_cat_id`=?', $category_id);

            if (0 < $sel_subcats->num_rows()) {
                $i = 0;
                foreach ($sel_subcats->result() as $row) {
                    $result['category']['subcategories'][$i]['id']   = $row->subcat_id;
                    $result['category']['subcategories'][$i]['name'] = $row->subcat_name;

                    $i++;
                }
                unset($row);
            }*/
        }
        elseif ($sel_cat === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение новой категории
     *
     * @param $name
     * @param $description
     * @param $date
     * @param $admin_id
     * @return bool
     */
    public function setNewCategory($name, $description, $date, $admin_id)
    {
        $up_data = $this->db->query('
            INSERT INTO `categories` (`cat_name`, `cat_description`, `cat_date_add`, `cat_date_update`, `cat_admin_id`)
            VALUES (?, ?, ?, ?, ?)', array($name, $description, $date, $date, $admin_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение изменений данных категории
     *
     * @param $category_id
     * @param $name
     * @param $description
     * @param $date
     * @return bool
     */
    public function updateCategorySettings($category_id, $name, $description, $date)
    {
        $up_data = $this->db->query('
            UPDATE `categories` SET `cat_name`=?, `cat_description`=?, `cat_date_update`=? 
            WHERE `cat_id`=? LIMIT 1', array($name, $description, $date, $category_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Блокировка категории
     *
     * @param $category_id
     * @param $date
     * @return bool
     */
    public function blockCategory($category_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `categories` SET `cat_blocked`=1, `cat_date_update`=? WHERE `cat_id`=? LIMIT 1', array($date, $category_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Разблокировка категории
     *
     * @param $category_id
     * @param $date
     * @return bool
     */
    public function unblockCategory($category_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `categories` SET `cat_blocked`=0, `cat_date_update`=? WHERE `cat_id`=? LIMIT 1', array($date, $category_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }


    /**
     * Выборка данных для подкатегории
     *
     * @param $subcategory_id
     * @return array
     */
    /*public function getESubcategory($subcategory_id)
    {
        $result = array();

        $sel_subcat = $this->db->query('
            SELECT `subcat_id`, `subcat_cat_id`, `subcat_name`, `subcat_blocked`, `subcat_date_add`, `subcat_date_update`
            FROM `subcategories`
            WHERE `subcat_id`=? LIMIT 1', $subcategory_id);

        if (1 == $sel_subcat->num_rows()) {
            $row = $sel_subcat->row();

            $result['subcategory']['id']      = $row->subcat_id;
            $result['subcategory']['cat_id']  = $row->subcat_cat_id;
            $result['subcategory']['name']    = $row->subcat_name;
            $result['subcategory']['blocked'] = $row->subcat_blocked;

            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->subcat_date_add);
            $date_add = ($row->subcat_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->subcat_date_add))
                : '';
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->subcat_date_update);
            $date_update = ($row->subcat_date_update != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->subcat_date_update))
                : '';

            $result['subcategory']['date_add']    = $date_add;
            $result['subcategory']['date_update'] = $date_update;

            unset($row);
            $sel_subcat->free_result();
        }

        return $result;
    }*/

    /**
     * Сохранение новой подкатегории
     *
     * @param $category_id
     * @param $name
     * @param $date
     * @param $admin_id
     * @return bool
     */
    /*public function setNewSubcategory($category_id, $name, $date, $admin_id)
    {
        $this->db->query('
            INSERT INTO `subcategories` (`subcat_cat_id`, `subcat_name`, `subcat_date_add`, `subcat_date_update`, `subcat_admin_id`)
            VALUES (?, ?, ?, ?, ?)', array($category_id, $name, $date, $date, $admin_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }*/

    /**
     * Сохранение изменений данных подкатегории
     *
     * @param $subcategory_id
     * @param $category_id
     * @param $name
     * @param $date
     * @return bool
     */
    /*public function updateSubcategorySettings($subcategory_id, $category_id, $name, $date)
    {
        $this->db->query('
            UPDATE `subcategories` SET `subcat_cat_id`=?, `subcat_name`=?, `subcat_date_update`=? 
            WHERE `subcat_id`=? LIMIT 1', array($category_id, $name, $date, $subcategory_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }*/

    /**
     * Блокировка подкатегории
     *
     * @param $subcategory_id
     * @param $date
     * @return bool
     */
    /*public function blockSubcategory($subcategory_id, $date)
    {
        $this->db->query('
            UPDATE `subcategories` SET `subcat_blocked`=1, `subcat_date_update`=? WHERE `subcat_id`=? LIMIT 1', array($date, $subcategory_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }*/

    /**
     * Разблокировка подкатегории
     *
     * @param $subcategory_id
     * @param $date
     * @return bool
     */
    /*public function unblockSubcategory($subcategory_id, $date)
    {
        $this->db->query('
            UPDATE `subcategories` SET `subcat_blocked`=0, `subcat_date_update`=? WHERE `subcat_id`=? LIMIT 1', array($date, $subcategory_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }*/


    /**
     * Выборка всех не заблокированных категорий
     *
     * @return array
     */
    public function getCategories()
    {
        $result = array();

        $sel_cats = $this->db->query('SELECT `cat_id`, `cat_name`, `cat_description` FROM `categories`
            WHERE `cat_blocked`=0 ORDER BY `cat_id` ASC');

        if ($sel_cats !== false and 0 < $sel_cats->num_rows())
        {
            $i = 0;
            foreach ($sel_cats->result() as $row) {
                $result['categories'][$i]['id']   = $row->cat_id;
                $result['categories'][$i]['name'] = $row->cat_name;
                $result['categories'][$i]['desc'] = $row->cat_description;

                $i++;
            }
            unset($row);

            /*foreach ($result['categories'] as $key => $category) {
                $sel_subcats = $this->db->query('
                    SELECT `subcat_id`, `subcat_name`
                    FROM `subcategories`
                    WHERE `subcat_cat_id`=? and `subcat_blocked`=0', $category['id']);

                if (0 < $sel_subcats->num_rows()) {
                    $i = 0;
                    foreach ($sel_subcats->result() as $row) {
                        $result['categories'][$key]['subcategories'][$i]['id']   = $row->subcat_id;
                        $result['categories'][$key]['subcategories'][$i]['name'] = $row->subcat_name;

                        $i++;
                    }
                    unset($row);
                }
            }
            unset($category);*/
        }
        elseif ($sel_cats === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка подкатегорий выборанной категории
     *
     * @param $category_id
     * @return array
     */
    public function getCategorySubcategories($category_id)
    {
        $result = array();

        $sel_subcats = $this->db->query('
            SELECT `subcat_id`, `subcat_name`
            FROM `subcategories`
            WHERE `subcat_cat_id`=? and `subcat_blocked`=0', $category_id);

        if ($sel_subcats !== false and 0 < $sel_subcats->num_rows())
        {
            $i = 0;
            foreach ($sel_subcats->result() as $row) {
                $result['subcategories'][$i]['id']   = $row->subcat_id;
                $result['subcategories'][$i]['name'] = $row->subcat_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_subcats === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка категорий
     *
     * @return array
     */
    public function getCategoriesId()
    {
        $result = array();

        $sel_cats = $this->db->query('
            SELECT `cat_id` FROM `categories` WHERE `cat_blocked`=0');

        if ($sel_cats !== false and 0 < $sel_cats->num_rows())
        {
            $i = 0;
            foreach ($sel_cats->result() as $row) {
                $result['id'][$i] = $row->cat_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_cats === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка подкатегорий
     *
     * @param $category_id
     * @return array
     */
    public function getSubcategoriesId($category_id)
    {
        $result = array();

        $sel_subcats = $this->db->query('
            SELECT `subcat_id` FROM `subcategories` WHERE `subcat_cat_id`=? and `subcat_blocked`=0', $category_id);

        if ($sel_subcats !== false and 0 < $sel_subcats->num_rows())
        {
            $i = 0;
            foreach ($sel_subcats->result() as $row) {
                $result['id'][$i] = $row->subcat_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_subcats === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ ТОВАРА */

    /**
     * Выборка всех товаров
     *
     * @param int $first_id ID первого элемента страницы
     * @param float $first_price Цена первого элемента
     * @param float $first_discount Акция первого элемента
     * @param int $last_id ID последнего элемента страницы
     * @param float $last_price Цена последнего элемента
     * @param float $last_discount Акция последнего элемента
     * @param int $limit Кол-во товаров на страницу (LIMIT + 1 (next))
     * @return array
     */
    public function getProducts($first_id = null, $first_price = null, $first_discount = null,
                                $last_id = null, $last_price = null, $last_discount = null, $limit = 9)
    {
        $result    = array();
        $order_by  = '`p_id` DESC';
        $union_all = '';
        $next_page = false;
        $prev_page = false;
        $cols      = '`p_id`, `p_course_id`, `p_name`, `p_short_description`, `p_price`, `p_fitcoin_price`, `p_quantity`, 
                     `p_discount`, `p_discount_type`, `p_images`, `p_date_add`, `p_blocked`';

        $first_id = (int) $first_id;
        $first_price = (float) $first_price;
        $first_discount = (float) $first_discount;
        $last_id = (int) $last_id;
        $last_price = (float) $last_price;
        $last_discount = (float) $last_discount;

        $result['first_id']       = '';
        $result['first_price']    = '';
        $result['first_fc_price'] = '';
        $result['first_discount'] = '';

        $result['last_id']       = '';
        $result['last_price']    = '';
        $result['last_fc_price'] = '';
        $result['last_discount'] = '';

        // Если нажата "Следующая страница"
        if (!empty($last_id) and !empty($last_price)) {
            $union_all = '
                    (SELECT ' . $cols . '
                    FROM `products`
                    WHERE `p_course_id`=0 and `p_id`<'. $last_id .' and `p_blocked`=0 '
                . ' ORDER BY ' . $order_by
                . ' LIMIT '.$limit.')';
        }
        // Если нажата "Предыдущая страница"
        elseif (!empty($first_id) and !empty($first_price)) {
            $union_all = '
                    (SELECT ' . $cols . '
                    FROM `products`
                    WHERE `p_course_id`=0 and `p_id`>'. $first_id .' and `p_blocked`=0 '
                . ' LIMIT '.$limit.')';
        }

        $table = !empty($union_all) ? '('.$union_all.') as `temp_products`' : '`products`';

        $sql_query = 'SELECT ' . $cols . '
            FROM ' . $table
            . ' WHERE `p_course_id`=0 '
            . ' ORDER BY ' . $order_by
            . ' LIMIT ?';

        $result['sql'] = $sql_query;

        $sel_products = $this->db->query($sql_query, $limit);

        $result['sql_result'] = $sel_products->result();

        if ($sel_products !== false and 0 < $sel_products->num_rows())
        {
            $count_rows = $sel_products->num_rows();
            $elements = $sel_products->result();

            // Если нажата "Предыдущая страница"
            if (!empty($first_id))
            {
                if ($count_rows == $limit)
                {
                    // Извлекаем первый элемент массива
                    array_shift($elements);
                    $count_rows--;
                    $prev_page = true;
                }
                $next_page = true;
            }
            // Если нажата "Следующая страница"
            elseif (!empty($last_id))
            {
                if ($count_rows == $limit)
                {
                    // Извлекаем последний элемент массива
                    array_pop($elements);
                    $count_rows--;
                    $next_page = true;
                }

                $prev_page = true;
            }
            // Первая страница
            elseif ($count_rows == $limit and empty($first_id) and empty($last_id))
            {
                // Извлекаем последний элемент массива
                array_pop($elements);
                $count_rows--;
                $next_page = true;
            }

            $i = 0;
            foreach ($elements as $key => $row)
            {
                // Данные
                $result['products'][$i] = self::parseProductData($row);

                // Данные пагинации
                // Данные последнего элемента страницы
                if ($next_page === true and $key == ($count_rows-1))
                {
                    // Последний элемент страницы
                    $result['last_id']       = $row->p_id;
                    $result['last_price']    = $row->p_price;
                    $result['last_fc_price'] = $row->p_fitcoin_price;
                    $result['last_discount'] = $row->p_discount;
                }
                // Данные первого элемента страницы
                if ($prev_page === true and $key == 0)
                {
                    // Последний элемент страницы
                    $result['first_id']       = $row->p_id;
                    $result['first_price']    = $row->p_price;
                    $result['first_fc_price'] = $row->p_fitcoin_price;
                    $result['first_discount'] = $row->p_discount;
                }

                $i++;
            }
            unset($row);
        }
        elseif ($sel_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных товара для редактирования
     *
     * @param $product_id
     * @return array
     */
    public function getProduct($product_id)
    {
        $result = array();

        $sel_product = $this->db->query('
            SELECT `p_id`, `p_course_id`, `p_name`, `p_short_description`, `p_full_description`, `p_price`, `p_fitcoin_price`, 
              `p_quantity`, `p_discount`, `p_discount_type`, `p_images`, `p_union_flag`, `p_date_add`, `p_blocked`, `pc_cat_id` 
            FROM `products`
            LEFT JOIN `products_categories`
              ON `pc_p_id`=`p_id`
            WHERE `p_id`=? and `p_course_id`=0 LIMIT 1', $product_id);

        if ($sel_product !== false and 1 == $sel_product->num_rows())
        {
            $row = $sel_product->row();

            $result['product'] = self::parseProductData($row);
            
            $result['product']['attached']     = array();
            $result['product']['attached_id']  = array();
            $result['product']['attached_discount'] = array();
            $result['product']['category_id']  = $row->pc_cat_id;

            unset($row);

            // Выборка прикрепленных товаров
            $sel_attached_products = $this->db->query('
                SELECT `pg_attached_p_id`, `pg_discount`, `p_name`, `p_price`
                FROM `products_group`
                LEFT JOIN `products` ON `p_id`=`pg_attached_p_id`
                WHERE `pg_p_id`=?' , $product_id);

            if ($sel_attached_products !== false and 0 < $sel_attached_products->num_rows())
            {
                $i = 0;
                foreach ($sel_attached_products->result() as $row)
                {
                    $result['product']['attached'][$i] = self::parseAttachedProductData($row);

                    $result['product']['attached_id'][$i] = $row->pg_attached_p_id;
                    $result['product']['attached_discount'][$i] = $result['product']['attached'][$i]['discount'];

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_attached_products === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_product === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение нового товара и его категорию в БД
     *
     * @param string $name Наименование товара
     * @param string $short_desc Краткое описание
     * @param string $full_desc Полное описание
     * @param int $price Цена в рублях
     * @param int $quantity Кол-во
     * @param int $discount Скидка на товар
     * @param int $discount_type Тип скидки (процент)
     * @param int $category_id ID категории
     * @param array $attached_products Прикрепленные товары
     * @param string $date Дата
     * @param int $admin_id Id админа
     * @return bool
     */
    public function setNewProduct($name, $short_desc, $full_desc, $price, $quantity, $discount, $discount_type,
                                  $category_id, $attached_products, $date, $admin_id)
    {
        $in_data = $this->db->query('
            INSERT INTO `products` (`p_name`, `p_short_description`, `p_full_description`, `p_price`, 
              `p_quantity`, `p_discount`, `p_discount_type`, `p_date_add`, `p_date_update`, `p_admin_id`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($name, $short_desc, $full_desc, $price, $quantity, $discount, $discount_type, $date, $date, $admin_id));

        if ($in_data !== false and 1 == $this->db->affected_rows())
        {
            $product_id = $this->db->insert_id();

            // Категория товара
            $in_data2 = $this->db->query('
                INSERT INTO `products_categories` (`pc_p_id`, `pc_cat_id`, `pc_date_update`, `pc_admin_id`)
                VALUES (?, ?, ?, ?)', array($product_id, $category_id, $date, $admin_id));
            if ($in_data2 === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            // Прикрепленные товары
            if (!empty($attached_products['insert']))
            {
                foreach ($attached_products['insert'] as $a_id => $p_discount)
                {
                    $in_data3 = $this->db->query('
                        INSERT INTO `products_group` 
                          (`pg_p_id`, `pg_attached_p_id`, `pg_discount`, `pg_admin_id`, `pg_date_update`) 
                        VALUES (?, ?, ?, ?, ?)', array($product_id, $a_id, $p_discount, $admin_id, $date));
                    if ($in_data3 === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($p_discount);
                unset($a_id);
            }

            return $product_id;
        }
        elseif ($in_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение данных о пути к изображениям товара
     *
     * @param $product_id
     * @param $files_data
     * @param $date
     * @return bool
     */
    public function setProductImages($product_id, $files_data, $date)
    {
        $images = implode(';', $files_data);

        $up_data = $this->db->query('
            UPDATE `products` SET `p_images`=?, `p_date_update`=? WHERE `p_id`=? LIMIT 1', array($images, $date, $product_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение изменений данных товара
     *
     * @param int $product_id
     * @param string $category_id
     * @param string $name
     * @param string$short_desc
     * @param string $full_desc
     * @param float $price
     * @param float $fitcoin_price
     * @param int $quantity
     * @param float $discount
     * @param int $discount_type
     * @param array $attached_products
     * @param string $date
     * @param int $user_id
     * @return bool
     */
    public function updateProductSettings($product_id, $category_id, $name, $short_desc, $full_desc, $price, $quantity,
                                          $discount, $discount_type, $attached_products, $date, $user_id)
    {
        $up_data = $this->db->query('
            UPDATE `products` 
            SET `p_name`=?, `p_short_description`=?, `p_full_description`=?, `p_price`=?, 
              `p_quantity`=?, `p_discount`=?, `p_date_update`=? 
            WHERE `p_id`=? LIMIT 1', array($name, $short_desc, $full_desc, $price, $quantity, $discount, $date, $product_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            // Прикрепленные товары
            if (!empty($attached_products['insert']))
            {
                foreach ($attached_products['insert'] as $a_id => $p_discount)
                {
                    $in_data = $this->db->query('
                        INSERT INTO `products_group` 
                          (`pg_p_id`, `pg_attached_p_id`, `pg_discount`, `pg_admin_id`, `pg_date_update`) 
                        VALUES (?, ?, ?, ?, ?)', array($product_id, $a_id, $p_discount, $user_id, $date));
                    if ($in_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($p_discount);
                unset($a_id);
            }
            if (!empty($attached_products['update']))
            {
                foreach ($attached_products['update'] as $a_id => $p_discount)
                {
                    $in_data = $this->db->query('
                        UPDATE `products_group` SET `pg_discount`=?, `pg_date_update`=? 
                        WHERE `pg_p_id`=? and `pg_attached_p_id`=? LIMIT 1',
                            array($p_discount, $date, $product_id, $a_id));
                    if ($in_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($p_discount);
                unset($a_id);
            }
            if (!empty($attached_products['delete']))
            {
                foreach ($attached_products['delete'] as $a_id)
                {
                    $in_data = $this->db->query('
                        DELETE FROM `products_group` WHERE `pg_p_id`=? and `pg_attached_p_id`=? LIMIT 1',
                            array($product_id, $a_id));
                    if ($in_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($a_id);
            }

            /*if (!empty($attached_products)) {
                foreach ($attached_products as $product) {
                    $sel_attached_product = $this->db->query('
                        SELECT `pg_id` FROM `products_group` WHERE `pg_p_id`=? and `pg_attached_p_id`=? LIMIT 1',
                            array($product_id, $product['id']));

                    if (1 == $sel_attached_product->num_rows()) {
                        $this->db->query('
                            UPDATE `products_group` SET `pg_discount`=?, `pg_date_update`=? 
                            WHERE `pg_p_id`=? and `pg_attached_p_id`=? LIMIT 1',
                                array($product['discount'], $date, $product_id, $product['id']));
                    } else {
                        $this->db->query('
                            INSERT INTO `products_group` 
                              (`pg_p_id`, `pg_attached_p_id`, `pg_discount`, `pg_admin_id`, `pg_date_update`) 
                            VALUES (?, ?, ?, ?, ?)', array($product_id, $product['id'], $product['discount'], $user_id, $date));
                    }
                    $sel_attached_product->free_result();
                }
                unset($product);
            }*/

            // Категория товара
            $up_data2 = $this->db->query('
                UPDATE `products_categories` 
                SET `pc_cat_id`=?, `pc_date_update`=? 
                WHERE `pc_p_id`=? LIMIT 1', array($category_id, $date, $product_id));
            if ($up_data2 === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Добавление категорий товара
     *
     * @param int $product_id ID товара
     * @param int $category_id ID категории 
     * @param array $insert_cat Массив новых категорий для добавления
     * @param $date
     * @param $admin_id
     * @return bool
     */
    public function insertCategoriesProduct($product_id, $category_id, $insert_cat, $date, $admin_id)
    {
        $result = true;

        // Добавление новой категории
        if(!empty($insert_cat))
        {
            foreach($insert_cat as $new_cat)
            {
                $in_data = $this->db->query('
                    INSERT INTO `products_categories` (`pc_p_id`, `pc_cat_id`, `pc_subcat_id`, `pc_date_update`, `pc_admin_id`)
                    VALUES(?, ?, ?, ?, ?)', array($product_id, $category_id, $new_cat, $date, $admin_id));

                if($in_data !== false and $this->db->affected_rows() != 1)
                {
                    $result = false;
                }
                elseif ($in_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    return false;
                }
            }
        }

        return $result;
    }
    
    /**
     * Обновление категорий товара
     *
     * @param int $product_id ID товара
     * @param int $category_id ID категории 
     * @param array $update_cat Массив новых категорий для обновления
     * @param array $old_cat Массив старых категорий для обновления
     * @param $date
     * @return bool
     */
    public function updateCategoriesProduct($product_id, $category_id, $update_cat, $old_cat, $date)
    {
        $result = true;

        // Обновление данных категории товара
        if(!empty($update_cat))
        {
            foreach($update_cat as $key => $up_cat)
            {
                $up_data = $this->db->query('UPDATE `products_categories` SET `pc_cat_id`=?, `pc_subcat_id`=?, `pc_date_update`=?
                    WHERE `pc_p_id`=? and `pc_subcat_id`=?
                    LIMIT 1', array($category_id, $up_cat, $date, $product_id, $old_cat[$key]));

                if($up_data !== false and $this->db->affected_rows() != 1){
                    $result = false;
                }
                elseif ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }

        return $result;
    }

    /**
     * Удаление категорий товара
     *
     * @param int $product_id ID товара
     * @param array $delete_cat Массив категорий для удаления
     * @param int $count_categories Метка для уделания всех категорий товаров
     * @return bool
     */ 
    public function deleteCategoriesProduct($product_id, $delete_cat = null, $count_categories = null)
    {
        $result = true;

        // Удаление категории
        if(!empty($delete_cat))
        {
            foreach($delete_cat as $del_cat)
            {
                $up_data = $this->db->query('DELETE FROM `products_categories`
                  WHERE `pc_p_id`=? and `pc_subcat_id`=? LIMIT 1', array($product_id, $del_cat));

                if($up_data !== false and $this->db->affected_rows() != 1)
                {
                    $result = false;
                }
                elseif ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        } 
        elseif (!empty($count_categories) and is_numeric($count_categories))
        {
            $up_data = $this->db->query('DELETE FROM `products_categories`
                  WHERE `pc_p_id`=? LIMIT ?', array($product_id, $count_categories));

            if($up_data !== false and $this->db->affected_rows() == 0){
                $result = false;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
                return false;
            }
        }

        return $result;
    }

    /**
     * Блокировака товара
     *
     * @param $product_id
     * @param $date
     * @return bool
     */
    public function blockProduct($product_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `products` SET `p_blocked`=1, `p_date_update`=? WHERE `p_id`=? LIMIT 1', array($date, $product_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Разблокировка товара
     *
     * @param $product_id
     * @param $date
     * @return bool
     */
    public function unblockProduct($product_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `products` SET `p_blocked`=0, `p_date_update`=? WHERE `p_id`=? LIMIT 1', array($date, $product_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ ТОВАРА */

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ВЫВОДА ДАННЫХ ТОВАРОВ ИНТЕРНЕТ-МАГАЗИНА */

    /**
     * Выборка всех не заблокированных товаров
     *
     * @param int $category_id Катеория товара
     * @param int $subcategory_id Подкатегория товара
     * @param int $sort Сортировка
     * @param string $search Строка поиска
     * @param int $limit Кол-во товаров на страницу (LIMIT + 1 (next))
     * @param int $first_id ID первого элемента страницы
     * @param float $first_price Цена первого элемента
     * @param float $first_discount Акция первого элемента
     * @param int $last_id ID последнего элемента страницы
     * @param float $last_price Цена последнего элемента
     * @param float $last_discount Акция последнего элемента
     * @return array
     */
    public function getStoreProducts($category_id = null, $subcategory_id = null, $sort = null, $search = null, $limit = 9,
                                     $first_id = null, $first_price = null, $first_discount = null,
                                     $last_id = null, $last_price = null, $last_discount = null)
    {
        //echo $category_id.' '.$subcategory_id.' '.$sort.' '.$search.' '.$limit.'<br/>';
        $result         = array();
        $where_search   = '';
        $where_category = '';
        $order_by       = '`p_id` DESC';
        $union_all      = '';
        $next_page      = false;
        $prev_page      = false;

        $cols = '`p_id`, `p_course_id`, `p_name`, `p_short_description`, `p_price`, `p_fitcoin_price`, `p_quantity`, 
                `p_discount`, `p_discount_type`, `p_images`, `p_date_add`, `p_blocked`, `pc_cat_id`,
                `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`, `crs_blocked`';

        $sort           = (int) $sort;
        $first_id       = (int) $first_id;
        $first_price    = (float) $first_price;
        $first_discount = (float) $first_discount;
        $last_id        = (int) $last_id;
        $last_price     = (float) $last_price;
        $last_discount  = (float) $last_discount;

        $result['first_id']       = '';
        $result['first_price']    = '';
        $result['first_fc_price'] = '';
        $result['first_discount'] = '';

        $result['last_id']       = '';
        $result['last_price']    = '';
        $result['last_fc_price'] = '';
        $result['last_discount'] = '';

        // Если строка поиска не пустая, добавляем в условие поиска
        if (!empty($search))
        {
            $search = '+' . $search . '*';
            $where_search = ' and MATCH (`p_name`, `p_short_description`, `p_full_description`) AGAINST (? IN BOOLEAN MODE)';
        }

        // Если задан ID категории, добавляем в условие поиска
        if (is_numeric($category_id))
        {
            $where_category = ' and `products_categories`.`pc_cat_id`=' . $category_id;
        }

        // Если задан ID подкатегории, добавляем в условие поиска
        /*if (!empty($subcategory_id) and is_numeric($subcategory_id) and $category_id != 'courses') {
            $and_where .= ' and `pc_subcat_id`=' . $subcategory_id;
        }*/
        // Если задана сортировка, добавляем в условие сортировки
        if (!empty($sort))
        {
            // Цена по возрастанию
            if ($sort == 1)
            {
                $order_by = '`p_price` ASC';
                $order_by_course = '`crs_price` ASC';

                // Если нажата "Следующая страница"
                if (!empty($last_id) and !empty($last_price))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`>'.$last_price .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`='.$last_price.' and `p_id`>'.$last_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
                // Если нажата "Предыдущая страница"
                elseif (!empty($first_id) and !empty($first_price))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`<'.$first_price .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`='.$first_price.' and `p_id`<'.$first_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
            }
            // Цена по убыванию
            elseif ($sort == 2)
            {
                $order_by = '`p_price` DESC';
                $order_by_course = '`crs_price` DESC';

                // Если нажата "Следующая страница"
                if (!empty($last_id) and !empty($last_price))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`<'.$last_price .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`='.$last_price.' and `p_id`>'.$last_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
                // Если нажата "Предыдущая страница"
                elseif (!empty($first_id) and !empty($first_price))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`>'.$first_price .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_price`='.$first_price.' and `p_id`<'.$first_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
            }
            // Популярное
            elseif ($sort == 3) {
                $order_by = '`p_id` DESC';
            }
            // Акции (скидки)
            elseif ($sort == 4) {
                $order_by = '`p_discount` DESC';

                // Если нажата "Следующая страница"
                if (!empty($last_id) and !empty($last_discount))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_discount`>'.$last_discount .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_discount`='.$last_discount.' and `p_id`>'.$last_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
                // Если нажата "Предыдущая страница"
                elseif (!empty($first_id) and !empty($first_discount))
                {
                    $union_all = '
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_discount`<'.$first_discount .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')
                    UNION ALL
                    (SELECT ' . $cols . ', `pc_cat_id`
                    FROM `products`
                    LEFT JOIN `products_categories`
                    ON `p_id`=`pc_p_id`
                    WHERE `p_discount`='.$first_discount.' and `p_id`<'.$first_id .' and `p_blocked`=0 '. $where_search . $where_category
                        . ' GROUP BY `p_id`'
                        . ' LIMIT '.$limit.')';
                }
            }
            $order_by .= ', `p_id` ASC';
        }

        $table = !empty($union_all) ? '('.$union_all.') as `temp_products`' : '`products`';

        $sql_query = 'SELECT ' . $cols . '
            FROM ' . $table
            . ' LEFT JOIN `products_categories` ON `p_id`=`pc_p_id`'
            . ' LEFT JOIN `courses` ON `p_course_id`=`crs_id`'
            . ' WHERE `p_blocked`=0 ' . $where_category . $where_search
            . ' ORDER BY ' . $order_by
            . ' LIMIT ' . $limit;

        if (!empty($search))
        {
            $sel_products = $this->db->query($sql_query, $search);
        }
        else
        {
            $sel_products = $this->db->query($sql_query);
        }

        // Подробные данных товаров
        if ($sel_products !== false and 0 < $sel_products->num_rows())
        {
            $count_rows = $sel_products->num_rows();
            $elements = $sel_products->result();

            // Если нажата "Предыдущая страница"
            if (!empty($first_id))
            {
                if ($count_rows == $limit)
                {
                    // Извлекаем первый элемент массива
                    array_shift($elements);
                    $count_rows--;
                    $prev_page = true;
                }
                $next_page = true;
            }
            // Если нажата "Следующая страница"
            elseif (!empty($last_id))
            {
                if ($count_rows == $limit)
                {
                    // Извлекаем последний элемент массива
                    array_pop($elements);
                    $count_rows--;
                    $next_page = true;
                }

                $prev_page = true;
            }
            // Первая страница
            elseif ($limit == 9 and $count_rows == $limit and empty($first_id) and empty($last_id))
            {
                // Извлекаем последний элемент массива
                array_pop($elements);
                $count_rows--;
                $next_page = true;
            }

            $i = 0;
            foreach ($elements as $key => $row)
            {
                $cat_id = !empty($row->pc_cat_id) ? $row->pc_cat_id : 0;

                // Данные
                if ($row->p_course_id > 0)
                {
                    if ($row->crs_blocked == 0)
                    {
                        $result['products'][$cat_id][$i] = self::parseProductCourseData($row);
                    }
                }
                else
                {
                    $result['products'][$cat_id][$i] = self::parseProductData($row);
                }

                // Данные пагинации
                // Данные последнего элемента страницы
                if ($next_page === true and $key == ($count_rows-1))
                {
                    // Последний элемент страницы
                    $result['last_id']       = $row->p_id;
                    $result['last_price']    = $row->p_price;
                    $result['last_fc_price'] = $row->p_fitcoin_price;
                    $result['last_discount'] = $row->p_discount;
                }
                // Данные первого элемента страницы
                if ($prev_page === true and $key == 0)
                {
                    // Последний элемент страницы
                    $result['first_id']       = $row->p_id;
                    $result['first_price']    = $row->p_price;
                    $result['first_fc_price'] = $row->p_fitcoin_price;
                    $result['first_discount'] = $row->p_discount;
                }

                $i++;
            }
            unset($row);
        }
        elseif ($sel_products === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

        return $result;
    }

    /**
     * Выборка последних товаров (не заблокированных)
     *
     * @param int $sort Сортировка
     * @param string $search Строка поиска
     * @param int $limit Кол-во товаров на страницу
     * @return array
     */
    public function getLastStoreProducts($sort = null, $search = null, $limit = 5)
    {

        $result    = array('products' => array(), 'first_id' => '', 'first_price' => '', 'first_fc_price' => '',
            'first_discount' => '', 'last_id' => '', 'last_price' => '', 'last_fc_price' => '', 'last_discount' => '');
        $and_where = '';
        $order_by  = '`p_id` DESC';
        $cols      = '`p_id`, `p_course_id`, `p_name`, `p_short_description`, `p_price`, `p_fitcoin_price`, `p_quantity`, 
                     `p_discount`, `p_discount_type`, `p_images`, `p_date_add`, `p_blocked`, `pc_cat_id`,
                     `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`, `crs_blocked`';

        // Если строка поиска не пустая, добавляем в условие поиска
        if (!empty($search))
        {
            $search = '+' . $search . '*';
            $and_where .= ' and MATCH (`p_name`, `p_short_description`, `p_full_description`) AGAINST (? IN BOOLEAN MODE)';
        }
        // Если задана сортировка, добавляем в условие сортировки
        if (!empty($sort))
        {
            // Цена по возрастанию
            if ($sort == 1)
            {
                $order_by = '`p_price` ASC, `p_id` DESC';
                $order_by_course = '`crs_price` ASC, `p_id` DESC';
            }
            // Цена по убыванию
            elseif ($sort == 2)
            {
                $order_by = '`p_price` DESC, `p_id` DESC';
                $order_by_course = '`crs_price` DESC, `p_id` DESC';
            }
            // Популярное
            elseif ($sort == 3)
            {
                $order_by = '`p_id` DESC';
            }
            // Акции (скидки)
            elseif ($sort == 4)
            {
                $order_by = '`p_discount` DESC, `p_id` DESC';
            }

        }

        $table = '`products`';

        $sql_query = 'SELECT ' . $cols . ' 
            FROM ' . $table . '
            LEFT JOIN `products_categories` ON `p_id`=`pc_p_id`
            LEFT JOIN `courses` ON `p_course_id`=`crs_id`
            WHERE `p_blocked`=0 and `crs_blocked`=0 and `pc_cat_id`=? ' . $and_where
            . ' GROUP BY `p_id`'
            . ' ORDER BY ' . $order_by
            . ' LIMIT ?';

        $sel_categories = $this->db->query('SELECT `pc_cat_id` FROM `products_categories` GROUP BY `pc_cat_id`');

        if ($sel_categories !== false and 0 < $sel_categories->num_rows())
        {
            foreach($sel_categories->result() as $category)
            {
                $cat_id = $category->pc_cat_id;

                if (!empty($search))
                {
                    $sel_products = $this->db->query($sql_query, array($cat_id, $search, $limit));
                }
                else
                {
                    $sel_products = $this->db->query($sql_query, array($cat_id, $limit));
                }

                // Подробные данных товаров
                if ($sel_products !== false and 0 < $sel_products->num_rows())
                {
                    $elements = $sel_products->result();

                    $i = 0;
                    foreach ($elements as $key => $row)
                    {
                        // Данные
                        if ($row->p_course_id > 0)
                        {
                            if ($row->crs_blocked == 0)
                            {
                                $result['products'][$cat_id][$i] = self::parseProductCourseData($row);
                            }
                        }
                        else
                        {
                            $result['products'][$cat_id][$i] = self::parseProductData($row);
                        }

                        $i++;
                    }
                    unset($row);
                }
                elseif ($sel_products === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($category);
        }
        elseif ($sel_categories === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных не заблокированного товара
     *
     * @param $product_id
     * @return array
     */
    public function getStoreProduct($product_id)
    {
        $result = array();

        $sel_product = $this->db->query('
            SELECT `p_id`, `p_name`, `p_short_description`, `p_full_description`, `p_price`, `p_fitcoin_price`, 
              `p_quantity`, `p_discount`, `p_discount_type`, `p_images`, `p_union_flag`, `p_date_add`, `p_blocked` 
            FROM `products`
            WHERE `p_id`=? and `p_blocked`=0 and `p_course_id`=0 LIMIT 1', $product_id);

        if ($sel_product !== false and 1 == $sel_product->num_rows())
        {
            $row = $sel_product->row();

            $result['product'] = self::parseProductData($row);

            $result['product']['attached'] = self::getAttachedProducts($product_id);

            unset($row);
        }
        elseif ($sel_product === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка прикрепленных товаров к товару
     *
     * @param $product_id
     * @return array
     */
    public function getAttachedProducts($product_id)
    {
        $result = array();

        $sel_attached_products = $this->db->query('
            SELECT `pg_attached_p_id`, `pg_discount`, `p_name`, `p_price`, `p_fitcoin_price`, `p_images`, 
              `p_short_description`, `p_quantity`
            FROM `products_group`
            LEFT JOIN `products`
              ON `p_id`=`pg_attached_p_id`
            WHERE `pg_p_id`=?' , $product_id);

        if ($sel_attached_products !== false and 0 < $sel_attached_products->num_rows())
        {
            $i = 0;
            foreach ($sel_attached_products->result() as $row)
            {
                $result[$i] = self::parseAttachedProductData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_attached_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ВЫВОДА ДАННЫХ ТОВАРОВ ИНТЕРНЕТ-МАГАЗИНА */

    /* НАЧАЛО БЛОКА ФУНКЦИЙ КОРЗИНЫ */

    /**
     * Выборка всех товаров пользователя, добавленных в корзину
     *
     * @param $user_id
     * @return array
     */
    public function getUserCartProducts($user_id)
    {
        $result = array();

        if (!empty($user_id) and is_numeric($user_id))
        {
            $sel_products = $this->db->query('
            SELECT `c_id`, `c_attached_c_id`, `c_p_id`, `c_p_quantity`, 
              `p_id`, `p_course_id`, `p_name`, `p_price`, `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, 
              `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`
            FROM `cart`
            LEFT JOIN `products` ON `c_p_id`=`p_id`
            LEFT JOIN `courses` ON `p_course_id`=`crs_id`
            WHERE `c_user_id`=?
            ORDER BY `c_date_update` DESC', $user_id);

            if ($sel_products !== false and 0 < $sel_products->num_rows())
            {
                $i = 0;
                foreach ($sel_products->result() as $row)
                {
                    if ($row->c_attached_c_id == 0)
                    {
                        // Данные
                        if ($row->p_course_id > 0)
                        {
                            $result['products'][$i] = self::parseProductCourseData($row);
                        }
                        else
                        {
                            $result['products'][$i] = self::parseProductData($row);
                        }

                        // Прикрепленные товары
                        $result['products'][$i]['attached'] = self::getAttachedCartProducts($row->p_id, $row->c_id);

                        $i++;
                    }
                }
                unset($row);
            }
            elseif ($sel_products === false)
            {
                $params = array('user_id' => $user_id);
                parent::logDbMessages(__METHOD__, $params);
            }
        }

        return $result;
    }

    /**
     * Выборка всех товаров пользователя, добавленных в корзину
     *
     * @param $user_id
     * @return array
     */
    public function getUserCartInStockProducts($user_id)
    {
        $result = array();

        if (is_numeric($user_id))
        {
            $sel_products = $this->db->query('
            SELECT `c_id`, `c_attached_c_id`, `c_p_id`, `c_p_quantity`, 
              `p_id`, `p_course_id`, `p_name`, `p_price`, `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, 
              `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`
            FROM `cart`
            LEFT JOIN `products` ON `c_p_id`=`p_id`
            LEFT JOIN `courses` ON `p_course_id`=`crs_id`
            WHERE `c_user_id`=? and `c_attached_c_id`=0
            ORDER BY `c_date_update` DESC', $user_id);

            if ($sel_products !== false and 0 < $sel_products->num_rows())
            {
                $i = 0;
                foreach ($sel_products->result() as $row)
                {
                    // Данные
                    if ($row->p_course_id > 0)
                    {
                        $result['products'][$i] = self::parseProductCourseData($row);
                    }
                    else
                    {
                        $result['products'][$i] = self::parseProductData($row);
                    }

                    // Прикрепленные товары
                    $result['products'][$i]['attached'] = self::getAttachedCartProducts($row->p_id, $row->c_id);

                    $i++;
                }
                unset($row);

                // Очистка массива от группы товаров "Нет в наличии"
                if (!empty($result['products']))
                {
                    foreach ($result['products'] as $key => $product)
                    {
                        if ($product['quantity'] == 0)
                        {
                            unset($result['products'][$key]);
                        }
                        else
                        {
                            foreach ($product['attached'] as $attached)
                            {
                                if ($attached['quantity'] == 0)
                                {
                                    unset($result['products'][$key]['attached']);
                                    break;
                                }
                            }
                            unset($attached);
                        }
                    }
                    unset($product);
                }
            }
            elseif ($sel_products === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка прикрепленных товаров корзины
     *
     * @param int $product_id ID товара в таблицу "products"
     * @param int $cart_product_id ID товара в корзине пользователя
     * @return array
     */
    protected function getAttachedCartProducts($product_id, $cart_product_id)
    {
        $result = array();

        $sel_attached_products = $this->db->query('
            SELECT `c_id`, `c_attached_c_id`, `c_p_id`, `c_p_quantity`, `p_id`, `p_course_id`, `p_name`, `p_price`, 
              `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, `pg_discount` 
            FROM `cart`
            LEFT JOIN `products` ON `c_p_id`=`p_id`
            LEFT JOIN `products_group` ON `c_p_id`=`pg_attached_p_id` and `pg_p_id`=?
            WHERE `c_attached_c_id`=?', array($product_id, $cart_product_id));

        if ($sel_attached_products !== false and 0 < $sel_attached_products->num_rows())
        {
            $i = 0;
            foreach ($sel_attached_products->result() as $row2)
            {
                // Данные
                $result[$i] = self::parseAttachedProductData($row2);

                $i++;
            }
            unset($row2);
        }
        elseif ($sel_attached_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка ID товаров, добавленных пользователем в корзину
     *
     * @param $user_id
     * @return array
     */
    public function getCartProductsId($user_id)
    {
        $result = array('products_id' => array());

        $sel_products = $this->db->query('SELECT `c_p_id` FROM `cart` WHERE `c_user_id`=? GROUP BY `c_p_id`', $user_id);

        if ($sel_products !== false and 0 < $sel_products->num_rows())
        {
            $i = 0;

            foreach ($sel_products->result() as $row)
            {
                $result['products_id'][$i] = $row->c_p_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение/обновление данных товара в корзине пользователя
     *
     * @param int $product_id ID товара
     * @param int $user_id ID пользователя
     * @param string $date Текущая дата
     * @param int $product_quantity Количество товара
     * @param int $cb_attached Добавлять ли в корзину прикрепленные товары
     * @return bool
     */
    public function setProductToCart($product_id, $user_id, $date, $product_quantity = 1, $cb_attached = 0)
    {
        $result['add']  = false;
        $result['cart'] = 0;
        $cart           = 0;

        // Поиск товара в корзине пользователя
        $sel_product = $this->db->query('
            SELECT `c_id`, `c_p_quantity` FROM `cart` 
            WHERE `c_p_id`=? and `c_user_id`=? and `c_attached_c_id`=0 LIMIT 1', array($product_id, $user_id));

        // Обновление данных
        if ($sel_product !== false and 1 == $sel_product->num_rows())
        {
            $row = $sel_product->row();

            if (!empty($product_quantity))
            {
                $quantity = $row->c_p_quantity + $product_quantity;

                // ID товара в корзине пользователя
                $c_id = $row->c_id;

                $up_data = $this->db->query('
                    UPDATE `cart` SET `c_p_quantity`=?, `c_date_update`=? WHERE `c_p_id`=? and `c_user_id`=? LIMIT 1',
                    array($quantity, $date, $product_id, $user_id));

                if ($up_data !== false and 1 == $this->db->affected_rows())
                {
                    // Обновление данных прикрепленных товаров, если пользователь дал согласие на это
                    if ($cb_attached == 1)
                    {
                        $sel_attached_products = $this->db->query('
                        SELECT `pg_attached_p_id` FROM `products_group` WHERE `pg_p_id`=?', $product_id);

                        // Если есть прикрепленные товары, то обновляем или добавляем данные
                        if ($sel_attached_products !== false and 0 < $sel_attached_products->num_rows())
                        {
                            foreach ($sel_attached_products->result() as $row)
                            {
                                $sel_attached_cart = $this->db->query('
                                SELECT `c_p_id`, `c_p_quantity` FROM `cart` WHERE `c_attached_c_id`=? and `c_p_id`=? LIMIT 1',
                                    array($c_id, $row->pg_attached_p_id));

                                // Обновляем данные
                                if ($sel_attached_cart !== false and 1 == $sel_attached_cart->num_rows())
                                {
                                    $row2 = $sel_attached_cart->row();

                                    $quantity = $row2->c_p_quantity + $product_quantity;

                                    $up_data = $this->db->query('
                                      UPDATE `cart` SET `c_p_quantity`=?, `c_date_update`=? WHERE `c_attached_c_id`=? and `c_p_id`=? LIMIT 1',
                                        array($quantity, $date, $c_id, $row2->c_p_id));
                                    if ($up_data === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }
                                }
                                elseif ($sel_attached_cart === false)
                                {
                                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                                }
                                // Добавляем в корзину
                                else {
                                    $in_data = $this->db->query('
                                        INSERT INTO `cart` (`c_user_id`, `c_p_id`, `c_attached_c_id`, `c_p_quantity`, `c_date_update`)
                                        VALUES (?, ?, ?, ?, ?)', array($user_id, $row->pg_attached_p_id, $c_id, $product_quantity, $date));
                                    if ($in_data !== false and 1 == $this->db->affected_rows())
                                    {
                                        $cart++;
                                    }
                                    elseif ($in_data === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }
                                }
                            }
                            unset($row);
                        }
                        elseif ($sel_attached_products === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }

                    $result['add'] = true;
                }
                elseif ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }
        elseif ($sel_product === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        // Добавление новых данных
        else {
            $in_data = $this->db->query('
                INSERT INTO `cart` (`c_user_id`, `c_p_id`, `c_p_quantity`, `c_date_update`)
                VALUES (?, ?, ?, ?)', array($user_id, $product_id, $product_quantity, $date));

            if ($in_data !== false and 1 == $this->db->affected_rows())
            {
                $result['add'] = true;
                $cart++;
            }

            // Добавляем в корзину прикрепленные товары, если пользователь дал согласие на это
            if ($cb_attached == 1) {
                // ID товара в корзине пользователя, к которому будет прикреплен товар
                $c_id = $this->db->insert_id();

                // Добавление прикрепленных товаров (добавляемого товара) в корзину
                $sel_attached_products = $this->db->query('SELECT `pg_attached_p_id` FROM `products_group` WHERE `pg_p_id`=?', $product_id);

                if ($sel_attached_products !== false and 0 < $sel_attached_products->num_rows())
                {
                    foreach ($sel_attached_products->result() as $row)
                    {
                        $in_data2 = $this->db->query('
                            INSERT INTO `cart` (`c_user_id`, `c_p_id`, `c_attached_c_id`, `c_p_quantity`, `c_date_update`)
                            VALUES (?, ?, ?, ?, ?)', array($user_id, $row->pg_attached_p_id, $c_id, $product_quantity, $date));
                        if ($in_data2 !== false and 1 == $this->db->affected_rows())
                        {
                            $cart++;
                        }
                        elseif ($in_data2 === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    unset($row);
                }
                elseif ($sel_attached_products === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_attached_products->free_result();
            }
        }

        $result['cart'] = $cart;

        return $result;
    }

    /**
     * Id курса в таблице товаров
     *
     * @param int $course_id ID товара
     * @return bool
     */
    public function getCourseProductId($course_id)
    {
        $result = false;

        // Определение номера курса в таблице товаров
        $sel_c_p = $this->db->query('SELECT `p_id` FROM `products` WHERE `p_course_id`=? LIMIT 1', $course_id);
        if($sel_c_p !== false and 1 == $sel_c_p->num_rows())
        {
            $row = $sel_c_p->row();
            $result = $row->p_id;
            unset($row);
        }
        elseif($sel_c_p === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление данных товара в корзине пользователя
     *
     * @param int $product_id ID товара пользователя в корзине
     * @param int $user_id
     * @param string $date
     * @param int $product_quantity
     * @return bool
     */
    public function updateCart($product_id, $user_id, $date, $product_quantity = 1)
    {
        $sel_product = $this->db->query('
            SELECT `c_id`, `c_attached_c_id`, `c_p_quantity`, `p_quantity` 
            FROM `cart` 
            LEFT JOIN `products`
              ON `p_id`=`c_p_id`
            WHERE `c_id`=? and `c_user_id`=? 
            GROUP BY `c_p_id`
            LIMIT 1', array($product_id, $user_id));

        if ($sel_product !== false and 1 == $sel_product->num_rows())
        {
            $row = $sel_product->row();

            // Если товар прикреплен к другому товару, то кол-во выбранного товара не должно превышать кол-во основного
            if ($row->c_attached_c_id != 0)
            {
                $sel_base_product = $this->db->query('
                    SELECT `c_p_quantity` FROM `cart` WHERE `c_id`=? LIMIT 1', $row->c_attached_c_id);

                if ($sel_base_product !== false and 1 == $sel_base_product->num_rows())
                {
                    $base = $sel_base_product->row();

                    $product_quantity = $product_quantity <= $base->c_p_quantity ? $product_quantity : $base->c_p_quantity;

                    $up_data = $this->db->query('
                        UPDATE `cart` SET `c_p_quantity`=?, `c_date_update`=? WHERE `c_id`=? and `c_user_id`=? LIMIT 1',
                        array($product_quantity, $date, $product_id, $user_id));

                    if ($up_data !== false and 1 == $this->db->affected_rows())
                    {
                        return $product_quantity;
                    }
                    elseif ($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                        return false;
                    }
                    else
                    {
                        return false;
                    }
                }
                elseif ($sel_base_product === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    return false;
                }
                else
                {
                    return false;
                }
            }
            // Обновить данные если текущее значение кол-ва не совпадает с данными в БД
            elseif ($product_quantity != $row->c_p_quantity)
            {
                $product_quantity = $product_quantity <= $row->p_quantity ? $product_quantity : $row->p_quantity;

                $up_data = $this->db->query('
                UPDATE `cart` SET `c_p_quantity`=?, `c_date_update`=? WHERE `c_id`=? and `c_user_id`=? LIMIT 1',
                    array($product_quantity, $date, $product_id, $user_id));
                if ($up_data !== false and 1 == $this->db->affected_rows())
                {
                    return $product_quantity;
                }
                elseif ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    return false;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        elseif ($sel_product === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Удаление товара из корзины пользователя
     *
     * @param int $product_id ID товара пользователя в корзине
     * @param int $user_id
     * @return bool
     */
    public function deleteCartProduct($product_id, $user_id)
    {
        // Проверка на прикрепленные товары. Если есть, так же удалить
        $sel_attached = $this->db->query('
          SELECT `c_id` FROM `cart` WHERE `c_attached_c_id`=? and `c_user_id`=?', array($product_id, $user_id));

        if ($sel_attached !== false and 0 < $sel_attached->num_rows())
        {
            // Удаление прикрепленных товаров
            self::detachCartProducts($user_id, $product_id);
        }
        elseif ($sel_attached === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $up_data = $this->db->query('
            DELETE FROM `cart` WHERE `c_id`=? and `c_user_id`=? LIMIT 1', array($product_id, $user_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Удаление прикрепленных товаров из карзины пользователя
     *
     * @param int $user_id ID пользователя
     * @param int $attached_id ID прикрепленных товаров
     * @return bool
     */
    public function detachCartProducts($user_id, $attached_id)
    {
        $up_data = $this->db->query('DELETE FROM `cart` WHERE `c_user_id`=? and `c_attached_c_id`=?', array($user_id, $attached_id));

        if ($up_data !== false and 0 < $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Кол-во товаров в корзине пользователя
     *
     * @param $user_id
     * @return int
     */
    public function getCartCountProducts($user_id)
    {
        $result = 0;

        $sel_products = $this->db->query('SELECT COUNT(`c_id`) as `count_products` FROM `cart` WHERE `c_user_id`=?', $user_id);

        if ($sel_products !== false and 1 == $sel_products->num_rows())
        {
            $row = $sel_products->row();

            $result = $row->count_products;
        }
        elseif ($sel_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение товаров корзины неавторизованного пользователя
     *
     * @param array $products Товары сохраненные в корзине сессии пользователя
     * @return array
     */
    public function getSessionCartProducts($products)
    {
        $result = array();

        if (is_array($products) and !empty($products))
        {
            $i = 0;
            foreach ($products as $key => $product)
            {
                $sel_product = $this->db->query('
                    SELECT `p_id`, `p_course_id`, `p_name`, `p_price`, `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, 
                      `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`
                    FROM `products`
                    LEFT JOIN `courses` ON `p_course_id`=`crs_id`
                    WHERE `p_id`=? LIMIT 1', $product['id']);

                if ($sel_product !== false and 1 == $sel_product->num_rows())
                {
                    $row = $sel_product->row();

                    // Данные
                    if ($row->p_course_id > 0)
                    {
                        $result['products'][$i] = self::parseProductCourseData($row);
                    }
                    else
                    {
                        $result['products'][$i] = self::parseProductData($row);
                    }

                    $result['products'][$i]['c_id'] = $key;
                    $result['products'][$i]['cart_quantity'] = $product['quantity'];

                    // Прикрепленные товары
                    $result['products'][$i]['attached'] = self::getAttachedSessionCartProducts($key, $product['attached']);

                    $i++;
                }
            }
            unset($product);
        }

        return $result;
    }

    /**
     * Прикрепленные товары корзины сессии пользователя
     *
     * @param int $product_id
     * @param array $attached_products
     * @return array
     */
    public function getAttachedSessionCartProducts($product_id, $attached_products)
    {
        $result = array();

        if (is_array($attached_products) and !empty($attached_products))
        {
            $i = 0;

            foreach($attached_products as $key => $product)
            {
                $sel_product = $this->db->query('
                    SELECT `p_id`, `p_course_id`, `p_name`, `p_price`, `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, 
                      `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`
                    FROM `products`
                    LEFT JOIN `courses` ON `p_course_id`=`crs_id`
                    WHERE `p_id`=? LIMIT 1', $product['id']);

                if ($sel_product !== false and 1 == $sel_product->num_rows())
                {
                    $row = $sel_product->row();

                    // Данные
                    if ($row->p_course_id > 0)
                    {
                        $result[$i] = self::parseProductCourseData($row);
                    }
                    else
                    {
                        $result[$i] = self::parseProductData($row);
                    }

                    $result[$i]['c_id']          = $key;
                    $result[$i]['c_ap_id']       = $product_id;
                    $result[$i]['cart_quantity'] = $product['quantity'];

                    $i++;
                }
            }
            unset($product);
        }

        return $result;
    }

    /**
     * Сохранение товаров корзины сессии в БД авторизованного пользователя
     *
     * @param int $user_id
     * @param array $products
     * @param string $date
     * @return bool
     */
    public function setSessionCartToDB($user_id, $products, $date)
    {
        $result = false;

        // Если данные пользователя корректны и массив товаров корзины не пуст
        if(is_array($products) and !empty($products) and is_numeric($user_id))
        {
            foreach ($products as $product)
            {
                $product_id       = (is_numeric($product['id'])) ? $product['id'] : null;
                $product_quantity = (is_numeric($product['quantity'])) ? $product['quantity'] : 1;

                // Если корректны данные товара, добавляем в БД
                if (!empty($product_id))
                {
                    $ins_data = $this->db->query('
                        INSERT INTO `cart` (`c_user_id`, `c_p_id`, `c_p_quantity`, `c_date_update`)
                        VALUES (?, ?, ?, ?)', array($user_id, $product_id, $product_quantity, $date));

                    if ($ins_data !== false and 1 == $this->db->affected_rows())
                    {
                        // Если массив прикрепленных товаров не пуст, проверяем и добавляем в БД
                        if(is_array($product['attached']) and !empty($product['attached']))
                        {
                            // ID товарв в коризне БД пользователя
                            $c_p_id = $this->db->insert_id();

                            foreach ($product['attached'] as $attached)
                            {
                                $attached_id       = (is_numeric($attached['id'])) ? $attached['id'] : null;
                                $attached_quantity = (is_numeric($attached['quantity'])) ? $attached['quantity'] : 1;

                                // Если корректны данные товара, добавляем в БД
                                if(!empty($attached_id))
                                {
                                    $ins_attached = $this->db->query('
                                        INSERT INTO `cart` (`c_attached_c_id`, `c_user_id`, `c_p_id`, `c_p_quantity`, `c_date_update`)
                                        VALUES (?, ?, ?, ?, ?)', array($c_p_id, $user_id, $attached_id, $attached_quantity, $date));

                                    if($ins_attached === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }

                                }
                            }
                            unset($attached);
                        }

                        $result = true;
                    }
                    elseif($ins_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
            }
            unset($product);
        }

        return $result;
    }

    /**
     * Получение товаров корзины неавторизованного пользователя
     *
     * @param array $products Товары сохраненные в корзине сессии пользователя
     * @return array
     */
    public function getSessionCartInStockProducts($products)
    {
        $result = array();

        if (is_array($products) and !empty($products))
        {
            $i = 0;
            foreach ($products as $key => $product)
            {
                $sel_product = $this->db->query('
                    SELECT `p_id`, `p_course_id`, `p_name`, `p_price`, `p_fitcoin_price`, `p_discount`, `p_images`, `p_quantity`, 
                      `crs_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_image`
                    FROM `products`
                    LEFT JOIN `courses` ON `p_course_id`=`crs_id`
                    WHERE `p_id`=? LIMIT 1', $product['id']);

                if ($sel_product !== false and 1 == $sel_product->num_rows())
                {
                    $row = $sel_product->row();

                    // Данные
                    if ($row->p_course_id > 0)
                    {
                        $result['products'][$i] = self::parseProductCourseData($row);
                    }
                    else
                    {
                        $result['products'][$i] = self::parseProductData($row);
                    }

                    $result['products'][$i]['c_id'] = $key;
                    $result['products'][$i]['cart_quantity'] = $product['quantity'];

                    // Прикрепленные товары
                    $result['products'][$i]['attached'] = self::getAttachedSessionCartProducts($key, $product['attached']);

                    $i++;
                }
            }
            unset($product);

            // Очистка массива от группы товаров "Нет в наличии"
            if (!empty($result['products']))
            {
                foreach ($result['products'] as $key => $product)
                {
                    if ($product['quantity'] == 0)
                    {
                        unset($result['products'][$key]);
                    }
                    else
                    {
                        foreach ($product['attached'] as $attached)
                        {
                            if ($attached['quantity'] == 0)
                            {
                                unset($result['products'][$key]['attached']);
                                break;
                            }
                        }
                        unset($attached);
                    }
                }
                unset($product);
            }
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ КОРЗИНЫ */

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ЗАКАЗА */

    /**
     * Данные адресов пользователя
     *
     * @param $user_id
     * @return array
     */
    public function getUserOrderAddresses($user_id)
    {
        $result = array();

        if(is_numeric($user_id))
        {
            $sel_addresses = $this->db->query('
                SELECT `oud_id`, `oud_country`, `oud_city`, `oud_street`, `oud_building`, `oud_house`, `oud_postcode` 
                FROM `orders_users_data`
                WHERE `oud_u_id`=?', $user_id);

            if ($sel_addresses !== false and 0 < $sel_addresses->num_rows())
            {
                $i = 0;

                foreach ($sel_addresses->result() as $row)
                {
                    $result['addresses'][$i]['id']       = $row->oud_id;
                    $result['addresses'][$i]['country']  = $row->oud_country;
                    $result['addresses'][$i]['city']     = $row->oud_city;
                    $result['addresses'][$i]['street']   = $row->oud_street;
                    $result['addresses'][$i]['building'] = $row->oud_building;
                    $result['addresses'][$i]['house']    = $row->oud_house;
                    $result['addresses'][$i]['postcode'] = $row->oud_postcode;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_addresses === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Создание заказа, сохранение адреса пользователя, сохранение товаров заказа
     *
     * @param int $user_id
     * @param string|int $prev_address
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $code
     * @param string $phone
     * @param string $country
     * @param string $city
     * @param string $street
     * @param string $building
     * @param string $house
     * @param int|string $postcode
     * @param string $delivery
     * @param array $products
     * @param string $date
     * @return bool
     */
    public function setOrder($user_id, $prev_address = '', $name, $surname, $email, $code, $phone, $country = '', $city = '',
                             $street = '', $building = '', $house = '', $postcode = '', $delivery, $products, $date)
    {
        $result     = false;
        $address_id = !empty($prev_address) ? $prev_address : 0;
        $order_id   = null;

        // Сохранение нового адреса пользователя
        if (empty($prev_address) and !empty($country) and !empty($city) and !empty($street))
        {
            $in_data = $this->db->query('
                INSERT INTO `orders_users_data` (`oud_u_id`, `oud_country`, `oud_city`, `oud_street`, `oud_building`, 
                  `oud_house`, `oud_postcode`, `oud_date_add`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                    array($user_id, $country, $city, $street, $building, $house, $postcode, $date));

            if ($in_data !== false and 1 == $this->db->affected_rows())
            {
                $address_id = $this->db->insert_id();
            }
            elseif ($in_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        // Создание заказа
        $in_data = $this->db->query('
            INSERT INTO `orders` (`o_u_id`, `o_user_name`, `o_user_surname`, `o_user_email`, `o_user_country_code`, `o_user_phone`, 
              `o_oud_id`, `o_delivery`, `o_date_add`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($user_id, $name, $surname, $email, $code, $phone, $address_id, $delivery, $date));

        if ($in_data !== false and 1 == $this->db->affected_rows())
        {
            $order_id = $this->db->insert_id();
            $result['order_id']     = $order_id;
            $result['total_amount'] = 0;

            // Сохранение товаров заказа
            if (!empty($order_id) and !empty($products['products']))
            {
                foreach ($products['products'] as $product)
                {
                    $price    = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];
                    $fc_price = !empty($product['discount_fc_price']) ? $product['discount_fc_price'] : $product['fc_price'];
                    $pcu_id   = '';

                    // Добавление промокода как использованный
                    if(!empty($product['promo_id']) and !empty($product['promo_code']))
                    {
                        $ins_data = $this->db->query('
                            INSERT INTO `promocodes_used` (`pcu_pc_id`, `pcu_code`, `pcu_o_id`, `pcu_p_id`, `pcu_u_id`, `pcu_date`)
                            VALUES (?, ?, ?, ?, ?, ?)',
                                array($product['promo_id'], $product['promo_code'], $order_id, $product['id'], $user_id, $date));
                        if($ins_data !== false and 1 == $this->db->affected_rows())
                        {
                            $pcu_id = $this->db->insert_id();
                        }
                        elseif ($ins_data === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }

                    // Сохранение товара в таблице Заказов
                    $in_data = $this->db->query('
                        INSERT INTO `orders_users_cart` (`ouc_o_id`, `ouc_u_id`, `ouc_p_id`, `ouc_p_quantity`, 
                            `ouc_p_price`, `ouc_p_fitcoin_price`, `ouc_promocode_id`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)',
                            array($order_id, $user_id, $product['id'], $product['cart_quantity'], $price, $fc_price, $pcu_id));

                    if ($in_data !== false and 1 == $this->db->affected_rows())
                    {
                        $result['total_amount'] += ($product['cart_quantity'] * $price);
                        $quantity = (($product['quantity'] - $product['cart_quantity']) > 0) ? ($product['quantity'] - $product['cart_quantity']) : 0;

                        // Изменение общего кол-ва товара в ИМ
                        $up_data = $this->db->query('
                            UPDATE `products` SET `p_quantity`= ? WHERE `p_id`=? LIMIT 1',
                                array($quantity, $product['id']));
                        if ($up_data === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }

                        // Удаление товаров из корзины пользователя
                        if (!empty($product['c_id']))
                        {
                            $up_data = $this->db->query('DELETE FROM `cart` WHERE `c_id`=? LIMIT 1', $product['c_id']);
                            if ($up_data === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }

                        // Добавление прикрепленных товаров
                        if (!empty($product['attached']))
                        {
                            $product_id = $this->db->insert_id();

                            foreach ($product['attached'] as $attached)
                            {
                                $price = !empty($attached['discount_price']) ? $attached['discount_price'] : $attached['price'];
                                $fc_price = !empty($attached['discount_fc_price']) ? $attached['discount_fc_price'] : $attached['fc_price'];

                                $in_data2 = $this->db->query('
                                    INSERT INTO `orders_users_cart` (`ouc_o_id`, `ouc_u_id`, `ouc_p_id`, `ouc_attached_p_id`, 
                                        `ouc_p_quantity`, `ouc_p_price`, `ouc_p_fitcoin_price`) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)',
                                        array($order_id, $user_id, $attached['id'], $product_id, $attached['cart_quantity'], $price, $fc_price));

                                if ($in_data2 !== false and 1 == $this->db->affected_rows())
                                {
                                    $result['total_amount'] += ($attached['cart_quantity'] * $price);
                                    $quantity = (($attached['quantity'] - $attached['cart_quantity']) > 0) ? ($attached['quantity'] - $attached['cart_quantity']) : 0;

                                    // Изменение общего кол-ва товара в ИМ
                                    $up_data2 = $this->db->query('
                                        UPDATE `products` SET `p_quantity`= ? WHERE `p_id`=? LIMIT 1',
                                            array($quantity, $attached['id']));
                                    if ($up_data2 === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }

                                    // Удаление товаров из корзины пользователя
                                    $up_data2 = $this->db->query('DELETE FROM `cart` WHERE `c_id`=? LIMIT 1', $attached['c_id']);
                                    if ($up_data2 === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }
                                }
                                elseif ($in_data2 === false)
                                {
                                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                                }

                            }
                            unset($attached);
                        }
                    }
                    elseif ($in_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($product);
            }
        }
        elseif ($in_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка заказов пользователей
     *
     * @return array
     */
    public function getOrders()
    {
        $result = array();

        $sel_orders = $this->db->query('
            SELECT `o_id`, `o_u_id`, `o_user_name`, `o_user_surname`, `o_user_email`, `o_user_country_code`, `o_user_phone`,            
                `o_delivery`, `o_payment`, `o_payment_status`, `o_status`, `o_date_add`,
                `oud_country`, `oud_city`, `oud_street`, `oud_building`, `oud_house`, `oud_postcode`
            FROM `orders`
            LEFT JOIN `orders_users_data` ON `oud_id`=`o_oud_id`
            ORDER BY `o_id` ASC');

        if ($sel_orders !== false and 0 < $sel_orders->num_rows())
        {
            $i = 0;
            foreach($sel_orders->result() as $row)
            {
                // Данные заказа
                $order = self::parseOrderData($row);

                // Данные оплаты заказа
                $waiting_status   = false;
                $waiting_payments = self::getOrderWaitingPayments($row->o_id);
                if(!empty($waiting_payments))
                {
                    $waiting_status = true;
                }
                $order['waiting_status'] = $waiting_status;

                // Если есть платежи, требующие обработки, помещаем данные в начало массива, иначе в конец
                if($waiting_status === true)
                {
                    array_unshift($result['orders'], $order);
                }
                else
                {
                    $result['orders'][$i] = $order;
                }

                $i++;
            }
            unset($row);
        }
        elseif ($sel_orders === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение данных о заказе
     *
     * @param $order_id
     * @return array
     */
    public function getOrder($order_id)
    {
        $result = array();

        $sel_order = $this->db->query('
            SELECT `o_id`, `o_u_id`, `o_user_name`, `o_user_surname`, `o_user_email`, `o_user_country_code`, `o_user_phone`,            
                `o_delivery`, `o_payment`, `o_payment_status`, `o_status`, `o_date_add`,
                `oud_country`, `oud_city`, `oud_street`, `oud_building`, `oud_house`, `oud_postcode`
            FROM `orders`
            LEFT JOIN `orders_users_data` ON `oud_id`=`o_oud_id`
            WHERE `o_id`=? LIMIT 1', $order_id);

        if ($sel_order !== false and 1 == $sel_order->num_rows())
        {
            $row = $sel_order->row();

            // Данные заказа
            $result['order'] = self::parseOrderData($row);

            unset($row);

            // Даннаые оплаты заказа
            $result['order']['payments'] = self::getOrderPayments($order_id);

            // Выборка товаров заказа
            $sel_products = $this->db->query('
                SELECT `ouc_id`, `ouc_o_id`, `ouc_u_id`, `ouc_p_id`, `ouc_attached_p_id`, `ouc_p_quantity`, `ouc_p_price`, 
                    `ouc_p_fitcoin_price`,
                    `p_id`, `p_course_id`, `p_name`, `p_short_description`, `p_full_description`, `p_images`, `p_fitcoin_price`,
                    `p_price`, `p_quantity`, `p_discount`, `p_discount_type`, `p_union_flag`, `p_blocked`, 
                    `crs_name`, `crs_image`
                FROM `orders_users_cart`
                LEFT JOIN `products` ON `p_id`=`ouc_p_id`
                LEFT JOIN `courses` ON `crs_id`=`p_course_id`
                WHERE `ouc_o_id`=?', $order_id);
            if ($sel_products !== false and 0 < $sel_products->num_rows())
            {
                $i = 0;

                foreach ($sel_products->result() as $row)
                {
                    if ($row->ouc_attached_p_id == 0)
                    {
                        // Данные
                        $result['order']['products'][$i] = self::parseOrderProductData($row);

                        $i++;
                    }
                }
                unset($row);
            }
            elseif ($sel_products === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_order === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка заказа пользователя
     *
     * @param $user_id
     * @param $order_id
     * @return mixed
     */
    public function getUserOrder($user_id, $order_id)
    {
        $result['order']['id'] = '';

        $sel_order = $this->db->query('
            SELECT `o_id`, `o_u_id`, `o_user_name`, `o_user_surname`, `o_user_email`, `o_user_country_code`, `o_user_phone`,            
                `o_delivery`, `o_payment`, `o_payment_status`, `o_status`, `o_date_add`,
                `oud_country`, `oud_city`, `oud_street`, `oud_building`, `oud_house`, `oud_postcode`
            FROM `orders`
            LEFT JOIN `orders_users_data` ON `oud_id`=`o_oud_id` 
            WHERE `o_u_id`=? and `o_id`=? LIMIT 1',
                array($user_id, $order_id));

        if ($sel_order !== false and 1 == $sel_order->num_rows())
        {
            $row = $sel_order->row();

            // Данные заказа
            $result['order'] = self::parseOrderData($row);

            unset($row);

            // Даннаые оплаты заказа

            // Даннаые оплаты заказа
            $result['order']['payments'] = self::getOrderPayments($order_id);

            // Выборка товаров заказа
            $sel_products = $this->db->query('
                SELECT `ouc_id`, `ouc_o_id`, `ouc_u_id`, `ouc_p_id`, `ouc_attached_p_id`, `ouc_p_quantity`, `ouc_p_price`, 
                    `ouc_p_fitcoin_price`,
                    `p_course_id`, `p_name`, `p_short_description`, `p_full_description`, `p_images`, `p_fitcoin_price`,
                    `p_price`, `p_quantity`, `p_discount`, `p_discount_type`, `p_union_flag`, `p_blocked`, 
                    `crs_name`, `crs_image`
                FROM `orders_users_cart`
                LEFT JOIN `products` ON `p_id`=`ouc_p_id`
                LEFT JOIN `courses` ON `crs_id`=`p_course_id`
                WHERE `ouc_o_id`=? and `ouc_u_id`=?', array($order_id, $user_id));

            if ($sel_products !== false and 0 < $sel_products->num_rows()) {
                $i = 0;

                foreach ($sel_products->result() as $row)
                {
                    if ($row->ouc_attached_p_id == 0)
                    {
                        // Данные
                        $result['order']['products'][$i] = self::parseOrderProductData($row);

                        $i++;
                    }
                }
                unset($row);
            }
            elseif ($sel_products === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_order === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка заказов пользователей
     *
     * @param $user_id
     * @return array
     */
    public function getUserOrders($user_id)
    {
        $result = array();

        $sel_orders = $this->db->query('
            SELECT `o_id`, `o_u_id`, `o_user_name`, `o_user_surname`, `o_user_email`, `o_user_country_code`, `o_user_phone`,            
                `o_delivery`, `o_payment`, `o_payment_status`, `o_status`, `o_date_add`,
                `oud_country`, `oud_city`, `oud_street`, `oud_building`, `oud_house`, `oud_postcode`
            FROM `orders`
            LEFT JOIN `orders_users_data` ON `oud_id`=`o_oud_id`
            WHERE `o_u_id`=?
            ORDER BY `o_id` DESC', $user_id);

        if ($sel_orders !== false and 0 < $sel_orders->num_rows())
        {
            $i = 0;

            foreach($sel_orders->result() as $row)
            {
                $result['orders'][$i] = self::parseOrderData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_orders === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление статуса заказа
     *
     * @param int $order_id
     * @param string $payment_id
     * @param int $status
     * @return bool
     */
    public function updateOrderStatus($order_id, $payment_id, $status)
    {
        if (empty($order_id) and !empty($payment_id))
        {
            $sel_order_id = $this->db->query('SELECT `op_o_id` FROM `orders_payment` WHERE `op_payment_id`=? LIMIT 1', $payment_id);

            if ($sel_order_id !== false and 1 == $sel_order_id->num_rows())
            {
                $row = $sel_order_id->row();
                $order_id = $row->op_o_id;
                unset($row);
            }
            elseif($sel_order_id === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        if (!empty($order_id))
        {
            $up_data = $this->db->query('UPDATE `orders` SET `o_status`=? WHERE `o_id`=? LIMIT 1', array($status, $order_id));

            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                return true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
                return false;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Выборка курсов заказа пользователя
     *
     * @param string $payment_id
     * @param int $order_id
     * @return mixed
     */
    public function getOrderCourses($payment_id = '', $order_id = '')
    {
        $result['courses'] = array();
        $result['user_id'] = '';

        // Выборка номера заказа и ID пользователя по номеру платежа
        if (!empty($payment_id) and empty($order_id))
        {
            $sel_order = $this->db->query('SELECT `op_o_id`, `o_u_id` FROM `orders_payment` 
                LEFT JOIN `orders` ON `o_id`=`op_o_id`
                WHERE `op_payment_id`=? LIMIT 1', $payment_id);

            if($sel_order !== false and 1 == $sel_order->num_rows())
            {
                $row = $sel_order->row();
                $order_id = $row->op_o_id;
                $user_id = $row->o_u_id;
                unset($row);
            }
            elseif($sel_order === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif (!empty($order_id))
        {
            $sel_order = $this->db->query('SELECT `o_u_id` FROM `orders` WHERE `o_id`=? LIMIT 1', $order_id);

            if($sel_order !== false and 1 == $sel_order->num_rows())
            {
                $row = $sel_order->row();
                $user_id = $row->o_u_id;
                unset($row);
            }
            elseif($sel_order === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        if (!empty($order_id) and !empty($user_id))
        {
            $result['user_id'] = $user_id;

            // Выборка курсов заказа
            $sel_courses = $this->db->query('
                SELECT `orders_users_cart`.`ouc_p_id`, `products`.`p_course_id`, `crs_category`, `crs_count_weeks`, 
                  `crs_count_days` 
                FROM `orders_users_cart` 
                LEFT JOIN `products` ON `p_id`=`ouc_p_id`
                LEFT JOIN `courses` ON `p_course_id`=`crs_id`
                WHERE `ouc_o_id`=? and `ouc_u_id`=? and `p_course_id`>0', array($order_id, $user_id));

            if($sel_courses !== false and 0 < $sel_courses->num_rows())
            {
                $i = 0;
                foreach($sel_courses->result() as $row)
                {
                    $result['courses'][$i]['id']          = $row->p_course_id;
                    $result['courses'][$i]['category']    = $row->crs_category;
                    $result['courses'][$i]['count_weeks'] = $row->crs_count_weeks;
                    $result['courses'][$i]['count_days']  = $row->crs_days;

                    $i++;
                }
                unset($row);
            }
            elseif($sel_courses === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка стоимости курса заказа пользователя
     *
     * @param int $order_id
     * @param int $course_id
     * @param int $user_id
     * @return int
     */
    public function getOrderCoursePrice($order_id, $course_id, $user_id)
    {
        $result = null;

        if (is_numeric($order_id) and is_numeric($course_id) and is_numeric($user_id))
        {
            // Выборка курса заказа
            $sel_course = $this->db->query('
                SELECT `orders_users_cart`.`ouc_p_id`, `orders_users_cart`.`ouc_p_price`, `products`.`p_course_id` 
                FROM `orders_users_cart` 
                LEFT JOIN `products` ON `p_id`=`ouc_p_id`
                WHERE `ouc_o_id`=? and `ouc_u_id`=? and `products`.`p_course_id`=? LIMIT 1', array($order_id, $user_id, $course_id));

            if($sel_course !== false and 1 == $sel_course->num_rows())
            {
                $row = $sel_course->row();

                $result = $row->ouc_p_price;
            }
            elseif($sel_course === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Количество заказов, требующих подтверждения
     *
     * @return int
     */
    public function getAdminCountWaitingOrders()
    {
        $result = 0;

        $sel_orders = $this->db->query('SELECT COUNT(`o_id`) as `count_orders` FROM `orders` 
            LEFT JOIN `orders_payment` ON `op_o_id`=`o_id`
            WHERE `op_status`="waiting_for_capture"
            GROUP BY `o_id`');

        if($sel_orders !== false and 0 < $sel_orders->num_rows())
        {
            $row = $sel_orders->row();
            $result = $row->count_orders;
        }
        elseif($sel_orders === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ЗАКАЗА */

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ОПЛАТЫ */

    /**
     * Получение данных о платежах заказа из БД
     *
     * @param $order_id
     * @return array
     */
    public function getOrderPayments($order_id)
    {
        $result = array();

        $sel_payments = $this->db->query('
            SELECT `op_id`, `op_o_id`, `op_number`, `op_payment_id`, `op_status`, `op_paid`, `op_created_at`, `op_captured_at`
                `op_expires_at`, `op_amount`, `op_currency`, `op_payment_method_saved`, `op_payment_method_id`, `op_following_date`
            FROM `orders_payment`
            WHERE `op_o_id`=?', $order_id);
        if ($sel_payments !== false and 0 < $sel_payments->num_rows())
        {
            $i = 0;
            foreach($sel_payments->result() as $row)
            {
                $confirm_url = '';

                if ($row->op_status != 'succeeded' and $row->op_status != 'canceled')
                {
                    $payment = self::getPaymentInfo($row->op_payment_id);

                    /*if (!empty($payment->_status) and $row->op_status != $payment->_status)
                    {
                        $created_at   = !empty($payment->_createdAt->_date) ? $payment->_createdAt->_date . $payment->_createdAt->_timezone : $row->op_created_at;
                        $expires_at   = !empty($payment->_expiresAt->_date) ? $payment->_expiresAt->_date . $payment->_expiresAt->_timezone : $row->op_expires_at;
                        $captured_at  = !empty($payment->_capturedAt->_date) ? $payment->_capturedAt->_date : '';
                        $method_id    = $payment->_paymentMethod->_id;
                        $method_saved = $payment->_paymentMethod->_saved;

                        $row->op_status = $payment->_status;
                        $row->op_paid = $payment->_paid;
                        $row->op_payment_method_id = $method_id;
                        $row->op_payment_method_saved = $method_saved;

                        self::updatePaymentStatus($order_id, $payment->_id, $payment->_status, $payment->_paid, $created_at,
                            $expires_at, $captured_at, $method_id, $method_saved);
                    }*/

                    if ($payment->_status == 'pending')
                    {
                        $confirm_url = !empty($payment->_confirmation->_confirmationUrl) ? $payment->_confirmation->_confirmationUrl : '';
                    }
                }

                // Данные платежа
                $result[$i] = self::parsePaymentData($row);
                $result[$i]['confirm_url'] = $confirm_url;

                // Данные возвратов
                $refunds = self::getPaymentRefunds($row->op_payment_id);
                $result[$i] = array_merge($result[$i], $refunds);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_payments === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение данных о платежах заказа из БД (со статусом waiting_for_capture)
     *
     * @param $order_id
     * @return array
     */
    public function getOrderWaitingPayments($order_id)
    {
        $result = array();

        $sel_payments = $this->db->query('
            SELECT `op_id`, `op_o_id`, `op_number`, `op_payment_id`, `op_status`, `op_paid`, `op_created_at`, `op_captured_at`
                `op_expires_at`, `op_amount`, `op_currency`, `op_payment_method_saved`, `op_payment_method_id`, `op_following_date`
            FROM `orders_payment`
            WHERE `op_o_id`=? and `op_status`="waiting_for_capture"', $order_id);
        if ($sel_payments !== false and 0 < $sel_payments->num_rows())
        {
            $i = 0;
            foreach($sel_payments->result() as $row)
            {
                // Данные платежа
                $result[$i] = self::parsePaymentData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_payments === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение данных о платеже
     *
     * @param $payment_id
     * @return \YandexCheckout\Model\PaymentInterface
     */
    public function getPaymentInfo($payment_id)
    {
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $payment = $client->getPaymentInfo($payment_id);

        return $payment;
    }

    /**
     * Подтверждение платежа
     *
     * @param string $payment_id
     * @param float $value
     * @param string $currency
     */
    public function capturePayment($payment_id, $value, $currency)
    {
        $idempotenceKey = uniqid('', true);
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        // Подтверждение платежа
        $client->capturePayment(
            array(
                'amount' => array(
                    'value' => $value,
                    'currency' => $currency,
                ),
            ),
            $payment_id,
            $idempotenceKey
        );
    }

    /**
     * Отмена платежа
     *
     * @param string $payment_id
     */
    public function cancelPayment($payment_id)
    {
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $client->cancelPayment(
            $payment_id,
            uniqid('', true)
        );
    }

    /**
     * Возврат платежа
     *
     * @param string $payment_id
     * @param float $value
     * @param string $currency
     * @param string $description
     * @return \YandexCheckout\Request\Refunds\CreateRefundResponse
     */
    public function refundPayment($payment_id, $value, $currency, $description)
    {
        $idempotenceKey = uniqid('', true);
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $response = $client->createRefund(
            array(
                'payment_id' => $payment_id,
                'amount' => array(
                    'value' => $value,
                    'currency' => $currency,
                ),
                'description' => $description,
            ),
            $idempotenceKey
        );

        return $response;
    }

    /**
     * Сохранение данных о возврате
     *
     * @param string $payment_id
     * @param string $refund_id
     * @param float $refund_amount
     * @param string $refund_status
     * @param string $description
     * @param string $created_at
     * @return bool
     */
    public function setPaymentRefund($payment_id, $refund_id, $refund_amount, $refund_status, $description, $created_at)
    {
        $up_data = $this->db->query('
            INSERT INTO `orders_payment_refund` (`opr_payment_id`, `opr_refund_id`, `opr_refund_amount`, 
              `opr_refund_status`, `opr_refund_description`, `opr_refund_created_at`)
            VALUES (?, ?, ?, ?, ?, ?)',
                array($payment_id, $refund_id, $refund_amount, $refund_status, $description, $created_at));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Выборка возвратов платежа
     *
     * @param string $payment_id
     * @return array
     */
    public function getPaymentRefunds($payment_id)
    {
        $result = array('refunds' => array(), 'refunds_amount' => 0);

        $sel_refunds = $this->db->query('
            SELECT `opr_refund_id`, `opr_refund_amount`, `opr_refund_status`, `opr_refund_description`, `opr_refund_created_at` 
            FROM `orders_payment_refund` 
            WHERE `opr_payment_id`=?', $payment_id);

        if ($sel_refunds !== false and 0 < $sel_refunds->num_rows())
        {
            $i = 0;
            foreach($sel_refunds->result() as $row)
            {
                $result['refunds'][$i]['id']          = $row->opr_refund_id;
                $result['refunds'][$i]['amount']      = $row->opr_refund_amount;
                $result['refunds'][$i]['description'] = $row->opr_refund_description;
                $result['refunds'][$i]['status_code'] = $row->opr_refund_status;

                $status = array('succeeded' => 'Возврат платежа успешно завершен', 'canceled' => 'Возврат платежа отменен');
                $result['refunds'][$i]['status'] = (array_key_exists($row->opr_refund_status, $status) !== false)
                    ? $status[$row->opr_refund_status] : '';

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $dt_create = new DateTime($row->opr_refund_created_at);
                $created_at = (!empty($row->opr_refund_created_at) and $dt_create !== false)
                    ? $dt_create->format('d F Y, H:i')
                    : '';
                $result['refunds'][$i]['created_at'] = $created_at;

                $result['refunds_amount'] += $row->opr_refund_amount;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_refunds === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОПЛАТЫ */

    /**
     * Поиск товаров по ID или наименованию
     *
     * @param $product_id
     * @param $product_name
     * @return array
     */
    public function searchProducts($product_id = null, $product_name = null)
    {
        $result = array();
        
        if (!empty($product_id)) {
            $search = $product_id;
            $where = '`p_id`=?';
        } else {
            $search = $product_name.'*';
            $where = 'MATCH (`p_name`) AGAINST (? IN BOOLEAN MODE)';
        }

        $sel_products = $this->db->query('
            SELECT `p_id`, `p_name`, `p_short_description`, `p_full_description`, `p_price`, `p_fitcoin_price`, 
              `p_quantity`, `p_discount`, `p_discount_type`, `p_images`, `p_union_flag`, `p_date_add`, `p_blocked` 
            FROM `products`
            WHERE `p_course_id`=0 and '.$where, $search);

        if ($sel_products !== false and 0 < $sel_products->num_rows())
        {
            $i = 0;
            foreach ($sel_products->result() as $row)
            {
                // Данные
                $result['products'][$i] = self::parseProductData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_products === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обработка данных полей товаров таблицы "Store"
     *
     * @param $row
     * @return array
     */
    protected function parseProductData($row)
    {
        $result = array();

        $result['id']           = $row->p_id;
        $result['course_id']    = $row->p_course_id;
        $result['name']         = !empty($row->p_name) ? $row->p_name : 'Товар №'.$row->p_id;
        $result['desc']         = !empty($row->p_short_description) ? mb_substr($row->p_short_description, 0, 30) . '...' : null;
        $result['short_desc']   = !empty($row->p_short_description) ? $row->p_short_description : null;
        $result['full_desc']    = !empty($row->p_full_description) ? $row->p_full_description : null;
        $result['quantity']     = !empty($row->p_quantity) ? $row->p_quantity : null;
        $result['image']        = '';
        $result['images']       = array();
        $result['images_id']    = array();
        $result['count_images'] = 0;
        $result['discount']     = (!empty($row->p_discount) and $row->p_discount != '0.00') ? $row->p_discount : null;
        $result['blocked']      = !empty($row->p_blocked) ? $row->p_blocked : null;
        $result['attached']     = array();
        $result['date']         = '';
        $result['cat_id']       = !empty($row->pc_cat_id) ? $row->pc_cat_id : null;

        $result['discount_type']  = !empty($row->p_discount_type) ? $row->p_discount_type : null;

        $discount = (!empty($row->p_discount) and $row->p_discount != '0.00') ? $row->p_discount : null;
        $price    = (!empty($row->p_price) and $row->p_price != '0.00') ? $row->p_price : null;
        $fc_price = (!empty($row->p_fitcoin_price) and $row->p_fitcoin_price != '0.00') ? $row->p_fitcoin_price : null;

        $result['price']             = $price;
        $result['fc_price']          = $fc_price;
        $result['discount_price']    = (!empty($discount) and !empty($price)) ? (float)($price - ($price * $discount / 100)) : '';
        $result['discount_fc_price'] = (!empty($discount) and !empty($fc_price)) ? (float)($fc_price - ($fc_price * $discount / 100)) : '';

        // Изображения
        if (!empty($row->p_images))
        {
            $images = explode(';', $row->p_images);

            $result['image']        = mb_substr($images[0], 1);
            $result['count_images'] = count($images);

            $im = 0;
            foreach ($images as $image)
            {
                if (is_file($image))
                {
                    $result['images'][$im]['path'] = mb_substr($image, 1);
                    $result['images_id'][$im]      = mb_substr($image, 1);

                    $im++;
                }
            }
            unset($image);
            unset($im);
        }

        // Поиск наличия прикрепленных товаров
        /*$sel_attached_ad = $this->db->query('
        SELECT `pg_attached_p_id` FROM `products_group` WHERE `pg_p_id`=? GROUP BY `pg_p_id` LIMIT 1', $row->p_id);
        if ($sel_attached_ad !== false and 1 == $sel_attached_ad->num_rows())
        {
            $result['attached'] = 1;
        }
        elseif ($sel_attached_ad === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        $sel_attached_ad->free_result();*/

        // Данные корзины
        if (!empty($row->c_id))
        {
            $result['c_id'] = $row->c_id;
            $result['cart_quantity'] = ($row->c_p_quantity <= $row->p_quantity) ? $row->c_p_quantity : $row->p_quantity;
        }

        // Дата добавления
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $date     = DateTime::createFromFormat('Y-m-d H:i:s', $row->p_date_add);
        $date_add = ($row->p_date_add != '0000-00-00 00:00:00' or $date !== false)
            ? strftime('%d %B %G, %H:%M', strtotime($row->p_date_add))
            : '';
        $result['date'] = $date_add;

        return $result;
    }

    /**
     * Обработка данных полей прикрепленных товаров таблицы "Store"
     *
     * @param $row
     * @return mixed
     */
    protected function parseAttachedProductData($row)
    {
        $result['course_id']  = 0;
        $result['id']         = $row->pg_attached_p_id;
        $result['name']       = !empty($row->p_name) ? $row->p_name : 'Товар №'.$row->pg_attached_p_id;
        $result['desc']       = !empty($row->p_short_description) ? mb_substr($row->p_short_description, 0, 30) . '...' : null;
        $result['short_desc'] = !empty($row->p_short_description) ? $row->p_short_description : null;

        $discount = (!empty($row->pg_discount) and $row->pg_discount != '0.00') ? $row->pg_discount : null;
        $price    = (!empty($row->p_price) and $row->p_price != '0.00') ? $row->p_price : null;
        $fc_price = (!empty($row->p_fitcoin_price) and $row->p_fitcoin_price != '0.00') ? $row->p_fitcoin_price : null;

        $result['price']             = $price;
        $result['fc_price']          = $fc_price;
        $result['discount_price']    = (!empty($discount) and !empty($price)) ? $price - ($price * $discount / 100) : null;
        $result['discount_fc_price'] = (!empty($discount) and !empty($fc_price)) ? $fc_price - ($fc_price * $discount / 100) : null;
        $result['discount']          = $discount;
        $result['quantity']          = (!empty($row->p_quantity) and $row->p_quantity > 0) ? $row->p_quantity : 0;

        // Изображения
        $images = !empty($row->p_images) ? explode(';', $row->p_images) : null;
        $result['image'] = !empty($images) ? mb_substr($images[0], 1) : null;

        // Данные корзины
        if (!empty($row->c_id)) {
            $result['c_id']          = $row->c_id;
            $result['attached_id']   = $row->c_attached_c_id;
            $result['cart_quantity'] = ($row->c_p_quantity <= $row->p_quantity) ? $row->c_p_quantity : $row->p_quantity;
        }

        return $result;
    }

    /**
     * Обработка данных полей товар-курсов таблицы "Course"
     *
     * @param $row
     * @return mixed
     */
    protected function parseProductCourseData($row)
    {
        $result['id']         = $row->p_id;
        $result['course_id']  = $row->p_course_id;
        $result['name']       = !empty($row->crs_name) ? $row->crs_name : 'Курс №'.$row->p_course_id;
        $result['short_desc'] = !empty($row->crs_description) ? $row->crs_description : null;

        $price    = (!empty($row->crs_price) and $row->crs_price != '0.00') ? $row->crs_price : '0.00';
        $fc_price = (!empty($row->crs_fitcoin_price) and $row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : '0.00';

        $result['price']             = $price;
        $result['fc_price']          = $fc_price;
        $result['discount_price']    = '';
        $result['discount_fc_price'] = '';
        $result['quantity']          = 1;
        $result['cart_quantity']     = 1;
        $result['attached']          = 0;
        $result['image']             = (!empty($row->crs_image) and is_file($row->crs_image))
            ? mb_substr($row->crs_image, 1) : null;

        // Данные корзины
        if (!empty($row->c_id)) {
            $result['c_id']          = $row->c_id;
            $result['attached_id']   = $row->c_attached_c_id;
            $result['cart_quantity'] = 1;
        }

        return $result;
    }

    /**
     * Обработка данных полей таблицы "Orders"
     *
     * @param $row
     * @return mixed
     */
    protected function parseOrderData($row)
    {
        $result['id']                = $row->o_id;
        $result['user_id']           = $row->o_u_id;
        $result['user_name']         = $row->o_user_name;
        $result['user_surname']      = $row->o_user_surname;
        $result['user_email']        = $row->o_user_email;
        $result['user_country_code'] = $row->o_user_country_code;
        $result['user_phone']        = $row->o_user_phone;

        $delivery = 'Курьер';
        $delivery = $row->o_delivery == 2 ? 'Почта' : $row->o_delivery == 3 ? 'Самовывоз' : $delivery;
        $result['delivery'] = $delivery;

        /*$payment = 'Оплата наличными при получении';
        $payment = $row->o_payment == 2 ? 'Онлайн оплата' : $row->o_payment == 3 ? 'Банковский перевод' : $payment;*/
        $result['payment']  = 'Банковская карта';
        $result['payments'] = array();

        $result['payment_status'] = '';
        $result['status']         = ($row->o_status == 1) ? 'Выполнен' : 'Не выполнен';

        // Дата добавления
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $date     = DateTime::createFromFormat('Y-m-d H:i:s', $row->o_date_add);
        $date_add = ($row->o_date_add != '0000-00-00 00:00:00' and $date !== false)
            ? strftime('%d %B %G, %H:%M', strtotime($row->o_date_add))
            : '';
        $result['date'] = $date_add;

        $result['country']  = $row->oud_country;
        $result['city']     = $row->oud_city;
        $result['street']   = $row->oud_street;
        $result['building'] = $row->oud_building;
        $result['house']    = $row->oud_house;
        $result['postcode'] = ($row->oud_postcode != 0) ? $row->oud_postcode : '';

        $postcode = ($row->oud_postcode != 0) ? $row->oud_postcode . ' ' : '';
        $country  = !empty($row->oud_country) ? $row->oud_country . ', ' : '';
        $city     = !empty($row->oud_city) ? $row->oud_city . ', ' : '';
        $street   = !empty($row->oud_street) ? $row->oud_street . ', ' : '';
        $building = !empty($row->oud_building) ? $row->oud_building . ' ' : '';
        $house    = !empty($row->oud_house) ? $row->oud_house : '';

        $result['address'] = $postcode . $country . $city . $street . $building . $house;

        $result['products'] = array();

        return $result;
    }

    /**
     * Обработка данных полей товаров таблицы "Orders"
     *
     * @param $row
     * @return mixed
     */
    protected function parseOrderProductData($row)
    {
        $result['id']        = $row->ouc_p_id;
        $result['course_id'] = $row->p_course_id;
        $result['attached']  = array();

        if ($row->p_course_id > 0)
        {
            $result['name'] = !empty($row->crs_name) ? $row->crs_name : 'Курс №'.$row->p_course_id;

            $price    = (!empty($row->ouc_p_price) and $row->ouc_p_price != '0.00') ? $row->ouc_p_price : '';
            $fc_price = (!empty($row->ouc_p_fitcoin_price) and $row->ouc_p_fitcoin_price != '0.00') ? $row->ouc_p_fitcoin_price : '';

            $result['price']             = $price;
            $result['fc_price']          = $fc_price;
            $result['discount_price']    = '';
            $result['discount_fc_price'] = '';
            $result['quantity']          = 1;
            $result['cart_quantity']     = 1;

            // Изображения
            $result['image'] = (!empty($row->crs_image) and is_file($row->crs_image))
                ? mb_substr($row->crs_image, 1) : null;
        }
        else
        {
            $result['name']          = !empty($row->p_name) ? $row->p_name : 'Товар №'.$row->ouc_p_id;
            $result['price']         = (!empty($row->ouc_p_price) and $row->ouc_p_price != '0.00') ? $row->ouc_p_price : '';
            $result['fc_price']      = (!empty($row->ouc_p_price) and $row->ouc_p_fitcoin_price != '0.00') ? $row->ouc_p_fitcoin_price : '';
            $result['quantity']      = $row->p_quantity;
            $result['cart_quantity'] = $row->ouc_p_quantity;

            // Изображения
            $images = !empty($row->p_images) ? explode(';', $row->p_images) : null;
            $result['image'] = !empty($images) ? mb_substr($images[0], 1) : null;
        }

        return $result;
    }

    /**
     * Обработка данных оплаты заказа
     *
     * @param $row
     * @return mixed
     */
    protected function parsePaymentData($row)
    {
        $result['id']       = $row->op_payment_id;
        $result['amount']   = $row->op_amount;
        $result['currency'] = $row->op_currency;

        $status = array('pending' => 'Платеж ожидает подтверждения пользователем', 'waiting_for_capture' => 'Платеж ожиданиет подтверждения или отмены магазином',
            'succeeded' => 'Платеж успешно завершен', 'canceled' => 'Платеж отменен', '' => '');
        $result['status'] = (array_key_exists($row->op_status, $status) !== false)
            ? $status[$row->op_status] : '';

        $result['status_code']  = $row->op_status;
        $result['paid']         = ($row->op_paid == 1) ? 'Оплачено' : 'Не оплачено';
        $result['method_saved'] = $row->op_payment_method_saved;
        $result['method_id']    = $row->op_payment_method_id;

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $dt_create = new DateTime($row->op_created_at);
        $created_at = (!empty($row->op_created_at) and $dt_create !== false)
            ? $dt_create->format('d F Y, H:i')
            : '';
        $dt_expires = new DateTime($row->op_expires_at);
        $expires_at = (!empty($row->op_expires_at) and $dt_expires !== false)
            ? $dt_expires->format('d F Y, H:i')
            : '';

        $result['following_date'] = $row->op_following_date;
        $result['created_at']     = $created_at;
        $result['created_at_orig'] = $row->op_created_at;
        $result['expires_at']     = $expires_at;

        return $result;
    }
}