<?php

function crearHorario($data_array){
    global $db;
    $id = $db->insert('m_horario', $data_array);        
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarHorario($horario_id, $data_array){
    global $db;
    $db->where ("id", $horario_id);                    
    if($db->update('m_horario', $data_array))
        return true;
    else 
        return false;
}

function eliminarHorario( $horario_id ){
    global $db;
    $db->where('id', $horario_id);
        
    if($db->delete('m_horario')){
        return true;    
    } else {
        return false;
    }    
}

?>