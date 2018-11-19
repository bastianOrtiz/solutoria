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

            $tag_ini = '{{';
            $tag_end = '}}';
            $string = $documento['texto'];
            $start_tags_found = strpos_recursive($string,$tag_ini);
            $end_tags_found = strpos_recursive($string,$tag_end);

            $arr_tgs_no_bd = ['fecha1','fecha2','trabajador.ciudad','trabajador.finiquito','trabajador.horario','trabajador.sueldoBase'];

            $array_search = [];
            foreach ($start_tags_found as $key => $pos) {
                $ini_pos = $pos;
                $end_pos = (($end_tags_found[$key] - $pos) + 2);
                $tag = substr($string,$pos,$end_pos);
                $array_search[] = $tag;
            }


            $array_replace = [];
            foreach ($array_search as $key => $tag) {
                //Limpiar tag
                $clean_tag = str_replace([$tag_ini, $tag_end, " "],"", $tag);
                
                if( !in_array($clean_tag, $arr_tgs_no_bd) ){
                    //Procesar la etiqueta para obtener  tabla.campo
                    $tag_parts = explode(".", $clean_tag);
                    $tag_DB_table = $tag_parts[0];
                    $tag_DB_field = $tag_parts[1];

                    //Consultar datos a la BD
                    $empresa_id = $_SESSION[PREFIX."login_eid"];
                    

                    switch ($tag_DB_table) {
                        case 'trabajador':
                            $db->where('id',$trabajador_id);
                            $db->where('empresa_id',$empresa_id);
                            break;
                        case 'empresa':
                            $db->where('id',$empresa_id);
                            break;
                        
                        default:
                            break;
                    }
                    $data = $db->getOne('m_'.$tag_DB_table,$tag_DB_field);
                    $array_replace[$key] = $data[$tag_DB_field];
                } else {

                    switch ($clean_tag) {
                        case 'fecha1':
                            $array_replace[$key] = date('d-m-Y');
                            break;

                        case 'fecha2':
                            $array_replace[$key] = date('d') . ' de ' . getNombreMes(date('n')) . ' de ' . date('Y');
                            break;

                        case 'trabajador.ciudad':
                            $db->where('id',$trabajador_id);
                            $db->where('empresa_id',$empresa_id);
                            $data = $db->getOne('m_trabajador','comuna_id');
                            $comuna_id = $data['comuna_id'];

                            $db->where('id',$comuna_id);
                            $comuna = $db->getOne('m_comuna','nombre');
                            $array_replace[$key] = $comuna['nombre'];
                            break;

                        case 'trabajador.finiquito':
                            $db->where('id',$trabajador_id); 
                            $db->where('empresa_id',$empresa_id);
                            $data = $db->getOne('m_trabajador','sueldoBase');

                            $array_replace[$key] = $data['sueldoBase'];
                            break;

                        case 'trabajador.horario':
                            $db->where('id',$trabajador_id); 
                            $db->where('empresa_id',$empresa_id);
                            $horario_id = $db->getValue('m_trabajador','horario_id');

                            $db->where('id',$horario_id);
                            $horario = $db->getValue('m_horario','nombre');
                            $array_replace[$key] = $horario;
                            break;

                        case 'trabajador.sueldoBase':
                            $db->where('id',$trabajador_id); 
                            $db->where('empresa_id',$empresa_id);
                            $sueldo_base = $db->getValue('m_trabajador','sueldoBase');
                            $sueldo_base = "$".number_format($sueldo_base,0,',','.');

                            $array_replace[$key] = $sueldo_base;
                            break;
                        
                        default:
                            # code...
                            break;
                    }

                }
            }
             
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

