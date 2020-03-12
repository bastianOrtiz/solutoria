<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

sleep(1);

if( $_POST['action'] == 'activar_caja' ){

    $db->update('m_cajacompensacion',['activa'=>0]);
    
    $db->where ("id", $regid);
    $db->update('m_cajacompensacion',['activa'=>1]);
    $json = ['msg' => 'ok'];
    
}

$json = json_encode($json);
echo $json;

?>