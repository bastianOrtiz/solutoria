<?php

$registros = $db->get("m_tipomonedavalor");

if( $_POST ){
    
    extract($_POST);
    
    
    if( @$_POST['action'] == 'new' ){
        
        $data = Array (
            "tipomoneda_id" => $id_tipomoneda,            
            "valor" => $valorTipomonedavalor,
            "mes" => $mesTipomonedavalor,
            "ano" => $anoTipomonedavalor
        );
        
        
        $db->where('tipomoneda_id',$id_tipomoneda);
        $db->where('mes',$mesTipomonedavalor);
        $db->where('ano',$anoTipomonedavalor);
        $currentValor = $db->getOne('m_tipomonedavalor','id');
        
        if( $db->count > 0 ){
            editarTipomonedavalor($currentValor['id'],$data);
            logit( $_SESSION[PREFIX.'login_name'],'editar','tipomonedavalor',$currentValor['id'],$db->getLastQuery() );
            $create_id = $currentValor['id'];
        } else {
            $create_id = crearTipomonedavalor($data);
            logit( $_SESSION[PREFIX.'login_name'],'crear','tipomonedavalor',$create_id,$db->getLastQuery() );    
        }
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');            
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);                            
        }
        
        redirect(BASE_URL . '/tipomonedavalor/ingresar/' . $id_tipomoneda );
        exit();                   
    }      
}

if( $parametros ){
    /** Consultar datos de tipomonedavalor **/
    if( isset($parametros[1]) ){
        $db->where ("tipomoneda_id", $parametros[1]);
        $db->orderBy("ano","DESC");
        $db->orderBy("mes","DESC");
        $tipomonedavalor = $db->get("m_tipomonedavalor");        
        
        $db->where ("id", $parametros[1]);
        $tipomoneda = $db->getOne("m_tipomoneda");
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

