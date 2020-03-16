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
        
        case 'edit_criterio_centrocosto':

            $data_update = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
                'id_ccosto' => $_POST['centroCosto']
            ];
            $db->where('id',$_POST['regid']);
            $db->update('c_crixccostos',$data_update);

            logit( $_SESSION[PREFIX.'login_name'],'editar','criterio x centrocosto',$_POST['regid'],$db->getLastQuery() );
        
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$_POST['regid']);
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


        case 'edit_criterio_entidad':

            $data_update = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
                'id_entidad' => $_POST['entidad'],
                'tabla_entidad' => $_POST['tablaEntidad']
            ];
            $db->where('id',$_POST['regid']);
            $db->update('c_crixentidad',$data_update);

            logit( $_SESSION[PREFIX.'login_name'],'editar','criterio x entidad',$_POST['regid'],$db->getLastQuery() );
        
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$_POST['regid']);
            redirect(BASE_URL . '/centralizacion/criterios-entidad/response/' . $response );
            exit();

            break;
        

        case 'new_criterio_idividual';
            $data_insert = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
            ];

            $create_id = $db->insert('c_crixindividual',$data_insert);

            logit( $_SESSION[PREFIX.'login_name'],'agregar','criterio x individual',$create_id,$db->getLastQuery() );
        
            if(!$create_id){
                $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            } else {
                $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            }

            redirect(BASE_URL . '/centralizacion/criterios-individual/response/' . $response );
            exit();
            break;
        

        case 'edit_criterio_idividual';
            $data_update = [
                'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                'criterio' => $_POST['nombreCriterio'],
                'DH' => $_POST['dh'],
                'ctacont' => $_POST['cuentaContable'],
                'nombre_cta' => $_POST['nombreCuentaContable'],
            ];

            $db->where('id',$_POST['regid']);
            $db->update('c_crixindividual',$data_update);

            logit( $_SESSION[PREFIX.'login_name'],'editar','criterio x individual',$_POST['regid'],$db->getLastQuery() );
        
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$_POST['regid']);            
            redirect(BASE_URL . '/centralizacion/criterios-individual/response/' . $response );
            exit();
            break;
        



        case 'new_malla_liq':

            foreach ($_POST['campos'] as $campo) {
                $data_insert = [
                    'fk_empreid' => $_SESSION[PREFIX.'login_eid'],
                    'origen' => $_POST['origenMalla'],
                    'campo' => $campo,
                    'tipo_criterio' => $_POST['tipoCriterioMalla'],
                    'fk_criterioid' => $_POST['criterioMalla']
                ];

                $create_id = $db->insert('c_mallaliq',$data_insert);
                logit( $_SESSION[PREFIX.'login_name'],'agregar','Malla liquidacion',$create_id,$db->getLastQuery() );
            }  

            
            $response = encrypt('status=success&mensaje=Los registros se han creado correctamente&id='.null);
            redirect(BASE_URL . '/centralizacion/malla-liquidacion-list/response/' . $response );
            exit(); 

            break;


        case 'eliminar_malla_batch':

            $in = '';
            foreach ($_POST['batch'] as $id) {
                $in .= $id . ',';
                logit( $_SESSION[PREFIX.'login_name'],'Eliminar','Malla liquidacion',$id,$db->getLastQuery() );
            }  
            $in = trim($in,',');

            $sql = "DELETE FROM c_mallaliq WHERE id IN ($in)";
            $db->rawQuery($sql);
            
            $response = encrypt('status=success&mensaje=Los registros se han eliminado correctamente&id='.null);
            redirect(BASE_URL . '/centralizacion/malla-liquidacion-list/response/' . $response );
            exit(); 

            break;


        case 'eliminar_one':

            $db->where('id',$_POST['malla_id']);
            $db->delete('c_mallaliq');
            
            $response = encrypt('status=success&mensaje=Registros eliminado correctamente&id='.null);
            redirect(BASE_URL . '/centralizacion/malla-liquidacion-list/response/' . $response );
            exit(); 

            break;


        default:
            break;
    }

}

