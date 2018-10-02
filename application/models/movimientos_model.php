<?php

class movimientos_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function set($datos) {
        $this->db->insert('movimientos', $datos);
        return $this->db->insert_id();
    }
    
    public function truncate() {
        $this->db->query("truncate table movimientos");
    }
}
?>