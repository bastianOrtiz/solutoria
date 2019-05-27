<?php

if( $_POST ){
    echo "POST OK";
    exit();

    if( $_POST['action'] == 'upload_dat' ){
        
        $dia_a_consultar = '2019-05-27';
        
        $upload = upload_doc('archivo_dat',ROOT.'/private/uploads/docs/');
        
        if( $upload['status'] == true ){
            
            $lines = file(ROOT.'/private/uploads/docs/' . $upload['filename']);

            if( $lines ){

                //$db->where ("checktime", $dia_a_consultar.'%', 'like');
                $db->delete('m_relojcontrol');
                
                foreach ($lines as $key => $value) {

                    $parts = preg_split('/\s+/', $value);
                    /*
                    $parts[0] = N/A
                    $parts[1] = UserID (Asociado al campo m_trabajador.relojcontrol_id)
                    $parts[2] = Fecha de Marcado
                    $parts[3] = Hora de Marcado
                    $parts[4] = N/A
                    $parts[5] = 0 = Entrada / 1 = Salida
                    $parts[6] = N/A
                    $parts[7] = N/A
                    $parts[8] = N/A
                    */

                    //if( $parts[2] == $dia_a_consultar ){
                    if( 1==1 ){
                        // Verificar si el dato existe en la BD
                        $db->where('checktime',$parts[2].' '.$parts[3]);
                        $db->where('userid',$parts[1]);
                        $exist = $db->getOne('m_relojcontrol');

                        if( !$exist ){
                            $checktype = '';
                            if( $parts[5] == 0 ){
                                $checktype = 'I';
                            } else {
                                $checktype = 'O';
                            }
                            $dataInsert = [
                                'checktime' => $parts[2].' '.$parts[3],
                                'userid' => $parts[1],
                                'checktype' => $checktype,
                                'logid' => 0
                            ];
                            $db->insert('m_relojcontrol',$dataInsert);
                        }
                    }
                }
            }
        }

        redirect(BASE_URL.'/importar_relojcontrol/upload', 302, false, 'Datos importados correctamente');
        exit();

    }
}

if( $parametros ){
    /** Consultar datos de horario **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $db->where ("empresa_id", $_SESSION[PREFIX.'login_eid']);
        $horario = $db->getOne("m_horario");        
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

