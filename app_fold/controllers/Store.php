<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Store
 * 
 * Класс для отображения и обработки данных интернет магазина, товаров, категорий товаров, корзины пользователя
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Store extends CI_Controller
{
    const CURRENCY = 'RUB';

    /**
     * Store constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Store_model');
    }

    /**
     * Вывод списка категорий
     *
     * @return void
     */
    public function categories()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result = $this->Store_model->getECategories();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Категории';
        $this->page_data['page_menu'] = 'categories';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/category/categories', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления категории
     *
     * @return void
     */
    public function newCategory()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_new_category', true)) {
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            
            if (!empty($name)) {
                $result = $this->Store_model->setNewCategory($name, $this->date, $this->user_id);
                
                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 63, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 62, 60);
            }

            header('Location: /administration/category/new');
        }
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Новая категория';
        $this->page_data['page_menu'] = 'categories';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/category/new_category');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных для редактирования категории, список подкатегорий, обработка введенных данных
     *
     * @param $category_id
     * @return void
     */
    public function category($category_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_category', true)) {
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Store_model->updateCategorySettings($category_id, $name, $this->date);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 63, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 62, 60);
            }

            header('Location: /administration/category/'.$category_id);
        }
        elseif ($this->input->post('bt_block_category', true)) {
            $result = $this->Store_model->blockCategory($category_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 64, 60);
            }
            header('Location: /administration/category/'.$category_id);
        }
        elseif ($this->input->post('bt_unblock_category', true)) {
            $result = $this->Store_model->unblockCategory($category_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 65, 60);
            }
            header('Location: /administration/category/'.$category_id);
        }

        $result = $this->Store_model->getECategory($category_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Категория';
        $this->page_data['page_menu'] = 'categories';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/category/category_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления подкатегории
     *
     * @param $category_id
     * @return void
     */
    public function newSubcategory($category_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_new_subcategory', true)) {
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Store_model->setNewSubcategory($category_id, $name, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 63, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 62, 60);
            }

            header('Location: /administration/category/'.$category_id.'/new');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Новая подкатегория';
        $this->page_data['page_menu'] = 'categories';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/category/new_subcategory');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных для редактирования подкатегории, обработка введенных данных
     *
     * @param $category_id
     * @param $subcategory_id
     * @return void
     */
    public function subcategory($category_id, $subcategory_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_subcategory', true)) {
            $new_category = $this->input->post('s_categories', true);
            $category = (is_numeric($new_category) and $new_category != $category_id) ? $new_category : $category_id;
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Store_model->updateSubcategorySettings($subcategory_id, $category, $name, $this->date);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 63, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 62, 60);
            }

            header('Location: /administration/category/'.$category_id.'/'.$subcategory_id);
        }
        elseif ($this->input->post('bt_block_subcategory', true)) {
            $result = $this->Store_model->blockSubcategory($subcategory_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 64, 60);
            }
            header('Location: /administration/category/'.$category_id.'/'.$subcategory_id);
        }
        elseif ($this->input->post('bt_unblock_subcategory', true)) {
            $result = $this->Store_model->unblockSubcategory($category_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 65, 60);
            }
            header('Location: /administration/category/'.$category_id.'/'.$subcategory_id);
        }

        $categories = $this->Store_model->getCategories();
        $subcategory = $this->Store_model->getESubcategory($subcategory_id);

        $result = array_merge($categories, $subcategory);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Подкатегория';
        $this->page_data['page_menu'] = 'categories';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/category/subcategory_settings', $result);
        $this->load->view('footer/footer');
    }


    /**
     * АП. Вывод всех товаров интернет-магазина
     *
     * @return void
     */
    public function products()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result = $this->Store_model->getProducts();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Интернет-магазин';
        $this->page_data['page_menu'] = 'a_store';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/product/products', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Форма добавления нового товара, обработка введенных данных
     *
     * @return void
     */
    public function newProduct()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_new_product', true)) {
            $categories_id = $this->Store_model->getCategoriesId();
            $s_category    = $this->input->post('sc_category_name', true);
            $category_id   = (is_numeric($s_category) and in_array($s_category, $categories_id['id']))
                ? $s_category
                : null;
            /*if (!empty($category_id)) {
                $subcategories_id = $this->Store_model->getSubcategoriesId($category_id);

                foreach($this->input->post('cb_subcat') as $subcategory){
                    if(is_numeric($subcategory) and in_array($subcategory, $subcategories_id['id'])){
                        $pr_category[] = $subcategory;
                    }
                }
                unset($subcategory);
            }*/

            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr(strip_tags($this->input->post('full_desc', true)), 0, 1000);

            $price         = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            //$fitcoin_price = is_numeric($this->input->post('fitcoin_price', true)) ? $this->input->post('fitcoin_price', true) : '';
            $quantity      = is_numeric($this->input->post('quantity', true)) ? $this->input->post('quantity', true) : 0;
            $discount      = is_numeric($this->input->post('discount', true)) ? $this->input->post('discount', true) : '';
            $discount_type = 2;

            // Прикрепленный товары
            $attached_products    = array('insert' => '', 'update' => '', 'delete' => '');
            $db_attached_id       = null;
            $db_attached_discount = null;

            if (!empty($this->input->post('attached_products', true))) {
                $i_products     = $this->input->post('attached_products', true);
                $input_products = array_unique($i_products);
                $input_discount = $this->input->post('attached_discount', true);
                $i = 0;
                foreach ($input_products as $key => $attached_id) {
                    if (is_numeric($attached_id) and is_numeric($input_discount[$key])){
                        // Поиск в массиве прикрепленных товаров
                        $search_key = !empty($db_attached_id) ? array_search($attached_id, $db_attached_id) : false;
                        // Если нашел товар и значения скидки отличаются, обновить данные
                        if (is_numeric($search_key) and $db_attached_discount[$search_key] != $input_discount[$key]) {
                            $attached_products['update'][$attached_id] = $input_discount[$key];
                        }
                        // Если не нашел товар, добавить данные
                        elseif ($search_key === false) {
                            $attached_products['insert'][$attached_id] = $input_discount[$key];
                        }

                        $i++;
                    }
                }
                unset($product);

                // Удаление открепленных товаров
                $attached_products['delete'] = !empty($db_attached_id) ? array_diff($db_attached_id, $input_products) : '';
            }
            else {
                // Удаление открепленных товаров
                $attached_products['delete'] = $db_attached_id;
            }

            if (!empty($name) and !empty($price)) {

                $product_id = $this->Store_model->setNewProduct($name, $short_desc, $full_desc, $price, $quantity,
                    $discount, $discount_type, $category_id, $attached_products, $this->date, $this->user_id);

                if (is_numeric($product_id)) {
                    $path = './product_files/' . $product_id . '/';
                    $files_data = array();
                    $temp_files = $_FILES;

                    if (!file_exists($path)) {
                        chdir('product_files');
                        if (!is_dir($product_id)) {
                            mkdir($product_id);
                        }
                        chmod($product_id, 0777);
                        chdir($product_id);
                        chdir('../../');
                    }

                    $i = 0;
                    foreach ($temp_files['images']['name'] as $name) {

                        $_FILES['images'] = array(
                            'name' => $temp_files['images']['name'][$i],
                            'type' => $temp_files['images']['type'][$i],
                            'tmp_name' => $temp_files['images']['tmp_name'][$i],
                            'error' => $temp_files['images']['error'][$i],
                            'size' => $temp_files['images']['size'][$i]);

                        $path_image = parent::uploadImage('images', $_FILES['images']['type'], $path);

                        if (file_exists($path . $path_image)) {
                            if ($this->security->xss_clean($path . $path_image, TRUE) !== FALSE) {
                                // файл прошел XSS тест
                                $files_data[] = $path . $path_image;

                            } else {
                                unlink($path . $path_image);
                                /*$image = pathinfo($path_image);
                                $mini_image = $image['filename'].'_thumb.'.$image['extension'];
                                if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$mini_image)){
                                    unlink('./user_files/'.$this->user_id.'/portfolio/'.$mini_image);
                                }*/
                            }
                        }
                        $i++;
                    }
                    if (!empty($files_data)) {
                        $this->Store_model->setProductImages($product_id, $files_data, $this->date);
                    }

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/store/product/'.$product_id);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 67, 60);

                    header('Location: /administration/store/product/new');
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 66, 60);

                header('Location: /administration/store/product/new');
            }
        }

        $result = $this->Store_model->getCategories();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Интернет-магазин - Новый товар';
        $this->page_data['page_menu'] = 'a_store';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/product/new_product', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Форма для редактирования данных товара, обработка данных
     *
     * @param $product_id
     * @return void
     */
    public function product($product_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $categories    = $this->Store_model->getCategories();
        $product       = $this->Store_model->getProduct($product_id);
        //$subcategories = !empty($product['product']['category_id']) ? $this->Store_model->getCategorySubcategories($product['product']['category_id']) : array('subcategories' => array());
        $result        = array_merge($categories, $product);

        if ($this->input->post('bt_save_product', true)) {
            // Категория
            $categories_id = $this->Store_model->getCategoriesId();
            $s_category    = $this->input->post('sc_category_name', true);
            $category_id   = (is_numeric($s_category) and in_array($s_category, $categories_id['id']))
                ? $s_category
                : null;
            /*$pr_category = array();
            if (!empty($category_id)) {
                $subcategories_id = $this->Store_model->getSubcategoriesId($category_id);

                if($this->input->post('cb_subcat', true)){
                    foreach($this->input->post('cb_subcat', true) as $subcategory){
                        if(is_numeric($subcategory) and in_array($subcategory, $subcategories_id['id'])){
                            $pr_category[] = $subcategory;
                        }
                    }
                    unset($subcategory);
                }
            }

            // Сравнение с предыдущими значениями категорий
            if(!empty($pr_category) and is_array($pr_category) and is_array($result['product']['subcategories'])){
                $old_cat = $result['product']['subcategories'];
                $new_cat = $pr_category;

                // Расхождение массивов
                $new_cat_diff = array_diff($new_cat, $old_cat); // Значения которые будут обновлены или добавлены
                $old_cat_diff = array_diff($old_cat, $new_cat); // Значения которые будут обновлены или удалены

                // Количество элементов в полученных массивах
                $count_new_cat = count($new_cat_diff);
                $count_old_cat = count($old_cat_diff);

                if($count_new_cat > $count_old_cat){ // Обновляем старые значения и добавляем новые
                    $update_cat = array_slice($new_cat_diff, 0, $count_old_cat); // Категории, на кот. нужно обновить
                    $insert_cat = array_slice($new_cat_diff, $count_old_cat); // Категории, кот. нужно добавить

                    $this->Store_model->insertCategoriesProduct($product_id, $category_id, $insert_cat, $this->date, $this->user_id);
                    $this->Store_model->updateCategoriesProduct($product_id, $category_id, $update_cat, $old_cat, $this->date);
                }
                elseif($count_new_cat < $count_old_cat){ // Обновляем старые значения и удаляем лишние
                    $update_cat = array_slice($old_cat_diff, 0, $count_new_cat); // Категории, кот. нужно обновить
                    $delete_cat = array_slice($old_cat_diff, $count_new_cat); // Категории, кот. нужно удалить

                    $this->Store_model->updateCategoriesProduct($product_id, $category_id, $new_cat, $update_cat, $this->date);
                    $this->Store_model->deleteCategoriesProduct($product_id, $delete_cat);
                }
                elseif($count_new_cat > 0 AND $count_old_cat > 0){ // Если количество элементов в массивах одинаковое. Обновляем старые значения
                    $this->Store_model->updateCategoriesProduct($product_id, $category_id, $new_cat_diff, $old_cat_diff, $this->date);
                }
            }
            elseif(!empty($pr_category) and is_array($pr_category) and !is_array($result['product']['subcategories'])){ // Добавление категорий товара
                $this->Store_model->insertCategoriesProduct($product_id, $category_id, $pr_category, $this->date, $this->user_id);
            }
            elseif(empty($pr_category) and is_array($result['product']['subcategories'])){ // Удаление категорий товара
                $count_old_cat = count($result['product']['subcategories']);
                $this->Store_model->deleteCategoriesProduct($product_id, null, $count_old_cat);
            }*/

            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr(strip_tags($this->input->post('full_desc', true)), 0, 1000);

            $price         = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            //$fitcoin_price = is_numeric($this->input->post('fitcoin_price', true)) ? $this->input->post('fitcoin_price', true) : '';
            $quantity      = is_numeric($this->input->post('quantity', true)) ? $this->input->post('quantity', true) : 0;
            $discount      = is_numeric($this->input->post('discount', true)) ? $this->input->post('discount', true) : '';
            $discount_type = 2;

            // Прикрепленный товары
            $attached_products    = array('insert' => '', 'update' => '', 'delete' => '');
            $db_attached_id       = $product['product']['attached_id'];
            $db_attached_discount = $product['product']['attached_discount'];

            if (!empty($this->input->post('attached_products', true))) {
                $i_products     = $this->input->post('attached_products', true);
                $input_products = array_unique($i_products);
                $input_discount = $this->input->post('attached_discount', true);
                $i = 0;
                foreach ($input_products as $key => $attached_id) {
                    if (is_numeric($attached_id) and is_numeric($input_discount[$key])){
                        // Поиск в массиве прикрепленных товаров
                        $search_key = !empty($db_attached_id) ? array_search($attached_id, $db_attached_id) : false;
                        // Если нашел товар и значения скидки отличаются, обновить данные
                        if (is_numeric($search_key) and $db_attached_discount[$search_key] != $input_discount[$key]) {
                            $attached_products['update'][$attached_id] = $input_discount[$key];
                        }
                        // Если не нашел товар, добавить данные
                        elseif ($search_key === false) {
                            $attached_products['insert'][$attached_id] = $input_discount[$key];
                        }

                        $i++;
                    }
                }
                unset($product);

                // Удаление открепленных товаров
                $attached_products['delete'] = !empty($db_attached_id) ? array_diff($db_attached_id, $input_products) : '';
            }
            else {
                // Удаление открепленных товаров
                $attached_products['delete'] = $db_attached_id;
            }

            //print_r($attached_products);

            // Сохранение данных в БД
            if (!empty($name) and !empty($price)) {

                $result_data = $this->Store_model->updateProductSettings($product_id, $category_id, $name, $short_desc, $full_desc,
                    $price, $quantity, $discount, $discount_type, $attached_products, $this->date, $this->user_id);
                
                if ($result_data === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 67, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 66, 60);
            }

            // Обработка изображений
            if ($result['product']['count_images'] < 6 and is_uploaded_file($_FILES['images']['tmp_name'][0])) {
                $path = './product_files/' . $product_id . '/';
                $files_data = array();
                $temp_files = $_FILES;
                $residue_images = 5 - $result['product']['count_images'];

                for ($i=0; $i<=$residue_images-1; $i++){
                    if(isset($temp_files['images']['name'][$i])){
                        $_FILES['images'] = array (
                            'name'=>$temp_files['images']['name'][$i],
                            'type'=>$temp_files['images']['type'][$i],
                            'tmp_name'=>$temp_files['images']['tmp_name'][$i],
                            'error'=>$temp_files['images']['error'][$i],
                            'size'=>$temp_files['images']['size'][$i]);

                        $path_image = parent::uploadImage('images', $_FILES['images']['type'], $path);

                        if(file_exists($path.$path_image)){
                            if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE) {
                                // файл прошел XSS тест
                                $files_data[] = $path . $path_image;

                            } else{
                                unlink($path . $path_image);
                                $image = pathinfo($path_image);
                                $mini_image = $image['dirname'].'/'.$image['filename'].'_thumb.'.$image['extension'];
                                if(file_exists($path . $mini_image)){
                                    unlink($path . $mini_image);
                                }
                            }
                        }
                    }
                }

                // Сохранение изображений в БД
                if(!empty($files_data)){
                    $result_images = $this->Store_model->setProductImages($product_id, $files_data, $this->date);

                    if ($result_images === true) {
                        // Сохранено
                        $this->session->set_tempdata('message', 10, 60);
                    } else {
                        // Не сохранено
                        $this->session->set_tempdata('message', 70, 60);
                    }
                }
            }

            header('Location: /administration/store/product/'.$product_id);
        }
        elseif ($this->input->post('bt_block_product', true)) {
            $result = $this->Store_model->blockProduct($product_id, $this->date);

            if ($result === true) {
                // Заблокировано
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не заблокировано
                $this->session->set_tempdata('message', 68, 60);
            }

            header('Location: /administration/store/product/'.$product_id);
        }
        elseif ($this->input->post('bt_unblock_product', true)) {
            $result = $this->Store_model->unblockProduct($product_id, $this->date);

            if ($result === true) {
                // Разблокировано
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не разблокировано
                $this->session->set_tempdata('message', 69, 60);
            }

            header('Location: /administration/store/product/'.$product_id);
        }
        elseif ($this->input->post('bt_delete_product_img', true)) {
            $img_id = key($this->input->post('bt_delete_product_img', true));

            $path_image = $this->input->post('img_path_'.$img_id, true);

            if(file_exists(mb_substr($path_image, 1))){
                unlink(mb_substr($path_image, 1));

                if (($i = array_search($path_image, $result['product']['images_id'])) !== false) {
                    unset($result['product']['images_id'][$i]);
                }
            }
            
            $this->Store_model->setProductImages($product_id, $result['product']['images_id'], $this->date);

            header('Location: /administration/store/product/'.$product_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Интернет-магазин - Редактирование данных товара';
        $this->page_data['page_menu'] = 'a_store';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/product/product_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Список заказов пользователей
     *
     * @return void
     */
    public function orders()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result = $this->Store_model->getOrders();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Заказы';
        $this->page_data['page_menu'] = 'a_orders';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/cart/orders', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Страница заказа пользователя, со список товаров и информацией о заказе
     *
     * @param $order_id
     */
    public function order($order_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        // Курсы заказа
        $order_courses = $this->Store_model->getOrderCourses('', $order_id);

        if ($this->input->post('bt_capture', true))
        {
            $payment_id = strip_tags($this->input->post('i_payment_id', true));

            if (!empty($payment_id))
            {
                $payment = $this->Store_model->getPaymentInfo($payment_id);

                if ($payment->_status == 'waiting_for_capture')
                {
                    $this->Store_model->capturePayment($payment->_id, $payment->_amount->_value, $payment->_amount->_currency);
                }
            }
            header('Location: /administration/order/' . $order_id);
        }
        elseif($this->input->post('bt_cancel', true))
        {
            $payment_id = strip_tags($this->input->post('i_payment_id', true));

            if (!empty($payment_id))
            {
                $payment = $this->Store_model->getPaymentInfo($payment_id);

                if ($payment->_status == 'waiting_for_capture')
                {
                    $this->Store_model->cencelPayment($payment->_id);
                }
            }

            header('Location: /administration/order/' . $order_id);
        }
        elseif($this->input->post('bt_refund', true))
        {
            $refund_amount = is_numeric($this->input->post('i_refund_amount', true)) ? $this->input->post('i_refund_amount', true) : null;
            $payment_id    = strip_tags($this->input->post('i_payment_id', true));
            $description   = strip_tags($this->input->post('i_description', true));

            if (!empty($refund_amount) and !empty($payment_id))
            {
                $payment = $this->Store_model->getPaymentInfo($payment_id);

                $response = $this->Store_model->refundPayment($payment->_id, $refund_amount, self::CURRENCY, $description);

                log_message('debug', __METHOD__ . ' ' . print_r($response, true));

                if (!empty($response->id))
                {
                    $this->Store_model->setPaymentRefund($response->payment_id, $response->id, $refund_amount, $response->status, $description, $response->created_at);

                    if ($response->status == 'succeeded')
                    {
                        $this->load->model('Course_model');

                        // Блокировка курсов пользователя
                        $this->Course_model->blockUserOrderCourses($order_courses['user_id'], $order_courses['courses']);
                    }
                }
            }

            header('Location: /administration/order/' . $order_id);
        }

        $order = $this->Store_model->getOrder($order_id);
        $course_data = array();

        if (!empty($order_courses['courses']))
        {
            $this->load->model('Course_model');

            // Кол-во пройденных пользователем тренировок курса
            $course_data = $this->Course_model->getUserPassedWorkouts($order['user_id'], $order_courses['courses']);
        }

        $result = array_merge($order, $course_data);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Заказ №' . $order_id;
        $this->page_data['page_menu'] = 'a_orders';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('store/cart/order', $result);
        $this->load->view('footer/footer');
    }


    /* НАЧАЛО БЛОКА ВЫВОДА ТОВАРА/ТОВАРОВ ИНТЕРНЕТ-МАГАЗИНА */

    /**
     * Вывод товаров ИМ для пользователя
     *
     * @param null|string $category_id
     * @param null|string $subcategory_id
     */
    public function store($category_id = null, $subcategory_id = null)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $this->load->model('Course_model');

        $category = (!empty($category_id) and $category_id == 'courses') ? 'courses' : $category_id;

        // Поиск по наименованию
        $search = !empty($this->input->post('search', true))
            ? strip_tags($this->input->post('search', true))
            : null;

        // Сортировка
        $sort = ($this->input->post('bt_sort_result', true) and is_numeric($this->input->post('sort', true)))
            ? $this->input->post('sort', true)
            : 1; // Цена по возрастанию

        $limit = !empty($category) ? 9 : 5;

        $user_cart    = !empty($this->user_id) ? $this->Store_model->getCartProductsId($this->user_id) : array();
        $user_courses = !empty($this->user_id) ? $this->Course_model->getUserCoursesId($this->user_id) : array();
        $categories   = $this->Store_model->getCategories();

        // Объединенные данные страница
        $this->page_data['title'] = 'Интернет-магазин';
        $this->page_data['page_menu'] = 'store';
        $this->page_data['sort_checked'] = $sort;
        $this->page_data['search'] = $search;
        $this->page_data['categories'] = $categories;
        $this->page_data['category_id'] = $category;
        $this->page_data['subcategory_id'] = $subcategory_id;

        if (empty($category))
        {
            $products = $this->Store_model->getLastStoreProducts($sort, $search, $limit);
        }
        else
        {
            $products = $this->Store_model->getStoreProducts($category, $subcategory_id, $sort, $search, $limit);
        }
        $result   = array_merge($user_cart, $user_courses, $products);
        //print_r($products['products']);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/store');
        $this->load->view('store/product/store_products', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных о товаре для пользователя
     *
     * @param $product_id
     * @param $category_id
     * @param $subcategory_id
     * @return void
     */
    public function storeProduct($product_id, $category_id = null, $subcategory_id = null)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $categories = $this->Store_model->getCategories();
        $products   = $this->Store_model->getStoreProduct($product_id);
        $user_cart  = $this->Store_model->getCartProductsId($this->user_id);
        $result     = array_merge($categories, $products, $user_cart);

        $result['category_id']    = $category_id;
        $result['subcategory_id'] = $subcategory_id;

        if ($this->input->post('bt_to_cart', true)) {
            $db_quantity = $products['product']['quantity'];

            $i_quantity = $this->input->post('product_quantity', true);
            $quantity = (is_numeric($i_quantity) and $i_quantity <= $db_quantity)
                ? $i_quantity : 1;

            $with_attached = !empty($this->input->post('cb_with_attached', true)) ? 1 : 0;

            $res_cart = $this->Store_model->setProductToCart($product_id, $this->user_id, $this->date, $quantity, $with_attached);

            if ($res_cart) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 71, 60);
            }

            $path = !empty($category_id) ? '/store/'.$category_id.'/product/'.$product_id : '/store/product/'.$product_id;

            header('Location: ' . $path);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Интернет-магазин - Товар';
        $this->page_data['page_menu'] = 'store';
        $this->page_data['categories'] = $categories;
        $this->page_data['category_id'] = $category_id;
        $this->page_data['subcategory_id'] = $subcategory_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/store');
        $this->load->view('store/product/store_product', $result);
        $this->load->view('footer/footer');
    }

    /* КОНЕЦ БЛОКА ВЫВОДА ТОВАРА/ТОВАРОВ ИНТЕРНЕТ-МАГАЗИНА */

    /**
     * Корзина пользователя
     *
     * @return void
     */
    public function cart()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        if ($this->input->post('bt_update_cart', true)) {
            $result_cart = true;
            if (!empty($this->input->post('product_quantity', true)) and !empty($this->input->post('product_id', true))) {
                $quantity = $this->input->post('product_quantity', true);
                foreach ($this->input->post('product_id', true) as $key => $product_id) {
                    $product_quantity = $quantity[$key];
                    
                    $result = $this->Store_model->updateCart($product_id, $this->user_id, $this->date, $product_quantity);

                    if ($result === false) {
                        $result_cart = false;
                    }
                }
                unset($product_id);
            }
            if ($result_cart === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 68, 60);
            }

            header('Location: /store/cart');
        }
        elseif ($this->input->post('bt_delete_product', true)) {
            $product_id = key($this->input->post('bt_delete_product', true));

            $result = $this->Store_model->deleteCartProduct($product_id, $this->user_id);

            header('Location: /store/cart');
        }
        elseif ($this->input->post('bt_detach_products', true)) {
            $attached_id = key($this->input->post('bt_detach_products', true));

            if (is_numeric($attached_id)) {
                $this->Store_model->detachCartProducts($this->user_id, $attached_id);

                header('Location: /cart');
            }
        }

        $categories = $this->Store_model->getCategories();
        $result     = $this->Store_model->getUserCartProducts($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Корзина';
        $this->page_data['page_menu'] = 'cart';
        $this->page_data['categories'] = $categories;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/store');
        $this->load->view('store/cart/user_cart', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница оформления заказа
     *
     * @param $order_id
     */
    public function ordering($order_id = null)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $categories = $this->Store_model->getCategories();
        $products   = $this->Store_model->getUserCartInStockProducts($this->user_id);
        $addresses  = $this->Store_model->getUserOrderAddresses($this->user_id);

        if ($this->input->post('bt_delete_product', true)) {
            $product_id = key($this->input->post('bt_delete_product', true));

            $result = $this->Store_model->deleteCartProduct($product_id, $this->user_id);

            header('Location: /ordering');
        }
        elseif ($this->input->post('bt_detach_products', true)) {
            $attached_id = key($this->input->post('bt_detach_products', true));

            if (is_numeric($attached_id)) {
                $this->Store_model->detachCartProducts($this->user_id, $attached_id);

                header('Location: /ordering');
            }
        }
        elseif ($this->input->post('bt_to_order', true))
        {
            // Выбранный адрес доставки из предыдущих
            $prev_address = is_numeric($this->input->post('s_o_address', true)) ? $this->input->post('s_o_address', true) : '';

            // Данные пользователя
            $name    = !empty($this->input->post('i_o_name', true)) ? mb_substr(strip_tags($this->input->post('i_o_name', true)), 0, 255) : '';
            $surname = !empty($this->input->post('i_o_surname', true)) ? mb_substr(strip_tags($this->input->post('i_o_surname', true)), 0, 255) : '';
            $email   = !empty($this->input->post('i_o_email', true)) ? mb_substr(strip_tags($this->input->post('i_o_email', true)), 0, 255) : '';
            $phone   = !empty($this->input->post('i_o_phone', true)) ? mb_substr(strip_tags($this->input->post('i_o_phone', true)), 0, 255) : '';

            // Адрес доставки
            $country  = (empty($prev_address) and !empty($this->input->post('i_o_country', true)))
                ? mb_substr(strip_tags($this->input->post('i_o_country', true)), 0, 255) : '';
            $city     = (empty($prev_address) and !empty($this->input->post('i_o_city', true)))
                ? mb_substr(strip_tags($this->input->post('i_o_city', true)), 0, 255) : '';
            $street   = (empty($prev_address) and !empty($this->input->post('i_o_street', true)))
                ? mb_substr(strip_tags($this->input->post('i_o_street', true)), 0, 255) : '';
            $building = (empty($prev_address) and !empty($this->input->post('i_o_building', true)))
                ? mb_substr(strip_tags($this->input->post('i_o_building', true)), 0, 50) : '';
            $house    = (empty($prev_address) and !empty($this->input->post('i_o_house', true)))
                ? mb_substr(strip_tags($this->input->post('i_o_house', true)), 0, 50) : '';
            $postcode = (empty($prev_address) and is_numeric($this->input->post('i_o_postcode', true)))
                ? $this->input->post('i_o_postcode', true) : '';

            // Способ доставки
            $a_d = array(1 => 'Курьер', 2 => 'Почта', 3 => 'Самовывоз');
            $delivery = (array_search($this->input->post('i_o_delivery', true), $a_d) !== false)
                ? array_search($this->input->post('i_o_delivery', true), $a_d) : 1;

            // Данные о платеже
            $a_p = array(1 => 'Оплата наличными при получении', 2 => 'Онлайн оплата', 3 => 'Банковский перевод');
            $payment_type = 'bank_card';

            // Товары заказа
            $products = $this->Store_model->getUserCartInStockProducts($this->user_id);

            if (!empty($products))
            {
                $res_order = $this->Store_model->setOrder($this->user_id, $prev_address, $name, $surname, $email, $phone,
                    $country, $city, $street, $building, $house, $postcode, $delivery, $products, $this->date);

                if ($res_order !== false and is_numeric($res_order['order_id']))
                {
                    // Кол-во товаров в корзине
                    parent::updateSessionCart(0);

                    header('Location: /payment?oid=' . $res_order['order_id'] . '&amount=' . $res_order['total_amount'] . '&type=' . $payment_type);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 101, 60);
                    header('Location: /ordering');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Оформление заказа';
        $this->page_data['page_menu'] = 'cart';
        $this->page_data['categories'] = $categories;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/store');
        if (is_numeric($order_id)) {
            $order = $this->Store_model->getUserOrder($this->user_id, $order_id);
            $result = array_merge($categories, $order);
            $this->load->view('store/cart/ordering_end', $result);
        }
        else {
            $result = array_merge($categories, $products, $addresses);
            $this->load->view('store/cart/ordering', $result);
        }
        $this->load->view('footer/footer');
    }

    public function userOrders()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id)) {
            show_404();
        }

        $result = $this->Store_model->getUserOrders($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Заказы';
        $this->page_data['page_menu'] = 'orders';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('store/cart/user_orders', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница заказа для пользователя
     *
     * @param $order_id
     */
    public function userOrder($order_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id)) {
            show_404();
        }

        $categories = $this->Store_model->getCategories();
        $order      = $this->Store_model->getUserOrder($this->user_id, $order_id);
        $result     = array_merge($categories, $order);

        // Объединенные данные страница
        $this->page_data['title'] = 'Заказ №' . $order_id;
        $this->page_data['page_menu'] = 'orders';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('store/cart/user_order', $result);
        $this->load->view('footer/footer');
    }

    /* БЛОК AJAX ФУНКЦИЙ */

    /**
     * AJAX. Получение подкатегорий для категории
     *
     * @return void
     */
    public function getSubcategories()
    {
        $category_id = $this->input->post('id_category', true) and is_numeric($this->input->post('id_category', true))
            ? $this->input->post('id_category', true)
            : null;
        $ids_subcat = is_array($this->input->post('ids_subcat', true))
            ? $this->input->post('ids_subcat', true)
            : null;
        $subcategories = '';

        if(!empty($category_id)){
            $result = $this->Store_model->getCategorySubcategories($category_id);

            if(!empty($result['subcategories'])){
                $a = 0;
                foreach($result['subcategories'] as $subcat){
                    $checked = '';
                    if(!empty($ids_subcat) and in_array($subcat['id'], $ids_subcat)){
                        $checked = 'checked="checked"';
                    }
                    $subcategories .= '<div class="sett">
                            <input type="checkbox" name="cb_subcat['.$a.']" id="cb_cat'.$subcat['id'].'" value="'.$subcat['id'].'" '.$checked.'/>
                            <label for="cb_cat'.$subcat['id'].'" class="subcat_h">'.$subcat['name'].'</label>
                        </div>';
                    $a++;
                }
                unset($subcategory);
            }
        }

        echo $subcategories;
    }

    /**
     * AJAX Сохранение товара в корзину
     *
     * @return void
     */
    public function productToCart()
    {
        $result = array('cart' => false, 'cart_info' => '');

        // Если пользователь авторизован
        if (!empty($this->user_id))
        {
            $product_id       = $this->input->post('product_id', true) and is_numeric($this->input->post('product_id', true))
                ? $this->input->post('product_id', true)
                : null;
            $product_quantity = ($this->input->post('product_quantity', true) and is_numeric($this->input->post('product_quantity', true)))
                ? $this->input->post('product_quantity', true)
                : 1;

            if(!empty($product_id))
            {
                $res = $this->Store_model->setProductToCart($product_id, $this->user_id, $this->date, $product_quantity);

                if ($res['add'] === true)
                {
                    // Кол-во товаров в корзине
                    $cart_products = $this->Store_model->getCartCountProducts($this->user_id);

                    parent::updateSessionCart($cart_products);

                    $result['cart_info'] = '<div class="not_available">В корзине</div>';
                    $result['cart'] = true;
                    $result['cart_count'] = (!empty($this->session->cart)) ? $this->session->cart : 0;
                }
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Обновление данных корзины
     */
    public function updateCartProduct()
    {
        $result = array('cart' => false);

        // Если пользователь авторизован
        if (!empty($this->user_id)) {
            $product_id       = !empty($this->input->post('product_id', true)) ? $this->input->post('product_id', true) : null;
            $product_quantity = (!empty($this->input->post('product_quantity', true)) and is_numeric($this->input->post('product_quantity', true)))
                ? $this->input->post('product_quantity', true)
                : 1;

            if(is_numeric($product_id)){
                $res_up = $this->Store_model->updateCart($product_id, $this->user_id, $this->date, $product_quantity);

                if (is_numeric($res_up)) {
                    $result['cart'] = $res_up;
                }
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Удаление товара из корзины
     */
    public function deleteCartProduct()
    {
        $result = array('cart' => false);

        // Если пользователь авторизован
        if (!empty($this->user_id))
        {
            $product_id = !empty($this->input->post('product_id', true)) ? $this->input->post('product_id', true) : null;

            if(is_numeric($product_id))
            {
                $res_del = $this->Store_model->deleteCartProduct($product_id, $this->user_id);

                if ($res_del === true)
                {
                    $result['cart'] = true;

                    // Кол-во товаров в корзине
                    $cart_products = $this->Store_model->getCartCountProducts($this->user_id);

                    parent::updateSessionCart($cart_products);

                    $result['cart_count'] = (!empty($this->session->cart)) ? $this->session->cart : 0;
                }
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Удаление прикрепленных товаров из коризны
     */
    public function detachCartProducts()
    {
        $result = array('cart' => false);

        // Если пользователь авторизован
        if (!empty($this->user_id))
        {
            $product_id = !empty($this->input->post('product_id', true)) ? $this->input->post('product_id', true) : null;

            if(is_numeric($product_id))
            {
                $res_del = $this->Store_model->detachCartProducts($this->user_id, $product_id);

                if ($res_del === true)
                {
                    $result['cart'] = true;

                    // Кол-во товаров в корзине
                    $cart_products = $this->Store_model->getCartCountProducts($this->user_id);

                    parent::updateSessionCart($cart_products);

                    $result['cart_count'] = (!empty($this->session->cart)) ? $this->session->cart : 0;
                }
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Выборка товаров с учетом сортировки
     *
     * @return void
     */
    public function getSortProducts()
    {
        $sort           = $this->input->post('sort', true) and is_numeric($this->input->post('sort', true))
            ? $this->input->post('sort', true)
            : null;
        $category_id    = $this->input->post('category_id', true) and (is_numeric($this->input->post('category_id', true)) or $this->input->post('category_id', true) == 'courses')
            ? $this->input->post('category_id', true)
            : null;
        $subcategory_id = $this->input->post('subcategory_id', true) and is_numeric($this->input->post('subcategory_id', true))
            ? $this->input->post('subcategory_id', true)
            : null;
        $search = $this->input->post('search', true) 
            ? mb_substr(strip_tags($this->input->post('search', true)), 0, 255)
            : null;
        $first_id = $this->input->post('first_id', true) and is_numeric($this->input->post('first_id', true))
            ? $this->input->post('first_id', true)
            : null;
        $first_price = $this->input->post('first_price', true) and is_numeric($this->input->post('first_price_id', true))
            ? $this->input->post('first_price', true)
            : null;
        $first_discount = $this->input->post('first_discount', true) and is_numeric($this->input->post('first_discount', true))
            ? $this->input->post('first_discount', true)
            : null;
        $last_id = $this->input->post('last_id', true) and is_numeric($this->input->post('last_id', true))
            ? $this->input->post('last_id', true)
            : null;
        $last_price = $this->input->post('last_price', true) and is_numeric($this->input->post('last_price', true))
            ? $this->input->post('last_price', true)
            : null;
        $last_discount = $this->input->post('last_discount', true) and is_numeric($this->input->post('last_discount', true))
            ? $this->input->post('last_discount', true)
            : null;
        $result['products']   = '';
        $result['pagination'] = '';
        $result['sql']        = '';
        $result['sql_result'] = '';

        $result_products = $this->Store_model->getStoreProducts($category_id, $subcategory_id, $sort, $search, 9, $first_id,
            $first_price, $first_discount, $last_id, $last_price, $last_discount);

        if (!empty($result_products['products'])) {
            $category_path = !empty($category_id) ? '/' . $category_id : '';
            //$category_path .= !empty($subcategory_id) ? '/' . $subcategory_id : '';
            $path = '/store'.$category_path.'/product/';

            foreach ($result_products['products'][$category_id] as $product) {
                $discount = (!empty($product['discount_price']) or !empty($product['discount_fc_price'])) ? 'shop_tov_promo' : '';
                $bonus    = (!empty($product['attached']) or !empty($product['attached'])) ? 'shop_tov_bonus' : '';
                $label    = (empty($bonus)) ? $discount: $bonus;

                $result['products'] .= '<div class="shop_tovs_wrap">';
                    ob_start();
                    include('./app_fold/views/store/product/store_product_item.php');
                    $product_item = ob_get_contents();
                    ob_end_clean();
                    $result['products'] .= $product_item;
                $result['products'] .= '</div>';

            }
            unset($product);
            $first_id       = !empty($result_products['first_id']) ? $result_products['first_id'] : '';
            $first_price    = !empty($result_products['first_price']) ? $result_products['first_price'] : '';
            $first_discount = !empty($result_products['first_discount']) ? $result_products['first_discount'] : '';
            $last_id        = !empty($result_products['last_id']) ? $result_products['last_id'] : '';
            $last_price     = !empty($result_products['last_price']) ? $result_products['last_price'] : '';
            $last_discount  = !empty($result_products['last_discount']) ? $result_products['last_discount'] : '';

            ob_start();
                include_once('./app_fold/views/pagination.php');
                $pagination = ob_get_contents();
            ob_end_clean();

            $result['pagination'] = $pagination;
        } else {
            $result['products'] = "false";
        }
        
        //echo $result;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX поиск товаров
     *
     * @return void
     */
    public function searchProduct()
    {
        $search       = $this->input->post('product', true);
        $product_id   = is_numeric($search) ? mb_substr($search, 0, 10) : null;
        $product_name = (empty($product_id) and (mb_strlen($search) >= 3)) ? mb_substr($search, 0, 255) : null;

        $result['products'] = '';

        if (!empty($product_id) or !empty($product_name)) {
            $product_result = $this->Store_model->searchProducts($product_id, $product_name);
            
            if (!empty($product_result)) {
                foreach ($product_result['products'] as $product) {
                    $result['products'] .= '<div class="add_tov_item parent" id="'.$product['id'].'">
                        <div class="add_tov_img"><img src="'.$product['image'].'" alt=""></div>
                        <a href="/store/product/'.$product['id'].'" class="add_tov_cont">
                            <div class="add_tov_h">'.$product['name'].'</div>
                            <div class="add_tov_price">'.$product['price'].' руб</div>
                        </a>
                        <input type="hidden" value="'.$product['id'].'" name="product_id" id="res-product-id"/>
                        <input type="hidden" value="'.$product['name'].'" name="product_name" id="res-product-name"/>
                        <input type="hidden" value="'.$product['price'].'" name="product_price" id="res-product-price"/>
                    </div>';
                }
                unset($row);

            } else {
                $result['products'] = false;
            }
        } else {
            $result['products'] = false;
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Выборка товаров для АП
     *
     * @return void
     */
    public function getSearchProducts()
    {
        $first_id = $this->input->post('first_id', true) and is_numeric($this->input->post('first_id', true))
            ? $this->input->post('first_id', true)
            : null;
        $first_price = $this->input->post('first_price', true) and is_numeric($this->input->post('first_price_id', true))
            ? $this->input->post('first_price', true)
            : null;
        $first_discount = $this->input->post('first_discount', true) and is_numeric($this->input->post('first_discount', true))
            ? $this->input->post('first_discount', true)
            : null;
        $last_id = $this->input->post('last_id', true) and is_numeric($this->input->post('last_id', true))
            ? $this->input->post('last_id', true)
            : null;
        $last_price = $this->input->post('last_price', true) and is_numeric($this->input->post('last_price', true))
            ? $this->input->post('last_price', true)
            : null;
        $last_discount = $this->input->post('last_discount', true) and is_numeric($this->input->post('last_discount', true))
            ? $this->input->post('last_discount', true)
            : null;
        $result['products']   = '';
        $result['pagination'] = '';
        $result['sql']        = '';
        $result['sql_result'] = '';

        $result_products = $this->Store_model->getProducts($first_id, $first_price, $first_discount, $last_id, $last_price, $last_discount);

        $result['sql']        = $result_products['sql'];
        $result['sql_result'] = $result_products['sql_result'];

        if (!empty($result_products['products'])) {
            $path = '/store/product/';

            foreach ($result_products['products'] as $product) {
                $discount = (!empty($product['discount_price']) or !empty($product['discount_fc_price'])) ? 'Скидка' : '';
                $bonus    = (!empty($product['attached']) or !empty($product['attached'])) ? 'Акция' : '';
                $label    = (empty($bonus)) ? $discount: $bonus;

                ob_start();
                include('./app_fold/views/store/product/product_item.php');
                $product_item = ob_get_contents();
                ob_end_clean();
                $result['products'] .= $product_item;

            }
            unset($product);
            $first_id       = !empty($result_products['first_id']) ? $result_products['first_id'] : '';
            $first_price    = !empty($result_products['first_price']) ? $result_products['first_price'] : '';
            $first_discount = !empty($result_products['first_discount']) ? $result_products['first_discount'] : '';
            $last_id        = !empty($result_products['last_id']) ? $result_products['last_id'] : '';
            $last_price     = !empty($result_products['last_price']) ? $result_products['last_price'] : '';
            $last_discount  = !empty($result_products['last_discount']) ? $result_products['last_discount'] : '';

            ob_start();
            include_once('./app_fold/views/pagination.php');
            $pagination = ob_get_contents();
            ob_end_clean();

            $result['pagination'] = $pagination;
        } else {
            $result['products'] = "false";
        }

        //echo $result;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
}