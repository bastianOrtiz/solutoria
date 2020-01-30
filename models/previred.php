<?php

function buscarEmpleados($id_empresa, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $sql = "SELECT L.*, T.* from liquidacion L, m_trabajador T
            where T.id IN ( select L.trabajador_id from liquidacion L WHERE L.mes = $mes and L.ano = $ano )
            and L.ano = $ano
            and L.mes = $mes
            and L.empresa_id = $id_empresa
            and L.trabajador_id = T.id
            GROUP by L.trabajador_id";

    $empleados= $db->rawQuery($sql);

    return $empleados;

    /*$super_arreglo = [];

    $db->where("empresa_id", $id_empresa);
    $db->where('tipocontrato_id',array(3,4),'NOT IN');
    //$db->where("apellidoPaterno","FARIAS");
    $empleados = $db->get("m_trabajador");

    return $empleados;*/
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
                'cargasMaternales' => $super_array["tramo_a"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["tramo_a"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["tramo_a"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }

/*---------- Tipo B ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_b"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_b"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["tramo_b"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["tramo_b"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["tramo_b"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }
    
/*---------- Tipo C ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_c"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_c"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["tramo_c"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["tramo_c"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["tramo_c"]["datos"][$trabajador_id]["cargasInvalidez"]
            ]
        ];
    }
    
/*---------- Tipo D ----------*/
    
    if(in_array($trabajador_id,$super_array["tramo_d"]["ids"])){
        $array_return = [
            'tipo_tramo' => $super_array["tramo_d"]["datos"][$trabajador_id]["tramoCargas"],
            'cargas' => [
                'cargasMaternales' => $super_array["tramo_d"]["datos"][$trabajador_id]["cargasMaternales"],
                'cargasSimples' => $super_array["tramo_d"]["datos"][$trabajador_id]["cargasSimples"],
                'cargasInvalidez' => $super_array["tramo_d"]["datos"][$trabajador_id]["cargasInvalidez"]
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

    $db->where("mes", $mes);//remplazar por datos que le mando antes de generar previred
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

function getApv($trabajador_id){
    global $db;

    $datos_retorno = [];

    $db->join("t_apv", "m_institucion.id=t_apv.institucion_id");
    $db->where("t_apv.trabajador_id",$trabajador_id);
    $results = $db->get("m_institucion",null, "m_institucion.nombre, m_institucion.codigo");

    $arreglo = [];

    $arreglo["count"] = count($results);
    $arreglo["results"] = $results;

    return $arreglo;
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

function insidencias($tipo, $trabajador_id, $super_array = []){

    $arreglo = [];

    if ($tipo == 'ausencia') {

        $ausencia = 0;

        if( in_array($trabajador_id, $super_array['ausencia']['trabajadores_ids']) ){
            $ocurrencias = array_count_values($super_array['ausencia']['trabajadores_ids']);

            if( $ocurrencias[$trabajador_id] >= 1 ){
                $ausencia = $ocurrencias[$trabajador_id];
            }

        }else{
            $ocurrencias = 0;
        }

        $arreglo["ausencia"]["count"] = $ocurrencias;
        $arreglo["ausencia"]["results"] = $super_array['ausencia']['datos'];

        return $arreglo;

    }elseif ($tipo == 'apv') {
        
        global $db;

        $datos_retorno = [];

        $db->join("t_apv", "m_institucion.id=t_apv.institucion_id");
        $db->where("t_apv.trabajador_id",$trabajador_id);
        $results = $db->get("m_institucion");

        $arreglo["apv"]["count"] = count($results);
        $arreglo["apv"]["results"] = $results;

        return $arreglo;

    }elseif ($tipo == 'licencia'){

        $licencia = 0;

        if( in_array($trabajador_id, $super_array['licencias']['trabajadores_ids']) ){
            $ocurrencias = array_count_values($super_array['licencias']['trabajadores_ids']);

            if( $ocurrencias[$trabajador_id] >= 1 ){
                $licencia = $ocurrencias[$trabajador_id];
            }

        }else{
            $ocurrencias = 0;
        }

        $arreglo["licencias"]["count"] = $ocurrencias;
        $arreglo["licencias"]["results"] = $super_array['licencias']['datos'];

        return $arreglo;

    }
}

function crearTxt($post){
    global $db;

    $super_array = sqlMovimientos($post['mesAtraso'],$post['anoAtraso']);
    $super_arreglo = sqlTramoCarga();
    $arreglo_asignacion_familiar = sqlAsignacionFamiliar($post['mesAtraso'],$post['anoAtraso']);
    $arreglo_ausencias = sqlAusencia($post['mesAtraso'],$post['anoAtraso']);
    $arreglo_asignacion_familiar_retroactiva = sqlAsignacionFamiliarRetroactiva($post['mesAtraso'],$post['anoAtraso']);
    $arreglo_ids_licencia = obtenerDiasLicencia($post['mesAtraso'],$post['anoAtraso']);
    $arreglo_liquidaciones = sqlLiquidacion($post['mesAtraso'],$post['anoAtraso']);
    $empleados = [];
    $arr_trabajadores_con_incidencia[] = [];
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
            'extranjero' => $post["extranjero"][$key],
       ];
    }

    $archivo= ROOT."/private/uploads/docs/previred.txt"; // el nombre de tu archivo
    $empleados= $empleados; // Recibez el formulario

    $fch= fopen($archivo, "w+"); // Abres el archivo para escribir en él
    $var = "";

    foreach ($empleados as $empleado) {

        $separador = explode("-",$empleado["rut"]);
        $rut = rellenar($separador[0], 11, "i");

        //$var.= $rut;
        fwrite($fch, $rut); // Grabas -- 1

        $dv = $separador[1];
        $dv = rellenar($dv, 1, "s");

        //$var.= $dv;
        fwrite($fch, $dv); // Grabas -- 2

        $apellidoPater = utf8_decode($empleado["apellidoPaterno"]);
        $apellidoPaterno = rellenar($apellidoPater, 30, "s");

        //$var.= $apellidoPaterno;
        fwrite($fch, $apellidoPaterno); // Grabas -- 3

        $apellidoMater = utf8_decode($empleado["apellidoMaterno"]);
        $apellidoMaterno = rellenar($apellidoMater, 30, "s");

        //$var.= $apellidoMaterno;
        fwrite($fch, $apellidoMaterno); // Grabas -- 4

        $nomb = utf8_decode($empleado["nombre"]);
        $nombres = rellenar($nomb, 30, "s");

        //$var.= $nombres;

        fwrite($fch, $nombres); // Grabas -- 5

        if ($empleado["sexo"] == 1) {
            $empleado_sexo = rellenar("M",1,"s");

            //$var.= $empleado_sexo;
            fwrite($fch, $empleado_sexo); // Grabas -- 6
        }else{
            $empleado_sexo = rellenar("F",1,"s");

            //$var.= $empleado_sexo;
            fwrite($fch, $empleado_sexo); // Grabas -- 6
        }

        if ($empleado['extranjero'] == 1) {
            $nacionalidad = rellenar("1",1,"i");

            //$var.= $nacionalidad;
            fwrite($fch, $nacionalidad); // Grabas -- 7
        }else{
            $nacionalidad = rellenar("0",1,"i");

            //$var.= $nacionalidad;
            fwrite($fch, $nacionalidad); // Grabas -- 7
        }

        /*if ($empleado["idNacionalidad"] = 46) {
            $nacionalidad = rellenar("0",1,"i");

            //$var.= $nacionalidad;
            fwrite($fch, $nacionalidad); // Grabas
        }else{
            $nacionalidad = rellenar("1",1,"i");

            //$var.= $nacionalidad;
            fwrite($fch, $nacionalidad); // Grabas
        }*/

        $tipo_pago = rellenar("01",2,"i");
        //$var.= $tipo_pago;
        fwrite($fch, $tipo_pago); // Grabas -- 8

        $periodoDesde = $post['mesAtraso'].$post['anoAtraso'];
        $periodoDesde = rellenar($periodoDesde,6,"i");
        //$var.= $periodoDesde;
        fwrite($fch, $periodoDesde); // Grabas -- 9

        $periodoHasta = $post['mesAtraso'].$post['anoAtraso'];
        $periodoHasta = rellenar($periodoHasta,6,"i");
        //$var.= $periodoHasta;
        fwrite($fch, $periodoHasta); // Grabas -- 10

        $tip_afp = previTrabajador($empleado["id"]);
        if ($tip_afp["id"] !== 7) {
            $tip_afp = rellenar("AFP",3,"s");
            //$var.= $tip_afp;
            fwrite($fch, $tip_afp); // Grabas -- 11
        }else{
            $tip_afp = rellenar("INP",3,"s");
            //$var.= $tip_afp;
            fwrite($fch, $tip_afp); // Grabas -- 11
        }

        $tipo_trabajador = tipoEmpleado($empleado["tipo_trabajador"]);
        if ($tipo_trabajador["id"] == 1 || $tipo_trabajador["id"] == 5 || $tipo_trabajador["id"] == 6 || $tipo_trabajador["id"] == 7) {
            $tip_trabajador = rellenar("0",1,"i");
            //$var.= $tip_trabajador;
            fwrite($fch, $tip_trabajador); // Grabas -- 12
        }elseif ($tipo_trabajador["id"] == 2 || $tipo_trabajador["id"] == 8) {
            $tip_trabajador = rellenar("1",1,"i");
            //$var.= $tip_trabajador;
            fwrite($fch, $tip_trabajador); // Grabas -- 12
        }elseif ($tipo_trabajador["id"] == 4 || $tipo_trabajador["id"] == 3) {
            $tip_trabajador = rellenar("2",1,"i");
            //$var.= $tip_trabajador;
            fwrite($fch, $tip_trabajador); // Grabas -- 12
        }

        $obtenerAusencias = obtenerAusenciasPrevired($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        //$dias_trabajados = getDiasTrabajados($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);//areglar
        $dias_trabajados = 30 - $obtenerAusencias['total'];//areglar
        $dias_trabajados = rellenar($dias_trabajados,2,"i");
        //$var.= $dias_trabajados;
        fwrite($fch, $dias_trabajados); // Grabas -- 13

        $tipo_linea = "00";
        $tipo_linea = rellenar($tipo_linea,2,"s");
        //$var.= $tipo_linea;
        fwrite($fch, $tipo_linea); // Grabas -- 14

        $movimientos = tieneMovimientos($empleado["id"],$super_array);

        $movimientos_lenght = 0;

        foreach ($obtenerAusencias as $key => $value) {
            if (is_int($key)) {
                $movimientos_lenght ++;
            }
        }



        $fecha_formateada_inicio = "";
        $fecha_formateada_fin = "";

        if ($movimientos_lenght >= 1) {
                $indice = 0;
                foreach ($obtenerAusencias as $key => $movimiento) {
                    if ($indice > 0) {
                        if (is_int($key)) {
                            $arr_trabajadores_con_incidencia[] = [
                                'trabajador_id' => $empleado["id"],
                                'tipo_incidencia' => 'movimientos',
                                'data' => $movimiento,
                                'codigo_movimiento' => $movimiento['codigo_previred']
                            ];
                        }
                    }
                    $indice++;
                }


                $codigo_movimiento = rellenar($obtenerAusencias[0]["codigo_previred"],2,"i");
                //$var.= $codigo_movimiento;
                fwrite($fch, $codigo_movimiento); // Grabas -- 15
                if ($obtenerAusencias[0]["fecha_inicio"] == "") {
                    $fecha_formateada_inicio = rellenar($obtenerAusencias[0]["fecha_inicio"],10,"s");
                }else{
                    $unix_time = strtotime($obtenerAusencias[0]["fecha_inicio"]); 
                    $fecha_parseada_inicio = date('d-m-Y',$unix_time);
                    $fecha_formateada_inicio = rellenar($fecha_parseada_inicio,10,"s");
                }
                //$var.= $fecha_formateada_inicio;
                fwrite($fch, $fecha_formateada_inicio); // Grabas -- 16

                if ($obtenerAusencias[0]["fecha_fin"] == "") {
                    $fecha_formateada_fin = rellenar($obtenerAusencias[0]["fecha_fin"],10,"s");
                }else{
                    $unix_time = strtotime($obtenerAusencias[0]["fecha_fin"]); 
                    $fecha_parseada_fin = date('d-m-Y',$unix_time);
                    $fecha_formateada_fin = rellenar($fecha_parseada_fin,10,"s");
                }
                //$var.= $fecha_formateada_fin;
                fwrite($fch, $fecha_formateada_fin); // Grabas -- 17
        }elseif (count($movimientos)) {
            $n_movimientos = count($movimientos);

            if ($n_movimientos >= 1) {
                $indice = 0;
                foreach ($movimientos as $movimiento) {
                    if ($indice > 0) {
                        $arr_trabajadores_con_incidencia[] = [
                            'trabajador_id' => $empleado["id"],
                            'tipo_incidencia' => 'movimientos',
                            'data' => $movimiento
                        ];
                    }
                    $indice++;
                }

                $codigo_movimiento = rellenar($movimientos[0]["codigo_movimiento"],2,"i");
                //$var.= $codigo_movimiento;
                fwrite($fch, $codigo_movimiento); // Grabas -- 15
                if ($movimientos[0]["fechas_limites"]["fecha_inicio"] == "") {
                    $fecha_formateada_inicio = rellenar($movimientos[0]["fechas_limites"]["fecha_inicio"],10,"s");
                }else{
                    $separador_fecha_inicio = explode("-",$movimientos[0]["fechas_limites"]["fecha_inicio"]);
                    $fecha_formateada_inicio = $separador_fecha_inicio[2]."-".$separador_fecha_inicio[1]."-".$separador_fecha_inicio[0];
                    $fecha_formateada_inicio = rellenar($fecha_formateada_inicio,10,"s");
                }
                //$var.= $fecha_formateada_inicio;
                fwrite($fch, $fecha_formateada_inicio); // Grabas -- 16

                if ($movimientos[0]["fechas_limites"]["fecha_fin"] == "") {
                    $fecha_formateada_fin = rellenar($movimientos[0]["fechas_limites"]["fecha_fin"],10,"s");
                }else{
                    $separador_fecha_fin = explode("-",$movimientos[0]["fechas_limites"]["fecha_fin"]);
                    $fecha_formateada_fin = $separador_fecha_fin[2]."-".$separador_fecha_fin[1]."-".$separador_fecha_fin[0];
                    $fecha_formateada_fin = rellenar($fecha_formateada_fin,10,"s");
                }
                //$var.= $fecha_formateada_fin;
                fwrite($fch, $fecha_formateada_fin); // Grabas -- 17
            }
        }else{
            $codigo_movimiento = rellenar(0,2,"i");
                //$var.= $codigo_movimiento;
                fwrite($fch, $codigo_movimiento); // Grabas -- 15
                $fecha_formateada_inicio = rellenar("",10,"s");
                fwrite($fch, $fecha_formateada_inicio); // Grabas -- 16
                
                $fecha_formateada_fin = rellenar("",10,"s");
                //$var.= $fecha_formateada_fin;
                fwrite($fch, $fecha_formateada_fin); // Grabas -- 17
        }
        $asignacion = tieneTramo($empleado["id"],$super_arreglo);
        $tramo = rellenar($asignacion["tipo_tramo"],1,"s");
        //$var.= $tramo;
        fwrite($fch, $tramo); // Grabas -- 18
        
        $num_cargas_simples = rellenar($asignacion["cargas"]["cargasSimples"],2,"i");
        //$var.= $num_cargas_simples;
        fwrite($fch, $num_cargas_simples); // Grabas -- 19
        
        $num_cargas_maternales = rellenar($asignacion["cargas"]["cargasMaternales"],1,"i");
        //$var.= $num_cargas_maternales;
        fwrite($fch, $num_cargas_maternales); // Grabas -- 20
        
        $num_cargas_invalidas = rellenar($asignacion["cargas"]["cargasInvalidez"],1,"i");
        //$var.= $num_cargas_invalidas;
        fwrite($fch, $num_cargas_invalidas); // Grabas -- 21

        $asig_familiar = tieneAsignacion($empleado["id"],$arreglo_asignacion_familiar);
        $monto_asignacion = $asig_familiar["monto"];
        $monto = rellenar($monto_asignacion,6,"i");
        //$var.= $monto;
        fwrite($fch, $monto); // Grabas -- 22

        $asig_familiar_retroactiva = tieneAsignacion($empleado["id"],$arreglo_asignacion_familiar_retroactiva);
        $monto_asignacion_retroactiva = $asig_familiar_retroactiva["monto"];
        $monto_retroactiva = rellenar($monto_asignacion_retroactiva,6,"i");
        //$var.= $monto_retroactiva;
        fwrite($fch, $monto_retroactiva); // Grabas -- 23

        $reintegro_cargas_familiares = 0;
        $monto_reintegro_cargas_familiares = rellenar($reintegro_cargas_familiares,6,"i");
        //$var.= $monto_reintegro_cargas_familiares;
        fwrite($fch, $monto_reintegro_cargas_familiares); // Grabas

        $solicitud_trabajador_joven = rellenar("N",1,"s");
        //$var.= $solicitud_trabajador_joven;
        fwrite($fch, $solicitud_trabajador_joven); // Grabas

        /*$licencia = obtenerDiasLicencia($empleado["id"]);
        $dias_de_licencia = rellenar($licencia,1,"s");

        if (in_array($empleado["id"], $arreglo_ids_licencia)) {
            fwrite($fch, "S"); // Grabas
        }else{
            fwrite($fch, "N"); // Grabas
        }*/

        $codigo_afp = getCodigoAfp($empleado["id"]);
        $codigo_afp_convertido = leadZero($codigo_afp["codigo"]);
        $codigo_afp_rellenar = rellenar($codigo_afp_convertido,2,"i");
        //$var.= $codigo_afp_rellenar;
        fwrite($fch, $codigo_afp_rellenar); // Grabas
        $imponible = tieneImponible($empleado["id"],$arreglo_liquidaciones);
        $montoImponible = rellenar($imponible["monto"],8,"i");
        //$var.= $montoImponible;
        fwrite($fch, $montoImponible); // Grabas
        $monto_obligatorio_afp = rellenar($imponible["cotizacion"],8,"i");
        //$var.= $monto_obligatorio_afp;
        fwrite($fch, $monto_obligatorio_afp); // Grabas
        $monto_sis = rellenar($imponible["sis"],8,"i");
        //$var.= $monto_sis;
        fwrite($fch, $monto_sis); // Grabas
        $cuenta2Monto = rellenar($imponible["cuenta2Monto"],8,"i");
        //$var.= $cuenta2Monto;
        fwrite($fch, $cuenta2Monto); // Grabas
        $renta_imp_sust_afp = rellenar(0,8,"i");
        //$var.= $renta_imp_sust_afp;
        fwrite($fch, $renta_imp_sust_afp); // Grabas
        $tasa_pactada = "00,00";
        //$var.= $tasa_pac00,tada;
        fwrite($fch, $tasa_pactada); // Grabas
        $aporte_indemn = rellenar(0,9,"i");
        //$var.= $aporte_indemn;
        fwrite($fch, $aporte_indemn); // Grabas
        $n_periodos = rellenar(0,2,"i");
        //$var.= $n_periodos;
        fwrite($fch, $n_periodos); // Grabas
        $periodo_desde = rellenar("",10,"s");
        //$var.= $periodo_desde;
        fwrite($fch, $periodo_desde); // Grabas
        $periodo_hasta = rellenar("",10,"s");
        //$var.= $periodo_hasta;
        fwrite($fch, $periodo_hasta); // Grabas
        $puesto_trabajo_pesado = rellenar("",40,"s");
        //$var.= $puesto_trabajo_pesado;
        fwrite($fch, $puesto_trabajo_pesado); // Grabas
        $porcentaje_cotizacion_trabajo_pesado = rellenar(0,5,"i");
        //$var.= $porcentaje_cotizacion_trabajo_pesado;
        fwrite($fch, $porcentaje_cotizacion_trabajo_pesado); // Grabas
        $cotizacion_trabajo_pesado = rellenar(0,6,"i");
        //$var.= $cotizacion_trabajo_pesado;
        fwrite($fch, $cotizacion_trabajo_pesado); // Grabas
        /*------ Datos Ahorro Previsional Voluntario Individual ------(Falta completar)*/
        $apvi = insidencias('apv',$empleado["id"]);
        if ($apvi['apv']['count'] > 1) {
            $indice = 0;
            foreach ($apvi['apv']['results'] as $result) {
                if( $indice > 0 ){
                    $arr_trabajadores_con_incidencia[] = [
                        'trabajador_id' => $empleado["id"],
                        'tipo_incidencia' => 'apv',
                        'data' => $result
                    ];
                }
                $indice++;
            }
            $codigo_institucion_apvi = $apvi['apv']['results'][0]['codigo'];
            $codigo_institucion_apvi = rellenar($codigo_institucion_apvi,3,'i');
            //$var.= $codigo_institucion_apvi;
            fwrite($fch, $codigo_institucion_apvi); // Grabas
            $numero_contrato_apvi = rellenar("",20,"s");
            //$var.= $numero_contrato_apvi;
            fwrite($fch, $numero_contrato_apvi); // Grabas
            $forma_pago_apvi = rellenar(1,1,'i');
            //$var.= $forma_pago_apvi;
            fwrite($fch, $forma_pago_apvi); // Grabas
            $tip_moneda = tipoMoneda($apvi['apv']['results'][0]['tipomoneda_id']);
            if ($tip_moneda['id'] == 1) {
                $val_moneda = 1;
                $val_monto_apvi = round($apvi['apv']['results'][0]['monto'] * $val_moneda);
            }else{
                $val_moneda = valorMoneda($tip_moneda['id'],$post['mesAtraso'],$post['anoAtraso']);
                $val_monto_apvi = round($apvi['apv']['results'][0]['monto'] * $val_moneda['valor']);
            }
            //$val_monto_sin_punto = str_replace(".","",$val_monto_apvi);/* No se remplaza el punto */
            $cotizacion_apvi = rellenar($val_monto_apvi,8,'i');
            //$var.= $cotizacion_apvi;
            fwrite($fch, $cotizacion_apvi); // Grabas
            $cotizacion_depositos_convenidos = rellenar(0,8,'i');
            //$var.= $cotizacion_depositos_convenidos;
            fwrite($fch, $cotizacion_depositos_convenidos); // Grabas
        }elseif ($apvi['apv']['count'] == 1) {
            $codigo_institucion_apvi = $apvi['apv']['results'][0]['codigo'];
            $codigo_institucion_apvi = rellenar($codigo_institucion_apvi,3,'i');
            //$var.= $codigo_institucion_apvi;
            fwrite($fch, $codigo_institucion_apvi); // Grabas
            $numero_contrato_apvi = rellenar("",20,"s");
            //$var.= $numero_contrato_apvi;
            fwrite($fch, $numero_contrato_apvi); // Grabas
            $forma_pago_apvi = rellenar(1,1,'i');
            //$var.= $forma_pago_apvi;
            fwrite($fch, $forma_pago_apvi); // Grabas
            $tip_moneda = tipoMoneda($apvi['apv']['results'][0]['tipomoneda_id']);
            if ($tip_moneda['id'] == 1) {
                $val_moneda = 1;
                $val_monto_apvi = round($apvi['apv']['results'][0]['monto'] * $val_moneda);
            }else{
                $val_moneda = valorMoneda($tip_moneda['id'],$post['mesAtraso'],$post['anoAtraso']);
                $val_monto_apvi = round($apvi['apv']['results'][0]['monto'] * $val_moneda['valor']);
            }
            //$val_monto_sin_punto = str_replace(".","",$val_monto_apvi);/* No se remplaza el punto */
            $cotizacion_apvi = rellenar($val_monto_apvi,8,'i');
            //$var.= $cotizacion_apvi;
            fwrite($fch, $cotizacion_apvi); // Grabas
            $cotizacion_depositos_convenidos = rellenar(0,8,'i');
            //$var.= $cotizacion_depositos_convenidos;
            fwrite($fch, $cotizacion_depositos_convenidos); // Grabas
        }else{
            /*---- Completar con 0 ----*/
            $codigo_institucion_apvi = rellenar(0,3,'i');
            //$var.= $codigo_institucion_apvi;
            fwrite($fch, $codigo_institucion_apvi); // Grabas
            $numero_contrato_apvi = rellenar("",20,"s");
            //$var.= $numero_contrato_apvi;
            fwrite($fch, $numero_contrato_apvi); // Grabas
            $forma_pago_apvi = rellenar(1,1,'i');
            //$var.= $forma_pago_apvi;
            fwrite($fch, $forma_pago_apvi); // Grabas
            $cotizacion_apvi = rellenar(0,8,'i');
            //$var.= $cotizacion_apvi;
            fwrite($fch, $cotizacion_apvi); // Grabas
            $cotizacion_depositos_convenidos = rellenar(0,8,'i');
            //$var.= $cotizacion_depositos_convenidos;
            fwrite($fch, $cotizacion_depositos_convenidos); // Grabas
        }
        /*------ Datos Ahorro Previsional Voluntario Colentivo ------*/
        $codigo_institucion_autorizada_apvc = rellenar(0,3,"i");
        //$var.= $codigo_institucion_autorizada_apvc;
        fwrite($fch, $codigo_institucion_autorizada_apvc); // Grabas
        $numero_contrato_apvc = rellenar("",20,"s");
        //$var.= $numero_contrato_apvc;
        fwrite($fch, $numero_contrato_apvc); // Grabas
        $forma_pago_apvc = rellenar(0,1,"i");
        //$var.= $forma_pago_apvc;
        fwrite($fch, $forma_pago_apvc); // Grabas
        $cotizacion_trabajador_apvc = rellenar(0,8,"i");
        //$var.= $cotizacion_trabajador_apvc;
        fwrite($fch, $cotizacion_trabajador_apvc); // Grabas
        $cotizacion_empleador_apvc = rellenar(0,8,"i");
        //$var.= $cotizacion_empleador_apvc;
        fwrite($fch, $cotizacion_empleador_apvc); // Grabas
        $rut_afiliado_voluntario = rellenar(0,11,"i");
        //$var.= $rut_afiliado_voluntario;
        fwrite($fch, $rut_afiliado_voluntario); // Grabas
        $dv_afiliado_voluntario = rellenar("",1,"s");
        //$var.= $dv_afiliado_voluntario;
        fwrite($fch, $dv_afiliado_voluntario); // Grabas
        $apellidoPaterno_afiliado_voluntario = rellenar("",30,"s");
        //$var.= $apellidoPaterno_afiliado_voluntario;
        fwrite($fch, $apellidoPaterno_afiliado_voluntario); // Grabas
        $apellidoMaterno_afiliado_voluntario = rellenar("",30,"s");
        //$var.= $apellidoMaterno_afiliado_voluntario;
        fwrite($fch, $apellidoMaterno_afiliado_voluntario); // Grabas
        $nombre_afiliado_voluntario = rellenar("",30,"s");
        //$var.= $nombre_afiliado_voluntario;
        fwrite($fch, $nombre_afiliado_voluntario); // Grabas
        $codigo_movimiento_personal = rellenar(0,2,"i");
        //$var.= $codigo_movimiento_personal;
        fwrite($fch, $codigo_movimiento_personal); // Grabas
        $fecha_desde_afiliado = rellenar("",10,"s");
        //$var.= $fecha_desde_afiliado;
        fwrite($fch, $fecha_desde_afiliado); // Grabas
        $fecha_hasta_afiliado = rellenar("",10,"s");
        //$var.= $fecha_hasta_afiliado;
        fwrite($fch, $fecha_hasta_afiliado); // Grabas
        $codigo_afp_afiliado = rellenar(0,2,"i");
        //$var.= $codigo_afp_afiliado;
        fwrite($fch, $codigo_afp_afiliado); // Grabas
        $monto_capitalizacion_voluntaria = rellenar(0,8,"i");
        //$var.= $monto_capitalizacion_voluntaria;
        fwrite($fch, $monto_capitalizacion_voluntaria); // Grabas
        $monto_ahorro_voluntario = rellenar(0,8,"i");
        //$var.= $monto_ahorro_voluntario;
        fwrite($fch, $monto_ahorro_voluntario); // Grabas
        $numero_periodos_cotizacion = rellenar(0,2,"i");
        //$var.= $numero_periodos_cotizacion;
        fwrite($fch, $numero_periodos_cotizacion); // Grabas
        $codigo_ex_caga_regimen = rellenar(0,4,"i");
        //$var.= $codigo_ex_caga_regimen;
        fwrite($fch, $codigo_ex_caga_regimen); // Grabas
        $tasa_cotizacion_ex_caja_prevision = "00,00";
        //$var.= $tasa_cotizacion_ex_caja_prevision;
        fwrite($fch, $tasa_cotizacion_ex_caja_prevision); // Grabas
        $renta_imponible_ips = rellenar($imponible["monto"],8,"i");
        //$var.= $renta_imponible_ips;
        fwrite($fch, $renta_imponible_ips); // Grabas -- 64
        $cotizacion_obligatoria_ips = rellenar(0,8,"i");
        //$var.= $cotizacion_obligatoria_ips;
        fwrite($fch, $cotizacion_obligatoria_ips); // Grabas -- 65
        $renta_imponible_desahucio = rellenar(0,8,"i");
        //$var.= $renta_imponible_desahucio;
        fwrite($fch, $renta_imponible_desahucio); // Grabas -- 66
        $codigo_ex_caja_regimen_desahucio = rellenar(0,4,"i");
        //$var.= $codigo_ex_caja_regimen_desahucio;
        fwrite($fch, $codigo_ex_caja_regimen_desahucio); // Grabas -- 67
        $tasa_cotizacion_desahucio_excaja_prevision = "00,00";
        //$tasa_cotizacion_desahucio_excaja_prevision = rellenar(0,5,"i");
        //$var.= $tasa_cotizacion_desahucio_excaja_prevision;
        fwrite($fch, $tasa_cotizacion_desahucio_excaja_prevision); // Grabas -- 68
        $cotizacion_desaucio = rellenar(0,8,"i");
        //$var.= $cotizacion_desaucio;
        fwrite($fch, $cotizacion_desaucio); // Grabas -- 69
        $fonasa = tipoSalud($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        if ($fonasa['isapre_id'] == 0) {
            $imponible_calculo = $imponible["monto"]*0.064;
            $imponible_calculo = number_format($imponible_calculo,0,",","");
            $cotizacion_fonasa = rellenar($imponible_calculo,8,"i");

            $imponible_CCAF = $imponible["monto"]*0.006;
            $imponible_CCAF = number_format($imponible_CCAF,0,",","");
            $cotizacion_ccaf = $imponible_CCAF;

        }else{
            $cotizacion_fonasa = rellenar(0,8,"i");
            $cotizacion_ccaf = rellenar(0,8,"i");
        }
        //$var.= $cotizacion_fonasa;
        fwrite($fch, $cotizacion_fonasa); // Grabas
        $cotizacion_acc_trabajo = rellenar(0,8,"i");
        //$var.= $cotizacion_acc_trabajo;
        fwrite($fch, $cotizacion_acc_trabajo); // Grabas
        $bonificacion_ley = rellenar(0,8,"i");
        //$var.= $bonificacion_ley;
        fwrite($fch, $bonificacion_ley); // Grabas
        $descuento_x_cargas_familiares_isl = rellenar(0,8,"i");
        //$var.= $descuento_x_cargas_familiares_isl;
        fwrite($fch, $descuento_x_cargas_familiares_isl); // Grabas
        $bonos_gobierno = rellenar(0,8,"i");
        //$var.= $bonos_gobierno;
        fwrite($fch, $bonos_gobierno); // Grabas
        $salud = datosSalud($empleado["id"]);
        $codigo_institucion_salud = rellenar($salud['codigo'],2,"i"); // es el 07
        //$var.= $codigo_institucion_salud;
        fwrite($fch, $codigo_institucion_salud); // Grabas
        $numero_fun = rellenar("",16,"s");
        //$var.= $numero_fun;
        fwrite($fch, $numero_fun); // Grabas
        $renta = tipoSalud($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        if ($renta['isapre_id'] == 0) {
            $renta_imponible_isapre = rellenar(0,8,"i");
        }else{
            $renta_imponible_isapre = rellenar($renta['totalImponible'],8,"i");
        }
        //$var.= $renta_imponible_isapre;
        fwrite($fch, $renta_imponible_isapre); // Grabas

        $datos_salud_moneda = tipoSalud($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        if ($datos_salud_moneda['isapre_id'] !== 0) {/* Si esta dentro de una Isapre */
            $datos_sal_mon = monedaSalud($empleado["id"]);
            if ($datos_sal_mon['tipo_moneda'] == 1) {
                $tipo_moneda_isapre = rellenar($datos_sal_mon['tipo_moneda'],1,"i");
                $red_cotizacion_pactada = round($datos_sal_mon['montoPlan']);
                $cotizacion_pactada = rellenar($red_cotizacion_pactada,8,"i");

                //$var.= $tipo_moneda_isapre;
                //$var.= $cotizacion_pactada;
                fwrite($fch, $tipo_moneda_isapre); // Grabas
                fwrite($fch, $cotizacion_pactada); // Grabas
            }else{
                $tipo_moneda_isapre = rellenar($datos_sal_mon['tipo_moneda'],1,"i");
                $separador = explode(".",$datos_sal_mon['montoPlan']);
                $var_cotizacion_pactada = $separador[0].",".$separador[1];
                $cotizacion_pactada = rellenar($var_cotizacion_pactada,8,"i");

                //$var.= $tipo_moneda_isapre;
                //$var.= $cotizacion_pactada;
                fwrite($fch, $tipo_moneda_isapre); // Grabas
                fwrite($fch, $cotizacion_pactada); // Grabas
            }

            $liquidacion_isapre = liquidacion($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
            $round_cotizacion_obligatoria_isapre = round($liquidacion_isapre['cotizacion_obligatoria_isapre']);
            $cotizacion_obligatoria_isapre = rellenar($round_cotizacion_obligatoria_isapre,8,"i");

            $round_cotizacion_adicional_voluntaria = round($liquidacion_isapre['aporte_voluntario']);
            $cotizacion_adicional_voluntaria = rellenar($round_cotizacion_adicional_voluntaria,8,"i");

            //$var.= $cotizacion_obligatoria_isapre;
            //$var.= $cotizacion_adicional_voluntaria;
            fwrite($fch, $cotizacion_obligatoria_isapre); // Grabas
            fwrite($fch, $cotizacion_adicional_voluntaria); // Grabas
            
        }else{
            $tipo_moneda_isapre = rellenar(0,1,"i");
            $cotizacion_pactada = rellenar(0,8,"i");
            $cotizacion_obligatoria_isapre = rellenar(0,8,"i");
            $cotizacion_adicional_voluntaria = rellenar(0,8,"i");

            //$var.= $tipo_moneda_isapre;
            //$var.= $cotizacion_pactada;
            //$var.= $cotizacion_obligatoria_isapre;
            //$var.= $cotizacion_adicional_voluntaria;
            fwrite($fch, $tipo_moneda_isapre); // Grabas
            fwrite($fch, $cotizacion_pactada); // Grabas
            fwrite($fch, $cotizacion_obligatoria_isapre); // Grabas
            fwrite($fch, $cotizacion_adicional_voluntaria); // Grabas
        }

        $monto_g_e_salud = rellenar(0,8,"i");
        //$var.= $monto_g_e_salud;
        fwrite($fch, $monto_g_e_salud); // Grabas*/

        $ccaf = CCAF();
        $cod_ccaf = $ccaf['codigo'];
        $codigo_CCAF = rellenar($cod_ccaf,2,"i");
        //$var.= $codigo_CCAF;
        fwrite($fch, $codigo_CCAF); // Grabas*/

        $imponible = liquidacion($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        $renta_imponible_CCAF = rellenar($imponible['totalImponible'],8,"i");
        //$var.= $renta_imponible_CCAF;
        fwrite($fch, $renta_imponible_CCAF); // Grabas*/

      /* esta variable hasta */  
        $credito_personales_ccaf = rellenar(0,8,"i");
        //$var.= $credito_personales_ccaf;
        fwrite($fch, $credito_personales_ccaf); // Grabas*/

        $descuento_dental = rellenar(0,8,"i");
        //$var.= $descuento_dental;
        fwrite($fch, $descuento_dental); // Grabas*/

        $descuento_leasing = rellenar(0,8,"i");
        //$var.= $descuento_leasing;
        fwrite($fch, $descuento_leasing); // Grabas*/

        $descuento_x_seguro = rellenar(0,8,"i");
        //$var.= $descuento_x_seguro;
        fwrite($fch, $descuento_x_seguro); // Grabas*/

        $otros_descuentos = rellenar(0,8,"i");
        //$var.= $otros_descuentos;
        fwrite($fch, $otros_descuentos); // Grabas*/

        $cotizacion_ccaf_no_isapres = rellenar($cotizacion_ccaf,8,"i");
        //$var.= $cotizacion_ccaf_no_isapres;
        fwrite($fch, $cotizacion_ccaf_no_isapres); // Grabas*/

        $descuento_cargas_familiares_ccaf = rellenar(0,8,"i");
        //$var.= $descuento_cargas_familiares_ccaf;
        fwrite($fch, $descuento_cargas_familiares_ccaf); // Grabas*/

        $otros_descuentos_ccaf = rellenar(0,8,"i");
        //$var.= $otros_descuentos_ccaf;
        fwrite($fch, $otros_descuentos_ccaf); // Grabas*/

        $otros_descuentos_ccaf_2 = rellenar(0,8,"i");
        //$var.= $otros_descuentos_ccaf_2;
        fwrite($fch, $otros_descuentos_ccaf_2); // Grabas*/

        $bono_gobierno = rellenar(0,8,"i");
        //$var.= $bono_gobierno;
        fwrite($fch, $bono_gobierno); // Grabas*/

        $codigo_sucursal = rellenar("",20,"s");
        //$var.= $codigo_sucursal;
        fwrite($fch, $codigo_sucursal); // Grabas*/

        /* esta variable, termina los CCAF */
        $m_mutual = mutualidad();
        $cod_mutual = $m_mutual['codigo'];
        $codigo_mutual = rellenar($cod_mutual,2,"i");
        //$var.= $codigo_mutual;
        fwrite($fch, $codigo_mutual); // Grabas*/

        $renta_imponible_mutual = rellenar($imponible['totalImponible'],8,"i");
        //$var.= $renta_imponible_mutual;
        fwrite($fch, $renta_imponible_mutual); // Grabas*/

        $suma_mutual = ($m_mutual['tasaBase'] + $m_mutual['tasaAdicional'] + $m_mutual['tasaExtraordinaria'] + $m_mutual['tasaLeyEspecial']);
        $multiplicacion_mutual = $suma_mutual * $imponible['totalImponible'];
        $division_mutual = $multiplicacion_mutual/100;
        $multiplicacion_redondeo_mutual = round($division_mutual);
        $cotizacion_accidente_trabajo = rellenar($multiplicacion_redondeo_mutual,8,"i");
        //$var.= $cotizacion_accidente_trabajo;
        fwrite($fch, $cotizacion_accidente_trabajo); // Grabas*/

        $sucursal_pago_mutual = rellenar(0,3,"i");
        //$var.= $sucursal_pago_mutual;
        fwrite($fch, $sucursal_pago_mutual); // Grabas*/

        $renta_imponible_seguro_cesantia = rellenar($imponible['totalImponible'],8,"i");
        //$var.= $renta_imponible_seguro_cesantia;
        fwrite($fch, $renta_imponible_seguro_cesantia); // Grabas*/

        $monto_porcentaje_trabajador = 0;
        $monto_porcentaje_empleador = 0;
        $aporte_trabajador = $imponible['totalImponible'];
        $afc_trabajador = afc($empleado["id"]);
        if ($afc_trabajador["id"] == 6) {
            $monto_porcentaje_trabajador = 0;
            $monto_porcentaje_empleador = ($aporte_trabajador * 3)/100;
        }elseif ($afc_trabajador["id"] == 5) {
            $monto_porcentaje_trabajador = 0;
            $monto_porcentaje_empleador = ($aporte_trabajador * 0.8)/100;
        }elseif ($afc_trabajador["id"] == 1) {
            $monto_porcentaje_trabajador = ($aporte_trabajador * 0.6)/100;
            $monto_porcentaje_trabajador = round($monto_porcentaje_trabajador);
            $monto_porcentaje_empleador = ($aporte_trabajador * 2.4)/100;
            $monto_porcentaje_empleador = round($monto_porcentaje_empleador);
        }
        $aporte_trabajador_seguro_cesantia = rellenar($monto_porcentaje_trabajador,8,"i");
        //$var.= $aporte_trabajador_seguro_cesantia;
        fwrite($fch, $aporte_trabajador_seguro_cesantia); // Grabas*/

        $aporte_empleador_seguro_cesantia = rellenar($monto_porcentaje_empleador,8,"i");
        //$var.= $aporte_empleador_seguro_cesantia;
        fwrite($fch, $aporte_empleador_seguro_cesantia); // Grabas*/

        $pagadorSubsidios = pagadorSubsidios($empleado["id"],$post['mesAtraso'],$post['anoAtraso']);
        $rut_pagador = explode("-",$pagadorSubsidios["rut"]);
        $rut_pagador_previred = rellenar($rut_pagador[0],11,"i");
        //$var.= $rut_pagador_previred;
        fwrite($fch, $rut_pagador_previred); // Grabas

        $dv_pagador = $rut_pagador[1];
        $dv_pagador_previred = rellenar($dv_pagador,1,"s");
        //$var.= $dv_pagador_previred;
        fwrite($fch, $dv_pagador_previred); // Grabas

        $otros_datos = rellenar("",20,"s");
        //$var.= $otros_datos;
        fwrite($fch, $otros_datos); // Grabas
        //show_array($arr_trabajadores_con_incidencia);
        fwrite($fch, PHP_EOL); // Grabas
        foreach ($arr_trabajadores_con_incidencia as $array_trabajadores) {
            if ($array_trabajadores['trabajador_id'] == $empleado["id"]) {
                if ($array_trabajadores['tipo_incidencia'] == 'movimientos') {
                    fwrite($fch, $rut); // Grabas
                    fwrite($fch, $dv); // Grabas
                    fwrite($fch, $apellidoPaterno); // Grabas
                    fwrite($fch, $apellidoMaterno); // Grabas
                    fwrite($fch, $nombres); // Grabas
                    fwrite($fch, $empleado_sexo); // Grabas
                    fwrite($fch, $nacionalidad); // Grabas
                    fwrite($fch, $tipo_pago); // Grabas
                    fwrite($fch, $periodoDesde); // Grabas
                    fwrite($fch, $periodoHasta); // Grabas
                    fwrite($fch, $tip_afp); // Grabas
                    fwrite($fch, $tip_trabajador); // Grabas

                    $dias_trabajado_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $dias_trabajado_movimientos); // Grabas

                    $tipo_linea_movimientos = "01";
                    $tipo_linea = rellenar($tipo_linea_movimientos,2,"s");
                    fwrite($fch, $tipo_linea); // Grabas
                    $codigo_movimientos = rellenar($array_trabajadores['codigo_movimiento'],2,"i");
                    fwrite($fch, $codigo_movimientos); // Grabas

                    if ($array_trabajadores !== null) {
                        if ($array_trabajadores['data']['fechas_limites']) {
                            $separador_fecha_inicio_movimientos = explode("-",$array_trabajadores['data']['fechas_limites']['fecha_inicio']);
                            $fecha_formateada_inicio_movimientos = $separador_fecha_inicio_movimientos[2]."-".$separador_fecha_inicio_movimientos[1]."-".$separador_fecha_inicio_movimientos[0];
                            $fecha_formateada_inicio_movimientos = rellenar($fecha_formateada_inicio_movimientos,10,"s");
                            fwrite($fch, $fecha_formateada_inicio_movimientos); // Grabas

                            $separador_fecha_fin_movimientos = explode("-",$array_trabajadores['data']['fechas_limites']['fecha_fin']);
                            $fecha_formateada_fin_movimientos = $separador_fecha_fin_movimientos[2]."-".$separador_fecha_fin_movimientos[1]."-".$separador_fecha_fin_movimientos[0];
                            $fecha_formateada_fin_movimientos = rellenar($fecha_formateada_fin_movimientos,10,"s");
                            fwrite($fch, $fecha_formateada_fin_movimientos); // Grabas
                        }else{
                            $unix_time = strtotime($array_trabajadores['data']['fecha_inicio']); 
                            $fecha_parseada_inicio = date('d-m-Y',$unix_time);
                            $fecha_formateada_inicio_movimientos = rellenar($fecha_parseada_inicio,10,"s");
                            fwrite($fch, $fecha_formateada_inicio_movimientos);

                            $unix_time = strtotime($array_trabajadores['data']['fecha_fin']); 
                            $fecha_parseada_fin = date('d-m-Y',$unix_time);
                            $fecha_formateada_fin_movimientos = rellenar($fecha_formateada_fin_movimientos,10,"s");
                            fwrite($fch, $fecha_parseada_fin); // Grabas
                        }
                    }

                    $tramo = rellenar("",1,"s");
                    fwrite($fch, $tramo); // Grabas

                    $num_cargas_simples_movimientos = rellenar("0",2,"i");
                    fwrite($fch, $num_cargas_simples_movimientos); // Grabas

                    $num_cargas_maternales_movimientos = rellenar("0",1,"i");
                    fwrite($fch, $num_cargas_maternales_movimientos); // Grabas

                    $num_cargas_invalidas_movimientos = rellenar("0",1,"i");
                    fwrite($fch, $num_cargas_invalidas_movimientos); // Grabas

                    $asignacion_familiar_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $asignacion_familiar_movimientos); // Grabas

                    $asignacion_familiar_retroactiva_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $asignacion_familiar_retroactiva_movimientos); // Grabas

                    $reintegro_cargas_familiares_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $reintegro_cargas_familiares_movimientos); // Grabas

                    $solicitud_trabajador_joven_movimientos = rellenar("",1,"s");
                    fwrite($fch, $solicitud_trabajador_joven_movimientos); // Grabas

                    $codigo_afp_movimientos = getCodigoAfp($empleado["id"]);
                    $codigo_afp_convertido = leadZero($codigo_afp_movimientos["codigo"]);
                    $codigo_afp_rellenar = rellenar($codigo_afp_convertido,2,"i");
                    fwrite($fch, $codigo_afp_rellenar); // Grabas

                    $renta_imponible_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $renta_imponible_movimientos); // Grabas

                    $cotizacion_obligatoria_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cotizacion_obligatoria_movimientos); // Grabas

                    $cotizacion_seguro_invalides_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cotizacion_seguro_invalides_movimientos); // Grabas

                    $cuenta_ahorro_afp_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cuenta_ahorro_afp_movimientos); // Grabas

                    $renta_imponible_sust_afp_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $renta_imponible_sust_afp_movimientos); // Grabas

                    $tasa_pactada_movimientos = $tasa_pactada;
                    fwrite($fch, $tasa_pactada_movimientos); // Grabas

                    $aporte_indemn_movimientos = $aporte_indemn;
                    fwrite($fch, $aporte_indemn_movimientos); // Grabas

                    $num_periodos = rellenar(0,2,"i");
                    fwrite($fch, $num_periodos); // Grabas

                    $periodoDesde_movimientos = rellenar("",10,"s");
                    fwrite($fch, $periodoDesde_movimientos); // Grabas

                    $periodoHasta_movimientos = rellenar("",10,"s");
                    fwrite($fch, $periodoHasta_movimientos); // Grabas

                    $puesto_trabajo_pesado_movimientos = rellenar("",40,"s");
                    fwrite($fch, $puesto_trabajo_pesado_movimientos); // Grabas

                    $porcentaje_cotizacion_trabajo_pesado_movimientos = $porcentaje_cotizacion_trabajo_pesado;
                    fwrite($fch, $porcentaje_cotizacion_trabajo_pesado_movimientos); // Grabas 

                    $cotizacion_trabajo_pesado_movimientos = rellenar(0,6,"i");
                    fwrite($fch, $cotizacion_trabajo_pesado_movimientos); // Grabas 

                    $codigo_institucion_apvi_movimientos = $codigo_institucion_apvi;
                    fwrite($fch, $codigo_institucion_apvi_movimientos); // Grabas

                    $numero_contrato_apvi_movimientos = $numero_contrato_apvi;
                    fwrite($fch, $numero_contrato_apvi_movimientos); // Grabas

                    $forma_pago_apvi_movimientos = $forma_pago_apvi;
                    fwrite($fch, $forma_pago_apvi_movimientos); // Grabas

                    $cotizacion_apvi_movimientos = $cotizacion_apvi;
                    fwrite($fch, $cotizacion_apvi_movimientos); // Grabas

                    $cotizacion_depositos_convenidos_movimientos = $cotizacion_depositos_convenidos;
                    fwrite($fch, $cotizacion_depositos_convenidos_movimientos); // Grabas

                    $codigo_institucion_autorizada_apvc_movimientos = $codigo_institucion_autorizada_apvc;
                    fwrite($fch, $codigo_institucion_autorizada_apvc_movimientos); // Grabas

                    $numero_contrato_apvc_movimientos = $numero_contrato_apvc;
                    fwrite($fch, $numero_contrato_apvc_movimientos); // Grabas

                    $forma_pago_apvc_movimientos = $forma_pago_apvc;
                    fwrite($fch, $forma_pago_apvc_movimientos); // Grabas

                    $cotizacion_trabajador_apvc_movimientos = $cotizacion_trabajador_apvc;
                    fwrite($fch, $cotizacion_trabajador_apvc_movimientos); // Grabas

                    $cotizacion_empleador_apvc_movimientos = $cotizacion_empleador_apvc;
                    fwrite($fch, $cotizacion_empleador_apvc_movimientos); // Grabas

                    $rut_afiliado_voluntario_movimientos = rellenar(0,11,"i");
                    fwrite($fch, $rut_afiliado_voluntario_movimientos); // Grabas

                    $dv_afiliado_voluntario_movimientos = rellenar("",1,"s");
                    fwrite($fch, $dv_afiliado_voluntario_movimientos); // Grabas

                    $apellidoPaterno_afiliado_voluntario_movimientos = rellenar("",30,"s");
                    fwrite($fch, $apellidoPaterno_afiliado_voluntario_movimientos); // Grabas

                    $apellidoMaterno_afiliado_voluntario_movimientos = rellenar("",30,"s");
                    fwrite($fch, $apellidoMaterno_afiliado_voluntario_movimientos); // Grabas

                    $nombres_afiliado_movimientos = rellenar("",30,"s");
                    fwrite($fch, $nombres_afiliado_movimientos); // Grabas

                    $codigo_movimiento_personal_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_movimiento_personal_movimientos); // Grabas

                    $fecha_desde_afiliado_movimientos = rellenar("",10,"s");
                    fwrite($fch, $fecha_desde_afiliado_movimientos); // Grabas

                    $fecha_hasta_afiliado_movimientos = rellenar("",10,"s");
                    fwrite($fch, $fecha_hasta_afiliado_movimientos); // Grabas

                    $codigo_afp_afiliado_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_afp_afiliado_movimientos); // Grabas

                    $monto_capitalizacion_voluntaria_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $monto_capitalizacion_voluntaria_movimientos); // Grabas

                    $monto_ahorro_voluntario_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $monto_ahorro_voluntario_movimientos); // Grabas

                    $numero_periodos_cotizacion_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $numero_periodos_cotizacion_movimientos); // Grabas

                    $codigo_ex_caga_regimen_movimientos = rellenar(0,4,"i");
                    fwrite($fch, $codigo_ex_caga_regimen_movimientos); // Grabas

                    $tasa_cotizacion_ex_caja_prevision_movimientos = "00,00";
                    fwrite($fch, $tasa_cotizacion_ex_caja_prevision_movimientos); // Grabas

                    $renta_imponible_ips_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_ips_movimientos); // Grabas

                    $cotizacion_obligatoria_ips_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_obligatoria_ips_movimientos); // Grabas

                    $renta_imponible_desahucio_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_desahucio_movimientos); // Grabas

                    $codigo_ex_caja_regimen_desahucio_movimientos = rellenar(0,4,"i");
                    fwrite($fch, $codigo_ex_caja_regimen_desahucio_movimientos); // Grabas

                    $tasa_cotizacion_desahucio_excaja_prevision_movimientos = "00,00";
                    fwrite($fch, $tasa_cotizacion_desahucio_excaja_prevision_movimientos); // Grabas

                    $cotizacion_desaucio_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_desaucio_movimientos); // Grabas

                    $cotizacion_fonasa_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_fonasa_movimientos); // Grabas

                    $cotizacion_acc_trabajo_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_acc_trabajo_movimientos); // Grabas

                    $bonificacion_ley_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $bonificacion_ley_movimientos); // Grabas

                    $descuento_x_cargas_familiares_isl_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_x_cargas_familiares_isl_movimientos); // Grabas

                    $bonos_gobierno_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $bonos_gobierno_movimientos); // Grabas

                    $codigo_institucion_salud_movimientos = $codigo_institucion_salud;
                    fwrite($fch, $codigo_institucion_salud_movimientos); // Grabas

                    $numero_fun_movimientos = rellenar(0,16,"i");
                    fwrite($fch, $numero_fun_movimientos); // Grabas

                    $renta_imponible_isapre_movimientos = $renta_imponible_isapre;
                    fwrite($fch, $renta_imponible_isapre_movimientos); // Grabas

                    $moneda_plan_isapre_movimientos = rellenar(0,1,"i");
                    fwrite($fch, $moneda_plan_isapre_movimientos); // Grabas

                    $cotizacion_pactada = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_pactada); // Grabas

                    $cotizacion_obligatoria_isapre_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_obligatoria_isapre_movimientos); // Grabas

                    $cotizacion_adicional_voluntaria_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_adicional_voluntaria_movimientos); // Grabas

                    $monto_g_e_salud_movimientos = $monto_g_e_salud;
                    fwrite($fch, $monto_g_e_salud_movimientos); // Grabas

                    $codigo_CCAF_movimientos = $codigo_CCAF;
                    fwrite($fch, $codigo_CCAF_movimientos); // Grabas

                    $renta_imponible_CCAF_movimientos = $renta_imponible_CCAF;
                    fwrite($fch, $renta_imponible_CCAF_movimientos); // Grabas

                    $credito_personales_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $credito_personales_ccaf_movimientos); // Grabas

                    $descuento_dental_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_dental_movimientos); // Grabas

                    $descuento_leasing_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_leasing_movimientos); // Grabas

                    $descuento_x_seguro_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_x_seguro_movimientos); // Grabas

                    $otros_descuentos_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_movimientos); // Grabas

                    $cotizacion_ccaf_no_isapres_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_ccaf_no_isapres_movimientos); // Grabas

                    $descuento_cargas_familiares_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_cargas_familiares_ccaf_movimientos); // Grabas

                    $otros_descuentos_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_ccaf_movimientos); // Grabas

                    $otros_descuentos_ccaf_2_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_ccaf_2_movimientos); // Grabas

                    $bonos_gobierno_movimientos_2 = rellenar(0,8,"i");
                    fwrite($fch, $bonos_gobierno_movimientos_2); // Grabas

                    $codigo_sucursal_movimientos = rellenar(0,20,"i");
                    fwrite($fch, $codigo_sucursal_movimientos); // Grabas

                    $codigo_mutual_movimientos = $codigo_mutual;
                    fwrite($fch, $codigo_mutual_movimientos); // Grabas

                    $renta_imponible_mutual_movimientos = $renta_imponible_mutual;
                    fwrite($fch, $renta_imponible_mutual_movimientos); // Grabas

                    $cotizacion_accidente_trabajo_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_accidente_trabajo_movimientos); // Grabas

                    $sucursal_pago_mutual_movimientos = $sucursal_pago_mutual;
                    fwrite($fch, $sucursal_pago_mutual_movimientos); // Grabas

                    $renta_imponible_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_seguro_cesantia_movimientos); // Grabas

                    $aporte_trabajador_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $aporte_trabajador_seguro_cesantia_movimientos); // Grabas

                    $aporte_empleador_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $aporte_empleador_seguro_cesantia_movimientos); // Grabas

                    $rut_pagador_previred_movimientos = $rut_pagador_previred;
                    fwrite($fch, $rut_pagador_previred_movimientos); // Grabas

                    $dv_pagador_previred_movimientos = $dv_pagador_previred;
                    fwrite($fch, $dv_pagador_previred_movimientos); // Grabas

                    $otros_datos_movimientos = rellenar("",20,"s");
                    fwrite($fch, $otros_datos_movimientos); // Grabas
                    fwrite($fch, PHP_EOL); // Grabas
                }
                elseif ($array_trabajadores['tipo_incidencia'] == 'apv') 
                {

                    fwrite($fch, $rut); // Grabas
                    fwrite($fch, $dv); // Grabas
                    fwrite($fch, $apellidoPaterno); // Grabas
                    fwrite($fch, $apellidoMaterno); // Grabas
                    fwrite($fch, $nombres); // Grabas
                    fwrite($fch, $empleado_sexo); // Grabas
                    fwrite($fch, $nacionalidad); // Grabas
                    fwrite($fch, $tipo_pago); // Grabas
                    fwrite($fch, $periodoDesde); // Grabas
                    fwrite($fch, $periodoHasta); // Grabas
                    fwrite($fch, $tip_afp); // Grabas
                    fwrite($fch, $tip_trabajador); // Grabas

                    $dias_trabajado_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $dias_trabajado_movimientos); // Grabas

                    $tipo_linea_movimientos = "01";
                    $tipo_linea = rellenar($tipo_linea_movimientos,2,"s");
                    fwrite($fch, $tipo_linea); // Grabas

                    $codigo_movimientos = rellenar($array_trabajadores['codigo_movimiento'],2,"i");
                    fwrite($fch, $codigo_movimientos); // Grabas

                    $separador_fecha_inicio_movimientos = explode("-",$array_trabajadores['data']['fechaHora']);
                    $separador_fecha_inicio_movimientos_dias = explode(" ",$separador_fecha_inicio_movimientos[2]);
                    $fecha_formateada_inicio_movimientos = $separador_fecha_inicio_movimientos_dias[0]."-".$separador_fecha_inicio_movimientos[1]."-".$separador_fecha_inicio_movimientos[0];
                    $fecha_formateada_inicio_movimientos = rellenar($fecha_formateada_inicio_movimientos,10,"s");
                    fwrite($fch, $fecha_formateada_inicio_movimientos); // Grabas

                    $separador_fecha_fin_movimientos = explode("-",$array_trabajadores['data']['fechaHora']);
                    $separador_fecha_fin_movimientos_dias = explode(" ",$separador_fecha_fin_movimientos[2]);
                    $fecha_formateada_fin_movimientos = $separador_fecha_fin_movimientos_dias[0]."-".$separador_fecha_fin_movimientos[1]."-".$separador_fecha_fin_movimientos[0];
                    $fecha_formateada_fin_movimientos = rellenar($fecha_formateada_fin_movimientos,10,"s");
                    fwrite($fch, $fecha_formateada_fin_movimientos); // Grabas

                    $tramo = rellenar("",1,"s");
                    fwrite($fch, $tramo); // Grabas

                    $num_cargas_simples_movimientos = rellenar("0",2,"i");
                    fwrite($fch, $num_cargas_simples_movimientos); // Grabas

                    $num_cargas_maternales_movimientos = rellenar("0",1,"i");
                    fwrite($fch, $num_cargas_maternales_movimientos); // Grabas

                    $num_cargas_invalidas_movimientos = rellenar("0",1,"i");
                    fwrite($fch, $num_cargas_invalidas_movimientos); // Grabas

                    $asignacion_familiar_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $asignacion_familiar_movimientos); // Grabas

                    $asignacion_familiar_retroactiva_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $asignacion_familiar_retroactiva_movimientos); // Grabas

                    $reintegro_cargas_familiares_movimientos = rellenar("0",6,"i");
                    fwrite($fch, $reintegro_cargas_familiares_movimientos); // Grabas

                    $solicitud_trabajador_joven_movimientos = rellenar("",1,"s");
                    fwrite($fch, $solicitud_trabajador_joven_movimientos); // Grabas

                    $codigo_afp_rellenar = rellenar(0,2,"i");
                    fwrite($fch, $codigo_afp_rellenar); // Grabas

                    $renta_imponible_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $renta_imponible_movimientos); // Grabas

                    $cotizacion_obligatoria_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cotizacion_obligatoria_movimientos); // Grabas

                    $cotizacion_seguro_invalides_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cotizacion_seguro_invalides_movimientos); // Grabas

                    $cuenta_ahorro_afp_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $cuenta_ahorro_afp_movimientos); // Grabas

                    $renta_imponible_sust_afp_movimientos = rellenar("0",8,"i");
                    fwrite($fch, $renta_imponible_sust_afp_movimientos); // Grabas

                    $tasa_pactada_movimientos = $tasa_pactada;
                    fwrite($fch, $tasa_pactada_movimientos); // Grabas

                    $aporte_indemn_movimientos = $aporte_indemn;
                    fwrite($fch, $aporte_indemn_movimientos); // Grabas

                    $num_periodos = rellenar(0,2,"i");
                    fwrite($fch, $num_periodos); // Grabas

                    $periodoDesde_movimientos = rellenar("",10,"s");
                    fwrite($fch, $periodoDesde_movimientos); // Grabas

                    $periodoHasta_movimientos = rellenar("",10,"s");
                    fwrite($fch, $periodoHasta_movimientos); // Grabas

                    $puesto_trabajo_pesado_movimientos = rellenar("",40,"s");
                    fwrite($fch, $puesto_trabajo_pesado_movimientos); // Grabas

                    $porcentaje_cotizacion_trabajo_pesado_movimientos = $porcentaje_cotizacion_trabajo_pesado;
                    fwrite($fch, $porcentaje_cotizacion_trabajo_pesado_movimientos); // Grabas 

                    $cotizacion_trabajo_pesado_movimientos = rellenar(0,6,"i");
                    fwrite($fch, $cotizacion_trabajo_pesado_movimientos); // Grabas 

                    $codigo_institucion_apvi_movimientos = $codigo_institucion_apvi;
                    fwrite($fch, $codigo_institucion_apvi_movimientos); // Grabas

                    $numero_contrato_apvi_movimientos = $numero_contrato_apvi;
                    fwrite($fch, $numero_contrato_apvi_movimientos); // Grabas

                    $forma_pago_apvi_movimientos = $forma_pago_apvi;
                    fwrite($fch, $forma_pago_apvi_movimientos); // Grabas

                    $cotizacion_apvi_movimientos = $cotizacion_apvi;
                    fwrite($fch, $cotizacion_apvi_movimientos); // Grabas

                    $cotizacion_depositos_convenidos_movimientos = $cotizacion_depositos_convenidos;
                    fwrite($fch, $cotizacion_depositos_convenidos_movimientos); // Grabas

                    $codigo_institucion_autorizada_apvc_movimientos = $codigo_institucion_autorizada_apvc;
                    fwrite($fch, $codigo_institucion_autorizada_apvc_movimientos); // Grabas

                    $numero_contrato_apvc_movimientos = $numero_contrato_apvc;
                    fwrite($fch, $numero_contrato_apvc_movimientos); // Grabas

                    $forma_pago_apvc_movimientos = $forma_pago_apvc;
                    fwrite($fch, $forma_pago_apvc_movimientos); // Grabas

                    $cotizacion_trabajador_apvc_movimientos = $cotizacion_trabajador_apvc;
                    fwrite($fch, $cotizacion_trabajador_apvc_movimientos); // Grabas

                    $cotizacion_empleador_apvc_movimientos = $cotizacion_empleador_apvc;
                    fwrite($fch, $cotizacion_empleador_apvc_movimientos); // Grabas

                    $rut_afiliado_voluntario_movimientos = rellenar(0,11,"i");
                    fwrite($fch, $rut_afiliado_voluntario_movimientos); // Grabas

                    $dv_afiliado_voluntario_movimientos = rellenar("",1,"s");
                    fwrite($fch, $dv_afiliado_voluntario_movimientos); // Grabas

                    $apellidoPaterno_afiliado_voluntario_movimientos = rellenar("",30,"s");
                    fwrite($fch, $apellidoPaterno_afiliado_voluntario_movimientos); // Grabas

                    $apellidoMaterno_afiliado_voluntario_movimientos = rellenar("",30,"s");
                    fwrite($fch, $apellidoMaterno_afiliado_voluntario_movimientos); // Grabas

                    $nombres_afiliado_movimientos = rellenar("",30,"s");
                    fwrite($fch, $nombres_afiliado_movimientos); // Grabas

                    $codigo_movimiento_personal_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_movimiento_personal_movimientos); // Grabas

                    $fecha_desde_afiliado_movimientos = rellenar("",10,"s");
                    fwrite($fch, $fecha_desde_afiliado_movimientos); // Grabas

                    $fecha_hasta_afiliado_movimientos = rellenar("",10,"s");
                    fwrite($fch, $fecha_hasta_afiliado_movimientos); // Grabas

                    $codigo_afp_afiliado_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_afp_afiliado_movimientos); // Grabas

                    $monto_capitalizacion_voluntaria_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $monto_capitalizacion_voluntaria_movimientos); // Grabas

                    $monto_ahorro_voluntario_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $monto_ahorro_voluntario_movimientos); // Grabas

                    $numero_periodos_cotizacion_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $numero_periodos_cotizacion_movimientos); // Grabas

                    $codigo_ex_caga_regimen_movimientos = rellenar(0,4,"i");
                    fwrite($fch, $codigo_ex_caga_regimen_movimientos); // Grabas

                    $tasa_cotizacion_ex_caja_prevision_movimientos = "00,00";
                    fwrite($fch, $tasa_cotizacion_ex_caja_prevision_movimientos); // Grabas

                    $renta_imponible_ips_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_ips_movimientos); // Grabas

                    $cotizacion_obligatoria_ips_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_obligatoria_ips_movimientos); // Grabas

                    $renta_imponible_desahucio_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_desahucio_movimientos); // Grabas

                    $codigo_ex_caja_regimen_desahucio_movimientos = rellenar(0,4,"i");
                    fwrite($fch, $codigo_ex_caja_regimen_desahucio_movimientos); // Grabas

                    $tasa_cotizacion_desahucio_excaja_prevision_movimientos = "00,00";
                    fwrite($fch, $tasa_cotizacion_desahucio_excaja_prevision_movimientos); // Grabas

                    $cotizacion_desaucio_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_desaucio_movimientos); // Grabas

                    $cotizacion_fonasa_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_fonasa_movimientos); // Grabas

                    $cotizacion_acc_trabajo_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_acc_trabajo_movimientos); // Grabas

                    $bonificacion_ley_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $bonificacion_ley_movimientos); // Grabas

                    $descuento_x_cargas_familiares_isl_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_x_cargas_familiares_isl_movimientos); // Grabas

                    $bonos_gobierno_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $bonos_gobierno_movimientos); // Grabas

                    $codigo_institucion_salud_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_institucion_salud_movimientos); // Grabas

                    $numero_fun_movimientos = rellenar(0,16,"i");
                    fwrite($fch, $numero_fun_movimientos); // Grabas

                    $renta_imponible_isapre_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_isapre_movimientos); // Grabas

                    $moneda_plan_isapre_movimientos = rellenar(0,1,"i");
                    fwrite($fch, $moneda_plan_isapre_movimientos); // Grabas

                    $cotizacion_pactada = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_pactada); // Grabas

                    $cotizacion_obligatoria_isapre_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_obligatoria_isapre_movimientos); // Grabas

                    $cotizacion_adicional_voluntaria_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_adicional_voluntaria_movimientos); // Grabas

                    $monto_g_e_salud_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $monto_g_e_salud_movimientos); // Grabas

                    $codigo_CCAF_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_CCAF_movimientos); // Grabas

                    $renta_imponible_CCAF_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_CCAF_movimientos); // Grabas

                    $credito_personales_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $credito_personales_ccaf_movimientos); // Grabas

                    $descuento_dental_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_dental_movimientos); // Grabas

                    $descuento_leasing_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_leasing_movimientos); // Grabas

                    $descuento_x_seguro_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_x_seguro_movimientos); // Grabas

                    $otros_descuentos_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_movimientos); // Grabas

                    $cotizacion_ccaf_no_isapres_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_ccaf_no_isapres_movimientos); // Grabas

                    $descuento_cargas_familiares_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $descuento_cargas_familiares_ccaf_movimientos); // Grabas

                    $otros_descuentos_ccaf_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_ccaf_movimientos); // Grabas

                    $otros_descuentos_ccaf_2_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $otros_descuentos_ccaf_2_movimientos); // Grabas

                    $bonos_gobierno_movimientos_2 = rellenar(0,8,"i");
                    fwrite($fch, $bonos_gobierno_movimientos_2); // Grabas

                    $codigo_sucursal_movimientos = rellenar(0,20,"i");
                    fwrite($fch, $codigo_sucursal_movimientos); // Grabas

                    $codigo_mutual_movimientos = rellenar(0,2,"i");
                    fwrite($fch, $codigo_mutual_movimientos); // Grabas

                    $renta_imponible_mutual_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_mutual_movimientos); // Grabas

                    $cotizacion_accidente_trabajo_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $cotizacion_accidente_trabajo_movimientos); // Grabas

                    $sucursal_pago_mutual_movimientos = rellenar(0,3,"i");
                    fwrite($fch, $sucursal_pago_mutual_movimientos); // Grabas

                    $renta_imponible_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $renta_imponible_seguro_cesantia_movimientos); // Grabas

                    $aporte_trabajador_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $aporte_trabajador_seguro_cesantia_movimientos); // Grabas

                    $aporte_empleador_seguro_cesantia_movimientos = rellenar(0,8,"i");
                    fwrite($fch, $aporte_empleador_seguro_cesantia_movimientos); // Grabas

                    $rut_pagador_previred_movimientos = rellenar(0,11,"i");
                    fwrite($fch, $rut_pagador_previred_movimientos); // Grabas

                    $dv_pagador_previred_movimientos = rellenar("",1,"s");
                    fwrite($fch, $dv_pagador_previred_movimientos); // Grabas

                    $otros_datos_movimientos = rellenar("",20,"s");
                    fwrite($fch, $otros_datos_movimientos); // Grabas
                    fwrite($fch, PHP_EOL); // Grabas
                }
            }
        }

        //$var.= PHP_EOL;

    }
    fclose($fch); // Cierras el archivo.

    // Headers for an download:
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="previred.txt"');
    readfile($archivo);
    //unlink($archivo);
    exit();
}

