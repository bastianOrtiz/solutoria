<?php
@session_start();
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

if( $_SESSION && isAdmin() ){
    
    $informe_pago_imposiciones = $_SESSION[PREFIX . 'informe_pago_imposiciones'];
    
    $inicio_plazo_fijo_mes = $informe_pago_imposiciones['inicio_plazo_fijo_mes'];
    $licencias = $informe_pago_imposiciones['licencias'];
    $ausencias_no_justificadas = $informe_pago_imposiciones['ausencias_no_justificadas'];
    $indefinidos_mes = $informe_pago_imposiciones['indefinidos_mes'];
    $plazo_fijo_durante_mes = $informe_pago_imposiciones['plazo_fijo_durante_mes'];
    $plazo_a_indefinido = $informe_pago_imposiciones['plazo_a_indefinido'];
    $arr_paso_a_indefinido = $informe_pago_imposiciones['arr_paso_a_indefinido'];
    $despedidos = $informe_pago_imposiciones['despedidos'];
    
    
    
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