<?php
@session_start();



/**
 * Retorna "Haber" o "Descuento" segun caracter D o H
 * 
 * @param bool, el valor booleano en 0 ó 1
 * @return string, SI ó NO
 */
function getDebeHaber($char){
    $char = strtolower($char);
    if( $char == 'd' ){
        return 'Debe';
    } elseif ($char == 'h') {
        return "Haber";
    } else {
        return "-";
    }
}

    
/**
 * Se conecta a una base de datos SQL Server y realiza una Query
 * Por seguridad, solo realiza consultas de datos, no escribe ni actualiza
 * @param (string) $sql Consulta SQL a realizar
 * @return (array) $arr_return Arreglo con los datos resultantes de la consulta sql  
 */ 
function sqlServQuery($sql){

    try {
        $conn = new PDO("sqlsrv:server=".SQLSERV_HOST.";database=".SQLSERV_DBNAME, SQLSERV_USER, SQLSERV_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Ocurrió un error con la base de datos: " . $e->getMessage();
    }

    $arr_return = [];
    $query = $sql;
    $stmt = $conn->query( $query );
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $arr_return[] = $row;
    }
    
    // Liberar la conexion;
    $stmt = null;
    $conn = null;
    
    return $arr_return;
}

function getRepresentante($empresa_id){
    global $db;
    $representante = [];

    $db->where("id", $empresa_id);
    $result = $db->getOne("m_empresa");
    
    if( !$db->count ){
        return false;
    } else { 
        $representante['nombre'] = $result['representante'];
        $representante['rut'] = $result['rut_representante'];

        return $representante;
    }
}

/**
 * Respaldar base de datos de MySQL con PHP
 * Función modificada de: https://stackoverflow.com/a/21284229/5032550
 *
 * Visita: https://parzibyte.me/blog/2018/10/22/script-respaldar-base-de-datos-mysql-php/
 */

// Ejemplo de llamada: exportarTablas("localhost", "root", "123", "foo");

function exportarTablas($host, $usuario, $pasword, $nombreDeBaseDeDatos)
{
    
    if(!file_exists(ROOT . '/respaldos/backup_' . date('Y-m-d') . '.sql')){

        set_time_limit(3000);
        $tablasARespaldar = [];
        $mysqli = new mysqli($host, $usuario, $pasword, $nombreDeBaseDeDatos);
        $mysqli->select_db($nombreDeBaseDeDatos);
        $mysqli->query("SET NAMES 'utf8'");
        $tablas = $mysqli->query('SHOW TABLES');
        while ($fila = $tablas->fetch_row()) {
            $tablasARespaldar[] = $fila[0];
        }
        $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";
        foreach ($tablasARespaldar as $nombreDeLaTabla) {
            if (empty($nombreDeLaTabla)) {
                continue;
            }
            $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
            $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
            $cantidadDeFilas = $mysqli->affected_rows;
            $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
            $filaDeTabla = $esquemaDeTabla->fetch_row();
            $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
            for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
                while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                    //La primera y cada 100 veces
                    if ($contador % 100 == 0 || $contador == 0) {
                        $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                    }
                    $contenido .= "\n(";
                    for ($j = 0; $j < $cantidadDeCampos; $j++) {
                        $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                        if (isset($fila[$j])) {
                            $contenido .= '"' . $fila[$j] . '"';
                        } else {
                            $contenido .= '""';
                        }
                        if ($j < ($cantidadDeCampos - 1)) {
                            $contenido .= ',';
                        }
                    }
                    $contenido .= ")";
                    # Cada 100...
                    if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                        $contenido .= ";";
                    } else {
                        $contenido .= ",";
                    }
                    $contador = $contador + 1;
                }
            }
            $contenido .= "\n\n\n";
        }
        $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

        # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
        $carpeta = ROOT . "/respaldos";

        # Calcular un ID único
        $id = uniqid();

        # También la fecha
        $fecha = date("Y-m-d");

        # Crear un archivo que tendrá un nombre como respaldo_2018-10-22.sql
        $nombreDelArchivo = sprintf('%s/backup_%s.sql', $carpeta, $fecha, $id);

        #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
        if( file_put_contents($nombreDelArchivo, $contenido) ){
            return true;
        } else {
            return false;    
        }
        
    } else {
        return true;
    }
}


/**
 * Determina si el trabajador esta finiquitado en la fecha dada
 * @param (int) $trabajador_id ID del trabajador a consultar
 * @param (date) $fecha Fecha a consultar     
 * @return (bool) True o False si ya esta finiquitado en la fecha pasada por parametro  
 */
function pagaPlanCompleto($trabajador_id){
    global $db;
    
    $db->where("id", $trabajador_id);
    $db->where("forzar_plan_completo", 1);
    $forzar_plan = $db->get("m_trabajador");
    if( $db->count ){
        return true;
    } else { 
            return false;
    }
}


/**
 * Determina si el trabajador esta finiquitado en la fecha dada
 * @param (int) $trabajador_id ID del trabajador a consultar
 * @param (date) $fecha Fecha a consultar     
 * @return (bool) True o False si ya esta finiquitado en la fecha pasada por parametro  
 */
function estaFiniquitado($trabajador_id, $fecha){
    global $db;
    
    
    $db->where("id", $trabajador_id);
    $db->where("tipocontrato_id", 3);
    $trabajador_finiquitado = $db->get("m_trabajador");    
    if( $db->count ){
        return true;
    } else { 
        
        $db->where("id", $trabajador_id);        
        $db->where("fechaContratoFin", '0000-00-00', '!=');
        $db->where("fechaContratoFin", $fecha, '<');
        $contratos_asignados = $db->getOne("m_trabajador");
                
        if( $db->count ){
            return true;            
        } else {
            return false;
        }   
    }     
}


/**
 * Retorna un arreglo con las horas marcadas a la entrada y salida
 * los dias que son feriados o NO laborales (Gralmente. fines de semana)
 * @param (string) $fecha Fecha a consultar
 * @param (int) $trabajador_id ID del trabajador a consultar
 * @return (array) $arr_return Arreglo con los marcajes de entrada y salida  
 */
function getMarcajeFDS($fecha, $trabajador_id){
    global $db;
    
    $date_iterar = $fecha;    
    $db->where('id',$trabajador_id);
    $relojcontrol_id = $db->getValue('m_trabajador','relojcontrol_id');
    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $umbral = $db->getValue('m_empresa','umbralRelojControl');
    
    $sql = "
    SELECT  * FROM m_relojcontrol 
    WHERE  userid = '$relojcontrol_id' 
    AND checktime LIKE '$date_iterar %'              
    ORDER BY checktime ASC
    ";                     
    $marcajes = $db->rawQuery($sql);                                                                               
    
    if( $db->count == 1 ){
        $unix_hora_umbral = strtotime( $date_iterar . ' ' . $umbral );
        $unix_hora_marcada = strtotime( $marcajes[0]['checktime'] );    

        $temp_timestamp = strtotime($marcajes[0]['checktime']);

        if( $unix_hora_marcada > $unix_hora_umbral ){
            $salidas[] = array(
                'id' => $marcajes[0]['id'],
                'userid' => $marcajes[0]['userid'],
                'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp),
                'checktype' => $marcajes[0]['checktype'],
                'logid' => $marcajes[0]['logid']
            );
        } else {
            $entradas[] = array(
                'id' => $marcajes[0]['id'],
                'userid' => $marcajes[0]['userid'],
                'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp),
                'checktype' => $marcajes[0]['checktype'],
                'logid' => $marcajes[0]['logid']
            );
        }   
    } 
    
    if( $db->count > 1 ){
        
        $primer_marcaje = 0;
        $ultimo_marcaje = ( count($marcajes) - 1 ); 

        $temp_timestamp_I = strtotime($marcajes[$primer_marcaje]['checktime']);
        $temp_timestamp_O = strtotime($marcajes[$ultimo_marcaje]['checktime']);

        $entradas[] = array(
            'id' => $marcajes[$primer_marcaje]['id'],
            'userid' => $marcajes[$primer_marcaje]['userid'],
            'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp_I),
            'checktype' => $marcajes[$primer_marcaje]['checktype'],
            'logid' => $marcajes[$primer_marcaje]['logid']
        );
        $salidas[] = array(
            'id' => $marcajes[$ultimo_marcaje]['id'],
            'userid' => $marcajes[$ultimo_marcaje]['userid'],
            'checktime' => date('Y-m-d H:i:\0\0',$temp_timestamp_O),
            'checktype' => $marcajes[$ultimo_marcaje]['checktype'],
            'logid' => $marcajes[$ultimo_marcaje]['logid']
        );
    } 
    
    $entradas = $entradas[0];
    $salidas = $salidas[0];
    
    $arr_return = array(
        "entrada" => $entradas,
        "salida" => $salidas
    );
    
    return $arr_return;
}


/**
 * Guarda en la base de datos un log de todos los cambios
 * @param (string) $user_nombre Nombre Real del usuario logueado     
 * @return (string) $url Url Actual  
 */
function logit($user_nombre, $action, $entity, $id=null, $sql="", $empresa_id=0){
    //global $db;
    
    $empresa_id = $_SESSION[PREFIX.'login_eid'];
    $data = array(
        'nombre' => $user_nombre,
        'entidad' => $entity,
        'accion' => $action,
        'consulta_sql' => $sql,
        'empresa_id' => $empresa_id
    );


    $filename = ROOT.'/logs/log_'.date('Y-m').'.txt';

    $data_write = $user_nombre."|".$entity."|".$action."|".$sql."|".$empresa_id."|".$id."|".date('Y-m-d H:i:s');

    file_put_contents($filename, $data_write . PHP_EOL, FILE_APPEND);


    //$db->insert('log',$data);
    
    return true;
}

/**
 * Envía un mail usando un servidor externo    
 * @param (array) $arr_query_post Arreglo con los datos $_POST
 * Los cuales son los siguientes 
 *  'token' => Token generado usando la funcion generateToken(),
    'currUrl' => URL a la cual quiero direccionar despues del envío del correo,
    'mailto' => Mail destinatario,
    'nombre' => Nombre del destinatario,
    'new_hash' => Hash para el reestablecimiento de contraeña (opcional, pero debe ir vacío en caso de no usar),
    'body' => Cuerpo del mensaje
 */