function afc($trabajador_id){
    global $db;

    $db->where("id",$trabajador_id);
    $result_mtrabajador = $db->getOne("m_trabajador");

    $db->where("id",$result_mtrabajador["tipotrabajador_id"]);
    $result = $db->getOne("m_tipotrabajador");
    return $result;
}

function pagadorSubsidios($trabajador_id, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $sql = "SELECT * FROM t_ausencia TA, m_ausencia MA WHERE month(fecha_inicio) = $mes AND year(fecha_inicio) = $ano AND TA.trabajador_id = $trabajador_id AND MA.licencia = 1 AND TA.ausencia_id = MA.id";

    $result = $db->rawQueryOne($sql);

    $db->where("codigo", $result['cod_previred_pagadora']);
    $result_mpagalicencia = $db->getOne('m_pagalicencia');


    if($result_mpagalicencia !== null){
        return $result_mpagalicencia;
    }elseif($result_isapre !== null){
        return $result_isapre;
    }else{
        return 0;
    }
    
}

function obtenerAusenciasPrevired($trabajador_id, $mes = "", $year = ""){

    global $db;

    //$periodo = getPeriodoCorte();

    //$mes = getMesMostrarCorte();
    //$year = getAnoMostrarCorte();

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $year == '' ){
        $year = (int)getAnoMostrarCorte();
    }


    $periodo = [ 
        'desde' => "$year-$mes-01", 
        'hasta' => "$year-$mes-".getLimiteMes($mes)
    ];

    //Proceso para obtener el
    $sql_fecha_fin = "
    SELECT * FROM `m_trabajador` WHERE id = $trabajador_id
    AND month(fechaContratoFin) = $mes
    AND year(fechaContratoFin) = $year
    ";
    $finiquito_este_mes = $db->rawQueryOne($sql_fecha_fin);

    if( $finiquito_este_mes ){
        $hasta = $finiquito_este_mes['fechaContratoFin'] . "  23:59:59";
    } else {
        $hasta = $periodo['hasta'].' 23:59:59';
    }
    
    $desde              = $periodo['desde'].' 00:00:00';

    $fechaInicio        = strtotime($periodo['desde']);
    $fechaFin           = strtotime($periodo['hasta']);    
    $arr_ausencias      = array();
    $total_ausencias    = 0;
    $dias_licencia      = 0;



    
    /** AUSENCIAS SIN INC. LICENCIAS **/
    $raw_query = "
    SELECT fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id, m_ausencia.codigoPrevired
    FROM t_ausencia, m_ausencia
    WHERE ( 
            fecha_inicio <= '$desde' 
            AND fecha_fin <= '$hasta' 
            AND fecha_fin >= '$desde' 
            AND trabajador_id = $trabajador_id 
            AND m_ausencia.id = t_ausencia.ausencia_id
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )            
            )
    OR ( 
        fecha_inicio >= '$desde' 
        AND fecha_fin >= '$hasta' 
        AND fecha_inicio <= '$hasta' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
    OR ( 
        fecha_inicio <= '$desde' 
        AND fecha_fin >= '$hasta' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
    OR ( 
        fecha_inicio >= '$desde' 
        AND fecha_fin <= '$hasta' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
        ORDER BY fecha_inicio
    ";    
    $res = $db->rawQuery($raw_query,'',false);

    if( $res ){
        foreach($res as $aus){
            $ausencias = 0;
            $date_fin_corte = new DateTime( $hasta );
            $date_fin_ausen = new DateTime( $aus['fecha_fin'] );
            
            $date_ini_corte = new DateTime( $desde );
            $date_ini_ausen = new DateTime( $aus['fecha_inicio'] );
            
            if( ( $date_ini_ausen <= $date_ini_corte ) && ( $date_fin_ausen <= $date_fin_corte ) ){
                $interval = $date_ini_corte->diff($date_fin_ausen);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($desde,$aus['fecha_fin'],$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $desde,
                    'fecha_fin' => $aus['fecha_fin'],
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id'],
                    'codigo_previred' => $aus['codigoPrevired']
                );
                $total_ausencias += $ausencias;
                //echo "1<br />";
            } elseif( ( $date_ini_ausen >= $date_ini_corte ) && ( $date_fin_ausen >= $date_fin_corte ) && ( $date_ini_ausen <= $date_fin_corte ) ){
                $interval = $date_ini_ausen->diff($date_fin_corte);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$hasta,$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $hasta,
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id'],
                    'codigo_previred' => $aus['codigoPrevired']
                );
                $total_ausencias += $ausencias;
                //echo "2<br />";
            } elseif( ( $date_ini_ausen <= $date_ini_corte ) && ( $date_fin_ausen >= $date_fin_corte ) ){                
                $interval = $date_ini_ausen->diff($date_fin_corte);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$hasta,$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $hasta,
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id'],
                    'codigo_previred' => $aus['codigoPrevired']
                );
                $total_ausencias += $ausencias;
                //echo "3<br />";
            } else {                
                $ausencias += $aus['dias'];
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$aus['fecha_fin'],$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $aus['fecha_fin'],
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id'],
                    'codigo_previred' => $aus['codigoPrevired']
                );   
                $total_ausencias += $ausencias;             
                //echo "4<br />";
            }    
        }
    }

    
    
    /** Ahora Se Recorren Las LICENCIAS **/
    $total_days_month = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $desde_licencia = $year . '-' . leadZero($mes) . '-01';
    $hasta_licencia = $year . '-' . leadZero($mes) . '-' . $total_days_month;  
    $sql_licencia = "
    SELECT fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id, m_ausencia.codigoPrevired
    FROM t_ausencia, m_ausencia
    WHERE ( 
            fecha_inicio <= '$desde_licencia' 
            AND fecha_fin <= '$hasta_licencia' 
            AND fecha_fin >= '$desde_licencia' 
            AND trabajador_id = $trabajador_id 
            AND m_ausencia.id = t_ausencia.ausencia_id
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )            
            )
    OR ( 
        fecha_inicio >= '$desde_licencia' 
        AND fecha_fin >= '$hasta_licencia' 
        AND fecha_inicio <= '$hasta_licencia' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1)
        )
    OR ( 
        fecha_inicio <= '$desde_licencia' 
        AND fecha_fin >= '$hasta_licencia' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
        )
    OR ( 
        fecha_inicio >= '$desde_licencia' 
        AND fecha_fin <= '$hasta_licencia' 
        AND trabajador_id = $trabajador_id 
        AND m_ausencia.id = t_ausencia.ausencia_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 ) 
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
        )
        ORDER BY fecha_inicio
    ";
    $res_licencias = $db->rawQuery($sql_licencia,'',false);    

    foreach($res_licencias as $aus){
        $ausencias = 0;
        $date_fin_mes = new DateTime( $hasta_licencia . ' 23:59:59' );
        $date_fin_ausen = new DateTime( $aus['fecha_fin'] );
        
        $date_ini_mes = new DateTime( $desde_licencia . ' 00:00:00' );
        $date_ini_ausen = new DateTime( $aus['fecha_inicio'] );                
        
        if( ( $date_ini_ausen <= $date_ini_mes ) && ( $date_fin_ausen <= $date_fin_mes ) ){
            $interval = $date_ini_mes->diff($date_fin_ausen);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $desde,
                'fecha_fin' => $aus['fecha_fin'],
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id'],
                'codigo_previred' => $aus['codigoPrevired']
            );
            $dias_licencia += $ausencias;
            //echo "1<br />";
        } elseif( ( $date_ini_ausen >= $date_ini_mes ) && ( $date_fin_ausen >= $date_fin_mes ) && ( $date_ini_ausen <= $date_fin_mes ) ){
            $interval = $date_ini_ausen->diff($date_fin_mes);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $hasta,
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id'],
                'codigo_previred' => $aus['codigoPrevired']
            );
            $dias_licencia += $ausencias;
            //echo "2<br />";
        } elseif( ( $date_ini_ausen <= $date_ini_mes ) && ( $date_fin_ausen >= $date_fin_mes ) ){                
            $interval = $date_ini_ausen->diff($date_fin_mes);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $hasta,
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id'],
                'codigo_previred' => $aus['codigoPrevired']
            );
            $dias_licencia += $ausencias;
            //echo "3<br />";
        } else {                
            $ausencias += $aus['dias'];
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $aus['fecha_fin'],
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id'],
                'codigo_previred' => $aus['codigoPrevired']
            );   
            $dias_licencia += $ausencias;             
            //echo "4<br />";
        }        
    }



    if( $dias_licencia > 30 ){
        $dias_licencia = 30;
    }


    if( esAnoBisiesto($year) ){
        $limiteFeb = 29;
    } else {
        $limiteFeb = 28;
    }
    

    if( ( $mes == 2 ) && ( $dias_licencia == $limiteFeb ) ){
        $dias_licencia += ( 30 - $limiteFeb );
    }

    

    /*********************************************/
    /**************** EXCEPCIONES ****************/
    /*********************************************/

    if( ( $trabajador_id == 643 ) && ($mes == 2) && ( $year == 2018 ) ){
        $dias_licencia = 30;
    }
    if( ( $trabajador_id == 358 ) && ($mes == 2) && ( $year == 2018 ) ){
        $dias_licencia = 29;
    }



    /** Proceso para determinar dias de NO enrolado **/
    $diasNoEnrolado = 0;
    
    $db->where('id',$trabajador_id);
    $fecha_inicio_contrato_plano = $db->getValue('m_trabajador','fechaContratoInicio');
    $fecha_inicio_contrato_plano .= ' 00:00:00';    
    $fecha_inicio_contrato = strtotime($fecha_inicio_contrato_plano);        

    $mes_enrolado = date('m',$fecha_inicio_contrato);
    $ano_enrolado = date('Y',$fecha_inicio_contrato);
    $mes_enrolado = (int)$mes_enrolado;

    
    if( ($mes_enrolado == $mes) && ( $ano_enrolado == $year ) ){
        /*
        $db->where('trabajador_id',$trabajador_id);
        $db->where('activo',1);
        $db->get('t_contrato');
        if( $db->count <= 2 ){
        */
            $datetime1 = new DateTime( $year.'-'.$mes.'-01 00:00:00' );
            $datetime2 = new DateTime( $fecha_inicio_contrato_plano );
            $interval = $datetime1->diff($datetime2);                    

            $diasNoEnrolado = $interval->days;
        //}
    }
    /** END **/


    /** Proceso para determinar dias que no trabajo por Finiquito **/
    $diasNoTrabajados = 0;
    
    $db->where('id',$trabajador_id);
    $fecha_fin_contrato_plano = $db->getValue('m_trabajador','fechaContratoFin');

    if($fecha_fin_contrato_plano != "0000-00-00"){                
        $fecha_fin_contrato = strtotime($fecha_fin_contrato_plano);
        $mes = leadZero($mes);
        $ano = $year;
        $fechaFinCorte=strtotime( $ano.'-'.$mes.'-30' );
        if( $mes == 2 ){
            $fechaFinCorte=strtotime( $ano.'-'.$mes.'-28' );
        }

        if( $fecha_fin_contrato < $fechaFinCorte ){
            if( ( date('m',$fechaFinCorte) == date('m',$fecha_fin_contrato) ) ){
                $datetime1 = new DateTime( $ano.'-'.$mes.'-01' );
                $datetime2 = new DateTime( $fecha_fin_contrato_plano );
                $interval = $datetime1->diff($datetime2);


                $diasAlcanzoATrabajar = $interval->days;
                $diasAlcanzoATrabajar++;
                if($diasAlcanzoATrabajar > 30){
                    $diasAlcanzoATrabajar = 0;
                }
            } else {
                $diasAlcanzoATrabajar = 0;
            }

            $diasNoTrabajados = ( 30 - $diasAlcanzoATrabajar );            
        }
    }
    /** END **/

    
    $arr_ausencias['dias_finiquito'] = $diasNoTrabajados;
    $arr_ausencias['dias_no_enrolado'] = $diasNoEnrolado;
    $arr_ausencias['dias_ausentismo'] = $total_ausencias;
    $arr_ausencias['dias_licencia'] = $dias_licencia;
    $arr_ausencias['total'] = ($total_ausencias + $dias_licencia + $diasNoEnrolado + $diasNoTrabajados );

    return $arr_ausencias;
}

