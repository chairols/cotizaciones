<?php

class Cotizaciones_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function get_cantidad_cotizaciones() {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        Cotizaciones");
        return $query->row_array();
    }
}
?>

