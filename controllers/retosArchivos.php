<?php
require_once "libs/baseCrud.php";

class retosArchivos extends baseCrud{
	protected $tabla = 'retos_archivos';

	public function insert($datos){
		$db = new database();
		$sql = "INSERT INTO {$this->tabla} SET ";
		foreach ($datos['info'] as $key => $value) {
			$sql .= "$key = '".$db->real_escape_string($value)."',";
		}
		$sql .= "creado_por = ".$_SESSION['usuario']['id'].", fecha_creacion = NOW(), modificado_por = 0, fecha_modificacion = NOW()";
		return $db->ejecutarConsulta($sql);
	}

	public function update($datos){
		$db = new database();
		$sql = "UPDATE {$this->tabla} SET ";
		foreach ($datos['info'] as $key => $value) {
			$sql .= "$key = '".$db->real_escape_string($value)."',";
		}
		$sql .= "modificado_por = ".$_SESSION['usuario']['id'].", fecha_modificacion = NOW()";
		$sql .= " WHERE id = " . intval($datos['id']);
		return $db->ejecutarConsulta($sql);
	}
}