function mutualidad(){
    global $db;

    $db->join("m_empresa", "m_mutual.id=m_empresa.mutual_id");
    $db->where("m_empresa.id", session('login_eid'));
    $result = $db->getOne("m_mutual");

    return $result;

}

function CCAF(){
    global $db;

    $db->join("m_empresa", "m_cajacompensacion.id=m_empresa.cajacompensacion_id");
    $db->where("m_empresa.id", session('login_eid'));
    $result = $db->getOne("m_cajacompensacion","m_cajacompensacion.codigo, m_cajacompensacion.nombre");
    return $result;
    
}

function descuentosCCAF($trabajador_id, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("ccaf_id",0,">");
    $db->where("empresa_id", session('login_eid'));
    $ids = $db->get("m_descuento",null,"id");

    $ids_sql_descuentosCCAF = [];

    foreach ($ids as $result) {
        $ids_sql_descuentosCCAF[] = $result['id'];
    }

    $db->join("l_descuento", "liquidacion.id=l_descuento.liquidacion_id");
    $db->where("liquidacion.mes", $mes);
    $db->where("liquidacion.ano", $ano);
    $db->where("liquidacion.trabajador_id", $trabajador_id);
    $db->where('l_descuento.descuento_id', $ids_sql_descuentosCCAF, 'IN');
    $results = $db->get("l_descuento");

    return $results;

}

