<?php

function crearImpuestounico($data_array){
    global $db;
    $id = $db->insert('m_impuestounico', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarImpuestounico($impuestounico_id, $data_array){
    global $db;
    $db->where ("id", $impuestounico_id);                    
    if($db->update('m_impuestounico', $data_array))
        return true;
    else 
        return false;
}

function eliminarImpuestounico( $impuestounico_id ){
    global $db;
    $db->where('id', $impuestounico_id);
        
    if($db->delete('m_impuestounico')){
        return true;    
    } else {
        return false;
    }    
}

function getTipoImpuestounico($char){
    switch( $char ){
        case 'A': return 'Ausencia'; break;
        case 'H': return 'Hora Extra'; break;
        default: return ''; break;
    }
}

?>