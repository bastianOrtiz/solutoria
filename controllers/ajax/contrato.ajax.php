<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$contratos = $db->get("m_contrato");
if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $contrato = $db->getOne("m_contrato");
    
    if( $contrato ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $contrato['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $contrato['nombre'],
            "Descripción" => $contrato['descripcion'],
            "Activo" => booleano($contrato['activo'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>