function liquidacion ($trabajador_id, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("trabajador_id", $trabajador_id);
    $db->where("mes", $mes);
    $db->where("ano", $ano);
    //$db->where("apellidoPaterno","FARIAS");
    $liquidacion = $db->getOne("liquidacion");
    $cotizacion_obligatoria_isapre = ($liquidacion['totalImponible'] * 0.07);
    $floor_cotizacion_obligatoria_isapre = floor($cotizacion_obligatoria_isapre);
    $aporte_voluntario = ($liquidacion['saludMonto']-$floor_cotizacion_obligatoria_isapre);
    $monto_imponible = $liquidacion['totalImponible'];
    $afc_monto = $liquidacion['afcMonto'];

    $datos_liquidacion = [];
    $datos_liquidacion = [
        'cotizacion_obligatoria_isapre' => $cotizacion_obligatoria_isapre,
        'aporte_voluntario' => $aporte_voluntario,
        'totalImponible' => $monto_imponible,
        'afcMonto' => $afc_monto,
    ];

    return $datos_liquidacion;
}

function monedaSalud($trabajador_id){
    global $db;

    $return_datos = [];

    $db->where("trabajador_id", $trabajador_id);
    $mon_salud = $db->getOne("t_prevision");

    if ($mon_salud['isapre_id'] !== 0) {

        $db->where("id", $mon_salud['tipomoneda_id']);
        $db->where("empresa_id", $_SESSION[PREFIX.'login_eid']);
        $tipo_mon = $db->getOne("m_tipomoneda");

        $return_datos = [
            'tipo_moneda' => $tipo_mon['id'],
            'montoPlan' => $mon_salud['montoPlan']
        ];
    }
    return $return_datos;
}

