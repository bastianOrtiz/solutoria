<?php
global $db;
$id_empresa = $_SESSION[PREFIX.'login_eid'];
$nombre_empresa = $_SESSION[PREFIX.'login_empresa'];

if( $_POST ){

    if( @$_POST['action'] == 'enviarEmpleados' ){
        crearTxt($_POST);
    }
    
    if( @$_POST['action'] == 'new' ){        
                   
    }    

    if( @$_POST['action'] == 'generar_archivo_previred' ){
        
        $lineas = $db->get('m_previred_paso');

        $total_reg = count($lineas);

        $uniqid = uniqid();
        $archivo = ROOT . "/private/uploads/docs/previred_" . $uniqid . ".txt"; // el nombre de tu archivo
        $fch = fopen($archivo, "a"); // Abres el archivo para escribir en él

        foreach ($lineas as $linea) {
            fwrite($fch, utf8_decode($linea['rut'].$linea['dv'].$linea['data']) );
        }

        fclose($fch); // Cierras el archivo.

        $empresa_name_sanitized = _sanitize_redirect( $_SESSION[PREFIX . 'login_empresa'] );
        $empresa_name_sanitized = str_replace(".","",$empresa_name_sanitized);

        // Headers for an download:
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="previred_' . $empresa_name_sanitized . '_REV_' . $uniqid . '.txt"');
        readfile($archivo);
        unlink($archivo);

        exit();
    }    


    if( $_POST['action'] == 'upload_previred' ){

        $upload = upload_doc('archivo_previred',ROOT.'/private/uploads/docs/');

        if( $upload['status'] == true ){

            $lines = file(ROOT.'/private/uploads/docs/' . $upload['filename']);
            unlink(ROOT.'/private/uploads/docs/' . $upload['filename']);

            $db->delete('m_previred_paso');

            $i = 1;
            foreach ($lines as $line) {
                $linea = 'linea_' . $i;
                $rut = substr($line, 0, 11);
                $dv = substr($line, 11, 1);
                $data = substr($line, 12,strlen($line));

                $data_array = [
                    'linea' => $linea,
                    'rut' => $rut,
                    'dv' => $dv,
                    'data' => utf8_encode($data)
                ];
                $id = $db->insert('m_previred_paso', $data_array);

                $i++;
            }
            redirect(BASE_URL . '/previred/revisor');
            exit();
        }
    }

}   

if( $parametros ){

    $CantidadMostrar = 30;
                        // Validado de la variable GET
    $compag         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
    $TotalReg       = $db->get('m_previred_paso');
    //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
    $TotalRegistro  = ceil(count($TotalReg) / $CantidadMostrar);

    //Consulta SQL
    $consultavistas = "SELECT * FROM m_previred_paso LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
    $consulta = $db->rawQuery($consultavistas);

    //Operacion matematica para botón siguiente y atrás 
    $IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):1;
    $DecrementNum =(($compag -1))<1?1:($compag -1);

    $paginacion =  '<ul class="pagination"><li><a href="?pag=' . $DecrementNum . '" data-toggle="tooltip" title="Página Anterior"><i class="fa fa-angle-left"></i></a></li>';

    //Se resta y suma con el numero de pag actual con el cantidad de 
    //números  a mostrar
     $Desde=$compag-(ceil($CantidadMostrar/2)-1);
     $Hasta=$compag+(ceil($CantidadMostrar/2)-1);
     
     //Se valida
     $Desde=($Desde<1)?1: $Desde;
     $Hasta=($Hasta<$CantidadMostrar)?$CantidadMostrar:$Hasta;
     //Se muestra los números de paginas
     for($i=$Desde; $i<=$Hasta;$i++){
        //Se valida la paginacion total
        //de registros
        if($i<=$TotalRegistro){
            //Validamos la pag activo
          if($i==$compag){
           $paginacion .= "<li class=\"active\"><a href=\"?pag=".$i."\">".$i."</a></li>";
          }else {
            $paginacion .= "<li><a href=\"?pag=".$i."\">".$i."</a></li>";
          }             
        }
     }
    $paginacion .= '<li><a href="?pag=' . $IncrimentNum . '" data-toggle="tooltip" title="Página Siguiente"><i class="fa fa-angle-right"></i></a></li></ul>';

    if( $consulta ):
        $revisor = [];
        foreach ($consulta as $result) {
            $revisor[] = [
                'data' => $result['rut'] . $result['dv'] . $result['data'],
                'linea' => $result['linea']
            ];
        }
    endif;



    if ($_POST) {
        $empleados = buscarEmpleados($id_empresa, $_POST['mesAtraso'], $_POST['anoAtraso']);
    }
    $periodoDesde = getMesMostrarCorte().getAnoMostrarCorte(); 
    $periodoHasta = getMesMostrarCorte().getAnoMostrarCorte();
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

