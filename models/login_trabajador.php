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
    $email = $db->getValue('m_trabajador','email');
    if( $email == "" ){
        return false;
    } else {
        return true;  
    }
}


?>