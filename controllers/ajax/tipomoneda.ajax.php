<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$tipomonedas = $db->get("m_tipomoneda");

if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $tipomoneda = $db->getOne("m_tipomoneda");
    
    $db->where ("tipomoneda_id", $regid);
    $db->orderBy("ano","DESC");
    $db->orderBy("mes","DESC");    
    $tipomonedavalores = $db->get("m_tipomonedavalor");
    
    if( $tipomoneda ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $tipomoneda['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $tipomoneda['nombre'],
            "Descripcion" => $tipomoneda['descripcion'],
            "Activo" => booleano($tipomoneda['activo'])
        );
        
        if( @$tipomonedavalores ){
        foreach( $tipomonedavalores as $tvalor ){
            $json['tipomonedavalores'][] = array(                
                $tvalor['valor'], 
                getNombreMes($tvalor['mes']),
                $tvalor['ano']
            );
        };
        } else {
            $json['tipomonedavalores'] = 'vacio';
        }
        
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>