<?php

function crearDiaferiado($data_array){
    global $db;
    $id = $db->insert('m_diaferiado', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarDiaferiado($diaferiado_id, $data_array){
    global $db;
    $db->where ("id", $diaferiado_id);                    
    if($db->update('m_diaferiado', $data_array))
        return true;
    else 
        return false;
}

function eliminarDiaferiado( $diaferiado_id ){
    global $db;
    $db->where('id', $diaferiado_id);
        
    if($db->delete('m_diaferiado')){
        return true;    
    } else {
        return false;
    }    
}

?>