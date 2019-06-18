<?php

function buscarEmpleados($id_empresa){
    global $db;

    $super_arreglo = [];

    $db->where("empresa_id", $id_empresa);
    //$db->where("apellidoPaterno","FARIAS");
    $empleados = $db->get("m_trabajador");

    return $empleados;
    /*$id = $db->insert('m_afp', $data_array);
    if( $id ){
        return $id;
    } else {
        return false;
    }*/
}

function crearTxt($post){
    global $db;

    $empleados = [];
    foreach ($post['rut'] as $key => $empleado) {
       $empleados[] = [
            'rut'=>$key,
            'id'=>$post["id"][$key],
            'apellidoPaterno'=> $post["apellidoPaterno"][$key],
            'apellidoMaterno'=> $post["apellidoMaterno"][$key],
            'nombre'=> $post["nombres"][$key],
            'sexo'=> $post["sexo"][$key],
            'idNacionalidad'=> $post["nacionalidad"][$key],
            'tipo_pago' => $post["tipo_pago"][$key],
            'periodoDesde' => $post["periodoDesde"][$key],
            'periodoHasta' => $post["periodoHasta"][$key],
            'tipo_trabajador' => $post["tipo_trabajador"][$key],
       ];
    }
    $archivo= ROOT."/private/uploads/docs/previred.txt"; // el nombre de tu archivo
    $empleados= $empleados; // Recibez el formulario
    $fch= fopen($archivo, "w"); // Abres el archivo para escribir en él
    foreach ($empleados as $empleado) {

        $separador = explode("-",$empleado["rut"]);
        $rut = rellenar($separador[0], 11, "i");
        fwrite($fch, $rut); // Grabas

        $dv = $separador[1];
        $dv = rellenar($dv, 1, "s");
        fwrite($fch, $dv); // Grabas

        $apellidoPater = utf8_decode($empleado["apellidoPaterno"]);
        $apellidoPaterno = rellenar($apellidoPater, 30, "s");
        fwrite($fch, $apellidoPaterno); // Grabas

        $apellidoMater = utf8_decode($empleado["apellidoMaterno"]);
        $apellidoMaterno = rellenar($apellidoMater, 30, "s");
        fwrite($fch, $apellidoMaterno); // Grabas

        $nombres = rellenar($empleado["nombre"], 30, "s");
        fwrite($fch, $nombres); // Grabas

        if ($empleado["sexo"] == 1) {
            $empleado_sexo = rellenar("M",1,"s");
            fwrite($fch, $empleado_sexo); // Grabas
        }else{
            $empleado_sexo = rellenar("F",1,"s");
            fwrite($fch, $empleado_sexo); // Grabas
        }

        if ($empleado["idNacionalidad"] = 46) {
            $nacionalidad = rellenar("0",1,"i");
            fwrite($fch, $nacionalidad); // Grabas
        }else{
            $nacionalidad = rellenar("1",1,"i");
            fwrite($fch, $nacionalidad); // Grabas
        }

        $tipo_pago = rellenar("01",2,"i");
        fwrite($fch, $tipo_pago); // Grabas

        $periodoDesde = date("m").date("Y");
        $periodoDesde = rellenar($periodoDesde,6,"i");
        fwrite($fch, $periodoDesde); // Grabas

        $periodoHasta = date("m").date("Y");
        $periodoHasta = rellenar($periodoHasta,6,"i");
        fwrite($fch, $periodoHasta); // Grabas

        $tip_afp = previTrabajador($empleado["tipo_trabajador"]);
        if ($tip_afp["id"] !== 7) {
            $tip_afp = rellenar("AFP",3,"s");
            fwrite($fch, $tip_afp); // Grabas
        }else{
            $tip_afp = rellenar("INP",3,"s");
            fwrite($fch, $tip_afp); // Grabas
        }

        $tipo_trabajador = tipoEmpleado($empleado["tipo_trabajador"]);
        if ($tipo_trabajador["id"] == 1 || $tipo_trabajador["id"] == 5 || $tipo_trabajador["id"] == 6 || $tipo_trabajador["id"] == 7) {
            $tip_trabajador = rellenar("0",1,"i");
            fwrite($fch, $tip_trabajador); // Grabas
        }elseif ($tipo_trabajador["id"] == 2 || $tipo_trabajador["id"] == 8) {
            $tip_trabajador = rellenar("1",1,"i");
            fwrite($fch, $tip_trabajador); // Grabas
        }elseif ($tipo_trabajador["id"] == 4 || $tipo_trabajador["id"] == 3) {
            $tip_trabajador = rellenar("2",1,"i");
            fwrite($fch, $tip_trabajador); // Grabas
        }

        $dias_trabajados = getDiasTrabajados($empleado["id"]);
        $dias_trabajados = rellenar($dias_trabajados,2,"i");
        fwrite($fch, $dias_trabajados); // Grabas

        $tipo_linea = "00";
        $tipo_linea = rellenar($tipo_linea,2,"s");
        fwrite($fch, $tipo_linea); // Grabas

        fwrite($fch, PHP_EOL);
    }
    fclose($fch); // Cierras el archivo.
}

/**
 * Rellena con cero o espacios dependiendo del tipo de datos
 * @param (string) $dato dato que desea rellenar
 * @param (int) $largo largo del campo     
 * @return (string) $tipo tipo "s" si es string y tipo "i" si es int para diferenciar el proceso  
 */
function rellenar($dato, $largo, $tipo){
    $largoDato = strlen($dato);
    $diferenciaLargo = $largo - $largoDato;

    if ($tipo == "i") {
        $temp = "";
        for ($i=0; $i < $diferenciaLargo; $i++) {
            $temp.="0";
        }
        $dato = $temp.$dato;
    }else{
        for ($i=0; $i < $diferenciaLargo; $i++) { 
            $dato.=" ";
        }
    }
    
    return $dato;

}

function editarAfp($afp_id, $data_array){
    global $db;
    $db->where ("id", $afp_id);                    
    if($db->update('m_afp', $data_array))
        return true;
    else 
        return false;
}

function eliminarAfp( $afp_id ){
    global $db;
    $db->where('id', $afp_id);
        
    if($db->delete('m_afp')){
        return true;    
    } else {
        return false;
    }    
}

?>