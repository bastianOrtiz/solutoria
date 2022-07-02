<?php

namespace App\Controllers;
use App\Controllers\conexion;
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

}