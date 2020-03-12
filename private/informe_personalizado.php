<?php
@session_start();
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=listado_trabajadores.xls");
header("Pragma: no-cache");
header("Expires: 0");

include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


if( $_SESSION && isAdmin() ){


    $sql = "select * from m_trabajador where empresa_id = 2 AND tipocontrato_id NOT IN (3,4)";
    $trabajadores = $db->rawQuery($sql);




$content = '<table class="table_header" border="1">';
$content .= '    <thead>';
$content .= '        <tr>';
$content .= '            <th> Apellido Paterno </th>';
$content .= '            <th> Apellido Materno </th>';
$content .= '            <th> Nombres </th>';
$content .= '            <th> Email </th>';
$content .= '            <th> Rut </th>';
$content .= '        </tr>';
$content .= '    </thead>';
$content .= '    <tbody>';
    foreach($trabajadores as $t){
        $content .= '        <tr>';
        $content .= '            <td> '. $t['apellidoPaterno'] .' </td>';
        $content .= '            <td> '. $t['apellidoMaterno'] .' </td>';
        $content .= '            <td> '. $t['nombres'] .' </td>';

        if( $t['email'] != "" ){
            $contruct_email = $t['email'];
            $content .= '           <td> '. $contruct_email .' </td>';
        } else {
            $contruct_email = strtoupper(substr($t['nombres'],0,1).$t['apellidoPaterno']."@tecnodatasa.cl");
            $content .= '           <td style="background-color:yellow"> '. $contruct_email .' </td>';
        }


        $content .= '            <td> '. $t['rut'] .' </td>';
        $content .= '        </tr>';
    }
$content .= '   </tbody>';
$content .= '</table>';


    echo $content;
}
?>
