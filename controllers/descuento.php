<?php

$registros = getRegistrosCompartidos('Descuento','m_descuento');
$tipomoneda = getRegistrosCompartidos('TipoMoneda','m_tipomoneda');

$descuentos = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){

        $fijo = $fijoDescuento[0];
        $seguro = $seguroDescuento[0];
        $valorPredeterminado = $predeterminadoDescuento[0];

        $data = Array (
            "nombre" => $nombreDescuento,            
            "fijo" => $fijo,
            "valorPredeterminado" => $valorPredeterminado,
            "tipomoneda_id" => $tipoMonedaDescuento,
            "valor" => $valorDescuento,            
            "activo" => $activoDescuento,
            "empresa_id" => $_SESSION[PREFIX.'login_eid'],
            "mostrarAbajo" => $mostrarAbajoDescuento,
            "ccaf_id" => $cajaDescuento,
            "es_seguro" => $seguro
        );

        if( editarDescuento($descuento_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'descuento',$descuento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$descuento_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $descuento_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$descuento_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $descuento_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarDescuento( $descuento_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'descuento',$descuento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$descuento_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la descuento porque tiene trabajadores asociados&id='.$descuento_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $fijo = $fijoDescuento[0];
        $seguro = $seguroDescuento[0];
        $valorPredeterminado = $predeterminadoDescuento[0];                
        
        $data = Array (
            "nombre" => $nombreDescuento,            
            "fijo" => $fijo,
            "valorPredeterminado" => $valorPredeterminado,
            "tipomoneda_id" => $tipoMonedaDescuento,
            "valor" => $valorDescuento,            
            "activo" => $activoDescuento,
            "empresa_id" => $_SESSION[PREFIX.'login_eid'],
            "mostrarAbajo" => $mostrarAbajoDescuento,
            "ccaf_id" => $cajaDescuento,
            "es_seguro" => $seguro
        );
        
        $create_id = crearDescuento($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'descuento',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }                   
    }      
}

if( $parametros ){
    /** Consultar datos de descuento **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $descuento = $db->getOne("m_descuento");
    }

    $cajas = $db->get('m_cajacompensacion');
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