function tipoSalud($trabajador_id, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("trabajador_id", $trabajador_id);
    $tipo_salud = $db->getOne("t_prevision");

    if ($tipo_salud['fonosa'] == 1) {

        $db->where("trabajador_id", $trabajador_id);
        $db->where("ano", $ano);
        $db->where("mes", $mes);
        $liquidacion_fonasa = $db->getOne("liquidacion");
        return $liquidacion_fonasa;

    }elseif ($tipo_salud['isapre_id'] !== 0) {

        $db->where("trabajador_id", $trabajador_id);
        $db->where("isapre_id", $tipo_salud['isapre_id']);
        $db->where("ano", $ano);
        $db->where("mes", $mes);
        $liquidacion_isapre = $db->getOne("liquidacion");
        return $liquidacion_isapre;
    }
}

function datosSalud($trabajador_id){
    global $db;

    $db->where("trabajador_id", $trabajador_id);
    $tipo_salud = $db->getOne("t_prevision");

    if ($tipo_salud['fonosa'] == 1) {
        $institucion = [];

        $institucion = [
            'id' => 0,
            'nombre' => 'fonasa',
            'codigo' => 07,
            'activo' => 0
        ];
        return $institucion;

    }elseif ($tipo_salud['isapre_id'] !== 0) {

        $db->where("id", $tipo_salud['isapre_id']);
        $institucion = $db->getOne("m_isapre");
        return $institucion;
    }
}

