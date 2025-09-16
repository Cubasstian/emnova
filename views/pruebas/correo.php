<?php
require_once "controllers/correo.php";

$obj = new correo();
$datos = [
	'vigencia' => 2021
];
$respuesta = $obj->pruebaUnitaria($datos);
print_r($respuesta);
?>