<?php

$registros = $db->get("m_afpvalores");

if( $_POST ){
    
    extract($_POST);
    
    
    if( @$_POST['action'] == 'new' ){        
        $data = Array (             
            'mes' => $mesAfpvalor, 
            'ano' => $anoAfpvalor, 
            'porCientoPension' => $porcentajePensionAfpvalor, 
            'porCientoSeguro' => $porcentajeSeguroAfpvalor, 
            'porCientoSis' => $porcentajeSisAfpvalor, 
            'porCientoPencionado' => $porcentajePensionadoAfpvalor,
            'usuario_id' => $_SESSION[PREFIX.'login_uid'], 
            'afp_id' => $id_afp
        );
        
        
        $db->where('afp_id',$id_afp);
        $db->where('mes',$mesAfpvalor);
        $db->where('ano',$anoAfpvalor);
        $currentValor = $db->getOne('m_afpvalores','id');
        
        if( $db->count > 0 ){
            editarAfpvalor($currentValor['id'],$data);
            logit( $_SESSION[PREFIX.'login_name'],'editar','afpvalor',$currentValor['id'],$db->getLastQuery() );
            
            $create_id = $currentValor['id'];
        } else {
            $create_id = crearAfpvalor($data);
            logit( $_SESSION[PREFIX.'login_name'],'insertar','afpvalor',$create_id,$db->getLastQuery() );    
        }
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');            
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);                            
        }
        
        redirect(BASE_URL . '/afpvalor/ingresar/' . $id_afp );
        exit();                   
    }      
}

if( $parametros ){
    /** Consultar datos de afpvalor **/
    if( isset($parametros[1]) ){
        $db->where ("afp_id", $parametros[1]);
        $db->orderBy("ano","DESC");
        $db->orderBy("mes","DESC");
        $afpvalor = $db->get("m_afpvalores");        
        
        $db->where ("id", $parametros[1]);
        $afp = $db->getOne("m_afp");
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

