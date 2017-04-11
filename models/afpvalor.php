<?php

function crearAfpvalor($data_array){
    global $db;
    $id = $db->insert('m_afpvalores', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarAfpvalor($afpvalor_id, $data_array){
    global $db;
    $db->where ("id", $afpvalor_id);                    
    if($db->update('m_afpvalores', $data_array))
        return true;
    else 
        return false;
}

function eliminarAfpvalor( $afpvalor_id ){
    global $db;
    $db->where('id', $afpvalor_id);
        
    if($db->delete('m_afpvalores')){
        return true;    
    } else {
        return false;
    }    
}

?>