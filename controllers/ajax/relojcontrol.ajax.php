<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $db->where("empresa_id",$_SESSION[PREFIX . 'login_eid']);
    $trabajador = $db->getOne("m_trabajador");
    
    if( $trabajador ){
        $t = $trabajador;
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $t['nombres'].' '.$t['apellidoPaterno'].' '.$t['apellidoMaterno'];
        $json['foto'] = $t['foto'];
        
        $json['registros'] = array(                
                'id' => $t['id'],                
                'Rut' => $t['rut'],
                'Email' => $t['email'],
                'Telefono' => $t['telefono'],
                'En caso de emergencia' => $t['emergencia'],
                'Dirección' => $t['direccion'],
                'Fecha Nac.' => $t['fechaNacimiento'],
                'Sueldo Base' => $t['sueldoBase']
            );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }
}


if( $_POST['action'] == 'buscarlive' ){
    
    /*
    $db->where ("nombres",'%'.$s.'%','LIKE');    
    $db->orWhere('apellidoPaterno','%'.$s.'%','LIKE');
    $db->orWhere('apellidoMaterno','%'.$s.'%','LIKE');
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid'] ,'LIKE');
    $trabajadores = $db->get("m_trabajador");
    */
     
    $sql = "SELECT id, nombres, apellidoPaterno, apellidoMaterno  
            FROM m_trabajador 
            WHERE  empresa_id = ".$_SESSION[ PREFIX . 'login_eid']." 
            AND (nombres LIKE '%$s%'  
            OR apellidoPaterno LIKE '%$s%'  
            OR apellidoMaterno LIKE '%$s%')";
    $trabajadores = $db->rawQuery( $sql );   
   
    
    if ($db->count > 0){        
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';
        foreach( $trabajadores as $t ){
            $json['registros'][] = array(
                'id' => $t['id'],
                'nombre' => $t['nombres'].' '.$t['apellidoPaterno'].' '.$t['apellidoMaterno']
            );
        }
    } else {
        $json['status'] = 'no_reg';
        $json['mensaje'] = 'NO HAY REGISTROS';
    }        
}

if( $_POST['action'] == 'valida_relojcontrol_id' ){        
    $db->where ("relojcontrol_id", $relojid);
    $existe = $db->getValue("m_trabajador", 'relojcontrol_id');        
    
    if ($db->count > 0){        
        $json['exist'] = 'TRUE';        
    } else {
        $json['exist'] = 'FALSE';        
    }
}


if( $_POST['action'] == 'get_comuna' ){
    
    $db->orderBy("nombre","ASC");
    $db->where ("region_id", $regid);
    $comunas = $db->get("m_comuna");
    
    if( $comunas ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        foreach( $comunas as $c ){
            $json['registros'][] = array(
                "id" => $c['id'],
                "nombre" => $c['nombre']
            );    
        }
        
    } else {
        $json['status'] = 'vacio';
        $json['mensaje'] = $db->getLastError();;   
    }     
}

if( $action == 'add_minutos' ){
    $data = Array (
        "mes" => $mesAusenciaAtraso,            
        "ano" => $anoAusenciaAtraso,        
        "hrRetraso" => $minutosAtraso,
        "hrExtra" => $minutosExtraNormal,
        "hrExtraFestivo" => $minutosExtraFestivo,
        "trabajador_id" => $regid_ausencias
    );
    
    $db->where('trabajador_id',$regid_ausencias);
    $db->where('mes',$mesAusenciaAtraso);
    $db->where('ano',$anoAusenciaAtraso);
    $currentValor = $db->getOne('t_relojcontrol','id');
    
    if( $db->count > 0 ){
        $db->where ("id", $currentValor['id']);                    
        $db->update('t_relojcontrol' , $data);
        logit( $_SESSION[PREFIX.'login_name'],'actualizar','t_relojcontrol',$currentValor['id'],$db->getLastQuery() );
        $json['update'] = 'TRUE';
        $json['tr_id'] = $currentValor['id'];        
    } else {
        $last_id = $db->insert('t_relojcontrol' , $data);
        logit( $_SESSION[PREFIX.'login_name'],'insertar','t_relojcontrol',$last_id,$db->getLastQuery() );
        $json['update'] = 'FALSE';
        $json['tr_id'] = $last_id;
    }
            
    $create_id = true;
    
    if( $create_id ){
        $json['minutosAtraso'] = $minutosAtraso; 
        $json['minutosExtraNormal'] = $minutosExtraNormal;
        $json['minutosExtraFestivo'] = $minutosExtraFestivo;
                          
        $json['status'] = 'OK';        
        $json['mensaje'] = 'Datos ingresados correctamente';    
    } else {
        $json['registro'] = '';
        $json['status'] = 'ERROR';
        $json['mensaje'] = $db->getLastError();
    }                
}


