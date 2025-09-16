<?php
require_once "libs/baseCrud.php";

class ideasCriterios extends baseCrud{
	protected $tabla = 'ideas_criterios';

	public function guardarCriterio($datos){
		//Primero evaluo que no lo deje pasar de 100
		$total = $datos['info']['peso'] + $this->sumarCriterios($datos['info']['fk_ideas']);		
		if($total > 100){
			return [
					'ejecuto' => false,
					'mensajeError' => 'La suma de los pesos no debe superar 100%'
				];
		}else{
			return parent::insert($datos);
		}
	}

	public function sumarCriterios($idea){
		$suma = 0;
		$pesos = parent::select([
									'info' => [
										'fk_ideas' => $idea
									]
								]);
		foreach ($pesos['data'] as $value){
			$suma += $value['peso'];
		}
		return $suma;
	}

	public function getIdeasCriterios($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ic.id = ".$datos['valor'];
				break;
			case 'idea':
				$filtro = "ic.fk_ideas = ".$datos['valor'];
				break;
			default:
				$filtro = 0;
				break;
		}		
		$sql = "SELECT
					ic.id,
					cri.id AS idCriterio,
					cri.nombre,
					cri.descripcion,
					cri.escala,
					ic.peso
				FROM
					ideas_criterios ic INNER JOIN criterios cri ON ic.fk_criterios = cri.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}
}