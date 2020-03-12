<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$horarios = $db->get("m_horario");


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $horario = $db->getOne("m_horario");
    
    if( $horario ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $horario['nombre'];
        
        $json['registros'] = array(            
            "Nombre" => $horario['nombre'],
            "Descripcion" => $horario['descripcion'],
            "Hora Entrada al Trabajo" => $horario['entradaTrabajo'],
            "Hora Salida del Trabajo" => $horario['salidaTrabajo'],
            "Hora Entrada a Colación" => $horario['entradaColacion'],
            "Hora Salida de Colación" => $horario['salidaColacion'],
            "Activo" => booleano($horario['activo'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>