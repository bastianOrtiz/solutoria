<?php

namespace App\Controllers;
use App\Controllers\conexion;
use Carbon\Carbon;
use CodeIgniter\HTTP\RequestInterface;

class crudUnidades extends BaseController{

	public function index(){

		$cn = conexion::conexion();

		$unidades = self::listaUnidades($cn);

		return view('crud_unidades', compact('unidades'));
	}

	public static function listaUnidades($conex){

        $dataDB = $conex->query("select * from unidad")->fetch_all(MYSQLI_ASSOC);

        return $dataDB;
	}

	public function eliminar(){
		if ($_GET['id']) {
			$cn = conexion::conexion();
			$dataDBeliminar = $cn->query("delete from unidad where id = ".$_GET['id']);
		}
		return json_encode('Registro eliminado');
	}

	public function getOne(){
		if ($_GET['id']) {
			$cn = conexion::conexion();
			$dataDBUnidad = $cn->query("select * from unidad where id = ".$_GET['id'])->fetch_all(MYSQLI_ASSOC);
		}
		$dataDBUnidad = $dataDBUnidad[0];
		return json_encode($dataDBUnidad);
	}

	public function editar(){

		$cn = conexion::conexion();
		$dataDBeliminar = $cn->query("update unidad set valor = ".$_POST['valor']." where id = ".$_POST['id']);

		return json_encode('Registro Modificado');
	}

	public function insertar(){
		$ch = file_get_contents('https://mindicador.cl/api/uf/2022');
        $jch = json_decode($ch);
        
        //INSERT INTO `unidad`(`id`, `codigo`, `nombre`, `fecha`, `valor`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

        foreach ($jch->serie as $key => $value) {
        	$cn = conexion::conexion();
        	$validar = $cn->query("select * from unidad where codigo='".$jch->codigo."' and fecha='".Carbon::parse($value->fecha)->format('Y-m-d')."'")->fetch_all(MYSQLI_ASSOC);

        	if (count($validar)==0) {
        		$cn->query("INSERT INTO `unidad`(`codigo`, `nombre`, `fecha`, `valor`) VALUES ('".$jch->codigo."','".$jch->nombre."','".Carbon::parse($value->fecha)->format('Y-m-d')."',".$value->valor.")");
        	}
        }

        return json_encode("Registros actualizados");
	}

}