<?php
require_once "libs/baseCrud.php";
require_once "ideas.php";

class resultados extends baseCrud{
	protected $tabla = 'resultados';

	
	public function getResultados($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "res.id = ".$datos['valor'];
				break;
			case 'evaluador':
				$filtro = "res.fk_ideas = $datos[idea] AND res.creado_por = ".$_SESSION['usuario']['id'];
				break;
			default:
				$filtro = 0;
				break;
		}
		$sql = "SELECT
					res.id,
					cri.nombre,
					res.valor
				FROM
					resultados res INNER JOIN criterios cri ON res.fk_criterios = cri.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}

	public function guardarRespuestas($datos){
		$temp = '';
		$db = new database();
		foreach ($datos['respuestas'] as $key => $value) {
			$temp = explode("_", $key);
			$sql = "INSERT INTO
						resultados
					SET
						fk_ideas = $datos[idea],
						fk_criterios = $temp[1],
						valor = $value,
						creado_por = ".$_SESSION['usuario']['id'].",
						fecha_creacion=NOW()";
       		$resultado = $db->ejecutarConsulta($sql, false);
       	}       	
       	return $resultado;
	}
}