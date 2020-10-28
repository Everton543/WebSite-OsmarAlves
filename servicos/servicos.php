
<?php
	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		include '../login.php';

		if(isset($_POST['textoServico'])){
			$texto = $_POST['textoServico'];
			$mysqli = entrarDb("cadastro");

			$texto = str_replace("\r", "<br>", $texto);
			$texto = str_replace("\n", "<br>", $texto);

			$sql = "UPDATE `textoservicos` SET `texto` = '"
				.$texto. "' WHERE (`id` = '1');";
			$mysqli->query($sql);
			$mysqli->close();
		}

		else{
			$mysqli = entrarDb("cadastro");
			$sql = "SELECT texto FROM textoservicos ;";
			$resultado = $mysqli->query($sql);
			if ($resultado->num_rows > 0){
				$tx = $resultado->fetch_assoc();
				$texto =  $tx["texto"];
				$texto = mb_convert_encoding($texto, "UTF8");
				echo ' {"texto" : "'.$texto.'"}';
			}
		
			$mysqli->close();

		}
	}
?>