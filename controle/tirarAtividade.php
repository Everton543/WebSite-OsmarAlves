<?php
	include '../login.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$atividadeId = $_POST["atividadeId"];
		$atividadeId = $mysqli->real_escape_string($atividadeId);

		$sql = "DELETE FROM `serviços` WHERE `servico_id` = '"
			.$atividadeId."';";

		$mysqli->query($sql);

		$mysqli->close();
	}	

?>