function tipoMoneda($tipomoneda_id){
    global $db;

    $db->where("id", $tipomoneda_id);
    //$db->where("apellidoPaterno","FARIAS");
    $tipo_moneda = $db->getOne("m_tipomoneda");

    return $tipo_moneda;
}

function valorMoneda($tipomoneda_id, $mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = (int)getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = (int)getAnoMostrarCorte();
    }

    $db->where("tipomoneda_id", $tipomoneda_id);
    $db->where("mes", $mes);
    $db->where("ano", $ano);
    //$db->where("apellidoPaterno","FARIAS");
    $valor_moneda = $db->getOne("m_tipomonedavalor");

    return $valor_moneda;
}

function sqlAusencia($mes = "", $ano = ""){
    global $db;

    if( $mes == '' ){
        $mes = getMesMostrarCorte();
    }
    if( $ano == '' ){
        $ano = getAnoMostrarCorte();
    }

    $sql = "
    SELECT TA.trabajador_id, TA.fecha_inicio, TA.fecha_fin, TA.totalDias, A.licencia, A.nombre
    FROM t_ausencia TA, m_ausencia A
    WHERE TA.ausencia_id = A.id
    AND month(fecha_inicio) = $mes
    AND year(fecha_inicio) = $ano
    ";

    $results= $db->rawQuery($sql);

    $ids_sql_ausencia = [];
    $datos_retorno_sql_ausencia = [];
    foreach ($results as $result) {
        $ids_sql_ausencia[] = $result["trabajador_id"];
        $datos_retorno_sql_ausencia[$result["trabajador_id"]][] = [
            'todo' => $result
        ];
    }

    $super_array["ausencia"] = [
        'trabajadores_ids' => $ids_sql_ausencia,
        'datos' => $datos_retorno_sql_ausencia
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
        'trabajadores_ids' => $ids_licencias,
        'datos' => $datos_retorno_licencias
    ];

    return $super_array;
}

