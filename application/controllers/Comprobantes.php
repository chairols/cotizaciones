<?php

class Comprobantes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'form_validation'
        ));
        $this->load->model(array(
            'facturas_model'
        ));
        $this->load->helper(array(
            'url'
        ));
        
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
    }
    
    public function consulta() {
        $this->form_validation->set_rules('tipo_comprobante', 'Tipo de Comprobante', 'required');
        $this->form_validation->set_rules('numero', 'Número de Comprobante', 'required|numeric');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            
        }
        
        
        $data['session'] = $this->session->all_userdata();
        $data['tipos'] = $this->facturas_model->gets_tipos_comprobantes();
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('comprobantes/consulta');
        $this->load->view('layout/footer');
    }
}
?>