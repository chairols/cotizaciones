<?php

class retenes_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function vaciar() {
        $query = $this->db->query("TRUNCATE TABLE retenes;");
        
    }
    
    public function set($datos) {
        $this->db->insert('retenes', $datos);
        return $this->db->insert_id();
    }
    
    public function gets_where_codigo($codigo) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        retenes
                                    WHERE
                                        reten LIKE '%$codigo%'");
        return $query->result_array();
    }
}
?>