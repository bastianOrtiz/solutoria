<?php
$tipomoneda = $db->get("m_tipomoneda");

$db->orderBy("nombre","ASC");
$haberes = $db->get("m_haber");

$db->orderBy("nombre","ASC");
$descuentos = $db->get("m_descuento");

$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$db->orderBy("departamento_id","ASC");
$db->orderBy("nombres","ASC");
$trabajdores = $db->get('m_trabajador');

$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$db->orderBy("apellidoPaterno","ASC");
$trabajdores_todos = $db->get('m_trabajador');

if( $_POST ){
    extract($_POST);
        
    if( @$action == 'new_haber' ){
        $err = 0;
        foreach( $trabajadorCargamasiva as $trabajador_id => $item ){
            $data = Array (
                "mesInicio" => $mesHaberTrabajador,            
                "anoInicio" => $anoHaberTrabajador,
                "cuotaActual" => $cuotaActualHaberTrabajador,
                "cuotaTotal" => $totalCuotasHaberTrabajador,
                "valor" => $valorHaberTrabajador,
                "haber_id" => $haberTrabajador,
                "trabajador_id" => $trabajador_id,
                "tipomoneda_id" => $tipoMonedaHaber,
                "glosa" => $glosaHaberTrabajador,
                "activo" => 1
            );
            $last_id = $db->insert('t_haber' , $data);
            if( !@$last_id ){
                $err++;
            }
        }     
        
        if( $err == 0 ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'haber_masivo',0,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Haberes ingresados correctamente&id=');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();    
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id=');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        }                    
    }
    
    
        
    if( @$action == 'new_descuento' ){
        $err = 0;
        foreach( $trabajadorCargamasiva as $trabajador_id => $item ){
            $data = Array (
                "mesInicio" => $mesDescuentoTrabajador,            
                "anoInicio" => $anoDescuentoTrabajador,
                "cuotaActual" => $cuotaActualDescuentoTrabajador,
                "cuotaTotal" => $totalCuotasDescuentoTrabajador,
                "valor" => $valorDescuentoTrabajador,
                "descuento_id" => $descuentoTrabajador,
                "trabajador_id" => $trabajador_id,
                "tipomoneda_id" => $tipoMonedaDescuento,
                "glosa" => $glosaDescuentoTrabajador,
                "activo" => 1
            );
            $last_id = $db->insert('t_descuento' , $data);
            if( !@$last_id ){
                $err++;
            }
        }     
        
        if( $err == 0 ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'descuento_masivo',0,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Descuentos ingresados correctamente&id=');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();    
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id=');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        }
                    
    }
    
    if( @$action == 'new_anticipo' ){
        
        $sql = 'INSERT INTO t_descuento (glosa, mesInicio, anoInicio, cuotaActual, cuotaTotal, procesado, tipomoneda_id, valor, descuento_id, trabajador_id, activo, obs) VALUES';
        foreach( $trabajadorAnticipoMasivo as $trabajador_id => $item ){
            $sql .= "('', ".getMesMostrarCorte().", ".getAnoMostrarCorte().", 1, 1, 0, 1, $montoAnticipoMasivo, ".ID_ANTICIPO.", $trabajador_id, 1, ''),";
        }
        
        $sql = trim($sql,',');
        
        $insert = $db->rawQuery($sql);
        logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'anticipo_masivo',0,$db->getLastQuery() );
        
        $response = encrypt('status=success&mensaje=Anticipos ingresados correctamente&id=');
        redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
        exit();
        
        
    }
    
    
                          
}

if( $parametros ){
    
}

include ROOT . '/views/comun/header.php';
include ROOT . '/views/comun/menu_top.php';
include ROOT . '/views/comun/menu_sidebar.php';

if( isset($parametros[0]) ){
    if( file_exists(ROOT . '/views/' . strtolower($entity) . '/' . $parametros[0] . '.php') ){
        include ROOT . '/views/' . $entity . '/' . $parametros[0] . '.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> Not Found </h2> </section></div>';
    }
} else {
    if( file_exists( ROOT . '/views/' . strtolower($entity) . '/dashboard.php') ){
        include ROOT . '/views/' . $entity .  '/dashboard.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> '. strtoupper($entity) .' </h2> </section></div>';
    }    
}

include ROOT . '/views/comun/footer.php';

?>

