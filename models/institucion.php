<?php

function crearInstitucion($data_array){
    global $db;
    $id = $db->insert('m_institucion', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarInstitucion($institucion_id, $data_array){
    global $db;
    $db->where ("id", $institucion_id);                    
    if($db->update('m_institucion', $data_array))
        return true;
    else 
        return false;
}

function eliminarInstitucion( $institucion_id ){
    global $db;
    $db->where('id', $institucion_id);
        
    if($db->delete('m_institucion')){
        return true;    
    } else {
        return false;
    }    
}

?>