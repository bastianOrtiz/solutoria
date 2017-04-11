<?php

function crearContrato($data_array){
    global $db;
    $id = $db->insert('m_contrato', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarContrato($contrato_id, $data_array){
    global $db;
    $db->where ("id", $contrato_id);                    
    if($db->update('m_contrato', $data_array))
        return true;
    else 
        return false;
}

function eliminarContrato( $contrato_id ){
    global $db;
    $db->where('id', $contrato_id);
        
    if($db->delete('m_contrato')){
        return true;    
    } else {
        return false;
    }    
}

?>