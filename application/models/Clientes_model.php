<?php

class Clientes_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        clientes
                                    GROUP BY
                                        cliente
                                    ORDER BY
                                        cliente");
        
        return $query->result_array();
    }
}
?>