function enviarMailExterno($arr_query_post){

    $to      = $arr_query_post['mailto'];
	$subject = $arr_query_post['subject'];
	$message = $arr_query_post['body'];
	$header = "From: Tecnodata <no_responder@tecnodatasa.cl>\r\n"; 
	$header.= "MIME-Version: 1.0\r\n"; 
	$header.= "Content-Type: text/html; charset=utf-8\r\n"; 
	$header.= "X-Priority: 1\r\n"; 
	
	if( mail($to,$subject,$message,$header) ){ 
	    return true;
	} else { 
	    return false;
	}

    
    /*
	$datos_post = http_build_query( $arr_query_post );    
    $opciones = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $datos_post
        )
    );    
    $contexto = stream_context_create($opciones);            
    $resultado = file_get_contents('http://www.daft.cl/lab/tdmailer/tdmailer.php', false, $contexto);    

    
    
    if( ! $resultado ){
        return false;
    } else {
        return true;
    }
    */
}

/**
 * Retorna la URL actual     
 * @return (string) $url Url Actual  
 */
function currentUrl(){
    $url = $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * Genera un TOKEN unico segun el dia, mes, año, hora y minuto
 * para pasarlo al server externo que envía correos     
 * @return (string) $token El TOKEN  
 */
function generateToken($mailto){
    $time = (int)(date('Ymd'));           
    $tecnodata_server_time = $time;        
    $user = "tecnodata";
    $pass = "tecnochamba";
    $string_token = $user."|".$pass."|".$tecnodata_server_time."|".$mailto;
    $base64_toke = base64_encode($string_token);
    $token = md5($base64_toke);
        
    return $token;     
}

/**
 * Obtiene el total de minutos de atraso de un mes determinado    
 * @param (int) $mes Mes a consultar
 * @param (int) $ano Año a consultar 
 * @param (int) $trabajador_id ID del trabajador
 * @return (array) $array_return Arreglo con 2 valores: Total de minutos  y dias que tiene atrasos
 */
function getMinutosAtrasoMes( $mes, $ano, $trabajador_id){
    global $db;
    
    $array_return = array();
    
    //Obtener el horario del trabajador
    $db->where("id",$trabajador_id);
    $horario_id = $db->getValue('m_trabajador','horario_id');
    
    //Obtener la hora de entrada segun el horario del trabajador    
    $db->where("id",$horario_id);
    $horario_entrada = $db->getValue('m_horario','entradaTrabajo');
             
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $umbral = $db->getValue('m_empresa','umbralRelojControl');
    
    //obtener el atraso del trabajador, del dia solicitado 
    $sql = "
    SELECT T.id, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, T.horario_id, R.checktime, R.checktype 
    FROM m_trabajador T, m_relojcontrol R 
    WHERE T.relojcontrol_id = R.userid 
    AND R.checktime LIKE '$ano-$mes%'        
    AND time( checktime ) < '$umbral'
    AND time( checktime ) > '$horario_entrada'
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    AND T.marcaTarjeta = 1
    AND T.id = $trabajador_id
    ";
    $result = $db->rawQuery( $sql );     
    
    if( $db->count > 0 ){                
        
        $total_minutos = 0;
        foreach( $result as $marcaje ){            
            $arr_marcaje = explode(" ",$marcaje['checktime']);
            $date1 = new DateTime( $marcaje['checktime'] );
            $date2 = new DateTime( $arr_marcaje[0] . " " . $horario_entrada );
            $interval = $date1->diff($date2);        
            $minutos = $interval->i;
            $horas_en_minutos = ( $interval->h * 60 );
            $total_minutos += $minutos + $horas_en_minutos;
        }
        $int_minutos = $total_minutos;        
                                
    } else {
        $int_minutos = 0;
     
    }
        
    $array_return['minutos'] = $int_minutos;
    $array_return['total_atrasos'] = $db->count;
    
    return $array_return;
}



/**
 * Obtiene el total de minutos de atraso de una fecha determinada    
 * @param (date) $date Fecha en formayo YYYY-mm-dd
 * @param (int) $trabajador_id ID del trabajador
 * @return (int) $int_minutos Total de minutos  
 */
function getMinutosAtraso( $date, $trabajador_id){
    global $db;
    
    //Obtener el horario del trabajador
    $db->where("id",$trabajador_id);
    $horario_id = $db->getValue('m_trabajador','horario_id');
    
    //Obtener la hora de entrada segun el horario del trabajador    
    $db->where("id",$horario_id);
    $horario_entrada = $db->getValue('m_horario','entradaTrabajo');
        
    // Obtener el UMBRAL x empresa        
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $umbral = $db->getValue('m_empresa','umbralRelojControl');
    
    //obtener el atraso del trabajador, del dia solicitado 
    $sql = "
    SELECT T.id, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, T.horario_id, R.checktime, R.checktype 
    FROM m_trabajador T, m_relojcontrol R 
    WHERE T.relojcontrol_id = R.userid 
    AND R.checktime LIKE '$date%'        
    AND time( checktime ) < '$umbral'
    AND time( checktime ) > '$horario_entrada'
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    AND T.marcaTarjeta = 1
    AND T.id = $trabajador_id
    ";    
    $result = $db->rawQuery( $sql );        
        
    if( $db->count > 0 ){
        $result = $result[0];                                             
        
        $date1 = new DateTime( $result['checktime'] );
        $date2 = new DateTime( $date . " " . $horario_entrada );
        $interval = $date1->diff($date2);        
        $minutos = $interval->i;
        $horas_en_minutos = ( $interval->h * 60 );
        $total_minutos = $minutos + $horas_en_minutos;            
                
        $int_minutos = $total_minutos;
                                
    } else {
        $int_minutos = 0;
     
    }
                               
    return $int_minutos;
} 


/**
 * Traduce el dia de la semana 
 * y dias feriados, recive por parametros las fechas limites de la ausencia   
 * @param (int) $int Numero del dia. Se usa la funcion date('w') que devuelve de 0 a 6
 * @return (string) $str_dia Nombre del dia en español  
 */
function getNombreDia($int){
    switch( $int ){
        case 0: $str_dia = 'Lunes'; break;
        case 1: $str_dia = 'Martes'; break;
        case 2: $str_dia = 'Miércoles'; break;
        case 3: $str_dia = 'Jueves'; break;
        case 4: $str_dia = 'Viernes'; break;
        case 5: $str_dia = 'Sábado'; break;
        case 6: $str_dia = 'Domingo'; break;                
        default: $str_dia = ''; break;
    }
    
    return $str_dia;
}

/**
 * Devuelve el numero ORDINAL escrito en palabras 
 * y dias feriados, recive por parametros las fechas limites de la ausencia   
 * @param (int) $int Numero entero
 * @return (string) $str_ordinal Numero ORDINAL en palabras  
 */
function ordinalEnPalabras($int){
    switch( $int ){
        case 1: $str_ordinal = 'Primer'; break;
        case 2: $str_ordinal = 'Segundo'; break;
        case 3: $str_ordinal = 'Tercer'; break;
        case 4: $str_ordinal = 'Cuarto'; break;
        case 5: $str_ordinal = 'Quinto'; break;
        case 6: $str_ordinal = 'Sexto'; break;
        case 7: $str_ordinal = 'Séptimo'; break;
        case 8: $str_ordinal = 'Octavo'; break;
        case 9: $str_ordinal = 'Noveno'; break;
        case 10: $str_ordinal = 'Décimo'; break;
        default: $str_ordinal = ''; break;
    }
    
    return $str_ordinal;
}


/**
 * Determinar la cantidad de dias que no son laborales segun el maestro de horario 
 * y dias feriados, recive por parametros las fechas limites de la ausencia   
 * @param (date) $fecha_ini Fecha inicial de la ausencia
 * @param (date) $fecha_fin Fecha final de la ausencia
 * @param (int) $trabajador_id ID del trabajador 
 * @return (decimal) Cantidad de horas extras justificadas  
 */
function diasNoLaborales($fecha_ini, $fecha_fin,$trabajador_id){
    global $db;
    $restar = 0;
    
    // Obtener el id del horario del trabajador    
    $db->where('id',$trabajador_id);
    $horario_id = $db->getValue('m_trabajador','horario_id');
    
    //Llenar arreglo con los dias laborales
    $db->where('id',$horario_id);
    $m_horarios = $db->getOne('m_horario');
    $array_dias_temp = array($m_horarios['lun'],$m_horarios['mar'],$m_horarios['mie'],$m_horarios['jue'],$m_horarios['vie'],$m_horarios['sab'],$m_horarios['dom']);
    $dias_laborales_horario = array();
    foreach( $array_dias_temp as $k => $i ){
        if( $i == 1 ){
            $dias_laborales_horario[] = $k;
        }
    }        
    
    $fechaInicio=strtotime($fecha_ini);
    $fechaFin=strtotime($fecha_fin);
    
    
    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        $fecha_iterar = date("Y-m-d", $i); 
        $dia_semana = date('N', strtotime($fecha_iterar));
        $dia_semana--;        
        if( !in_array($dia_semana,$dias_laborales_horario) ){
            $restar++;
        } elseif( isDiaFeriado($fecha_iterar) ) {
            $restar++;
        }
    }
     
    return $restar;
}

function mHorarios($horario_id){
    global $db;
    $dias_laborales = [];

    $db->where('id', $horario_id);
    $m_horario = $db->getOne('m_horario');

    if ($m_horario['lun'] == 1) {
        $dias_laborales[] = 1;
    }

    if ($m_horario['mar'] == 1) {
        $dias_laborales[] = 2;
    }

    if ($m_horario['mie'] == 1) {
        $dias_laborales[] = 3;
    }

    if ($m_horario['jue'] == 1) {
        $dias_laborales[] = 4;
    }

    if ($m_horario['vie'] == 1) {
        $dias_laborales[] = 5;
    }

    if ($m_horario['sab'] == 1) {
        $dias_laborales[] = 6;
    }

    if ($m_horario['dom'] == 1) {
        $dias_laborales[] = 7;
    }
    
    return $dias_laborales;
}



/**
 * Checkea si la fecha enviada por parametros es una ausencia (En la tabla T_AUSENCIA)    
 * @param (int) $trabajador_id ID del trabajador
 * @param (date) $fecha Fecha a consultar
 * @return (boolean) True si es ausencia, False si no lo es 
 */
function esAusencia($trabajador_id, $fecha ){    
    global $db;
    $db->where('fecha_inicio', $fecha, '<=');
    $db->where('fecha_fin', $fecha, '>= ');
    $db->where('trabajador_id', $trabajador_id);
    $res_check = $db->get( 't_ausencia' );
    if( ! $res_check ){
        return false;
    } else {
        return true;
    }
}


