<?php
	include '../login.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$sql = "SELECT dia_semana, tipo, horaGasta, minutoGasto FROM `servi�os`;";
		$resultado = $mysqli->query($sql);
		returnJson($resultado);
		$mysqli->close();	
	}

?>