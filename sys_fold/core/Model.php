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
            log_message('error', $method . ' [' . $error['code'] . '] ' . $error['message'] . ' ' . $this->db->last_query() . ' Params: '. print_r($params, true));
        }
    }
}
