<?php
@session_start();

if($_SESSION[ PREFIX . 'logged']):

include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
sleep(1);

if( $_POST['ajax_action'] == 'procesar_liquidaciones' ){
    
    $mes = getMesMostrarCorte();
    $ano = getAnoMostrarCorte();

    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $res = $db->update('liquidacion',['terminada' => 1]);
    
    if( $res ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';        
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }
        
}

$json = json_encode($json);
echo $json;

endif;

?>