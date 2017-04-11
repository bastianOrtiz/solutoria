<?php

$registros = getRegistrosCompartidos('Haber','m_haber');
$tipomoneda = $db->get("m_tipomoneda");

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $fijo = $fijoHaber[0];
        $valorPredeterminado = $predeterminadoHaber[0];
        $imponible = $imponibleHaber[0]; 
        $comision = $comisionHaber[0];       
        
        $data = Array (
            "nombre" => $nombreHaber,            
            "fijo" => $fijo,
            "valorPredeterminado" => $valorPredeterminado,
            "tipomoneda_id" => $tipoMonedaHaber,
            "valor" => $valorHaber,
            "imponible" => $imponible,
            "comision" => $comision,
            "activo" => $activoHaber,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );

        if( editarHaber($haber_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'haber',$haber_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$haber_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $haber_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$haber_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $haber_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarHaber( $haber_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'haber',$haber_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$haber_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la haber porque tiene trabajadores asociados&id='.$haber_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $fijo = $fijoHaber[0];
        $valorPredeterminado = $predeterminadoHaber[0];
        $imponible = $imponibleHaber[0];
        $comision = $comisionHaber[0];        
        
        $data = Array (
            "nombre" => $nombreHaber,            
            "fijo" => $fijo,
            "valorPredeterminado" => $valorPredeterminado,
            "tipomoneda_id" => $tipoMonedaHaber,
            "valor" => $valorHaber,
            "imponible" => $imponible,
            "comision" => $comision,            
            "activo" => $activoHaber,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );
        
        $create_id = crearHaber($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'haber',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }                   
    }      
}

if( $parametros ){
    /** Consultar datos de haber **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $haber = $db->getOne("m_haber");        
    }
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

