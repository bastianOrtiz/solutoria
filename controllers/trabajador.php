<?php
$mes = getMesMostrarCorte();
$year = getAnoMostrarCorte();

$paises = $db->get("m_pais");
$regiones = $db->get("m_region");
$ids_relojcontrol = $db->rawQuery('SELECT distinct `userid` from m_relojcontrol');


/** MAX ID RELOJ CONTROL **/
//(Si en tabla 'm_cuenta' en el campo 'comparteRelojControl' = 1 o true)
if( getComparte('RelojControl') ){
    $sql = "SELECT max(t.relojcontrol_id) mayor FROM m_trabajador t, m_empresa e, m_cuenta c WHERE c.id=e.cuenta_id and e.id=t.empresa_id and c.id = " . $_SESSION[ PREFIX . 'login_cid' ];     
} else{
    $sql = "SELECT max(t.relojcontrol_id) mayor FROM m_trabajador t, m_empresa e WHERE e.id=t.empresa_id and e.id = " . $_SESSION[ PREFIX . 'login_eid' ];
}
$resul_relojcontrol_id = $db->rawQuery( $sql );
$max_id_relojcontrol =  $resul_relojcontrol_id[0]['mayor'];
$max_id_relojcontrol = ( $max_id_relojcontrol + 1 );


