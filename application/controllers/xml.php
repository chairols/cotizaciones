<?php

class Xml extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function generar() {
        $xml = new DOMDocument('1.0', 'UTF-8');
        
        $ddjjSifereWeb = $xml->createElement('ddjjSifereWeb');
        $ddjjSifereWeb = $xml->appendChild($ddjjSifereWeb);
        
        $cabecera = $xml->createElement('cabecera');
        $cabecera->setAttribute('id', '1321651651');
        $cabecera->setAttribute('cuit', '33647656779');
        $cabecera->setAttribute('periodo', '201801');
        $cabecera->setAttribute('timestamp', time());
        $cabecera->setAttribute('coeficienteDistribucion', '0.047');
        $cabecera->setAttribute('articulo14', 'NO');
        $ddjjSifereWeb = $ddjjSifereWeb->appendChild($cabecera);
        
        $facturacion = $xml->createElement('facturacion');
        $facturacion->setAttribute('ingresosGravados', 14345151.12);
        $facturacion->setAttribute('ingresosNoGravados', '0.00');
        $facturacion->setAttribute('ingresosExentos', '0.00');
        $ddjjSifereWeb = $ddjjSifereWeb->appendChild($facturacion);
        
        $actividades = $xml->createElement('actividades');
        $ddjjSifereWeb = $ddjjSifereWeb->appendChild($actividades);
        
        
        for($i = 0; $i < 10; $i++) {
            $actividad = $xml->createElement('actividad');
            $actividad->setAttribute('regimenArticulo', 2);
            $actividad->setAttribute('cuacm', rand(111111, 999999));
            $actividad->setAttribute('tratamientoFiscal', 0);
            $actividad->setAttribute('baseImponible', rand(100, 9999999) / 100);
            $actividad->setAttribute('ajusteBaseImponible', '0.00');
            $actividad->setAttribute('alicuota', rand(1, 5));
            
            $actividades = $ddjjSifereWeb->appendChild($actividad);
        }
        
        $el_xml = $xml->saveXML();
        header ("Content-Type:text/xml");
        echo $el_xml;
        
    }
}
?>
