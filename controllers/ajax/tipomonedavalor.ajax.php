<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$tipomonedavalors = $db->get("m_tipomonedavalor");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $tipomonedavalor = $db->getOne("m_tipomonedavalor");
    
    if( $tipomonedavalor ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $tipomonedavalor['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $tipomonedavalor['nombre'],
            "Descuenta" => booleano($tipomonedavalor['descuenta'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>