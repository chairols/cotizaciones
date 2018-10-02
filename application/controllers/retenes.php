<?php

class retenes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'form_validation'
        ));
        $this->load->model(array(
            'retenes_model'
        ));
        $this->load->helper(array(
            'url'
        ));
        
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
    }
    
    public function cargar() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/retenes/cargar/';
        
        $directorio = opendir('./upload/retenes/');
        while($archivo = readdir($directorio)) {
            if(!is_dir($archivo)) {
                $data['archivos'][] = $archivo;
            }
        }
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('retenes/cargar');
        $this->load->view('layout/footer');
    }
    
    public function upload() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/retenes/cargar/';
        
        $config['upload_path'] = "./upload/retenes/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;

        $this->load->library('upload', $config);
        $adjunto = null;

        if(!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            show_404();
        } else {
            $adjunto = array('upload_data' => $this->upload->data());
        }
        
    }
    
    public function procesar() {
        $data['session'] = $this->session->all_userdata();
        
        $directorio = opendir('./upload/retenes/');
        while($archivo = readdir($directorio)) {
            if(!is_dir($archivo)) {
                $data['archivos'][] = $archivo;
            }
        }
        
        $i = 0;
        
        
        $this->retenes_model->vaciar();
        
        foreach ($data['archivos'] as $archivo) {
            $fp = fopen('./upload/retenes/'.$archivo, "r");
            
            while($linea = fgets($fp)) {
                $linea = explode(";", $linea);
                $datos = array(
                    'reten' => $linea[0],
                    'disenio' => $linea[1],
                    'eje' => $linea[2],
                    'alojamiento' => $linea[3],
                    'altura' => $linea[4],
                    'precio' => str_replace(",", ".", $linea[5])
                );
                
                $this->retenes_model->set($datos);
                var_dump($linea);
                var_dump($datos);
            }
            
            unlink('./upload/retenes/'.$archivo);
        }
        
        $this->load->view('comprobantes/procesar', $data);
    }
    
    public function consultar() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/retenes/consultar/';
        
        $this->form_validation->set_rules('numero', 'Numero', 'required');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            $codigo = $this->input->post('numero');
            $data['retenes'] = $this->retenes_model->gets_where_codigo($codigo);
        }
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('retenes/consultar');
        $this->load->view('layout/footer');
    }
}
?>