<?php

function editarUsuarioLogin($user_email, $data_array){
    global $db;
    $db->setTrace(true);
    $db->where ("user", $user_email,'like');                    
    if($db->update('m_usuario', $data_array))
        return true;
    else 
        return false;
}

?>