<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

if( $action == 'set_corte' ){
    
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $diaCierre = $db->getOne('m_empresa','diaCierre');
    $diaCierre = $diaCierre['diaCierre'];
    $hoy = date('d');
    $mesMostrar = date('m');
    $anoMostrar = date('Y');
    if( $hoy < $diaCierre ){
        $mesMostrar--;
        if($mesMostrar == 0){
            $mesMostrar = 12;
            $anoMostrar--;
        }      
    }       
    $mes = $mesMostrar;    
    $ano = $anoMostrar;    
    
    $data_array = array(
        'dia' => $dia,
        'mes' => $mes,
        'ano' => $ano,
        'empresa_id' => $_SESSION[PREFIX.'login_eid']
    );
    
    
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $db->getOne('m_corte');
        
    
    if($db->count > 0){
        $db->where('mes',$mes);
        $db->where('ano',$ano);
        $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
        $res = $db->update('m_corte', $data_array);
        logit( $_SESSION[PREFIX.'login_name'],'actualizar','corte',0,$db->getLastQuery(),$_SESSION[PREFIX.'login_eid'] );
        
        $json['alerta_off'] = 0;    
    } else {
        $res = $db->insert('m_corte', $data_array);
        logit( $_SESSION[PREFIX.'login_name'],'insertar','corte',0,$db->getLastQuery(),$_SESSION[PREFIX.'login_eid'] );
        $json['alerta_off'] = 1;
    }    
    
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

?>