<?php

if( $_POST ){
    
    switch ($_POST['action']) {
        case 'new_criterio_centrocosto':

            $data_insert = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
                'id_ccosto' => $_POST['centroCosto']
            ];

            $create_id = $db->insert('c_crixccostos',$data_insert);

            logit( $_SESSION[PREFIX.'login_name'],'agregar','criterio x centrocosto',$create_id,$db->getLastQuery() );
        
            if(!$create_id){
                $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            } else {
                $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            }

            redirect(BASE_URL . '/centralizacion/criterios-centrocosto/response/' . $response );
            exit();

            break;


        case 'new_criterio_entidad';
            $data_insert = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
                'id_entidad' => $_POST['entidad'],
                'tabla_entidad' => $_POST['tablaEntidad']
            ];

            $create_id = $db->insert('c_crixentidad',$data_insert);

            logit( $_SESSION[PREFIX.'login_name'],'agregar','criterio x entidad',$create_id,$db->getLastQuery() );
        
            if(!$create_id){
                $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            } else {
                $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            }

            redirect(BASE_URL . '/centralizacion/criterios-entidad/response/' . $response );
            exit();
            break;
        
        default:
            break;
    }

}

if( $parametros ){
    switch ($parametros[0]) {
        case 'ingresar-criterio-centrocosto':
        case 'ingresar-criterio-entidad':
            $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
            $ccostos = $db->get('m_centrocosto');
            break;
        
        case 'criterios-centrocosto':
            $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
            $registros = $db->get('c_crixccostos');
            break;


        case 'criterios-entidad':
            $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
            $registros = $db->get('c_crixentidad');
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

