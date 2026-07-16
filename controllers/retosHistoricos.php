<?php
require_once "libs/baseCrud.php";

class retosHistorico extends baseCrud{
	protected $tabla = 'retos_historico';

	public function getHistorico($datos){
		$sql = "SELECT
					idrh.id,
					usu.nombre,
					idrh.informacion,
					idrh.fecha_creacion
				FROM
					retos_historico idrh INNER JOIN usuarios usu ON idrh.creado_por = usu.id
				WHERE
					idrh.fk_idretos = $datos[reto]
				ORDER BY
					idrh.fecha_creacion";
		$db = new database();
       	return $db->ejecutarConsulta($sql);
    }
}