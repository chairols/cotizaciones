<?php

class Facturas_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function gets_tipos_comprobantes() {
        $query = $this->db->query("SELECT comprobanteDescripcion
                                    FROM 
                                        facturas
                                    GROUP BY
                                        comprobanteDescripcion
                                    ORDER BY
                                        comprobanteDescripcion");
        return $query->result_array();
    }
}
?>