<?php

class Clientes_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        Clientes
                                    GROUP BY
                                        cliente
                                    ORDER BY
                                        cliente");
        
        return $query->result_array();
    }
    
    public function get_where($where) {
        $query = $this->db->get_where('Clientes', $where);
        return $query->row_array();
    }
}
?>