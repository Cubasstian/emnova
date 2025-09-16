<?php
require_once "libs/baseCrud.php";
require_once "integrantes.php";
require_once "ideasHistorico.php";
require_once "ideasCriterios.php";

class ideas extends baseCrud{
	protected $tabla = 'ideas';

	public function crear($datos){
		//print_r($datos);
		$datos['estado'] = 1;
		//Incluir fecha de modificación para que inicie el conteo
		$datos['info']['fecha_modificacion'] = date("Y-m-d H:i:s");

		//Se inserta la idea
		$resultado = parent::insert([
			'info' => $datos['info']
		]);		

		//Se gauardan los integrantes incluyendo primero al líder
		if($resultado['ejecuto']){
			//Ingreso integrantes
			$objIntegrantes = new integrantes();
			foreach ($datos['integrantes'] as $value) {
				$respuesta = $objIntegrantes->insert([
					'info' => [
						'fk_ideas' => $resultado['insertId'],
						'integrante' => $value
					]
				]);				
			}

			//ingresamos historico			
			$objHistorico = new ideasHistorico();
			$respuesta = $objHistorico->insert([
				'info'=>[
					'fk_ideas'=>$resultado['insertId'],
					'informacion'=>json_encode($datos)
				]
			]);
			if($respuesta['ejecuto']){
				return $resultado;
			}
		}
	}

	public function getIdeas($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ide.id = ".$datos['valor'];
				break;
			case 'proponente':
				$filtro = "ide.creado_por = ".$_SESSION['usuario']['id'];
				break;
			case 'gestor':
				if($_SESSION['usuario']['rol'] == 'Administrador'){
					$filtro = 1;	
				}else{
					$filtro = "ide.gestor = ".$_SESSION['usuario']['id'];
				}
				break;
			case 'todas':				
				$filtro = 1;
				break;
			default:
				$filtro = 0;
				break;
		}
		if(isset($datos['estado'])){
			$filtro .= " AND ide.estado = ".$datos['estado'];
		}
		$sql = "SELECT
					ide.id,
					ret.id AS idReto,
					ret.titulo AS reto,
					ide.titulo,
					ide.descripcion,
					ide.fecha_pitch,
					ide.lugar_pitch,
					ges.id AS idGestor,
					ges.nombre AS gestor,
					ide.estado,
					DATEDIFF(NOW(),ide.fecha_modificacion) AS dias
				FROM
					(ideas ide INNER JOIN retos ret ON ide.fk_retos = ret.id) INNER JOIN usuarios ges ON ide.gestor = ges.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}

	public function getIdeasAll($datos){
		$filtro = 0;
		switch ($datos['criterio']) {
			case 'id':
				$filtro = "ide.id = ".$datos['valor'];
				break;			
			default:
				$filtro = 0;
				break;
		}
		$sql = "SELECT
					ide.id,
					tip.nombre AS tipo,
					ide.titulo,
					ide.descripcion,
					ide.justificacion,
					ide.objetivo,
					ide.beneficios,
					ide.tiempo,
					pro.nombre AS proponente,
					ges.id AS idGestor,
					ges.nombre AS gestor,
					ide.estado,
					ide.fecha_creacion,
					DATEDIFF(NOW(),ide.fecha_modificacion) AS dias
				FROM
					((ideas ide INNER JOIN tipos tip ON ide.fk_tipos = tip.id) INNER JOIN usuarios pro ON ide.creado_por = pro.id) INNER JOIN usuarios ges ON ide.gestor = ges.id
				WHERE					
					$filtro";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}

	public function updateIdeas($datos){
		//Actualizo la solicitud
		$resultado = parent::update($datos);
		//Guardo historico
		if($resultado['ejecuto']){
			//ingresamos historico			
			$objHistorico = new ideasHistorico();
			$respuesta = $objHistorico->insert([
				'info'=>[
					'fk_ideas'=>$datos['id'],
					'informacion'=>json_encode($datos['info'])
				]
			]);
			if($respuesta['ejecuto']){
				return $resultado;
			}
		}else{
			return $resultado;
		}
	}

	public function updateIdeasVerificar($datos){
		$objIdeasCriterios = new ideasCriterios();
		$sumaPesos = $objIdeasCriterios->sumarCriterios($datos['id']);
		if($sumaPesos == 100){
			return $this->updateIdeas($datos);
		}else{
			return [
					'ejecuto' => false,
					'mensajeError' => 'Los criterios deben sumar 100%'
				];
		}
	}

	public function getCalificar($datos){
		$filtro = "ie.evaluador = ".$_SESSION['usuario']['id'];
		if($_SESSION['usuario']['rol'] == 'Administrador'){
			$filtro = 1;	
		}else if($_SESSION['usuario']['rol'] == 'Gestor'){
			$filtro = "ide.gestor = ".$_SESSION['usuario']['id'];
		}
		$sql = "SELECT
					ide.id,
					ret.id AS idReto,
					ret.titulo AS reto,
					ide.titulo,
					ide.descripcion,
					ide.estado,
					DATEDIFF(NOW(),ide.fecha_modificacion) AS dias
				FROM
					ideas_evaluadores ie INNER JOIN (ideas ide INNER JOIN retos ret ON ide.fk_retos = ret.id) ON ie.fk_ideas = ide.id
				WHERE
					$filtro
					AND ide.estado = 4";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
	}
}