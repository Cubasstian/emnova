<?php
require_once "libs/baseCrud.php";

class integrantes extends baseCrud{
	protected $tabla = 'integrantes';

	public function getIntegrantes($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ine.id = ".$datos['valor'];
				break;
			case 'idea':
				$filtro = "ine.fk_ideas = ".$datos['valor'];
				break;
			default:
				$filtro = 0;
				break;
		}
		$sql = "SELECT
					ine.id,
					usu.nombre,
					usu.registro
				FROM
					integrantes ine INNER JOIN usuarios usu ON ine.integrante = usu.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}
}