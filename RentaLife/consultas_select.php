<?php
include("conexion.php");

// Consulta de municipios
$municipios = $conexion->query("SELECT * FROM municipio ORDER BY nombre_municipio");

// Consulta de colonias
$colonias = $conexion->query("SELECT * FROM colonia ORDER BY nombre_colonia");

// Consulta de tipos de propiedad
$tipos = $conexion->query("SELECT * FROM tipo_propiedad ORDER BY nombre_tipo");

//Consulta de servicios
$sql_servicios = "SELECT * FROM servicios ORDER BY nombre_servicio";
$result_servicios = $conexion->query($sql_servicios);
?>

