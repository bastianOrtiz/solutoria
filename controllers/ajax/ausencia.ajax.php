<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$ausencias = $db->get("m_ausencia");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $ausencia = $db->getOne("m_ausencia");
    
    if( $ausencia ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $ausencia['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $ausencia['nombre'],
            "Descuenta" => booleano($ausencia['descuenta'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>