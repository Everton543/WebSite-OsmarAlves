<?php
	if(isset($_POST['id']) && isset($_POST['senha'])){
		include '../login.php';
		include '../encrypt.php';
		$id = $_POST['id'];
		$senha = $_POST['senha'];
		

		$mysqli = entrarDb("cadastro");
		$id = $mysqli->real_escape_string($id);
		$senha = $mysqli->real_escape_string($senha);
		$senha = troca($senha, $id);

		$sql =  "SELECT id, senha FROM clientes where id = '" .$id. "';";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0){
            $info = $result->fetch_assoc();
            if(password_verify($senha ,$info['senha'])){        
				$sql = "DELETE FROM `clientes` WHERE `id` = '".
					$id."';";
				$mysqli->query($sql);

				$mysqli->close();	
				echo '{ "resultado" : "true"}';
            }
        }
        else {
             echo '{ "resultado" : "false"}';
        }
	}
	else if (isset($_POST['id']) && isset($_POST['senha'])
		&& isset($_POST['controle'])){

		include '../login.php';
		$logado = login($_POST['id'], $_POST['senha']);
		if($logado){
			$sql = "DELETE FROM `clientes` WHERE `id` = '".
				$id."';";
			$mysqli->query($sql);
			$mysqli->close();	
			echo '{ "resultado" : "true"}';
		}
		else{
			echo '{ "resultado" : "false"}';
		}
	}
?>