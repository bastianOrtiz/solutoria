<?php
$ids_relojcontrol = $db->rawQuery('SELECT distinct `userid` from m_relojcontrol');

/*
if( !$_SESSION[ PREFIX . 'login_admin'] ){
    if( !$_SESSION[ PREFIX . 'is_jefe'] ){
        redirect(BASE_URL);
    }
}
*/


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

$sql_hijos = "SELECT * FROM `m_cargo` WHERE `cargoPadreId` = $cargo_id ORDER BY `activo` DESC";
$childs = $db->rawQuery( $sql );
$str_IN = "(";
foreach($childs as $ch){
    $str_IN .= $ch['id'].",";
}
$str_IN = trim($str_IN,",");
$str_IN .= ")";


// Todos los trabajadores que pertenecen a cualquiera de los cargos hijos

/* OLD
$db->where('empresa_id', $_SESSION[PREFIX.'login_eid']);
$db->where('cargo_id',$cargos_hijo[0]['id']);
array_shift($cargos_hijo);
foreach( $childs as $hijo ){
    $db->orWhere('cargo_id',$hijo['id']);
}
$trabajadores_x_cargo = $db->get('m_trabajador',null,array( 'id','nombres','apellidoPaterno','apellidoMaterno' ));
show_array( $db->getLastQuery() );
*/

$sql_trabajadores_x_cargo = "SELECT * from m_trabajador T WHERE T.cargo_id IN " . $str_IN . "  AND T.empresa_id = " . $_SESSION[PREFIX.'login_eid'];
$trabajadores_x_cargo = $db->rawQuery( $sql_trabajadores_x_cargo );


if( $_POST ){

    extract($_POST);

    if( @$_POST['action'] == 'edit' ){

        $fechaInicio=date("Y-m-d", $fI);
        $fechaInicio .= " 00:00:00";
        $fechaFin=date("Y-m-d", $fF);
        $fechaFin .= " 23:59:59";


        $db->where ("id", $parametros[1]);
        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $trabajador = $db->getOne("m_trabajador",'horario_id');
        $horarioTrabajador = $trabajador['horario_id'];

        $db->where('id',$horarioTrabajador);
        $m_horarios = $db->getOne('m_horario');

        $m_horario_entrada = $m_horarios['entradaTrabajo'];
        $m_horario_salida = $m_horarios['salidaTrabajo'];

        // Eliminar todos los registros de justificaciones del trabajador para reingresar todo
        $db->where('trabajador_id',$idTrabajador);
        $db->where('fecha', Array ($fechaInicio, $fechaFin), 'BETWEEN');
        $db->delete('t_atrasohoraextra');
        //end

        // Guardar las justificaciones
        if( @$_POST['justificativo'] ){
            foreach( $_POST['justificativo'] as $jkey => $justif ){
                if( $justif['justificado'] ){

                    if( $justif['tipo'] == 'H' ){
                        if( $justif['hora_extra_efectiva'] == 0 ){
                            // sacar la diferencia entre lo marcado y el horario en BD
                            if($justif['io'] == 'I')
                                $m_horarioen_BD = $m_horario_entrada;
                            else
                                $m_horarioen_BD = $m_horario_salida;



                            $datetime1 = date_create(date('Y-m-d ') . $m_horarioen_BD);
                            $datetime2 = date_create(date('Y-m-d ') . $justif['hora_marcada']);
                            $interval = date_diff($datetime1, $datetime2);
                            $sub_total_min = ( $interval->h * 60 );
                            $total_min = ( $interval->i + $sub_total_min );
                            $horas_extras_efectivas = ( $total_min / 60 );

                        } else {
                            $horas_extras_efectivas = $justif['hora_extra_efectiva'];
                        }
                    } else {
                        $horas_extras_efectivas = $justif['hora_extra_efectiva'];
                    }

                    //$horas_extras_efectivas = round($horas_extras_efectivas, 2);

                    $data_j = array(
                        'logid' => $jkey,
                        'tipo' => $justif['tipo'],
                        'io' => $justif['io'],
                        'fecha' => $justif['fecha'],
                        'horas' => $horas_extras_efectivas,
                        'comentario' => $justif['comentario'],
                        'justificativo_id' => $justif['justificativo'],
                        'trabajador_id' => $idTrabajador
                    );
                    $db->insert('t_atrasohoraextra', $data_j);
                }
            }
        }


        if( @$_POST['justificativo_no_marco_entrada'] ){
            foreach( $_POST['justificativo_no_marco_entrada'] as $jkey => $justif_in ){
                if( $justif_in['justificado'] ){
                    $data_j = array(
                        'tipo' => $justif_in['tipo'],
                        'io' => $justif_in['io'],
                        'fecha' => $justif_in['fecha'],
                        'horas' => $justif_in['hora_extra_efectiva'],
                        'comentario' => $justif_in['comentario'],
                        'justificativo_id' => $justif_in['justificativo'],
                        'trabajador_id' => $idTrabajador
                    );
                    $db->insert('t_atrasohoraextra', $data_j);
                }
            }
        }


        if( @$_POST['justificativo_no_marco_salida'] ){
            foreach( $_POST['justificativo_no_marco_salida'] as $jkey => $justif_out ){
                if( $justif_out['justificado'] ){
                    $data_j = array(
                        'tipo' => $justif_out['tipo'],
                        'io' => $justif_out['io'],
                        'fecha' => $justif_out['fecha'],
                        'horas' => $justif_out['hora_extra_efectiva'],
                        'comentario' => $justif_out['comentario'],
                        'justificativo_id' => $justif_out['justificativo'],
                        'trabajador_id' => $idTrabajador
                    );
                    $db->insert('t_atrasohoraextra', $data_j);
                }
            }
        }
        // end

        logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'relojcontrol',0,$db->getLastQuery() );

        //$response = encrypt('status=success&mensaje=Datos guardados correctamente &id='.@$idTrabajador);
        redirect(BASE_URL . '/' . $entity . '/editar/'.$idTrabajador. '/' . $parametros[2]. '/' . $parametros[3]. '/OK' );
        exit();
    }

}

