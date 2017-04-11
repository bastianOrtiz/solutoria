<?php
function comprobarAusencia($fecha, $trabajador_id){
    global $db;
    
    $db->where('fecha_inicio', $fecha, '<=');
    $db->where('fecha_fin', $fecha, '>=');
    $db->where('trabajador_id',$trabajador_id);    
    $res = $db->get('t_ausencia');       
    
    if( $db->count > 0 ){
        return true;
    } else {
        return false;
    }
    
}


function existeRelojcontrol($rut){
    global $db;
    $db->where('rut',$rut);
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $id = $db->getOne('m_relojcontrol','rut');
    if ($db->count > 0)
        return true;
    else
        return false;    
}

function crearRelojcontrol($data_array){
    global $db;
    $id = $db->insert('m_relojcontrol', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarRelojcontrol($relojcontrol_id, $data_array){
    global $db;
    $db->where ("id", $relojcontrol_id); 
    $db->where ("empresa_id", $_SESSION[PREFIX . 'login_eid']);
    if($db->update('m_relojcontrol', $data_array))
        return true;
    else 
        return false;
}

function editarPrevisionalRelojcontrol($relojcontrol_id, $data_array){
    global $db;
    $db->where ("relojcontrol_id", $relojcontrol_id);
    $db->getOne('t_prevision');
    if( $db->count > 0 ){
        $db->where ("relojcontrol_id", $relojcontrol_id);        
        $result = $db->update('t_prevision', $data_array);    
    } else {
        $last_insert = $db->insert('t_prevision',$data_array);
        if( $last_insert )
        $result = true;            
    }
    
    if($result)
        return true;
    else 
        return false;
}

function eliminarRelojcontrol( $relojcontrol_id ){
    global $db;
    $db->where('id', $relojcontrol_id);
    if($db->delete('m_relojcontrol')){
        return true;    
    } else {
        return false;
    }    
}

?>