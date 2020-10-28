<?php
	include '../login.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$sql = "SELECT dia_semana, tipo, horaGasta, minutoGasto FROM `serviços`;";
		$resultado = $mysqli->query($sql);
		returnJson($resultado);
		$mysqli->close();	
	}

?>