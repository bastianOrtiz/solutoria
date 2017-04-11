<?php

function crearHaber($data_array){
    global $db;
    $id = $db->insert('m_haber', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarHaber($haber_id, $data_array){
    global $db;
    $db->where ("id", $haber_id);                    
    if($db->update('m_haber', $data_array))
        return true;
    else 
        return false;
}

function eliminarHaber( $haber_id ){
    global $db;
    $db->where('id', $haber_id);
        
    if($db->delete('m_haber')){
        return true;    
    } else {
        return false;
    }    
}

?>