if( $parametros ){

    /** Consultar datos de trabajador **/
    if( ( $parametros[0] == 'me' ) && ( $parametros[1] != $_SESSION[ PREFIX . 'login_uid'] ) ){
        redirect(BASE_URL . '/' . $entity . '/me' );
    }
    if( isset($parametros[1]) ){

        $db->where ("id", $parametros[1]);
        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $trabajador = $db->getOne("m_trabajador");
        if(!$trabajador){
            redirect(BASE_URL . '/' . $entity . '/listar/' );
        }

        $db->where("trabajador_id", $parametros[1]);
        $db->orderBy('ano','DESC');
        $db->orderBy('mes','DESC');
        $minutos_trabajador = $db->getOne("t_relojcontrol");

        $periodo = getPeriodoCorte();

        /* OLD SQL
        $desde = $periodo['desde'].' 00:00:00';
        $hasta = $periodo['hasta'].' 23:59:59';
        $db->where("trabajador_id", $parametros[1]);
        $db->where('fecha_inicio',$desde,'>');
        $db->where('fecha_fin',$hasta,'<');
        $db->orderBy('fecha_inicio','DESC');
        $ausencias_trabajador = $db->get("t_ausencia");
        */

        /** NEW SQL **/
        $sql = "
        SELECT * FROM t_ausencia
        WHERE trabajador_id = $parametros[1]
        AND fecha_inicio >= '".$periodo['desde']."'
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        ";
        $ausencias_trabajador = $db->rawQuery( $sql );


        // NUeva SQL para licencias (desde el mes en corte hacia aelante TODAS)
        $sql_licencias = "
        SELECT * FROM t_ausencia
        WHERE trabajador_id = $parametros[1]
        AND fecha_inicio >= '".$periodo['desde']."'
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
        ";
        $licencias_trabajador = $db->rawQuery( $sql_licencias,null,false );


        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $ausencias = $db->get('m_ausencia');

        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->where ("tipo", 'A');
        $justificativos_atrasos = $db->get('m_justificativo');

        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->where ("tipo", 'H');
        $justificativos_horaextra = $db->get('m_justificativo');


        $limites_periodo = getPeriodoCorte();

        if( $parametros[2] && $parametros[3] ){
            $limites_periodo = array(
                'desde' => $parametros[2],
                'hasta' => $parametros[3]
            );
        }

        $fecha_desde = $limites_periodo['desde'];
        $fecha_limite = $limites_periodo['hasta'];

        $db->where('id',$parametros[1]);
        $relojcontrol_id =  $db->getOne('m_trabajador','relojcontrol_id');
        $relojcontrol_id = $relojcontrol_id['relojcontrol_id'];

        $db->where("id",$_SESSION[PREFIX.'login_eid']);
        $umbral = $db->getValue('m_empresa','umbralRelojControl');

        $sql = "
        SELECT  * FROM m_relojcontrol
        WHERE  userid = '$relojcontrol_id'
        AND checktime >= '$fecha_desde 00:00:00'
        AND checktime <= '$fecha_limite 23:59:59'
        AND time( checktime ) < '$umbral'
        ORDER BY checktime ASC
        ";
        $entradas = $db->rawQuery($sql);

        $sql = "
        SELECT  * FROM m_relojcontrol
        WHERE  userid = '$relojcontrol_id'
        AND checktime >= '$fecha_desde 00:00:00'
        AND checktime <= '$fecha_limite 23:59:59'
        AND time( checktime ) > '$umbral'
        ORDER BY checktime ASC
        ";
        $salidas = $db->rawQuery($sql);

        if( $_SESSION[PREFIX . 'is_trabajador'] ){
            $fechaInicio=strtotime(date('Y-m-') . '01' . ' 00:00:00');
            $fechaFin=strtotime(date('Y-m-d') . ' 23:59:59');
        } else {
            $fechaInicio=strtotime($fecha_desde.' 00:00:00');
            $fechaFin=strtotime($fecha_limite.' 23:59:59');
        }



        $db->where('id',$trabajador['horario_id']);
        $m_horarios = $db->getOne('m_horario');
        $m_horario_entrada = $m_horarios['entradaTrabajo'];
        $m_horario_salida = $m_horarios['salidaTrabajo'];
        $array_dias_temp = array($m_horarios['lun'],$m_horarios['mar'],$m_horarios['mie'],$m_horarios['jue'],$m_horarios['vie'],$m_horarios['sab'],$m_horarios['dom']);
        $dias_laborales_horario = array();

        foreach( $array_dias_temp as $k => $i ){
            if( $i == 1 ){
                $dias_laborales_horario[] = $k;
            }
        }
        /* fin */

        //Justificativos
        $db->where("trabajador_id", $parametros[1]);
        $t_atrasohoraextra = $db->get('t_atrasohoraextra');

        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->orderBy("nombre","ASC");
        $justificativos = $db->get('m_justificativo');

        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->where ("tipo", 'H');
        $justificativos_horaextra = $db->get('m_justificativo');


    } else {
        if( $action != "listar_trabajadores" ){
            if( $_SESSION[PREFIX.'is_trabajador'] == true ){
                redirect(BASE_URL.'/relojcontrol/me/' . $_SESSION[PREFIX.'login_uid']);
            } else {
                redirect(BASE_URL.'/relojcontrol');
            }
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

