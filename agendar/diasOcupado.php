<?php	
	function alterarTabela($tipo, $cheio){

		$ano = $_POST['ano'];
		$mes = $_POST['mes'];
		$dia = $_POST['dia'];


		++$mes;

		$mesId = "d";

		//$id a parte do mês temque checar se os meses abaixo de 10
		//possuem um 0 na frente, se não tiver tem que colocar.

		if($mes < 10){
			$mesId = str_replace("d", "0".$mes, $mesId);
		}else{
			$mesId = str_replace("d", $mes, $mesId);
		}

		$id = $dia.$mesId.$ano;
		include '../login.php';
		$mysqli = entrarDb("cadastro");
		$ano = $mysqli->real_escape_string($ano);
		$mes = $mysqli->real_escape_string($mes);
		$mesId = $mysqli->real_escape_string($mesId);
		$cheio = $mysqli->real_escape_string($cheio);
		$dia = $mysqli->real_escape_string($dia);
		$id = $mysqli->real_escape_string($id);

		$sql = "";

		if($tipo == "novo"){
			$sql = "INSERT INTO `dia_cheio` (`dia`, `mes`, `ano`,".
				" `cheio`, `id`) VALUES ('".$dia."', '".$mes."', '".
				$ano."', '".$cheio."', '".$id."');";
		}else if($tipo == "muda"){
			$sql = "UPDATE `dia_cheio` SET `cheio` = '".$cheio."'".
				" WHERE (`id` = '".$id."');";
		}

		$mysqli->query($sql);
		$mysqli->close();	
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if(isset($_POST['ano']) && isset($_POST['mes'])
			&& isset($_POST['consultar'])){

			$ano = $_POST['ano'];
			$mes = $_POST['mes'];
			++$mes;
			include '../login.php';
			$mysqli = entrarDb("cadastro");
			$ano = $mysqli->real_escape_string($ano);
			$mes = $mysqli->real_escape_string($mes);
			$sql = "select dia, mes, cheio from dia_cheio 
				where ano = '".$ano."' and mes = '".$mes."';";
			$resultado = $mysqli->query($sql);
			returnJson($resultado);
			$mysqli->close();	
		}

		
		//Falta testar esta parte do código
		else if(isset($_POST['ano']) && isset($_POST['mes'])
			&& isset($_POST['dia']) && isset($_POST['novo'])){
			
			$cheio = 1;
			alterarTabela("novo", $cheio);
		}

		else if(isset($_POST['cheio'])){
			$cheio = $_POST['cheio'];
			alterarTabela("muda", $cheio);
		}
	}
?>