<?php

function crearTipotrabajador($data_array){
    global $db;
    $id = $db->insert('m_tipotrabajador', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTipotrabajador($tipotrabajador_id, $data_array){
    global $db;
    $db->where ("id", $tipotrabajador_id);                    
    if($db->update('m_tipotrabajador', $data_array))
        return true;
    else 
        return false;
}

function eliminarTipotrabajador( $tipotrabajador_id ){
    global $db;
    $db->where('id', $tipotrabajador_id);
        
    if($db->delete('m_tipotrabajador')){
        return true;    
    } else {
        return false;
    }    
}

?>