<?php
require_once "libs/baseCrud.php";

class ideasEvaluadores extends baseCrud{
	protected $tabla = 'ideas_evaluadores';

	public function getIdeasEvaluadores($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ie.id = ".$datos['valor'];
				break;
			case 'idea':
				$filtro = "ie.fk_ideas = ".$datos['valor'];
				break;
			default:
				$filtro = 0;
				break;
		}		
		$sql = "SELECT
					ie.id,
					usu.nombre,
					usu.registro
				FROM
					ideas_evaluadores ie INNER JOIN usuarios usu ON ie.evaluador = usu.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}
}