if( getComparte('Cargo') ){
    $cargos = $db->rawQuery('SELECT * FROM m_cargo WHERE empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ORDER BY nombre ASC');
} else {
    $cargos = $db->rawQuery("SELECT * FROM m_cargo WHERE empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
}

if( getComparte('CentroCosto') ){
    $ccostos = $db->rawQuery('SELECT * FROM m_centrocosto WHERE empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ORDER BY nombre ASC ');
} else {
    $ccostos = $db->rawQuery("SELECT * FROM m_centrocosto WHERE empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
}

if( getComparte('Departamento') ){
    $deptos = $db->rawQuery('SELECT * FROM m_departamento WHERE activo = 1 AND empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');
} else {
    $deptos = $db->rawQuery("SELECT * FROM m_departamento WHERE activo = 1 AND empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
}



function fnNombreCargo($id_cargo){
    global $cargos;    
    foreach( $cargos as $e ){
        if( $e['id'] == $id_cargo ){
            return $e['nombre'];
            break;
        }
    }
}
function fnNombreDepartamento($id_departamento){
    global $deptos;    
    foreach( $deptos as $e ){
        if( $e['id'] == $id_departamento ){
            return $e['nombre'];
            break;
        }
    }
}


$db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
$db->where ("deleted_at", NULL, 'IS');
$db->orderBy('apellidoPaterno','ASC');
$registros = $db->get("m_trabajador");
$trabajadors = $registros;


$db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
$sucursales = $db->get("m_sucursal");


if( getComparte('Horario') ){
    $sql_horarios = 'SELECT * FROM m_cuenta c, m_empresa e, m_horario h WHERE c.id=e.cuenta_id and e.id=h.empresa_id and c.id = ' . $_SESSION[ PREFIX . 'login_cid' ] ;
    $horario = $db->rawQuery( $sql_horarios );
} else {
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $horario = $db->get("m_horario");    
} 

$tipopago = $db->get("m_tipopago");

if( $_POST ){

    extract($_POST);
        
    if( @$_POST['action'] == 'edit' ){

        $fechaInicio=date("Y-m-d", $fI);
        $fechaInicio .= " 00:00:00";
        $fechaFin=date("Y-m-d", $fF);
        $fechaFin .= " 23:59:59";
        
        
        $db->where('id',$horarioTrabajador);
        $m_horarios = $db->getOne('m_horario');
        $m_horario_entrada = $m_horarios['entradaTrabajo'];
        $m_horario_salida = $m_horarios['salidaTrabajo'];    


        // Guardar las justificaciones        
        if( @$_POST['justificativo'] ){
                        
            // Eliminar todos los registros de justificaciones del trabajador para reingresar todo
            $db->where('trabajador_id',$idTrabajador);
            $db->where('fecha', Array ($fechaInicio, $fechaFin), 'BETWEEN');
            $db->delete('t_atrasohoraextra');
            //end
            foreach( $_POST['justificativo'] as $jkey => $justif ){                                
                if( $justif['justificado'] ){
                    if( $justif['tipo'] == 'H' ){                        
                        if(( $justif['hora_extra_efectiva'] == 0 ) && ( $justif['no_marco'] != 1 ) ){
                            // sacar la diferencia entre lo marcado y el horario en BD
                            
                            if($justif['io'] == 'I'){
                                if(@$justif['no_laboral']){
                                    $m_horarioen_BD = $justif['no_laboral'];
                                } else {
                                    $m_horarioen_BD = $m_horario_entrada;
                                }
                            } else{
                                $m_horarioen_BD = $m_horario_salida;
                            }
                            
                            
                            $datetime1 = date_create(date('Y-m-d ') . $m_horarioen_BD);
                            $datetime2 = date_create(date('Y-m-d ') . $justif['hora_marcada']);
                            
                            $interval = date_diff($datetime1, $datetime2);
                            //show_array($interval);
                            $sub_total_min = ( $interval->h * 60 );
                            $total_min = ( $interval->i + $sub_total_min );                            
                            $horas_extras_efectivas = ( $total_min / 60 );
                                                                
                        } else {
                            $horas_extras_efectivas = $justif['hora_extra_efectiva'];
                        }        
                    } else {
                        $horas_extras_efectivas = $justif['hora_extra_efectiva'];
                    }                
                    $horas_extras_efectivas = round($horas_extras_efectivas, 2);
                    


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
                        'justificativo_id' => $justif_in['justificativo'],
                        'comentario' => $justif_in['comentario'],
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
                        'justificativo_id' => $justif_out['justificativo'],
                        'comentario' => $justif_out['comentario'],
                        'trabajador_id' => $idTrabajador
                    );
                    $db->insert('t_atrasohoraextra', $data_j);           
                }
            }
        }  
        // end   

        
        $saludTrabajador = $optionsRadios[0];
        $gratificacionTrabajador = $gratificacionTrabajador[0];
        $sexoTrabajador = $sexoTrabajador[0];
        $extranjeroTrabajador = $extranjeroTrabajador[0];
        $accionistaTrabajador = $accionistaTrabajador[0];
        $agricolaTrabajador = $agricolaTrabajador[0];
        $salarioEstableTrabajador = $salarioEstableTrabajador[0];
        $marcaTarjetaTrabajador = $marcaTarjetaTrabajador[0];
        $revisaRelojTrabajador = $revisaRelojTrabajador[0];
        $fullJerarquiaTrabajador = $fullJerarquiaTrabajador[0];

         if($forzarPlanCompleto){
            $forzarPlanCompleto = 1;
         }

        
        $db->where('id',$idTrabajador);
        $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
        $foto = $db->getOne('m_trabajador','foto');
        
        
        $customFields = '{"fields": [';
        foreach( $camposPersonalizadosTipoPago as $key => $value ){
            $customFields .= ' {"key": "'.$key.'","value": "'.$value.'"},';
        }
        $customFields = trim($customFields,',');
        $customFields .= ']}';
        
        $data = array(
            'empresa_id' => $_SESSION[ PREFIX . 'login_eid'],
            'nombres' => $nombreTrabajador,
            'apellidoPaterno' => $apellidoPaternoTrabajador,
            'apellidoMaterno' => $apellidoMaternoTrabajador,
            'rut' => $rutTrabajador,
            'sexo' => $sexoTrabajador, //Bool
            'fechaNacimiento' => $fechaNacimientoTrabajador,
            'extranjero' => $extranjeroTrabajador, //Bool
            'pasaporte' => $pasaporteTrabajador,
            'idNacionalidad' => $nacionalidadTrabajador,
            'email' => $emailTrabajador,
            'telefono' => $telefonoTrabajador,
            'celular' => $celularTrabajador,
            'emergencia' => $emergenciaTrabajador,
            'direccion' => $direccionTrabajador,
            'accionista' => $accionistaTrabajador, //Bool
            'agricola' => $agricolaTrabajador, //Bool
            'salarioEstable' => $salarioEstableTrabajador, //Bool        
            'marcaTarjeta' => $marcaTarjetaTrabajador, //Bool
            'gratificacion' => $gratificacionTrabajador, //Bool
            
            'revisaReloj' => $revisaRelojTrabajador,
            'fullJerarquia' => $fullJerarquiaTrabajador,
            
            'diasVacaciones' => $diasVacacionesTrabajador,
            'diasVacacionesProgresivas' => $vacacionesProgresivasTrabajador,
            'sueldoBase' => $sueldoBaseTrabajador,
            'factorHoraExtra' => $factorHoraExtraTrabajador,
            'factorHoraExtraEspecial' => $factorHoraExtraEspecial,          
            'fechaContratoInicio' => $inicioContratoTrabajador,
            'fechaContratoFin' => $finContratoTrabajador,
            
            'cargo_id' => $cargoTrabajador,
            'centrocosto_id' => $centroCostoTrabajador,
            'departamento_id' => $departamentoTrabajador,
            'comuna_id' => $comunaTrabajador,
            'horario_id' => $horarioTrabajador,
            'tipotrabajador_id' => $tipoTrabajadorPrev,
            'sucursal_id' => $sucursalTrabajador,
            'tipocontrato_id' => $tipoContratoTrabajador,
            
            'tipopago_id' => $tipoPagoTrabajador,
            'tipopagodato' => $customFields,
            'relojcontrol_id' => $relojControlIdTrabajador,
            'forzar_plan_completo' => $forzarPlanCompleto,
            'estadoCivil' => $estadoCivil,
            'centrocosto_externo' => $ccostoExterno,
            'horas_reduccion_laboral_semanal' => $horas_reduccion_laboral_semanal,
            'horario_reduccion' => $horario_reduccion,
            'sueldo_base_reducido' => $sueldo_base_reducido
        );

        
        if( $_FILES['fotoTrabajador']['name'] != "" ){
            $return = upload_image('fotoTrabajador', ROOT . '/private/uploads/images/');
            $data['foto'] = $return['filename'];    
        } else {
            $data['foto'] = $foto['foto'];
        }

        if( $_POST['comisiones_pendientes'] ){
            $data['comisiones_pendientes'] = 1;
        } else {
            $data['comisiones_pendientes'] = 0;
        }

        if( $_POST['teletrabajo'] ){
            $data['teletrabajo'] = 1;
        } else {
            $data['teletrabajo'] = 0;
        }

        if( $_POST['reduccion_laboral'] ){
            $data['reduccion_laboral'] = 1;
        } else {
            $data['reduccion_laboral'] = 0;
        }

        if( $_POST['crea_evento'] ){
            $data['creaEvento'] = 1;
        } else {
            $data['creaEvento'] = 0;
        }
        
        if( $saludTrabajador == 'fonasa' ){
            $data_prev = array(
                'trabajador_id' => $idTrabajador,
                'fonosa' => 1,
                'tramo_id' => $fonasaTramoTrabajadorFonasa,
                'isapre_id' => 0,
                'tipomoneda_id' => 0,
                'montoPlan' => 0,        
                'cuenta2_id' => $afpCuenta2TrabajadorPrev,
                'tipomoneda2_id' => $tipoMonedaCuenta2Trabajador,
                'montoCta2' => $montoCuenta2Trabajador,
                'cargasMaternales' => $cargasMaternalesTrabajadorPrev,
                'cargasSimples' => $cargasSimplesTrabajadorPrev,
                'cargasInvalidez' => $cargasInvalidezTrabajadorPrev,
                'tramoCargas' => $tramoCargasTrabajadorPrev,
                'afp_id' => $afpTrabajadorPrev
            );
        } else {
            $data_prev = array(
                'trabajador_id' => $idTrabajador,
                'fonosa' => 0,
                'tramo_id' => 0,
                'isapre_id' => $isapreTrabajador,
                'tipomoneda_id' => $tipoMonedaIsapreTrabajador,
                'montoPlan' => $planPesoTrabajadorSalud,
                'cuenta2_id' => $afpCuenta2TrabajadorPrev,
                'tipomoneda2_id' => $tipoMonedaCuenta2Trabajador,
                'montoCta2' => $montoCuenta2Trabajador,
                'cargasMaternales' => $cargasMaternalesTrabajadorPrev,
                'cargasSimples' => $cargasSimplesTrabajadorPrev,
                'cargasInvalidez' => $cargasInvalidezTrabajadorPrev,
                'tramoCargas' => $tramoCargasTrabajadorPrev,
                'afp_id' => $afpTrabajadorPrev
            );
        }

        
        
        if( $_FILES['docTrabajadorDocumento']['name'] != "" ){
            $return = upload_doc('docTrabajadorDocumento', ROOT . '/private/uploads/docs/');
            if( $return['status'] ){
                $insertData = array(
                    'trabajador_id' => $idTrabajador,
                    'filename' => $return['filename'],
                    'nombre' => $docTrabajadorTitulo 
                );
                $db->insert('t_documentotrabajador', $insertData);
            }       
        }
        
        $edit_trabajador = editarTrabajador($idTrabajador, $data);

        logit( $_SESSION[PREFIX.'login_name'],'editar','trabajador',$idTrabajador,$db->getLastQuery() );
        
        
        $edit_previsional = editarPrevisionalTrabajador($idTrabajador, $data_prev);
        
        if( $edit_trabajador && $edit_previsional ){
            $response = encrypt('status=success&mensaje=Datos guardados correctamente &id='.@$idTrabajador);    
        } else {
            $response = encrypt('status=warning&mensaje=Error actualizando datos: ' . $db->getLastError() . '&id='.@$idTrabajador);
        }
        
        
        
        //redirect(BASE_URL . '/' . $entity . '/editar/'.$idTrabajador.'/response/' . $response );
        redirect(BASE_URL . '/' . $entity . '/editar/'.$idTrabajador. '/' . $parametros[2]. '/' . $parametros[3]. '/OK' );
        exit();
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarTrabajador( $trabajdor_id );
        logit( $_SESSION[PREFIX.'login_name'],'eliminar','trabajador',$trabajdor_id,$db->getLastQuery() );
        
        if( $delete ){
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$trabajador_id);
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar el trabajador: '. $db->getLastError() .'&id='.$trabajador_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
        
    
    if( @$_POST['action'] == 'new' ){
        
        $sexoTrabajador = $sexoTrabajador[0];
        $extranjeroTrabajador = $extranjeroTrabajador[0];
        $accionistaTrabajador = $accionistaTrabajador[0];
        $agricolaTrabajador = $agricolaTrabajador[0];
        $salarioEstableTrabajador = $salarioEstableTrabajador[0];
        $marcaTarjetaTrabajador = $marcaTarjetaTrabajador[0];
        $gratificacionTrabajador = $gratificacionTrabajador[0];
        $revisaRelojTrabajador = $revisaRelojTrabajador[0];
        $fullJerarquiaTrabajador = $fullJerarquiaTrabajador[0];
        
        if($camposPersonalizadosTipoPago){
            $customFields = '{"fields": [';
            foreach( $camposPersonalizadosTipoPago as $key => $value ){
                $customFields .= ' {"key": "'.$key.'","value": "'.$value.'"},';
            }
            $customFields = trim($customFields,',');
            $customFields .= ']}';
        } else {
            $customFields = '';
        }
        
        if( $_POST['teletrabajo'] ){
            $data['teletrabajo'] = 1;
        } else {
            $data['teletrabajo'] = 0;
        }
        
        if( $_POST['reduccion_laboral'] ){
            $data['reduccion_laboral'] = 1;
        } else {
            $data['reduccion_laboral'] = 0;
        }

        if( $_POST['crea_evento'] ){
            $data['creaEvento'] = 1;
        } else {
            $data['creaEvento'] = 0;
        }

        $data = array(
            'empresa_id' => $_SESSION[ PREFIX . 'login_eid'],
            'nombres' => $nombreTrabajador,
            'apellidoPaterno' => $apellidoPaternoTrabajador,
            'apellidoMaterno' => $apellidoMaternoTrabajador,
            'rut' => $rutTrabajador,
            'sexo' => $sexoTrabajador, //Bool
            'fechaNacimiento' => $fechaNacimientoTrabajador,
            'extranjero' => $extranjeroTrabajador, //Bool
            'pasaporte' => $pasaporteTrabajador,
            'idNacionalidad' => $nacionalidadTrabajador,
            'email' => $emailTrabajador,
            'telefono' => $telefonoTrabajador,
            'celular' => $celularTrabajador,
            'emergencia' => $emergenciaTrabajador,
            'direccion' => $direccionTrabajador,
            'accionista' => $accionistaTrabajador, //Bool
            'agricola' => $agricolaTrabajador, //Bool
            'salarioEstable' => $salarioEstableTrabajador, //Bool        
            'marcaTarjeta' => $marcaTarjetaTrabajador, //Bool
            'gratificacion' => $gratificacionTrabajador,
            
            'revisaReloj' => $revisaRelojTrabajador,
            'fullJerarquia' => $fullJerarquiaTrabajador,
            
            'diasVacaciones' => $diasVacacionesTrabajador,
            'diasVacacionesProgresivas' => $vacacionesProgresivasTrabajador,
            'sueldoBase' => $sueldoBaseTrabajador,
            'factorHoraExtra' => $factorHoraExtraTrabajador,
            'factorHoraExtraEspecial' => $factorHoraExtraEspecial,
            'fechaContratoInicio' => $inicioContratoTrabajador,
            'fechaContratoFin' => $finContratoTrabajador,
            
            'cargo_id' => $cargoTrabajador,
            'centrocosto_id' => $centroCostoTrabajador,
            'departamento_id' => $departamentoTrabajador,
            'comuna_id' => $comunaTrabajador,
            'horario_id' => $horarioTrabajador,
            'sucursal_id' => $sucursalTrabajador,
            'tipocontrato_id' => $tipoContratoTrabajador,
            
            'tipopago_id' => $tipoPagoTrabajador,
            'tipopagodato' => $customFields,
            'relojcontrol_id' => $relojControlIdTrabajador,
            'estadoCivil' => $estadoCivil,
            'centrocosto_externo' => $ccostoExterno
        );

        
        
        if( !existeIdRelojcontrol( $relojControlIdTrabajador ) ){
            if( !existeTrabajador($rutTrabajador) ){                
                if( $_FILES['fotoTrabajador']['name'] != "" ){
                    $return = upload_image('fotoTrabajador', ROOT . '/private/uploads/images/');
                    $data['foto'] = $return['filename'];    
                } else {
                    $return['status'] = true;
                    $data['foto'] = 'H8ABH5NZ9qhz6QAAAAASUVORK5CYII=.jpeg';
                }
                
                $create_id = crearTrabajador($data);  
                logit( $_SESSION[PREFIX.'login_name'],'crear','trabajador',$create_id,$db->getLastQuery() );                              
                
                if( $return['status'] != 1 ){
                    $response = encrypt('status=success&mensaje=Datos guardados correctamente (Con errores en la subida de la foto)&id='.@$create_id);
                    redirect(BASE_URL . '/' . $entity . '/editar/'.$create_id.'/response/' . $response );
                    exit();          
                } else {
                    $response = encrypt('status=success&mensaje=Datos guardados correctamente&id='.@$create_id);
                    redirect(BASE_URL . '/' . $entity . '/editar/'.$create_id.'/response/' . $response );
                    exit();
                }
            } else {
                goBack('Ya existe un trabajdor activo en la empresa, con el rut ingresado');
            }
        } else {            
            goBack('El ID RelojControl ya existe en la BD');
        }
    }
       
}

if( $parametros ){

    if( $parametros[0] == 'lista_firmas' ){

        $m_empresa = ( $parametros[1] ) ? $parametros[1] : $_SESSION[PREFIX.'login_eid'];


        $db->where ("empresa_id", $m_empresa);
        $db->where ("deleted_at", NULL, 'IS');
        $db->where('tipocontrato_id',array(3,4),'NOT IN');
        $db->orderBy('apellidoPaterno','ASC');
        $registros = $db->get("m_trabajador");
        $trabajadors = $registros;

        $cargos = $db->orderBy('nombre', 'ASC')->get('m_cargo');
        $departamentos = $db->orderBy('nombre', 'ASC')->get('m_departamento');
        $m_empresas = $db->get('m_empresa');
    }


    if( $parametros[0] == 'generar_firmas' ){
        
        Header("Content-type: image/png");


        $im = imagecreatefrompng(ROOT . '/public/img/firma_base.png');
        $font_color = imagecolorallocate($im, 65, 100, 160);
        $font_regular = ROOT . '/public/font/Arial.ttf';
        $font_bold = ROOT . '/public/font/ArialBold.ttf';

        $first_name = explode(" ", utf8_decode($_POST['nombres']));
        $first_name = strtolower($first_name[0]);
        $apellidoPaterno = strtolower( utf8_decode($_POST['apellidoPaterno']) );
        $apellidoMaterno = strtolower( utf8_decode($_POST['apellidoMaterno']) );


        //$filename = $trabajador['apellidoPaterno'] . '-' . $trabajador['apellidoPaterno'] . '-' . $trabajador['nombres'];
        //$filename = 'trabajador_' .;

        $nombre = ucwords( $first_name . ' ' . $apellidoPaterno . ' ' . $apellidoMaterno );
        $cargo = ucwords(strtolower( utf8_decode($_POST['cargo_id']) ));
        $email = 'Email: ' . strtolower($_POST['email']);
        $telefono = ( $_POST['telefono'] ) ? 'Teléfono: ' . $_POST['telefono'] : '';
        $celular = ($_POST['celular']) ? 'Celular: ' . $_POST['celular'] : '';

        //show_array('generando firma de "' . $nombre .'" ...................................[OK]',0);

        // Escribir nombre
        $dimensions = imagettfbbox(11, 0, $font_bold, $nombre);
        $textWidth = abs($dimensions[4] - $dimensions[0]);
        $x = (imagesx($im) - $textWidth - 240);
        imagettftext($im, 11, 0, $x, 25, $font_color, $font_bold, $nombre);

        // Escribir Cargo
        $dimensions = imagettfbbox(10, 0, $font_bold, $cargo);
        $textWidth = abs($dimensions[4] - $dimensions[0]);
        $x = (imagesx($im) - $textWidth - 240);
        imagettftext($im, 10, 0, $x, 43, $font_color, $font_bold, $cargo);

        // Escribir Email
        $dimensions = imagettfbbox(9, 0, $font_bold, $email);
        $textWidth = abs($dimensions[4] - $dimensions[0]);
        $x = (imagesx($im) - $textWidth - 17);
        imagettftext($im, 9, 0, $x, 130, $font_color, $font_bold, $email);


        if( $celular ):
             // Escribir celular
            $dimensions = imagettfbbox(9, 0, $font_bold, $celular);
            $textWidth = abs($dimensions[4] - $dimensions[0]);
            $x = (imagesx($im) - $textWidth - 16);
            imagettftext($im, 9, 0, $x, 117, $font_color, $font_bold, $celular);
        endif;
       
        if( $telefono ):
             // Escribir telefono
            $dimensions = imagettfbbox(9, 0, $font_bold, $telefono);
            $textWidth = abs($dimensions[4] - $dimensions[0]);
            $x = (imagesx($im) - $textWidth - 16);
            imagettftext($im, 9, 0, $x, 102, $font_color, $font_bold, $telefono);
        endif;


        // Using imagepng() results in clearer text compared with imagejpeg()
        //$save = ROOT . '/public/img/firmas/' . $filename . '.png';
        imagepng($im);
        imagedestroy($im);


        exit();

    }


    /** Consultar datos de trabajador **/
    if( isset($parametros[1]) ){
        
        $trabajador_id = $parametros[1];
                
        $db->where ("id", $parametros[1]);
        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $trabajador = $db->getOne("m_trabajador");        
        if(!$trabajador){
            redirect(BASE_URL . '/' . $entity . '/listar/' );
            exit();
        }
        
        
        $mes = getMesMostrarCorte();        
        $ano = getAnoMostrarCorte();
        $db->where("trabajador_id", $parametros[1]);
        $db->where("mes", $mes);
        $db->where("ano", $ano);
        $db->orderBy('ano','DESC');
        $db->orderBy('mes','DESC');        
        $minutos_trabajador = $db->getOne("t_relojcontrol");                
        
        
        /*
        $db->where("trabajador_id", $parametros[1]);
        $db->where("activo", 1);
        $db->orderBy('mesInicio','DESC');
        $debes_trabajador = $db->get("t_descuento");
        */
        
        $query_desc = "
        SELECT * FROM t_descuento 
        WHERE trabajador_id=$parametros[1] 
        AND activo = 1 
        OR
            (
            activo = 0 and fechaFinalizacion = '". leadZero($mes) ."-$ano' 
            AND trabajador_id = $parametros[1]
            )  
        ORDER BY mesInicio DESC ";
        $debes_trabajador = $db->rawQuery( $query_desc );     
        
        
        /*
        $db->where("trabajador_id", $parametros[1]);
        $db->where("activo", 1);        
        $db->orderBy('mesInicio','DESC');
        $haberes_trabajador = $db->get("t_haber");
        */
        $max_days = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $query_habers = "SELECT * FROM `t_haber` 
            WHERE trabajador_id=$trabajador_id 
            AND fechaInicio <= '$ano-$mes-$max_days'
            AND activo =1 or
            (activo = 0 and fechaFinalizacion = '".leadZero($mes)."-$year' AND trabajador_id=$trabajador_id)  ORDER BY mesInicio DESC ";
        $haberes_trabajador = $db->rawQuery( $query_habers,'',false );

        $periodo = getPeriodoCorte();        
        $desde = $periodo['desde'].' 00:00:00';
        $hasta = $periodo['hasta'].' 23:59:59';
                   
        
        /* SQL para obtener ausencias que caen dentro del periodo de corte
        Se solicito poder ver todas las ausencias desde el inicio del corte en adelante.
        Por eso se reemplaza con la siguiente consulta */
        $sql_ausencias = "
        SELECT id, fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id  
        FROM t_ausencia 
        WHERE ( 
                fecha_inicio <= '$desde' 
                AND fecha_fin <= '$hasta' 
                AND fecha_fin >= '$desde' 
                AND trabajador_id = $trabajador_id 
                AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )            
                )
        OR ( 
            fecha_inicio >= '$desde' 
            AND fecha_fin >= '$hasta' 
            AND fecha_inicio <= '$hasta' 
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 ) 
            )
        OR ( 
            fecha_inicio <= '$desde' 
            AND fecha_fin >= '$hasta' 
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 ) 
            )
        OR ( 
            fecha_inicio >= '$desde' 
            AND fecha_fin <= '$hasta' 
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 ) 
            )
            ORDER BY fecha_inicio
        ";
        //$ausencias_trabajador = $db->rawQuery( $sql_ausencias,null,false ); // Obsoleta por ahora

        /* Nueva SQL, ausencias desde el inicio del corte hacia adelante sin limite */
        $sql = "
        SELECT id, fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id 
        FROM t_ausencia
        WHERE trabajador_id = $trabajador_id 
        AND fecha_inicio >= '".$periodo['desde']."' 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )         
        ";        
        $ausencias_trabajador = $db->rawQuery( $sql, null, false );


        
        $total_days_month = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $desde_licencia = $ano . '-' . leadZero($mes) . '-01';
        $hasta_licencia = $ano . '-' . leadZero($mes) . '-' . $total_days_month;
        $sql_licencias = "
        SELECT id, fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id  
        FROM t_ausencia 
        WHERE ( 
                fecha_inicio <= '$desde_licencia' 
                AND fecha_fin <= '$hasta_licencia' 
                AND fecha_fin >= '$desde_licencia' 
                AND trabajador_id = $trabajador_id 
                AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )            
                )
        OR ( 
            fecha_inicio >= '$desde_licencia' 
            AND fecha_fin >= '$hasta_licencia' 
            AND fecha_inicio <= '$hasta_licencia'
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 ) 
            )
        OR ( 
            fecha_inicio <= '$desde_licencia' 
            AND fecha_fin >= '$hasta_licencia' 
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 ) 
            )
        OR ( 
            fecha_inicio >= '$desde_licencia' 
            AND fecha_fin <= '$hasta_licencia' 
            AND trabajador_id = $trabajador_id 
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 ) 
            )
            ORDER BY fecha_inicio
        ";      
        
        // NUeva SQL para licencias (desde el mes en corte hacia aelante TODAS)
        $sql_licencias_ = "
        SELECT * FROM t_ausencia
        WHERE trabajador_id = $trabajador_id 
        AND fecha_inicio >= '".$periodo['desde']."' 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )  
        ";
        $licencias_trabajador = $db->rawQuery( $sql_licencias,null,false );


                       
        $ausencias = getRegistrosCompartidos('Ausencia','m_ausencia');
        
        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->orderBy("nombre","ASC");
        $justificativos = $db->get('m_justificativo');
        
        $db->where ("cuenta_id", $_SESSION[ PREFIX . 'login_cid']);
        $db->where ("tipo", 'H');
        $justificativos_horaextra = $db->get('m_justificativo');

        $descuentos = getRegistrosCompartidos('Descuento','m_descuento');
        $haberes = getRegistrosCompartidos('haber','m_haber');       
        
        
        //$db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $tipomoneda = $db->get("m_tipomoneda");    
        
        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $contratos = $db->get("m_contrato");
        
        $db->where("trabajador_id", $parametros[1]);
        $db->where("activo", 1);
        $contratos_asignados = $db->get("t_contrato");
        
        $instituciones = $db->get("m_institucion");            
        $tipotrabajador = $db->get("m_tipotrabajador");
        $isapres = $db->get("m_isapre");
        
        $db->where("trabajador_id", $parametros[1]);
        $apv = $db->get("t_apv");        
    
        $afp = $db->get("m_afp"); 
        
        $limites_periodo = getPeriodoCorte();                            
        if( @$parametros[2] && $parametros[3] ){
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
        
        
        
        /** Marcajes **/
        $date_from = strtotime($fecha_desde . "00:00:00");
        $date_to = strtotime($fecha_limite . "23:59:59");
        $db->where('id',$trabajador['horario_id']);
        $m_horarios = $db->getOne('m_horario');
        $array_dias_temp = array($m_horarios['lun'],$m_horarios['mar'],$m_horarios['mie'],$m_horarios['jue'],$m_horarios['vie'],$m_horarios['sab'],$m_horarios['dom']);
        $dias_laborales_horario = array();
        
        foreach( $array_dias_temp as $k => $i ){
            if( $i == 1 ){
                $dias_laborales_horario[] = $k;
            }
        } 
        
        $entradas = array();
        $salidas = array();
                
        for($unixtime=$date_from; $unixtime<=$date_to; $unixtime+=86400){            
            $dia_semana = date('N', $unixtime);
            $dia_semana--;
            
            if( in_array($dia_semana,$dias_laborales_horario) ){
                $date_iterar = date('Y-m-d',$unixtime);
                if( ! isDiaFeriado($date_iterar) ){
                    
                    $sql = "
                    SELECT  * FROM m_relojcontrol 
                    WHERE  userid = '$relojcontrol_id' 
                    AND checktime LIKE '$date_iterar %'              
                    ORDER BY checktime ASC
                    ";  
                                  
                    $marcajes = $db->rawQuery($sql);
                    
                    if( $db->count == 1 ){
                        $unix_hora_umbral = strtotime( $date_iterar . ' ' . $umbral );
                        $unix_hora_marcada = strtotime( $marcajes[0]['checktime'] );

                        $temp_timestamp = strtotime($marcajes[0]['checktime']);

                        if( $unix_hora_marcada > $unix_hora_umbral ){
                            $salidas[] = array(
                                'id' => $marcajes[0]['id'],
                                'userid' => $marcajes[0]['userid'],
                                'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp),
                                'checktype' => $marcajes[0]['checktype'],
                                'logid' => $marcajes[0]['logid']
                            );
                        } else {
                            $entradas[] = array(
                                'id' => $marcajes[0]['id'],
                                'userid' => $marcajes[0]['userid'],
                                'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp),
                                'checktype' => $marcajes[0]['checktype'],
                                'logid' => $marcajes[0]['logid']
                            );
                        }   
                    } 
                    
                    if( $db->count > 1 ){
                        
                        $primer_marcaje = 0;
                        $ultimo_marcaje = ( count($marcajes) - 1 );                        
                        
                        $temp_timestamp_I = strtotime($marcajes[$primer_marcaje]['checktime']);
                        $temp_timestamp_O = strtotime($marcajes[$ultimo_marcaje]['checktime']);

                        $entradas[] = array(
                            'id' => $marcajes[$primer_marcaje]['id'],
                            'userid' => $marcajes[$primer_marcaje]['userid'],
                            'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp_I),
                            'checktype' => $marcajes[$primer_marcaje]['checktype'],
                            'logid' => $marcajes[$primer_marcaje]['logid']
                        );
                        $salidas[] = array(
                            'id' => $marcajes[$ultimo_marcaje]['id'],
                            'userid' => $marcajes[$ultimo_marcaje]['userid'],
                            'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp_O),
                            'checktype' => $marcajes[$ultimo_marcaje]['checktype'],
                            'logid' => $marcajes[$ultimo_marcaje]['logid']
                        );
                    } 
                
                }
            }                 
                            
        }
        /*
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
        */
        
        $fechaInicio = inicioPeriodo($fecha_desde . ' 00:00:00', $trabajador_id);
        $fechaFin = finPeriodo($fecha_limite . ' 23:59:59', $trabajador_id);                               
        
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
        $periodo_corte = getPeriodoCorte();
        $db->where("trabajador_id", $parametros[1]);
        if( $parametros[2] && $parametros[3] ){
            $db->where('fecha', Array ($parametros[2], $parametros[3]), 'BETWEEN');    
        } else {
            $db->where('fecha', Array ($periodo_corte['desde'], $periodo_corte['hasta']), 'BETWEEN');    
        }
        $t_atrasohoraextra = $db->get('t_atrasohoraextra');

        
        /** Datos previsionales Trabajador **/
        $db->where("trabajador_id", $parametros[1]);
        $datos_prev = $db->getOne("t_prevision");
        
        /** Documentos escaneados del trabajador **/
        $db->where("trabajador_id", $parametros[1]);
        $documentos_trabajador = $db->get("t_documentotrabajador");
    }

    if ($parametros[0] == 'marcaje') {

        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $db->orderBy("apellidoPaterno","ASC");
        $db->where ("deleted_at", NULL, 'IS');
        $lista_trabajadores = $db->get("m_trabajador");

        $fecha_ini = strtotime($parametros[2]);
        $fecha_fin = strtotime($parametros[3]);

        $super_arreglo = [];

        $indice=0;

        $db->where('id',$parametros[1]);
        $db->where ("deleted_at", NULL, 'IS');
        $trabajador = $db->getOne('m_trabajador');
        $relojcontrol_id = $trabajador['relojcontrol_id'];

        $dias_laborales = mHorarios($trabajador['horario_id']);
        

        for($i=$fecha_ini; $i<=$fecha_fin; $i+=86400){

            $fecha_iterar = date("Y-m-d", $i);
            $super_arreglo[$indice]['fecha'] = $fecha_iterar;
            $fecha_comparar_temp = strtotime($fecha_iterar);
            $dias_semana_comparar = date('N',$fecha_comparar_temp);

            $db->where ("fecha", $fecha_iterar);
            $db->where('id',$parametros[1]);
            $existe_en_t_atrasoHE = $db->getOne ("t_atrasohoraextra");
            //show_array($existe_en_t_atrasoHE);----- Averiguar por qe no trae datos

            if (count($existe_en_t_atrasoHE) > 0) {
                $super_arreglo[$indice]['existe'] = 1;
                $super_arreglo[$indice]['io'] = $existe_en_t_atrasoHE['io'];
                $super_arreglo[$indice]['justificativo_id'] = $existe_en_t_atrasoHE['justificativo_id'];
                $super_arreglo[$indice]['trabajador_id'] = $existe_en_t_atrasoHE['trabajador_id'];

                $db->where("id",$super_arreglo[$indice]['justificativo_id']);
                $justificativo = $db->getOne("m_justificativo");

                $super_arreglo[$indice]['nombre_justif'] = $justificativo['nombre'];
                
                $super_arreglo[$indice]['horas'] = $existe_en_t_atrasoHE['horas'];
            } else {
                $super_arreglo[$indice]['existe'] = 0;
                $super_arreglo[$indice]['io'] = "";
                $super_arreglo[$indice]['justificativo_id'] = 0;
                $super_arreglo[$indice]['nombre_justif'] = "";                    
                $super_arreglo[$indice]['horas'] = "";
                $super_arreglo[$indice]['trabajador_id'] = 0;
            } 

            $db->where('checktype','I');
            $db->where('userid',$relojcontrol_id);
            $db->where('checktime',$fecha_iterar.' %','LIKE');
            $existe_en_relojcontrol_I = $db->getOne('m_relojcontrol');

            if (in_array($dias_semana_comparar, $dias_laborales)) {
                if($existe_en_relojcontrol_I){
                    $hora_entrada = explode(' ', $existe_en_relojcontrol_I['checktime']);
                    $hora_entrada = $hora_entrada[1];
                    $super_arreglo[$indice]['hora_entrada'] = $hora_entrada;
                    
                } else {
                    $super_arreglo[$indice]['hora_entrada'] = 'no marco';
                }

                $db->where('checktype','O');
                $db->where('userid',$relojcontrol_id);
                $db->where('checktime',$fecha_iterar.' %','LIKE');
                $existe_en_relojcontrol_O = $db->getOne('m_relojcontrol');

                if($existe_en_relojcontrol_O){
                    $hora_salida = explode(' ', $existe_en_relojcontrol_O['checktime']);
                    $hora_salida = $hora_salida[1];
                    $super_arreglo[$indice]['hora_salida'] = $hora_salida;
                    
                } else {
                    $super_arreglo[$indice]['hora_salida'] = 'no marco';
                }

            }else{
                $super_arreglo[$indice]['hora_salida'] = "Dia no laboral";
                $super_arreglo[$indice]['hora_entrada'] = "Dia no laboral";
                
            }
            if($super_arreglo[$indice]['hora_entrada'] == "no marco" && $super_arreglo[$indice]['hora_salida'] == "no marco"){
                $super_arreglo[$indice]['no_marco_dia_completo'] = true;
            }else{
                $super_arreglo[$indice]['no_marco_dia_completo'] = false;
            }

            $indice++;
        }

    }

    $ccostos_externo = $db->get('m_centrocosto_externo');


    /*if( $parametros[0] == "marcaje" ){
        
        $super_arreglo = [];
        
        $indice=0;
        for( fI -> fCurrent fF ){
            
            $super_arreglo[$indice]['fecha'] = fCurrent;
            
            $existe_en_t_atrasoHE = $db ->  existe en t_atraso
            
            if( count($existe_en_t_atrasoHE) > 0 ){
                $super_arreglo[$indice]['existe'] = 1;
                $super_arreglo[$indice]['io'] = $existe_en_t_atrasoHE['io'];
                
                $justificativo = $db->m_justuifucativo;
                $super_arreglo[$indice]['nombre_justif'] = $justificativo['nombre'];
                
                $super_arreglo[$indice]['horas'] = $existe_en_t_atrasoHE['horas'];
                
            } else {
                $super_arreglo[$indice]['existe'] = 0;
                $super_arreglo[$indice]['io'] = "";
                $super_arreglo[$indice]['nombre_justif'] = "";                    
                $super_arreglo[$indice]['horas'] = "";
            }
            
            $db->where('checktype') = 'I'
            $existe_en_relojcontrol_I = $db ->  existe en m_reloljcontrol;
            
            if( $existe_en_relojcontrol_I ){
            
                $super_arreglo[$indice]['hora_entrada'] = $existe_en_relojcontrol_I['checktime']; // OJO --- solo la hora
                
            } else {
                $super_arreglo[$indice]['hora_entrada'] = 'no marco';
            }
            
            
            
            $existe_en_relojcontrol_O = $db ->  existe en m_reloljcontrol;
            
            if( $existe_en_relojcontrol_O ){
                $super_arreglo[$indice]['hora_salida'] = $existe_en_relojcontrol_O['checktime']; // OJO --- solo la hora
                
            } else {
            
                $super_arreglo[$indice]['hora_salida'] = 'no marco';
            }
            
            $indice++;
        }
        
    }*/
    
    if ($parametros[0] == 'documentos_pendientes' || $parametros[0] == 'editar') {

        $total_documentos = 18;

        $codigos_documentos = [];
        for($i=1;$i<=$total_documentos;$i++){
            $codigos_documentos[] = str_pad($i, 3, '0', STR_PAD_LEFT);
        }

        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
        $db->orderBy("apellidoPaterno","ASC");
        $db->where ("deleted_at", NULL, 'IS');
        $db->where ("tipocontrato_id", [3,4], 'NOT IN');
        $lista_trabajadores = $db->get("m_trabajador");
    }

}


function properText($text){
    $text = mb_convert_encoding($text, "HTML-ENTITIES", "UTF-8");
    $text = preg_replace('~^(&([a-zA-Z0-9]);)~',htmlentities('${1}'),$text);
    return($text); 
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

