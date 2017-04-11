<?php


function crearCostoEmpresa($data_array){
    global $db;
    $id = $db->insert('m_costoempresa', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

?>