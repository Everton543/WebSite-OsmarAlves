<?php

	function criarSenha($id){
		$senha = substr(md5(time()), 0, 8);
		/***********************************************
		 * $mensagem = "Caro cliente, você cadastrou um
		 *	agendamento em nosso site(FALTA: colocar o link do site)
		 *	Caso queira desmarcar o agendamento siga as instruções abaixo:
		 *	(FALTA: fazer pular linha)
		 *	Entre neste link (FALTA: link da parte de agendamento). (FALTA: fazer pular linha)
		 *	Click em um dia em verde e logo após alguma hora em vermelho.
		 *	No campo ID escreva: ".$id. (FALTA: fazer pular linha)
		 *	"No campo Senha escreva: ".$senha;
		 *************************************************************************************/

		//FALTA: apagar o echo ao publicar o site com o email funcionando
		echo '{ "senha" : "'.$senha.'"} ';
		return $senha;
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if(isset($_POST['ano']) && isset($_POST['mes'])
			&& isset($_POST['horas'])){
			$ano = $_POST['ano'];
			$mes = $_POST['mes'];
			++$mes;
			include '../login.php';
			$mysqli = entrarDb("cadastro");
			$ano = $mysqli->real_escape_string($ano);
			$mes = $mysqli->real_escape_string($mes);
			$sql = "select dia, mes, ano, hora, horaGasta, minutoGasto from ".
				"clientes where ano = '".$ano."' and mes = '".$mes."';";
			$resultado = $mysqli->query($sql);
			returnJson($resultado);
			$mysqli->close();	
		}

		else if(isset($_POST['total']) && isset($_POST['semana'])){
			include '../login.php';
			$mysqli = entrarDb('cadastro');

			$total = $_POST['total'];
			$semana = $_POST['semana'];
			$total = $mysqli->real_escape_string($total);
			$semana = $mysqli->real_escape_string($semana);

			$sql = "select servico_id, tipo from serviços where gastoTotal <= '"
				.$total. "' and dia_semana = '".$semana."';";
			$resultado = $mysqli->query($sql);
			$resultado = $mysqli->query($sql);
			returnJson($resultado);
			$mysqli->close();	
		}

		else if(isset($_POST['email']) && isset($_POST['telefone'])){

			include '../login.php';
			$nome = $_POST['nome'];
			$telefone = $_POST['telefone'];
			$atividade= $_POST['atividade'];
			$atividadeId = $_POST['atividadeId'];
			$dia = $_POST['dia'];
			$mes = $_POST['mes'];
			$ano = $_POST['ano'];
			$hora = $_POST['hora'];
			$mesId = "d";

			//$id a parte do mês temque checar se os meses abaixo de 10
			//possuem um 0 na frente, se não tiver tem que colocar.

			if($mes < 10){
				$mesId = str_replace("d", "0".$mes, $mesId);
			}else{
				$mesId = str_replace("d", $mes, $mesId);
			}

			$minutoGasto = "";
			$horaGasta = "";


			//checar se email está vazio, caso estiver não enviar o email
			$email = $_POST['email'];

			$id = $dia.$mesId.$ano.$hora;
			$senha = criarSenha($id);

			$mysqli = entrarDb("cadastro");
			$nome = $mysqli->real_escape_string($nome);
			$telefone = $mysqli->real_escape_string($telefone);
			$atividade = $mysqli->real_escape_string($atividade);
			$atividadeId = $mysqli->real_escape_string($atividadeId);
			$dia = $mysqli->real_escape_string($dia);
			$mes = $mysqli->real_escape_string($mes);
			$ano = $mysqli->real_escape_string($ano);
			$hora = $mysqli->real_escape_string($hora);

			$sql = "select horaGasta, minutoGasto from `serviços`".
				" where servico_id = '".$atividadeId."';";

			$resultado = $mysqli->query($sql);
			$info = $resultado->fetch_assoc();
			
			$minutoGasto = $info['minutoGasto'];
			$horaGasta = $info['horaGasta'];

			$sql = "select id from clientes where id = '".$id."'";
			$resultado = $mysqli->query($sql);
			if($resultado->num_rows > 0){
			//FALTA: arrumar esta parte ao tirar o echo da senha
				echo '{"Mensagem": " Horario já está agendado atualize o site" }';
			}
			else if($horaGasta != "" && $minutoGasto != ""){
				$minutoGasto = $mysqli->real_escape_string($minutoGasto);
				$horaGasta = $mysqli->real_escape_string($horaGasta);
				include '../encrypt.php';

				$senha = troca($senha, $id);
				$senha = password_hash($senha, PASSWORD_DEFAULT);

				$sql = "INSERT INTO `clientes` (`nome`, `telefone`, ".
				"`atividade`, `dia`, `mes`, `ano`, `hora`, `id`, `minutoGasto`,".
				" `horaGasta`, `senha`, `email`) VALUES ('".$nome."', '"
				.$telefone."', '".$atividade."', '".$dia."', '".$mes."', '".$ano.
				"', '".$hora."', '".$id."', '".$minutoGasto."', '".$horaGasta.
				"', '".$senha."', '".$email."');";
				$mysqli->query($sql);
				$mysqli->close();
			}
		}
	}
	


?>