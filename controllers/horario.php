<?php

if( getComparte('Horario') ){
    $sql_horarios = 'SELECT * FROM m_cuenta c, m_empresa e, m_horario h WHERE c.id=e.cuenta_id and e.id=h.empresa_id and c.id = ' . $_SESSION[ PREFIX . 'login_cid' ] ;
    $registros = $db->rawQuery( $sql_horarios );
} else {
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $registros = $db->get("m_horario");    
} 
$horarios = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$action == 'edit' ){
        
        $data = Array (
            "nombre" => $nombreHorario,            
            "descripcion" => $descripcionHorario,
            "entradaTrabajo" => $entradaTrabajoHorario,
            "salidaTrabajo" => $salidaTrabajoHorario,
            "entradaColacion" => $entradaColacionHorario,            
            "salidaColacion" => $salidaColacionHorario,
            "activo" => $activoHorario,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );        
        $dias = array('lun','mar','mie','jue','vie','sab','dom');
        foreach( $dias as $d ){
            if( @$diasHorario[$d] ){
                $data[$d] = 1;
            } else {
                $data[$d] = 0;
            }
        } 
        

        if( editarHorario($horario_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'horario',$horario_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$horario_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $horario_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$horario_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $horario_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$action == 'delete' ){
        $delete = eliminarHorario( $horario_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'horario',$horario_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$horario_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la horario porque tiene trabajadores asociados&id='.$horario_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$action == 'new' ){
        
        $data = Array (
            "nombre" => $nombreHorario,            
            "descripcion" => $descripcionHorario,
            "entradaTrabajo" => $entradaTrabajoHorario,
            "salidaTrabajo" => $salidaTrabajoHorario,
            "entradaColacion" => $entradaColacionHorario,            
            "salidaColacion" => $salidaColacionHorario,
            "activo" => $activoHorario,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );
        
        $dias = array('lun','mar','mie','jue','vie','sab','dom');
        foreach( $dias as $d ){
            if( @$diasHorario[$d] ){
                $data[$d] = 1;
            } else {
                $data[$d] = 0;
            }
        }               
        
        $create_id = crearHorario($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'horario',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }                   
    }      
}

if( $parametros ){
    /** Consultar datos de horario **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $db->where ("empresa_id", $_SESSION[PREFIX.'login_eid']);
        $horario = $db->getOne("m_horario");        
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

