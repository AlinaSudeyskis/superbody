<?php

/**
 * Created by Alina Sudeyskis (alina.sudeyskis@gmail.com).
 * Date: 13.06.2018 13:48
 */
class Excel
{
    private $excel;

    /**
     * Excel constructor.
     */
    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    /**
     * @param $path
     */
    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    /**
     * @param $path
     */
    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    /**
     * @param $filename
     */
    public function stream($filename) {
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|null
     */
    public function  __call($name, $arguments) {
        // make sure our child object has this method
        if(method_exists($this->excel, $name)) {
            // forward the call to our child object
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }
}