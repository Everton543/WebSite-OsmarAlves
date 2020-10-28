<?php
	include '../login.php';

	/************************************************************
	 * TO-DO:
	 * 2- Assim que confirmar o código como correto deletar o codigo
	 *	do banco de dados.
	 **********************************************************/

	/***********************************************
	 * function: fazerCodigoSeguro
	 * Purpose: create a random integer number of 6
	 *	digits.
	 ***********************************************/
	function fazerCodigoSeguro(){
		$text = "d";
		$codigo=  rand(100000, 999999);
		$text = str_replace("d", $codigo, $text);
		return $text;
	}

	/**************************************************************
	 * function: enviarCodigo
	 * Purpose: Send the random integer number to the client's email
	 **************************************************************/
	 //Atualizar
	function enviarCodigo($codigo, $email){
	//https://www.youtube.com/watch?v=6y_czpK8_Hg para aprender a enviar email.
		$to = "everton.felipe.alves@gmail.com";
		$subject = "MUDAR SENHA";
		$txt = "Código: " .$codigo. " \n \n Caro cliente você fez uma solicitação para mudar a senha.
			Caso não tenha sido você que fez este pedido recomendamos que mude
			a senha de seu email para maior segurança.";
		$headers = "From: everton.felipe.alves@gmail.com";

		$txt = wordwrap($txt,70);
		if(mail($to,$subject,$txt,$headers)){
		    echo "Email sent";
		}
		else{
		    echo "Email sending failed";
		}



		//echo "Enviar codigo: " .$codigo. "</br> para email: "
			 //.$email."</br>";

                //quando conseguir enviar o código por email
                //tirar o codigo do json
				//logo apos consertar a função salvarCodigo
				//para não dar erro no json;
		echo '{ "codigo" : "' .$codigo.'",';
	}

	function checarTempo($data){
		date_default_timezone_set("America/Recife");
		$dataAt = date('Y-m-d H:i:s');
		$hora = date('H');
		$erro = false;

		for($i = 0; $i < 10; $i++){
			if($data[$i] != $dataAt[$i]){
				$erro = true;
			}
		}

		$erro = false;
		$horaDb = $data[11].$data[12];
		$check = $hora - $horaDb;
		if($check > 1){
			$erro = true;	
		}

		if($erro == true){
			return $erro;
		}
		else{
			return $erro;
		}
	}

	function salvarCodigo(){
		if(isset($_POST["email"])){
			include 'encrypt.php';
			$codigo = fazerCodigoSeguro();


			$chave = "";
			$mysqli = entrarDb("cadastro");
			$email = $_POST["email"];
			$email = $mysqli->real_escape_string($email);
			$sql = "select * from login where email = '"
					.$email."';";
			$resposta = $mysqli->query($sql);
			if(mysqli_num_rows($resposta) == 0){
				$erro = "Email não válido";
				$erro = mb_convert_encoding($erro, "UTF8");
				echo '{"erro":"'.$erro.'"}';
			}
			else{
				enviarCodigo($codigo, $email);
				$info = $resposta->fetch_assoc();
				$id = $info['id'];
				
				$mysqli->close();
				$mysqli = entrarDb("chave");
				$id = $mysqli->real_escape_string($id);
				$sql = "select chave from chaves where est_id = '"
						.$id."';";
				$resposta = $mysqli->query($sql);
				if(mysqli_num_rows($resposta) == 0){
					$chave = novaChave();
					$chave = $mysqli->real_escape_string($chave);
					$sql = "INSERT INTO chaves (chave, est_id) VALUES ('";
					$sql.= $chave."', '".$id."');";
					$mysqli->query($sql);
				}
				else{
					$info = $resposta->fetch_assoc();
					$chave = $info['chave'];
				}

				if($chave != ""){
					$codigo = troca($codigo, $chave);
					$hash = password_hash($codigo, PASSWORD_DEFAULT);
					$sql = "select * from codigoseguro where est_id = '"
						.$id."';";
					$resposta = $mysqli->query($sql);
					
					if(mysqli_num_rows($resposta) == 0){
						$sql = "INSERT INTO `codigoseguro` (`codigo`) VALUES ('"
							.$hash."');";
						$mysqli->query($sql);
						$mysqli->close();
						echo '"certo" : "' .true.'", "id" : "'.$id.'" }';

					}
					else{
						$info = $resposta->fetch_assoc();
						$codigoId = $info["id"];
						date_default_timezone_set("America/Recife");
						$data = date('Y-m-d H:i:s');

						$sql = "UPDATE `codigoseguro` SET `codigo` = '"
							.$hash."', tempo = '".$data."' WHERE (`id` = '".$codigoId."');";
						$mysqli->query($sql);
						$mysqli->close();
						echo '"certo" : "' .true.'", "id" : "'.$id.'" }';
					}
				}
			}
		}
	}	
	
	function salvarSenha(){
		if(isset($_POST["senha"])){
			include 'encrypt.php';
			$senha = $_POST["senha"];
			$id = $_POST['id'];

			$chave = "";
			$mysqli = entrarDb("chave");
			$id = $mysqli->real_escape_string($id);
			$sql = "select chave from chaves where est_id = '"
				.$id."';";
			$senha = $mysqli->real_escape_string($senha);
			$resposta = $mysqli->query($sql);
				
			$resposta = $mysqli->query($sql);
			if(mysqli_num_rows($resposta) == 0){
				$chave = novaChave();
				$chave = $mysqli->real_escape_string($chave);
				$sql = "INSERT INTO chaves (chave, est_id) VALUES ('";
				$sql .= $chave."', '".$id."');";
				$mysqli->query($sql);
			}
			else{
				$info = $resposta->fetch_assoc();
				$chave = $info['chave'];
			}

			if($chave != ""){
				$mysqli->close();
				$mysqli = entrarDb("cadastro");
				$senha = troca($senha, $chave);
				$hash = password_hash($senha, PASSWORD_DEFAULT);
				$sql = "UPDATE `login` SET `senha` = '".$hash.
						"' WHERE (`id` = '".$id."');";
				$mysqli->query($sql);
				$mysqli->close();
			}
		}
	}


	/************************************************************
	 * Function: senhaValida
	 * Purpose: Check if the future password is strong or not.
	 ************************************************************/
	function senhaValida($senha){
		$maiuscula = preg_match('@[A-Z]@', $senha);
		$minuscula = preg_match('@[a-z]@', $senha);
		$numero = preg_match('@[0-9]@', $senha);
		
		if(!$maiuscula){
			//echo "Falta letra maiúscula";
			return false;
		}
		else if (!$minuscula){
			//echo "Falta letra minúscula";
			return false;
		}
		else if (!$numero){
			//echo "Falta número";
			return false;
		}
		else if(strlen($senha) < 8){
			//echo "Senha menos de 8 caracteres";
			return false;
		}
		else{
		    return true;
		}
	}

	function compararCodigo(){
		include 'encrypt.php';
		$email = $_POST['email'];
		$codigo = $_POST['codigo'];
		$id = $_POST['id'];
		$chave = "";
		$mysqli = entrarDb("chave");
		$email = $mysqli->real_escape_string($email);
		$id = $mysqli->real_escape_string($id);
		$codigo = $mysqli->real_escape_string($codigo);

		$sql = "select * from chaves where est_id = '"
				.$id. "';";
		$resposta =  $mysqli->query($sql);

		if(mysqli_num_rows($resposta) == 0){
			return false;
		}
		else{
			$inf = $resposta->fetch_assoc();
			$chave = $inf['chave'];
				
			if($chave != ""){
				$codigo = troca($codigo, $chave);						
				$sql = "select * from codigoseguro where est_id = '"
					.$id. "';";
				$resposta =  $mysqli->query($sql);
				if ($resposta->num_rows > 0){
					$info = $resposta->fetch_assoc();

					if(password_verify($codigo ,$info['codigo'])){
						return true;
					}
					else{
						return false;
					}
				}
				else {
					return false;
		        }					
			}
		}
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if(isset($_POST["email"]) && isset($_POST['salva'])){
			salvarCodigo();
		}

		if(isset($_POST['email']) && isset($_POST['codigo'])){
			$resultado = compararCodigo();
			echo '{"resultado": "' .$resultado.'" }';
		}

		if(isset($_POST['senha'])){
			$senha = $_POST['senha'];
			
			if(isset($_POST['repSenha'])){
				$repSenha = $_POST['repSenha'];
			}
			else{
				echo '{ "erro" : "Problema no código do site"}';
			}

			if($senha == $repSenha && ($senha != "" || $senha != null)){
			//codigo para mudar a senha.
				if(senhaValida($senha)){
					salvarSenha();
					echo '{"certo": "'.true.'"}';
				}
				else{
					echo '{ "erro" : "Senha fraca"}';
				}
			}
		}
	}
?>