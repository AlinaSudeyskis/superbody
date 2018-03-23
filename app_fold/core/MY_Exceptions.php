<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by Alina Sudeyskis (alina.sudeyskis@gmail.com).
 * Date: 06.07.2017 11:32
 */
class MY_Exceptions extends CI_Exceptions
{
    protected $CI;

    /**
     * MY_Exceptions constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    /**
     * Exception Logger
     *
     * Метод заменяет базовый добавляя возможности
     * отсылать сообщению администратору сайта о ошибках
     * и выводить дополнительную информацию в лог
     *
     * @access	private
     * @param	string	$severity the error severity
     * @param	string	$message the error string
     * @param	string	$filepath the error filepath
     * @param	string	$line the error line number
     * @return	void
     */
    public function log_exception($severity, $message, $filepath, $line)
    {
        $severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

        // Дополняем текст сообщения дампам переменных окружения
        $message .= "\n" . $this->GetGlobalVariables() . $filepath.' '.$line . "\n\n";

        log_message('error', 'Severity: '.$severity.'  --> '.$message, TRUE);
    }

    /**
     * Возвращает дамп переменных окружения
     *
     * @return string дамп переменных окружения
     */
    public function GetGlobalVariables()
    {
        $content = 'REMOTE_ADDR = '.$_SERVER["REMOTE_ADDR"]."\n";

        if (isset($_SERVER["HTTP_REFERER"]))
        {
            $content .= 'HTTP_REFERER = '.$_SERVER["HTTP_REFERER"]."\n";
        }

        $content .= 'USER_AGENT = '.$_SERVER["HTTP_USER_AGENT"]."\n";
        $content .= '$_SERVER[\'REQUEST_URI\'] = ';
        $content .=  var_export(@$_SERVER['REQUEST_URI'], true);
        $content .= "\n".'$_GET = ';
        $content .=  var_export(@$_GET, true);
        $content .= "\n".'$_POST = ';
        $content .=  var_export(@$_POST, true);
        $content .= "\n";

        return $content;
    }
}