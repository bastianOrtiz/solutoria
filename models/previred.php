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

function sqlTramoCarga() {
    global $db;
    
    $super_array = [];

/*-------------- Comienzo SQL de tramo A ----------------*/
    
    $db->where("tramoCargas", "A");
    $resultadosTramoA = $db->get("t_prevision");
    
    $ids_trabajadores_resultadoTramoA = [];
    $datos_retorno_resultadoTramoA = [];
    
    foreach($resultadosTramoA as $rta){
        $ids_trabajadores_resultadoTramoA[] = $rta["trabajador_id"];
        $datos_retorno_resultadoTramoA[$rta["trabajador_id"]] = [
            'tramoCargas' => $rta["tramoCargas"],
            'cargasMaternales' => $rta["cargasMaternales"],
            'cargasSimples' => $rta["cargasSimples"],
            'cargasInvalidez' => $rta["cargasInvalidez"]
        ];
    }
    
    $super_array["tramo_a"] = [
        'ids' => $ids_trabajadores_resultadoTramoA,
        'datos' => $datos_retorno_resultadoTramoA
    ];
    
/*-------------- Comienzo SQL de tramo B ----------------*/
    
    $db->where("tramoCargas", "B");
    $resultadosTramoB = $db->get("t_prevision");
    
    $ids_trabajadores_resultadoTramoB = [];
    $datos_retorno_resultadoTramoB = [];
    
    foreach($resultadosTramoB as $rtb){
        $ids_trabajadores_resultadoTramoB[] = $rtb["trabajador_id"];
        $datos_retorno_resultadoTramoB[$rtb["trabajador_id"]] = [
            'tramoCargas' => $rtb["tramoCargas"],
            'cargasMaternales' => $rtb["cargasMaternales"],
            'cargasSimples' => $rtb["cargasSimples"],
            'cargasInvalidez' => $rtb["cargasInvalidez"]
        ];
    }
    
    $super_array["tramo_b"] = [
        'ids' => $ids_trabajadores_resultadoTramoB,
        'datos' => $datos_retorno_resultadoTramoB
    ];
    
/*-------------- Comienzo SQL de tramo C ----------------*/
    
    $db->where("tramoCargas", "C");
    $resultadosTramoC = $db->get("t_prevision");
    
    $ids_trabajadores_resultadoTramoC = [];
    $datos_retorno_resultadoTramoC = [];
    
    foreach($resultadosTramoC as $rtc){
        $ids_trabajadores_resultadoTramoC[] = $rtc["trabajador_id"];
        $datos_retorno_resultadoTramoC[$rtc["trabajador_id"]] = [
            'tramoCargas' => $rtc["tramoCargas"],
            'cargasMaternales' => $rtc["cargasMaternales"],
            'cargasSimples' => $rtc["cargasSimples"],
            'cargasInvalidez' => $rtc["cargasInvalidez"]
        ];
    }
    
    $super_array["tramo_c"] = [
        'ids' => $ids_trabajadores_resultadoTramoC,
        'datos' => $datos_retorno_resultadoTramoC
    ];
    
/*-------------- Comienzo SQL de tramo D ----------------*/
    
    $db->where("tramoCargas", "D");
    $resultadosTramoD = $db->get("t_prevision");
    
    $ids_trabajadores_resultadoTramoD = [];
    $datos_retorno_resultadoTramoD = [];
    
    foreach($resultadosTramoD as $rtd){
        $ids_trabajadores_resultadoTramoD[] = $rtd["trabajador_id"];
        $datos_retorno_resultadoTramoD[$rtd["trabajador_id"]] = [
            'tramoCargas' => $rtd["tramoCargas"],
            'cargasMaternales' => $rtd["cargasMaternales"],
            'cargasSimples' => $rtd["cargasSimples"],
            'cargasInvalidez' => $rtd["cargasInvalidez"]
        ];
    }
    
    $super_array["tramo_d"] = [
        'ids' => $ids_trabajadores_resultadoTramoD,
        'datos' => $datos_retorno_resultadoTramoD
    ];
    
    return $super_array;
}

