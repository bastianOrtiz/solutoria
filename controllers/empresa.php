<?php

$db->where('cuenta_id',$_SESSION[PREFIX.'login_cid']);
$registros = $db->get("m_empresa");

$comunas = $db->get('m_comuna');
$regiones = $db->get('m_region');

if( getComparte('Ausencia') ){
    $sql_aus = "SELECT a.nombre, a.id FROM m_ausencia a, m_empresa e, m_cuenta c WHERE c.id=e.cuenta_id and e.id=a.empresa_id and c.id = " . $_SESSION[ PREFIX . 'login_cid' ];     
} else{
    $sql_aus = "SELECT a.nombre, a.id FROM m_ausencia a, m_empresa e WHERE e.id=a.empresa_id and e.id = " . $_SESSION[ PREFIX . 'login_eid' ];
}
$ausencias_empresa = $db->rawQuery( $sql_aus );


function fnGetRegionEmpresa($comuna_id){
    global $db;
    $db->where('id', $comuna_id);
    $id_reg = $db->getOne('m_comuna','region_id');
    return $id_reg['region_id'];
}

function fnNombreComuna($id_comuna){
    global $db;    
    $db->where('id', $id_comuna);
    $comuna = $db->getOne('m_comuna','nombre');
    return $comuna['nombre'];
}

if( $_POST ){
    
    extract($_POST);
    
    if( $action == 'change_empresa' ){        
        $_SESSION[PREFIX.'login_eid'] = $eid;
        $db->where('id',$eid);
        $empresa = $db->getOne('m_empresa','nombre');
        $_SESSION[PREFIX.'login_empresa'] = $empresa['nombre'];
        redirect($current_url);
        exit();
    }
    
    if( @$_POST['action'] == 'edit' ){
        $relojControl = $relojControl[0];
        $relojControlSync = $relojControlSync[0];
        
        $umbralRelojControl = $horaUmbralRelojControl.":".$minutoUmbralRelojControl.":00";
        
        $db->where('id',$empresa_id);
        $foto = $db->getOne('m_empresa','foto');   

        $data = Array (
            "nombre" => $nombreEmpresa,
            "razonSocial" => $razonSocial,
            "rut" => $rutEmpresa,
            "direccion" => $direccionEmpresa,
            'ciudad' => $ciudadEmpresa,
            "giro" => $giroEmpresa,            
            "empleaRelojControl" => $relojControl,
            "relojControlSync" => $relojControlSync,
            "diaCorte" => $fechaCorteEmpresa,
            "diaCierre" => $fechaCierreEmpresa,
            "minutoGracia" => $minutoGraciaEmpresa,
            "horasDescuentoNoMarca" => $horasNomarcoEmpresa,
            "umbralRelojControl" => $umbralRelojControl,
            "ausenciaVacaciones" => $tipoAusenciaVacaciones,
            "representante" => $representante,
            "rut_representante" => $rut_representante,
            "comuna_id" => $empresaComuna,
            "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
            "mutual_id" => $institucionAseguradora,
            "cajacompensacion_id" => $cajaCompensacion
        );
      
        
        if( $_FILES['logoEmpresa']['name'] != "" ){
            $return = upload_image('logoEmpresa', ROOT . '/private/uploads/images/');            
            $data['foto'] = $return['filename'];    
        } else {
            $data['foto'] = $foto['foto'];
        }                
        
        if( editarEmpresa($empresa_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'empresa',$empresa_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $empresa_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $empresa_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarEmpresa( $empresa_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'empresa',$empresa_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$empresa_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la empresa porque tiene trabajadores asociados&id='.$empresa_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $relojControl = $relojControl[0];
        $relojControlSync = $relojControlSync[0];
        
        $umbralRelojControl = $horaUmbralRelojControl.":".$minutoUmbralRelojControl.":00";
        
        $exist = verificarExisteEmpresa($rutEmpresa);        
        if($exist){            
            goBack('El registro ya se encuentra en la base de datos');
            exit();
        } else {
        
            $logo_uploaded = upload_image('logoEmpresa', ROOT . '/private/uploads/images/');                     
            
            $data = Array(
                "nombre" => $nombreEmpresa,
                "razonSocial" => $razonSocial,
                "rut" => $rutEmpresa,
                "direccion" => $direccionEmpresa,
                'ciudad' => $ciudadEmpresa,
                "giro" => $giroEmpresa,
                "foto" => $logo_uploaded['filename'],
                "empleaRelojControl" => $relojControl,
                "relojControlSync" => $relojControlSync,
                "diaCorte" => $fechaCorteEmpresa,
                "diaCierre" => $fechaCierreEmpresa,
                "minutoGracia" => $minutoGraciaEmpresa,
                "horasDescuentoNoMarca" => $horasNomarcoEmpresa,
                "umbralRelojControl" => $umbralRelojControl,
                "ausenciaVacaciones" => $tipoAusenciaVacaciones,
                "representante" => $representante,
                "rut_representante" => $rut_representante,
                "comuna_id" => $empresaComuna,
                "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
                "mutual_id" => $institucionAseguradora,
                "cajacompensacion_id" => $cajaCompensacion
            );
            
            $create_id = crearEmpresa($data);
            
            if(!$create_id){                                                
                $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD: '. $db->getLastError() .'&id=NULL');
                redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );                
            } else {
                $arr_insert_corte = array(
                    'mes' => date('m'),
                    'ano' => date('Y'),
                    'dia' => 1,
                    'empresa_id' => $create_id
                );
                $db->insert('m_corte',$arr_insert_corte);
                logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'empresa',$create_id,$db->getLastQuery() );
                
                
                $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
                redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            }                        
            exit();
        }           
    }      
}

if( $parametros ){
    /** Consultar datos de empresa **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $empresa = $db->getOne("m_empresa");             
    }
    
    $umbral = $empresa['umbralRelojControl'];
    $umbral = explode(":",$umbral);    
    $umbralHora = $umbral[0];
    $umbralMinuto = $umbral[1];

    $instituciones_aseguradoras = $db->get('m_mutual');
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

