<?php

function getTotalTrabajadoresById($cargo_id){
    global $db;
    $sql = "select COUNT(*) as total from m_trabajador T WHERE T.cargo_id = $cargo_id";
    $db->where('cargo_id', $cargo_id);
    $count = $db->getValue ("m_trabajador", "count(*)");

    return $count;
}

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
