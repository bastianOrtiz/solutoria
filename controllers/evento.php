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

            $last_evento_insert = $db->insert('m_evento',$data_insert);


            $error = [];
            foreach ($_POST['trabajador_id'] as $key => $trabajador_id) {
                $data_participantes = [
                    'evento_id' => $last_evento_insert,
                    'trabajador_id' => $trabajador_id,
                    'asistencia' => 0,
                    'confirmacion' => 0,
                    'nota' => ''
                ];
                $insert_participante = $db->insert('m_participante_evento',$data_participantes);
                show_array($db->getLastQuery(),0);
                show_array($db->getLastError(),0);
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
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = '4aa44a8666e48a';
                $mail->Password = '1cfbebc393a642';
                                      // Specify main and backup server
                $mail->SetFrom('contacto@tecnodatasa.cl', 'Tecnodata S.A.');
                $mail->addAddress($email_to);  // Add a recipient
                $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
                $mail->isHTML(true);                                  // Set email format to HTML

                $location           = "Stardestroyer-013";
                $date               = '20151216';
                $startTime          = '0800';
                $endTime            = '0900';
                $subject            = 'Millennium Falcon';
                $desc               = 'This email is a reminder for you. Please accept!';

                $organizer          = 'Darth Vader';

                $organizer_email    = 'contacto@tecnodatasa.cl';   
                $participant_name_1 = 'Angelo TErrile';
                $participant_email_1= $email_to;

                $text = "BEGIN:VCALENDAR\r\n
                VERSION:2.0\r\n
                PRODID:-//Deathstar-mailer//theforce/NONSGML v1.0//EN\r\n
                METHOD:REQUEST\r\n
                BEGIN:VEVENT\r\n
                UID:" . md5(uniqid(mt_rand(), true)) . "example.com\r\n
                DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\r\n
                DTSTART:".$date."T".$startTime."00Z\r\n
                DTEND:".$date."T".$endTime."00Z\r\n
                SUMMARY:".$subject."\r\n
                ORGANIZER;CN=".$organizer.":mailto:".$organizer_email."\r\n
                LOCATION:".$location."\r\n
                DESCRIPTION:".$desc."\r\n
                ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN".$participant_name_1.";X-NUM-GUESTS=0:MAILTO:".$participant_email_1."\r\n
                END:VEVENT\r\n
                END:VCALENDAR\r\n";

                $headers = "From: Sender\n";
                $headers .= "Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n";
                $headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n";
                $mail->Subject = "nuevo evento";
                $mail->Body = $desc; 
                $mail->AltBody = $text;
                $mail->Ical = $text;


                if(!$mail->send()) {
                   echo 'Message could not be sent.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
                   exit;
                }

                echo 'Message has been sent';



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
            $db->where('id',$_POST['evento_id'])->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->update('m_evento',['deleted_at'=>date('Y-m-d H:is')]);

            echo json_encode([
                'evento' => $_POST['evento_id']
            ]);
            exit();
        break;


        case 'ajax_restaurar_evento':
            $db->where('id',$_POST['evento_id'])->where('trabajador_id',$_SESSION[ PREFIX . 'login_uid'])->update('m_evento',['deleted_at'=>null]);

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

    $tipos_eventos = [
        ['id'=>1,'nombre'=>'Reunión'],
        ['id'=>2,'nombre'=>'Capacitacion'],
        ['id'=>3,'nombre'=>'Pendientes']
    ];

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