/**
 * Determina los dias habiles dentro de un periodo de tiempo (2 fechas)
 * Recibe como parametros el id del trabajador, la fecha de inicio del periodo
 * la fecha final del periodo y el ID de la ausencia.
 * Dependiendo del tipo de ausencia procesa los dias que son descontables (llamados dias habiles)
 *      Si son vacaciones, deja fuera los sabados, domingos y festivos agregados en el maestro de dias festivos
 *      Si es Licencia, incluye todos los dias del periodo
 *      Si es una ausencia sin jutificar, deja fuera los dias NO laborales definidos en el maestro de horarios y    
 *      los festivos agregados en el maestro de dias festivos
 * @param (int) $trabajador_id ID del trabajador 
 * @param (date) $fechaInicio Fecha de inicio del periodo
 * @param (date) $fechaFin ID Fecha final del periodo
 * @param (int) $ausencia_id ID de la ausencia
 * 
 * @return (int) $dias_habiles Total de días hábiles a descontar
 */
function diasHabiles($trabajador_id,$fechaInicio, $fechaFin, $ausencia_id){
    global $db;
    $dias_habiles = 0;
    $ids_licencia = array();        
    
    // Ausencia tipo vacaciones
    $id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');
    
    //Ausencias tipo licencia
    $db->where('licencia',1);
    $db->where('codigoPrevired',0,"!=");
    $ids_licencia_bd = $db->get('m_ausencia',null, 'id');
    foreach( $ids_licencia_bd as $i ){
        $ids_licencia[] = $i['id'];
    }
    
    
    if( $ausencia_id == $id_ausencia_vacaciones ){
        // procesar ausencias como vacaciones
        $timeInicio = strtotime($fechaInicio.' 00:00:00');
        $timeFin = strtotime($fechaFin.' 23:59:59');
        
        for($timestamp=$timeInicio; $timestamp<=$timeFin; $timestamp+=86400){
            $dia_semana = date('N', $timestamp);
            $dia_semana--; // Parte con LUNES = 0 a DOMINGO = 6
            if( $dia_semana < 5 ){
                if( ! isDiaFeriado(date('Y-m-d',$timestamp)) ){
                    $dias_habiles++;    
                }
                
            }                        
        }        
        
    } elseif( in_array($ausencia_id, $ids_licencia) ) {
        // Procesar ausencias como Licencias
        $datetime1 = new DateTime( $fechaInicio );
        $datetime2 = new DateTime( $fechaFin );
        $interval = $datetime1->diff($datetime2);
        $diasAlcanzoATrabajar = $interval->days;
        $diasAlcanzoATrabajar++;
        
        $dias_habiles = $diasAlcanzoATrabajar;
    } else {
        // Procesar ausencias como AUSENCIAS, segun dias que trabaja el trabajador y sin contar los feriados
        $db->where('id',$trabajador_id);
        $horario_id = $db->getValue('m_trabajador','horario_id');    
    
        $db->where('id',$horario_id);
        $m_horarios = $db->getOne('m_horario');
        $array_dias_temp = array($m_horarios['lun'],$m_horarios['mar'],$m_horarios['mie'],$m_horarios['jue'],$m_horarios['vie'],$m_horarios['sab'],$m_horarios['dom']);
        $dias_laborales_horario = array();
        foreach( $array_dias_temp as $k => $i ){
            if( $i == 1 ){
                $dias_laborales_horario[] = $k;
            }
        }
        
        
        $timeInicio = strtotime($fechaInicio.' 00:00:00');
        $timeFin = strtotime($fechaFin.' 23:59:59');
        
        for($timestamp=$timeInicio; $timestamp<=$timeFin; $timestamp+=86400){
            $dia_semana = date('N', $timestamp);
            $dia_semana--; // Parte con LUNES = 0 a DOMINGO = 6
            if( in_array($dia_semana,$dias_laborales_horario) ){
                if( ! isDiaFeriado(date('Y-m-d',$timestamp)) ){
                    $dias_habiles++;    
                }
                
            }
        }                
    }
            
    
    return $dias_habiles;  
}


/**
 * Obtiene el nombre completo del trabajador, concatenando el nombre y apellidos
 * @param ($trabajador_id) $trabajador_id ID del 
 * @return (string) $nombre_completo Nombre completo del trabajador
 */
function getNombreTrabajador($trabajador_id, $nombre_primero=false){
    global $db;    
    $db->where('id',$trabajador_id);
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $trabajador = $db->getOne('m_trabajador',array('nombres','apellidoPaterno','apellidoMaterno'));
    $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
    
    if( $nombre_primero == true ){
        $nombre_completo = $trabajador['nombres'] . " " . $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'];
    }

    return $nombre_completo;
}

function isAdmin(){
    if( $_SESSION[PREFIX.'login_admin'] ){
        return true;
    } else {
        return false;
    }
}

/**
 * Determina la fecha de inicio del periodo
 * Si un trabajador empezo su contrato despues de la fecha de inicio del periodo
 * usa la fecha de contrato como inicio.  
 * @param (string) $fecha_desde Fecha de inicio del periodo como STRING
 * @param (int) $trabajador_id ID del trabajador
 * @return (date) $fechaInicio Fecha en formato time() de inicio del periodo
 */
function inicioPeriodo($fecha_desde,$trabajador_id){
    global $db;
    
    $db->where('id',$trabajador_id);
    $fecha_inicio_contrato = $db->getValue('m_trabajador','fechaContratoInicio');    
    $fecha_inicio_contrato = strtotime($fecha_inicio_contrato.' 00:00:00');        
    
    $fechaInicio=strtotime($fecha_desde);
    if($fecha_inicio_contrato > $fechaInicio){
        $fechaInicio = $fecha_inicio_contrato; 
    }
        
    return $fechaInicio;
}


function getTipoContrato($tipocontrato_id){        
    switch( $tipocontrato_id ){
        case 1: $tipo_contrato = "A Plazo Fijo"; break;
        case 2: $tipo_contrato = "Indefinido"; break;
        case 3: $tipo_contrato = "Finiquitado"; break;
        case 3: $tipo_contrato = "Despedido"; break;
        default:  $tipo_contrato = ""; break;
    }
    
    return $tipo_contrato;
}

 /**
 * Determina la fecha de fin del periodo
 * Si un trabajador es finiquitado antes de la fecha de fin del periodo
 * se usa la fecha de FIN contrato como fin de periodo.  
 * @param (string) $fecha_desde Fecha de inicio del periodo como STRING
 * @param (int) $trabajador_id ID del trabajador
 * @return (date) $fechaInicio Fecha en formato time() de inicio del periodo
 */
function finPeriodo($fecha_fin,$trabajador_id){
    global $db;
    /**
    SELECT fechaContratoFin FROM m_trabajador T 
    WHERE id = 164
    AND T.tipocontrato_id = 3
    AND T.fechaContratoFin != '0000-00-00'
    **/    
    $db->where('id',$trabajador_id);
    $db->where('tipocontrato_id',3);
    $db->where('fechaContratoFin','0000-00-00','!=');
    $fecha_contrato_fin = $db->getOne('m_trabajador','fechaContratoFin');
    $fecha_contrato_fin = $fecha_contrato_fin['fechaContratoFin']." 23:59:59";
        
    
    $str_fecha_contrato_fin = strtotime($fecha_contrato_fin);
    $str_fecha_fin = strtotime($fecha_fin);
    
    if( $str_fecha_contrato_fin < $str_fecha_fin ){
        $fecha_fin_periodo = $str_fecha_contrato_fin;
    } else {
        $fecha_fin_periodo = $str_fecha_fin;
    }
    
    return $fecha_fin_periodo;
}

/**
 * Verifica que exista la liquidacion en el mes y año que se esta liquidando
 * @param (int) $trabajador_id ID del trabajador
 * @return (boolean) True si existe en la BD, False si NO existe en la BD
 */
function existeLiquidacion($trabajador_id){
    global $db;
    
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    
    $db->where("trabajador_id",$trabajador_id);
    $db->where("mes",$mes);
    $db->where("ano",$year);
    $liq = $db->getOne('liquidacion');
    
    if( $db->count > 0 ){
        return true;             
    } else {
        return false;                        
    }
     
}


/**
 * Funcion que procesa las alertas en la cabecera del sitio
 * Llena un arreglo
 * @param Sin Parametros 
 * @return (array) Array con las alertas
 */
function fnAlertas(){ 
    global $db;
    $alertas = array();
    
    if( !getUF(getMesMostrarCorte(),getAnoMostrarCorte()) ){
        $alertas['uf'] = array(
            'mensaje' => 'Debe ingresar el valor de la UF del mes',
            'link' => BASE_URL . '/tipomoneda/listar'
        );
    }
    
    if( !existeSemanaCorrida() ){
        $alertas['semana_corrida'] = array(
            'mensaje' => 'Debe definir la semana corrida para el mes',
            'link' => BASE_URL . '/semanacorrida/ingresar'
        );
    }
    
    if( !checkValoresAfp() ){
        $alertas['valores_afp'] = array(
            'mensaje' => 'Existen AFP sin valores este mes',
            'link' => BASE_URL . '/afp/listar'
        );
    }
    
    $proximos = proximosContratos11años();    
    if( $proximos  ){
        foreach( $proximos as $prox ){
            $alertas['proximo_'.$prox['id']] = array(
                'mensaje' => $prox['nombres'] . ' ' . $prox['apellidoPaterno'] . " cumple 11 años trabajando",
                'link' => BASE_URL . '/trabajador/editar/'. $prox['id'] .'#tab_2'
            );
        }
    }

    if( !exportarTablas(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) ){
        $alertas['respaldos'] = array(
            'mensaje' => 'Hubo un problema al crear el respaldo. Por favor generarlo manualmente en el Dashboard',
            'link' => BASE_URL
        );
    }
    
    return $alertas;
}


function proximosContratos11años(){
    global $db;
    
    $ano_actual = date('Y');
    $ano_past = ($ano_actual - 11);    
    $date_query = date('m').'-'.$ano_past;
    //SELECT id, nombres, apellidoPaterno, apellidoMaterno FROM `m_trabajador` WHERE `fechaContratoInicio` LIKE '2005-04%'
    $db->where('fechaContratoInicio','2005-04%','LIKE');
    $result = $db->get('m_trabajador',999,array('id','nombres','apellidoPaterno','apellidoMaterno'));
    
    return $result;
}

function checkValoresAfp(){
    global $db;
    $sql_check_afp = "Select count(nombre) as total
        from m_afp A
        where A.id is null
              or not exists (select 1
                             from m_afpvalores V
                             where V.afp_id = A.id)";

    $res = $db->rawQuery( $sql_check_afp );
    $total = $res[0]['total'];
    
    if( $total > 0 )   
        return false;
    else 
        return true;              
}


/**
 * Alias de obtenerSemanaCorrida(), pero sin pasar por parametros las comisiones
 */
