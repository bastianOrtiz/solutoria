<?php
@extract($_POST);

$mes = getMesMostrarCorte();
$mes = (int)$mes;
$ano = getAnoMostrarCorte();

if( isAdmin() ){
    $anticipo_espera_todos = $db->get('m_anticipo');
}

$sql = "
SELECT  * FROM t_descuento 
WHERE  trabajador_id = '" . $_SESSION[PREFIX.'login_uid'] . "'  
AND descuento_id = ".ID_ANTICIPO."  
AND (activo = 1  OR ( activo = 0 AND fechaFinalizacion IS NOT NULL ) )
ORDER BY anoInicio DESC, mesInicio DESC 
";
$anticipo_historial = $db->rawQuery( $sql );


$db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
$db->where('mes',$mes);
$db->where('ano',$ano); 
$db->where('aprobado',null,'IS');
$anticipo_espera = $db->get('m_anticipo');


$db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
$db->where('mes',$mes);
$db->where('ano',$ano); 
$db->where('aprobado',0);
$anticipo_historial_rechazados = $db->get('m_anticipo');


$reglas_anticipo = "No mas del 50% del liquido del mes anterior 
	No mas de 1 al mes
	Maximo: al día 12 del mes en curso	
";

if( $_POST ){        
    
    if( ( $action == 'aprobar' ) && (isAdmin()) ){
        
        $db->where('id',$anticipo_id);
        $anticipo_pre = $db->getOne('m_anticipo');
                
        $db->where('trabajador_id', $anticipo_pre['trabajador_id'] );
        $db->where('descuento_id',ID_ANTICIPO);
        $db->where('activo',1);        
        $db->where('mesInicio',$anticipo_pre['mes'] );
        $db->where('anoInicio',$anticipo_pre['ano'] );
        $db->where('fechaFinalizacion',null, 'IS');
        $existe_anticipo = $db->getOne('t_descuento');
        
        
        if( $db->count > 0 ){
            $response = encrypt('status=warning&mensaje=Ya tiene un anticipo ingresado en la base de datos para el mes actual&id=');
        } else {
            if( $status_aprobacion == 1 ){
                $data = array(            
                    'mesInicio' => $anticipo_pre['mes'],
                    'anoInicio' => $anticipo_pre['ano'],
                    'fechaInicio' => $anticipo_pre['ano'].'-'.leadZero($anticipo_pre['mes']).'-01',
                    'cuotaActual' => 1,
                    'cuotaTotal' => 1,
                    'procesado' => 0,
                    'tipomoneda_id' => 1,
                    'valor' => $anticipo_pre['monto'],
                    'descuento_id' => ID_ANTICIPO,
                    'trabajador_id' => $anticipo_pre['trabajador_id'],
                    'activo' => 1
                );                
                $insert_id = $db->insert('t_descuento', $data);
                logit( $_SESSION[PREFIX.'login_name'],'aprobar','anticipo (t_descuento)',$insert_id,$db->getLastQuery() );
            }
            
            $data_upd = array(
                "aprobado" => $status_aprobacion,
                "aprobadoPor" => $_SESSION[PREFIX.'login_name'], 
                "fechaAprobacion" => date('Y-m-d H:i:s')
            );
            $db->where('id',$anticipo_pre['id']);
            $db->update('m_anticipo',$data_upd);
            logit( $_SESSION[PREFIX.'login_name'],'rechazar','anticipo',$anticipo_pre['id'],$db->getLastQuery() );
            
            $response = encrypt('status=success&mensaje=Anticipo Aprobado correctamente&id='.$insert_id);                           
        }
        
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();         
    }
    
    if( $action == "anticipo" ){
        
        $db->where('id',$_SESSION[PREFIX.'login_uid']);
        $sueldo_base = $db->getValue('m_trabajador','sueldoBase');        
        
        $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
        $db->where('mes',$mes);
        $db->where('ano',$ano);        
        $anticipo = $db->getOne('m_anticipo');
                
        if( $db->count > 0 ){
            $response = encrypt('status=warning&mensaje=Ya tiene un anticipo solicitado para el mes actual&id=');            
        } else {
            
            $medio_sueldo = ($sueldo_base / 2 );            
            if( $anticipoMonto > $medio_sueldo ){
                $response = encrypt('status=warning&mensaje=El monto del anticipo supera el 50% del sueldo base&id=');
            } else {                                                
                $data = array(            
                    'mes' => $mes,
                    'ano' => $ano,
                    'monto' => $anticipoMonto,
                    'trabajador_id' => $_SESSION[PREFIX.'login_uid']                    
                );                
                $insert_id = $db->insert('m_anticipo', $data);                
                                
                if( !$insert_id ){
                    logit( $_SESSION[PREFIX.'login_name'],'solicitar','anticipo',$insert_id,$db->getLastQuery() );
                    $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id=');    
                } else {
                    $response = encrypt('status=success&mensaje=Anticipo solicitado correctamente&id='.$insert_id);
                } 
            }                                   
        }         
        
        redirect(BASE_URL . '/' . $entity . '/solicitar/response/' . $response );
        exit();        
    }
}

if( $action == "solicitar" && isAdmin() ){
    redirect(BASE_URL . '/' . $entity . '/listar' );
    exit();
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

