<?php
	include '../login.php';

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$sql = "select * from `serviços` order by dia_semana, tipo;";
		$resultado = $mysqli->query($sql);
		returnJson($resultado);

		$mysqli->close();
	}

?>