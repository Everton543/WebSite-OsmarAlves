<?php
	include '../login.php';
	//echo "test";
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$diaSemana = "";
		$atividade = "";
		$pesoHora = "";
		$pesoMinuto = "";
		$atividadeId = "";


		if(isset($_POST['atividadeId'])){
			$atividadeId = $mysqli->real_escape_string($_POST['atividadeId']);
		}

		if(isset($_POST['diaSemana'])){
			$diaSemana = $mysqli->real_escape_string($_POST['diaSemana']);
		}

		if(isset($_POST['atividade'])){
			$atividade = $mysqli->real_escape_string($_POST['atividade']);
		}

		if(isset($_POST['pesoHora'])){
			$pesoHora = $mysqli->real_escape_string($_POST['pesoHora']);
		}

		if(isset($_POST['pesoMinuto'])){
			$pesoMinuto = $mysqli->real_escape_string($_POST['pesoMinuto']);
		}

		$sql = "";
		echo "test";

		if($diaSemana != null && $diaSemana != ""){
			$sql = "UPDATE `servi�os` SET `dia_semana` = '"
				.$diaSemana."' WHERE `servico_id` = '"
				.$atividadeId."';";
			echo $sql. "<br>";
			echo "dia";
			$mysqli->query($sql);
		}
		if($atividade != null  && $atividade != ""){
			$sql = "UPDATE `servi�os` SET `tipo` = '"
				.$atividade."' WHERE `servico_id` = '"
				.$atividadeId."';";
			echo $sql. "<br>";
			$mysqli->query($sql);
		}
		if($pesoHora != null  && $pesoHora != ""){
			$sql = "UPDATE `servi�os` SET `horaGasta` = '"
				.$pesoHora."' WHERE `servico_id` = '"
				.$atividadeId."';";
			echo $sql. "<br>";
			$mysqli->query($sql);
		}
		if($pesoMinuto != null  && $pesoMinuto != ""){
			$sql = "UPDATE `servi�os` SET `minutoGasto` = '"
				.$pesoMinuto."' WHERE `servico_id` = '"
				.$atividadeId."';";
			$mysqli->query($sql);
			echo $sql. "<br>";
		}

		

		

		$mysqli->close();
	}	

?>