<?php

function crearAfp($data_array){
    global $db;
    $id = $db->insert('m_afp', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarAfp($afp_id, $data_array){
    global $db;
    $db->where ("id", $afp_id);                    
    if($db->update('m_afp', $data_array))
        return true;
    else 
        return false;
}

function eliminarAfp( $afp_id ){
    global $db;
    $db->where('id', $afp_id);
        
    if($db->delete('m_afp')){
        return true;    
    } else {
        return false;
    }    
}

?>