<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$afps = $db->get("m_afp");
if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $afp = $db->getOne("m_afp");
    
    $db->where ("afp_id", $regid);
    $db->orderBy("ano","DESC");
    $db->orderBy("mes","DESC");
    $afpvalores = $db->get("m_afpvalores");
    
    if( $afp ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $afp['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $afp['nombre']
        );
        
        if( @$afpvalores ){
        foreach( $afpvalores as $afpvalor ){
            $json['afpvalores'][] = array(                
                $afpvalor['porCientoPension'], 
                $afpvalor['porCientoSeguro'],
                $afpvalor['porCientoSis'],
                $afpvalor['porCientoPencionado'],
                getNombreMes($afpvalor['mes']),
                $afpvalor['ano']
            );
        };
        } else {
            $json['afpvalores'] = 'vacio';
        }
                              
        
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>