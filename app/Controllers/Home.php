<?php

namespace App\Controllers;
use Carbon\Carbon;
use App\Controllers\conexion;

class Home extends BaseController
{
    public function index()
    {   

        $cn = conexion::conexion();

        $nombreUnidad = 'Unidad Fomento';
        $tipoUnidades = [["id" => 'uf', "name" => 'Unidad Fomento'], 
                         ["id" => 'ivp', "name" => 'Indice de valor promedio'],
                         ["id" => 'dolar', "name" => 'Dólar observado'],
                         ["id" => 'dolar_intercambio', "name" => 'Dolar acuerdo'],
                         ["id" => 'euro', "name" => 'Euro'],
                         ["id" => 'ipc',  "name" => 'Indice de precios al consumir'],
                         ["id" => 'utm', "name" => 'Unidad tributaria mensual'],
                         ["id" => 'imacec', "name" => 'Imacec'],
                         ["id" => 'tpm', "name" => 'Tasa política monetaria'],
                         ["id" => 'libra_cobre', "name" => 'Libra de cobre'],
                         ["id" => 'tasa_desempleo', "name" => 'Tasa de desempleo'],
                         ["id" => 'bitcoin', "name" => 'Bitcoin']];

        $urlbase = 'https://mindicador.cl/api/uf';
        $data = self::getUrl($urlbase);
        if ($_GET) {
            $tipo = $_REQUEST['tipo'];
            $nombreUnidad = self::nombreUnidad($tipo);
            if (isset($_REQUEST['ano'])) {
                $ano = $_REQUEST['ano'];
            }

            if ($tipo != '' && $ano == '' && $_REQUEST['nomRangoFecha'] == '') {
                $urlbase = 'https://mindicador.cl/api/'.$tipo;
                $data = self::getUrl($urlbase);
            }

            if ($tipo != '' && $ano != '' && $_REQUEST['nomRangoFecha'] == '') {
                $urlbase = 'https://mindicador.cl/api/'.$tipo.'/'.$ano;
                $data = self::getUrl($urlbase);
            }

            if ($tipo != '' && $_REQUEST['nomRangoFecha'] != '') {
                $urlbase = 'https://mindicador.cl/api/'.$tipo;
                $rangoFechas = explode('-', $_REQUEST['nomRangoFecha']);
                $fechaIni = trim(str_replace('/','-', $rangoFechas[0]),' ');
                $fechaTer = trim(str_replace('/','-', $rangoFechas[1]),' ');
                $data = self::arregloRango($urlbase,$fechaIni,$fechaTer);
            }
        }
        $valores = json_encode($data[0]);
        $fechas = json_encode($data[1]);
        return view('welcome_message', compact('tipoUnidades','valores','fechas','nombreUnidad'));
    }

    public static function getUrl($urlbase){
        $ch = file_get_contents($urlbase);
        $jch = json_decode($ch);
        $valores = [];
        $fechas = [];
        if (count($jch->serie)>0) {
            foreach ($jch->serie as $key => $value) {
                $valores[] = round($value->valor);
                $date = date_create($value->fecha);
                $fechas[] = date_format($date,'d-m-Y');
            }
        }
        return [$valores, $fechas];
    }

    public static function nombreUnidad($str){
        switch ($str) {
            case 'bitcoin':
                return 'Bitcoin';
                break;

            case 'ivp':
                return 'Indice de valor promedio';
                break;

            case 'dolar':
                return 'Dólar observado';
                break;
            case 'dolar_intercambio':
                return 'Dolar acuerdo';
                break;

            case 'euro':
                return 'Euro';
                break;

            case 'ipc':
                return 'Indice de precios al consumir';
                break;

            case 'utm':
                return 'Unidad tributaria mensual';
                break;

            case 'imacec':
                return 'Imacec';
                break;

            case 'tpm':
                return 'Tasa política monetaria';
                break;

            case 'libra_cobre':
                return 'Libra de cobre';
                break;

            case 'tasa_desempleo':
                return 'Tasa de desempleo';
                break;

            default:
                return 'Unidad Fomento';
                break;
        }
    }

    public static function arregloRango($urlbase, $fechaIni, $fechaTer){
        $fecha_loop = $fechaIni;
        $valores = [];
        $fechas = [];

        while($fecha_loop<$fechaTer){
            $ch = file_get_contents($urlbase.'/'.$fecha_loop);
            $jch = json_decode($ch);

            if (count($jch->serie)>0) {
                foreach ($jch->serie as $key => $value) {
                    $valores[] = round($value->valor);
                    $date = date_create($value->fecha);
                    $fechas[] = date_format($date,'d-m-Y');
                }
            }

            $fecha_loop = date('d-m-Y',strtotime($fecha_loop.'+ 1 days'));
        }
        return [$valores, $fechas];
    }
}
