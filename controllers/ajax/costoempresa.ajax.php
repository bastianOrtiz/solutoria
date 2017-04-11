<?php
usleep(500000);
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


if( $action == 'detalle_x_costo' ){
    
    $db->where ("costoempresa_id", $costoempresa_id);
    $valores = $db->get("m_costoempresa");
    
    if( $valores ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';
        
        foreach( $valores as $v ){
            /*
            $strfecha = strtotime($v['fecha']);            
            $new_fecha = date('d',$strfecha).'/'.getNombreMes(date('m',$strfecha)).'/'.date('Y',$strfecha);
            */
            
            $json['registros'][] = array(
                'id' => $v['id'],
                'valor' => $v['valor'],
                'mes' => getNombreMes($v['mes']),
                'ano' => $v['ano']
            );
        }
        
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
}

if( $action == 'borrar_costoempresa' ){
    $db->where ("id", $costoempresa_id);
    $del = $db->delete("m_costoempresa");
    logit( $_SESSION[PREFIX.'login_name'],'costoempresa','borrar',$costoempresa_id,$db->getLastQuery(),$_SESSION[PREFIX.'login_eid'] );
    
    if( $del ){
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