<?php
require_once "libs/baseCrud.php";

class ideasHistorico extends baseCrud{
	protected $tabla = 'ideas_historico';

	public function getHistorico($datos){
		$sql = "SELECT
					usu.nombre,
					idh.informacion,
					idh.fecha_creacion
				FROM
					ideas_historico idh INNER JOIN usuarios usu ON idh.creado_por = usu.id
				WHERE
					idh.fk_ideas = $datos[idea]
				ORDER BY
					idh.fecha_creacion";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
    }
}