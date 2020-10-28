<?php 
    DEFINE("user", "root");
    DEFINE("serv", "localhost");
    DEFINE("pass", "");
function entrarDb($database){

    //DEFINE("db", $database);
    //$mysqli = new mysqli(serv, user, pass, $database);
    //$mysqli->set_charset("utf8");
    return new mysqli(serv, user, pass, $database);
}

function login($id, $senha){
    include 'encrypt.php';

    $chave = "";
    $mysqli = entrarDb("chave");
    $logId = $mysqli->real_escape_string($id);
    $logSenha = $mysqli->real_escape_string($senha);

    $q = "select * from chaves where est_id = '" .$logId. "';";
    $resposta = $mysqli->query($q);
    if($resposta == null || $resposta === false){
        return false;
    }
    else{
        $inf = $resposta->fetch_assoc();
        $chave = $inf['chave'];

        if($chave != ""){
            $logSenha = troca($logSenha, $chave);
            $mysqli->close();

            $mysqli = entrarDb("cadastro");
            if ($mysqli->connect_errno) {
                return false;
            }
            $sql =  "SELECT id, senha FROM login where id = '" .$logId. "';";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0){
                $info = $result->fetch_assoc();
                if(password_verify($logSenha ,$info['senha'])){
                    return true;
                }
            }
            else {
                return false;
            }

            $mysqli->close();
        }
    }
}

function mudarSenha($id, $senha){
    $mysqli = entrarDb("cadastro");
    $logSenha = $mysqli->real_escape_string($senha);
    $chave = substr(md5(Rand()), 0, 25);

    $logId = $mysqli->real_escape_string($id);
    $logSenha = troca($logSenha, $chave);
    $hash = password_hash($logSenha, PASSWORD_DEFAULT);
    $sql =  "SELECT * FROM login where id = '" .$logId. "';";
    $result = $mysqli->query($sql);
    $id = "";

    if ($result->num_rows > 0){
        $info = $result->fetch_assoc();
        if(password_verify($logSenha ,$info['senha'])){
            $id = $info['estRef'];
            $sql =  "UPDATE cadastro. login SET senha = '".$hash.
                "' WHERE (`id` = '".$logId."');";
            $mysqli->query($sql);
        }
    }
    else {
        //return false;
    }

    $mysqli->close();

    if($id != ""){
        $mysqli = entrarDb("chave");
        $sql = "UPDATE `chave`.`chaves` SET `chave` = '".$chave."' WHERE (`priv_id` = '".$id."';";
        $mysqli->query($q);
        $mysqli->close();
    }
}

	function returnJson($resultado){
		$tamanho = $resultado->num_rows;
		$tx = "[";
		$i = 1;
		while ($row = $resultado->fetch_assoc()){
			if($tamanho != $i && json_encode($row)){
				$tx .= json_encode($row);
				$tx .= ",";
			}
			else if(json_encode($row)){	
				$tx .= json_encode($row);
			}
			++$i;
		}
		$tx .= "]";

        if($tx[strlen($tx) - 2] == ","){
            $tx[strlen($tx) - 2] = " ";
		}
		echo $tx;	
	}

?>
