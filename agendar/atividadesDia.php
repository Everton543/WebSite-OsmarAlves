<?php
	include '../login.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$diaSemana = $_POST["diaSemana"];
		$diaSemana = $mysqli->real_escape_string($diaSemana);
		$sql = "SELECT tipo, servico_id FROM `serviços` where dia_semana = '".$diaSemana."';";
		$resultado = $mysqli->query($sql);
		returnJson($resultado);
		$mysqli->close();
	}	

?>