<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);

include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


$json = array();

if( $_POST['action'] == 'ajax_update_field' ){
    
    $data_update = [
        $_POST['field'] => $_POST['value']
    ];

    $upd = $db->where('id',$_POST['regid'])->update('liquidacion', $data_update);
    
     if( $upd ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();
    }     
    
}

$json = json_encode($json);
echo $json;

?>