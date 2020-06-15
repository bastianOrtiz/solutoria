<?php

if( $_POST ){
    
    if( $_POST['action'] == 'upload_dat' ){
        
        $stamp_ini = strtotime($_POST['fechaInicioRango']);
        $stamp_fin = strtotime($_POST['fechaFinRango']);


        $upload = upload_doc('archivo_dat',ROOT.'/private/uploads/docs/');
        
        if( $upload['status'] == true ){
            
            $lines = file(ROOT.'/private/uploads/docs/' . $upload['filename']);

            if( $lines ){
                
                for($i=$stamp_ini; $i<=$stamp_fin; $i+=86400){
                    
                    $dia_a_consultar = date('Y-m-d',$i);
                    
                    $db->where ("checktime", $dia_a_consultar.'%', 'like');
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
    
                        if( $parts[2] == $dia_a_consultar ){
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

            unlink(ROOT.'/private/uploads/docs/' . $upload['filename']);
            
        }



        // Proceso para agregar los marcajes por teletrabajo
        $db->where('cast(checktime as date)',[$_POST['fechaInicioRango'],$_POST['fechaFinRango']], 'BETWEEN');
        $rango_teletrabajo = $db->get('m_relojcontrol_teletrabajo');
        
        foreach ($rango_teletrabajo as $key => $value) {
            $db->where('rut',$value['rut']);
            $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
            $reloj_id = $db->getValue('m_trabajador','relojcontrol_id');
            $dataInsert = [
                'checktime' => $value['checktime'],
                'userid' => $reloj_id,
                'checktype' => $value['checktime'],
                'logid' => 0
            ];
            $db->insert('m_relojcontrol',$dataInsert);
        }



        $response = encrypt('status=success&mensaje=Datos importados correctamente&id=0');
        redirect(BASE_URL . '/' . $entity . '/upload/response/' . $response );
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

