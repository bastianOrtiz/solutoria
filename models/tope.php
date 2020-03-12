<?php

function fnCalculaEnPesos($cantidad_uf){
    global $db;
    if($cantidad_uf){
        $mes = getMesMostrarCorte();
        $year = getAnoMostrarCorte();
        $db->where('tipomoneda_id',2);
        $db->where('mes',$mes);
        $db->where('ano',$year);
        $uf = $db->getOne('m_tipomonedavalor','valor');
        $uf = $uf['valor'];
        $total_pesos = ($cantidad_uf * $uf);
        $total_pesos = number_format($total_pesos, 0, '', '.');        

        
        return $total_pesos;
    } else {
        return 0;
    }
}

function fnGetTope($codigo){
    global $db;
    $db->where('codigo',$codigo);
    $db->orderBy('fechaHora', 'DESC');
    $tope = $db->getOne('m_tope','valor');
    if($db->count > 0)
        return $tope['valor'];
    else 
        return 0;
}

function crearTope($data_array){
    global $db;
    $id = $db->insert('m_tope', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }
}

function editarTope($tope_id, $data_array){
    global $db;
    $db->where ("id", $tope_id);                    
    if($db->update('m_tope', $data_array))
        return true;
    else 
        return false;
}

function eliminarTope( $tope_id ){
    global $db;
    $db->where('id', $tope_id);
        
    if($db->delete('m_tope')){
        return true;    
    } else {
        return false;
    }    
}

?>