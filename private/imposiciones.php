<?php
@session_start();
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

if( $_SESSION && isAdmin() ){
        
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin != '0000-00-00'
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $inicio_plazo_fijo_mes = $db->rawQuery( $sql );        
       
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, A.trabajador_id, A.fecha_inicio, A.fecha_fin 
    FROM t_ausencia A, m_trabajador T
    WHERE ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 )
    AND ( month(fecha_inicio) = $mes OR month(fecha_fin) = $mes )
    AND ( year(fecha_inicio) = $year OR year(fecha_fin) = $year )
    AND T.id = A.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $licencias = $db->rawQuery( $sql ); 
    
    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');
    $sql = "
    SELECT CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, A.trabajador_id, A.fecha_inicio, A.fecha_fin 
    FROM t_ausencia A, m_trabajador T
    WHERE A.ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.descuenta = 1 )
    AND A.ausencia_id NOT IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 )
    AND ( month(fecha_inicio) = $mes OR month(fecha_fin) = $mes )
    AND ( year(fecha_inicio) = $year OR year(fecha_fin) = $year )
    AND T.id = A.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ";
    $ausencias_no_justificadas = $db->rawQuery( $sql );
    
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin = '0000-00-00'
    AND T.empresa_id = ".$_SESSION[PREFIX.'login_eid']."
    ORDER BY nombre ASC
    ";
    $indefinidos_mes = $db->rawQuery( $sql );
         
    
    $total_dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T
    WHERE T.fechaContratoFin != '0000-00-00'
    AND T.fechaContratoInicio < '$year-".leadZero($mes)."-01'
    AND T.fechaContratoFin >= '$year-".leadZero($mes)."-01'
    AND T.empresa_ID = " . $_SESSION[PREFIX.'login_eid'] ."
    AND T.tipocontrato_id != 4
    ORDER BY nombre ASC
    ";
    $plazo_fijo_durante_mes = $db->rawQuery( $sql );
    
        
    
    $array_plazo_a_indefinido = array();   
    $arr_paso_a_indefinido = array();
    $sql1 = "
    SELECT C.trabajador_id
    FROM t_contrato C, m_trabajador T
    where C.trabajador_id IN ( SELECT id FROM m_trabajador 
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." )
    AND T.id = C.trabajador_id
    group by trabajador_id HAVING SUM(activo)>1  
    ";
    $plazo_a_indefinido = $db->rawQuery( $sql1 );
    
    foreach( $plazo_a_indefinido as $p ){
        $sub_sql = "
        SELECT MAX(C.fechaInicio) as fechaContrato, concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre
        FROM t_contrato C, m_trabajador T
        WHERE C.trabajador_id = " . $p['trabajador_id']."
        AND C.activo = 1
        AND C.trabajador_id = T.id    
        ORDER BY nombre ASC 
        ";
        $subres = $db->rawQuery( $sub_sql );
        $array_plazo_a_indefinido[] = $subres[0];        
    }        
    
    
    foreach( $array_plazo_a_indefinido as $r ){        
        $time = strtotime( $r['fechaContrato'] );    
        if( ( date('n',$time) == $mes ) && ( date('Y',$time) == $year ) ){
            $arr_paso_a_indefinido[] = $r;
        }
    } 
    
    
    $sql = "
    SELECT concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre, T.fechaContratoFin
    FROM m_trabajador T
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." 
    AND tipocontrato_id IN (3,4)
    AND month(fechaContratoFin) = $mes
    AND year(fechaContratoFin) = $year
    ORDER BY nombre ASC
    ";        
    $despedidos = $db->rawQuery( $sql );       
    
    
    
    $super_html = '
    <style type="text/css">
    <!--
        table.table{ font-size: 12px; }
        table.table{ width: 100%; border-collapse:collapse; }
        table.table td{ border: 1px solid gray; padding: 2px 5px; }
        table.table th{ border: 1px solid gray; padding: 2px 5px; }
        
        table.col2 th{width: 50%;}
        table.col2 td{width: 50%;}
        
        table.col3 th{width: 33%;}
        table.col3 td{width: 33%;}
    -->
    </style>
    <page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">
    ';
    

    $super_html .= '<h3>Contratados a plazo fijo en el mes</h3>
    <table class="table col3">
        <thead>
            <tr>
                <th> Nombre </th>
                <th> Fecha Inicio Contrato </th>
                <th> Fecha fin Contrato </th>
            </tr>
        </thead>
        <tbody>
    ';
    foreach( $inicio_plazo_fijo_mes as $row ){
    $super_html .= '<tr>
                        <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>
                        <td>' . $row['fechaContratoInicio'] . '</td>
                        <td>' . $row['fechaContratoFin'] . '</td>
                    </tr>';
    }
    $super_html .= '</tbody></table>';
    

        
        
        
    $super_html .= '<hr><h3>Contratados indefinidos en el mes</h3>';
    $super_html .= '<table class="table col2">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Fecha Inicio </th>';                   
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $indefinidos_mes as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';
        $super_html .= '            <td>' . $row['fechaContratoInicio'] . '</td>';
        $super_html .= '        </tr>';
    }
    $super_html .= '    </tbody></table>';
        



    $super_html .= '<hr><h3>Contratos a plazo fijo</h3>';
    $super_html .= '<table class="table col3">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Fecha Inicio Contrato </th>';
    $super_html .= '            <th> Fecha fin Contrato </th>';
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $plazo_fijo_durante_mes as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';
        $super_html .= '            <td>' . $row['fechaContratoInicio'] . '</td>';
        $super_html .= '            <td>' . $row['fechaContratoFin'] . '</td>';
        $super_html .= '        </tr>';
    }
    $super_html .= '    </tbody>';
    $super_html .= '</table>';
                           
        
        
            
    $super_html .= '<hr><h3>Paso de plazo fijo a indefinido</h3>';
    $super_html .= '<table class="table col2">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Fecha Inicio Contrato Indefinido </th>';                                        
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $arr_paso_a_indefinido as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';
        $super_html .= '            <td>' . $row['fechaContrato'] . '</td>';
        $super_html .= '        </tr>';
    } 
    $super_html .= '    </tbody>';
    $super_html .= '</table>';
        
        
        
    $super_html .= '<hr><h3>Licencias</h3>';
    $super_html .= '<table class="table col3">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Desde </th>';
    $super_html .= '            <th> Hasta </th>';
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $licencias as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';
        $super_html .= '            <td>' . $row['fecha_inicio'] . '</td>';
        $super_html .= '            <td>' . $row['fecha_fin'] . '</td>';
        $super_html .= '        </tr>';
    }
    $super_html .= '    </tbody>';
    $super_html .= '</table>';
    
    
    
    
    $super_html .= '<hr><h3>Personas que faltaron</h3>';
    $super_html .= '<table class="table col3">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Desde </th>';
    $super_html .= '            <th> Hasta </th>';                                      
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $ausencias_no_justificadas as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';
        $super_html .= '            <td>' . $row['fecha_inicio'] . '</td>';
        $super_html .= '            <td>' . $row['fecha_fin'] . '</td>';
        $super_html .= '        </tr>';
    }
    $super_html .= '    </tbody>';
    $super_html .= '</table>';
    


    $super_html .= '<hr><h3 class="box-title">Despedidos</h3>';
    $super_html .= '<table class="table table-hover">';
    $super_html .= '    <thead>';
    $super_html .= '        <tr>';
    $super_html .= '            <th> Nombre </th>';
    $super_html .= '            <th> Fecha Fin Contrato </th>';                                        
    $super_html .= '        </tr>';
    $super_html .= '    </thead>';
    $super_html .= '    <tbody>';
    foreach( $despedidos as $row ){
        $super_html .= '        <tr>';
        $super_html .= '            <td style="text-transform: uppercase;">' . $row['nombre'] . '</td>';                                        
        $super_html .= '            <td>' . $row['fechaContratoFin'] . '</td>';
        $super_html .= '        </tr>';
    }
    $super_html .= '    </tbody>';
    $super_html .= '</table>';
    
    
    
    $super_html .= '</page>';
    $content = $super_html;
    require_once('../libs/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','LETTER','es');
    $html2pdf->WriteHTML($content);    
    $html2pdf->Output( 'informe_para_pago_de_imposiciones.pdf');
    
}

?>