<?php
require_once "libs/baseCrud.php";

class dependencia extends baseCrud {
	protected $tabla = 'dependencia';

	public function getDuplicados($datos){
		$sql = "SELECT code_gerencia, dependencia, COUNT(*) AS cantidad FROM `dependencias` GROUP BY dependencia HAVING COUNT(*) > 1";
		$db = new database();
		return $db->ejecutarConsulta($sql);
	}
}


?>