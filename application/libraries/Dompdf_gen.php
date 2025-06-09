<?php
use Dompdf\Dompdf;

class Dompdf_gen {
    public function __construct()
    {
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        // Dapatkan instance CodeIgniter
        $CI =& get_instance();
        
        // Simpan Dompdf ke controller yang memanggil
        $CI->dompdf = new Dompdf();
    }
}
