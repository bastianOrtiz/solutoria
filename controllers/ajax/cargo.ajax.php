<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$cargos = $db->get("m_cargo");
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

function fnNombreCargo($id_cargo){
    global $cargos;    
    foreach( $cargos as $e ){
        if( $e['id'] == $id_cargo ){
            return $e['nombre'];
            break;
        } else {
            return 'Ninguno';
        }
    }
}


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $cargo = $db->getOne("m_cargo");
    
    if( $cargo ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $cargo['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $cargo['nombre'],
            "Cargo depende de" => fnNombreCargo($cargo['cargoPadreId']),
            "Activo" => booleano($cargo['activo']),
            "Empresa" => fnNombreEmpresa($cargo['empresa_id'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>