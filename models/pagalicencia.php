<?php

function crearPagaLicencia($data_array){
    global $db;
    $id = $db->insert('m_pagalicencia', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarPagaLicencia($pagalicencia_id, $data_array){
    global $db;
    $db->where ("id", $pagalicencia_id);                    
    if($db->update('m_pagalicencia', $data_array))
        return true;
    else 
        return false;
}

function eliminarPagaLicencia( $pagalicencia_id ){
    global $db;
    $db->where('id', $pagalicencia_id);
        
    if($db->delete('m_pagalicencia')){
        return true;    
    } else {
        return false;
    }    
}

?>