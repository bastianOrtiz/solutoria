<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

function fnNombreComuna($id_comuna){
    global $db;    
    $db->where('id', $id_comuna);
    $comuna = $db->getOne('m_comuna','nombre');
    return $comuna['nombre'];
}

$json = array();
extract($_POST);

if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $empresa = $db->getOne("m_empresa");
    
    if( $empresa ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $empresa['nombre'];
        
        $json['registros'] = array(
            'Nombre' => $empresa['nombre'],
            'Rut' => $empresa['rut'],
            'Dirección' => $empresa['direccion'],
            'Giro' => $empresa['giro'],
            'Usa Reloj Control' => booleano($empresa['empleaRelojControl'])
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