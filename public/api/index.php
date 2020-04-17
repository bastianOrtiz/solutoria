<?php 

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

if( $action == 'api' && $entity == 'trabajador' ){

    if( $_POST['secret'] == md5('arriba los que luchan') ){

        if ($_POST['method'] == 'get_trabajador_data') {
            $rut_decrypted = $_POST['rut'];
            $db->where('rut',$rut_decrypted);
            $db->where('teletrabajo',1);
            $trabajador = $db->getOne('m_trabajador');

            if($trabajador):
                $db->where('id',$trabajador['empresa_id']);
                $empresa = $db->getOne('m_empresa');
                
                $array_trabajador = [
                    'found' => 1,
                    'id' => $trabajador['id'],
                    'nombres' => $trabajador['nombres'],
                    'apellidoPaterno' => $trabajador['apellidoPaterno'],
                    'apellidoMaterno' => $trabajador['apellidoMaterno'],
                    'rut' => $trabajador['rut'],
                    'email' => $trabajador['email'],
                    'empresa' => $empresa['nombre'],
                    'umbral' => $empresa['umbralRelojControl']
                ];
            else:
                $array_trabajador = [
                    'found' => 0
                ];
            endif;

            echo json_encode($array_trabajador);
            exit();
        }


        if ($_POST['method'] == 'set_trabajador_checkin') {
            $db->where('rut',$_POST['rut']);
            $trabajador = $db->getOne('m_trabajador');

            if($trabajador):

                $time = strtotime($_POST['checktime']);
                
                $array_data = [
                    'rut' => $_POST['rut'],
                    'checktime' => $_POST['checktime'],
                    'checktype' => $_POST['checktype']
                ];

                $last_id = $db->insert('m_relojcontrol_teletrabajo',$array_data);
                if( $last_id ):
                    $array_trabajador = [
                        'status' => 'ok',
                        'email' => $trabajador['email'],
                        'nombre' => $trabajador['nombres'] . ' ' . $trabajador['apellidoPaterno'] . ' ' . $trabajador['apellidoMaterno'],
                        'rut' => $trabajador['rut'],
                        'fecha' => date('d/M/Y',$time),
                        'hora' => date('H:i',$time)
                    ];
                else:
                    $array_trabajador = ['status' => 'error'];
                endif;
        
            endif;

            echo json_encode($array_trabajador);
            exit();
        }





    
    

        $rut_decrypted = base64_decode($_POST['id']);

        $db->where('rut',$rut_decrypted);
        $foto = $db->getValue('m_trabajador','foto');

        if( !$foto ){
            $base64 = 'data:image/png;base64,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';
        } else {
            $path = ROOT . '/private/uploads/images/' . $foto;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }


        $data = [
            'thumbnail' => $base64
        ];

        echo json_encode( $data );
    

    } else {
        echo json_encode(['msg' => 'no permitido']);
    }

    exit();
}


?>