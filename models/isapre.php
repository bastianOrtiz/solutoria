<?php

function crearIsapre($data_array){
    global $db;
    $id = $db->insert('m_isapre', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarIsapre($isapre_id, $data_array){
    global $db;
    $db->where ("id", $isapre_id);                    
    if($db->update('m_isapre', $data_array))
        return true;
    else 
        return false;
}

function eliminarIsapre( $isapre_id ){
    global $db;
    $db->where('id', $isapre_id);
        
    if($db->delete('m_isapre')){
        return true;    
    } else {
        return false;
    }    
}

?>