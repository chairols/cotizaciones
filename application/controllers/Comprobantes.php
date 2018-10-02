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
    
    public function cargar() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/comprobantes/cargar/';
        $data['archivos'] = array();
        $data['valores'] = array();
        
        $directorio = opendir('./upload/');
        while($archivo = readdir($directorio)) {
            if(!is_dir('./upload/'.$archivo)) {
                $data['archivos'][] = $archivo;
            }
        }
        
        $i = 0;
        foreach ($data['archivos'] as $archivo) { 
            $fp = fopen('./upload/'.$archivo, "r");
            fgets($fp);  //  PRINTER1
            $data['valores'][$i]['comprobante'] = trim(fgets($fp));
            $data['valores'][$i]['comprobanteDescripcion'] = trim(fgets($fp));
            $data['valores'][$i]['codigo'] = trim(fgets($fp));
            $data['valores'][$i]['cabecera'] = trim(fgets($fp));
            $data['valores'][$i]['numeroFactura'] = substr($data['valores'][$i]['cabecera'], 34, 8);
            $data['valores'][$i]['fecha'] = trim(fgets($fp));
            $data['valores'][$i]['razonSocial1'] = trim(fgets($fp));
            $data['valores'][$i]['numeroCliente'] = substr($data['valores'][$i]['razonSocial1'], 33, 4);
            $data['valores'][$i]['proveedor'] = trim(fgets($fp));
            $data['valores'][$i]['razonSocial2'] = trim(fgets($fp));
            $data['valores'][$i]['ordenDeCompra'] = trim(fgets($fp));
            $data['valores'][$i]['direccion'] = trim(fgets($fp));
            $data['valores'][$i]['ciudad'] = trim(fgets($fp));
            $data['valores'][$i]['iva'] = trim(fgets($fp));
            $data['valores'][$i]['condicion1'] = trim(fgets($fp));
            $data['valores'][$i]['remitos'] = trim(fgets($fp));
            $data['valores'][$i]['condicion2'] = trim(fgets($fp));
            // Comienzo de lectura de Items
            for($j = 0; $j < 15; $j++) {
                $item = trim(fgets($fp));
                if($item != '') {
                    $data['items'][$i][] = $item;
                }
            }
            // Fin de lectura de items
            $data['valores'][$i]['subtotal'] = trim(fgets($fp));
            $data['valores'][$i]['bonificacion'] = trim(fgets($fp));
            $data['valores'][$i]['gravado'] = trim(fgets($fp));
            $data['valores'][$i]['exento'] = trim(fgets($fp));
            $data['valores'][$i]['importeIva'] = trim(fgets($fp));
            $data['valores'][$i]['iibb'] = trim(fgets($fp));
            $data['valores'][$i]['iibb2'] = trim(fgets($fp));
            $data['valores'][$i]['total'] = trim(fgets($fp));
            $data['valores'][$i]['nroCae'] = trim(fgets($fp));
            $data['valores'][$i]['vtoCae'] = trim(fgets($fp));
            $data['valores'][$i]['cae'] = $this->calcularDigitoVerificador(trim(fgets($fp)));
            $data['valores'][$i]['codigoDeBarras'] = $this->calcularCodigoDeBarras(trim(fgets($fp)));
            $data['valores'][$i]['copia'] = trim(fgets($fp));
            $data['valores'][$i]['dolar1'] = trim(fgets($fp));
            $data['valores'][$i]['dolar2'] = trim(fgets($fp));
            
            while(!feof($fp)) {
                $data['val'][] = fgets($fp);
            }
            $i++;
        }
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('comprobantes/cargar');
        $this->load->view('layout/footer');
    }
    
    private function calcularDigitoVerificador($cae) {
        $c = 0;
        $par = 0;
        $impar = 0;
        $i = 0;
        
        for($i = 0; $i < strlen($cae); $i++) {
            $impar += substr($cae, $i, 1);
            $i++;
        }
        for($i = 1; $i < strlen($cae); $i++) {
            $par += substr($cae, $i, 1);
            $i++;
        }
        
        $impar *= 3;
        $resultado = $impar + $par;
        
        $r = "";
        $r = (string) $resultado;
        $r = substr($r, strlen($r)-1, strlen($r));
        
        if($r > 0) {
            $r = 10 - $r;
        } 
        
        
        return $cae.$r;
    }
    
    private function calcularCodigoDeBarras($cae) {
        $aux = 0;
        $str = "";
        $cae = $this->calcularDigitoVerificador($cae);
        
        for($i = 0; $i < strlen($cae); $i++) {
            $aux = substr($cae, $i, $i+2);
            if($aux <= 49) {
                $aux = $aux + 48;
            } else {
                $aux = $aux + 142;
            }
            $str .= chr($aux).')';
            $i++;
        }
        
        $s = "";
        for($i = 0; $i < strlen($str); $i++) {
            if(substr($str, $i, 1) == chr(92)) {
                $s .= chr(92);
            }
            $s .= substr($str, $i, 1);
        }
        
        return $s;
    }
    
    public function upload() {
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = '/comprobantes/cargar/';
        
        $config['upload_path'] = "./upload/";
        $config['allowed_types'] = 'txt';
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;

        $this->load->library('upload', $config);
        $adjunto = null;

        if(!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            show_404();
        } else {
            $adjunto = array('upload_data' => $this->upload->data());
        }
        
    }
    
    public function procesar() {
        $data['session'] = $this->session->all_userdata();
        
        $directorio = opendir('./upload/');
        while($archivo = readdir($directorio)) {
            if(!is_dir('/upload/'.$archivo)) {
                $data['archivos'][] = $archivo;
            }
        }
        
        $i = 0;
        $data['agregados'] = array();
        $data['existentes'] = array();
        
        foreach ($data['archivos'] as $archivo) {
            $fp = fopen('./upload/'.$archivo, "r");
            fgets($fp);  //  PRINTER1
            $data['valores'][$i]['comprobante'] = trim(fgets($fp));
            $data['valores'][$i]['comprobanteDescripcion'] = trim(fgets($fp));
            $data['valores'][$i]['codigo'] = trim(fgets($fp));
            $data['valores'][$i]['cabecera'] = trim(fgets($fp));
            $data['valores'][$i]['numeroFactura'] = substr($data['valores'][$i]['cabecera'], 34, 8);
            $data['valores'][$i]['fecha'] = trim(fgets($fp));
            $data['valores'][$i]['razonSocial1'] = htmlspecialchars(trim(fgets($fp)));
            $data['valores'][$i]['numeroCliente'] = substr($data['valores'][$i]['razonSocial1'], 33, 4);
            $data['valores'][$i]['proveedor'] = trim(fgets($fp));
            $data['valores'][$i]['razonSocial2'] = trim(fgets($fp));
            $data['valores'][$i]['ordenDeCompra'] = trim(fgets($fp));
            $data['valores'][$i]['direccion'] = trim(fgets($fp));
            $data['valores'][$i]['ciudad'] = trim(fgets($fp));
            $data['valores'][$i]['iva'] = trim(fgets($fp));
            $data['valores'][$i]['condicion1'] = trim(fgets($fp));
            $data['valores'][$i]['remitos'] = trim(fgets($fp));
            $data['valores'][$i]['condicion2'] = trim(fgets($fp));
            // Comienzo de lectura de Items
            for($j = 0; $j < 15; $j++) {
                $item = fgets($fp);
                if(strlen($item) > 10) {
                    $data['items'][$i][] = array(
                        'numeroFactura' => $data['valores'][$i]['numeroFactura'],
                        'comprobante' => $data['valores'][$i]['comprobante'],
                        'comprobanteDescripcion' => $data['valores'][$i]['comprobanteDescripcion'],
                        'descripcion' => $item
                    );
                }
            }
            // Fin de lectura de items
            $data['valores'][$i]['subtotal'] = trim(fgets($fp));
            $data['valores'][$i]['bonificacion'] = trim(fgets($fp));
            $data['valores'][$i]['gravado'] = trim(fgets($fp));
            $data['valores'][$i]['exento'] = trim(fgets($fp));
            $data['valores'][$i]['importeIva'] = trim(fgets($fp));
            $data['valores'][$i]['iibb'] = trim(fgets($fp));
            $data['valores'][$i]['iibb2'] = trim(fgets($fp));
            $data['valores'][$i]['total'] = trim(fgets($fp));
            $data['valores'][$i]['nroCae'] = trim(fgets($fp));
            $data['valores'][$i]['vtoCae'] = trim(fgets($fp));
            $data['valores'][$i]['cae'] = $this->calcularDigitoVerificador(trim(fgets($fp)));
            $data['valores'][$i]['codigoDeBarras'] = ''; //$this->calcularCodigoDeBarras(trim(fgets($fp)));
            $data['valores'][$i]['copia'] = trim(fgets($fp));
            if(!feof($fp)) {
                $data['valores'][$i]['copia'] = trim(fgets($fp));
            }
            if(!feof($fp)) {
                $data['valores'][$i]['dolar1'] = trim(fgets($fp));
            }
            if(!feof($fp)) {
                $data['valores'][$i]['dolar2'] = trim(fgets($fp));
            }
            if(!feof($fp)) {
                $data['valores'][$i]['dolar3'] = trim(fgets($fp));
            }
            
            fclose($fp);
            
            $datos = array(
                'numeroFactura' => $data['valores'][$i]['numeroFactura'],
                'comprobante' => $data['valores'][$i]['comprobante'],
                'comprobanteDescripcion' => $data['valores'][$i]['comprobanteDescripcion']
            );
            
            $data['resultados'][$i]['resultado'] = $this->facturas_model->get_where($datos);
            
            
            if(count($data['resultados'][$i]['resultado']) == 0) {
                //$data['ultimoid'] = $this->facturas_model->get_ultimo_id_factura();
                //$data['valores'][$i]['id'] = $data['ultimoid']['id'] + 1;
                $id = $this->facturas_model->set($data['valores'][$i]);
                foreach($data['items'][$i] as $item) {
                    $this->facturas_model->set_items($item);
                }
                
                $data['agregados'][] = $data['valores'][$i];
                unlink("./upload/".$archivo);
            } else {
                $data['existentes'][] = $data['valores'][$i];
                unlink("./upload/".$archivo);
            }
            
            
            $i++;
        }
        
        $this->load->view('comprobantes/procesar', $data);
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
            
            $this->pdf->SetXY(10, 248);
            $this->pdf->Cell(0,0,$factura['dolar3'],0,0,'L');
        
            // Footer
            $this->pdf->Pie($factura);
            
            
            $this->pdf->Output('Comprobante '.$idfactura.'.pdf', $modo);
        } 
    }
}
?>