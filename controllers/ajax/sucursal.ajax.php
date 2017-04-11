<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

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

function fnNombreComuna($id_comuna){
    global $db;    
    $db->where('id', $id_comuna);
    $comuna = $db->getOne('m_comuna','nombre');
    return $comuna['nombre'];
}


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $sucursal = $db->getOne("m_sucursal");
    
    if( $sucursal ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $sucursal['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $sucursal['nombre'],
            "Direccion" => $sucursal['direccion'],
            "Empresa" => fnNombreEmpresa($sucursal['empresa_id']),
            "Comuna" => fnNombreComuna($sucursal['comuna_id'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
}


if( $_POST['action'] == 'get_comuna' ){
    
    $db->orderBy("nombre","ASC");
    $db->where ("region_id", $regid);
    $comunas = $db->get("m_comuna");
    
    if( $comunas ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        foreach( $comunas as $c ){
            $json['registros'][] = array(
                "id" => $c['id'],
                "nombre" => $c['nombre']
            );    
        }
        
    } else {
        $json['status'] = 'vacio';
        $json['mensaje'] = $db->getLastError();;   
    }     
}


$json = json_encode($json);
echo $json;

?>