function existeSemanaCorrida(){
    global $db;
    
    $year = getAnoMostrarCorte();
    $mes = getMesMostrarCorte();
    $db->where('mes',$mes);
    $db->where('ano',$year);
    $res = $db->getOne('m_semanacorrida');
           
    if($db->count > 0)
        return true;
                
    else
        return false;    
}


/**
 * Retorna todos los registros de una entidad, dependiendo si son compartidos
 * o no por la cuenta logueada
 * @param (string) $entidad Nombre de la entidad que se desea consultar si se comparte por la cuenta
 * Diferencia entre MAYUSCULAS y minusculas
 * @param (string) $tabla Nombre de la tabla desde donde obtener los registros
 * @return (array) $registros Arreglo con los registros obtenidos 
 * Ej. NO es lo mismo getComparte('Cargo') que getComparte('cargo')
 */
function getRegistrosCompartidos($entidad, $tabla){    
    global $db;    
    if( getComparte($entidad) ){
        $sql_share = "
        SELECT * FROM $tabla ENT 
        WHERE ENT.empresa_id IN 
            ( SELECT id FROM m_empresa E WHERE E.cuenta_id = ". $_SESSION[ PREFIX . 'login_cid' ] ." )
        ORDER BY ENT.nombre
        ";          
        $registros = $db->rawQuery( $sql_share );        
    } else {
        $db->orderBy('nombre', 'ASC');
        $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);    
        $registros = $db->get($tabla);    
    }         
        
    return $registros;    
}



/**
 * Funcion para determinar si se comparte alguna entidad
 * @param string $entidad Nombre de la entidad. Diferencia entre MAYUSCULAS y minusculas 
 * Ej. NO es lo mismo getComparte('Cargo') que getComparte('cargo')
 */
function getComparte($entidad){    
    global $db;
    $db->where('id',$_SESSION[PREFIX.'login_cid']);
    $comparte_cargo = $db->getOne('m_cuenta','compartir' . $entidad);    
    $comparte_cargo['compartir' . $entidad];        
                    
    if( $comparte_cargo['compartir' . $entidad] == 1 ){
        return true;
    } else {
        return false;
    }
}


/**
 * Retorna tru o false si la fecha pasada por parametro es un dia feriado   
 * @param (date) $fecha Fecha en formato Y-m-d
 * @return (boolean) Tru o False si la fecha es feriado  
 */
function trabajoDiaFeriado($fecha){
    global $db;
    
    $arr_fecha = explode("-",$fecha);    
        
    $mes = $arr_fecha[1];
    $dia = $arr_fecha[2];        
    $db->rawQuery("SELECT * FROM m_diaferiado WHERE month(fecha) = $mes AND day(fecha) = $dia AND anual = 1");
    
    if( $db->count > 0 ){
        return true;
    } else {
        $db->rawQuery("SELECT * FROM m_diaferiado WHERE fecha = '$fecha' AND anual = 0");        
        if( $db->count > 0 ){
            return true;
        } else {
            return false;
        }
    }    
}

/**
 * Alias trabajoDiaFeriado()   
 */
function isDiaFeriado($fecha){
    return trabajoDiaFeriado($fecha);
}


function getAnoMostrarCorte(){
    global $db;    
    
    if( getMesMostrarCorte() > (int)date('m') ){
        $year = ( date('Y') - 1 );
    } else {
        $year = date('Y');
    }
            
    return $year;
}




/**
 * Define un arreglo con todos los items del menu para el trabajador  
 *   
 */
function menuJefe(){
    $menu = array();
    $menu['justificar'] = array(
        'label' => 'Justificaciones y Atrasos',
        'icon_class' => 'fa fa-clock-o',
        'childs' => array(
            array(
                'entidad' => 'relojcontrol',
                'accion' => 'listar_trabajadores',
                'label' => 'Listar'
            )
        )
    );
    
    $menu['informes'] = array(
        'label' => 'Informes',
        'icon_class' => 'fa fa-flag',
        'childs' => array(
            array(
                'entidad' => 'informe',
                'accion' => 'reporte_atrasos',
                'label' => 'Reporte de atrasos'
            )
        )
    );
    
    /*
    $menu['vacaciones_aprovar'] = array(
        'label' => 'Vacaciones',
        'icon_class' => 'fa fa-plane',
        'childs' => array(
            array(
                'entidad' => 'vacaciones',
                'accion' => 'ver_solicitudes',
                'label' => 'Ver Solicitudes'
            ),
            array(
                'entidad' => 'vacaciones',
                'accion' => 'calendario',
                'label' => 'Calendario'
            )
        )
    );
    */
                        
    return $menu;   
}




/**
 * Define un arreglo con todos los items del menu para el trabajador  
 *   
 */
function menuTrabajador(){
    $menu = array();

    $menu['profile'] = array(
        'label' => 'Mi Perfil',
        'icon_class' => 'fa fa-user',
        'childs' => array(
            array(
                'entidad' => 'usuario',
                'accion' => 'perfil',
                'label' => 'Modificar Datos'
            )
        )
    );

    $menu['liquidaciones'] = array(
        'label' => 'Liquidaciones',
        'icon_class' => 'fa fa-file-text',
        'childs' => array(
            array(
                'entidad' => 'liquidacion',
                'accion' => 'listar_trabajador',
                'label' => 'Listar'
            )
        )
    );
    
    /*            
    $menu['anticipo'] = array(
        'label' => 'Anticipo',
        'icon_class' => 'fa fa-money',
        'childs' => array(
            array(
                'entidad' => 'anticipo',
                'accion' => 'solicitar',
                'label' => 'Solicitar'
            )
        )
    );
            
    $menu['vacaciones'] = array(
        'label' => 'Vacaciones',
        'icon_class' => 'fa fa-plane',
        'childs' => array(
            array(
                'entidad' => 'vacaciones',
                'accion' => 'solicitar',
                'label' => 'Solicitar'
            )
        )
    );
    */
    
    $menu['relojcontrol'] = array(
        'label' => 'Reloj Control',
        'icon_class' => 'fa fa-clock-o',
        'childs' => array(
            array(
                'entidad' => 'relojcontrol',
                'accion' => 'me',
                'label' => 'Ver'
            )
        )
    );
            
    return $menu;   
}


/**
 * Define un arreglo con todos los items del menu  
 *   
 */
function mainMenu(){
    global $db;    
    
    $db->where('id',$_SESSION[PREFIX.'login_uid']);
    $roles = $db->getValue('m_usuario','roles');    
    $roles = json_decode($roles);
             
    $menu = array();
    $menu['empresa'] = array(
        'label' => 'Empresa',
        'icon_class' => 'fa fa-building',
        'childs' => array(
            array(
                'entidad' => 'empresa',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'empresa',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            ),
            array(
                'entidad' => 'centrocosto',
                'accion' => 'listar',
                'label' => 'Centro Costo'
            ),
            array(
                'entidad' => 'descuento',
                'accion' => 'listar',
                'label' => 'Descuentos'
            ),
            array(
                'entidad' => 'haber',
                'accion' => 'listar',
                'label' => 'Haberes'
            ),
            array(
                'entidad' => 'haber_masivo',
                'accion' => 'ingresar',
                'label' => 'Haberes y Dctos. Masivo'
            )
        )
    );
            
    $menu['contrato'] = array(
        'label' => 'Contrato',
        'icon_class' => 'fa fa-paperclip',
        'childs' => array(
            array(
                'entidad' => 'contrato',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'contrato',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            ),
        )
    );
            
    $menu['horario'] = array(
        'label' => 'Horario',
        'icon_class' => 'fa fa-clock-o',
        'childs' => array(
            array(
                'entidad' => 'horario',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'horario',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            )
        )
    );
        
    $menu['cargo'] = array(
        'label' => 'Cargo',
        'icon_class' => 'fa fa-male',
        'childs' => array(
            array(
                'entidad' => 'cargo',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'cargo',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            )
        )
    );
    
    $menu['departamento'] = array(
        'label' => 'Departamento',
        'icon_class' => 'fa fa-hand-o-right',
        'childs' => array(
            array(
                'entidad' => 'departamento',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'departamento',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            )
        )
    );
    
    $menu['trabajador'] = array(
        'label' => 'Trabajador',
        'icon_class' => 'fa fa-user',
        'childs' => array(
            array(
                'entidad' => 'trabajador',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'trabajador',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            ),
            array(
                'entidad' => 'tipotrabajador',
                'accion' => 'listar',
                'label' => 'Tipo Trabajador'
            )
        )
    );
    
    $menu['sucursales'] = array(
        'label' => 'Sucursales',
        'icon_class' => 'fa fa-map-marker',
        'childs' => array(
            array(
                'entidad' => 'sucursal',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'sucursal',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            )
        )
    );
    
    $menu['usuario'] = array(
        'label' => 'Usuario',
        'icon_class' => 'fa fa-user',
        'childs' => array(
            array(
                'entidad' => 'usuario',
                'accion' => 'listar',
                'label' => 'Listar'
            ),
            array(
                'entidad' => 'usuario',
                'accion' => 'ingresar',
                'label' => 'Ingresar'
            )
        )
    );
                
    $menu['salud'] = array(
        'label' => 'Prevision',
        'icon_class' => 'fa fa-medkit',
        'childs' => array(
            array(
                'entidad' => 'afp',
                'accion' => 'listar',
                'label' => 'Afp'
            ),
            array(
                'entidad' => 'isapre',
                'accion' => 'listar',
                'label' => 'Isapre'
            ),
            array(
                'entidad' => 'institucion',
                'accion' => 'listar',
                'label' => 'Institución APV'
            )
        )
    );
    
    $menu['misc'] = array(
        'label' => 'Misceláneos',
        'icon_class' => 'fa fa-paperclip',
        'childs' => array(
            array(
                'entidad' => 'ausencia',
                'accion' => 'listar',
                'label' => 'Ausencia'
            ),
            array(
                'entidad' => 'justificativo',
                'accion' => 'listar',
                'label' => 'Justificativo'
            ),
            array(
                'entidad' => 'tipomoneda',
                'accion' => 'listar',
                'label' => 'Tipo Moneda/Valores'
            ),
            array(
                'entidad' => 'tope',
                'accion' => 'listar',
                'label' => 'Topes'
            ),
            array(
                'entidad' => 'tipopago',
                'accion' => 'listar',
                'label' => 'Tipo de Pago'
            ),
            array(
                'entidad' => 'diaferiado',
                'accion' => 'listar',
                'label' => 'Feriados'
            ),
            array(
                'entidad' => 'semanacorrida',
                'accion' => 'listar',
                'label' => 'Semana Corrida'
            ),
            array(
                'entidad' => 'impuestounico',
                'accion' => 'listar',
                'label' => 'Impuesto Unico'
            ),
            array(
                'entidad' => 'factorcorreccion',
                'accion' => 'listar',
                'label' => 'Factor de actualización'
            ),
            array(
                'entidad' => 'costoempresa',
                'accion' => 'ingresar',
                'label' => 'Costos Empresa'
            ),
            array(
                'entidad' => 'documento',
                'accion' => 'listar',
                'label' => 'Redacción de Documentos'
            ),
            array(
                'entidad' => 'gestion_masiva_documento',
                'accion' => 'dashboard',
                'label' => 'Gestion Masiva Documento'
            ),
            array(
                'entidad' => 'rentas_no_gravadas',
                'accion' => 'listar',
                'label' => 'Rentas no Gravadas'
            )
        )
    );
    
    
    $menu['informe'] = array(
        'label' => 'Informes',
        'icon_class' => 'fa fa-file-text-o',
        'childs' => array(
            array(
                'entidad' => 'informe',
                'accion' => 'listar_trabajadores',
                'label' => 'Lista de Trabajadores'
            ),            
            array(
                'entidad' => 'informe',
                'accion' => 'impuesto',
                'label' => 'Informe de Impuestos'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'atrasos',
                'label' => 'Informe de Atrasos'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'atrasos_mensual',
                'label' => 'Reporte de Atrasos x mes'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'personalizado',
                'label' => 'Informe Personalizado'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'imposiciones',
                'label' => 'Informacion para Imposiciones'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'remuneraciones-centrocosto',
                'label' => 'Remuneraciones x C.Costo'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'ausencias',
                'label' => 'Ausencias x Fecha'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'ausencias_trabajador',
                'label' => 'Ausencias x Trabajador'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'certificado_sueldos',
                'label' => 'Certificado de sueldos'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'certificado_antiguedad',
                'label' => 'Certificado de Antigüedad'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'haberes_descuentos',
                'label' => 'Informe Haberes/Descuentos'
            )
        )
    );
    
    $menu['formularios'] = array(
        'label' => 'Formularios',
        'icon_class' => 'fa  fa-file-text-o',
        'childs' => array(
            array(
                'entidad' => 'informe',
                'accion' => 'anticipo',
                'label' => 'Solicitud de Anticipo'
            ),
            array(
                'entidad' => 'informe',
                'accion' => 'prestamo',
                'label' => 'Solicitud de Préstamo'
            )
        )
    );
    
    $menu['liquidacion'] = array(
        'label' => 'Liquidaciones',
        'icon_class' => 'fa fa-file-pdf-o',
        'childs' => array(
            array(
                'entidad' => 'liquidacion',
                'accion' => 'seleccionar',
                'label' => 'Ver liquidacion'
            )
        )
    );
    
    $menu['anticipo'] = array(
        'label' => 'Anticipos',
        'icon_class' => 'fa fa-money',
        'childs' => array(
            array(
                'entidad' => 'anticipo',
                'accion' => 'listar',
                'label' => 'Solicitudes pendientes'
            )
        )
    );
    
    
    $menu['importar_relojcontrol'] = array(
        'label' => 'Importar Relojcontrol',
        'icon_class' => 'fa fa-clock-o',
        'childs' => array(
            array(
                'entidad' => 'importar_relojcontrol',
                'accion' => 'upload',
                'label' => 'Subir archivo'
            )
        )
    );


    $menu['centralizacion'] = array(
        'label' => 'Centralizacion',
        'icon_class' => 'fa fa-files-o',
        'childs' => array(
            array(
                'entidad' => 'centralizacion',
                'accion' => 'criterios-centrocosto',
                'label' => 'Criterios por Centros de Costos'
            )
        )
    );
    
    return $menu;   
}


