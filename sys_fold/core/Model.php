<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		log_message('info', 'Model Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

    /**
     * Добавление окончания (лет, пропущенное занятие, клиентов) к возрасту, стажу, пропущенным занятиям или кол-ву клиентов
     *
     * @param int $count Кол-во лет
     * @param string $ending_singular Вариант для единственного числа
     * @param string $ending_plural Вариант для множественного числа
     * @param string|null $ending_24 Вариант для промеждука между 2 и 4 (пр. 1 год, 2 года - 4 года, 5 лет)
     * @return string
     */
	public function endingWords($count, $ending_singular, $ending_plural, $ending_24 = null)
    {
        if (($count - $count % 10) % 100 != 10){
            if ($count % 10 == 1){
                $output = $count . ' ' . $ending_singular;
            }else if ($count % 10 >= 2 && $count % 10 <= 4 && !empty($ending_24)){
                $output = $count . ' ' . $ending_24;
            }else{
                $output = $count . ' ' . $ending_plural;
            }
        }else{
            $output = $count . ' ' . $ending_plural;
        }

        return $output;
    }

    /**
     * Форматирование текста BBCode
     *
     * @param $text
     * @return mixed
     */
    public function showBBcodes($text)
    {
        // BBcode array
        $find = array(
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
        );
        // HTML tags to replace BBcode
        $replace = array(
            '<b>$1</b>',
            '<i>$1</i>',
            '<span style="text-decoration:underline;">$1</span>',
            '<pre>$1</'.'pre>',
            '<span style="font-size:$1px;">$2</span>',
            '<span style="color:$1;">$2</span>',
            '<a href="$1">$1</a>',
            '<img src="$1" alt="" />'
        );
        // Replacing the BBcodes with corresponding HTML tags
        return preg_replace($find,$replace,$text);
    }

    /**
     * Запись ошибок запросов к БД
     *
     * @param string $method
     * @param array $params
     */
    public function logDbMessages($method, $params = array())
    {
        $error = $this->db->error();

        if (!empty($error))
        {
            $method = $_SERVER['REQUEST_URI'] . '<br/>' . $method;
            log_message('error', $method . ' [' . $error['code'] . '] ' . $error['message'] . ' ' . $this->db->last_query() . ' Params: '. print_r($params, true));
        }
    }

    /**
     * Склонение месяцев
     *
     * @param $month_id
     * @return string
     */
    public function declensionRussianMonths($month_id)
    {
        $m = '';

        switch ($month_id){
            case 1: $m='января'; break;
            case 2: $m='февраля'; break;
            case 3: $m='марта'; break;
            case 4: $m='апреля'; break;
            case 5: $m='мая'; break;
            case 6: $m='июня'; break;
            case 7: $m='июля'; break;
            case 8: $m='августа'; break;
            case 9: $m='сентября'; break;
            case 10: $m='октября'; break;
            case 11: $m='ноября'; break;
            case 12: $m='декабря'; break;
        }

        return $m;
    }

    /**
     * Склонение месяцев
     *
     * @param $weekday
     * @return string
     */
    public function RussianWeekday($weekday)
    {
        $m = '';

        switch ($weekday){
            case 'Mon': $m='пон'; break;
            case 'Tue': $m='вт'; break;
            case 'Wed': $m='ср'; break;
            case 'Thu': $m='чт'; break;
            case 'Fri': $m='пт'; break;
            case 'Sat': $m='сб'; break;
            case 'Sun': $m='вс'; break;
            case 'Monday': $m='понедельник'; break;
            case 'Tuesday': $m='вторник'; break;
            case 'Wednesday': $m='среда'; break;
            case 'Thursday': $m='четверг'; break;
            case 'Friday': $m='пятница'; break;
            case 'Saturday': $m='суббота'; break;
            case 'Sunday': $m='воскресенье'; break;
        }

        return $m;
    }

    /**
     * Обработка данных пагинации
     *
     * @param $row_type
     * @param $first_id
     * @param $last_id
     * @param $limit
     * @param $elements
     * @return array
     */
    public function parsePagination($row_type, $first_id, $last_id, $limit, $elements)
    {
        $result = array('pagination' => array());
        $next_page = false;
        $prev_page = false;

        $count_rows = count($elements);

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

        foreach($elements as $key => $row)
        {
            // Данные последнего элемента страницы
            if ($next_page === true and $key == ($count_rows-1))
            {
                // Последний элемент страницы
                if($row_type == 'shop')
                {
                    $result['pagination']['last_id']       = $row->p_id;
                    $result['pagination']['last_price']    = $row->p_price;
                    $result['pagination']['last_fc_price'] = $row->p_fitcoin_price;
                    $result['pagination']['last_discount'] = $row->p_discount;
                }
                elseif($row_type == 'course')
                {
                    $result['pagination']['last_id'] = $row->crs_id;
                }
            }
            // Данные первого элемента страницы
            if ($prev_page === true and $key == 0)
            {
                // Последний элемент страницы
                if($row_type == 'shop') {
                    $result['pagination']['first_id']       = $row->p_id;
                    $result['pagination']['first_price']    = $row->p_price;
                    $result['pagination']['first_fc_price'] = $row->p_fitcoin_price;
                    $result['pagination']['first_discount'] = $row->p_discount;
                }
                elseif($row_type == 'course')
                {
                    $result['pagination']['first_id'] = $row->crs_id;
                }
            }
        }

        $result['elements'] = $elements;

        return $result;
    }
}
