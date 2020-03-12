<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$afpvalors = $db->get("m_afpvalores");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $afpvalor = $db->getOne("m_afpvalores");
    
    if( $afpvalor ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $afpvalor['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $afpvalor['nombre'],
            "Descuenta" => booleano($afpvalor['descuenta'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>