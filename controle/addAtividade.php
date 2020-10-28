<!DOCTYPE html>
<html lang="pt">
    <head>
            <meta http-equiv="content-type" content="text/html;charset=utf-8" /> <!--Introduza esta linha no teu html-->
            <title>Osmar Studio</title>
    </head>
    <body>

<?php
	include '../login.php';
	header('Content-Type: text/html; charset=utf-8');

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$mysqli = entrarDb("cadastro");
		$diaSemana = $mysqli->real_escape_string($_POST['diaSemana']);
		$atividade = $mysqli->real_escape_string($_POST['atividade']);
		$pesoHora = $mysqli->real_escape_string($_POST['pesoHora']);
		$pesoMinuto = $mysqli->real_escape_string($_POST['pesoMinuto']);

		$sql = "INSERT INTO `serviços` (`dia_semana`, `tipo`, `horaGasta`, `minutoGasto`)
				VALUES ('".$diaSemana."', '".$atividade."', '".$pesoHora."', '".$pesoMinuto."');";
		$mysqli->query($sql);
		$mysqli->close();
		echo "Tentei";
	
	}
?>

    </body>
</html>