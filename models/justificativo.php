<?php

function crearJustificativo($data_array){
    global $db;
    $id = $db->insert('m_justificativo', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarJustificativo($justificativo_id, $data_array){
    global $db;
    $db->where ("id", $justificativo_id);                    
    if($db->update('m_justificativo', $data_array))
        return true;
    else 
        return false;
}

function eliminarJustificativo( $justificativo_id ){
    global $db;
    $db->where('id', $justificativo_id);
        
    if($db->delete('m_justificativo')){
        return true;    
    } else {
        return false;
    }    
}

function getTipoJustificativo($char){
    switch( $char ){
        case 'A': return 'Ausencia'; break;
        case 'H': return 'Hora Extra'; break;
        default: return ''; break;
    }
}

?>