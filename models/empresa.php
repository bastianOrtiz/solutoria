<?php

function crearEmpresa($data_array){
    global $db;
    $id = $db->insert('m_empresa', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function verificarExisteEmpresa($rutEmpresa){
    global $db;
    $db->where ("rut", $rutEmpresa);
    $exist = $db->get("m_empresa");
    if ($db->count > 0){
        return true;
    } else {
        return false;
    }
}

function editarEmpresa($empresa_id, $data_array){
    global $db;
    $db->where ("id", $empresa_id);                    
    if($db->update('m_empresa', $data_array))
        return true;
    else 
        return false;
}

function eliminarEmpresa( $empresa_id ){
    global $db;
    $db->where('id', $empresa_id);
        
    if($db->delete('m_empresa')){
        return true;    
    } else {
        return false;
    }    
}

?>