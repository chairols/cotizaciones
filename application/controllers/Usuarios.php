<?php

class Usuarios extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'form_validation',
            'session'
        ));
        $this->load->model(array(
            'usuarios_model'
        ));
        $this->load->helper(array(
            'url'
        ));
    }
    
    public function login() {
        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            $usuario = $this->usuarios_model->get_usuario($this->input->post('usuario'), $this->input->post('password'));
            if(!empty($usuario)) {
                $datos = array(
                    'SID' => $usuario['id_usuarios'],
                    'usuario' => $usuario['usuario_usuarios'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'correo' => $usuario['email'],
                    'botonmenu' => 0,
                    'tipo_usuario' => $usuario['corredor']
                );
                $this->session->set_userdata($datos);
                redirect(base_url().'dashboard/', 'refresh');
            }
        }
        
        $session = $this->session->all_userdata();
        if(!empty($session['SID'])) {
            redirect(base_url().'dashboard/', 'refresh');
        } else {
            $this->load->view('usuarios/login');
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url().'usuarios/login/', 'refresh');
    } 
}
?>