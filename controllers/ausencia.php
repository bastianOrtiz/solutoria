<?php
$ausencias = getRegistrosCompartidos('Ausencia','m_ausencia');
$registros = $ausencias;

if( $_POST ){

    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $descuenta = $ausenciaDescuenta[0];
        $licencia = $ausenciaLicencia[0];
        $mesCompleto = $ausenciaMesCompleto[0];
        
        $data = Array (
            "nombre" => $nombreAusencia,            
            "descuenta" => $descuenta,
            "licencia" => $licencia,
            "empresa_id" => $_SESSION[PREFIX.'login_eid'],
            "codigoPrevired" => $codigoPrevired,
            "mesCompleto" => $mesCompleto
        );

        if( editarAusencia($ausencia_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],'editar','ausencia',$ausencia_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $ausencia_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $ausencia_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarAusencia( $ausencia_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],'borrar','ausencia',$ausencia_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$ausencia_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la ausencia porque tiene trabajadores asociados&id='.$ausencia_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){
        $descuenta = $ausenciaDescuenta[0];
        $licencia = $ausenciaLicencia[0];
        $mesCompleto = $ausenciaMesCompleto[0];
        
        $data = Array (
            "nombre" => $nombreAusencia,
            "descuenta" => $descuenta,
            "licencia" => $licencia,
            "empresa_id" => $_SESSION[PREFIX.'login_eid'],
            "codigoPrevired" => $codigoPrevired,
            "mesCompleto" => $mesCompleto
        );                
        
        $create_id = crearAusencia($data);
        
        if(!$create_id){
            logit( $_SESSION[PREFIX.'login_name'],'crear','ausencia',$create_id,$db->getLastQuery() );
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/editar/'.$create_id.'/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de ausencia **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $ausencia = $db->getOne("m_ausencia");        
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