function tieneTramo($trabajador_id, $super_array){
    
    $array_return = [
        'tipo_tramo' => "D",
        'cargas' => [
            'cargasMaternales' => 0,
            'cargasSimples' => 0,
            'cargasInvalidez' => 0
        ]
    ];
    
/*---------- Tipo A ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_a"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_a"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["licencias"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["licencias"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["licencias"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }

/*---------- Tipo B ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_b"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_b"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["licencias"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["licencias"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["licencias"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }
    
/*---------- Tipo C ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_c"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_c"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["licencias"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["licencias"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["licencias"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }
    
/*---------- Tipo D ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_d"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_d"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["licencias"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["licencias"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["licencias"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }
    
    return $array_return;
}

function tramoAsignacion($id_trabajador) {
    global $db;
    
    $db->where("trabajador_id", $id_trabajador);
    $tramo_trabajador = $db->get("tramoCargas");
    
    return $tramo_trabajador;
}

function obtenerDiasLicencia($mes = "", $ano = ""){
    global $db;

    $arreglo_licencia = [];

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("mes", $mes);
    $db->where("ano", $ano);
    $db->where("diaLicencia",0,">");
    $dias_licencia = $db->get("liquidacion",null,"trabajador_id");

    foreach ($dias_licencia as $licencia) {
        $arreglo_licencia[] = $licencia["trabajador_id"];
    }

    show_array($arreglo_licencia);

    return $arreglo_licencia;
}

function sqlLiquidacion($mes = "", $ano = ""){
    global $db;

    $ids_trabajadores_liquidacion = [];
    $datos_retorno_liquidacion = [];
    $super_array = [];

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("mes", $mes);
    $db->where("ano", $ano);
    $liquidaciones = $db->get("liquidacion");
    foreach ($liquidaciones as $liquidacion) {
        $ids_trabajadores_liquidacion[] = $liquidacion["trabajador_id"];
        $datos_retorno_liquidacion[$liquidacion["trabajador_id"]] = [
            'totalImponible' => $liquidacion["totalImponible"],
            'afpMonto' => $liquidacion["afpMonto"],
            'sis' => $liquidacion["sis"],
            'cuenta2Monto' => $liquidacion["cuenta2Monto"]
        ];
    }

    $super_array["liquidaciones"] = [
        'ids' => $ids_trabajadores_liquidacion,
        'datos' => $datos_retorno_liquidacion
    ];
    return $super_array;
}

function tieneImponible($trabajador_id, $super_array){
    $array_return = [
        'monto' => 0,
        'cotizacion' => 0,
        'sis' => 0,
        'cuenta2Monto' => 0
    ];

    if (in_array($trabajador_id, $super_array["liquidaciones"]["ids"])) {
        $array_return = [
            'monto' => $super_array["liquidaciones"]["datos"][$trabajador_id]["totalImponible"],
            'cotizacion' => $super_array["liquidaciones"]["datos"][$trabajador_id]["afpMonto"],
            'sis' => $super_array["liquidaciones"]["datos"][$trabajador_id]["sis"],
            'cuenta2Monto' => $super_array["liquidaciones"]["datos"][$trabajador_id]["cuenta2Monto"]
        ];
    }

    return $array_return;
}

function getCodigoAfp($trabajador_id){
    global $db;

    $db->join("m_afp AFP", "P.afp_id=AFP.id");
    $db->where("P.trabajador_id",$trabajador_id);
    $results = $db->getOne("t_prevision P", "AFP.codigo");

    return $results;
}

function crearTxt($post){
    global $db;

    $super_array = sqlMovimientos();
    $super_arreglo = sqlTramoCarga();
    $arreglo_asignacion_familiar = sqlAsignacionFamiliar();
    $arreglo_asignacion_familiar_retroactiva = sqlAsignacionFamiliarRetroactiva();
    $arreglo_ids_licencia = obtenerDiasLicencia();
    $arreglo_liquidaciones = sqlLiquidacion();
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

        $tip_afp = previTrabajador($empleado["id"]);
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

        $movimiento = tieneMovimientos($empleado["id"],$super_array);
        $codigo_movimiento = rellenar($movimiento["codigo_movimiento"],2,"i");
        fwrite($fch, $codigo_movimiento); // Grabas

        if ($movimiento["fechas_limites"]["fecha_inicio"] == "") {
            $fecha_formateada_inicio = rellenar($movimiento["fechas_limites"]["fecha_inicio"],10,"s");
        }else{
            $separador_fecha_inicio = explode("-",$movimiento["fechas_limites"]["fecha_inicio"]);
            $fecha_formateada_inicio = $separador_fecha_inicio[2]."-".$separador_fecha_inicio[1]."-".$separador_fecha_inicio[0];
            $fecha_formateada_inicio = rellenar($fecha_formateada_inicio,10,"s");
        }
        fwrite($fch, $fecha_formateada_inicio); // Grabas

        if ($movimiento["fechas_limites"]["fecha_fin"] == "") {
            $fecha_formateada_fin = rellenar($movimiento["fechas_limites"]["fecha_fin"],10,"s");
        }else{
            $separador_fecha_fin = explode("-",$movimiento["fechas_limites"]["fecha_fin"]);
            $fecha_formateada_fin = $separador_fecha_fin[2]."-".$separador_fecha_fin[1]."-".$separador_fecha_fin[0];
            $fecha_formateada_fin = rellenar($fecha_formateada_fin,10,"s");
        }
        fwrite($fch, $fecha_formateada_fin); // Grabas
        
        $asignacion = tieneTramo($empleado["id"],$super_arreglo);
        $tramo = rellenar($asignacion["tipo_tramo"],1,"s");
        fwrite($fch, $tramo); // Grabas
        
        $num_cargas_simples = rellenar($asignacion["cargas"]["cargasSimples"],2,"i");
        fwrite($fch, $num_cargas_simples); // Grabas
        
        $num_cargas_maternales = rellenar($asignacion["cargas"]["cargasMaternales"],2,"i");
        fwrite($fch, $num_cargas_maternales); // Grabas
        
        $num_cargas_invalidas = rellenar($asignacion["cargas"]["cargasInvalidez"],2,"i");
        fwrite($fch, $num_cargas_invalidas); // Grabas

        $asig_familiar = tieneAsignacion($empleado["id"],$arreglo_asignacion_familiar);
        $monto_asignacion = $asig_familiar["monto"];
        $monto = rellenar($monto_asignacion,6,"i");
        fwrite($fch, $monto); // Grabas

        $asig_familiar_retroactiva = tieneAsignacion($empleado["id"],$arreglo_asignacion_familiar_retroactiva);
        $monto_asignacion_retroactiva = $asig_familiar_retroactiva["monto"];
        $monto_retroactiva = rellenar($monto_asignacion_retroactiva,6,"i");
        fwrite($fch, $monto_retroactiva); // Grabas

        $reintegro_cargas_familiares = 0;
        $monto_reintegro_cargas_familiares = rellenar($reintegro_cargas_familiares,6,"i");
        fwrite($fch, $monto_reintegro_cargas_familiares); // Grabas

        $licencia = obtenerDiasLicencia($empleado["id"]);
        $dias_de_licencia = rellenar($licencia,1,"s");

        if (in_array($empleado["id"], $arreglo_ids_licencia)) {
            fwrite($fch, "S"); // Grabas
        }else{
            fwrite($fch, "N"); // Grabas
        }

        $codigo_afp = getCodigoAfp($empleado["id"]);
        $codigo_afp_convertido = leadZero($codigo_afp["codigo"]);
        $codigo_afp_rellenar = rellenar($codigo_afp_convertido,2,"i");
        fwrite($fch, $codigo_afp_rellenar); // Grabas

        $imponible = tieneImponible($empleado["id"],$arreglo_liquidaciones);
        $montoImponible = rellenar($imponible["monto"],8,"i");
        fwrite($fch, $montoImponible); // Grabas
        $monto_obligatorio_afp = rellenar($imponible["cotizacion"],8,"i");
        fwrite($fch, $monto_obligatorio_afp); // Grabas
        $monto_sis = rellenar($imponible["sis"],8,"i");
        fwrite($fch, $monto_sis); // Grabas
        $cuenta2Monto = rellenar($imponible["cuenta2Monto"],8,"i");
        fwrite($fch, $cuenta2Monto); // Grabas
        $renta_imp_sust_afp = rellenar(0,8,"i");
        fwrite($fch, $renta_imp_sust_afp); // Grabas
        $tasa_pactada = rellenar(0,5,"i");
        fwrite($fch, $tasa_pactada); // Grabas
        $aporte_indemn = rellenar(0,9,"i");
        fwrite($fch, $aporte_indemn); // Grabas
        $n_periodos = rellenar(0,2,"i");
        fwrite($fch, $n_periodos); // Grabas
        $periodo_desde = rellenar("",10,"s");
        fwrite($fch, $periodo_desde); // Grabas
        $periodo_hasta = rellenar("",10,"s");
        fwrite($fch, $periodo_hasta); // Grabas
        $puesto_trabajo_pesado = rellenar("",40,"s");
        fwrite($fch, $puesto_trabajo_pesado); // Grabas
        $porcentaje_cotizacion_trabajo_pesado = rellenar(0,5,"i");
        fwrite($fch, $porcentaje_cotizacion_trabajo_pesado); // Grabas
        $cotizacion_trabajo_pesado = rellenar(0,6,"i");
        fwrite($fch, $cotizacion_trabajo_pesado); // Grabas

        fwrite($fch, PHP_EOL);
    }
    fclose($fch); // Cierras el archivo.

    // Headers for an download:
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="previred.txt"');
    readfile($archivo);
    exit();
}

function sql_ausencia($mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = getAnoMostrarCorte();
    }

    $sql = "
    SELECT *
    FROM t_ausencia
    WHERE month(fecha_inicio) = $mes
    AND year(fecha_inicio) = $ano
    ";

    $results= $db->rawQuery($sql);

    $ids_sql_ausencia = [];
    $datos_retorno_sql_ausencia = [];
    foreach ($results as $result) {
        $ids_sql_ausencia[] = $result["trabajador_id"];
        $datos_retorno_sql_ausencia[$result["trabajador_id"]] = [
            'todo' => $result
        ];
    }

    $super_array["ausencia"] = [
        'trabajadores_ids' => $ids_sql_ausencia,
        'datos' => $datos_retorno_sql_ausencia
    ];

    return $super_array;
}

function tieneAusencia($trabajador_id, $super_array){

    show_array($super_array);
    $array_return = [
        'todo' => 0
    ];

    if (in_array($trabajador_id, $super_array["ausencia"]["trabajadores_ids"])) {
        $array_return = [
            'todo' => $super_array["ausencia"]["datos"][$trabajador_id]["todo"]
        ];
    }

    show_array($array_return);

    return $array_return;
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

function sqlAsignacionFamiliar($mes = "", $ano = ""){
    global $db;

    $super_array = [];

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

/*---------- Asignacion Familiar -----------*/
    $sql = "
    SELECT 
        L.mes,
        L.ano,            
        T.rut,
        T.id,
        CONCAT(T.apellidoPaterno,' ',T.apellidoMaterno,' ',T.nombres) AS nombreCompleto,
        H.nombre,
        LH.monto
    FROM m_haber H, l_haber LH, m_trabajador T, liquidacion L
    WHERE LH.liquidacion_id = L.id
    AND L.trabajador_id = T.id
    AND LH.haber_id = H.id
    AND H.id = 20
    AND T.empresa_id = " . $_SESSION[PREFIX.'login_eid'] . "
    AND L.mes = $mes
    AND L.ano = $ano
    ";

    $results= $db->rawQuery($sql);

    $ids_asignacion_familiar = [];
    $datos_retorno_asignacion_familiar = [];
    foreach ($results as $result) {
        $ids_asignacion_familiar[] = $result["id"];
        $datos_retorno_asignacion_familiar[$result["id"]] = [
            'monto' => $result["monto"]
        ];
    }

    $super_array["asignacion_familiar"] = [
        'ids' => $ids_asignacion_familiar,
        'datos' => $datos_retorno_asignacion_familiar
    ];



    return $super_array;
}

