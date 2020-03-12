<?php
$ano = getAnoMostrarCorte();

$db->where("id",$_SESSION[PREFIX.'login_eid']);
$id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');

$db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
$db->where('aprobado',null,'IS');
$vacaciones_espera = $db->get('m_vacaciones');


$sql = "
SELECT  * FROM t_ausencia 
WHERE  trabajador_id = ".$_SESSION[PREFIX.'login_uid']."    
AND ausencia_id = $id_ausencia_vacaciones
";
$vacaciones_historial = $db->rawQuery( $sql );

$db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
$db->where('aprobado',0);
$vacaciones_historial_rechazados = $db->get('m_vacaciones');

//if( isAdmin() ){
    $vacaciones_espera_todos = $db->get('m_vacaciones');
//}


if( $_POST ){
    extract($_POST);  
          
    if( @$_POST['action'] == 'solicitar_vacaciones' ){                
        
        $diasHabiles = diasHabiles( $_SESSION[PREFIX.'login_uid'],$desdeVacaciones, $hastaVacaciones, $id_ausencia_vacaciones);                
        
        $diasVacacionesTrabajador = $db->getValue('m_trabajador','diasVacaciones');
        
        if( $diasHabiles > $diasVacacionesTrabajador ){
            $response = encrypt("status=warning&mensaje=No puede solicitar mas de $diasVacacionesTrabajador días hábiles legales&id=");    
        } else{
            //SELECT * from t_ausencia WHERE trabajador_id = 1 and ausencia_id = 4 and YEAR( fecha_inicio ) = '2016'
            $sub_total_dias = 0;
            
            $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);
            $db->where('ausencia_id',4);
            $db->where('YEAR( fecha_inicio )',$ano);
            $vacas = $db->get('t_ausencia');
                      
            foreach( $vacas as $v ){
                $datetime1 = new DateTime($v['fecha_inicio']);
                $datetime2 = new DateTime($v['fecha_fin']);
                $interval = $datetime1->diff($datetime2);                
                $int_dias += (int)($interval->format('%a'));                
                $sub_total_dias += $int_dias;
            }
            
            $vacacionesDisponibleEsteAno = ( $diasVacacionesTrabajador - $sub_total_dias );
            
            if( $diasHabiles > $vacacionesDisponibleEsteAno ){
                $response = encrypt("status=warning&mensaje=No puede solicitar mas de $diasVacacionesTrabajador dias habiles legales en el año &id=");
            } else {
                
                $data_insert = array(
                    'trabajador_id' => $_SESSION[PREFIX.'login_uid'],
                    'fecha_inicio' => $desdeVacaciones,
                    'fecha_fin' => $hastaVacaciones,
                    'totalDias' => $diasHabiles                    
                );
                $insert_id = $db->insert('m_vacaciones',$data_insert);
                
                $response = encrypt('status=success&mensaje=Vacaciones solicitadas correctmente&id=');
            }
            
        }
        
        logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'vacaciones',$insert_id,$db->getLastQuery() );
        
        redirect(BASE_URL . '/' . $entity . '/solicitar/response/' . $response );
        exit();
    }
    
    
    if( $action == 'aprobar' ){                        
        
        $db->where('id',$vacaciones_id);
        $vacaciones_pre = $db->getOne('m_vacaciones');
    
        if( $status_aprobacion == 1 ){
            $data = Array (
                "fecha_inicio" => $vacaciones_pre['fecha_inicio'],            
                "fecha_fin" => $vacaciones_pre['fecha_fin'],        
                "ausencia_id" => $id_ausencia_vacaciones,
                "trabajador_id" => $vacaciones_pre['trabajador_id']
            );                        
                           
            $insert_id = $db->insert('t_ausencia', $data);
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'vacaciones (t_ausencia)',$insert_id,$db->getLastQuery() );
        }
        
        
        
        $data_upd = array(
            "aprobado" => $status_aprobacion,
            "aprobadoPor" => $_SESSION[PREFIX.'login_name'], 
            "fechaAprobacion" => date('Y-m-d H:i:s')
        );                
        
        $db->where('id',$vacaciones_pre['id']);
        $db->update('m_vacaciones',$data_upd);
        
        $response = encrypt('status=success&mensaje=Datos guardados correctamente&id='.$insert_id);                           
    
        
        redirect(BASE_URL . '/' . $entity . '/ver_solicitudes/response/' . $response );
        exit();         
    }
    
}

if( $parametros ){  
    
    if( $parametros[0] == 'calendario' ){
                
                
                
        /** Proceso para determinar los trabajadores del jefe logueado **/
        // Cargo del jefe logeado
        $db->where('id',$_SESSION[PREFIX.'login_uid']);
        $cargo_id = $db->getValue('m_trabajador','cargo_id');
        
        $sql = " 
            SELECT id from m_cargo where cargoPadreId in 
                ( SELECT id FROM m_cargo where cargoPadreId IN 
                    ( SELECT id FROM `m_cargo` WHERE cargoPadreId = $cargo_id )
                ) 
            OR cargoPadreId = $cargo_id 
            OR cargoPadreId IN 
                (SELECT id FROM `m_cargo` WHERE cargoPadreId = $cargo_id
            )";
            
        $childs = $db->rawQuery( $sql );
        
        // Todos los trabajadores que pertenecen a cualquiera de los cargos hijos
        foreach( $childs as $hijo ){
            $db->orWhere('cargo_id',$hijo['id']);
        }
        $trabajadores_x_cargo = $db->get('m_trabajador',null,array( 'id' ));
        $IN_concat = "( ";
        foreach( $trabajadores_x_cargo as $trab_hijos ){
            //$array_hijos[] = $trab_hijos['id'];
            $IN_concat .= $trab_hijos['id'].',';
        }        
        $IN_concat = trim($IN_concat,",");
        $IN_concat .= " )";
                
        $sql_ausencias_vacaciones = "
        SELECT * FROM t_ausencia WHERE ausencia_id = $id_ausencia_vacaciones
        AND trabajador_id IN $IN_concat
        ";            
        $ausencias_all = $db->rawQuery( $sql_ausencias_vacaciones );                
        
        $colors = array('#d76a6a','#b46ad7','#6a6dd7','#6ab2d7','#fe7575','#0ee669','#7fd76a','#d3d76a','#dca13a','#8b8baf');             
        $color_cont = 0;
        $events = '';
        foreach( $ausencias_all as $aus ){
            $fecha_fin = date($aus['fecha_fin']);
            $nuevafecha_fin = strtotime ( '+1 day' , strtotime ( $fecha_fin ) ) ;
            $nuevafecha_fin = date ( 'Y-m-d' , $nuevafecha_fin );                                 
            
            $events .= "{
              title: '". getNombreTrabajador( $aus['trabajador_id'] ) ."',
              desc: '". getNombreTrabajador( $aus['trabajador_id'] ) ."\\n(Desde: " . $aus['fecha_inicio'] . ", Hasta: ". $aus['fecha_fin'] .")',
              start: '". $aus['fecha_inicio'] ."',
              end: '". $nuevafecha_fin ."',
              backgroundColor: '".$colors[$color_cont]."',
              borderColor: '".$colors[$color_cont]."'
            },";            
            
            $color_cont++;
            if( $color_cont == 10 )
                $color_cont = 0;            
            
        }
        $events = trim($events,',');
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

