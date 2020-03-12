<?php

function crearTipomoneda($data_array){
    global $db;
    $id = $db->insert('m_tipomoneda', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTipomoneda($tipomoneda_id, $data_array){
    global $db;
    $db->where ("id", $tipomoneda_id);                    
    if($db->update('m_tipomoneda', $data_array))
        return true;
    else 
        return false;
}

function eliminarTipomoneda( $tipomoneda_id ){
    global $db;
    $db->where('id', $tipomoneda_id);
        
    if($db->delete('m_tipomoneda')){
        return true;    
    } else {
        return false;
    }    
}

?>