function tieneAusencia($trabajador_id, $super_array){

    $ausencia = 0;

    if( in_array($trabajador_id, $super_array['ausencia']['trabajadores_ids']) ){
        $ocurrencias = array_count_values($super_array['ausencia']['trabajadores_ids']);

        if( $ocurrencias[$trabajador_id] >= 1 ){
            $ausencia = $ocurrencias[$trabajador_id];
        }

    } else {
        return $ausencia;
    }

    
    return $ausencia;
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
    WHERE T.id = C.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."  
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
        AND month(T.fechaContratoInicio) = $mes
        AND year(T.fechaContratoInicio) = $year   
        AND T.fechaContratoFin != '0000-00-00'
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

    $array_return = [];

    if (in_array($trabajador_id,$super_array["inicio_plazo_fijo_mes"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 7,
            'fechas_limites' => $super_array["inicio_plazo_fijo_mes"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'inicio_plazo_fijo_mes'
        ];
    }
    if (in_array($trabajador_id,$super_array["licencias"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 3,
            'fechas_limites' => $super_array["licencias"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'licencias'
        ];
    }
    if (in_array($trabajador_id,$super_array["ausencias_no_justificadas"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 11,
            'fechas_limites' => $super_array["ausencias_no_justificadas"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'ausencias_no_justificadas'
        ];
    }
    if (in_array($trabajador_id,$super_array["indefinidos_mes"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 1,
            'fechas_limites' => $super_array["indefinidos_mes"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'indefinidos_mes'
        ];
    }
    if (in_array($trabajador_id,$super_array["plazo_fijo_durante_mes"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 7,
            'fechas_limites' => $super_array["plazo_fijo_durante_mes"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'plazo_fijo_durante_mes'
        ];
    }
    if (in_array($trabajador_id,$super_array["plazo_a_indefinido"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 8,
            'fechas_limites' => $super_array["plazo_a_indefinido"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'plazo_a_indefinido'
        ];
    }
    if (in_array($trabajador_id,$super_array["despidos"]["ids"])) {
        $array_return[] = [
            'codigo_movimiento' => 2,
            'fechas_limites' => $super_array["despidos"]["datos"][$trabajador_id],
            'tipo_movimiento' => 'despidos'
        ];
    }

    return $array_return;
}

?>
