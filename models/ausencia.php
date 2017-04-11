<?php

function crearAusencia($data_array){
    global $db;
    $id = $db->insert('m_ausencia', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarAusencia($ausencia_id, $data_array){
    global $db;
    $db->where ("id", $ausencia_id);                    
    if($db->update('m_ausencia', $data_array))
        return true;
    else 
        return false;
}

function eliminarAusencia( $ausencia_id ){
    global $db;
    $db->where('id', $ausencia_id);
        
    if($db->delete('m_ausencia')){
        return true;    
    } else {
        return false;
    }    
}

?>