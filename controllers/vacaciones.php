<?php
$ano = getAnoMostrarCorte();

$db->where("id",$_SESSION[PREFIX.'login_eid']);
$id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');

$diasVacacionesTrabajador = $db->where('id',$_SESSION[PREFIX . 'login_uid'])->getValue('m_trabajador','diasVacaciones');
$diasVacacionesProgresivasTrabajador = $db->where('id',$_SESSION[PREFIX . 'login_uid'])->getValue('m_trabajador','diasVacacionesProgresivas');


// Determinar trabajadores a cargo del jefe logueado y buscar solicitudes de ESOS trabajadores

$db->where('id',$_SESSION[PREFIX.'login_uid']);
$cargo_id = $db->getValue('m_trabajador','cargo_id');


if( $_POST ){

    extract($_POST);

    if( $_POST['action'] == 'ajax_anular_solicitud'){

        sleep(2);

        $solicitud = $db->where('id',$_POST['solicitud_id'])->getOne('m_vacaciones');

        $t_ausencia = $db->where('fecha_inicio',$solicitud['fecha_inicio'])
        ->where('fecha_fin',$solicitud['fecha_fin'])
        ->where('ausencia_id',4)
        ->where('trabajador_id',$_POST['trabajador_id'])
        ->getOne('t_ausencia');


        // 1. Eliminar el registro en la table t_ausencia, si la ausencia NO es mediodia
        if( $solicitud['mediodia'] == 0 ){
            if( !$solicitud['solicitud_id'] ){
                $del = $db->where('id',$t_ausencia['id'])->delete('t_ausencia'); 
            } else {
                $del = $db->where('solicitud_id',$solicitud['id'])->delete('t_ausencia'); 
            }
            
        }

        //2. Reestableceer cantidad de dias de vacaciones
        $tipo_field = ($solicitud['tipo'] == 'progresivas') ? 'diasVacacionesProgresivas' : 'diasVacaciones';

        $diasVacacionesCurrent = $db->where('id',$_POST['trabajador_id'])->getValue('m_trabajador',$tipo_field);

        $newDiasVacaciones = ($diasVacacionesCurrent + $solicitud['totalDias']);

        $db->where('id',$_POST['trabajador_id'])->update('m_trabajador',[
            $tipo_field => $newDiasVacaciones
        ]);


        // 3. Eliminar la solicitud de vacaciones
        $db->where('id',$_POST['solicitud_id'])->delete('m_vacaciones');

        logit($_SESSION[PREFIX.'login_name'], 'Anular Vacaciones', 'm_vacaciones', $_POST['solicitud_id'], $db->getLastQuery(), $_SESSION[PREFIX.'login_eid']);

        echo json_encode([
            'status' => 'ok',
            'solicitud_id' => $_POST['solicitud_id']
        ]);
        exit();
    }


    if($_POST['action'] == 'confirmar_vacaciones'){

        if( $_POST['status_aprobacion'] == 1 ){ // Si se confirma la solicitud de vacaciones:

            // 1. Actualizar la solicitud a confirmada = 1
            $db->where('id',$_POST['vacaciones_id'])->update('m_vacaciones',[
                'confirmada' => 1,
                'confirmada_por' => $_SESSION[PREFIX.'login_uid'],
                'confirmada_fecha' => date('Y-m-d H:i:s')
            ]);

            // 2. Ingresar los dias a la tabla t_ausencia,solo en caso que NO sea mediodia
            $solicitud = $db->where('id',$_POST['vacaciones_id'])->getOne('m_vacaciones');

            if( $solicitud['mediodia'] == 0 ){
                $db->insert('t_ausencia',[
                    'fecha_inicio' => $solicitud['fecha_inicio'],
                    'fecha_fin' => $solicitud['fecha_fin'],
                    'totalDias' => $solicitud['totalDias'],
                    'trabajador_id' => $solicitud['trabajador_id'],
                    'ausencia_id' => $id_ausencia_vacaciones,
                    'usuario_id' => $_SESSION[PREFIX.'login_uid'],
                    'solicitud_id' => $_POST['vacaciones_id']
                ]);
            }


            // 3. Descontar dias de las vacaciones que tiene actualmente (Progresivas o Legales)
            if( $solicitud['mediodia'] == 1 ){
                $solicitud['totalDias'] = 0.5;
                $solicitud['fecha_fin'] = $solicitud['fecha_inicio'];
            }
            if( $solicitud['tipo'] == 'progresivas' ){
                $diasVacacionesTrabajador = $db->where('id',$solicitud['trabajador_id'])->getValue('m_trabajador','diasVacacionesProgresivas');
                 $db->where('id',$solicitud['trabajador_id'])->update('m_trabajador',[
                    'diasVacacionesProgresivas' => ( $diasVacacionesTrabajador - $solicitud['totalDias'])
                ]);
            } else {
                $diasVacacionesTrabajador = $db->where('id',$solicitud['trabajador_id'])->getValue('m_trabajador','diasVacaciones');
                $db->where('id',$solicitud['trabajador_id'])->update('m_trabajador',[
                    'diasVacaciones' => ( $diasVacacionesTrabajador - $solicitud['totalDias'])
                ]);
            }
            
           
            $person = $db->where('id',$solicitud['trabajador_id'])->getOne('m_trabajador');

            // Fechas con el mes en español
            $fecha_spanish_inicio = date('d',strtotime($solicitud['fecha_inicio'])) . '/' . getNombreMes(date('m',strtotime($solicitud['fecha_inicio'])), true) . '/' . date('Y',strtotime($solicitud['fecha_inicio']));
            $fecha_spanish_fin = date('d',strtotime($solicitud['fecha_fin'])) . '/' . getNombreMes(date('m',strtotime($solicitud['fecha_fin'])), true) . '/' . date('Y',strtotime($solicitud['fecha_fin']));

            $body = "
                <table>
                    <tr>
                        <td> 
                            <h2> Hola, " . $person['nombres'] . " " . $person['apellidoPaterno'] . " " . $person['apellidoMaterno'] . " </h2>
                            <p>
                                Su solicitud de vacaciones, desde el " . $fecha_spanish_inicio . ", hasta el " . $fecha_spanish_fin . " ha sido CONFIRMADA
                            </p>
                            <p>
                                El periodo de vacaciones ha sido descontado autom&aacute;ticamente de su saldo de d&iacute;as de vacaciones y se ver&aacute; reflejado en la liquidaci&oacute;n correspondiente al mes solicitado.
                            </p>
                            <br />
                            <p>
                                Saludos<br />
                                Tecnodata S.A.
                            </p>
                        </td>
                    </tr>
                </table>
            ";

            $mailto = $db->where('id',$solicitud['trabajador_id'])->getValue('m_trabajador','email');


            // 4. Enviar correo avisando que esta OK
            $mail = new PHPMailer(true);
            try {
                
                $mail->isSMTP();
                $mail->Host     = 'srvcorreo.tecnodatasa.cl';
                $mail->SMTPAuth = true;
                $mail->Username = "sist_rrhh@tecnodatasa.cl";
                $mail->Password = "devti007";

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom("sist_rrhh@tecnodatasa.cl", 'Recursos Humanos Tecnodata');
                $mail->addAddress($mailto);
                
                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Solicitud de vacaciones CONFIRMADA';
                $mail->Body    = $body;

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $response = encrypt('status=success&mensaje=Vacaciones CONFIRMADAS correctamente&id=');

        } else {
            $db->where('id',$_POST['vacaciones_id'])->delete('m_vacaciones');
            $response = encrypt('status=error&mensaje=Solicitud ELIMINADA&id='.$_POST['vacaciones_id']);
        }

        redirect(BASE_URL . '/' . $entity . '/confirmar_solicitudes/response/' . $response );
        exit();

    }


    if( @$_POST['action'] == 'solicitar_vacaciones' ){


        $int_desde_vacaciones = str_replace("-", "", $desdeVacaciones);
        $int_desde_vacaciones = (int)$int_desde_vacaciones;
        $int_hoy = (int)date('Ymd');

        $diasHabiles = diasHabiles( $_SESSION[PREFIX.'login_uid'],$desdeVacaciones, $hastaVacaciones, $id_ausencia_vacaciones);

        if( ($diasHabiles > $diasVacacionesTrabajador) && ($cargo != "progresivas") && (!$_POST['vacaciones_mediodia']) ){
            $response = encrypt("status=error&mensaje=No puede solicitar mas de $diasVacacionesTrabajador días hábiles legales&id=");    
        } else{

            if( $cargo == 'progresivas' && $diasHabiles > $diasVacacionesProgresivasTrabajador ){
                $response = encrypt('status=error&mensaje=No puedes pedir mas de ' . $diasVacacionesProgresivasTrabajador . ' días de vacaciones progresivas&id=');
            } else {

                $data_insert = array(
                    'trabajador_id' => $_SESSION[PREFIX.'login_uid'],
                    'fecha_inicio' => $desdeVacaciones,
                    'fecha_fin' => $hastaVacaciones,
                    'totalDias' => $diasHabiles,
                    'tipo' => $cargo                    
                );
                if($_POST['vacaciones_mediodia']){
                    $data_insert['mediodia'] = 1;
                    $data_insert['fecha_fin'] = $desdeVacaciones;
                    $data_insert['totalDias'] = 0.5;
                }
                $insert_id = $db->insert('m_vacaciones',$data_insert);
                
                $solicitud = $db->where('id',$insert_id)->getOne('m_vacaciones');

                $dias_disponibles = $db->where('id',$solicitud['trabajador_id'])->getValue('m_trabajador','diasVacaciones');
                $dias_disponibles_prog = $db->where('id',$solicitud['trabajador_id'])->getValue('m_trabajador','diasVacacionesProgresivas');


                // AVisar al jefe directo que hay una solicitud de vacaciones
                $jefe_id = $db->where('id',$_SESSION[PREFIX.'login_uid'])->getValue('m_trabajador','jefe_id');
                $jefe = $db->where('id',$jefe_id)->getOne('m_trabajador');

                if( $solicitud['mediodia'] ){
                    $solicitud['fecha_fin'] = $solicitud['fecha_inicio'];
                }

                // Fechas con el mes en español
                $fecha_spanish_inicio = date('d',strtotime($solicitud['fecha_inicio'])) . '/' . getNombreMes(date('m',strtotime($solicitud['fecha_inicio'])), true) . '/' . date('Y',strtotime($solicitud['fecha_inicio']));
                $fecha_spanish_fin = date('d',strtotime($solicitud['fecha_fin'])) . '/' . getNombreMes(date('m',strtotime($solicitud['fecha_fin'])), true) . '/' . date('Y',strtotime($solicitud['fecha_fin']));

                $body = "
                    <table>
                        <tr>
                            <td> 
                                <h2> Hola, " . $jefe['nombres'] . " " . $jefe['apellidoPaterno'] . " " . $jefe['apellidoMaterno'] . " </h2>
                                <p>
                                    Le informamos que el trabajador <strong>" . getNombreTrabajador($_SESSION[PREFIX . 'login_uid'],true) . "</strong> est&aacute; solicitando <strong>" . $solicitud['totalDias'] . " d&iacute;as </strong> de vacaciones, con cargo a sus vacaciones " . $solicitud['tipo'] . ", desde el " . $fecha_spanish_inicio . ", hasta el " . $fecha_spanish_fin . ".
                                </p>
                                <p>
                                Su saldo actual de dias disponibles es:<br>
                                Vacaciones Legales: " . $dias_disponibles . " d&iacute;as <br>
                                Vacaciones Progresivas: " . $dias_disponibles_prog . " d&iacute;as <br>
                                </p>
                                <p>Ingrese al portal de Recursos Humanos para aprobar o rechazar esta solicitud, seg&uacute;n sea el caso.</p>
                                <p>
                                    <br>
                                    Saludos<br />
                                    Tecnodata S.A.
                                </p>
                            </td>
                        </tr>
                    </table>
                ";

                $mailto = $jefe['email'];

                $mail = new PHPMailer(true);
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host     = 'srvcorreo.tecnodatasa.cl';
                $mail->SMTPAuth = true;
                $mail->Username = "sist_rrhh@tecnodatasa.cl";
                $mail->Password = "devti007";

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom("sist_rrhh@tecnodatasa.cl", 'Recursos Humanos Tecnodata');
                $mail->addAddress($mailto);
                
                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Nueva Solicitud de vacaciones';
                $mail->Body    = $body;

                $mail->send();


                $response = encrypt('status=success&mensaje=Vacaciones solicitadas correctamente. Ahora debe esperar a que su jefe directo la revise y apruebe o rechace según sea el caso&id=');
            }
        }
        
        logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'vacaciones',$insert_id,$db->getLastQuery() );
        
        redirect(BASE_URL . '/' . $entity . '/solicitar/response/' . $response );
        exit();
    }
    
    
    if( $action == 'aprobar' ){
        
        $db->where('id',$vacaciones_id);
        $vacaciones_pre = $db->getOne('m_vacaciones');

        $arr_status = ['Rechazada','Aprobada'];
        
        $trabajador = $db->where('id',$vacaciones_pre['trabajador_id'])->getOne('m_trabajador');
        
        $data_upd = array(
            "aprobado" => $status_aprobacion,
            "aprobadoPor" => getNombreTrabajador($_SESSION[PREFIX.'login_uid'], true), 
            "fechaAprobacion" => date('Y-m-d H:i:s')
        );                
        
        $db->where('id',$vacaciones_pre['id']);
        $db->update('m_vacaciones',$data_upd);

        // Fechas con el mes en español
        $fecha_spanish_inicio = date('d',strtotime($vacaciones_pre['fecha_inicio'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_inicio'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_inicio']));
        $fecha_spanish_fin = date('d',strtotime($vacaciones_pre['fecha_fin'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_fin'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_fin']));

        $body = "
            <table>
                <tr>
                    <td> 
                        <h2> Hola, " . $trabajador['nombres'] . " " . $trabajador['apellidoPaterno'] . " " . $trabajador['apellidoMaterno'] . " </h2>
                        <p>
                            Su solicitud de vacaciones, desde el " . $fecha_spanish_inicio . ", hasta el " . $fecha_spanish_fin . " ha sido " . $arr_status[$status_aprobacion] . "
                        </p>";

                    if($status_aprobacion == 1){
                        $body .= "<p>Por favor, imprima el formulario adjunto. F&iacute;rmelo y ll&eacute;velo a Recursos Humanos, para que confirmen su solicitud.</p>";
                    }
            
                        
                    $body .= "
                        <br />
                        <p>
                            Saludos<br />
                            Tecnodata S.A.
                        </p>
                    </td>
                </tr>
            </table>
        ";            

        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = "srvcorreo.tecnodatasa.cl";
        $mail->SMTPAuth = true;
        $mail->Username = "sist_rrhh@tecnodatasa.cl";
        $mail->Password = "devti007";

        $mail->SMTPOptions = array( // Disable SSL Check
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom("sist_rrhh@tecnodatasa.cl", 'Recursos Humanos Tecnodata');
        $mail->addAddress($trabajador['email']);     //Add a recipient
                    
        //Attachments
        $v_legal = ($vacaciones_pre['tipo'] == 'legal') ? 'X' : '&nbsp;&nbsp;';
        $v_progre = ($vacaciones_pre['tipo'] == 'progresivas') ? 'X' : '&nbsp;&nbsp;';

        $saldo_pendiente = ($vacaciones_pre['tipo'] == 'legal') ? ($trabajador['diasVacaciones'] - $vacaciones_pre['totalDias']) : ($trabajador['diasVacacionesProgresivas'] - $vacaciones_pre['totalDias']);

        // Fechas con el mes en español
        $fecha_spanish_inicio = date('d',strtotime($vacaciones_pre['fecha_inicio'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_inicio'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_inicio']));
        $fecha_spanish_fin = date('d',strtotime($vacaciones_pre['fecha_fin'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_fin'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_fin']));


        //Obtener el logo y el timbre "aprobado" de la empresa
        $logo = $db->where('id',$trabajador['empresa_id'])->getValue('m_empresa','foto');

        switch ($trabajador['empresa_id']) {
            case 2: $timbre = 'aprobado_tecnodata.jpg'; break;
            case 11: $timbre = 'aprobado_mellafe.jpg'; break;
            default: $timbre = 'aprobado.jpg'; break;
        }

        if($status_aprobacion == 1){
            $formulario_vacaciones_html = '
            <style type="text/css">
                table.border td{ border: 1px solid #000; padding: 2px 5px; }
            </style>
            <page style="font-family: sans-serif;" backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">
                <table style="width: 800px" border="0">
                    <tr>
                        <td style="width: 400px; text-align: left"><img class="round" src="'. ROOT .'/private/uploads/images/' . $logo . '"></td>
                        <td style="width: 300px; text-align: right">' . date('d-m-Y') . '</td>
                    </tr>
                </table>

                <h2 style="text-align: center; text-transform: uppercase"> <u>COMPROBANTE DE FERIADO LEGAL</u> </h2>
                
                <p>&nbsp;</p>

                <table>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
                    ' . $trabajador['nombres'] . ' ' . $trabajador['apellidoPaterno'] . ' ' . $trabajador['apellidoMaterno'] . ' 
                    &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  </div></td>
                    <td><strong>  &nbsp;  &nbsp;  &nbsp;  &nbsp; Rut:</strong></td>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> 
                    ' . $trabajador['rut'] . '
                    </div></td>
                </tr>
                </table>

                <p>CERTIFICO QUE EN LA FECHA INDICADA A CONTINUACIÓN, HARE USO DE MI FERIADO LEGAL Y DIAS PENDIENTES QUE CORRESPONDEN AL O LOS PERIODOS:</p>
                
                <table>
                <tr>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">' . $v_legal . '</div></td>
                    <td>Vacaciones Legales</td>
                </tr>
                </table>
                     
                <table>
                <tr>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">' . $v_progre . '</div></td>
                    <td>Dias Progresivos</td>
                </tr>
                </table>
                
                <p>&nbsp;</p>

                <table style="width: 100%" border="0">
                    <tr>
                        <td style="width: 50%; text-align: left">Fecha Inicio: 
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $fecha_spanish_inicio . '
                        </div>
                        </td>
                        <td style="width: 50%; text-align: left"> &nbsp;  &nbsp;  &nbsp;  &nbsp; Fecha Término: 
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $fecha_spanish_fin . '
                        </div>
                        </td>
                    </tr>
                </table>
                    
                <table>
                    <tr>
                        <td><strong>Días solicitados</strong></td>
                        <td>
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $vacaciones_pre['totalDias'] . '
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Saldo pendiente</strong></td>
                        <td>
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> 
                        ' . $saldo_pendiente . '
                        </div>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <table style="width: 800px" border="0">
                    <tr>
                        <td style="width: 300px; text-align: center; padding-top: 145px">
                            ______________________________________<br>Firma Trabajador 
                        </td>

                        <td style="width: 400px; text-align: center">
                            <img src="' . ROOT . '/public/img/' . $timbre . '"><br>
                            ______________________________________<br>Firma Jefe Directo 
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </page>
            ';

            require_once( ROOT . '/libs/html2pdf/html2pdf.class.php');
            $html2pdf = new HTML2PDF('P','LETTER','es');
            $html2pdf->WriteHTML($formulario_vacaciones_html);        
            $html2pdf->Output( ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf','F' );

            $mail->addAttachment(ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf','solicitud_de_vacaciones.pdf');

        }


        //Content
        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Solicitud de vacaciones ' . $arr_status[$status_aprobacion]);
        $mail->Body    = $body;
        $mail->send();

        unlink(ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf');

        $response = encrypt('status=success&mensaje=Solicitud '. $arr_status[$status_aprobacion] .' correctamente&id='.$insert_id);                           
    
        redirect(BASE_URL . '/' . $entity . '/ver_solicitudes/response/' . $response );
        exit();         
    }

    if( $action == 'ajax_count_days' ){

        $diasHabiles = diasHabiles($_SESSION[PREFIX.'login_uid'],$_POST['desde'], $_POST['hasta'], $id_ausencia_vacaciones);

        $desde_format = ( $_POST['desde'] ) ? date('d',strtotime($_POST['desde'])) . '/' .  getNombreMes(date('m',strtotime($_POST['desde'])),true) . '/' . date('Y',strtotime($_POST['desde'])) : '';
        $hasta_format = ( $_POST['hasta'] ) ? date('d',strtotime($_POST['hasta'])) . '/' .  getNombreMes(date('m',strtotime($_POST['hasta'])),true) . '/' . date('Y',strtotime($_POST['hasta'])) : '';

        echo json_encode([
            'dias' => $diasHabiles,
            'desde_format' => $desde_format,
            'hasta_format' => $hasta_format,
            'desde_int' => ( $_POST['desde'] ) ? (int)date('Ymd',strtotime($_POST['desde'])) : date('Ymd'),
            'hasta_int' => ( $_POST['hasta'] ) ? (int)date('Ymd',strtotime($_POST['hasta'])) : date('Ymd'),
        ]);
        exit();
    }

  
    if( $action == 'ajax_resend_form' ){

        $status_aprobacion = 1;

        $db->where('id',$_POST['vacaciones_id']);
        $vacaciones_pre = $db->getOne('m_vacaciones');

        $arr_status = ['Rechazada','Aprobada'];
        
        $trabajador = $db->where('id',$_SESSION[PREFIX . 'login_uid'])->getOne('m_trabajador');

        // Fechas con el mes en español
        $fecha_spanish_inicio = date('d',strtotime($vacaciones_pre['fecha_inicio'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_inicio'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_inicio']));
        $fecha_spanish_fin = date('d',strtotime($vacaciones_pre['fecha_fin'])) . '/' . getNombreMes(date('m',strtotime($vacaciones_pre['fecha_fin'])), true) . '/' . date('Y',strtotime($vacaciones_pre['fecha_fin']));

        $body = "
            <table>
                <tr>
                    <td> 
                        <h2> Hola, " . $trabajador['nombres'] . " " . $trabajador['apellidoPaterno'] . " " . $trabajador['apellidoMaterno'] . " </h2>
                        <p>
                            Su solicitud de vacaciones, desde el " . $fecha_spanish_inicio . ", hasta el " . $fecha_spanish_fin . " ha sido " . $arr_status[$status_aprobacion] . "
                        </p>";

                    if($status_aprobacion == 1){
                        $body .= "<p>Por favor, imprima el formulario adjunto. F&iacute;rmelo y ll&eacute;velo a Recursos Humanos, para que confirmen su solicitud.</p>";
                    }
            
                        
                    $body .= "
                        <br />
                        <p>
                            Saludos<br />
                            Tecnodata S.A.
                        </p>
                    </td>
                </tr>
            </table>
        ";            

        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = "srvcorreo.tecnodatasa.cl";
        $mail->SMTPAuth = true;
        $mail->Username = "sist_rrhh@tecnodatasa.cl";
        $mail->Password = "devti007";

        $mail->SMTPOptions = array( // Disable SSL Check
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom("sist_rrhh@tecnodatasa.cl", 'Recursos Humanos Tecnodata');
        $mail->addAddress($trabajador['email']);     //Add a recipient
                    
        //Attachments
        $v_legal = ($vacaciones_pre['tipo'] == 'legal') ? 'X' : '&nbsp;&nbsp;';
        $v_progre = ($vacaciones_pre['tipo'] == 'progresivas') ? 'X' : '&nbsp;&nbsp;';

        $saldo_pendiente = ($vacaciones_pre['tipo'] == 'legal') ? ($trabajador['diasVacaciones'] - $vacaciones_pre['totalDias']) : ($trabajador['diasVacacionesProgresivas'] - $vacaciones_pre['totalDias']);


        //Obtener el logo y el timbre "aprobado" de la empresa
        $logo = $db->where('id',$trabajador['empresa_id'])->getValue('m_empresa','foto');

        switch ($trabajador['empresa_id']) {
            case 2: $timbre = 'aprobado_tecnodata.jpg'; break;
            case 11: $timbre = 'aprobado_mellafe.jpg'; break;
            default: $timbre = 'aprobado.jpg'; break;
        }

        if($status_aprobacion == 1){
            $formulario_vacaciones_html = '
            <style type="text/css">
                table.border td{ border: 1px solid #000; padding: 2px 5px; }
            </style>
            <page style="font-family: sans-serif;" backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">
                <table style="width: 800px" border="0">
                    <tr>
                        <td style="width: 400px; text-align: left"><img class="round" src="'. ROOT .'/private/uploads/images/' . $logo . '"></td>
                        <td style="width: 300px; text-align: right">' . date('d-m-Y') . '</td>
                    </tr>
                </table>

                <h2 style="text-align: center; text-transform: uppercase"> <u>COMPROBANTE DE FERIADO LEGAL</u> </h2>
                
                <p>&nbsp;</p>

                <table>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
                    ' . $trabajador['nombres'] . ' ' . $trabajador['apellidoPaterno'] . ' ' . $trabajador['apellidoMaterno'] . ' 
                    &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  </div></td>
                    <td><strong>  &nbsp;  &nbsp;  &nbsp;  &nbsp; Rut:</strong></td>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> 
                    ' . $trabajador['rut'] . '
                    </div></td>
                </tr>
                </table>

                <p>CERTIFICO QUE EN LA FECHA INDICADA A CONTINUACIÓN, HARE USO DE MI FERIADO LEGAL Y DIAS PENDIENTES QUE CORRESPONDEN AL O LOS PERIODOS:</p>
                
                <table>
                <tr>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">' . $v_legal . '</div></td>
                    <td>Vacaciones Legales</td>
                </tr>
                </table>
                     
                <table>
                <tr>
                    <td><div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">' . $v_progre . '</div></td>
                    <td>Dias Progresivos</td>
                </tr>
                </table>
                
                <p>&nbsp;</p>

                <table style="width: 100%" border="0">
                    <tr>
                        <td style="width: 50%; text-align: left">Fecha Inicio: 
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $fecha_spanish_inicio . '
                        </div>
                        </td>
                        <td style="width: 50%; text-align: left"> &nbsp;  &nbsp;  &nbsp;  &nbsp; Fecha Término: 
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $fecha_spanish_fin . '
                        </div>
                        </td>
                    </tr>
                </table>
                    
                <table>
                    <tr>
                        <td><strong>Días solicitados</strong></td>
                        <td>
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center">
                        ' . $vacaciones_pre['totalDias'] . '
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Saldo pendiente</strong></td>
                        <td>
                        <div style="display: inline-block; border: 1px solid black; padding: 5px 15px; width: auto; text-align: center"> 
                        ' . $saldo_pendiente . '
                        </div>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <table style="width: 800px" border="0">
                    <tr>
                        <td style="width: 300px; text-align: center; padding-top: 145px">
                            ______________________________________<br>Firma Trabajador 
                        </td>

                        <td style="width: 400px; text-align: center">
                            <img src="' . ROOT . '/public/img/' . $timbre . '"><br>
                            ______________________________________<br>Firma Jefe Directo 
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </page>
            ';

            require_once( ROOT . '/libs/html2pdf/html2pdf.class.php');
            $html2pdf = new HTML2PDF('P','LETTER','es');
            $html2pdf->WriteHTML($formulario_vacaciones_html);        
            $html2pdf->Output( ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf','F' );

            $mail->addAttachment(ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf','solicitud_de_vacaciones.pdf');

        }


        //Content
        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Solicitud de vacaciones ' . $arr_status[$status_aprobacion]);
        $mail->Body    = $body;
        $mail->send();

        unlink(ROOT . '/private/uploads/docs/solicitud_de_vacaciones.pdf');

        echo json_encode([
            'status' => 'ok'
        ]);

        exit();

    }




    
}

if( $parametros ){  

    if( $parametros[0] == 'solicitar' ){

        $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
        $db->where('aprobado',null,'IS');
        $vacaciones_espera = $db->get('m_vacaciones');


        $sql = "
        SELECT fecha_inicio, fecha_fin, totalDias FROM t_ausencia
        where t_ausencia.trabajador_id = ".$_SESSION[PREFIX.'login_uid']."
        AND t_ausencia.ausencia_id = $id_ausencia_vacaciones
        UNION
        SELECT fecha_inicio, fecha_fin, totalDias FROM m_vacaciones
        WHERE m_vacaciones.trabajador_id = ".$_SESSION[PREFIX.'login_uid']."
        AND m_vacaciones.aprobado = 1
        AND m_vacaciones.mediodia = 1
        ORDER by fecha_inicio DESC
        ";
        $vacaciones_historial = $db->rawQuery( $sql );



        $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);                        
        $db->where('aprobado',0);
        $vacaciones_historial_rechazados = $db->get('m_vacaciones');



        $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);
        $db->where('aprobado',1);
        $vacaciones_aprobadas = $db->get('m_vacaciones');


        $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);
        $db->where('aprobado',2);
        $vacaciones_anuladas = $db->get('m_vacaciones');

    }
    

    if( $parametros[0] == 'confirmar_solicitudes' ){

        switch($_GET['filter']){
            case 'espera':
                 $db->where('aprobado',null,'IS');
            break;

            case 'confirmadas':
                $db->where('confirmada',null,'IS NOT');
            break;

            case 'por_confirmar':
                $db->where('aprobado',1);
                $db->where('confirmada',null,'IS');
            break;

            default;
            break;
        }

        $vacaciones_espera_todos = $db->orderBy('apellidoPaterno','ASC')
        ->join("m_trabajador", "m_trabajador.id = m_vacaciones.trabajador_id")
        ->orderBy('m_trabajador.apellidoPaterno','ASC')
        ->get('m_vacaciones',null,[
            'm_trabajador.apellidoPaterno',
            'm_trabajador.apellidoMaterno',
            'm_trabajador.nombres',
            'm_vacaciones.*'
        ]);

    }


    if( $parametros[0] == 'ver_solicitudes' ){

        $trabajadores_ids_x_area = $db->where('jefe_id',$_SESSION[PREFIX . 'login_uid'])->get('m_trabajador',null,'id');

        $arr_ids_x_area = [];
        foreach($trabajadores_ids_x_area as $t){
            $arr_ids_x_area[] = $t['id'];
        }

        if($arr_ids_x_area){
            $vacaciones_espera_area = $db->where('trabajador_id',$arr_ids_x_area,'IN')->get('m_vacaciones');
        } else {
            $vacaciones_espera_area = [];
        }

    }


    if( $parametros[0] == 'calendario' ){

        $colors = array('#e9109f','#de851b','#0c82ff','#e9dc10','#9510e9','#b9f448','#1510e9','#25be3a','#10e9e6','#878074','#c780ca','#FF0000','#eab275','#b775ea','#2d7fc5','#75ea7b');             
            

        if( $_SESSION[PREFIX.'is_jefe'] ):     
            $trabajadores_ids_x_area = $db->where('jefe_id',$_SESSION[PREFIX . 'login_uid'])->get('m_trabajador',null,'id');

            $arr_ids_x_area = [];
            foreach($trabajadores_ids_x_area as $t){
                $arr_ids_x_area[] = $t['id'];
            }
            
            $ausencias_all = $db->where( 'ausencia_id',$id_ausencia_vacaciones )
            ->where('trabajador_id',$arr_ids_x_area,'IN')
            ->get('t_ausencia');
            
            $color_cont = 0;
            $events = '';

            foreach( $ausencias_all as $aus ){
                $fecha_fin = date($aus['fecha_fin']);
                $nuevafecha_fin = strtotime ( '+1 day' , strtotime ( $fecha_fin ) ) ;
                $nuevafecha_fin = date ( 'Y-m-d' , $nuevafecha_fin );                                 
                
                $events .= "{
                  title: '". getNombreTrabajador( $aus['trabajador_id'], false, false ) ."',
                  desc: '". getNombreTrabajador( $aus['trabajador_id'], false, false ) ."\\n(Desde: " . $aus['fecha_inicio'] . ", Hasta: ". $aus['fecha_fin'] .")',
                  start: '". $aus['fecha_inicio'] ."',
                  end: '". $nuevafecha_fin ."',
                  backgroundColor: '".$colors[$color_cont]."',
                  borderColor: '".$colors[$color_cont]."'
                },";            
                
                $color_cont++;
                if( $color_cont == 10 )
                    $color_cont = 0;            
                
            }

        else:

            $arr_colors = [];
            $departamentos = $db->where('empresa_id',[2,11],'IN')->get('m_departamento');
            foreach ($departamentos as $key => $dep) {
                $arr_colors[$dep['id']] = $colors[$key];
            }

            if( $_GET['dep'] ){

                $arr_trabajadores_x_depto = $db->where('departamento_id',$_GET['dep'])
                ->getValue('m_trabajador','id',null);

                $db->where('trabajador_id',$arr_trabajadores_x_depto,'IN');
            }
            
            $db->where( 'ausencia_id',$id_ausencia_vacaciones );
            $ausencias_all = $db->get('t_ausencia');



            foreach( $ausencias_all as $aus ){
                $fecha_fin = date($aus['fecha_fin']);
                $nuevafecha_fin = strtotime ( '+1 day' , strtotime ( $fecha_fin ) ) ;
                $nuevafecha_fin = date ( 'Y-m-d' , $nuevafecha_fin );                                 
                
                $depto_id = $db->where('id',$aus['trabajador_id'])->getValue('m_trabajador','departamento_id');


                $events .= "{
                  title: '". getNombreTrabajador( $aus['trabajador_id'], false, false ) ."',
                  desc: '". getNombreTrabajador( $aus['trabajador_id'], false, false ) ."\\n(Desde: " . $aus['fecha_inicio'] . ", Hasta: ". $aus['fecha_fin'] .")\\nDepartamento: ". getNombre($depto_id, 'm_departamento', false) ."',
                  start: '". $aus['fecha_inicio'] ."',
                  end: '". $nuevafecha_fin ."',
                  backgroundColor: '". $arr_colors[$depto_id] ."',
                  borderColor: '".$arr_colors[$depto_id]."'
                },";            
                
                $color_cont++;
                if( $color_cont == 10 )
                    $color_cont = 0;            
                
            }

        endif;


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

