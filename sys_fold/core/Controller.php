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

		$this->date = date("Y-m-d H:i:s");

		$this->page_url = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $this->load->model('Welcome_model');
        $this->load->model('Course_model');

		// Проверка данных авторизованного пользователя
        if (!empty($this->session->user) and is_numeric($this->session->user['id']) and
            (empty($this->session->user['email']) or filter_var($this->session->user['email'], FILTER_VALIDATE_EMAIL)))
        {
            // Проверка авторизации пользователя (способ авторизации - соц. сети)
            self::checkUserSession();

            // Уничтожение сессии, для повтороной авторизации, если дата авторизации меньше метки,
            // заданной для обновления сессий пользователя
            $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $this->session->user['date_auth']);
            $u_date = $tmp_date->format('U');
            if ($u_date < '1511022412')
            {
                header('Location: /logout');
            }

            // ID пользователя
            $this->user_id = $this->session->user['id'];

            // Проверка пользовательских данных сессии
            $this->load->model('Message_model');
            $this->load->model('User_model');
            $this->load->model('Store_model');

            // Проверка новых сообщений
            $new_messages    = $this->Message_model->getCountNewMessages($this->user_id);
            $new_fb_messages = $this->Message_model->getCountNewFeedbackMessages($this->user_id, $this->session->user['email']);

            if ($new_messages != $this->session->new_messages) {
                $this->session->set_userdata("new_messages", $new_messages);
            }
            if ($new_fb_messages != $this->session->new_fb_messages) {
                $this->session->set_userdata("new_fb_messages", $new_fb_messages);
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

            $user_session_data['user']['email']     = $user_data['user_data']['user_email'];
            $user_session_data['user']['name']      = $user_data['user_data']['user_name'];
            $user_session_data['user']['image']     = $user_data['user_data']['user_image'];
            $user_session_data['user']['type']      = $user_data['user_data']['user_type'];
            $user_session_data['user']['blocked']   = $user_data['user_data']['user_blocked'];
            $user_session_data['user']['date_auth'] = $this->date;

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
        elseif(!empty($this->session->user))
        {
            session_destroy();
        }

		$this->list_errors = array (
			"0" => "Ошибка! Пользователь не найден.",
			"1" => "Ошибка! Пользователь с таким E-mail уже зарегистрирован.",
			"2" => "Ошибка! Не удалось зарегестрировать E-mail. Пожалуйста, повторите попытку.",
			"3" => "Ошибка! Не удалось активировать аккаунт. Пожалуйста, повторите попытку.",
			"4" => "Ошибка! Аккаунт не активирован. Неверный код активации.",
			"5" => "Ошибка! Не удалось авторизовать Вас. Пожалуйста, повторите попытку.",
			"6" => "Ошибка! Некорректный E-mail",
			"7" => "Ошибка! Неверный E-mail или пароль. Пожалуйста, повторите попытку.",
			"8" => "Ошибка! Проверьте, пожалуйста, корректность и заполните все поля регистрации.",
			"9" => "Ошибка! Изменения не были сохранены. Пожалуйста, повторите попытку.",
			"10" => "Сохранено!",
			"11" => "Ошибка! Не удалось сохранить имя. Пожалуйста, повторите попытку.",
			"12" => "Ошибка! Не удалось сохранить данные анкеты. Пожалуйста, повторите попытку.",
			"13" => "Ошибка! Не удалось сохранить антропометрические данные. Пожалуйста, повторите попытку.",
			"14" => "Ошибка! Не удалось сохранить нового администратора. Пожалуйста, повторите попытку.",
			"15" => "Ошибка! Не удалось сохранить нового тренера. Пожалуйста, повторите попытку.",
			"16" => "Пользователь заблокирован!",
			"17" => "Ошибка! Пользователя не заблокирован. Пожалуйста, повторите попытку.",
			"18" => "Пользователь разблокирован!",
			"19" => "Ошибка! Пользователь не разблокирован. Пожалуйста, повторите попытку.",
			"20" => "Аккаунт активирован!",
			"21" => "Ошибка! Имя и данные анкеты не сохранены. Пожалуйста, повторите попытку.",
			"22" => "Ошибка! Имя и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"23" => "Ошибка! Данные анкеты и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"24" => "Ошибка! Имя, данные анкеты и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"25" => "Ошибка! Категория курса не сохраненв. Пожалуйста, повторите попытку.",
			"26" => "Ошибка! Прием пищи не сохранен. Пожалуйста, повторите попытку.",
			"27" => "Ошибка! Типа приема пищи не сохранен. Пожалуйста, повторите попытку.",
			"28" => "Ошибка! Новый курс не сохранен. Пожалуйста, повторите попытку.",
			"29" => "Ошибка! Проверьте, пожалуйста, корректность и заполните все поля.",
            "30" => "Ошибка! Курс не сохранен. Пожалуйста, повторите попытку.",
            "31" => "Ошибка! Расписание курса не сохранено. Пожалуйста, повторите попытку.",
            "32" => "Ошибка! Основные данные и расписание курса не сохранены. Пожалуйста, повторите попытку.",
            "33" => "Ошибка! Курс не заблокирован. Пожалуйста, повторите попытку.",
            "34" => "Ошибка! Курс не разблокирован. Пожалуйста, повторите попытку.",
            "35" => "Ошибка! Запись блога не одобрена. Пожалуйста, повторите попытку.",
            "36" => "Ошибка! Запись блога не заблокирована. Пожалуйста, повторите попытку.",
            "37" => "Ошибка! Комментарий блога не одобрен. Пожалуйста, повторите попытку.",
            "38" => "Ошибка! Комментарий блога не заблокирован. Пожалуйста, повторите попытку.",
            "39" => "Ошибка! Видео не сохранено. Пожалуйста, повторите попытку.",
            "40" => "Ошибка! Видео не загружено. Пожалуйста, повторите попытку.",
            "41" => "Ошибка! Настройки видео не сохранены. Пожалуйста, повторите попытку.",
            "42" => "Видео заблокировано!",
            "43" => "Ошибка! Видео не заблокировано. Пожалуйста, повторите попытку.",
            "44" => "Видео разблокировано.",
            "45" => "Ошибка! Видео не разблокировано. Пожалуйста, повторите попытку.",
            "46" => "На указанный Вами E-mail отправлено письмо с указаниями по смене пароля.",
            "47" => "Ошибка! Пользователь с таким E-mail не найден.",
            "48" => "Ошибка! Пароль не обновлен. Пожалуйста, повторите попытку.",
            "49" => "Ошибка! Сообщение не разблокировано. Пожалуйста, повторите попытку.",
            "50" => "Ошибка! Сообщение не заблокировано. Пожалуйста, повторите попытку.",
            "51" => "Ошибка! Сообщение не отправлено.",
            "52" => "Сообщение отправлено. Копия сообщения отправлена Вам на почту.",
            "53" => "Ошибка! Проверьте корректность E-mail пользователя.",
            "54" => "Сообщение отправлено. Копия диалога отправлена пользователю на почту.",
            "55" => "Курс добавлен в Ваш календарь.",
            "56" => "Ошибка! Курс не добавлен в Ваш календарь. Пожалуйста, повторите попытку.",
            "57" => "Ошибка! Выберите тренировочные дни.",
            "58" => "Ошибка! Статья не сохранена. Пожалуйста, повторите попытку.",
            "59" => "Ошибка! Интервью не сохранено. Пожалуйста, повторите попытку.",
            "60" => "Ошибка! Новость не сохранена. Пожалуйста, повторите попытку.",
            "61" => "Ошибка! Пожалуйста, проверьте корректность введенных данных в обязательных полях.",
            "62" => "Ошибка! Введите наименование категории.",
            "63" => "Ошибка! Категория не сохранена. Пожалуйста, повторите попытку.",
            "64" => "Ошибка! Категория не заблокирована. Пожалуйста, повторите попытку.",
            "65" => "Ошибка! Категория не разблокирована. Пожалуйста, повторите попытку.",
            "66" => "Ошибка! Товар не сохранен. Не все поля заполнены корректно.",
            "67" => "Ошибка! Товар не сохранен. Пожалуйста, повторите попытку.",
            "68" => "Ошибка! Товар не заблокирован. Пожалуйста, повторите попытку.",
            "69" => "Ошибка! Товар не разблокирован. Пожалуйста, повторите попытку.",
            "70" => "Ошибка! Изображение товара не сохранено. Пожалуйста, повторите попытку.",
            "71" => "Ошибка! Товар не добавлен в корзину. Пожалуйста, повторите попытку.",
            "72" => "Ошибка! Не все товары корзины удалось обновить. Пожалуйста, повторите попытку.",
            "73" => "Ошибка! Данные курса не сохранены. Пожалуйста, повторите попытку.",
            "74" => "Вы подписаны на новости.",
            "75" => "Ошибка! Не удалось добавить E-mail в подписчики. Пожалуйста, повторите попытку.",
            "76" => "Ошибка! Проверьте корректность введенных E-mail и имени.",
            "77" => "Вы уже подписаны на новости.",
            "78" => "",
            "79" => "Ошибка! Тренировочные дни не сохранены. Пожалуйста, повторите попытку.",
            "80" => "Ошибка! Курс не заморожен. Пожалуйста, повторите попытку.",
            "81" => "Ошибка! Тренировочные дни не изменены. Курс не заморожен. Пожалуйста, повторите попытку.",
            "82" => "Категория пользователя изменена с \"Пользователь\" на \"Администратор\".",
            "83" => "Категория пользователя изменена с \"Пользователь\" на \"Тренер\".",
            "84" => "Категория пользователя изменена с \"Администратор\" на \"Пользователь\".",
            "85" => "Категория пользователя изменена с \"Тренер\" на \"Пользователь\".",
            "86" => "Ошибка! Категория пользователя не изменена. Пожалуйста, повторите попытку.",
            "87" => "Изменения в портфолио сохранены.",
            "88" => "Ошибка! Не удалось измененить изображение портфолио. Пожалуйста, повторите попытку.",
            "89" => "Ошибка! Данные портфолио не сохранены. Пожалуйста, повторите попытку.",
            "90" => "Ошибка! Изображение и данные портфолио не сохранены. Пожалуйста, повторите попытку.",
            "91" => "Запись удалена из портфолио.",
            "92" => "Ошибка! Запись из портфолио не удалена. Пожалуйста, повторите попытку.",
            "93" => "Запись добавлена в портфолио.",
            "94" => "Ошибка! Запись из портфолио не добавлена. Пожалуйста, повторите попытку.",
            "95" => "Ошибка! Пол и дата рождения не сохранены. Пожалуйста, повторите попытку.",
            "96" => "Ошибка! Фото профиля не удалено. Пожалуйста, повторите попытку.",
            "97" => "Комментарий отправлен. В ближайшее время он пройдет проверку модератором.",
            "98" => "Ошибка! Комментарий не отправлен. Пожалуйста, повторите попытку.",
            "99" => "Ошибка! Landing page курса не активирован. Пожалуйста, повторите попытку.",
            "100" => "Ошибка! Landing page курса не деактивирован. Пожалуйста, повторите попытку.",
            "101" => "Ошибка! Заказ не оформлен. Пожалуйста, повторите попытку.",
            "102" => "Ошибка! Не удалось получить доступ к Вашим данным из социальной сети. Пожалуйста, повторите попытку.",
            "103" => "Ошибка! Отказано в доступе.",
            "104" => "Видео удалено.",
            "105" => "Ошибка! Видео не удалено. Пожалуйста, повторите попытку.",
            "106" => "Ошибка! Курс не удален. Курс куплен пользователем.",
            "107" => "Ошибка! Курс не удален. Пожалуйста, повторите попытку.",
            "108" => "Курс удален.",
            "109" => "Курс куплен.",
            "110" => "Ошибка! Курс не куплен. Пожалуйста, повторите попытку.",
            "111" => "Ошибка! Информация о сайте не сохранена. Пожалуйста, повторите попытку.",
            "112" => "Ошибка! Изменения Landing page курса не сохранены. Пожалуйста, повторите попытку.",
            "113" => "Запись добавлена в блог.",
            "114" => "Ошибка! Запись не была добавлен в блог. Пожалуйста, повторите попытку.",
            "115" => "Ошибка! Не корректные данные пользователя. Пожалуйста, повторите попытку.",
            "116" => "Ошибка! Баннер не сохранен. Пожалуйста, повторите попытку.",
            "117" => "Ошибка! Файл баннера не сохранен. Пожалуйста, повторите попытку.",
            "118" => "Ошибка! Баннер не заблокирован. Пожалуйста, повторите попытку.",
            "119" => "Ошибка! Баннер не разблокирован. Пожалуйста, повторите попытку.",
            "120" => "Ошибка! Баннер не удален. Пожалуйста, повторите попытку.",
            "121" => "Ошибка! Отзыв не сохранен. Пожалуйста, повторите попытку.",
            "122" => "Ошибка! Отзыв не сохранен. Пожалуйста, проверьте правильность ввода текста.",
            "123" => "Ошибка! Отзыв не удален. Пожалуйста, повторите попытку.",
            "124" => "Ошибка! Отзыв не одобрен. Пожалуйста, повторите попытку.",
            "125" => "Ошибка! Отзыв не отклонён. Пожалуйста, повторите попытку.",
            "126" => "Ошибка! Запись блога не удалена. Пожалуйста, повторите попытку.",
            "127" => "Ошибка! Запись блога не сохранена. Пожалуйста, повторите попытку.",
            "128" => "Ошибка! Вы не подтвердили согласие на обработку персональных данных.",
            "129" => "Ошибка! Изменения настроек соц. сетей не сохранены. Пожалуйста, повторите попытку.",
            "130" => "Ошибка! Не все данные курса сохранены.",
            "131" => "Сообщение отправлено.",
            "132" => "Ошибка! Пароли не совпадают. Пожалуйста, повторите попытку.",
            "133" => "Пароль успешно обновлен."
		);

        // Сообщение о результатах действий пользователя
        if (!empty($this->session->tempdata('message')))
        {
            $this->page_message = $this->list_errors[$this->session->tempdata('message')];

            // Удаление значения сообщения
            $this->session->unset_tempdata('message');
        }

        // Список доступных пользователю курсов
        $courses = $this->Course_model->getAvailableCourses();

        // Обновление БД
        $this->Welcome_model->updateDatabase($this->date);
        // Данные сайта (контактные данные, о нас, соц. сети и т.д.)
        $site_info = $this->Welcome_model->getSiteInfo();

        // Данные страницы
        $this->page_data = array(
            "title" => '',
            "site_info" => !empty($site_info) ? $site_info : '',
            "user_session" => !empty($this->session->user) ? $this->session->user : '',
            "new_messages" => !empty($this->session->new_messages) ? $this->session->new_messages : 0,
            "new_fb_messages" => !empty($this->session->new_fb_messages) ? $this->session->new_fb_messages : 0,
            "cart_count" => !empty($this->session->cart['count']) ? $this->session->cart['count'] : 0,
            "message" => $this->page_message,
            "page_menu" => '',
            "page_submenu" => '',
            "outsider" => false,
            "menu_courses" => $courses
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
        $valid_type = array('jpg' => 'image/jpeg', 'png' => 'image/png');

        if (in_array($file_type, $valid_type)){
            $img_type = array_search($file_type, $valid_type); // Расширение файла
            $md5_time = md5(time());
            $md5_name = substr($md5_time, 0, 10); // Новое имя для файла

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|png';
            $config['max_size']	= '2048';
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
     * @param $user_id
     * @param $user_email
     * @param $user_type
     * @param $user_blocked
     * @param $user_name
     * @param $user_image
     * @param $access_token
     * @param $user_soc_via
     * @param $user_soc_id
     * @param $date
     */
    public function updateSession($user_id, $user_email, $user_type, $user_blocked, $user_name, $user_image, $access_token, $user_soc_via, $user_soc_id, $date)
    {
        $split_name = mb_split(' ', $user_name);
        $s_name     = !empty($split_name[0]) ? $split_name[0] : '';
        $s_surname  = !empty($split_name[1]) ? $split_name[1] : '';

        if (!empty($this->session->user))
        {
            // Обновление данных сессии, если она пренадлежит ему
            if ($this->session->user['id'] == $user_id or
                ($this->session->user['social_id'] == $user_soc_id and $this->session->user['social_id'] == $user_soc_via))
            {
                $user_data['user'] = $this->session->user;

                $user_data['user']['blocked']      = $user_blocked;
                $user_data['user']['access_token'] = $access_token;
                $user_data['user']['date_auth']    = $date;

                $this->session->set_userdata($user_data);
            }
            // Удаляем сессию и создаем новую
            else
            {
                $this->session->sess_destroy();
                // Создание сессии
                self::createUserSession($user_id, $user_email, $user_type, $user_blocked, $user_name, $s_name, $s_surname, $user_image, $access_token, $user_soc_via, $user_soc_id, $date);
            }
        }
        else
        {
            // Создание сессии
            self::createUserSession($user_id, $user_email, $user_type, $user_blocked, $user_name, $s_name, $s_surname, $user_image, $access_token, $user_soc_via, $user_soc_id, $date);
        }
    }

    /**
     * Создание сессии пользователя
     *
     * @param $user_id
     * @param $user_email
     * @param $user_type
     * @param $user_blocked
     * @param $user_name
     * @param $s_name
     * @param $s_surname
     * @param $user_image
     * @param $access_token
     * @param $user_soc_via
     * @param $user_soc_id
     * @param $date
     */
    protected function createUserSession($user_id, $user_email, $user_type, $user_blocked, $user_name, $s_name, $s_surname, $user_image, $access_token, $user_soc_via, $user_soc_id, $date)
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
                "type" => $user_type,
                "blocked" => $user_blocked,
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
            )
        );

        $this->session->set_userdata($user_data);
    }

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
        if (!empty($db_height) and !empty($db_weight) and !empty($weight) and $db_weight != $weight)
        {
            $bmi = $weight / pow(($db_height/100), 2);
            $bmi = number_format($bmi, 2, '.', '');
        }

        // Базальная скорость обмена
        if (!empty($db_height) and !empty($db_weight) and !empty($weight) and !empty($db_birthday) and $db_weight != $weight)
        {
            $datetime = new DateTime($db_birthday);
            $interval = $datetime->diff(new DateTime(date("d-m-Y")));
            $age = $interval->format("%Y");

            if ('female' == $db_gender)
            {
                if (30 > $bmi)
                {
                    $bmr = 655 + 9.6*$weight + 1.8*$db_height - 4.7*$age;
                }
                else
                {
                    $bmr = 2.4*$weight + 9*$db_height - 4.7*$age - 65;
                }
            }
            else
            {
                if (30 > $bmi)
                {
                    $bmr = 66.5 + 13.7*$weight + 5*$db_height - 6.8*$age;
                }
                else
                {
                    $bmr = 3.4*$weight + 15.3*$db_height - 6.8*$age - 691;
                }
            }
            $bmr = round($bmr);
        }

        // Сохранение данных В БД
        if (!empty($bmi) and !empty($bmr) and $db_bmi != $bmi and $db_bmr != $bmr)
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
        $this->load->view('errors/html/error_404', $this->page_data);
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

            $res_check = $this->Authorization_model->checkEmail($email, $name, $surname, $this->date);

            // Возвращаем ID пользователя
            if (is_numeric($res_check['user_id']))
            {
                $result     = $res_check['user_id'];
                $email_hash = password_hash($email, PASSWORD_DEFAULT);

                // Отправление письма о подтвержении регистрации пользователю
                if ($res_check['new_user'] === true and $res_check['auth_via'] == 'native')
                {
                    $email_to  = "<$email>";

                    $subject   = "Подтвеждение регистрации на сайте SuperBody";

                    $message   = '<p>Для подтверждения регистрации на сайте перейдите по ссылке</p> </br>';
                    $message  .= '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash . '">';
                    $message  .= 'https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash;
                    $message  .= '</a></b>';

                    $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers   .= "From: Support Superbody.pro <info@superbody.pro>\r\n";
                    $headers   .= "Reply-To: info@superbody.pro\r\n";

                    mail($email_to, $subject, $message, $headers);
                }
            }
        }

        return $result;
    }
}
