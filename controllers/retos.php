<?php
require_once "libs/baseCrud.php";

class retos extends baseCrud{
	protected $tabla = 'retos';

	public function getRetos($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ret.id = ".$datos['valor'];
				break;
			case 'activos':
				$hoy = date('Y-m-d');
				$filtro = "'".$hoy."' BETWEEN fecha_inicio AND fecha_fin";
				break;
			default:
				$filtro = 0;
				break;
		}
		$sql = "SELECT
					ret.*
				FROM
					retos ret
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}

	public function getRetosTotal(){
		$sql="
			SELECT  
			rt.id,
			rt.titulo,
			rt.descripcion,
			rt.fecha_inicio,
			rt.fecha_fin,
			rt.estado,
			rt.creado_por,
			rt.fecha_creacion,
			us.id as usid, 
			us.nombre, 
			us.registro
			FROM retos rt
			INNER JOIN usuarios us ON us.id = rt.creado_por
			WHERE 1;
		";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}
}