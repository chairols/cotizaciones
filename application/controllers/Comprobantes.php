<?php

class Comprobantes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'form_validation',
            'pdf_factura'
        ));
        $this->load->model(array(
            'facturas_model',
            'clientes_model'
        ));
        $this->load->helper(array(
            'url'
        ));
        
        $session = $this->session->all_userdata();
        if(count($session) < 6) {
            redirect(base_url().'usuarios/login/', 'refresh');
        }
    }
    
    public function consulta() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/comprobantes/consulta/';
        
        $this->form_validation->set_rules('tipo_comprobante', 'Tipo de Comprobante', 'required');
        $this->form_validation->set_rules('numero', 'Número de Comprobante', 'required|numeric');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'comprobanteDescripcion' => $this->input->post('tipo_comprobante'),
                'numeroFactura' => $this->input->post('numero')
            );
            $data['factura'] = $this->facturas_model->get_where($datos);
            
            $datos = array(
                'n_cliente' => $data['factura']['numeroCliente']
            );
            $data['cliente'] = $this->clientes_model->get_where($datos);
        }
        
        
        $data['tipos'] = $this->facturas_model->gets_tipos_comprobantes();
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('comprobantes/consulta');
        $this->load->view('layout/footer');
    }
    
    public function pdf($idfactura = null, $modo = null) {
        
        if($idfactura != null && $modo != null) {
            $this->pdf = new Pdf_factura();
            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();
            
            $datos = array(
                'id' => $idfactura
            );
            $factura = $this->facturas_model->get_where($datos);
            
            $datos = array(
                'numeroFactura' => $factura['numeroFactura'],
                'comprobante' => $factura['comprobante'],
                'comprobanteDescripcion' => $factura['comprobanteDescripcion']
            );
            $items = $this->facturas_model->gets_where_items($datos);
            
            $this->pdf->SetFont('Arial','B',18);
            $this->pdf->SetXY(115, 16);
            $this->pdf->SetTextColor(0,0,0);
            $this->pdf->Cell(0,0,$factura['comprobante'],0,0,'L');
            
            $this->pdf->SetFont('Arial','B', 8);
            $this->pdf->SetXY(113, 20);
            $this->pdf->Cell(0,0,$factura['codigo'],0,0,'L');

            $this->pdf->SetFont('Arial','',8);
            $this->pdf->SetXY(130, 10);
            $this->pdf->Cell(0,0,$factura['comprobanteDescripcion'],0,0,'L');

            $this->pdf->SetXY(130, 15);
            $this->pdf->Cell(0,0,$factura['cabecera'],0,0,'L');

            $this->pdf->SetXY(130, 20);
            $this->pdf->Cell(0,0,$factura['fecha'],0,0,'L');
            
            
            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->SetXY(15, 58);
            $this->pdf->Cell(0,0,$factura['razonSocial1'],0,0,'L');

            $this->pdf->SetFont('Arial','B',9);
            $this->pdf->SetXY(15, 61);
            $this->pdf->Cell(0,0,$factura['razonSocial2'],0,0,'L');
            
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->SetXY(124, 61);
            $this->pdf->Cell(0,0,$factura['ordenDeCompra'],0,0,'L');

            $this->pdf->SetFont('Arial','',9);
            $this->pdf->SetXY(15, 64);
            $this->pdf->Cell(0,0,'DOMICILIO: ',0,0,'L');

            $this->pdf->SetFont('Arial','',9);
            $this->pdf->SetXY(35, 64);
            $this->pdf->Cell(0,0,$factura['direccion'],0,0,'L');

            $this->pdf->SetFont('Arial','',9);
            $this->pdf->SetXY(35, 67);
            $this->pdf->Cell(0,0,$factura['ciudad'],0,0,'L');

            $this->pdf->SetFont('Arial','',9);
            $this->pdf->SetXY(15, 70);
            $this->pdf->Cell(0,0,$factura['iva'],0,0,'L');

            $this->pdf->SetFont('Courier','',9);
            $this->pdf->SetXY(35, 84);
            $this->pdf->Cell(0,0,$factura['condicion1'],0,0,'L');

            $this->pdf->SetFont('Courier','',9);
            $this->pdf->SetXY(124, 84);
            $this->pdf->Cell(0,0,$factura['remitos'],0,0,'L');

            $this->pdf->SetFont('Courier','',9);
            $this->pdf->SetXY(35, 88);
            $this->pdf->Cell(0,0,$factura['condicion2'],0,0,'L');
            

            //Salto de línea
            $this->pdf->Ln(10);
            
            
            $Y = 96;
            $this->pdf->SetFont('Courier','',11);
            foreach($items as $item) {
                $this->pdf->SetXY(5, $Y);
                $this->pdf->Cell(0, 8, $item['descripcion'], 0, 1, 'L');
                $Y = $Y + 4;
            }
            
            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 185);
            $this->pdf->Cell(0,0,$factura['subtotal'],0,0,'L');
            
            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 190);
            $this->pdf->Cell(0,0,$factura['bonificacion'],0,0,'L');

            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 195);
            $this->pdf->Cell(0,0,$factura['gravado'],0,0,'L');

            
            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 200);
            $this->pdf->Cell(0,0,$factura['exento'],0,0,'L');

            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 205);
            $this->pdf->Cell(0,0,$factura['importeIva'],0,0,'L');

            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 210);
            $this->pdf->Cell(0,0,$factura['iibb'],0,0,'L');
            
            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 215);
            $this->pdf->Cell(0,0,$factura['iibb2'],0,0,'L');

            $this->pdf->SetFont('Courier','B',12);
            $this->pdf->SetXY(105, 220);
            $this->pdf->Cell(0,0,$factura['total'],0,0,'L');

            $this->pdf->SetFont('Courier', 'B', 10);
            $this->pdf->SetXY(10, 240);
            $this->pdf->Cell(0,0,$factura['dolar1'],0,0,'L');

            $this->pdf->SetXY(10, 244);
            $this->pdf->Cell(0,0,$factura['dolar2'],0,0,'L');
        
            // Footer
            $this->pdf->Pie($factura);
            
            
            
            
            
            
            
            $this->pdf->Output('Comprobante '.$idfactura.'.pdf', $modo);
        } 
    }
}
?>