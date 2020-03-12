<?php

function procesarFecha($fecha,$relojcontrol_id, $dias_laborales_horario){
    global $db;
        
    $fecha_proc = array();
    $db->where('userid',$relojcontrol_id);
    $db->where ("DATE(checktime) = '$fecha'");
    $res = $db->get('m_relojcontrol');
    $count = $db->count;
    
    foreach ($res as $key => $part) {
        $sort[$key] = strtotime($part['checktime']);
    }
    array_multisort($sort, SORT_ASC, $res);
    
    if( $count == 0 ){                
        $dia_semana = date('N', strtotime($fecha));
        $dia_semana--;
        if( in_array($dia_semana,$dias_laborales_horario) ){ // Es un dia laboral?
            $fecha_proc['dia_laboral'] = 1;
            $fecha_proc['es_ausencia'] = 1;
        } else {
            $fecha_proc['dia_laboral'] = 0;
            $fecha_proc['es_ausencia'] = 0;            
        }                                
        
    } elseif( $count == 1 ) {
        $checktime = explode(" ",$res[0]['checktime']);
        $hora_marcada = $checktime[1];
        $fecha_proc['dia_laboral'] = 1;
        $fecha_proc['es_ausencia'] = 0;
        if( strtoupper($res[0]['checktype']) == 'O' ){
            $fecha_proc['entrada'] = '';
            $fecha_proc['salida'] = $hora_marcada;
            $fecha_proc['suma_minutos_descontar'] = 240;
        } else {
            $fecha_proc['entrada'] = $hora_marcada;
            $fecha_proc['salida'] = '';
            $fecha_proc['suma_minutos_descontar'] = 240;
        }
    } else {
        
        $fecha_proc['dia_laboral'] = 1;
        $fecha_proc['es_ausencia'] = 0;
        
        $hora_min = explode(" ",$res[0]['checktime']);
        $hora_max = explode(" ",$res[ ( count($res) - 1 ) ]['checktime']);
        
        $fecha_proc['entrada'] = $hora_min[1];
        $fecha_proc['salida'] = $hora_max[1];
                
    }
    
    return $fecha_proc;
}

function comprobarAusencia($fecha, $trabajador_id=''){
    if($trabajador_id==''){
        return false;
        exit();        
    }
    
    global $db;          
    $arr_return = array();    
    
    $db->where('fecha_inicio', $fecha, '<=');
    $db->where('fecha_fin', $fecha, '>=');    
    $db->where('trabajador_id',$trabajador_id);
    $res = $db->getOne('t_ausencia');
    
    if( $db->count > 0 ){
        $motivo = fnGetNombre($res['ausencia_id'],'m_ausencia',false);
        $arr_return['es_ausencia'] = true;
        $arr_return['motivo'] = $motivo;
    } else {
        $arr_return['es_ausencia'] = false;
        $arr_return['motivo'] = '';
    }           
    
    return $arr_return;
}



function existeTrabajador($rut){
    global $db;
    $db->where('rut',$rut);
    $db->where('tipocontrato_id',3,"!=");
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $id = $db->getOne('m_trabajador','rut');    
    if ($db->count > 0)
        return true;
    else
        return false;    
}



function existeIdRelojcontrol($relojcontrol_id){
    global $db;
    
    if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) ){ 
        //if( getComparte('RelojControl') ){
        //    $sql = "SELECT count(t.relojcontrol_id) existe FROM m_trabajador t, m_empresa e, m_cuenta c WHERE c.id=e.cuenta_id and e.id=t.empresa_id and c.id = 1 and t.relojcontrol_id=" . $relojcontrol_id;     
        //} else{
            $sql = "SELECT count(t.relojcontrol_id) existe FROM m_trabajador t, m_empresa e WHERE e.id=t.empresa_id and e.id= ". $_SESSION[PREFIX.'login_eid'] ." and relojcontrol_id=" . $relojcontrol_id;
        //}                
        
        $resul_relojcontrol_id = $db->rawQuery( $sql );
        $max_id_relojcontrol =  $resul_relojcontrol_id[0]['existe'];    
    
        if ( $max_id_relojcontrol > 0)
            return true;
        else
            return false;    
    } else {
        return false;
    }
}

function crearTrabajador($data_array){
    global $db;
    $id = $db->insert('m_trabajador', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTrabajador($trabajador_id, $data_array){
    global $db;
    $db->where ("id", $trabajador_id); 
    $db->where ("empresa_id", $_SESSION[PREFIX . 'login_eid']);
    if($db->update('m_trabajador', $data_array))
        return true;
    else 
        return false;
}

function editarPrevisionalTrabajador($trabajador_id, $data_array){
    global $db;
    $db->where ("trabajador_id", $trabajador_id);
    $db->getOne('t_prevision');
    if( $db->count > 0 ){
        $db->where ("trabajador_id", $trabajador_id);        
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

function eliminarTrabajador( $trabajador_id ){
    global $db;
    $db->where('id', $trabajador_id);
    if($db->delete('m_trabajador')){
        return true;    
    } else {
        return false;
    }    
}

?>