<?php

function crearDepartamento($data_array){
    global $db;
    $id = $db->insert('m_departamento', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarDepartamento($departamento_id, $data_array){
    global $db;
    $db->where ("id", $departamento_id);                    
    if($db->update('m_departamento', $data_array))
        return true;
    else 
        return false;
}

function eliminarDepartamento( $departamento_id ){
    global $db;
    $db->where('id', $departamento_id);
        
    if($db->delete('m_departamento')){
        return true;    
    } else {
        return false;
    }    
}

?>