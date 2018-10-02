<?php

class Productos_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function set($array) {
        $this->db->insert('product_abstract', $array);
    }
    
    
    public function get_where($where) {
        $query = $this->db->get_where('product', $where);
        
        return $query->row_array();
    }
    
    public function update($datos, $product_id) {
        $id = array('product_id' => $product_id);
        $this->db->update('product', $datos, $id);
    }
    
    public function get_cantidad_productos() {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        product");
        return $query->row_array();
    }
    
    public function set_product($array) {
        $this->db->insert('product', $array);
    }
}
?>