function sqlAsignacionFamiliarRetroactiva($mes = "", $ano = ""){

    global $db;

    $super_array = [];

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

/*---------- Asignacion Familiar Retroactiva -----------*/
    $sql = "
    SELECT 
        L.mes,
        L.ano,            
        T.rut,
        T.id,
        CONCAT(T.apellidoPaterno,' ',T.apellidoMaterno,' ',T.nombres) AS nombreCompleto,
        H.nombre,
        LH.monto
    FROM m_haber H, l_haber LH, m_trabajador T, liquidacion L
    WHERE LH.liquidacion_id = L.id
    AND L.trabajador_id = T.id
    AND LH.haber_id = H.id
    AND H.id = 56
    AND T.empresa_id = " . $_SESSION[PREFIX.'login_eid'] . "
    AND L.mes = $mes
    AND L.ano = $ano
    ";

    $results= $db->rawQuery($sql);

    $ids_asignacion_familiar_retroactiva = [];
    $datos_retorno_asignacion_familiar_retroactiva = [];
    foreach ($results as $result) {
        $ids_asignacion_familiar_retroactiva[] = $result["id"];
        $datos_retorno_asignacion_familiar_retroactiva[$result["id"]] = [
            'monto' => $result["monto"]
        ];
    }

    $super_array["asignacion_familiar_retroactiva"] = [
        'ids' => $ids_asignacion_familiar_retroactiva,
        'datos' => $datos_retorno_asignacion_familiar_retroactiva
    ];

    return $super_array;
}

