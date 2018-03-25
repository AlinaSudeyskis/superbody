<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Errors
 *
 * Класс для работы с ошибками страниц
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Errors extends CI_Controller
{
    public function error_404()
    {
        $this->load->view('errors/html/error_404', $this->page_data);
    }
}