if( $action == 'add_ausencia' ){
    $data = Array (
        "fecha_inicio" => $fechaAusenciaInicio,            
        "fecha_fin" => $fechaAusenciaFin,        
        "ausencia_id" => $motivoAusencia,
        "trabajador_id" => $regid_ausencias
    );
        
    $last_id = $db->insert('t_ausencia' , $data);   
    logit( $_SESSION[PREFIX.'login_name'],'insertar','t_ausencia',$last_id,$db->getLastQuery() );
     
    $json['update'] = 'FALSE';
    $json['tr_id'] = $last_id;
        
    $create_id = true;
    
    $datetime1 = date_create($fechaAusenciaInicio);
    $datetime2 = date_create($fechaAusenciaFin);
    $interval = date_diff($datetime1, $datetime2);
    $days_diff = $interval->format('%a');
    $days_diff++;
    
    if( $create_id ){
        $json['registro'] = array(                
            $fechaAusenciaInicio, 
            $fechaAusenciaFin,
            $days_diff,
            fnGetNombre($motivoAusencia,'m_ausencia',0)
        );
        $json['status'] = 'OK';        
        $json['mensaje'] = 'Datos ingresados correctamente';    
    } else {
        $json['registro'] = '';
        $json['status'] = 'ERROR';
        $json['mensaje'] = $db->getLastError();
    } 
        
                   
}





if( $action == 'check_ausencia_reloj' ){
    $data = Array (
        "fecha_inicio" => $fechaAusenciaInicio . " 00:00:00",            
        "fecha_fin" => $fechaAusenciaFin . " 23:59:59",
        "trabajador_id" => $regid_ausencias,
        "usuario_id" => $_SESSION[PREFIX.'login_uid']
    );
        
    $db->where('checktime', Array ($data['fecha_inicio'], $data['fecha_fin']), 'BETWEEN');
    $db->get('m_relojcontrol');
    if( $db->count > 0 ){
        $json['exist'] = 'TRUE';        
    } else {
        $json['exist'] = 'FALSE';
    }
                      
}




if( $action == 'add_debe' ){
    $data = Array (
        "mesInicio" => $mesDebeTrabajador,            
        "anoInicio" => $anoDebeTrabajador,
        "cuotaActual" => $cuotaActualDebeTrabajador,
        "cuotaTotal" => $totalCuotasDebeTrabajador,
        "valor" => $valorDebeTrabajador,
        "descuento_id" => $descuentoDebeTrabajador,
        "trabajador_id" => $regid_debes,
        "tipomoneda_id" => $tipoMonedaDescuento,
        "glosa" => $glosaDebeTrabajador,
        "activo" => 1
    );
    
    $last_id = $db->insert('t_descuento' , $data);
    $json['update'] = 'FALSE';
    $json['tr_id'] = $last_id;                
    
    $bool = true;
    if( getComparte('Descuento') )
        $bool = false;    
    
    if( $last_id ){
        $json['registro'] = array(                
            getNombreMes($mesDebeTrabajador), 
            $anoDebeTrabajador,
            $cuotaActualDebeTrabajador,
            $totalCuotasDebeTrabajador,
            fnGetNombre($descuentoDebeTrabajador,'m_descuento',$bool),
            $valorDebeTrabajador
        );        
        $json['status'] = 'OK';        
        $json['mensaje'] = 'Datos ingresados correctamente';    
    } else {
        $json['registro'] = '';
        $json['status'] = 'ERROR';
        $json['mensaje'] = $db->getLastError();
    }
                
}

if( $action == 'actualizar_ausencia' ){
    $data = Array (
        "ausencia_id" => $id_m_ausencia
    );
    
    $db->where ('id', $id_t_ausencia);
    $last_upd = $db->update('t_ausencia' , $data);
    if( $last_upd ){     
        $json['status'] = 'OK';
        $json['id'] = $id_t_ausencia;
    }           
}


if( $action == 'delete_debe' ){
    $data = Array (
        "activo" => 0,
        "obs" => urldecode($obs),
        "fechaFinalizacion" => null
    );
    
    $db->where ('id', $id);
    $last_upd = $db->update('t_descuento' , $data);
    if( $last_upd ){                
        $json['status'] = 'OK';        
        $json['id'] = $id;    
    }           
}

if( $action == 'delete_ausencia_trabajador' ){
    $db->where ('id', $id);
    $last_delete = $db->delete('t_ausencia');
    if( $last_delete ){                
        $json['status'] = 'OK';        
        $json['id'] = $id;    
    }           
}


