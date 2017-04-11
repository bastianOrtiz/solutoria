<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';
include ROOT . '/models/tope.php';

$json = array();
extract($_POST);

if( $action == 'add_tope' ){
    usleep(250000);        
    $data = array(
        'codigo' => $codigo,
        'valor' => $valor,
        'usuario_id' => $_SESSION[PREFIX.'login_uid']
    );
    
    $db->where("codigo", $codigo);
    $db->rawQuery( "INSERT INTO m_tope (codigo, valor, usuario_id) VALUES ($codigo, '$valor','".$_SESSION[PREFIX.'login_uid']."')" );    
    logit( $_SESSION[PREFIX.'login_name'],'insertar','tope',0,$db->getLastQuery() );
    
    
    $json['sql'] = $db->getLastQuery();
    
    $json['status'] = 'success';
    $json['mensaje'] = 'OK';    
    if( in_array($codigo, array(4,5,6)) )     {
        //$pesos = fnCalculaEnPesos($valor);
        $json['pesos'] = number_format($valor, 0, '', '.');    
    } else {
        $json['pesos'] = fnCalculaEnPesos($valor);
    }
       
}



$json['action'] = $action;

$json = json_encode($json);
echo $json;

?>