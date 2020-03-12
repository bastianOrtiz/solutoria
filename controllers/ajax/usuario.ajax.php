<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $usuario = $db->getOne("m_usuario");
    
    $db->where ("usuario_id", $regid);    
    $empresasUsuario = $db->rawQuery('SELECT E.nombre from m_empresa E, m_usuarioempresa UE WHERE UE.empresa_id = E.id AND UE.usuario_id = ' . $regid . ' ORDER BY E.nombre ASC');
    
    if( $usuario ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $usuario['nombre'];
        
        $json['registros'] = array(
            'Nombre' => $usuario['nombre'],
            'Email' => $usuario['user'],            
        );
        
        if( $usuario['empresasTodas'] == 1 ){
            $json['empresas'][] = array(                
                'Nombre' => 'Todas'            
            );
        } else {
            foreach( $empresasUsuario as $empresa ){
                $json['empresas'][] = array(
                    'Nombre' => $empresa['nombre']            
                );
            }            
        }
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>