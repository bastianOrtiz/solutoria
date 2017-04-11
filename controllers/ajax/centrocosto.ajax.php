<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$centrocostos = $db->get("m_centrocosto");
$empresas = $db->get("m_empresa");

function fnNombreEmpresa($id_empresa){
    global $empresas;    
    foreach( $empresas as $e ){
        if( $e['id'] == $id_empresa ){
            return $e['nombre'];
            break;
        }
    }
}


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $centrocosto = $db->getOne("m_centrocosto");
    
    if( $centrocosto ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $centrocosto['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $centrocosto['nombre'],
            "Empresa" => fnNombreEmpresa($centrocosto['empresa_id'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>