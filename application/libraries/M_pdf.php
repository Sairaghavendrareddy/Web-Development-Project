<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/mpdf/autoload.php';


class M_pdf {

    public $param;
    public $mpdf;

    public function __construct()
    {
        $this->mpdf = new \Mpdf\Mpdf();}
}
