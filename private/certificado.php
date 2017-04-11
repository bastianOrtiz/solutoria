<?php
@session_start();
extract($_POST);
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


if( $_SESSION && isAdmin() ){   
    
    if( 1==1 ){ // if( @$_SESSION[PREFIX.'carta_amonestacion'] ){                       
        
        /** Obtener el HTML del documento obtenido anteriormente **/
        $doc_id = 4;        
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
        
        $numero_dia = ( date('w') - 1 );
        if( $numero_dia < 0 ){
            $numero_dia = 0;
        }
        
        $db->where('id',$trabajador['empresa_id']);
        $empresa = $db->getOne('m_empresa');
        

        $db->where('trabajador_id',$trabajador_id);
        $db->where('activo',1);
        $db->orderBy('fechaInicio','ASC');
        $contratos = $db->get('t_contrato',null,array('fechaInicio','tipocontrato_id'));
        
        if( count($contratos) == 0 ){            
            redirect(BASE_URL."/trabajador/editar/$trabajador_id#tab_2",302,true,'El trabajador no tiene contratos asociados\n(Redireccionado a la ficha del trabajador...)');
            exit();
        }
        
        $contrato_inicio_time = strtotime($contratos[0]['fechaInicio']);        
        $fecha_contrato = date('d',$contrato_inicio_time) . ' de ' . getNombreMes(date('m',$contrato_inicio_time)) . ' del ' . date('Y',$contrato_inicio_time);
        
        $index_contratos = ( count($contratos) - 1 );
        $tipocontrato_id = $contratos[$index_contratos]['tipocontrato_id'];
        
        $tipo_contrato = getTipoContrato($tipocontrato_id);          
        
        /** PROCESO PARA REEMPLAZAR TAGS **/
        $array_search = array(
            '#CARTA_FECHA#',        
            '#CARTA_SEXO#',
            '#CARTA_NOMBRE#',
            '#CARTA_DEPARTAMENTO#',                        
            '#CARTA_FECHA_ATRASO#',
            '#CARTA_RUT_TRABAJADOR#',
            '#CARTA_EMPRESA#',
            '#CARTA_RUT_EMPRESA#',
            '#CARTA_FECHA_CONTRATO#',
            '#CARTA_CARGO#',
            '#CARTA_TIPO_CONTRATO#'
        );        
        $array_replace = array(
            date('d') . ' de ' . getNombreMes(date('n')) . ' de ' . date('Y'),            
            $sexo,
            $trabajador['nombres'].' '.$trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'],
            strtoupper(getNombre($trabajador['departamento_id'],'m_departamento')),                        
            getNombreDia($numero_dia) . ', ' . date('d') . ' de ' . getNombreMes(date('n')) . ' de ' . date('Y'),
            $trabajador['rut'],
            strtoupper(getNombre($trabajador['empresa_id'],'m_empresa',false)),
            $empresa['rut'],
            $fecha_contrato,
            strtoupper(getNombre( $trabajador['cargo_id'],'m_cargo',false )),
            strtoupper($tipo_contrato)
        );
         
        $content = str_replace( $array_search,$array_replace,$content );
        
        
        require_once('../libs/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF('P','LETTER','es');
        $html2pdf->WriteHTML($content);    
        $html2pdf->Output( 'carta.pdf');
    } else {
        echo "<h3>No se admite enlace directo</h3>(Debe generar la carta nuevamente desde la pantalla anterior)";
    } 
}
?>