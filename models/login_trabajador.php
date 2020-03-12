<?php

function editarUsuarioLogin($user_rut, $data_array){
    global $db;    
    $db->where ("rut", $user_rut);
    if($db->update('m_trabajador', $data_array))
        return true;
    else 
        return false;
}

function checkMailTrabajador($rut){
    global $db;    
    $db->where ("rut", $rut);
    $db->where('tipocontrato_id', Array(1, 2), 'IN');
    $email = $db->getValue('m_trabajador','email');
    
    if( $email == "" ){
        return false;
    } else {
        return true;  
    }
}


?>