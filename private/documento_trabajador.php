<?php
@session_start();
extract($_GET);
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


if( $_SESSION && isAdmin() ){   
        
        $trabajador_id = $_GET['trabajador_id'];
        $empresa_id = session('login_eid');
  
        /** Obtener el HTML del documento obtenido anteriormente **/        
        $db->where('id',$doc_id);
        $doc = $db->getOne("m_documento");        
        
        
        $db->where('id',$trabajador_id);
        $trabajador = $db->getOne('m_trabajador');

        
        $content = '<style type="text/css">';
        $content .= 'table{ font-size: 16px; width: 100%; }';
        $content .= '</style>';
        $content .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
        $content .= html_entity_decode($doc['texto']);
        $content .= "</page>";
         
        if( $trabajador['sexo'] == 1 ){
            $sexo = "";
        } else {
            $sexo = "a";
        }

        /** PROCESO PARA REEMPLAZAR TAGS **/
        $array_search = array(
            '{{ empresa.razonSocial }}',
            '{{ empresa.rut }}',
            '{{ empresa.direccion }}',
            '{{ empresa.ciudad }}',
            '{{ trabajador.nombreCompleto }}',
            '{{ trabajador.nombres }}',
            '{{ trabajador.apellidoPaterno }}',
            '{{ trabajador.apellidoMaterno }}',
            '{{ trabajador.rut }}',
            '{{ trabajador.direccion }}',
            '{{ trabajador.ciudad }}',
            '{{ trabajador.pais }}',
            '{{ trabajador.nacionalidad }}',
            '{{ trabajador.fechaNacimiento }}',
            '{{ trabajador.finiquito }}',
            '{{ trabajador.estadoCivil }}',
            '{{ trabajador.horario }}',
            '{{ trabajador.sueldoBase }}',
            '{{ trabajador.gratificacion }}',
            '{{ fecha1 }}',
            '{{ fecha2 }}'
        );

        $array_replace = array(
            getTag('{{ empresa.razonSocial }}', $empresa_id),
            getTag('{{ empresa.rut }}', $empresa_id),
            getTag('{{ empresa.direccion }}', $empresa_id),
            getTag('{{ empresa.ciudad }}', $empresa_id),
            getTag('{{ trabajador.nombreCompleto }}', $trabajador_id),
            getTag('{{ trabajador.nombres }}', $trabajador_id),
            getTag('{{ trabajador.apellidoPaterno }}', $trabajador_id),
            getTag('{{ trabajador.apellidoMaterno }}', $trabajador_id),
            getTag('{{ trabajador.rut }}', $trabajador_id),
            getTag('{{ trabajador.direccion }}', $trabajador_id),
            getTag('{{ trabajador.ciudad }}', $trabajador_id),
            getTag('{{ trabajador.pais }}', $trabajador_id),
            getTag('{{ trabajador.nacionalidad }}', $trabajador_id),
            getTag('{{ trabajador.fechaNacimiento }}', $trabajador_id),
            getTag('{{ trabajador.finiquito }}', $trabajador_id),
            getTag('{{ trabajador.estadoCivil }}', $trabajador_id),
            getTag('{{ trabajador.horario }}', $trabajador_id),
            getTag('{{ trabajador.sueldoBase }}', $trabajador_id),
            getTag('{{ trabajador.gratificacion }}', $trabajador_id),
            date('dd-mm-yyyy'),
            date('d') . ' de ' . getNombreMes(date('d')) . ' de ' . date('Y')
        );
         
        $content = str_replace( $array_search,$array_replace,$content );

        require_once('../libs/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF('P','LETTER','es');
        $html2pdf->WriteHTML($content);    
        $html2pdf->Output( 'carta_amonestacion.pdf');
     
}
?>
