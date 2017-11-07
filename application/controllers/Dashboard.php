<?php

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session'
        ));
        $this->load->model(array(
            'facturas_model',
            'cotizaciones_model'
        ));
        $this->load->helper(array(
            'url'
        ));
        
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
    }
    
    public function index() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/dashboard/';
        
        $data['comprobantes'] = $this->facturas_model->get_cantidad_facturas();
        $data['cotizaciones'] = $this->cotizaciones_model->get_cantidad_cotizaciones();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('dashboard/index');
        $this->load->view('layout/footer');
    }
}
?>