/**
 * Genera html del menu, segun el arreglo de menu  
 *   
 */
function generaMenu(){
    global $db;
    $menu = mainMenu();
    
    $output_admin = '';
    $output_user = '';
                
    if( $_SESSION[ PREFIX . 'login_admin' ] == 1 ){
        $output_admin = '<ul class="sidebar-menu">';
        $output_admin .= '<li class="header">MENÚ </li>';         
        foreach( $menu as $menu_key => $menu_item ){
                
            $output_admin .= '<li class="treeview" id="menu_item_' . $menu_item['label'] . '">';
            $output_admin .= '    <a href="#">';
            $output_admin .= '    <i class="' . $menu_item['icon_class'] . '"></i> <span>' . $menu_item['label'] . '</span> <i class="fa fa-angle-left pull-right"></i>';
            $output_admin .= '  </a>'; 
            $output_admin .= '  <ul class="treeview-menu">';   
            
            foreach( $menu_item['childs'] as $subemnu_item ){            
                $output_admin .= '  <li><a href="' . BASE_URL . '/' . $subemnu_item['entidad'] . '/' . $subemnu_item['accion'] . '"><i class="fa fa-circle-o"></i>' . $subemnu_item['label'] . '</a></li>';            
            }                                                         
            $output_admin .= '  </ul>';             
            $output_admin .= '</li>';            
        }                                    
        $output_admin .= '</ul>';
        
        return $output_admin;   
                
    } else if( $_SESSION[PREFIX.'is_trabajador'] ) {
        
        $menu = menuTrabajador();
        $output_trabajador = '<ul class="sidebar-menu">';
        $output_trabajador .= '<li class="header">MENÚ </li>';         
        foreach( $menu as $menu_key => $menu_item ){
                
            $output_trabajador .= '<li class="treeview" id="menu_item_' . $menu_item['label'] . '">';
            $output_trabajador .= '    <a href="#">';
            $output_trabajador .= '    <i class="' . $menu_item['icon_class'] . '"></i> <span>' . $menu_item['label'] . '</span> <i class="fa fa-angle-left pull-right"></i>';
            $output_trabajador .= '  </a>'; 
            $output_trabajador .= '  <ul class="treeview-menu">';   
            
            foreach( $menu_item['childs'] as $subemnu_item ){            
                $output_trabajador .= '  <li><a href="' . BASE_URL . '/' . $subemnu_item['entidad'] . '/' . $subemnu_item['accion'] . '"><i class="fa fa-circle-o"></i>' . $subemnu_item['label'] . '</a></li>';            
            }                                                         
            $output_trabajador .= '  </ul>';
            $output_trabajador .= '</li>';
        }        
        $output_trabajador .= '</ul>';
        
        if( $_SESSION[PREFIX.'is_jefe'] ){
            $menu_jefe = menuJefe();
            $output_trabajador .= '<ul class="sidebar-menu">';
            $output_trabajador .= '<li class="header">MENÚ JEFATURA</li>'; 
            foreach( $menu_jefe as $menu_key => $menu_item ){
                    
                $output_trabajador .= '<li class="treeview" id="menu_item_' . $menu_item['label'] . '">';
                $output_trabajador .= '    <a href="#">';
                $output_trabajador .= '    <i class="' . $menu_item['icon_class'] . '"></i> <span>' . $menu_item['label'] . '</span> <i class="fa fa-angle-left pull-right"></i>';
                $output_trabajador .= '  </a>'; 
                $output_trabajador .= '  <ul class="treeview-menu">';   
                
                foreach( $menu_item['childs'] as $subemnu_item ){            
                    $output_trabajador .= '  <li><a href="' . BASE_URL . '/' . $subemnu_item['entidad'] . '/' . $subemnu_item['accion'] . '"><i class="fa fa-circle-o"></i>' . $subemnu_item['label'] . '</a></li>';            
                }                                                         
                $output_trabajador .= '  </ul>';             
                $output_trabajador .= '</li>';            
            }
        }
        
        $output_trabajador .= '</ul>';
        
        return $output_trabajador;
        
    } else {
        $db->where('id',$_SESSION[PREFIX.'login_uid']);
        $menuItem = $db->getValue('m_usuario','menuItem');    
        $menuItems = json_decode($menuItem);                                
                       
        $output_user = '<ul class="sidebar-menu">';
        $output_user .= '<li class="header">MENÚ </li>';
        
        foreach( $menuItems as $menu_key => $menu_item ){
            $output_user .= '<li class="treeview" id="menu_item_' . $menu_item->label . '">';
            $output_user .= '    <a href="#">';
            $output_user .= '    <i class="' . $menu_item->icon . '"></i> <span>' . $menu_item->label . '</span> <i class="fa fa-angle-left pull-right"></i>';
            $output_user .= '  </a>'; 
            $output_user .= '  <ul class="treeview-menu">';  
            
            foreach( $menu_item->hijos as $subemnu_item ){
                $output_user .= '  <li><a href="'. BASE_URL . '/' . $subemnu_item->link . '"><i class="fa fa-circle-o"></i>' . $subemnu_item->label . '</a></li>';
            }                        
                                             
            $output_user .= '  </ul>';             
            $output_user .= '</li>';
        }
        
                                                 
        $output_user .= '</ul>';                
                                        
        return $output_user;
    }
}


/**
 * Clase que convierte numero en palabras escritas  
 *  
 */
class EnLetras{ 
    var $Void = ""; 
    var $SP = " "; 
    var $Dot = "."; 
    var $Zero = "0"; 
    var $Neg = "Menos"; 

    function ValorEnLetras($x, $Moneda ){ 
        $s=""; 
        $Ent=""; 
        $Frc=""; 
        $Signo=""; 
             
        if(floatVal($x) < 0) 
         $Signo = $this->Neg . " "; 
        else 
         $Signo = ""; 
         
        if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales 
          $s = number_format($x,2,'.',''); 
        else 
          $s = number_format($x,2,'.',''); 
            
        $Pto = strpos($s, $this->Dot); 
             
        if ($Pto === false) 
        { 
          $Ent = $s; 
          $Frc = $this->Void; 
        } 
        else 
        { 
          $Ent = substr($s, 0, $Pto ); 
          $Frc =  substr($s, $Pto+1); 
        } 
    
        if($Ent == $this->Zero || $Ent == $this->Void) 
           $s = "Cero "; 
        elseif( strlen($Ent) > 7) 
        { 
           $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) .  
                 "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
        } 
        else 
        { 
          $s = $this->SubValLetra(intval($Ent)); 
        } 
    
        if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ") 
           $s = $s . "de "; 
    
        $s = $s . $Moneda; 
    
