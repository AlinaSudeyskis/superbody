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

require("./app_fold/third_party/sendpulse-rest-api-php/src/ApiInterface.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/ApiClient.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/Storage/TokenStorageInterface.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/Storage/FileStorage.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/Storage/SessionStorage.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/Storage/MemcachedStorage.php");
require("./app_fold/third_party/sendpulse-rest-api-php/src/Storage/MemcacheStorage.php");

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

// API credentials from https://login.sendpulse.com/settings/#api
define('API_USER_ID', '1fffbf089fbc738f9e2e2a29006f83b6');
define('API_SECRET', '028b7e8fd03b4e638fd33ad50726c117');
define('PATH_TO_ATTACH_FILE', __FILE__);

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;
	
	/**
	 * @var object Текущая дата и время
	 */
	public $date;

	/**
	 * @var array Список ошибок
	 */
	public $list_errors;
    
    /**
     * @var string $page_message Сообщения о результатах действиях пользователя
     */
    public $page_message;
    public $page_message_type;

    /**
     * @var int ID пользователя
     */
    public $user_id = null;

    /**
     * @var array Данные страницы
     */
    public $page_data;

    /**
     * @var string URL страницы
     */
    public $page_url;

    /**
     * @var array URL доступные для переадресации
     */
    public $return_urls = array('/settings', '/course/', '/profile');

    /**
     * @var string Код страны пользователя
     */
    public $country_code = '';
    public $user_timezone = '';

    /**
     * @var array Коды стран
     */
    public $countries_codes = array(
        "AU" => "+61",
        "AT" => "+43",
        "AZ" => "+994",
        "AL" => "+355",
        "DZ" => "+213",
        "VI" => "+1",
        "AI" => "+1",
        "AO" => "+244",
        "AD" => "+376",
        "AG" => "+1",
        "AR" => "+54",
        "AM" => "+374",
        "AW" => "+297",
        "AF" => "+93",
        "BS" => "+1",
        "BD" => "+880",
        "BB" => "+1",
        "BH" => "+973",
        "BY" => "+375",
        "BZ" => "+501",
        "BE" => "+32",
        "BJ" => "+229",
        "BM" => "+1",
        "BG" => "+359",
        "BO" => "+591",
        "BQ" => "+599",
        "BA" => "+387",
        "BW" => "+267",
        "BR" => "+55",
        "IO" => "+246",
        "VG" => "+1",
        "BN" => "+673",
        "BF" => "+226",
        "BI" => "+257",
        "BT" => "+975",
        "VU" => "+678",
        "HU" => "+36",
        "VE" => "+58",
        "AS" => "+1",
        "TL" => "+670",
        "VN" => "+84",
        "GA" => "+241",
        "HT" => "+509",
        "GY" => "+592",
        "GM" => "+220",
        "GH" => "+233",
        "GP" => "+590",
        "GT" => "+502",
        "GN" => "+224",
        "GW" => "+245",
        "DE" => "+49",
        "GG" => "+44",
        "GI" => "+350",
        "HN" => "+504",
        "HK" => "+852",
        "VA" => "+39",
        "GD" => "+1",
        "GL" => "+299",
        "GR" => "+30",
        "GE" => "+995",
        "GU" => "+1",
        "DK" => "+45",
        "CD" => "+243",
        "JE" => "+44",
        "DJ" => "+253",
        "DO" => "+1",
        "DM" => "+1",
        "EG" => "+20",
        "ZM" => "+260",
        "EH" => "+212",
        "ZW" => "+263",
        "IL" => "+972",
        "IN" => "+91",
        "ID" => "+62",
        "JO" => "+962",
        "IQ" => "+964",
        "IR" => "+98",
        "IE" => "+353",
        "IS" => "+354",
        "ES" => "+34",
        "IT" => "+39",
        "YE" => "+967",
        "CV" => "+238",
        "KZ" => "+7",
        "KY" => "+1",
        "KH" => "+855",
        "CM" => "+237",
        "CA" => "+1",
        "QA" => "+974",
        "KE" => "+254",
        "CY" => "+357",
        "KG" => "+996",
        "KI" => "+686",
        "CN" => "+86",
        "CO" => "+57",
        "KM" => "+269",
        "XK" => "+381",
        "CR" => "+506",
        "CI" => "+225",
        "CU" => "+53",
        "KW" => "+965",
        "CW" => "+599",
        "LA" => "+856",
        "LV" => "+371",
        "LS" => "+266",
        "LR" => "+231",
        "LB" => "+961",
        "LY" => "+218",
        "LT" => "+370",
        "LI" => "+423",
        "LU" => "+352",
        "MU" => "+230",
        "MR" => "+222",
        "MG" => "+261",
        "YT" => "+262",
        "MO" => "+853",
        "MK" => "+389",
        "MW" => "+265",
        "MY" => "+60",
        "ML" => "+223",
        "MV" => "+960",
        "MT" => "+356",
        "MQ" => "+596",
        "MH" => "+692",
        "MX" => "+52",
        "MZ" => "+258",
        "MD" => "+373",
        "MC" => "+377",
        "MN" => "+976",
        "MS" => "+1",
        "MA" => "+212",
        "MM" => "+95",
        "NA" => "+264",
        "NR" => "+674",
        "NP" => "+977",
        "NE" => "+227",
        "NG" => "+234",
        "NL" => "+31",
        "NI" => "+505",
        "NU" => "+683",
        "NZ" => "+64",
        "NC" => "+687",
        "NO" => "+47",
        "AE" => "+971",
        "OM" => "+968",
        "IM" => "+44",
        "NF" => "+672",
        "SH" => "+290",
        "CK" => "+682",
        "TC" => "+1",
        "PK" => "+92",
        "PW" => "+680",
        "PS" => "+970",
        "PA" => "+507",
        "PG" => "+675",
        "PY" => "+595",
        "PE" => "+51",
        "PL" => "+48",
        "PT" => "+351",
        "PR" => "+1",
        "CG" => "+242",
        "RE" => "+262",
        "RU" => "+7",
        "RW" => "+250",
        "RO" => "+40",
        "SV" => "+503",
        "WS" => "+685",
        "SM" => "+378",
        "ST" => "+239",
        "SA" => "+966",
        "SZ" => "+268",
        "KP" => "+850",
        "MP" => "+1",
        "SC" => "+248",
        "BL" => "+590",
        "VC" => "+1",
        "MF" => "+590",
        "PM" => "+508",
        "SN" => "+221",
        "KN" => "+1",
        "LC" => "+1",
        "SX" => "+599",
        "RS" => "+381",
        "SG" => "+65",
        "SY" => "+963",
        "SK" => "+421",
        "SI" => "+386",
        "GB" => "+44",
        "SB" => "+677",
        "SO" => "+252",
        "SD" => "+249",
        "SR" => "+597",
        "US" => "+1",
        "SL" => "+232",
        "TJ" => "+992",
        "TH" => "+66",
        "TW" => "+886",
        "TZ" => "+255",
        "TG" => "+228",
        "TK" => "+690",
        "TO" => "+676",
        "TT" => "+1",
        "TV" => "+688",
        "TN" => "+216",
        "TM" => "+993",
        "TR" => "+90",
        "UG" => "+256",
        "UZ" => "+998",
        "UA" => "+380",
        "WF" => "+681",
        "UY" => "+598",
        "FO" => "+298",
        "FM" => "+691",
        "FJ" => "+679",
        "PH" => "+63",
        "FI" => "+358",
        "FK" => "+500",
        "FR" => "+33",
        "GF" => "+594",
        "PF" => "+689",
        "HR" => "+385",
        "CF" => "+236",
        "TD" => "+235",
        "ME" => "+382",
        "CZ" => "+420",
        "CL" => "+56",
        "CH" => "+41",
        "SE" => "+46",
        "LK" => "+94",
        "EC" => "+593",
        "GQ" => "+240",
        "ER" => "+291",
        "EE" => "+372",
        "ET" => "+251",
        "ZA" => "+27",
        "KR" => "+82",
        "SS" => "+211",
        "JM" => "+1",
        "JP" => "+81"
    );

    /**
     * @var array Коды стран
     */
    public $genitive_months = array( 1 => 'Января' , 'Февраля' , 'Марта' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		
        // echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
        date_default_timezone_set('UTC');
		$this->date = date("Y-m-d H:i:s");

		$this->page_url = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $this->load->model('Welcome_model');
        $this->load->model('Course_model');
        $this->load->model('Notification_model');

        $admin_new_fbs    = null;
        $admin_new_orders = null;
        //$urls = array('/administration/update/database');
        //log_message('debug',  date('U'));

		// Проверка данных авторизованного пользователя
        if (!empty($this->session->user) and is_numeric($this->session->user['id']) and
            (empty($this->session->user['email']) or filter_var($this->session->user['email'], FILTER_VALIDATE_EMAIL)))
        {
            $this->load->model('Message_model');
            $this->load->model('User_model');
            $this->load->model('Store_model');

            // Проверка авторизации пользователя (social)
            self::checkUserSession();

            $user = $this->User_model->getUser($this->session->user['id']);

            // Если пользователь не найден в БД, завершить сессию
            if(empty($user['user_data']))
            {
                header('Location: /logout');
            }

            // Уничтожение сессии, для повтороной авторизации, если дата авторизации меньше метки,
            // заданной для обновления сессий пользователя
            $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $this->session->user['date_auth']);
            $u_date = ($tmp_date !== false) ? $tmp_date->format('U') : null;
            if ($u_date < '1602078554')
            {
                header('Location: /logout');
            }

            // ID пользователя
            $this->user_id = $this->session->user['id'];
            // Проверка новых сообщений
            $new_messages    = $this->Message_model->getCountNewMessages($this->user_id);
            $new_fb_messages = $this->Message_model->getCountNewFeedbackMessages($this->user_id, $this->session->user['email']);

            if ($new_messages != $this->session->new_messages) {
                $this->session->set_userdata("new_messages", $new_messages);
            }
            if ($new_fb_messages != $this->session->new_fb_messages) {
                $this->session->set_userdata("new_fb_messages", $new_fb_messages);
            }

            // Кол-во новых сообщений обратной связи и новых заказов, требущих обработки
            if($this->session->user['type'] == 3)
            {
                $admin_new_fbs    = $this->Message_model->getAdminCountNewFeedbackMessages();
                $admin_new_orders = $this->Store_model->getAdminCountWaitingOrders();
            }

            // Сверка данных пользователя
            $user_data = $this->User_model->getUserSettingsData($this->user_id);

            // Сверка данных коризны
            $cart_data = $this->Store_model->getCartCountProducts($this->user_id);

            // Обновление данных сессии
            $user_session_data = array(
                'user' => $this->session->user,
                'cart' => array(
                    'count' => $cart_data,
                    'products' => $this->session->cart['products'],
                ));

            $user_session_data['user']['email']       = $user_data['user_data']['user_email'];
            $user_session_data['user']['name']        = $user_data['user_data']['user_name'];
            $user_session_data['user']['phone']       = $user_data['user_data']['user_phone'];
            $user_session_data['user']['image']       = $user_data['user_data']['user_image'];
            $user_session_data['user']['type']        = $user_data['user_data']['user_type'];
            $user_session_data['user']['advertising'] = $user_data['user_data']['user_advertising'];
            $user_session_data['user']['blocked']     = $user_data['user_data']['user_blocked'];
            $user_session_data['user']['subscribed']  = $user_data['user_data']['user_subscribed'];
            $user_session_data['user']['activated']   = $user_data['user_data']['user_activated'];
            $user_session_data['user']['date_auth']   = $this->date;

            $this->session->set_userdata($user_session_data);
            // Проверка существования изображения пользователя
            /*if (!is_file('.'.$this->session->user['image'])) {
                $user_data = array('user' => $this->session->user);
                $user_data['user']['image'] = '';
                $this->session->set_userdata($user_data);
            }*/

            // Обновление данных курса
            /*if (empty($this->session->user['date_update_course']) or $this->date > $this->session->user['date_update_course']) {
                $this->load->model('Course_model');
                $this->Course_model->updateUserCourseData($this->user_id, $this->date);
            }*/
        }
        elseif(!empty($this->session->user) and
            (!is_numeric($this->session->user['id']) or (!empty($this->session->user['email']) and
                    !filter_var($this->session->user['email'], FILTER_VALIDATE_EMAIL))))
        {
            $this->session->sess_destroy();
        }

        // Проверка кода страны пользователя
        if(empty($this->session->country_code) or empty($this->session->user_timezone))
        {
            $client        = (!empty($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : null;
            $forward       = (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
            $remote        = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : null;

            if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
            elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
            else $ip = $remote;

            $ip_data = (!empty($ip)) ? json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip)) : null;

            if($ip_data)
            {
                if(empty($this->session->country_code))
                {
                    $this->country_code = $ip_data->geoplugin_countryCode;
                    $user_data['country_code'] = $ip_data->geoplugin_countryCode;
                }
                else
                {
                    $this->country_code = $this->session->country_code;
                }

                if(empty($this->session->user_timezone))
                {
                    $this->user_timezone = $ip_data->geoplugin_timezone;
                    $user_data['user_timezone'] = $ip_data->geoplugin_timezone;
                }
                else
                {
                    $this->user_timezone = $this->session->user_timezone;
                }

                //log_message('debug', print_r($ip_data, true));
                if(!empty($user_data))
                {
                    $this->session->set_userdata($user_data);
                }
            }
        }
        else
        {
            $this->country_code = $this->session->country_code;
            $this->user_timezone = $this->session->user_timezone;
        }

		$this->list_errors = $this->Notification_model->getListNotifications();

        // Сообщение о результатах действий пользователя
        if (!empty($this->session->tempdata('message')))
        {
            $this->page_message = (is_numeric($this->session->tempdata('message'))) ? $this->list_errors['text'][$this->session->tempdata('message')] : $this->session->tempdata('message');
            $this->page_message_type = (is_numeric($this->session->tempdata('message'))) ? $this->list_errors['type'][$this->session->tempdata('message')] : 'error';

            // Удаление значения сообщения
            $this->session->unset_tempdata('message');
        }

        // Список доступных пользователю курсов
        //$courses = $this->Course_model->getAvailableCourses();
        // Список доступных пользователю категорий курсов
        $courses = $this->Course_model->getAvailableCourseTypes();

        // Данные сайта (контактные данные, о нас, соц. сети и т.д.)
        $site_info = $this->Welcome_model->getSiteInfo();

        // Данные сайта (контактные данные, о нас, соц. сети и т.д.)
        $site_metadata = $this->Welcome_model->getSiteMetaData();

        // Данные страницы
        $this->page_data = array(
            "title" => '',
            "keywords" => '',
            "description" => '',
            "site_info" => (!empty($site_info)) ? $site_info : '',
            "metadata" => (!empty($site_metadata)) ? $site_metadata : '',
            "user_session" => (!empty($this->session->user)) ? $this->session->user : '',
            "new_messages" => (!empty($this->session->new_messages)) ? $this->session->new_messages : 0,
            "new_fb_messages" => (!empty($this->session->new_fb_messages)) ? $this->session->new_fb_messages : 0,
            "user_subscribed" => (!empty($this->session->user['subscribed']) and $this->session->user['subscribed'] === true) ? true : false,
            "cart_count" => (!empty($this->session->cart['count'])) ? $this->session->cart['count'] : 0,
            "message" => $this->page_message,
            "message_type" => $this->page_message_type,
            "page_menu" => '',
            "page_submenu" => '',
            "outsider" => false,
            "menu_courses" => $courses,
            "country_code" => $this->country_code,
            "user_timezone" => $this->user_timezone,
            "user_notification" => array(),
            "e_new_messages" => $admin_new_fbs,
            "e_new_orders" => $admin_new_orders
        );
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

    /**
     * Сохранение изображения на сервер
     *
     * @param string $file_tmp Имя поля input[type=file] 
     * @param string $file_type Тип файла
     * @param string $path Путь к файлу
     * @return string Полный путь файла
     */
    public function uploadImage($file_tmp, $file_type, $path)
	{
        $valid_type = array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif');

        if (in_array($file_type, $valid_type)){
            $img_type = array_search($file_type, $valid_type); // Расширение файла
            $md5_time = md5(time());
            $md5_name = substr($md5_time, 0, 10); // Новое имя для файла

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|png|gif';
            $config['max_size']	= '30720';
            $config['file_name'] = $md5_name;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($file_tmp)){
                return $this->upload->display_errors(); // Возвращаем возникшую ошибку
            }  else{
                $data = $this->upload->data();

                return $data['file_name']; // Возвращаем полный путь файла
            }
        } else{
            return 'Не корректный тип файла'; // Возвращаем ошибку
        }
    }

    /**
     * Сохранение файла на сервер
     *
     * @param string $file_tmp Имя поля input[type=file]
     * @param string $file_type Тип файла
     * @param string $path Путь к файлу
     * @return string Полный путь файла
     */
    public function uploadFile($file_tmp, $file_type, $path)
	{
        $md5_time = md5(time());
        $md5_name = substr($md5_time, 0, 10); // Новое имя для файла

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xls';
        $config['max_size']	= '2048';
        $config['file_name'] = $md5_name;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($file_tmp)){
            return $this->upload->display_errors(); // Возвращаем возникшую ошибку
        }  else{
            $data = $this->upload->data();

            return $data['file_name']; // Возвращаем полный путь файла
        }
    }

    /**
     * Сохранение видео на сервер
     *
     * @param string $file_tmp Имя поля input[type=file]
     * @param string $file_type Тип файла
     * @param string $path Путь к файлу
     * @return string Полный путь файла
     */
    public function uploadVideoFile($file_tmp, $file_type, $path)
	{
        $valid_type = array('mp4' => 'video/mp4');

        if (in_array($file_type, $valid_type)){
            $img_type = array_search($file_type, $valid_type); // Расширение файла
            $md5_time = md5(time());
            $md5_name = substr($md5_time, 0, 10); // Новое имя для файла

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'mp4';
            $config['max_size']	= '1048576';
            $config['file_name'] = $md5_name;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($file_tmp)){
                return $this->upload->display_errors(); // Возвращаем возникшую ошибку
            }  else{
                $data = $this->upload->data();

                return $data['file_name']; // Возвращаем полный путь файла
            }
        } else{
            return 'Не корректный тип файла'; // Возвращаем ошибку
        }
    }

    /**
     * Обновление/создание сессии пользователя
     *
     * @param $user_data
     * @param $access_token
     * @param $user_soc_via
     * @param $user_soc_id
     * @param $date
     * @param null $login_from
     */
    public function updateSession($user_data, $access_token, $user_soc_via, $user_soc_id, $date, $login_from = null)
    {
        //log_message('debug', __METHOD__.':'.__LINE__.' '. print_r($user_data, true));
        $user_id            = $user_data['user_id'];
        $user_email         = $user_data['user_email'];
        $user_type          = $user_data['user_type'];
        $user_advertising   = $user_data['user_advertising'];
        $user_premium_order = $user_data['user_premium_order'];
        $user_name          = $user_data['user_name'];
        $user_blocked       = $user_data['user_blocked'];
        $user_activated     = $user_data['user_activated'];
        $user_timezone      = $user_data['user_timezone'];
        $user_phone         = $user_data['user_phone'];
        $user_image         = $user_data['user_images'];

        $split_name = mb_split(' ', $user_name);
        $s_name     = !empty($split_name[0]) ? $split_name[0] : '';
        $s_surname  = !empty($split_name[1]) ? $split_name[1] : '';

        // Обновление данных сессии, если она пренадлежит ему
        if (!empty($this->session->user) and $this->session->user['id'] == $user_id)
        {
            $user_data['user'] = $this->session->user;

            $user_data['user']['blocked']      = $user_blocked;
            $user_data['user']['activated']    = $user_activated;
            $user_data['user']['access_token'] = $access_token;
            $user_data['user']['date_auth']    = $date;
            $user_data['user_timezone']        = $user_timezone;

            $this->session->set_userdata($user_data);
        }
        else
        {
            // Создание сессии
            self::createUserSession($user_id, $user_email, $user_type, $user_advertising, $user_premium_order, $user_blocked, $user_activated, $user_name, $s_name,
                $s_surname, $user_timezone, $user_phone, $user_image, $access_token, $user_soc_via, $user_soc_id, $date, $login_from);
        }
    }

    /**
     * Создание сессии пользователя
     *
     * @param $user_id
     * @param $user_email
     * @param $user_type
     * @param $user_advertising
     * @param $user_premium_order
     * @param $user_blocked
     * @param $user_activated
     * @param $user_name
     * @param $s_name
     * @param $s_surname
     * @param $user_timezone
     * @param $user_phone
     * @param $user_image
     * @param $access_token
     * @param $user_soc_via
     * @param $user_soc_id
     * @param $date
     * @param null $login_from
     */
    protected function createUserSession($user_id, $user_email, $user_type, $user_advertising, $user_premium_order, $user_blocked, $user_activated, $user_name,
                                         $s_name, $s_surname, $user_timezone, $user_phone, $user_image, $access_token, $user_soc_via,
                                         $user_soc_id, $date, $login_from = null)
    {
        $cart_count = (!empty($this->session->cart['count']) and is_numeric($this->session->cart['count']) and $this->session->cart['count'] > 0) ? $this->session->cart['count'] : 0;
        $cart_products = (!empty($this->session->cart['products']) and is_array($this->session->cart['products'])) ? $this->session->cart['products'] : array();

        if (!empty($cart_products))
        {
            $this->load->model('Store_model');
            $this->Store_model->setSessionCartToDB($user_id, $cart_products, $this->date);
        }

        $user_data = array (
            "user" => array (
                "id" => $user_id,
                "email" => $user_email,
                "name" => $user_name,
                "s_name" => $s_name,
                "s_surname" => $s_surname,
                "phone" => $user_phone,
                "type" => $user_type,
                "advertising" => $user_advertising,
                "premium_order" => $user_premium_order,
                "blocked" => $user_blocked,
                "activated" => $user_activated,
                "image" => $user_image,
                "access_token" => $access_token,
                "auth_via" => $user_soc_via,
                "social_id" => $user_soc_id,
                "date_auth" => $date
            ),
            "new_messages" => 0,
            "new_fb_messages" => 0,
            "cart" => array(
                "count" => $cart_count,
                "products" => array()
            ),
            "user_timezone" => $user_timezone
        );

        if(!empty($login_from) and is_numeric($login_from))
        {
            $user_data['user']['login_from'] = $login_from;
        }

        $this->session->set_userdata($user_data);
    }

    /**
     * Проверка данных сессии пользователя, авторизованного при помощи соц. сетей
     */
    protected function checkUserSession()
    {
        // Если пользователь авторизован при помощи соц. сетей
        if ($this->session->user['auth_via'] != 'native')
        {
            $this->load->model('Authorization_model');
            $access_token = $this->session->user['access_token'];
            $user_soc_id  = $this->session->user['social_id'];
            $auth_via     = $this->session->user['auth_via'];

            // Проверяем не отзывал ли пользователь своё разрешение на использование его данных
            if ($auth_via == 'vk.com')
            {
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.vk.com/method/users.get',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('user_ids' => $user_soc_id, 'access_token' => $access_token,
                        'fields' => 'id,first_name,last_name,screen_name,sex,bdate,photo_200'))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $resp_info = json_decode($response);

                if (empty($resp_info->response))
                {
                    header('Location: /logout');
                }
            }
            elseif ($auth_via == 'instagram.com')
            {

                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.instagram.com/v1/users/self/?access_token='.$access_token,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $resp_info = json_decode($response);

                if (empty($resp_info->data->id))
                {
                    header('Location: /logout');
                }
            }
            elseif ($auth_via == 'facebook.com')
            {
                $client_secret = 'c4730a166b67b5c5404fccabd7d3ae00';
                $appsecret_proof = hash_hmac('sha256', $access_token, $client_secret);

                // Получение данный пользователя
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://graph.facebook.com/me',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('access_token' => $access_token,
                        'appsecret_proof' => $appsecret_proof, 'fields' => 'id,name,email'))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $resp_info = json_decode($response);

                if (empty($resp_info->id))
                {
                    header('Location: /logout');
                }
            }
            elseif ($auth_via == 'ok.ru')
            {
                $app_key       = 'CBAQKKPLEBABABABA';
                $client_secret = '7A370FC2FF713947EAAF9654';

                $secret_key = md5($access_token . $client_secret);
                $sig = md5('application_key=CBAQKKPLEBABABABAformat=jsonmethod=users.getCurrentUser' . $secret_key);

                // Получаем данные пользователя
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.ok.ru/fb.do',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('application_key' => $app_key, 'format' => 'json',
                        'method' => 'users.getCurrentUser', 'sig' => $sig, 'access_token' => $access_token))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);

                $resp_info = json_decode($response);

                if (empty($resp_info->uid))
                {
                    header('Location: /logout');
                }
            }
        }
    }

    /**
     * Обновление количества товаров корзины в данных сессии пользователя
     *
     * @param $count_products
     */
    protected function updateSessionCart($count_products)
    {
        // Если кол-во товаров в корзине изменено, обновляем данные сессии
        if ($this->session->cart['count'] != $count_products and is_numeric($count_products))
        {
            $user_data['cart']['products'] = $this->session->cart['products'];
            $user_data['cart']['count']    = $count_products;
            $this->session->set_userdata($user_data);
        }
    }

    /**
     * Расчет и сохранение данных ИМТ и БСО
     *
     * @param $user_id
     * @param $weight
     * @throws Exception
     */
    protected function calcBmiBmr($user_id, $weight)
    {
        // Выборка данных для подсчета ИМТ и БСО
        $result_bmr  = $this->User_model->getDataForBmr($user_id);
        $db_height   = $result_bmr['height'];
        $db_weight   = $result_bmr['weight'];
        $db_gender   = $result_bmr['gender'];
        $db_birthday = $result_bmr['birthday'];
        $db_bmi      = $result_bmr['bmi'];
        $db_bmr      = $result_bmr['bmr'];

        $bmi = '';
        $bmr = '';

        // Индекс массы тела
        if (!empty($db_height) and !empty($db_weight))
        {
            $bmi = $db_weight / pow(($db_height/100), 2);
            $bmi = number_format($bmi, 2, '.', '');
        }

        // Базальная скорость обмена
        if (!empty($db_height) and !empty($db_weight) and !empty($db_birthday))
        {
            $datetime = new DateTime($db_birthday);
            $interval = $datetime->diff(new DateTime(date("d-m-Y")));
            $age = $interval->format("%Y");

            if ('female' == $db_gender)
            {
                if (30 > $bmi)
                {
                    $bmr = 655 + 9.6*$db_weight + 1.8*$db_height - 4.7*$age;
                }
                else
                {
                    $bmr = 2.4*$db_weight + 9*$db_height - 4.7*$age - 65;
                }
            }
            else
            {
                if (30 > $bmi)
                {
                    $bmr = 66.5 + 13.7*$db_weight + 5*$db_height - 6.8*$age;
                }
                else
                {
                    $bmr = 3.4*$db_weight + 15.3*$db_height - 6.8*$age - 691;
                }
            }
            $bmr = round($bmr);
        }

        // Сохранение данных В БД
        if ($db_bmi != $bmi or $db_bmr != $bmr)
        {
            $this->User_model->setBmiBmr($user_id, $bmi, $bmr, $this->date);
        }
    }

    /**
     * Вывод ошибки 404 "Страница не найдена"
     *
     * @param $page_url
     */
    public function pageNotFound($page_url)
    {
        set_status_header(404);
        log_message('error', 'Page not found (404): ' . $page_url);

        ob_start();
        $this->load->view('errors/html/error_404', $this->page_data);
        $page = ob_get_contents();
        ob_end_clean();

        exit($page);
    }

    /**
     * Данные корзины из сессии
     *
     * @return array
     */
    public function getSessionCartProductsId()
    {
        $result = array('products_id' => array());

        if (!empty($this->session->cart['products']))
        {
            $i = 0;
            foreach($this->session->cart['products'] as $product)
            {
                $result['products_id'][$i] = $product['id'];
                $i++;
            }
            unset($product);
        }

        return $result;
    }

    /**
     * Сохранение/обновление данных товара в корзине сессии пользователя
     *
     * @param int $product_id ID товара
     * @param int $user_id ID пользователя
     * @param string $date Текущая дата
     * @param int $product_quantity Количество товара
     * @param int $cb_attached Добавлять ли в корзину прикрепленные товары
     * @return bool
     */
    public function setProductToSessionCart($product_id, $date, $product_quantity, $cb_attached = 0)
    {
        $result['add']    = false;
        $result['cart']   = 0;
        $cart             = 0;
        $new_product      = true;
        $cart_p_id        = null;
        $product_id       = is_numeric($product_id) ? $product_id : null;
        $product_quantity = is_numeric($product_quantity) ? $product_quantity : null;
        $cb_attached      = $cb_attached == 1 ? 1 : 0;
        $date             = strip_tags($date);

        $user_data['cart']['products'] = $this->session->cart['products'];

        // Проверка корзина на присутствие товара. Обновление данных
        if (!empty($this->session->cart['products']) and is_array($this->session->cart['products'])
            and !empty($product_id) and !empty($product_quantity))
        {
            foreach($this->session->cart['products'] as $key => $product)
            {
                if ($product['id'] == $product_id)
                {
                    // Обновление корзины
                    $user_data['cart']['products'][$key]['quantity'] = $product['quantity'] + $product_quantity;

                    // Обновление данных прикрепленных товаров, если пользователь дал согласие на это
                    if ($cb_attached == 1)
                    {
                        $attached_products = $this->Store_model->getAttachedProducts($product_id);
                        $cart_p_id = $key;

                        if (!empty($attached_products))
                        {
                            // Добавление в корзину
                            if($product['attached'] === false)
                            {
                                $i = 0;
                                foreach($attached_products as $attached_product)
                                {
                                    $user_data['cart']['products'][$cart_p_id]['attached'][$i]['id']       = $attached_product['id'];
                                    $user_data['cart']['products'][$cart_p_id]['attached'][$i]['quantity'] = $product_quantity;
                                    $user_data['cart']['products'][$cart_p_id]['attached'][$i]['date']     = $date;

                                    $i++;
                                }
                                unset($attached_product);
                            }
                            // Обновление данных прикрепленных товаров
                            elseif(is_array($product['attached']))
                            {
                                foreach($product['attached'] as $a_key => $attached)
                                {
                                    foreach($attached_products as $attached_product)
                                    {
                                        if ($attached['id'] == $attached_product['id'])
                                        {
                                            $user_data['cart']['products'][$cart_p_id]['attached'][$a_key]['quantity'] = $attached['quantity'] + $product_quantity;
                                        }
                                    }
                                    unset($attached_product);
                                }
                                unset($attached);
                            }
                        }
                    }

                    //log_message('debug', __METHOD__ . __LINE__ . ' Обновление товара в корзине ' . print_r($user_data, true));
                    $this->session->set_userdata($user_data);
                    $result['add'] = true;
                    $new_product   = false;

                    // Кол-во товаров в корзине
                    $cart_products = self::getSessionCartCountProducts();

                    self::updateSessionCart($cart_products);
                }
            }
            unset($products);
        }

        // Добавление товара в корзину
        if((empty($this->session->cart['products']) or $new_product === true)
            and !empty($product_id) and !empty($product_quantity))
        {
            $new_cart_p_id = (!empty($this->session->cart['products']) and count($this->session->cart['products']) > 0)
                ? (count($this->session->cart['products']) + 1)
                : 0;

            $user_data['cart']['products'][$new_cart_p_id]['id']       = $product_id;
            $user_data['cart']['products'][$new_cart_p_id]['quantity'] = $product_quantity;
            $user_data['cart']['products'][$new_cart_p_id]['attached'] = false;
            $user_data['cart']['products'][$new_cart_p_id]['date']     = $date;

            if ($cb_attached == 1)
            {
                $attached_products = $this->Store_model->getAttachedProducts($product_id);
                if (!empty($attached_products))
                {
                    $i = 0;
                    foreach($attached_products as $attached_product)
                    {
                        $user_data['cart']['products'][$new_cart_p_id]['attached'][$i]['id']       = $attached_product['id'];
                        $user_data['cart']['products'][$new_cart_p_id]['attached'][$i]['quantity'] = $product_quantity;
                        $user_data['cart']['products'][$new_cart_p_id]['attached'][$i]['date']     = $date;

                        $i++;
                    }
                    unset($attached_product);
                }
            }

            $this->session->set_userdata($user_data);
            $result['add'] = true;

            // Кол-во товаров в корзине
            $cart_products = self::getSessionCartCountProducts();

            self::updateSessionCart($cart_products);
        }

        $result['cart'] = $cart;

        return $result;
    }

    /**
     * Количество товаров в корзине сессии
     *
     * @return int
     */
    public function getSessionCartCountProducts()
    {
        $count_products = 0;

        if (!empty($this->session->cart['products']) and is_array($this->session->cart['products']))
        {
            foreach ($this->session->cart['products'] as $product)
            {
                $count_products++;

                if ($product['attached'] !== false and is_array($product['attached']))
                {
                    $count_products += count($product['attached']);
                }
            }
            unset($product);
        }

        return $count_products;
    }

    /**
     * Удаление товара из корзины сессии пользователя
     *
     * @param $product_id
     * @return bool
     */
    public function deleteSessionCartProduct($product_id)
    {
        $result = false;

        if (!empty($this->session->cart['products']) and is_array($this->session->cart['products']) and is_numeric($product_id))
        {
            $user_data['cart']['products'] = $this->session->cart['products'];

            foreach ($this->session->cart['products'] as $key => $product)
            {
                if ($key == $product_id)
                {
                    unset($user_data['cart']['products'][$key]);
                    $result = true;
                }
            }
            unset($product);

            $this->session->set_userdata($user_data);

            // Кол-во товаров в корзине
            $cart_products = self::getSessionCartCountProducts();

            self::updateSessionCart($cart_products);
        }

        return $result;
    }

    /**
     * Удаление прикрепленных товаров из корзины сессии пользователя
     *
     * @param $product_id
     * @return bool
     */
    public function detachSessionCartProduct($product_id)
    {
        $result = false;

        if (!empty($this->session->cart['products']) and is_array($this->session->cart['products']) and is_numeric($product_id))
        {
            $user_data['cart']['products'] = $this->session->cart['products'];

            foreach ($this->session->cart['products'] as $key => $product)
            {
                if ($key == $product_id and is_array($product['attached']))
                {
                    $user_data['cart']['products'][$key]['attached'] = false;
                    $result = true;
                }
            }
            unset($product);

            $this->session->set_userdata($user_data);

            // Кол-во товаров в корзине
            $cart_products = self::getSessionCartCountProducts();

            self::updateSessionCart($cart_products);
        }

        return $result;
    }

    /**
     * Обновление данных корзины сессии
     *
     * @param int $product_id
     * @param int|null $product_a_id
     * @param string $date
     * @param int $product_quantity
     * @return bool|int
     */
    public function updateSessionCartProduct($product_id, $product_a_id, $date, $product_quantity)
    {
        $result           = false;
        $product_id       = is_numeric($product_id) ? $product_id : null;
        $product_a_id     = is_numeric($product_a_id) ? $product_a_id : null;
        $product_quantity = is_numeric($product_quantity) ? $product_quantity : null;
        $date             = strip_tags($date);

        if (!empty($this->session->cart['products']) and is_array($this->session->cart['products'])
            and is_numeric($product_id) and is_numeric($product_quantity))
        {
            $user_data['cart']['products'] = $this->session->cart['products'];

            // Если товар прикреплен к другому товару, то кол-во выбранного товара не должно превышать кол-во основного
            if (is_numeric($product_a_id) and !empty($user_data['cart']['products'][$product_a_id])
                and !empty($user_data['cart']['products'][$product_a_id]['attached'][$product_id]))
            {
                $base_quantity = $user_data['cart']['products'][$product_a_id]['quantity'];

                // Сравнение с количеством основного товара
                $product_quantity = $product_quantity <= $base_quantity ? $product_quantity : $base_quantity;

                // Изменение количества текущего прикрепленного товара
                $user_data['cart']['products'][$product_a_id]['attached'][$product_id]['quantity'] = $product_quantity;

                $result = $product_quantity;

                $this->session->set_userdata($user_data);

                // Кол-во товаров в корзине
                $cart_products = self::getSessionCartCountProducts();

                self::updateSessionCart($cart_products);
            }
            // Обновить данные, если текущее значение кол-ва не совпадает с данными в сессии
            elseif (!empty($user_data['cart']['products'][$product_id])
                and $product_quantity != $user_data['cart']['products'][$product_id]['quantity'])
            {
                $product = $this->Store_model->getStoreProduct($user_data['cart']['products'][$product_id]['id']);

                if (!empty($product['product']))
                {
                    $product_quantity = ($product_quantity <= $product['product']['quantity']) ? $product_quantity : $product['product']['quantity'];

                    // Изменение количества текущего прикрепленного товара
                    $user_data['cart']['products'][$product_id]['quantity'] = $product_quantity;

                    $result = $product_quantity;

                    $this->session->set_userdata($user_data);

                    // Кол-во товаров в корзине
                    $cart_products = self::getSessionCartCountProducts();

                    self::updateSessionCart($cart_products);
                }
            }
        }

        return $result;
    }

    /**
     * Проверка email в БД
     *
     * @param $email
     * @param $name
     * @param $surname
     * @return int|null|string
     */
    public function checkEmail($email, $name = '', $surname = '')
    {
        $result = null;
        $email  = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? $email : null;

        if (!empty($email))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkRegEmail($email, $name, $surname, $this->date);

            // Возвращаем ID пользователя
            if (is_numeric($res_check['user_id']))
            {
                $result = $res_check['user_id'];

                // Отправление письма о подтвержении регистрации пользователю
                if ($res_check['new_user'] === true and $res_check['auth_via'] == 'native')
                {
                    // Отправка письма с активацией почты
                    $system_message['text']  = '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $res_check['email_hash']
                        . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                    $system_message['text']  .= 'Активировать';
                    $system_message['text']  .= '</a></b>';

                    self::sendEmail(17, $email, $system_message);

                    /*$email_to  = "<$email>";

                    $subject   = "Подтвеждение регистрации на сайте SuperBody";

                    $message   = '<p>Для подтверждения регистрации на сайте перейдите по ссылке</p> </br>';
                    $message  .= '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash . '">';
                    $message  .= 'https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash;
                    $message  .= '</a></b>';

                    $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers   .= "From: Support Superbody.pro <info@superbody.pro>\r\n";
                    $headers   .= "Reply-To: info@superbody.pro\r\n";

                    mail($email_to, $subject, $message, $headers);*/
                }
            }
            else
            {
                log_message('debug', __METHOD__.':'.__LINE__.' checkRegEmail user_id empty');
            }
        }

        return $result;
    }

    /**
     * Обновление данных сессии url возврата на страницу
     *
     * @param $return_data
     * @param $return
     */
    public function setSessionReturnUrl($return_data, $return)
    {
        // Обрезаем строку для сравнения с массивом разрешенных url
        $cut_return    = (!empty($return_data)) ? mb_substr($return_data, 0, 8) : '' ;
        // Сравнение
        $i_return      = (in_array($cut_return, $this->return_urls))
            ? $return_data
            : '/';
        $return        = (!empty($return)) ? $return : $i_return;
        // Добавляем параметр ref к строке, если переход на страницу курса
        $return        = (mb_substr($return, 0, 8) == '/course/') ? ($return . '?ref=1') : $return;
        // Возврат в случае ошибки
        $fail_return   = ($return == '/profile/') ? '/' : $return;

        // Запись в сессию
        $user_data['return_url']      = $return;
        $user_data['fail_return_url'] = $fail_return;
        $this->session->set_userdata($user_data);
    }

    /**
     * Очищение данных адреса возврата
     */
    public function deleteSessionReturnUrl()
    {
        $this->session->unset_userdata('return_url');
        $this->session->unset_userdata('fail_return_url');
    }

    /**
     * Отправка эл. письма пользователю
     *
     * @param $email_id
     * @param $recipient_email
     * @param $system_message
     * @return bool
     */
    public function sendEmail($email_id, $recipient_email, $system_message = '')
    {
        if(filter_var($recipient_email, FILTER_VALIDATE_EMAIL) !== false and is_numeric($email_id))
        {
            $email_data = $this->Notification_model->getEmail($email_id);
            $email      = $email_data['email'];

            if(!empty($email['sender_email']) and filter_var($email['sender_email'], FILTER_VALIDATE_EMAIL) !== false)
            {
                $site_info  = $this->page_data['site_info'];

                $email_to  = "<$recipient_email>";

                ob_start();
                include_once('./app_fold/views/email/email_parts/full_page.php');
                $message = ob_get_contents();
                ob_end_clean();

                $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                $headers   .= "From: " . $email['sender_name'] . "<" . $email['sender_email'] . ">\r\n";
                $headers   .= "Reply-To: " . $email['sender_email'] . "\r\n";

                mail($email_to, $email_data['email']['subject'], $message, $headers);

                return true;
            }
            else
            {
                // Отсутствует Email отправителя
                $this->session->set_tempdata('message', 174, 60);

                return false;
            }
        }
        else
        {
            // Некорректный Email получателя
            $this->session->set_tempdata('message', 175, 60);

            return false;
        }
    }

    /**
     * Покупка курса
     *
     * @param $course_id
     * @param $course_data
     * @param $course_coaches
     * @param $id_coach
     * @param $s_payment_options
     * @param $s_payment_method
     * @param $i_phone
     * @param $i_login
     * @param $i_email
     * @param $i_name
     * @param $i_promocode
     * @param $return_url
     * @param string $order_id
     * @param string $user_id
     * @param string $user_email
     * @throws Exception
     */
    public function buyCourse($course_id, $course_data, $course_coaches, $id_coach, $s_payment_options, $s_payment_method,
                              $i_phone, $i_login, $i_email, $i_name, $i_promocode, $return_url, $order_id = '', $user_id = '', $user_email = '')
    {
        $products['products'] = array();

        $promocode_id = '';
        $promocode    = array();
        $promocode_discount      = '';
        $promocode_discount_type = '';
        $free_weeks = 0;  // Кол-во бесплатных недель
        $order_payment = false; // Флаг оплаты сущействующего заказа
        $missed_payment_id = 0; // ID прорущенного платежа

        // Проверка данных пользователя
        $i_email   = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : null;
        $i_name    = (mb_substr(strip_tags($i_name), 0, 255)) ? $i_name : null;
        $user_id   = (is_numeric($user_id)) ? $user_id : null;
        $email     = (!empty($user_email)) ? $user_email : null;
        $name      = null;
        $user_type = null;
        if(empty($user_id) and is_numeric($this->user_id))
        {
            $user_id   = $this->user_id;
            $email     = (!empty($this->session->user['email'])) ? $this->session->user['email'] : $i_email;
            $name      = (!empty($this->session->user['name'])) ? $this->session->user['name'] : $i_name;
            $user_type = $this->session->user['type'];
        }
        elseif(empty($user_id))
        {
            $email = $i_email;
            $name  = $i_name;
        }
        //log_message('debug', 'UID ' . $user_id . ' OID ' . $order_id . ' CID ' . $course_id);

        // Если пользователь не авторизован, проверяем введенный им email (нет в БД - регистрация)
        /*if (empty($user_id) and !empty($email))
        {
            $user_id = self::checkEmail($email, $name);
        }*/

        // Пользователь не авторизован
        if(empty($user_id) or empty($email) or empty($name))
        {
            $this->session->set_tempdata('message', 217, 60);
            header('Location: ' . $return_url . '?ref=1');
        }

        // Количество тренировок за курс
        $count_workouts = $course_data['count_weeks'] * $course_data['count_days'];

        // Выбранный тренер
        $user_coach = (is_numeric($id_coach) and in_array($id_coach, $course_coaches['id'])) ? $id_coach : '';

        // Тренировочные дни
        $training_days = '';
        /*if (!empty($this->input->post('cb_day'))) {
            $days = $this->input->post('cb_day');
            $i = 1;
            foreach ($days as $day) {
                if ($i <= $db_data['count_days']) {
                    $training_days .= $day;
                }

                $i++;
            }
            unset($day);
        }*/

        // Даты начала и окончания курса
        $start_date = '';
        $end_date   = '';
        $free_weeks_end_date = '';
        /*$array_training_days = str_split($training_days);
        $tem_date            = new DateTime($this->date);
        $start_date          = $tem_date->format('Y-m-d');
        $end_date            = null;
        $set_start_date      = true; // Флаг начала отсчета дат

        // Текущий номер дня недели
        $current_num_day = date("N", strtotime($this->date));
        // Вычисление даты начала курса
        // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
        // то вычисляем дату следующего дня недели тренировки.
        if (!in_array($current_num_day, $array_training_days)) {
            // Поиск большего номера дня недели
            foreach ($array_training_days as $key => $training_day) {
                if ($training_day > $current_num_day and $set_start_date === true) {
                    $diff_days = $training_day - $current_num_day;

                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                    $date->add(new DateInterval('P' . $diff_days . 'D'));
                    $start_date = ($date !== false) ? $date->format('Y-m-d') : $start_date;

                    $set_start_date = false;
                }
            }
            unset($training_day);

            // Если дата начала курса не изменилась, то берем первый выбранный номер дня недели тренировки
            if ($start_date == $this->date) {
                $diff_days = 7 - $current_num_day + $array_training_days[0];

                $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                $date->add(new DateInterval('P' . $diff_days . 'D'));
                $start_date = $date !== false ? $date->format('Y-m-d') : null;
            }
        }

        // Изначальная дата окончания курса
        if (!empty($start_date)) {
            $count_days = ($course['count_weeks']*7) - 1;
            $date = DateTime::createFromFormat('Y-m-d', $start_date);
            $date->add(new DateInterval('P' . $count_days . 'D'));
            $end_date = $date !== false ? $date->format('Y-m-d') : null;
        }*/

        // Вариант оплаты (полный, разделить на месяцы)
        $options = array('full_payment' => 'full_payment', 'partial_payment' => 'partial_payment', 'balance_payment' => 'full_payment', 'missed_payment' => 'partial_payment');
        $payment_option = (array_key_exists($s_payment_options, $options)) ? $options[$s_payment_options] : 'full_payment';
        $order_payment_option = (array_key_exists($s_payment_options, $options)) ? $s_payment_options : 'full_payment';

        // Способ оплаты
        $methods      = array('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank');
        $payment_type = (in_array($s_payment_method, $methods) and $payment_option != 'partial_payment')
            ? $s_payment_method
            : 'bank_card';

        // Данные для способа оплаты
        $phone_methods = array('qiwi', 'sberbank');
        $login_methods = array('alfabank');
        $phone        = (is_numeric($i_phone)) ? $i_phone : '';
        $method_phone = (in_array($payment_type, $phone_methods)) ? $phone : '';
        $login        = strip_tags($i_login);
        $method_login = (in_array($payment_type, $login_methods)) ? $login : '';

        // Стоимость курса
        $full_course_price = $course_data['db_price'];
        $rec_months = '';
        $rec_first_course_price = '';
        $rec_subseq_course_price = '';

        // Рекуррентная стоимость курса в зависимости отдоступности такой оплаты в настройка курса
        if($course_data['recurrent'] === true)
        {
            $rec_months = $course_data['recur_months'];
            $rec_first_course_price = $course_data['db_recur_first'];
            $rec_subseq_course_price = $course_data['db_recur_subsequent'];
        }

        // Перерасчет стоимости, с учетом скидки
        $i_promocode  = mb_substr(strip_tags($i_promocode), 0, 25); // Введенный промокод
        // Проверка введенного промокода
        extract(self::recalculationOrderPrice($i_promocode, $course_id, $user_id, $order_id, $payment_option, $course_data['db_price'], $course_data['count_weeks'], $rec_months));

        $full_course_price = (!empty($full_course_price)) ? number_format($full_course_price, 2, '.', '') : '';
        $rec_first_course_price = (!empty($rec_first_course_price)) ? number_format($rec_first_course_price, 2, '.', '') : '';
        $rec_subseq_course_price = (!empty($rec_subseq_course_price)) ? number_format($rec_subseq_course_price, 2, '.', '') : '';

        // Добавление товара в заказы пользователя
        $products['products'] = array( 0 => array(
            'id' => $course_data['p_id'],
            'name' => $course_data['name'],
            'cart_quantity' => 1,
            'price' => $full_course_price,
            'rec_first_price' => $rec_first_course_price,
            'rec_months' => $rec_months,
            'rec_subsequent' => $rec_subseq_course_price,
            'fc_price' => '',
            'discount_price' => '',
            'discount_fc_price' => '',
            'promo_id' => $promocode_id,
            'promo_code' => $i_promocode,
            'promo_discount' => $promocode_discount,
            'promo_discount_type' => $promocode_discount_type));

        // Amount
        $order_total_amount   = $full_course_price;
        $payment_total_amount = ((!empty($full_course_price) and $payment_option != 'partial_payment') or $full_course_price === 0) ? $full_course_price : $rec_first_course_price;

        /*log_message('debug', 'Full price: '. $full_course_price);
        log_message('debug', 'First: '. $rec_first_course_price);
        log_message('debug', 'Subsequent: '. $rec_subseq_course_price);
        log_message('debug', 'Rec months: '. $rec_months);
        log_message('debug', 'Order total amount: '. $order_total_amount);
        log_message('debug', 'Payment total amount: '. $payment_total_amount);
        log_message('debug', 'Products: '. print_r($products, true));*/

        // Если курс питания, то сразу вычисляем дату начала и окончания курса
        if($course_data['category'] == 'nutrition')
        {
            $start_date = $this->date;

            $tmp_date = new DateTime($start_date);
            $tmp_date->add(new DateInterval("P" . $count_workouts . "D"));
            $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

            if($free_weeks > 0)
            {
                $free_weeks_days = $free_weeks*7;
                $tmp_date = new DateTime($start_date);
                $tmp_date->add(new DateInterval("P" . $free_weeks_days . "D"));
                $free_weeks_end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
            }
        }

        if(!empty($user_id))
        {
            // Покупать могут все кроме тренера
            if($user_type !== 2)
            {
                $uc_id = false;

                // Был передан ID заказа. Проверка данных заказа, присвоение данных заказа платежу
                if(is_numeric($order_id) and $order_id > 0)
                {
                    // Проверка корректности заказа
                    $res_check_uc = $this->Course_model->checkUserOrder($user_id, $order_id, $course_id);
                    if($res_check_uc['order'] === true and is_numeric($res_check_uc['uc_id']))
                    {
                        $uc_id = $res_check_uc['uc_id']; // ID курса пользователя

                        $this->load->model('Store_model');
                        $order = $this->Store_model->getUserCourseOrder($user_id, $order_id, $course_id); // Данные заказа
                        $order = $order['order'];

                        // Присовение данных платежу. Обновление данных заказа
                        if(!empty($order))
                        {
                            // Обновляем данные заказа, если не было еще платежей и курс еще не был активен
                            if($res_check_uc['succeeded_payment'] === false and $res_check_uc['free_weeks'] === false and $order['payment_status_eng'] != 'not_paid')
                            {
                                $prev_address = '';
                                $u_name = '';
                                $u_surname = '';
                                $code = '';
                                $o_phone = '';
                                $delivery = '';
                                $payment_status = 'pending';

                                //log_message('debug', 'Update order');

                                $this->Store_model->updateUserOrder($order_id, $user_id, $prev_address, $u_name, $u_surname, $email,
                                    $code, $o_phone, $delivery, $products, $payment_status, $payment_option, $order_total_amount, $this->date);
                            }
                            elseif(($order['payment_status_eng'] == 'not_paid' or ($order['payment_status_eng'] == 'canceled' and $res_check_uc['succeeded_payment'] === true)) and $order['balance_amount'] > 0)
                            {
                                // Проверка введенного промокода
                                extract(self::recalculationOrderPrice($i_promocode, $course_id, $user_id, $order_id, $payment_option, $order['balance_amount'], $course_data['count_weeks'], $order['product']['rec_months']));

                                $full_course_price = (!empty($full_course_price)) ? number_format($full_course_price, 2, '.', '') : '';

                                $payment_total_amount = ((!empty($full_course_price) and $payment_option != 'partial_payment') or $full_course_price === 0) ? $full_course_price : $rec_first_course_price;

                                $products['products'][0]['price'] = $full_course_price;
                                $products['products'][0]['rec_first_price'] = $order['product']['rec_first'];
                                $products['products'][0]['rec_subsequent'] = $order['product']['rec_subseq'];
                                $products['products'][0]['rec_months'] = $order['product']['rec_months'];

                                if($order_payment_option == 'missed_payment')
                                {
                                    $payment_total_amount = $order['missed_payment']['amount'];
                                    $missed_payment_id = $order['missed_payment']['id'];

                                    $products['products'][0]['rec_first_price'] = $order['missed_payment']['amount'];
                                }

                                $order_payment = true;
                            }

                            /*if(!empty($order['products']))
                            {
                                $i = 0;
                                foreach ($order['products'] as $product)
                                {
                                    if($product['id'] == $supposed_products['products'][0]['id'] and
                                        $product['cart_quantity'] == $supposed_products['products'][0]['cart_quantity'] and
                                        $product['price'] == $supposed_products['products'][0]['price'] and
                                        $product['rec_first'] == $supposed_products['products'][0]['rec_first_price'] and
                                        $product['rec_months'] == $supposed_products['products'][0]['rec_months'] and
                                        $product['rec_subseq'] == $supposed_products['products'][0]['rec_subsequent'] and
                                        $product['promo_id'] == $supposed_products['products'][0]['promo_id'] and
                                        $product['promo_code'] == $supposed_products['products'][0]['promo_code'] and
                                        $product['promo_discount'] == $supposed_products['products'][0]['promo_discount'] and
                                        $product['promo_discount_type'] == $supposed_products['products'][0]['promo_discount_type'])
                                    {
                                        $products['products'][$i]['id'] = $product['course_id'];
                                        $products['products'][$i]['name'] = $product['name'];
                                        $products['products'][$i]['cart_quantity'] = $product['cart_quantity'];
                                        $products['products'][$i]['price'] = $product['price'];
                                        $products['products'][$i]['rec_first_price'] = $product['rec_first'];
                                        $products['products'][$i]['rec_months'] = $product['rec_months'];
                                        $products['products'][$i]['rec_subsequent'] = $product['rec_subseq'];
                                        $products['products'][$i]['fc_price'] = $product['fc_price'];
                                        $products['products'][$i]['discount_price'] = $product['discount_price'];
                                        $products['products'][$i]['discount_fc_price'] = $product['discount_fc_price'];
                                        $products['products'][$i]['promo_id'] = '';
                                        $products['products'][$i]['promo_code'] = '';
                                        $products['products'][$i]['promo_discount'] = '';
                                        $products['products'][$i]['promo_discount_type'] = '';

                                        $i++;
                                    }
                                }
                                unset($product);
                            }*/

                            $res_order['order_id'] = $order_id;
                        }
                    }
                    else
                    {
                        $this->session->set_tempdata('message', 207, 60);
                        header('Location: ' . $return_url . '?ref=1');
                    }
                }
                // Проверка дубликатов активного курса и пользователя
                else
                {
                    $res_check_duplicates = $this->Course_model->checkUserOrderCourseDuplicates($course_id, $user_id, $this->date);
                    if($res_check_duplicates === true)
                    {
                        $this->session->set_tempdata('message', 207, 60);
                        header('Location: ' . $return_url . '?ref=1');
                    }
                }

                // Создание нового заказа
                if(empty($order_id) and is_numeric($user_id) and !empty($email))
                {
                    $prev_address = '';
                    $u_name = '';
                    $u_surname = '';
                    $code = '';
                    $o_phone = '';
                    $country = '';
                    $city = '';
                    $street = '';
                    $building = '';
                    $house = '';
                    $postcode = '';
                    $delivery = '';
                    $payment_status = 'pending';

                    $this->load->model('Store_model');

                    $res_order = $this->Store_model->setOrder($user_id, $prev_address, $u_name, $u_surname, $email, $code, $o_phone,
                        $country, $city, $street, $building, $house, $postcode, $delivery, $products, $payment_status, $payment_option, $order_total_amount, $this->date);

                    if (!empty($res_order) and $res_order !== false and is_numeric($res_order['order_id']))
                    {
                        $uc_id = $this->Course_model->setNewUserCourse($res_order['order_id'], $course_id, $user_id, $start_date, $end_date, $training_days, $user_coach, $free_weeks, $free_weeks_end_date, $this->date);
                    }
                }

                // Создание платежа, активация курса пользователя
                if (!empty($res_order) and $res_order !== false and is_numeric($res_order['order_id']))
                {
                    // Кол-во товаров в корзине
                    self::updateSessionCart(0);

                    if($order_total_amount >= 1 and $payment_total_amount >= 1 and (empty($promocode) or $promocode['discount_type'] != 'free_week'))
                    {
                        $payment_data = array(
                            'oid' => $res_order['order_id'],
                            'ucid' => $uc_id,
                            'mpid' => $missed_payment_id,
                            'order' => $order_payment,
                            'amount' => $payment_total_amount,
                            'type' => $payment_type,
                            'option' => $payment_option,
                            'phone' => $method_phone,
                            'login' => $method_login,
                            'customer_email' => $email,
                            'customer_name' => $name,
                            'order_items' => $products['products'][0],
                            'return_url' => $return_url . '?ref=1'
                        );
                        //log_message('debug', 'Payment data: ' . print_r($payment_data, true));

                        header('Location: /payment?' .http_build_query($payment_data));
                    }
                    elseif($order_total_amount == 0 or (!empty($promocode) and $promocode_discount_type == 'free_week' and $promocode_discount > 0))
                    {
                        $free_weeks = ($promocode_discount_type == 'free_week') ? $promocode_discount : 0;
                        $free_weeks_end_date = '';
                        $payment_status = 'free';

                        if(!empty($uc_id) and is_numeric($uc_id))
                        {
                            $this->Course_model->updateNewUserCourse($uc_id, $free_weeks, $free_weeks_end_date, $this->date);
                            $this->Store_model->updateOrderStatus($res_order['order_id'], '', $payment_status);
                            if($return_url == '/administration/user/'.$user_id.'/add_course')
                            {
                                header('Location: '.$return_url);

                            }
                            else
                            {
                                header('Location: /profile/course/'.$uc_id);
                            }
                        }
                        else
                        {
                            // Не сохранено
                            $this->session->set_tempdata('message', 101, 60);
                            header('Location: ' . $return_url . '?ref=1');
                        }
                    }
                    else
                    {
                        log_message('debug', __METHOD__.':'.__LINE__);
                        header('Location: ' . $return_url . '?ref=1');
                    }
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 101, 60);
                    header('Location: ' . $return_url . '?ref=1');
                }
            }
            else
                {
                    log_message('debug', __METHOD__.':'.__LINE__.' User is coach');
                    header('Location: ' . $return_url . '?ref=1');
                }
        }
        else
        {
            // Пользователь не авторизован
            $this->session->set_tempdata('message', 5, 60);
            header('Location: ' . $return_url . '?ref=1');
        }
    }

    /**
     * Оплата премиум аккаунта
     *
     * @param $s_payment_options
     * @param $s_payment_method
     * @param $i_phone
     * @param $i_login
     * @param $i_email
     * @param $i_name
     * @param $return_url
     * @param string $order_id
     * @throws Exception
     */
    public function buyPremium($s_payment_options, $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $return_url, $order_id = '')
    {
        //log_message('debug', __METHOD__.':'.__LINE__);
        $products['products'] = array();

        $order_payment = false; // Флаг оплаты сущействующего заказа

        // Проверка данных пользователя
        $i_email   = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : null;
        $i_name    = (mb_substr(strip_tags($i_name), 0, 255)) ? $i_name : null;
        $user_id   = (!empty($user_id) and is_numeric($user_id)) ? $user_id : null;
        $email     = (!empty($user_email)) ? $user_email : null;
        $name      = null;
        $user_type = null;
        if(empty($user_id) and is_numeric($this->user_id))
        {
            $user_id   = $this->user_id;
            $email     = (!empty($this->session->user['email'])) ? $this->session->user['email'] : $i_email;
            $name      = (!empty($this->session->user['name'])) ? $this->session->user['name'] : $i_name;
            $user_type = $this->session->user['type'];
        }
        elseif(empty($user_id))
        {
            $email = $i_email;
            $name  = $i_name;
        }

        // Пользователь не авторизован
        if(empty($user_id) or empty($email) or empty($name))
        {
            $this->session->set_tempdata('message', 217, 60);
            header('Location: ' . $return_url . '?ref=1');
        }

        // Даты начала и окончания курса
        $start_date = '';
        $end_date   = '';

        // Вариант оплаты (полный, разделить на месяцы)
        $options = array('full_payment' => 'full_payment', 'partial_payment' => 'partial_payment', 'balance_payment' => 'full_payment', 'missed_payment' => 'partial_payment');
        $payment_option = (array_key_exists($s_payment_options, $options)) ? $options[$s_payment_options] : 'full_payment';
        $order_payment_option = (array_key_exists($s_payment_options, $options)) ? $s_payment_options : 'full_payment';

        // Способ оплаты
        $methods      = array('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank');
        $payment_type = (in_array($s_payment_method, $methods) and $payment_option != 'partial_payment')
            ? $s_payment_method
            : 'bank_card';

        // Данные для способа оплаты
        $phone_methods = array('qiwi', 'sberbank');
        $login_methods = array('alfabank');
        $phone        = (is_numeric($i_phone)) ? $i_phone : '';
        $method_phone = (in_array($payment_type, $phone_methods)) ? $phone : '';
        $login        = strip_tags($i_login);
        $method_login = (in_array($payment_type, $login_methods)) ? $login : '';

        // Стоимость курса
        $premium_price = $this->page_data['site_info']['advertising_month_price'];

        $premium_price = (!empty($premium_price)) ? number_format($premium_price, 2, '.', '') : '';

        // Добавление товара в заказы пользователя
        $products['products'] = array( 0 => array(
            'id' => 0,
            'premium_account' => 1,
            'name' => 'Премиум аккаунт Superbody',
            'cart_quantity' => 1,
            'price' => $premium_price,
            'rec_first_price' => $premium_price));

        // Amount
        $order_total_amount   = $premium_price;
        $payment_total_amount = $premium_price;

        // Вычисляем дату начала и окончания курса
        $start_date = $this->date;
        $tmp_date = new DateTime($start_date);
        $tmp_date->add(new DateInterval("P1M"));
        $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

        if(!empty($user_id))
        {
            // Покупать могут все кроме тренера
            if($user_type !== 2)
            {
                $uc_id = false;

                // Был передан ID заказа.
                if(is_numeric($order_id) and $order_id > 0)
                {
                    $res_order['order_id'] = $order_id;
                }

                // Создание нового заказа
                if(empty($order_id) and is_numeric($user_id) and !empty($email))
                {
                    $prev_address = '';
                    $u_name = '';
                    $u_surname = '';
                    $code = '';
                    $o_phone = '';
                    $country = '';
                    $city = '';
                    $street = '';
                    $building = '';
                    $house = '';
                    $postcode = '';
                    $delivery = '';
                    $payment_status = 'pending';

                    $this->load->model('Store_model');

                    $res_order = $this->Store_model->setOrder($user_id, $prev_address, $u_name, $u_surname, $email, $code, $o_phone,
                        $country, $city, $street, $building, $house, $postcode, $delivery, $products, $payment_status, $payment_option, $order_total_amount, $this->date);
                }

                // Создание платежа, активация курса пользователя
                if (!empty($res_order) and $res_order !== false and is_numeric($res_order['order_id']))
                {
                    if($order_total_amount >= 1 and $payment_total_amount >= 1)
                    {
                        $payment_data = array(
                            'oid' => $res_order['order_id'],
                            'ucid' => '',
                            'mpid' => '',
                            'order' => $order_payment,
                            'amount' => $payment_total_amount,
                            'type' => $payment_type,
                            'option' => $payment_option,
                            'phone' => $method_phone,
                            'login' => $method_login,
                            'customer_email' => $email,
                            'customer_name' => $name,
                            'order_items' => $products['products'][0],
                            'return_url' => $return_url . '?ref=1'
                        );
                        //log_message('debug', 'Payment data: ' . print_r($payment_data, true));

                        header('Location: /payment?' .http_build_query($payment_data));
                    }
                    else
                    {
                        log_message('debug', __METHOD__.':'.__LINE__);
                        header('Location: ' . $return_url . '?ref=1');
                    }
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 101, 60);
                    header('Location: ' . $return_url . '?ref=1');
                }
            }
            else
            {
                log_message('debug', __METHOD__.':'.__LINE__.' User is coach');
                header('Location: ' . $return_url . '?ref=1');
            }
        }
        else
        {
            // Пользователь не авторизован
            $this->session->set_tempdata('message', 5, 60);
            header('Location: ' . $return_url . '?ref=1');
        }
    }

    /**
     * Вычисление стоимости курса с учетом промокода
     *
     * @param $i_promocode
     * @param $course_id
     * @param $user_id
     * @param $order_id
     * @param $payment_option
     * @param $course_db_price
     * @param $course_db_count_weeks
     * @param $course_db_rec_months
     * @return array
     */
    public function recalculationOrderPrice($i_promocode, $course_id, $user_id, $order_id, $payment_option, $course_db_price, $course_db_count_weeks, $course_db_rec_months)
    {
        $result = array();

        if(!empty($i_promocode))
        {
            $promocode = $this->Course_model->getAvailableCoursePromocode($course_id, $i_promocode, $this->date, $user_id, $order_id);
            //log_message('debug', 'Promocode: '. print_r($promocode, true));
            if($promocode['discount'] !== false and !empty($promocode['id']))
            {
                $promocode_id = $promocode['id'];
                $promocode_discount      = $promocode['discount'];
                $promocode_discount_type = $promocode['discount_type'];

                if($payment_option == 'full_payment')
                {
                    $full_course_price = $course_db_price;

                    // Вычислеие цены со скидкой
                    // Скидка - процент
                    if($promocode_discount_type == 'percent')
                    {
                        $full_course_price = $course_db_price - ($course_db_price*$promocode_discount/100);
                    }
                    // Скидка - сумма без процентного ограничения
                    elseif($promocode_discount_type == 'currency' and $promocode['rel_percent'] == 0)
                    {
                        $new_price = $course_db_price - $promocode_discount;
                        $full_course_price = ($new_price < 1) ? 1 : $new_price;
                    }
                    // Скидка - сумма с процентным ограничением
                    elseif($promocode_discount_type == 'currency' and $promocode['rel_percent'] > 0)
                    {
                        $full_course_price  = $course_db_price - ($course_db_price*$promocode['rel_percent']/100);
                        $promocode_discount = $promocode['rel_percent'];
                        $promocode_discount_type = 'percent';
                    }
                    // Скидка - бесплатные недели
                    elseif($promocode_discount_type == 'free_week' and $promocode_discount > 0 and $course_db_count_weeks >= $promocode_discount)
                    {
                        $free_weeks  = $promocode_discount;
                        $free_months = $free_weeks/4;

                        $course_db_rec_months = (!empty($course_db_rec_months) and $free_months > 0) ? ceil($course_db_rec_months - $free_months) : $course_db_rec_months;

                        $week_price        = $course_db_price / $course_db_count_weeks;
                        $free_weeks_price  = $week_price * $free_weeks;
                        $new_price         = $course_db_price - $free_weeks_price;
                        $full_course_price = ($new_price < 1) ? 1 : $new_price;
                    }

                    $result = array(
                        'full_course_price'       => $full_course_price,
                        'promocode'               => $promocode,
                        'promocode_id'            => $promocode_id,
                        'promocode_discount'      => $promocode_discount,
                        'promocode_discount_type' => $promocode_discount_type,
                        'rec_months'              => $course_db_rec_months
                    );
                }
            }
        }

        return $result;
    }

    /**
     * Регистрация/авторизация Facebook
     *
     * @param $i_email
     * @param $return
     * @param $bt_facebook_login
     */
    public function ctrlFacebookLogin($i_email, $return, $bt_facebook_login)
    {
        $email = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/facebook_login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'bt_facebook_login' => $bt_facebook_login,
            'email' => $email,
            'hi_return' => $return));

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

    /**
     * Регистрация/авторизация Одноклассники
     *
     * @param $i_email
     * @param $return
     * @param $bt_ok_login
     */
    public function ctrlOkLogin($i_email, $return, $bt_ok_login)
    {
        $email = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/ok_login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'bt_ok_login' => $bt_ok_login,
            'email' => $email,
            'hi_return' => $return));

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

    /**
     * Регистрация/авторизация ВКонтакте
     *
     * @param $i_email
     * @param $return
     * @param $bt_vk_login
     */
    public function ctrlVkLogin($i_email, $return, $bt_vk_login)
    {
        $email = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/vk_login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'bt_vk_login' => $bt_vk_login,
            'email' => $email,
            'hi_return' => $return));

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

    /**
     * Регистрация/авторизация Instagram
     *
     * @param $i_email
     * @param $return
     * @param $bt_instagram_login
     */
    public function ctrlInstagramLogin($i_email, $return, $bt_instagram_login)
    {
        $email = (filter_var($i_email, FILTER_VALIDATE_EMAIL)) ? $i_email : '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/instagram_login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'bt_insta_login' => $bt_instagram_login,
            'email' => $email,
            'hi_return' => $return));

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

    /**
     * Добавление email пользователя в книгу SendPulse
     * @param $email
     */
    public function sendPulseAddEmails($email)
    {
        $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

        $bookID = 37283;
        $emails = array(
            array(
                'email' => $email
            )
        );

        $response = $SPApiClient->addEmails($bookID, $emails);

        // Without confirmation
        //log_message('debug', __METHOD__ . ':'. PHP_EOL . print_r($response, true));

    }

    /**
     * Удаление email пользователя из книги SendPulse
     *
     * @param $email
     */
    public function sendPulseRemoveEmails($email)
    {
        $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

        $bookID = 37283;
        $emails = array($email);

        $response = $SPApiClient->removeEmails($bookID, $emails);

        // Without confirmation
        //log_message('debug', __METHOD__ . ':'. PHP_EOL . print_r($response, true));

    }

    /**
     * Сохранение нового промокода
     *
     * @param $s_use_category
     * @param $i_code_name
     * @param $i_code_desc
     * @param $i_code_discount
     * @param $i_discount_type
     * @param $i_rel_percent
     * @param $s_pv_type
     * @param $i_validity_date_start
     * @param $i_validity_date_end
     * @param $s_ua_type
     * @param $i_ua_number
     * @param $s_user_ua_type
     * @param $i_user_ua_number
     * @param $i_promocodes
     * @param $i_users
     * @param $r_crs_group
     * @param $s_crs_categories
     * @param $i_courses
     * @param int $admin_id
     * @param int $coach_id
     * @return array
     * @throws Exception
     * @internal param $course_id
     * @internal param $s_category
     */
    public function saveNewCoursePromocode($s_use_category, $i_code_name, $i_code_desc, $i_code_discount, $i_discount_type,
                                           $i_rel_percent, $s_pv_type, $i_validity_date_start, $i_validity_date_end, $s_ua_type,
                                           $i_ua_number, $s_user_ua_type, $i_user_ua_number, $i_promocodes, $i_users, $r_crs_group,
                                           $s_crs_categories, $i_courses, $admin_id, $coach_id = 0)
    {
        $result = array('error' => false, 'promocode_id' => null);
        $pc_types = array('percent', 'currency', 'free_week');
        $pc_use_cats = array('primary', 'secondary');

        $use_category  = (in_array($s_use_category, $pc_use_cats)) ? $s_use_category : 'primary';
        $name          = mb_substr(strip_tags($i_code_name), 0, 255);
        $desc          = mb_substr(strip_tags($i_code_desc), 0, 255);
        $discount      = (is_numeric($i_code_discount)) ? $i_code_discount : null;
        $discount_type = (in_array($i_discount_type, $pc_types)) ? $i_discount_type : 'percent';
        $rel_percent   = (is_numeric($i_rel_percent)) ? $i_rel_percent : 0;
        $validity_type = ($s_pv_type == 'unlimited') ? 'unlimited' : 'date_range';
        $tmp_ds        = new DateTime($i_validity_date_start);
        $tmp_de        = new DateTime($i_validity_date_end);
        $pv_date_start = ($tmp_ds !== false and $validity_type == 'date_range') ? $tmp_ds->format('Y-m-d') : '';
        $pv_date_end   = ($tmp_de !== false and $validity_type == 'date_range') ? $tmp_de->format('Y-m-d') : '';

        $use_type  = ($s_ua_type == 'unlimited') ? 'unlimited' : 'number';
        $ua_number = (is_numeric($i_ua_number) and $use_type == 'number') ? $i_ua_number : '';
        $user_use_type  = ($s_user_ua_type == 'unlimited') ? 'unlimited' : 'number';
        $user_ua_number = (is_numeric($i_user_ua_number) and $user_use_type == 'number') ? $i_user_ua_number : '';

        $promocodes = array();
        $users      = array('insert' => array());

        foreach($i_promocodes as $i_pc)
        {
            $i_pc = strtoupper(mb_substr(strip_tags($i_pc), 0, 25));
            if(!empty($i_pc))
            {
                $promocodes[] = $i_pc;
            }
        }
        unset($i_pc);

        foreach($i_users as $i_user)
        {
            if(is_numeric($i_user))
            {
                $users['insert'][] = $i_user;
            }
        }
        unset($i_user);

        $discount = ($discount_type == 'percent' and $discount > 100) ? 100 : $discount;

        // Группы курсов, на которые распространяется промокод
        $crs_groups = array('all', 'workouts', 'nutritions', 'categories', 'courses', 'course');
        $pc_type = (in_array($r_crs_group, $crs_groups)) ? $r_crs_group : 'all';

        // Категории курсов, на которые распространяется промокод
        $crs_categories   = '';
        if(!empty($s_crs_categories) and $pc_type == 'categories')
        {
            foreach($s_crs_categories as $key => $crs_cat)
            {
                if(!is_numeric($crs_cat))
                {
                    unset($s_crs_categories[$key]);
                }
            }
            unset($crs_cat);

            $crs_categories = implode(';', $s_crs_categories);
        }

        // Выбранные курсы, на которые распространяется промокод
        $courses = array('insert' => array());
        if(!empty($i_courses))
        {
            $i = 0;
            foreach ($i_courses as $i_c)
            {
                if(is_numeric($i_c))
                {
                    $courses['insert'][$i] = $i_c;

                    $i++;
                }
            }
            unset($i_c);

            $count_courses = count($courses['insert']);
            if($count_courses > 0)
            {
                $pc_type = 'courses';
            }
            elseif($count_courses == 1)
            {
                $pc_type = 'course';
            }
        }

        if(!empty($discount) and !empty($promocodes))
        {
            $res_ins = $this->Course_model->setNewPromocode($use_category, $pc_type, $name, $desc, $discount, $discount_type, $rel_percent,
                $validity_type, $pv_date_start, $pv_date_end, $use_type, $ua_number, $user_use_type, $user_ua_number,
                $promocodes, $users, $courses, $crs_categories, $coach_id, $admin_id, $this->date);

            if (is_numeric($res_ins))
            {
                $result['promocode_id'] = $res_ins;
            }
            else
            {
                $result['error'] = 145;
            }
        }
        else
        {
            $result['error'] = 146;
        }

        return $result;
    }

    /**
     * @param $html
     * @return string
     */
    public function closetags($html) {
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];

        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)){
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }
}
