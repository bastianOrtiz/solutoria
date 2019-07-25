<?php

$registros = $db->get("m_mutual");
$mutuals = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){        
        $data = Array (
            "nombre" => $nombreMutual,
            "codigo" => $codigoMutual,
            "tasaBase" => $tasaBase,
            "tasaAdicional" => $tasaAdicional,
            "tasaExtraordinaria" => $tasaExtraordinaria,
            "tasaLeyEspecial" => $tasaLeyEspecial
        );

        if( editarMutual($mutual_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'mutual',$mutual_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $mutual_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $mutual_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarMutual( $mutual_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'mutual',$mutual_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$mutual_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la mutual porque tiene trabajadores asociados&id='.$mutual_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $data = Array (
            "nombre" => $nombreMutual,
            "codigo" => $codigoMutual,
            "tasaBase" => $tasaBase,
            "tasaAdicional" => $tasaAdicional,
            "tasaExtraordinaria" => $tasaExtraordinaria,
            "tasaLeyEspecial" => $tasaLeyEspecial
        );
        
        $create_id = crearMutual($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'mutual',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de mutual **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $mutual = $db->getOne("m_mutual");        
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

