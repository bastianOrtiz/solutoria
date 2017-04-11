<?php

function obtenerContenidoDirectorio($directorio, $is_dir){    
    $ficheros = scandir($directorio);    
    $dirs = array_diff($ficheros, array('.', '..','comun'));
    
    $arr_ficheros = array();
    if( $is_dir ){
        foreach( $dirs as $item ){
            $arr_ficheros[] = str_replace(".php","",$item);
        }        
    } else {
        
        $arr_ficheros = $dirs;
    }
    
    return $arr_ficheros;
}

function crearUsuario($data_array){
    global $db;
    $id = $db->insert('m_usuario', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function verificarExisteUsuario($emailUsuario){
    global $db;
    $db->where ("user", $emailUsuario);
    $exist = $db->get("m_usuario");
    if ($db->count > 0){
        return true;
    } else {
        return false;
    }
}

function editarUsuario($usuario_id, $data_array){
    global $db;
    $db->where ("id", $usuario_id);                    
    if($db->update('m_usuario', $data_array))
        return true;
    else 
        return false;
}


function editarPerfil($trabajador_id, $data_array){
    global $db;
    $db->where ("id", $trabajador_id);                    
    if($db->update('m_trabajador', $data_array))
        return true;
    else 
        return false;
}

function eliminarUsuario( $usuario_id ){
    global $db;
    eliminarUsuarioEmpresa($usuario_id);
    $db->where('id', $usuario_id);
    if($db->delete('m_usuario')){
        return true;    
    } else {
        return false;
    }
        
}

function eliminarUsuarioEmpresa( $usuario_id ){
    global $db;
    $db->where('usuario_id', $usuario_id);        
    if($db->delete('m_usuarioempresa')){
        return true;    
    } else {
        return false;
    }    
}


?>