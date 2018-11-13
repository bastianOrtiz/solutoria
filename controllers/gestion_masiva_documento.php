<?php

if( $_POST ){

    if( $_POST['action'] == 'generar_documento' ){ 

        $db->where('id',$_POST['documento']);
        $documento = $db->getOne('m_documento');
        
        $pdf_output = '';
        foreach($_POST['trabajadorDocumentoMasivo'] as $trabajador_id => $trabajador){
            $pdf_output .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
            $pdf_output .= html_entity_decode($documento['texto']);
            $pdf_output .= "</page>";

            $db->where('id',$trabajador_id);
            $trabajador = $db->getOne('m_trabajador');

            /** PROCESO PARA REEMPLAZAR TAGS **/
            $array_search = array(
                '{{ trabajador.nombre }}'
            );
            $array_replace = array(
                $trabajador['nombres'].' '.$trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno']
            );
             
            $pdf_output = str_replace( $array_search,$array_replace,$pdf_output );
        }


        require_once( ROOT . '/libs/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF('P','LETTER','es');
        $html2pdf->WriteHTML($pdf_output);        
        $html2pdf->Output( 'informe.pdf');
    }

}

$documents = $db->get('m_documento');

$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$db->orderBy("apellidoPaterno","ASC");
$trabajdores_todos = $db->get('m_trabajador');



include ROOT . '/views/comun/header.php';
include ROOT . '/views/comun/menu_top.php';
include ROOT . '/views/comun/menu_sidebar.php';

if( isset($parametros[0]) ){
    if( file_exists(ROOT . '/views/' . strtolower($entity) . '/' . $parametros[0] . '.php') ){
        include ROOT . '/views/' . $entity . '/' . $parametros[0] . '.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> Not Found </h2> </section></div>';
    }
} else {
    if( file_exists( ROOT . '/views/' . strtolower($entity) . '/dashboard.php') ){
        include ROOT . '/views/' . $entity .  '/dashboard.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> '. strtoupper($entity) .' </h2> </section></div>';
    }    
}

include ROOT . '/views/comun/footer.php';

?>

