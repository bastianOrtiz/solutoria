<?php

function crearCajacompensacion($data_array){
    global $db;
    $id = $db->insert('m_cajacompensacion', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarCajacompensacion($cajacompensacion_id, $data_array){
    global $db;
    $db->where ("id", $cajacompensacion_id);                    
    if($db->update('m_cajacompensacion', $data_array))
        return true;
    else 
        return false;
}

function eliminarCajacompensacion( $cajacompensacion_id ){
    global $db;
    $db->where('id', $cajacompensacion_id);
        
    if($db->delete('m_cajacompensacion')){
        return true;    
    } else {
        return false;
    }    
}

?>