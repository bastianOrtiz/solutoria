<?php

$all_eventos = [];
$logic = ($_GET['papelera']) ? 'IS NOT' : 'IS';
$eventos = $db->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->where('deleted_at',null,$logic)->get("m_evento");

foreach ($eventos as $key => $evento) {

    $db->join("m_participante_evento P", "P.trabajador_id = T.id");
    $db->where("P.evento_id", $evento['id']);
    $participantes = $db->get ("m_trabajador T", null, "T.email, T.id, T.nombres");

    $all_eventos[] = [
        'id' => $evento['id'],
        'fechaHoraInicio' => $evento['fechaHoraInicio'],
        'fechaHoraTermino' => $evento['fechaHoraTermino'],
        'titulo' => $evento['titulo'],
        'descripcion' => $evento['descripcion'],
        'tipoevento_id' => $evento['tipoevento_id'],
        'tipo_evento' => getTipoEvento($evento['tipoevento_id']),
        'participantes' => $participantes,
    ];
}

if( $_POST ){
    
    switch($_POST['post_action']){
        case 'crear_evento':

            $fecha_inicio_sql = formatDateEventos($_POST['evento_fechahora_inicio'],'db');
            $fecha_termino_sql = formatDateEventos($_POST['evento_fechahora_termino'],'db');

            $data_insert = [
                'fechaHoraInicio' => $fecha_inicio_sql,
                'fechaHoraTermino' => $fecha_termino_sql,
                'titulo' => $_POST['evento_titulo'],
                'descripcion' => $_POST['descripcion'],
                'tipoevento_id' => $_POST['evento_tipo'],
                'trabajador_id' => $_SESSION[PREFIX . 'login_uid']
            ];

            //$last_evento_insert = $db->insert('m_evento',$data_insert);


            $error = [];
            $mail_sent = [];
            foreach ($_POST['trabajador_id'] as $key => $trabajador_id) {
                $data_participantes = [
                    'evento_id' => $last_evento_insert,
                    'trabajador_id' => $trabajador_id,
                    'asistencia' => 0,
                    'confirmacion' => 0,
                    'nota' => ''
                ];
                //$insert_participante = $db->insert('m_participante_evento',$data_participantes);
                
                if(!$insert_participante){
                    $error[] = [
                        'identificador' => [
                            'evento_id' => $last_evento_insert,
                            'trabajador_id' => $trabajador_id
                        ]
                    ];
                }

                $email_to = $db->where('id',$trabajador_id)->getValue('m_trabajador','email');
                
                $mail = new PHPMailer;
                
                $mail->Host = "192.168.0.22";
                $mail->SMTPAuth = true;
                $mail->Username = 'aterrile@tecnodatasa.cl';
                $mail->Password = 'tecno2016';
                $mail->Port = 25;
                
                
                
                /*
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = '4aa44a8666e48a';
                $mail->Password = '1cfbebc393a642';
                */
                
                // Specify main and backup server
                $mail->SetFrom('no_responder@tecnodatasa.cl');
                $mail->addAddress($email_to);  // Add a recipient

                //$mail->addAddress('darkcrisss@gmail.com');  // Add a recipient
                //$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
                $mail->isHTML(true);                                  // Set email format to HTML

                $body = '
                <strong>Nombre del evento: </strong>' . $_POST['evento_titulo'] . ' <br><br>
                <strong>Descripción del evento: </strong><br>' . $_POST['descripcion'] . ' <br><br>
                <strong>Tipo de evento: </strong> ' . getTipoEvento($_POST['evento_tipo']) . ' <br>
                <strong>Fecha/Hora Inicio:  </strong>' . formatDateEventos($_POST['evento_fechahora_termino']) . '<br>
                <strong>Fecha/Hora Termino: </strong>' . formatDateEventos($_POST['evento_fechahora_termino']) . '<br>
                <strong>Participantes:</strong> <br><br>
                ';

                foreach ($_POST['trabajador_id'] as $key => $trabajador_id) {
                    $body .= '&bull; ' . $db->where('id',$trabajador_id)->getValue('m_trabajador','email') . '<br>';
                }

                $body .= '<br><br>--<br>Correo enviado automáticamente. No responda a este correo';

                $body = utf8_decode($body);


                $mail->Subject = utf8_decode("Invitación a evento: " . $_POST['evento_titulo']);
                $mail->Body = $body; 

                /*
                if(!$mail->send()) {
                   echo 'Message could not be sent.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
                   exit;
                }
                */

                $datos = [
                    'mailto' => $email_to,
                    'subject' => utf8_decode("Invitación a evento: " . $_POST['evento_titulo']),
                    'body' => $body
                ];

                $sent = enviarMailExternalServer($datos);

            }


            if( count($error) == 0 ){
                $response = encrypt('status=success&mensaje=Evento creado correctamente &id='.$last_evento_insert);            
                redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
                exit();
            } else {
                echo "Hubo algunos errores insertando data";
                show_array($error,0);
            } 

        break;

        case 'editar_evento':

            $fecha_inicio_sql = formatDateEventos($_POST['evento_fechahora_inicio'],'db');
            $fecha_termino_sql = formatDateEventos($_POST['evento_fechahora_termino'],'db');

            $data_edit = [
                'fechaHoraInicio' => $fecha_inicio_sql,
                'fechaHoraTermino' => $fecha_termino_sql,
                'titulo' => $_POST['evento_titulo'],
                'descripcion' => $_POST['descripcion'],
                'tipoevento_id' => $_POST['evento_tipo'],
                'trabajador_id' => $_SESSION[PREFIX . 'login_uid']
            ];

            $db->where('id',$_POST['evento_id'])->update('m_evento',$data_edit);

            $db->where('evento_id',$_POST['evento_id'])->delete('m_participante_evento');
            foreach ($_POST['trabajador_id'] as $key => $trabajador_id) {
                $data_participantes = [
                    'evento_id' => $_POST['evento_id'],
                    'trabajador_id' => $trabajador_id,
                    'asistencia' => 0,
                    'confirmacion' => 0,
                    'nota' => '',
                ];
                $insert_participante = $db->insert('m_participante_evento',$data_participantes);
            }

            $response = encrypt('status=success&mensaje=Evento actualizado correctamente &id='.$last_evento_insert);
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();

        break;


        case 'ajax_get_evento':
            $evento = $db->where('id',$_POST['evento_id'])->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->getOne('m_evento');
            $evento['tipo_evento'] = getTipoEvento($evento['tipoevento_id']);
            
            $evento['fechaHoraInicioVista'] = formatDateEventos($evento['fechaHoraInicio'],'view');
            $evento['fechaHoraTerminoVista'] = formatDateEventos($evento['fechaHoraTermino'],'view');

            $db->join("m_participante_evento P", "P.trabajador_id = T.id");
            $db->where("P.evento_id", $_POST['evento_id']);
            $participantes = $db->get("m_trabajador T", null, ['T.email', 'T.id', 'T.nombres']);

            echo json_encode([
                'evento' => $evento,
                'participantes' => $participantes
            ]);
            exit();
        break;



        case 'ajax_delete_evento':
            $db->where('id',$_POST['evento_id'])->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->update('m_evento',['deleted_at'=>date('Y-m-d H:i:s')]);
            
            echo json_encode([
                'evento' => $_POST['evento_id']
            ]);
            exit();
        break;


        case 'ajax_restaurar_evento':
            $db->where('id',$_POST['evento_id'])->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->update('m_evento',['deleted_at' => null]);


            echo json_encode([
                'evento' => $_POST['evento_id']
            ]);
            exit();
        break;



        case 'tomar_asistencia':

            foreach ($_POST['asistencia'] as $trabajador_id => $asistencia) {
                $db->where('evento_id',$_POST['evento_id'])
                ->where('trabajador_id',$trabajador_id)
                ->update('m_participante_evento',[
                    'asistencia' => 1
                ]);
            }

            foreach ($_POST['notes'] as $trabajador_id => $nota) {
                $db->where('evento_id',$_POST['evento_id'])
                ->where('trabajador_id',$trabajador_id)
                ->update('m_participante_evento',[
                    'nota' => $nota
                ]);
            }

            $response = encrypt('status=success&mensaje=Asistencia ingresada correctamente&id='.$last_evento_insert);
            redirect(BASE_URL . '/evento/listar/response/' . $response );
            exit();

        break;


    }

}


