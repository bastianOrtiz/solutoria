<?php

function crearCargo($data_array){
    global $db;
    $id = $db->insert('m_cargo', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarCargo($cargo_id, $data_array){
    global $db;
    $db->where ("id", $cargo_id);                    
    if($db->update('m_cargo', $data_array))
        return true;
    else 
        return false;
}

function eliminarCargo( $cargo_id ){
    global $db;
    $db->where('id', $cargo_id);
        
    if($db->delete('m_cargo')){
        return true;    
    } else {
        return false;
    }    
}

?>