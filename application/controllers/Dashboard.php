<?php

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session'
        ));
    }
    
    public function index() {
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
        
        $data['session'] = $session;
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('layout/footer');
    }
}
?>