<?php

if( $_POST ){
    

    $bancos = sqlServQuery("select top 5 * from BANCO");
    
    show_array($bancos);   
    
    //FUNCIONAAAAA CTM!!!     

    exit();
}

if( $parametros ){
    
    switch ($parametros[0]) {
        case 'ingresar-criterio-centrocosto':
            $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
            $ccostos = $db->get('m_centrocosto');
            break;
        
        default:
            break;
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

