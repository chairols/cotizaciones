<?php

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('layout/footer');
    }
}
?>