        return ($Signo . $s ); 
        
    } 


    function SubValLetra($numero){ 
        $Ptr=""; 
        $n=0; 
        $i=0; 
        $x =""; 
        $Rtn =""; 
        $Tem =""; 
    
        $x = trim("$numero"); 
        $n = strlen($x); 
    
        $Tem = $this->Void; 
        $i = $n; 
         
        while( $i > 0) 
        { 
           $Tem = $this->Parte(intval(substr($x, $n - $i, 1).  
                               str_repeat($this->Zero, $i - 1 ))); 
           If( $Tem != "Cero" ) 
              $Rtn .= $Tem . $this->SP; 
           $i = $i - 1; 
        } 
    
         
        //--------------------- GoSub FiltroMil ------------------------------ 
        $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn ); 
        while(1) 
        { 
           $Ptr = strpos($Rtn, "Mil ");        
           If(!($Ptr===false)) 
           { 
              If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false )) 
                $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr); 
              Else 
               break; 
           } 
           else break; 
        } 
    
        //--------------------- GoSub FiltroCiento ------------------------------ 
        $Ptr = -1; 
        do{ 
           $Ptr = strpos($Rtn, "Cien ", $Ptr+1); 
           if(!($Ptr===false)) 
           { 
              $Tem = substr($Rtn, $Ptr + 5 ,1); 
              if( $Tem == "M" || $Tem == $this->Void) 
                 ; 
              else           
                 $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr); 
           } 
        }while(!($Ptr === false)); 
    
        //--------------------- FiltroEspeciales ------------------------------ 
        $Rtn=str_replace("Diez Un", "Once", $Rtn ); 
        $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
        $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
        $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
        $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
        $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
        $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
        $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
        $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
        $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
        $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
        $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
        $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
        $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
        $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
        $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
        $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
        $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn ); 
    
        //--------------------- FiltroUn ------------------------------ 
        If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn; 
        //--------------------- Adicionar Y ------------------------------ 
        for($i=65; $i<=88; $i++) 
        { 
          If($i != 77) 
             $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn); 
        } 
        $Rtn=str_replace("*", "a" , $Rtn); 
        return($Rtn); 
    } 


    function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) { 
      $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr); 
    } 

    function Parte($x) { 
        $Rtn=''; 
        $t=''; 
        $i=''; 
        Do 
        { 
          switch($x) 
          { 
             Case 0:  $t = "Cero";break; 
             Case 1:  $t = "Un";break; 
             Case 2:  $t = "Dos";break; 
             Case 3:  $t = "Tres";break; 
             Case 4:  $t = "Cuatro";break; 
             Case 5:  $t = "Cinco";break; 
             Case 6:  $t = "Seis";break; 
             Case 7:  $t = "Siete";break; 
             Case 8:  $t = "Ocho";break; 
             Case 9:  $t = "Nueve";break; 
             Case 10: $t = "Diez";break; 
             Case 20: $t = "Veinte";break; 
             Case 30: $t = "Treinta";break; 
             Case 40: $t = "Cuarenta";break; 
             Case 50: $t = "Cincuenta";break; 
             Case 60: $t = "Sesenta";break; 
             Case 70: $t = "Setenta";break; 
             Case 80: $t = "Ochenta";break; 
             Case 90: $t = "Noventa";break; 
             Case 100: $t = "Cien";break; 
             Case 200: $t = "Doscientos";break; 
             Case 300: $t = "Trescientos";break; 
             Case 400: $t = "Cuatrocientos";break; 
             Case 500: $t = "Quinientos";break; 
             Case 600: $t = "Seiscientos";break; 
             Case 700: $t = "Setecientos";break; 
             Case 800: $t = "Ochocientos";break; 
             Case 900: $t = "Novecientos";break; 
             Case 1000: $t = "Mil";break; 
             Case 1000000: $t = "Millón";break; 
          } 
    
          If($t == $this->Void) 
          { 
            $i = $i + 1; 
            $x = $x / 1000; 
            If($x== 0) $i = 0; 
          } 
          else 
             break; 
                
        }while($i != 0); 
        
        $Rtn = $t; 
        Switch($i) 
        { 
           Case 0: $t = $this->Void;break; 
           Case 1: $t = " Mil";break; 
           Case 2: $t = " Millones";break; 
           Case 3: $t = " Billones";break; 
        } 
        return($Rtn . $t); 
    } 

} 

//-------------- Programa principal ------------------------ 


/**
 * Obtiene valor de tipomoneda, segun mes solicitado y id_tipomoneda 
 *  
 * @param (int) $mes Mes a consultar
 * @param (int) $mes Mes a consultar 
 * @return (int) $id_moneda ID del tipo de moneda 
 */
function getValorMoneda($mes,$ano,$id_moneda){
    global $db;    
    if( $id_moneda == 1 ){
        return 1;
    } else {
        $db->where('mes',$mes);
        $db->where('ano',$ano);
        $db->where('tipomoneda_id',$id_moneda);    
        $valor_tipomoneda = $db->getOne('m_tipomonedavalor','valor');
        $valor_tipomoneda = $valor_tipomoneda['valor'];
            
        if( $valor_tipomoneda )
            return $valor_tipomoneda;
        else 
            return false;
    }
}



/**
 * Obtiene la UF segun mes solicitado 
 *  
 * @param (int) $mes Mes a consultar
 * @param (int) $mes Mes a consultar 
 * @return (int) $uf UF del mes solicitado 
 */
function getUF($mes,$ano){
    global $db;
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $db->where('tipomoneda_id',ID_UF);
    $uf = $db->getValue('m_tipomonedavalor','valor');
    
    if($uf)
        return $uf;
    else
        return false;
}


/**
 * Funcion para obtener el parametro de cuantas horas se
 * deben descontar en caso que el trabajador no marque
 * No recibe parametro. 
 */
function getHorasDescontarNoMarcado(){
    global $db;
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $db->where('cuenta_id',$_SESSION[PREFIX.'login_cid']);
    $horas = $db->getValue('m_empresa','horasDescuentoNoMarca');
    
    return $horas;
} 


/**
 * Determina si el trabajador marca tarjeta
 * @param (int) $trabajador_id ID del trabajador 
 * @return (bool) True si marca. False si no. 
 */
function marcaTarjeta($trabajador_id){ 
    global $db;
    
    if( empresaUsaRelojControl() ){        
        $db->where('id', $trabajador_id );
        $marca = $db->getOne('m_trabajador','marcaTarjeta');        
        
        $marca = $marca['marcaTarjeta'];
        if( $marca == 1 ){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}




/**
 * Determina si el reloj control esta soncronizado con el systema
 * No recibe parametro, pues usa la variable de Session 
 * @return (bool) True si esta sync. False si no. 
 */
function relojControlSync(){ 
    global $db;
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $relojSync = $db->getOne('m_empresa','relojControlSync');    
    $relojSync = $relojSync['relojControlSync'];
    if( $relojSync == 1 ){
        return true;
    } else {
        return false;
    }
}





/**
 * Determina si la empresa usa reloj control
 * No recibe parametro, pues usa la variable de Session 
 * @return (bool) True si usa. False si no. 
 */
function empresaUsaRelojControl(){ 
    global $db;
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $usaRelojC = $db->getOne('m_empresa','empleaRelojControl');
    $usaRelojC = $usaRelojC['empleaRelojControl'];
    if( $usaRelojC == 1 ){
        return true;
    } else {
        return false;
    }
}


/**
 * Verifica si la hora de atraso u hora extra esta justificada
 * en la tabla t_atrasohoraextra 
 *  
 * @param (int) $logid ID del registro en Reloj Control 
 * @param (int) $trabajador_id ID del Trabajador
 * @param @param (char) $tipoHora Tipo de Hora ( Atraso "A" o HoraExtra "H" )
 * @return (bool) Retorna TRUE si esta justificado/autorizado o False en caso contrario 
 */
function checkIfAutorized($logid=null, $trabajador_id, $tipoHora,$io="",$fecha=""){
    global $db;
    $count=0;

    //show_array($trabajador." - ".$tipoHora." - ".$io." - ".$fecha,0);

    if( $logid ){
        $db->where('logid',$logid);
        $db->where('trabajador_id',$trabajador_id);
        $db->where('tipo',$tipoHora);
        $res = $db->getOne('t_atrasohoraextra');
        $count = $db->count;
    } else {
        $db->where('fecha',$fecha);
        $db->where('io',$io);
        $db->where('trabajador_id',$trabajador_id);        
        $res = $db->getOne('t_atrasohoraextra');    
        $count = $db->count;                
    }



    if( $count > 0 ){
        return true;
    } else {
        return false;
    }
}



/**
 * Obtiene la diferencia de horas minutos y segundos entre 2 horas 
 *  
 * @param string $horaini Hora inicial
 * @param string $horafin Hora final
 * @return (array) Arreglo con la cantidad de horas, minutos y segundos por separado 
 */
function RestarHoras($horaini,$horafin,$fecha)
{
    $arr_hora_ini = explode(":",$horaini);
    $horaini = $arr_hora_ini[0].":".$arr_hora_ini[1].":00"; 
    
    $arr_hora_fin = explode(":",$horafin);
    $horafin = $arr_hora_fin[0].":".$arr_hora_fin[1].":00";
    
    $to_time = strtotime("2000-01-01 " . $horaini);
    $from_time = strtotime("2000-01-01 " . $horafin);
    $difm = (( $from_time - $to_time ) / 60);
    
    $dStart = new DateTime("2000-01-01 " . $horaini);
    $dEnd  = new DateTime("2000-01-01 " . $horafin);
    $dDiff = $dStart->diff($dEnd);
    
    /*
    $horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);        
    
    $difm = $difm + ( 60 * $difh ) + floor($difs/60);
    */
    
    $minutos = $dDiff->format('%i');
    $minutos_x_horas = ( 60 * $dDiff->format('%h') );
    $minutos_totales = $minutos + $minutos_x_horas;
    
	$arr_return = array(
        'horas' => $dDiff->format('%h'),
        'minutos' => $minutos_totales,
        'segundos' => $dDiff->format('%s') 
    );
        
    
    return $arr_return;    
}

/**
 * Determina el periodo de corte 
 * Obtiene los 2 ultimos registros en la tabla m_corte
 * Si aun no se ha cerrado el periodo, lo hace con el corte anterior
 * Si la fecha LIMITE del corte es mayor a HOY, solo se muestra
 * el periodo hasta HOY
 *  
 * @param null
 * @return (array) Arreglo con fecha de inicio y fecha de termino 
 */
function getPeriodoCorte(){    
    global $db;
            
    $db->where('empresa_id',$_SESSION[PREFIX . 'login_eid']);
    $db->orderBy("ano","Desc");
    $db->orderBy("mes","Desc");
    $fechas_limites = $db->get('m_corte',2);

    if( count($fechas_limites) < 2 ){
        $nuevafecha_plus1 = '';
        $fecha_limite = '';        
    } else {
        $f_db = $fechas_limites[0]['ano'].$fechas_limites[0]['mes'].$fechas_limites[0]['dia'];
        $f_db = (int) $f_db;
        
        $f_curr = date('Ymd');
        $f_curr = (int) $f_curr;
        if( $f_db > $f_curr ){
            $fecha_limite = date('Y-m-d');    
        } else {
            $fecha_limite = $fechas_limites[0]['ano']."-".$fechas_limites[0]['mes']."-".$fechas_limites[0]['dia'];            
        }                                
        $fecha_desde = $fechas_limites[1]['ano']."-".$fechas_limites[1]['mes']."-".$fechas_limites[1]['dia'];                                        
        
        if( debeCerrarMes() ){
            $fecha_desde = $fecha_limite;
            $fecha_limite = date('Y-m-d');
        }
        
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha_desde ) ) ;
                        
        
        if( date('n',strtotime($fecha_desde)) == date('n', strtotime($fecha_limite)) ){
            $nuevafecha_plus1 = $fecha_desde;                            
        } else {
            $nuevafecha_plus1 = date ( 'Y-n-d' , $nuevafecha );
        }
                
    }
    
    $arr_limites = array(
        'desde' => $nuevafecha_plus1,
        'hasta' => $fecha_limite
    );                
    
    return $arr_limites;
}

