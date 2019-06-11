<?php

if( $_POST ){
    
    $pass = "devti777";
    $usuario = "desarrollo";
    $nombreBaseDeDatos = "test";
    # Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
    $rutaServidor = "192.168.0.3";
    try {
        $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $pass);
        $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Ocurrió un error con la base de datos: " . $e->getMessage();
    }

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

