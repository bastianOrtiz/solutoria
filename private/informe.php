<?php
@session_start();

include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';
if( $_SESSION && isAdmin() ){   

extract($_GET);

$db->where("id",$_SESSION[PREFIX.'login_eid']);
$umbral = $db->getValue('m_empresa','umbralRelojControl');

$db->where('id',$trabajador_id);
$trabajador = $db->getOne('m_trabajador');
$nombre_completo = $trabajador['apellidoPaterno'] . ' ' . $trabajador['apellidoMaterno'] . ' ' . $trabajador['nombres'];
$reloj_control_id = $trabajador['relojcontrol_id'];

$db->where('id',$trabajador_id);
$horario_id = $db->getValue('m_trabajador','horario_id');

$db->where('id',$horario_id);
$horario_entrada = $db->getValue('m_horario','entradaTrabajo');

$sql = "
SELECT *  FROM `m_relojcontrol` 
WHERE `userid` = $reloj_control_id 
AND time(checktime) > '$horario_entrada'
AND time(checktime) < '$umbral'
AND date(checktime) >= '2016-01-01'
AND date(checktime) <= '2016-12-31'
";
$result = $db->rawQuery( $sql );

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=listado_atrasos_". slugify($nombre_completo) .".xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

?>
<table>
    <thead>
        <tr>
            <td colspan="3">Informe de atrasos: <?php echo $nombre_completo; ?> </td>
        </tr>        
        <tr>
            <td> Fecha </td>
            <td> Hora Marcada </td>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach( $result as $res ){
        $time = strtotime($res['checktime']);
        ?>
        <tr>
            <td> <?php echo date('d-m-Y',$time) ?> </td>
            <td> <?php echo date('h:i',$time) ?> </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</form>

<?php

} else {
    echo "Acceso Denegado";
}

?>