/**
 * Recive un numero en decimal y procesa: 
 * Si tiene decimal, lo muestra, sino, muestra solo la parte entera 
 * @param (float) $decimal Numero a procesar
 * @return (float|int) Numero procesado 
 */
function procesarDecimal($decimal){    
    $numero_return = '';
    $decimal = round($decimal,2);
    $arr_num = explode('.',$decimal);    
    $parte_entera = $arr_num[0];
    $parte_decimal = $arr_num[1];    
    if( ( $parte_decimal == '00' ) || ( $parte_decimal == '0' ) ){
        $numero_return = $parte_entera;        
    } else {
        $numero_return = $decimal;
    }
    
    return $numero_return;
}

/**
 * Traduce el nombre del dia, del Ingles al Español 
 * @param (string) $dia_EN Dia de la semana en ingles (3 caract.)
 * @return (string) Dia de la semana en español (3 caract.) 
 */
function translateDia($dia_EN){
    $dia_char = strtoupper($dia_EN);
    $days = array(
        'SUN' => 'Dom',
        'MON' => 'Lun',
        'TUE' => 'Mar',
        'WED' => 'Mie',
        'THU' => 'Jue',
        'FRI' => 'Vie',
        'SAT' => 'Sab'
    );
    
    return $days[$dia_char];
}



function getDiaCortado($intMes){
    global $db;
    
    $anoCorte = getAnoMostrarCorte();

    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $db->where('mes',$intMes);
    $db->where('ano',$anoCorte);
    $diaCorte = $db->getOne('m_corte');
    
    if( $db->count > 0 ){
        return $diaCorte['dia'];  
    } else {
        return false;
    }    
}

/**
 * Determina el mes a mostrar dentro del corte 
 * @param SIN PARAMETROS
 * @return (int) Numero del mes a mostrar 
 */
function getMesMostrarCorte(){    
    global $db;
        
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $diaCierre = $db->getOne('m_empresa','diaCierre');    
    $diaCierre = $diaCierre['diaCierre'];
    
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $diaCorte = $db->getOne('m_empresa','diaCorte');
    $diaCorte = $diaCorte['diaCorte'];       
       
    $hoy        = date('d');
    $mesMostrar = date('m');
    

    if( $hoy < $diaCierre ){
        $mesMostrar--;
        if($mesMostrar == 00){
            $mesMostrar = 12;
        }  
    }        
        
    
    return $mesMostrar;
}


/**
 * Determina si, a la fecha actual, ya es momento de cerrar el mes 
 * @param SIN PARAMETROS
 * @return True o False 
 */
function debeCerrarMes(){
    global $db;
    
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $diaCierre = $db->getOne('m_empresa','diaCierre');
    $diaCierre = $diaCierre['diaCierre'];
    
    $hoy        = date('d');
    $mesMostrar = date('m');
    $anoMostrar = date('Y');
    
    if( $hoy < $diaCierre ){
        $mesMostrar--;
        if($mesMostrar == 0){
            $mesMostrar = 12;
            $anoMostrar--;
        }      
    }       
    $mes = $mesMostrar;
    $ano = $anoMostrar;           
    
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $db->getOne('m_corte');
    
    if($db->count > 0){
        return false;    
    } else {
        return true;
    }
}


/**
 * Genera un string sin caracteres especiales , ideal para URL amigables
 * @param int $texto Texto a transformar 
 */
function slugify($text){ 
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  $text = trim($text, '-');
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = strtolower($text);
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text)){
    return 'n-a';
  }
    
  return $text;
}

/**
 * Agrega un cero (0) a la izquierda si es menor a 10
 * @param int $num Numero a agrgar 0 
 */
function leadZero($num){
    if( strlen( $num ) < 2 ){
        return '0'.$num;
    } else {
        return $num;  
    }
}


/**
 * Funcion que retorna nombre del mes
 * @param int $num Numero del mes de 1 a 12 
 */
function getNombreMes($num, $acortar = false){
    $strMes = '';
    switch( $num ){
        case 1: $strMes = 'Enero'; break;
        case 2: $strMes = 'Febrero'; break;
        case 3: $strMes = 'Marzo'; break;
        case 4: $strMes = 'Abril'; break;
        case 5: $strMes = 'Mayo'; break;
        case 6: $strMes = 'Junio'; break;
        case 7: $strMes = 'Julio'; break;
        case 8: $strMes = 'Agosto'; break;
        case 9: $strMes = 'Septiembre'; break;
        case 10: $strMes = 'Octubre'; break;
        case 11: $strMes = 'Noviembre'; break;
        case 12: $strMes = 'Diciembre'; break;
        default: $strMes = ''; break;
    }
    
    if( $acortar ){
        return substr($strMes,0,3);   
    } else {
        return $strMes;
    }
}



/**
 * Funcion que determina si un año es bisiesto
 * @param int $ano Año a verificar
 */
function esAnoBisiesto($ano){
    $bisiestos = array("2012","2016","2020","2024","2028","2032","2036","2040","2044","2048","2052","2056","2060","2064","2068","2072","2076","2080","2084","2088","2092","2096");
    if( in_array($ano,$bisiestos) ){
        return true;
    } else {
        return false;
    }
}


/**
 * Funcion que retorna el maximo de dias del mes
 * @param int $num Numero del mes de 1 a 12 
 */
function getLimiteMes($num){
    $num = (int)$num;
    $bisiestos = array("2012","2016","2020","2024","2028","2032","2036","2040","2044","2048","2052","2056","2060","2064","2068","2072","2076","2080","2084","2088","2092","2096");
    switch( $num ){
        case 1: $limite = 31; break;
        case 2: 
            if( in_array(date('Y'),$bisiestos) ){
                $limite = 29;         
            } else {
                $limite = 28;
            }
            break;
        case 3: $limite = 31; break;
        case 4: $limite = 30; break;
        case 5: $limite = 31; break;
        case 6: $limite = 30; break;
        case 7: $limite = 31; break;
        case 8: $limite = 31; break;
        case 9: $limite = 30; break;
        case 10: $limite = 31; break;
        case 11: $limite = 30; break;
        case 12: $limite = 31; break;
        default: $limite = ''; break;
    }    
    return $limite;
}




/**
 * Funcion que retorna numero del mes
 * @param string $strMes Nombre del mes en texto. 
 */
function getIntMes($strMes){    
    $strMes = strtolower($strMes);    
    $mes = 0;
    switch( $strMes ){
        case 'enero':
        case 'january':
            $mes = 1;
            break;
        case 'febrero':
        case 'february':
            $mes = 2;
            break;
        case 'marzo':
        case 'march':
            $mes = 3;
            break;
        case 'abril':
        case 'april':
            $mes = 4;
            break;
        case 'mayo':
        case 'may':
            $mes = 5;
            break;
        case 'junio':
        case 'june':
            $mes = 6;
            break;
        case 'julio':
        case 'july':
            $mes = 7;
            break;
        case 'agosto':
        case 'august':
            $mes = 8;
            break;
        case 'septiembre':              
        case 'september':
            $mes = 9;
            break;
        case 'octubre':
        case 'october':
            $mes = 10;
            break;
        case 'noviembre':
        case 'november':
            $mes = 11;
            break;
        case 'diciembre':
        case 'december':
            $mes = 12;
            break;                
    }
            
    return $mes;
    
}


/**
 * Funcion que retorna el id de la region, segun el id de la comuna
 * @param int $comuna_id ID de la comuna 
 */
function fnGetRegion($comuna_id){
    global $db;
    $db->where('id', $comuna_id);
    $id_reg = $db->getOne('m_comuna','region_id');
    return $id_reg['region_id'];
}


/**
 * Funcion que retorna Masculino o Femenino segun el boolenao
 * @param int $bool booleano del sexo (1 para Mac. 0 para Fem) 
 */
function fnSexo($bool){
    if( $bool == 1 ){
        return 'Mascullino';
    } else {
        return 'Femenino';
    }
}

function fnTipPago($id){
    global $db;
    $db->where ("id", $id);
    $tipo_pago = $db->getOne("m_tipopago");
    return $tipo_pago['nombre'];
}

function fnPais($dato, $bool){
    if ($dato == 46) {
        if ($bool == 1) {
            return "Chileno";
        }else{
            return "Chilena";
        }
    }else{
        if ($bool == 1) {
            return "Extranjero";
        }else{
            return "Extranjera";
        }
    }
}

function previTrabajador($trabajador_id){
    global $db;
    $db->where("trabajador_id", $trabajador_id);
    $datos_prev = $db->getOne("t_prevision");
    $datos_prev = saberAfp($datos_prev["afp_id"]);
    return $datos_prev;
}

function saberAfp($id_afp){
    global $db;
    $db->where("id", $id_afp);
    $dato = $db->getOne("m_afp");
    return $dato;
}

function tipoEmpleado($tipotrabajador_id){
    global $db;
    $db->where("id", $tipotrabajador_id);
    $trabajador = $db->getOne("m_tipotrabajador");
    return $trabajador;
}

function getDiasTrabajados($trabajador_id){
    global $db;
    $db->where("trabajador_id ", $trabajador_id);
    $trabajador = $db->getOne("liquidacion");
    $total_dias_trabajados = 30-$trabajador["diaAusencia"];
    return $total_dias_trabajados;
}

/**
 * Funcion que retorna el nombre de la entidad
 * @param int $id Id del nombre
 * @param string $tabla nombre de la tabla
 * @param boolean $valida_empresa Si debe validar con campo empresa_id
 */
