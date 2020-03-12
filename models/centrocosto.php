<?php

function crearCentrocosto($data_array){
    global $db;
    $id = $db->insert('m_centrocosto', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarCentrocosto($centrocosto_id, $data_array){
    global $db;
    $db->where ("id", $centrocosto_id);                    
    if($db->update('m_centrocosto', $data_array))
        return true;
    else 
        return false;
}

function eliminarCentrocosto( $centrocosto_id ){
    global $db;
    $db->where('id', $centrocosto_id);
        
    if($db->delete('m_centrocosto')){
        return true;    
    } else {
        return false;
    }    
}

?>