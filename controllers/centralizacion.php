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
    $mes = 8;
    $ano = (int)getAnoMostrarCorte();
        
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $ccostos = $db->get('m_centrocosto');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_criterios_centrocosto = $db->get('c_crixccostos');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_criterios_entidad = $db->get('c_crixentidad');
    
    $db->where('fk_empreid',$_SESSION[PREFIX.'login_eid']);
    $registros_individual = $db->get('c_crixindividual');
    
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

        foreach ($crit_x_ccosto as $crixccosto) {
            $db->where('fk_criterioid',$crixccosto['id']);
            $campos = $db->get('c_mallaliq');

            $subtotal = 0;
            foreach ($campos as $key => $campo) {

                $db->where('id',$campo['fk_criterioid']);
                $id_ccosto = $db->getValue("c_crixccostos",'id_ccosto');

                if( !in_array($campo['origen'],$tables_not_liq) ){
                    $sql = "
                    SELECT SUM(LIQ.". $campo['campo'] .") AS tot FROM liquidacion LIQ, m_trabajador T
                    WHERE LIQ.mes = $mes
                    AND LIQ.ano = $ano
                    AND LIQ.empresa_id = ".session('login_eid')."
                    AND LIQ.trabajador_id = T.id
                    AND T.centrocosto_id = " . $id_ccosto . "
                    ";
                } else {
                    $sql = "
                    SELECT SUM(".$campo['origen']. "." . $campo['campo'] .") AS tot FROM ". $campo['origen'] .", liquidacion LIQ
                    WHERE LIQ.mes = $mes
                    AND LIQ.ano = $ano
                    AND LIQ.empresa_id = ".session('login_eid')."
                    AND ".$campo['origen'].".liquidacion_id = LIQ.id
                    ";
                }

                $result = $db->rawQuery($sql);
                $subtotal += $result[0]['tot'];

            }


            $array_data['crit_x_ccosto'][] = [
                'criterio' => $crixccosto['criterio'],
                'centro_costo' => getNombre($crixccosto['id_ccosto'], 'm_centrocosto', true),
                'centro_costo_id' => $crixccosto['id_ccosto'],
                'subtotal' => $subtotal
            ];
        }




        $query_field = [
            'm_afp' => ['campo_monto' => 'afpMonto','campo_id' => 'afp_id'],
            'm_isapre' => ['campo_monto' => 'saludMonto','campo_id' => 'isapre_id'],
            'm_institucion' => ['campo_monto' => 'apvMonto','campo_id' => 'cuenta2Id']
        ];

        foreach ($crit_x_entidad as $crixentidad) {

            $sql = "
            SELECT SUM(L.". $query_field[$crixentidad['tabla_entidad']]['campo_monto'] .") AS tot 
            FROM liquidacion L
            WHERE L." . $query_field[$crixentidad['tabla_entidad']]['campo_id'] . " = ". $crixentidad['id_entidad'] ."
            AND L.mes = ". $mes ."
            AND L.ano = ". $ano ."
            ";

            $result = $db->rawQuery($sql);
            $subtotal += $result[0]['tot'];

            $array_data['crit_x_entidad'][] = [
                'criterio' => $crixentidad['criterio'],
                'entidad' => getNombre($crixentidad['id_entidad'], $crixentidad['tabla_entidad'], false),
                'entidad_id' => $crixentidad['id_entidad'],
                'subtotal' => $subtotal,
                'tipo_entidad' => $crixentidad['tabla_entidad']
            ];

        }


        $sql_adm = "
        select T.apellidoPaterno, T.apellidoMaterno, T.nombres, L.sueldoBase, L.gratificacion, (L.sueldoBase + L.gratificacion) as imponible, L.horaExtraMonto, L.horaExtraFestivoMonto, L.totalHaberesImponibles
        from m_trabajador T, liquidacion L
        WHERE L.mes = $mes
        AND L.ano = $ano
        AND T.empresa_id = 2
        AND T.centrocosto_id = 2
        and L.trabajador_id = T.id  
        ORDER BY `T`.`apellidoPaterno` ASC
        ";
        $result_adm = $db->rawQuery($sql_adm);

        $sql_com = "
        select T.apellidoPaterno, T.apellidoMaterno, T.nombres, L.sueldoBase, L.gratificacion, (L.sueldoBase + L.gratificacion) as imponible, L.horaExtraMonto, L.horaExtraFestivoMonto, L.totalHaberesImponibles
        from m_trabajador T, liquidacion L
        WHERE L.mes = $mes
        AND L.ano = $ano
        AND T.empresa_id = 2
        AND T.centrocosto_id = 4
        and L.trabajador_id = T.id  
        ORDER BY `T`.`apellidoPaterno` ASC
        ";
        $result_com = $db->rawQuery($sql_com);

        $arr_results = [
            2 => $result_adm,
            4 => $result_com
        ];

        $sql_tec = "
        select T.apellidoPaterno, T.apellidoMaterno, T.nombres, L.sueldoBase, L.gratificacion, (L.sueldoBase + L.gratificacion) as imponible, L.horaExtraMonto, L.horaExtraFestivoMonto, L.totalHaberesImponibles
        from m_trabajador T, liquidacion L
        WHERE L.mes = $mes
        AND L.ano = $ano
        AND T.empresa_id = 2
        AND T.centrocosto_id = 3
        and L.trabajador_id = T.id  
        ORDER BY `T`.`apellidoPaterno` ASC
        ";
        $result_tec = $db->rawQuery($sql_tec);

        $arr_results = [
            2 => $result_adm,
            4 => $result_com,
            3 => $result_tec
        ];


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

