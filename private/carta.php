<?php
@session_start();
extract($_GET);
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


if( $_SESSION && isAdmin() ){   
    
    if( 1==1 ){ // if( @$_SESSION[PREFIX.'carta_amonestacion'] ){
        
        unset($_SESSION[PREFIX.'carta_amonestacion']);
        $trabajador_id = base64_decode( base64_decode( $id ) );

        /** Proceso para guardar las amonestaciones **/
        $mes = date('m');
        $ano = date('Y');
        $sql = "
        SELECT * FROM t_amonestacion
        WHERE trabajador_id = $trabajador_id
        AND MONTH( fecha ) = '$mes'
        AND YEAR( fecha ) =  '$ano' 
        ";

        $result_amonestacion = $db->rawQuery( $sql );        
        $total_avisos = $db->count;

        if( $total_avisos <= 2 ){
            
            // Cartas generadas HOY, para determinar si INSERTAR o solo MOSTRAR
            $sql2 = "
            SELECT * FROM t_amonestacion
            WHERE trabajador_id = $trabajador_id
            AND fecha = '" . date('Y-m-d')."'";

            $result2 = $db->rawQuery( $sql2 );                        
            if( $db->count == 0 ){
                $data_insert = array(
                    'trabajador_id' => $trabajador_id,
                    'fecha' => date('Y-m-d')
                );
                $db->insert('t_amonestacion', $data_insert);      
                
                $total_avisos++;          
            }
            
        }
        if( @$_GET['aviso'] )
            $aviso_numero = $_GET['aviso'];
        else            
            $aviso_numero = $total_avisos; 


        $numeroAviso = $aviso_numero;
        if( $aviso_numero > 3 ){
            $numeroAviso = 3;
        }
        
        /** Obtener el ID del documento a usar, segun el Nro. de aviso **/
        $db->where('numeroAviso',$numeroAviso);
        $doc_id = $db->getValue('cartaaviso','documento_id');        

        
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
                   
        $atraso_incremento_hoy = getMinutosAtraso(date('Y-m-d'), $trabajador_id);
        $atraso_acumulado = getMinutosAtrasoMes(date('m'), date('Y'), $trabajador_id);;
        $atraso_numero = $atraso_acumulado['total_atrasos'];
        
        $numero_dia = ( date('w') - 1 );
        if( $numero_dia < 0 ){
            $numero_dia = 0;
        }
        
        /** Obtener los mintos de gracias de la empresa **/
        $db->where('id',$_SESSION[PREFIX.'login_eid']);
        $tope_atrasos = $db->getValue('m_empresa','minutoGracia');
        
        
        
        /** PROCESO PARA REEMPLAZAR TAGS **/
        $array_search = array(
            '#CARTA_FECHA#',
            '#CARTA_NUMERO_AVISO#',
            '#CARTA_SEXO#',
            '#CARTA_NOMBRE#',
            '#CARTA_DEPARTAMENTO#',
            '#CARTA_NUMERO_ATRASO_PALABRAS#',
            '#CARTA_NUMERO_ATRASO#',
            '#CARTA_FECHA_ATRASO#',
            '#CARTA_MINUTOS_INCREMENTO#',
            '#CARTA_MINUTOS_MES#',
            '#CARTA_TOPE_MINUTOS_ATRASO#'
        );
        $array_replace = array(
            'SANTIAGO, ' . date('d') . ' de ' . getNombreMes(date('n')) . ' de ' . date('Y'),
            $aviso_numero,
            $sexo,
            $trabajador['nombres'].' '.$trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'],
            strtoupper(getNombre($trabajador['departamento_id'],'m_departamento')),
            ordinalEnPalabras( $atraso_numero ),
            $atraso_numero,
            getNombreDia($numero_dia) . ', ' . date('d') . ' de ' . getNombreMes(date('n')) . ' de ' . date('Y'),
            $atraso_incremento_hoy,
            $atraso_acumulado['minutos'],
            $tope_atrasos
        );
         
        $content = str_replace( $array_search,$array_replace,$content );

        require_once('../libs/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF('P','LETTER','es');
        $html2pdf->WriteHTML($content);    
        $html2pdf->Output( 'carta_amonestacion.pdf');
    } else {
        echo "<h3>No se admite enlace directo</h3>(Debe generar la carta nuevamente desde la pantalla anterior)";
    } 
}
?>