function fnGetNombre($id,$tabla,$valida_empresa = true){
    global $db;
    $db->where('id',$id);
    if( $valida_empresa )
        $db->where('empresa_id',$_SESSION[ PREFIX . 'login_eid']);
    $dpto = $db->getOne($tabla,'nombre');
    return $dpto['nombre']; 
}

/**
 * Alias de fnGetNombre()
 * @param int $id Id del nombre
 * @param string $tabla nombre de la tabla
 * @param boolean $valida_empresa Si debe validar con campo empresa_id
 */
function getNombre($id,$tabla,$valida_empresa = true){
    $rt = fnGetNombre($id,$tabla,$valida_empresa);
    return $rt;    
}


/**
 * Funcion que imprime un history.back() de javascript
 * Ideal para formularios largos, para volver atras sin perder
 * los datos que ya han sido ingresados
 * @param string $msg OPCIONAL: mensaje para alertar
 */
function goBack($msg){
    if( $msg != "" ){
        echo "<script>alert('".$msg."');</script>";   
    }    
    echo "<script>history.back()</script>";
    exit();    
}

/**
 * Funcion para subir archivos
 * @param string $input_name El nombre del input
 * @param string $folder Ruta donde se subirá la 
 * foto (excluyendo la raiz definida en la constante ROOT 
 * y AGREGANDO el ultimo slash / )
 */
function upload_image($input_name, $folder){
    $name = $_FILES[$input_name]['name'];
    $pathinfo = pathinfo($name); 
    $array_return = array();
            
    $foo = new Upload($_FILES[$input_name]); 
    if ($foo->uploaded) {
        $filename_body = uniqid($input_name);
        $foo->file_new_name_body = $filename_body;
        $foo->image_resize = true;
        $foo->image_convert = 'jpeg';
        $foo->image_x = 150;
        $foo->image_ratio_y = true;
        $foo->Process($folder);
        if ($foo->processed) {
            $array_return['status'] = true;
            $array_return['filename'] = $filename_body . '.jpeg';
            $array_return['mensaje'] = "Archivo subido correctamente";            
        } else {
            $array_return['status'] = false;
            $array_return['filename'] = '';
            $array_return['mensaje'] = "Error Subiendo el archivo: " . $foo->error;            
        } 
        $foo->Clean();
    }
    
    return $array_return;  
}



/**
 * Funcion para subir archivos
 * @param string $input_name El nombre del input
 * @param string $folder Ruta donde se subirá el documento (incluyendo la raiz 
 * definida en la constante ROOT y AGREGANDO el ultimo slash / )
 * @return (Array) Arreglo con el Status del upload (true o false), el nombre del archivo generado
 * y un mensaje descriptivo con el resultado. 
 */
function upload_doc($input_name, $folder){
    $name = $_FILES[$input_name]['name'];
    $pathinfo = pathinfo($name);
    $array_extension_allowed = array('pdf','xls', 'xlsx', 'doc', 'docx','jpeg','jpg','png','dat');
    if( in_array($pathinfo['extension'],$array_extension_allowed) ){ 
        $array_return = array();
                
        $foo = new Upload($_FILES[$input_name]); 
        if ($foo->uploaded) {
            $filename_body = uniqid($input_name);
            $foo->file_new_name_body = $filename_body;        
            $foo->Process($folder);
            if ($foo->processed) {
                $array_return['status'] = true;
                $array_return['filename'] = $foo->file_dst_name_body . '.' . $foo->file_dst_name_ext;
                $array_return['mensaje'] = "Archivo subido correctamente";          
            } else {
                $array_return['status'] = false;
                $array_return['filename'] = '';
                $array_return['mensaje'] = "Error Subiendo el archivo: " . $foo->error;            
            } 
            $foo->Clean();
        }
    } else {
        $array_return['status'] = false;
        $array_return['filename'] = '';
        $array_return['mensaje'] = "Extension no permitida";   
    }
    
    return $array_return;  
}


/**
 * Muestra un resumen del contenido, separado por palabras
 * @param string $txt El contenido
 * @param string $cant_palabras Cuantas palabras quieres mostrar
 */
function excerpt($txt, $cant_palabras){
    $txt = strip_tags($txt);
    $arr_txt = explode(" ",$txt);
    if($cant_palabras > count($arr_txt)){
        return $txt;
    } else {
        $new_txt = "";
        
        for($i=0; $i<=$cant_palabras; $i++){
            $new_txt .= $arr_txt[$i]." ";
        }
    }
    return $new_txt;
}


/**
 * Devuelve la lista de empresas asociadas al usuario logueado 
 * @param int $uid ID del usuario logueado
 * @return array Arreglo con las empresas
 */
function fnListaEmpresasXUsuario($uid){    
    global $db;
    $params = Array($uid);
    $db->where('empresasTodas',1);
    $db->where('id',$uid);
    $adminTodasEmpresas = $db->getOne('m_usuario','empresasTodas');
    if( $db->count > 0 ){
        $db->where('cuenta_id',$_SESSION[PREFIX.'login_cid']);
        $usuario_empresa = $db->rawQuery("SELECT E.nombre, E.id as id_empresa FROM m_empresa E where cuenta_id = " . $_SESSION[PREFIX.'login_cid']);
    } else {
        $usuario_empresa = $db->rawQuery("SELECT E.nombre, E.id as id_empresa FROM m_empresa E, m_usuarioempresa U WHERE U.usuario_id = ? AND U.empresa_id = E.id", $params);
    }            
    return $usuario_empresa;
}


/**
 * Recibe el nombre de la empresa. Si es mas largo que 15, lo acorta para que quepa en el boton
 * @param string $e Nombre de la empresa
 * @return string Retorna el nombre acortado o completo segun cumpla con la condicion
 */
function fnAcortaNombreEmpresa($e){
    $txt = "";
    if( strlen($e) > 15 ){
        $txt .= substr($e,0,15);                            
        $txt .= "[...]";
    } else {
        $txt = $e;
    }
    return $txt;
}

/**
 * Formatea el rut para dejarlo en el formato XXXXXXXX-X (sin puntos)
 */
function sanitize($rut){
    $rut    = strtoupper($rut);
    $find   = array('.', '-');
    $repl   = array('', '');
    $rut    = str_replace ($find, $repl, $rut);
    $rut_sin_dv = substr($rut,0,(strlen($rut)-1));
    $rut_dv = substr($rut,(strlen($rut)-1),strlen($rut));
    return $rut_sin_dv."-".$rut_dv; 
}

/**
 * fnParseResponse()
 * Recive de forma encriptada un 1 solo string con todos los parametros,
 * lo desencripta y lo parsea para procesarlo y retornarlo como arreglo
 * 
 * @param string $encrypted
 * @return Array
 */
function fnParseResponse($encrypted){    
    $params = decrypt($encrypted);        
    parse_str($params, $result);
    return $result;
}

/**
 * Perform a deep string replace operation to ensure the values in $search are no longer present
 *
 * Repeats the replacement operation until it no longer replaces anything so as to remove "nested" values
 * e.g. $subject = '%0%0%0DDD', $search ='%0D', $result ='' rather than the '%0%0DD' that
 * str_replace would return
 *
 * @param string|array $search The value being searched for, otherwise known as the needle. An array may be used to designate multiple needles.
 * @param string $subject The string being searched and replaced on, otherwise known as the haystack.
 * @return string The string with the replaced svalues.
 */
function _deep_replace( $search, $subject ) {
	$subject = (string) $subject;

	$count = 1;
	while ( $count ) {
		$subject = str_replace( $search, '', $subject, $count );
	}

	return $subject;
}

/**
 * Sanitizes a URL for use in a redirect.
 * @return string redirect-sanitized URL
 **/
function _sanitize_redirect($location) {
	$regex = '/
		(
			(?: [\xC2-\xDF][\x80-\xBF]        # double-byte sequences   110xxxxx 10xxxxxx
			|   \xE0[\xA0-\xBF][\x80-\xBF]    # triple-byte sequences   1110xxxx 10xxxxxx * 2
			|   [\xE1-\xEC][\x80-\xBF]{2}
			|   \xED[\x80-\x9F][\x80-\xBF]
			|   [\xEE-\xEF][\x80-\xBF]{2}
			|   \xF0[\x90-\xBF][\x80-\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
			|   [\xF1-\xF3][\x80-\xBF]{3}
			|   \xF4[\x80-\x8F][\x80-\xBF]{2}
		){1,40}                              # ...one or more times
		)/x';
	//$location = preg_replace_callback( $regex, '_wp_sanitize_utf8_in_redirect', $location );
	$location = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!*\[\]()]|i', '', $location);
	
    $location = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $location);
	$location = preg_replace('/(\\\\0)+/', '', $location);

	// remove %0d and %0a from location
	$strip = array('%0d', '%0a', '%0D', '%0A');
	$location = _deep_replace($strip, $location);
	return $location;
}



/**
 * Redirecciona
 * 
 * @param string $location Direccion a donde redireccionar
 * @param integer $status Codigo de redireccion. Default 302
 * @param integer $js Si debe redireccionar usando JS o php 
 * @return
 */
function redirect($location, $status = 302, $js = false, $msg = '') {
	if ( ! $location )
		return false;

	$location = _sanitize_redirect($location);
    if( $js == true ){
        if( $msg != "" ){
            echo "<script> alert('".$msg."') </script>";    
        }
        echo "<script> location.href='".$location."' </script>";
    } else {
        header("Location: $location", true, $status);    
    }
	
	return true;
}


/**
 * Funcion que encrypta varialbes antes de pasarlas
 *
 */
function encrypt($string) {
    $key = ENCRYPT_KEY;
    $result = $string;
    /*
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result.=$char;
    }
    */
    $result = base64_encode($result);    
    $result = str_replace("/",",",$result);
    return $result;
}

/**
 * Funcion que desencrypta varialbes al recibirlas
 *
 */
function decrypt($string) {
    $result = str_replace(",","/",$string);
    $result = base64_decode($result);    
    
    /*
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    */    
    return $result;
}

/**
 * Muestra un arreglo de forma amigable al usuario
 * @$array (Array)  - Arreglo
 * @$stop (Boolean) - Detener Script
 * 
 */
function show_array($array, $stop=true){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    if($stop){
        exit();
    }
}


/**
 * Retorna SI o NO segun booleano
 * 
 * @param bool, el valor booleano en 0 ó 1
 * @return string, SI ó NO
 */
function booleano($bool){
    if( $bool == '0' ){
        return 'NO';
    } else {
        return "SI";
    }
}


?>
