<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$justificativos = $db->get("m_justificativo");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $justificativo = $db->getOne("m_justificativo");
    
    if( $justificativo ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $justificativo['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $justificativo['nombre'],
            "Descuenta" => booleano($justificativo['descuenta'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>