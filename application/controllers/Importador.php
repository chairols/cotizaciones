<?php

class Importador extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'productos_model'
        ));
    }
    
    public function index() {
        $fp = fopen("http://cotizaciones.local/assets/Genericos.csv", "r");
        while(!feof($fp)) {
            $linea = fgets($fp);
            $array = array(
                'category_id' => 0,
                'code' => trim($linea),
                'order_number' => intval(preg_replace('/[^0-9]+/', '', $linea), 10),
                'split' => str_split(trim($linea)),
                'creation_date' => date('Y-m-d H:i:s'),
                'organization_id' => 1
            );
            echo "<pre>";
            print_r($array);
            echo "</pre>";
            //$this->productos_model->set($array);
        }
        fclose($fp);
    }
}
?>