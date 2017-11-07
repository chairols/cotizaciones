<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf_factura extends FPDF {
        var $factura = null;
        
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
            $this->Image('assets/img/electronica.jpg',0,0,210,297);
            
       }
       // El pie del pdf
       public function Footer(){
           
           
           //Posición: a 1,5 cm del final
            $this->SetY(-15);
            //Arial italic 8
            $this->SetFont('Courier','B',10);
            //Número de página
            //$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
            $this->SetXY(10, -30);
            $this->Cell(0,10,$this->factura['copia'],0,0,'');

            //$this->SetFont('i2of5','',24);
            //$this->SetFont('ccode39','',10);
            //$this->SetXY(70, -33);
            //$this->Cell(0,0,'('.$factura['codigoDeBarras'].')',0,0,'L');  

            $this->SetFont('Courier','B',8);
            $this->SetXY(72, -28);
            $this->Cell(0,0,$this->factura['cae'],0,0,'L');

            $this->SetFont('Courier','',7);
            $this->SetXY(160, -28);
            $this->Cell(0,0,$this->factura['nroCae'],0,0,'L');

            $this->SetFont('Courier','',7);
            $this->SetXY(160, -25);
            $this->Cell(0,0,$this->factura['vtoCae'],0,0,'L');
       }
       
       public function Pie($fac) {
           $this->factura = $fac;
       }
    }
?>