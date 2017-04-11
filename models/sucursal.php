<?php

function crearSucursal($data_array){
    global $db;
    $id = $db->insert('m_sucursal', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarSucursal($sucursal_id, $data_array){
    global $db;
    $db->where ("id", $sucursal_id);                    
    if($db->update('m_sucursal', $data_array))
        return true;
    else 
        return false;
}

function eliminarSucursal( $sucursal_id ){
    global $db;
    $db->where('id', $sucursal_id);
        
    if($db->delete('m_sucursal')){
        return true;    
    } else {
        return false;
    }    
}

?>