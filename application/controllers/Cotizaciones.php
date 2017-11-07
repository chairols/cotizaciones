<?php

class Cotizaciones extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session'
        ));
        $this->load->model(array(
            'clientes_model'
        ));
        $this->load->helper(array(
            'url'
        ));
        
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
    }
    
    public function agregar() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/cotizaciones/agregar/';
        
        $data['clientes'] = $this->clientes_model->gets();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('cotizaciones/agregar');
        $this->load->view('layout/footer');
    }
}
?>