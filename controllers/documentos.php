<?php
require_once "libs/baseCrud.php";

class documentos extends baseCrud{
	protected $tabla = 'documentos';

	public function insert($datos){
		$db = new database();
		$sql = "INSERT INTO {$this->tabla} SET ";
		foreach ($datos['info'] as $key => $value) {
			$sql .= "$key = '".$db->real_escape_string($value)."',";
		}
		$sql .= "fk_diusuario = ".$_SESSION['usuario']['id'].", fecha_creacion=NOW()";
		return $db->ejecutarConsulta($sql);
	}

	public function update($datos){
		$db = new database();
		$sql = "UPDATE {$this->tabla} SET ";
		foreach ($datos['info'] as $key => $value) {
			$sql .= "$key = '".$db->real_escape_string($value)."',";
		}
		$sql = rtrim($sql, ',');
		$sql .= " WHERE id = " . intval($datos['id']);
		return $db->ejecutarConsulta($sql);
	}
}