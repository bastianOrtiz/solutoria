<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$descuentos = $db->get("m_descuento");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $descuento = $db->getOne("m_descuento");
    
    if( $descuento ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $descuento['nombre'];
        
        $json['registros'] = array(            
            "Nombre" => $descuento['nombre'],
            "Fijo" => booleano($descuento['fijo']),
            "Valor Predeterminado" => booleano($descuento['valorPredeterminado']),
            "Tipo Moneda" => fnGetNombre($descuento['tipomoneda_id'], 'm_tipomoneda'),
            "Valor" => $descuento['valor'],
            "Activo" => booleano($descuento['activo'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>