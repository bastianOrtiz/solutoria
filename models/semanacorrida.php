<?php

function crearSemanacorrida($data_array){
    global $db;
    $id = $db->insert('m_semanacorrida', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarSemanacorrida($semanacorrida_id, $data_array){
    global $db;
    $db->where ("id", $semanacorrida_id);                    
    if($db->update('m_semanacorrida', $data_array))
        return true;
    else 
        return false;
}

function eliminarSemanacorrida( $semanacorrida_id ){
    global $db;
    $db->where('id', $semanacorrida_id);
        
    if($db->delete('m_semanacorrida')){
        return true;    
    } else {
        return false;
    }    
}

?>