if( $parametros ){

    //$mes = (int)getMesMostrarCorte();
    //$ano = (int)getAnoMostrarCorte();
    $mes = 01;
    $ano = 2020;

        
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $ccostos = $db->get('m_centrocosto');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_criterios_centrocosto = $db->get('c_crixccostos');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_criterios_entidad = $db->get('c_crixentidad');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_individual = $db->get('c_crixindividual');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $db->groupBy('fk_criterioid');
    $criterios_id = $db->get('c_mallaliq',null,'fk_criterioid');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_malla = $db->get('c_mallaliq');


    if( $parametros[0] == 'criterios-centrocosto' && $parametros[1] == 'editar' && isset($parametros[2]) ){
        $parametros[0] = 'editar-criterio-centrocosto';
        $db->where('id',$parametros[2]);
        $criterio = $db->getOne('c_crixccostos');
    }
    
    if( $parametros[0] == 'criterios-entidad' && $parametros[1] == 'editar' && isset($parametros[2]) ){
        $parametros[0] = 'editar-criterio-entidad';
        $db->where('id',$parametros[2]);
        $criterio = $db->getOne('c_crixentidad');
    }
    
    if( $parametros[0] == 'criterios-individual' && $parametros[1] == 'editar' && isset($parametros[2]) ){
        $parametros[0] = 'editar-criterio-individual';
        $db->where('id',$parametros[2]);
        $criterio = $db->getOne('c_crixindividual');
    }

    if( $parametros[0] == 'centralizar' ){

        $campos_get = [
            'T.id as trabajador_id',
            'T.rut',
            'T.centrocosto_id',
            'L.sueldoBase',
            'L.gratificacion',
            'L.diaLicencia',
            'L.diaAusencia',
            'L.totalImponible'
        ];

        $db->join("m_trabajador T", "L.trabajador_id = T.id");
        $db->where('L.mes',$mes);
        $db->where('L.ano',$ano);
        $db->where('T.empresa_id',session('login_eid'));
        $results = $db->get('liquidacion L',null,$campos_get);

    }


    if( $parametros[0] == 'totales_x_criterios' ){
        
        $tables_not_liq = ['l_haber','l_descuento','l_apv'];
        $array_data = [];

        $crit_x_ccosto = $db->get('c_crixccostos');
        $crit_x_entidad = $db->get('c_crixentidad');
        $crit_x_individual = $db->get('c_crixindividual');



        // Tipos de Criterios: 1: CCOSTO, 2:ENTIDAD, 3:INDIVIDUAL

        foreach ($crit_x_ccosto as $crixccosto) {
            $db->where('fk_criterioid',$crixccosto['id']);
            $db->where('tipo_criterio',1);
            $campos = $db->get('c_mallaliq');

            $subtotal = 0;


            $tablas = [];
            foreach ($campos as $key => $campo) {
                if( !in_array($campo['origen'], $tablas) ){
                    $tablas[] = $campo['origen'];
                }
            }


            $sql_adm = "";

            $sql_adm .= "
            select 
                m_trabajador.apellidoPaterno, 
                m_trabajador.apellidoMaterno, 
                m_trabajador.nombres, ";
            foreach ($campos as $key => $campo) {
                $sql_adm .= $campo['origen'].".".$campo['campo'].",";
            }
            $sql_adm = trim($sql_adm,',');
            
            $sql_adm .= "\n FROM ";
            foreach ($tablas as $table) {
                $sql_adm .= $table . ",";
            }

            $sql_adm .= "m_trabajador ";

            $sql_adm .= "
            WHERE liquidacion.mes = $mes
            AND liquidacion.ano = $ano
            AND m_trabajador.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
            AND m_trabajador.centrocosto_id = ".$crixccosto['id_ccosto']."
            and liquidacion.trabajador_id = m_trabajador.id  
            AND m_trabajador.id = liquidacion.trabajador_id
            ORDER BY m_trabajador.apellidoPaterno ASC
            ";

            $all_data = $db->rawQuery($sql_adm);


            foreach ($campos as $key => $campo) {
                $totales[$campo['campo']] = 0;
            }


            foreach ($all_data as $tot_x_trabajador) {
                foreach ($campos as $key => $campo) {
                    $totales[$campo['campo']] += $tot_x_trabajador[$campo['campo']];
                }
            }

            $array_data['crit_x_ccosto'][$crixccosto['id_ccosto']] = [
                'criterio' => $crixccosto['criterio'],
                'centro_costo' => getNombre($crixccosto['id_ccosto'], 'm_centrocosto', true),
                'centro_costo_id' => $crixccosto['id_ccosto'],
                'totales' => $totales,
                'subtotal' => $totales['totalHaberesImponibles'] + $totales['horaExtraFestivoMonto'] + $totales['horaExtraMonto'] + $totales['gratificacion'] + $totales['sueldoBase'],
                'data' => $all_data
            ];
            
        }








        $query_field = [
            'm_afp' => ['campo_monto' => 'afpMonto','campo_id' => 'afp_id'],
            'm_isapre' => ['campo_monto' => 'saludMonto','campo_id' => 'isapre_id'],
            'm_institucion' => ['campo_monto' => 'apvMonto','campo_id' => 'cuenta2Id']
        ];

		
		show_array($crit_x_entidad, 1);

        foreach ($crit_x_entidad as $crixentidad) {
            $db->where('fk_criterioid',$crixentidad['id']);
            $db->where('tipo_criterio',2);
            $campos = $db->get('c_mallaliq');



            $tablas = [];
            foreach ($campos as $key => $campo) {
                if( !in_array($campo['origen'], $tablas) ){
                    $tablas[] = $campo['origen'];
                }
            }

            $sql_adm = "";

            $sql_adm .= "
            select 
                m_trabajador.apellidoPaterno, 
                m_trabajador.apellidoMaterno, 
                m_trabajador.nombres, ";
            foreach ($campos as $key => $campo) {
                $sql_adm .= $campo['origen'].".".$campo['campo'].",";
            }
            $sql_adm = trim($sql_adm,',');
            
            $sql_adm .= "\n FROM ";
            foreach ($tablas as $table) {
                $sql_adm .= $table . ",";
            }

            $sql_adm .= "m_trabajador ";

            $sql_adm .= "
            WHERE liquidacion." . $query_field[$crixentidad['tabla_entidad']]['campo_id'] . " = ". $crixentidad['id_entidad'] ."
            AND liquidacion.mes = ". $mes ."
            AND liquidacion.ano = ". $ano ."
            AND liquidacion.empresa_id = " . $_SESSION[PREFIX.'login_eid'];
            
			show_array($sql_adm, 0);

            $all_data = $db->rawQuery($sql_adm);

            foreach ($campos as $key => $campo) {
                $totales[$campo['campo']] = 0;
            }

            foreach ($all_data as $tot_x_trabajador) {
                foreach ($campos as $key => $campo) {
                    $totales[$campo['campo']] += $tot_x_trabajador[$campo['campo']];
                }
            }

            $array_data['crit_x_ccosto'][$crixccosto['id_ccosto']] = [
                'criterio' => $crixccosto['criterio'],
                'centro_costo' => getNombre($crixccosto['id_ccosto'], 'm_centrocosto', true),
                'centro_costo_id' => $crixccosto['id_ccosto'],
                'totales' => $totales,
                'subtotal' => $totales['totalHaberesImponibles'] + $totales['horaExtraFestivoMonto'] + $totales['horaExtraMonto'] + $totales['gratificacion'] + $totales['sueldoBase'],
                'data' => $all_data
            ];









            $subtotal_entidad = 0;

            if( $crixentidad['tabla_entidad'] == 'fonasa' ){
                $sql = "
                SELECT SUM(L.saludMonto) AS tot 
                FROM liquidacion L
                WHERE L.isapre_id = 0
                AND L.mes = ". $mes ."
                AND L.ano = ". $ano ."
                AND L.empresa_id = " . $_SESSION[PREFIX.'login_eid'];
            } elseif ($crixentidad['tabla_entidad'] == 'm_afc') {
                $sql = "
                SELECT SUM(L.saludMonto) AS tot 
                FROM liquidacion L
                WHERE L.isapre_id = 0
                AND L.mes = ". $mes ."
                AND L.ano = ". $ano ."
                AND L.empresa_id = " . $_SESSION[PREFIX.'login_eid'];
            } else {
                $sql = "
                SELECT SUM(L.". $query_field[$crixentidad['tabla_entidad']]['campo_monto'] .") AS tot 
                FROM liquidacion L
                WHERE L." . $query_field[$crixentidad['tabla_entidad']]['campo_id'] . " = ". $crixentidad['id_entidad'] ."
                AND L.mes = ". $mes ."
                AND L.ano = ". $ano ."
                AND L.empresa_id = " . $_SESSION[PREFIX.'login_eid'];
            }


            $result = $db->rawQuery($sql);
            $subtotal_entidad += $result[0]['tot'];

            $array_data['crit_x_entidad'][$crixentidad['id']] = [
                'criterio' => $crixentidad['criterio'],
                'entidad' => $crixentidad['id_entidad'],
                'entidad_id' => $crixentidad['id_entidad'],
                'subtotal' => $subtotal_entidad,
                'tipo_entidad' => $crixentidad['tabla_entidad'],
                'sql' => $sql
            ];
        }


    

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

