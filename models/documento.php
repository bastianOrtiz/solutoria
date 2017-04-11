<?php

function crearDocumento($data_array){
    global $db;
    $id = $db->insert('m_documento', $data_array);    
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarDocumento($documento_id, $data_array){
    global $db;
    $db->where ("id", $documento_id);                    
    if($db->update('m_documento', $data_array))
        return true;
    else 
        return false;
}

function eliminarDocumento( $documento_id ){
    global $db;
    $db->where('id', $documento_id);
        
    if($db->delete('m_documento')){
        return true;    
    } else {
        return false;
    }    
}

?>