if( $action == 'delete_ausencia_trabajador_batch' ){
    $array_ids = trim($ids,',');
    $array_ids = explode(',',$array_ids);
    
    $db->where ('id', $array_ids[0]);
    array_shift($array_ids);
    foreach( $array_ids as $id ){        
        $db->orWhere('id', $id);
    }
    
    $last_delete = $db->delete('t_ausencia');
    if( $last_delete ){
        $json['status'] = 'OK';        
        $json['id'] = $id;    
    }           
}


if( $action == 'add_haber' ){
    
    $data = Array (
        "mesInicio" => $mesHaberTrabajador,            
        "anoInicio" => $anoHaberTrabajador,
        "cuotaActual" => $cuotaActualHaberTrabajador,
        "cuotaTotal" => $totalCuotasHaberTrabajador,
        "valor" => $valorHaberTrabajador,
        "haber_id" => $descuentoHaberTrabajador,
        "trabajador_id" => $regid_haberes,
        "tipomoneda_id" => $tipoMonedaHaber,
        "glosa" => $glosaHaberTrabajador,
        "activo" => 1
    );
    
    $last_id = $db->insert('t_haber' , $data);
    $json['update'] = 'FALSE';
    $json['tr_id'] = $last_id;    
    
    $bool = true;
    if( getComparte('Haber') )
        $bool = false;  
        
    if( $last_id ){
        $json['registro'] = array(                
            getNombreMes($mesHaberTrabajador), 
            $anoHaberTrabajador,
            $cuotaActualHaberTrabajador,
            $totalCuotasHaberTrabajador,
            fnGetNombre($descuentoHaberTrabajador,'m_haber', $bool),
            $valorHaberTrabajador
        );        
        $json['status'] = 'OK';        
        $json['mensaje'] = 'Datos ingresados correctamente';    
    } else {
        $json['registro'] = '';
        $json['status'] = 'ERROR';
        $json['mensaje'] = $db->getLastError();
    }
                
}

if( $action == 'delete_haber' ){
    $data = Array (
        "activo" => 0,
        "obs" => urldecode($obs),
        "fechaFinalizacion" => null
    );
    
    $db->where ('id', $id);
    $last_upd = $db->update('t_haber' , $data);
    if( $last_upd ){                
        $json['status'] = 'OK';        
        $json['id'] = $id;    
    }           
}

if( $action == 'add_contrato' ){
    usleep(250000);
    $data = Array (
        "contrato_id" => $id_contrato,
        "trabajador_id" => $id_trabajador        
    );
    
    $insert = $db->insert('t_contrato' , $data);
    if( $insert ){                
        $json['status'] = 'OK';
        $json['contrato'] = fnGetNombre($id_contrato, 'm_contrato');        
        $json['id'] = $insert;
    }           
}

if( $action == 'delete_contrato' ){
    $db->where ('id', $id_contrato);
    $db->where ('trabajador_id', $id_trabajador);
    $last_del = $db->delete('t_contrato');
    if( $last_del ){                
        $json['status'] = 'OK';            
    }           
}



if( $action == 'add_apv' ){    
    usleep(250000);
    $data = Array (
        'trabajador_id' => $trabajador_id, 
        'institucion_id' => $institucion_id,
        'tipomoneda_id' => $tipomoneda_id,
        'monto' => (float)$monto,
        'tipo' => $tipo,
        'usuario_id' => $_SESSION[PREFIX.'login_uid']
    );
    
    $db->setTrace(true);
    $insert = $db->insert('t_apv' , $data);
    $db->getLastQuery();
    
    $bool = true;
    if( getComparte('TipoMoneda') )
        $bool = false;  
        
    if( $insert ){                
        $json['status'] = 'OK';
        $json['institucion'] = fnGetNombre($institucion_id, 'm_institucion', false);
        $json['moneda'] = fnGetNombre($tipomoneda_id, 'm_tipomoneda', $bool);
        $json['monto'] = (float)$monto;
        $json['id'] = $insert;
    }           
}

if( $action == 'delete_apv' ){
    $db->where ('id', $id_apv);
    $db->where ('trabajador_id', $id_trabajador);
    $last_del = $db->delete('t_apv');
    if( $last_del ){                
        $json['status'] = 'OK';            
    }           
}

if( $action == 'get_tipopagos_fields' ){    
    $db->where ( 'id', $id_tipopago );    
    $tipopago_fields = $db->getOne('m_tipopago','multicampo');
    $arr_fields = json_decode($tipopago_fields['multicampo']);                            
    foreach( $arr_fields as $field ){
        $json['registros'][] = array(
            'key' => $field->key,
            'name' => $field->name
        );
    }               
}


$json = json_encode($json);
echo $json;

?>