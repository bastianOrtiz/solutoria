<?php

function crearTipopago($data_array){
    global $db;
    $id = $db->insert('m_tipopago', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTipopago($tipopago_id, $data_array){
    global $db;
    $db->where ("id", $tipopago_id);                    
    if($db->update('m_tipopago', $data_array))
        return true;
    else 
        return false;
}

function eliminarTipopago( $tipopago_id ){
    global $db;
    $db->where('id', $tipopago_id);
        
    if($db->delete('m_tipopago')){
        return true;    
    } else {
        return false;
    }    
}

?>