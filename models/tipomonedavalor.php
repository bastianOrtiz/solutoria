<?php

function crearTipomonedavalor($data_array){
    global $db;
    $id = $db->insert('m_tipomonedavalor', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTipomonedavalor($tipomonedavalor_id, $data_array){
    global $db;
    $db->where ("id", $tipomonedavalor_id);                    
    if($db->update('m_tipomonedavalor', $data_array))
        return true;
    else 
        return false;
}

function eliminarTipomonedavalor( $tipomonedavalor_id ){
    global $db;
    $db->where('id', $tipomonedavalor_id);
        
    if($db->delete('m_tipomonedavalor')){
        return true;    
    } else {
        return false;
    }    
}

?>