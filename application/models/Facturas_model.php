<?php

class Facturas_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function gets_tipos_comprobantes() {
        $query = $this->db->query("SELECT comprobanteDescripcion
                                    FROM 
                                        Facturas
                                    GROUP BY
                                        comprobanteDescripcion
                                    ORDER BY
                                        comprobanteDescripcion");
        return $query->result_array();
    }
    
    public function get_where($where) {
        /*$query = $this->db->query("SELECT *
                                    FROM
                                        Facturas f,
                                        Clientes c
                                    WHERE
                                        comprobanteDescripcion = '".$descripcion."' AND
                                        numeroFactura = '".$numero."' AND 
                                        f.numeroCliente = c.n_cliente");*/
        $query = $this->db->get_where('Facturas', $where);
        return $query->row_array();
    }
    
    public function get_cantidad_facturas() {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        Facturas");
        return $query->row_array();
    }
    
    public function gets_where_items($where) {
        $query = $this->db->get_where('ItemsFactura', $where);
        return $query->result_array();
    }
    
    public function set($datos) {
        $this->db->insert('Facturas', $datos);
        return $this->db->insert_id();
    }
    
    public function set_items($datos) {
        $this->db->insert('ItemsFactura', $datos);
    }
    
    public function get_ultimo_id_factura() {
        $query = $this->db->query("SELECT max(id) as id
                                    FROM
                                        Facturas");
        return $query->row_array();
    }
    
    public function gets_count() {
        $query = $this->db->query("SELECT 
                                        COUNT(*) as cantidad, 
                                        numeroFactura, 
                                        comprobante,
                                        comprobanteDescripcion
                                    FROM
                                        Facturas
                                    GROUP BY
                                        numeroFactura,
                                        comprobante,
                                        comprobanteDescripcion
                                    ORDER BY
                                        cantidad DESC");
        return $query->result_array();
    }
}
?>