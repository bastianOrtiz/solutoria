<?php

function crearMutual($data_array){
    global $db;
    $id = $db->insert('m_mutual', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarMutual($mutual_id, $data_array){
    global $db;
    $db->where ("id", $mutual_id);                    
    if($db->update('m_mutual', $data_array))
        return true;
    else 
        return false;
}

function eliminarMutual( $mutual_id ){
    global $db;
    $db->where('id', $mutual_id);
        
    if($db->delete('m_mutual')){
        return true;    
    } else {
        return false;
    }    
}

?>