if( $parametros ){

    $tipos_eventos = $db->get('m_tipoevento');

    $departamentos = $db->where('empresa_id',[2,11],'IN')->where('activo',1)->get('m_departamento');
    $trabajadores = $db->orderBy("apellidoPaterno","ASC")
    ->where ("deleted_at", NULL, 'IS')
    ->where ("tipocontrato_id", [3,4], 'NOT IN')
    ->where ("empresa_id", [2,11], 'IN')
    ->get("m_trabajador");
    

    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $afp = $db->getOne("m_evento");        
    }

    if( $parametros[0] == 'asistencia' ){
        if( $_GET['evento_id'] ){
            $evento_id = $_GET['evento_id'];

            $db->join("m_participante_evento P", "P.trabajador_id = T.id");
            $db->where("P.evento_id", $_GET['evento_id']);
            $participantes = $db->get("m_trabajador T", null, ['T.id', 'T.nombres', 'T.email','T.apellidoPaterno','T.apellidoMaterno']);
        
            $asistencias = $db->where('evento_id',$_GET['evento_id'])
            ->get('m_participante_evento');

        } else {
            redirect(BASE_URL.'/evento/listar');
            exit();
        }
    }


    if( $parametros[0] == 'invitaciones' ){

        $sql = "
        SELECT E.* FROM m_evento E, m_participante_evento P
        WHERE E.id = P.evento_id
        AND E.deleted_at IS NULL
        AND date(E.fechaHoraTermino) >= '" . date('Y-m-d') . "'
        AND P.trabajador_id = " . $_SESSION[PREFIX . 'login_uid'];
        $eventos = $db->rawQuery($sql);
        
        $all_invitaciones = [];
        foreach ($eventos as $key => $evento) {

            $db->join("m_participante_evento P", "P.trabajador_id = T.id");
            $db->where("P.evento_id", $evento['id']);
            $participantes = $db->get ("m_trabajador T", null, "T.email, T.id, T.nombres");

            $all_invitaciones[] = [
                'id' => $evento['id'],
                'fechaHoraInicio' => $evento['fechaHoraInicio'],
                'fechaHoraTermino' => $evento['fechaHoraTermino'],
                'titulo' => $evento['titulo'],
                'descripcion' => $evento['descripcion'],
                'tipoevento_id' => $evento['tipoevento_id'],
                'tipo_evento' => getTipoEvento($evento['tipoevento_id']),
                'participantes' => $participantes,
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

