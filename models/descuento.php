<?php

function crearDescuento($data_array){
    global $db;    
    $id = $db->insert('m_descuento', $data_array);        
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarDescuento($descuento_id, $data_array){
    global $db;
    $db->where ("id", $descuento_id);                    
    if($db->update('m_descuento', $data_array))
        return true;
    else 
        return false;
}

function eliminarDescuento( $descuento_id ){
    global $db;
    $db->where('id', $descuento_id);
        
    if($db->delete('m_descuento')){
        return true;    
    } else {
        return false;
    }    
}

?>