function tieneAsignacion($trabajador_id, $super_array){


    $array_return = [
        'monto' => 0
    ];

    if (in_array($trabajador_id, $super_array["asignacion_familiar"]["ids"])) {
        $array_return = [
            'monto' => $super_array["asignacion_familiar"]["datos"][$trabajador_id]["monto"]
        ];
    }

    if (in_array($trabajador_id, $super_array["asignacion_familiar_retroactiva"]["ids"])) {
        $array_return = [
            'monto' => $super_array["asignacion_familiar"]["datos"][$trabajador_id]["monto"]
        ];
    }

    return $array_return;
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

function sqlMovimientos($mes = "", $year = ""){
    global $db;

    $super_array = [];

    if ($mes == "") {
        $mes = getMesMostrarCorte();
    }

    if ($year == "") {
        $year = getAnoMostrarCorte();
    }

    $array_tipo_movimiento = 0;
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin, T.id
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin != '0000-00-00'
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $inicio_plazo_fijo_mes = $db->rawQuery( $sql ); 

    $ids_inicio_plazo_fijo_mes = [];
    $datos_retorno_inicio_plazo_fijo_mes = [];
    foreach ($inicio_plazo_fijo_mes as $ipfm) {
        $ids_inicio_plazo_fijo_mes[] = $ipfm["id"];
        $datos_retorno_inicio_plazo_fijo_mes[$ipfm["id"]] = [
            'fecha_inicio' => $ipfm["fechaContratoInicio"],
            'fecha_fin' => $ipfm["fechaContratoFin"]
        ];
    }

    $super_array["inicio_plazo_fijo_mes"] = [
        'ids' => $ids_inicio_plazo_fijo_mes,
        'datos' => $datos_retorno_inicio_plazo_fijo_mes
    ];
       

    $licencias = [];
    $this_year = strtotime(date('Y-m-d'));
    $un_ano_atras = ($this_year - 31536000);
    $un_ano_atras = date('Y-m-d',$un_ano_atras);
    $sql = "
    SELECT 
    concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres) AS nombre,
    TA.trabajador_id,
    TA.fecha_inicio,
    TA.fecha_fin
    FROM t_ausencia TA, m_trabajador T
    where TA.ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 ) 
    AND T.empresa_id = 2
    AND T.id = TA.trabajador_id
    AND TA.fecha_fin > '$un_ano_atras'
    ";
    $all_licencias = $db->rawQuery( $sql ); 

    foreach ($all_licencias as $licencia) {
        
        $int_fecha_inicio_licencia = explode("-",$licencia['fecha_inicio']);
        $int_fecha_inicio_licencia = $int_fecha_inicio_licencia[0].$int_fecha_inicio_licencia[1].$int_fecha_inicio_licencia[2];
        
        $int_fecha_fin_licencia = explode("-",$licencia['fecha_fin']);
        $int_fecha_fin_licencia = $int_fecha_fin_licencia[0].$int_fecha_fin_licencia[1].$int_fecha_fin_licencia[2];
        
        $int_fecha_inicio_informe = getAnoMostrarCorte().getMesMostrarCorte().'01';
        
        $int_fecha_fin_informe = getAnoMostrarCorte().getMesMostrarCorte().getLimiteMes((int)getMesMostrarCorte());
        
        if( $int_fecha_fin_licencia < $int_fecha_inicio_informe ){
        } elseif ($int_fecha_inicio_licencia > $int_fecha_fin_informe) {
        } elseif ( $int_fecha_inicio_licencia >= $int_fecha_inicio_informe && $int_fecha_fin_licencia <= $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif ( $int_fecha_fin_licencia >= $int_fecha_inicio_informe && $int_fecha_fin_licencia <= $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif (  $int_fecha_inicio_licencia >= $int_fecha_inicio_informe && $int_fecha_inicio_licencia <= $int_fecha_fin_informe  ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif ( $int_fecha_inicio_licencia < $int_fecha_inicio_informe && $int_fecha_fin_licencia > $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        }


    }

    $ids_licencias  = [];
    $datos_retorno_licencias = [];
    foreach ($licencias as $l) {
        $ids_licencias[] = $l["trabajador_id"];
        $datos_retorno_licencias[$l["trabajador_id"]] = [
            'fecha_inicio' => $l["fecha_inicio"],
            'fecha_fin' => $l["fecha_fin"]
        ];
    }

    $super_array["licencias"] = [
        'ids' => $ids_licencias,
        'datos' => $datos_retorno_licencias
    ];

    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');
    $sql = "
    SELECT CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, A.trabajador_id, A.fecha_inicio, A.fecha_fin 
    FROM t_ausencia A, m_trabajador T
    WHERE A.ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.descuenta = 1 )
    AND A.ausencia_id NOT IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 )
    AND ( month(fecha_inicio) = $mes OR month(fecha_fin) = $mes )
    AND ( year(fecha_inicio) = $year OR year(fecha_fin) = $year )
    AND T.id = A.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $ausencias_no_justificadas = $db->rawQuery( $sql );

    $ids_ausencia_no_justificadas  = [];
    $datos_retorno_ausencia_no_justificadas = [];
    foreach ($ausencias_no_justificadas as $anj) {
        $ids_ausencia_no_justificadas[] = $anj["trabajador_id"];
        $datos_retorno_ausencia_no_justificadas[$anj["trabajador_id"]] = [
            'fecha_inicio' => $anj["fecha_inicio"],
            'fecha_fin' => $anj["fecha_fin"]
        ];
    }

    $super_array["ausencias_no_justificadas"] = [
        'ids' => $ids_ausencia_no_justificadas,
        'datos' => $datos_retorno_ausencia_no_justificadas
    ];
    
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin, T.id
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin = '0000-00-00'
    AND T.empresa_id = ".$_SESSION[PREFIX.'login_eid']."
    ORDER BY nombre ASC
    ";
    $indefinidos_mes = $db->rawQuery( $sql ); 

    $ids_indefinidos_mes = [];
    $datos_retorno_indefinidos_mes = [];
    foreach ($indefinidos_mes as $im) {
        $ids_indefinidos_mes[] = $im["id"];
        $datos_retorno_indefinidos_mes[$im["id"]] = [
            'fecha_inicio' => $im["fechaContratoInicio"],
            'fecha_fin' => $im["fechaContratoFin"]
        ];
    }

    $super_array["indefinidos_mes"] = [
        'ids' => $ids_indefinidos_mes,
        'datos' => $datos_retorno_indefinidos_mes
    ];
    
    $total_dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin, T.id
    FROM m_trabajador T
    WHERE T.fechaContratoFin != '0000-00-00'
    AND T.fechaContratoInicio < '$year-".leadZero($mes)."-01'
    AND T.fechaContratoFin >= '$year-".leadZero($mes)."-01'
    AND T.empresa_ID = " . $_SESSION[PREFIX.'login_eid'] ."
    AND T.tipocontrato_id NOT IN (3,4)
    ORDER BY nombre ASC
    ";    
    $plazo_fijo_durante_mes = $db->rawQuery( $sql );

    $ids_plazo_fijo_durante_mes = [];
    $datos_retorno_plazo_fijo_durante_mes = [];
    foreach ($plazo_fijo_durante_mes as $pfm) {
        $ids_plazo_fijo_durante_mes[] = $pfm["id"];
        $datos_retorno_plazo_fijo_durante_mes[$pfm["id"]] = [
            'fecha_inicio' => $pfm["fechaContratoInicio"],
            'fecha_fin' => $pfm["fechaContratoFin"]
        ];
    }

    $super_array["plazo_fijo_durante_mes"] = [
        'ids' => $ids_plazo_fijo_durante_mes,
        'datos' => $datos_retorno_plazo_fijo_durante_mes
    ];
    
    $array_plazo_a_indefinido = array();   
    $arr_paso_a_indefinido = array();
    $sql1 = "
    SELECT C.trabajador_id
    FROM t_contrato C, m_trabajador T
    where C.trabajador_id IN ( SELECT id FROM m_trabajador 
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." )
    AND T.id = C.trabajador_id
    group by trabajador_id HAVING SUM(T.activo)>1  
    ";
    $plazo_a_indefinido = $db->rawQuery( $sql1 );
    
    foreach( $plazo_a_indefinido as $p ){
        $sub_sql = "
        SELECT MAX(C.fechaInicio) as fechaContrato, concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre, T.id, T.fechaContratoFin, T.fechaContratoInicio
        FROM t_contrato C, m_trabajador T
        WHERE C.trabajador_id = " . $p['trabajador_id']."
        AND C.activo = 1
        AND C.trabajador_id = T.id    
        ORDER BY nombre ASC    
        ";
        $subres = $db->rawQuery( $sub_sql );
        $array_plazo_a_indefinido[] = $subres[0];        
    }        

    
    foreach( $array_plazo_a_indefinido as $r ){        
        $time = strtotime( $r['fechaContrato'] );    
        if( ( date('n',$time) == $mes ) && ( date('Y',$time) == $year ) ){
            $arr_paso_a_indefinido[] = $r;
        }
    } 

    $ids_plazo_a_indefinido = [];
    $datos_retorno_plazo_a_indefinido = [];
    foreach ($array_plazo_a_indefinido as $pai) {
        $ids_plazo_a_indefinido[] = $pai["id"];
        $datos_retorno_plazo_a_indefinido[$pai["id"]] = [
            'fecha_inicio' => $pai["fechaContratoInicio"],
            'fecha_fin' => $pai["fechaContratoFin"]
        ];
    }

    $super_array["plazo_a_indefinido"] = [
        'ids' => $ids_plazo_a_indefinido,
        'datos' => $datos_retorno_plazo_a_indefinido
    ];
    
    $sql = "
    SELECT concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre, T.fechaContratoFin, T.fechaContratoInicio, T.id
    FROM m_trabajador T
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." 
    AND tipocontrato_id IN (3,4)
    AND month(fechaContratoFin) = $mes
    AND year(fechaContratoFin) = $year
    ORDER BY nombre ASC
    ";        
    $despedidos = $db->rawQuery( $sql );

    $ids_despidos = [];
    $datos_retorno_despidos = [];
    foreach ($despedidos as $d) {
        $ids_despidos[] = $d["id"];
        $datos_retorno_despidos[$d["id"]] = [
            'fecha_inicio' => $d["fechaContratoInicio"],
            'fecha_fin' => $d["fechaContratoFin"]
        ];
    }

    $super_array["despidos"] = [
        'ids' => $ids_despidos,
        'datos' => $datos_retorno_despidos
    ];

    

    return $super_array;
    
}

function tieneMovimientos($trabajador_id, $super_array){

    $array_return = [
        'codigo_movimiento' => 0,
        'fechas_limites' => [
            'fecha_inicio' => "",
            'fecha_fin' => ""
        ]
    ];

    if (in_array($trabajador_id,$super_array["inicio_plazo_fijo_mes"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 7,
            'fechas_limites' => $super_array["inicio_plazo_fijo_mes"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["licencias"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 3,
            'fechas_limites' => $super_array["licencias"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["ausencias_no_justificadas"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 11,
            'fechas_limites' => $super_array["ausencias_no_justificadas"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["indefinidos_mes"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 1,
            'fechas_limites' => $super_array["indefinidos_mes"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["plazo_fijo_durante_mes"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 7,
            'fechas_limites' => $super_array["plazo_fijo_durante_mes"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["plazo_a_indefinido"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 8,
            'fechas_limites' => $super_array["plazo_a_indefinido"]["datos"][$trabajador_id]
        ];
    }
    if (in_array($trabajador_id,$super_array["despidos"]["ids"])) {
        $array_return = [
            'codigo_movimiento' => 2,
            'fechas_limites' => $super_array["despidos"]["datos"][$trabajador_id]
        ];
    }

    return $array_return;
}

?>
