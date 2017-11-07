<?php

class Usuarios_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function get_usuario($usuario, $password) {
        $query = $this->db->query("SELECT 
                                        id_usuarios,
                                        usuario_usuarios,
                                        nombre,
                                        apellido,
                                        email,
                                        corredor
                                    FROM
                                        Usuarios
                                    WHERE
                                        usuario_usuarios = '$usuario' AND
                                        password_usuarios = '$password'");
        return $query->row_array();
    }
}
?>