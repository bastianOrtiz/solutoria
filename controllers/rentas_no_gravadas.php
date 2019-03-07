<?php

if( $_POST ){

    if( $_POST['action'] == 'ingresar' ){

        $db->where('id_trabajador',$_POST['trabajador_id']);
        $db->where('ano',$_POST['ano']);
        $db->where('mes',$_POST['mes']);
        $exist = $db->getOne('t_rentasnogravadas');

        if( $exist ){
            goBack("Ya existe datos para el trabajador y periodo seleccionado\\nIngrese nuevos datos o Busque en el listado y edite la información deseada");
            exit();
        }

        $detalle = [];
        $monto_total = 0;
        foreach ($_POST['glosa'] as $key => $value) {
            $detalle[] = [ 'glosa' => $_POST['glosa'][$key], 'monto' => $_POST['monto'][$key] ];
            $monto_total += (int)$_POST['monto'][$key];
        }
        $detalle = json_encode($detalle);
        
        $data_insert = [
            'id_trabajador' => $_POST['trabajador_id'],
            'ano' => $_POST['ano'],
            'mes' => $_POST['mes'],
            'valor' => $monto_total,
            'detalle' => $detalle
        ];

        $insert_id = $db->insert('t_rentasnogravadas',$data_insert);

        if(!$insert_id){
            redirect(BASE_URL.'/rentas_no_gravadas', 302, true, 'Hubo un problema al ingresar el dato');
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'rentas_no_gravadas',$insert_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha ingreado correctamente&id='.$insert_id);
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();
        }
    }


    if( $_POST['action'] == 'editar' ){
        $detalle = [];
        $monto_total = 0;
        foreach ($_POST['glosa'] as $key => $value) {
            $detalle[] = [ 'glosa' => $_POST['glosa'][$key], 'monto' => $_POST['monto'][$key] ];
            $monto_total += (int)$_POST['monto'][$key];
        }
        $detalle = json_encode($detalle);
        
        $data_update = [
            'ano' => $_POST['ano'],
            'mes' => $_POST['mes'],
            'valor' => $monto_total,
            'detalle' => $detalle
        ];

        $db->where('id',$_POST['id']);
        $upd = $db->update('t_rentasnogravadas',$data_update);

        if(!$upd){
            redirect(BASE_URL.'/rentas_no_gravadas', 302, true, 'Hubo un problema al ingresar el dato');
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'rentas_no_gravadas',$_POST['id'],$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha ingreado correctamente&id='.$_POST['id']);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $_POST['id'] . '/response/' . $response );
            exit();
        }
    }


    if( $_POST['action'] == 'delete' ){
        $db->where('id',$_POST['id']);
        $delete = $db->delete('t_rentasnogravadas');
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'rentas_no_gravadas',$_POST['id'],$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$departamento_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la departamento porque tiene trabajadores asociados&id='.$departamento_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }

}

$rentas = $db->get('t_rentasnogravadas');

$db->orderBy('apellidoPaterno','ASC');
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$db->where('tipocontrato_id',array(3,4),'NOT IN');
$trabajadores_todos = $db->get('m_trabajador');


if( ($parametros[1]) && ($parametros[0] == 'editar') ){

    $db->where('id',$parametros[1]);
    $data_renta = $db->getOne('t_rentasnogravadas');
    $detalle = json_decode($data_renta['detalle']);
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
