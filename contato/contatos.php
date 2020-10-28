<head>
    <title>Osmar Studio</title>
    <meta name="author" content="Everton Alves" />
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="http://lvh.me/src/mainStyle.css" rel="stylesheet" type="text/css" />
    <link href="../controle/controleStyle.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <script src="../controle/controleScript.js"></script>
<?php

    function mudarInfoTexto(){
                 $texto = '  
                <table id="fotosMenu">
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image1.jpg"
                            id="1"
                            onclick="check(1, 1)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image2.jpg" 
                            id="2"
                            onclick="check(2, 2)"/>
                        </th>
                    </tr>
        
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image3.jpg"
                            id="3"
                            onclick="check(3, 3)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image4.jpg" 
                            id="4"
                            onclick="check(4, 4)"/>
                        </th>           
                    </tr>
                </table>
    
                <form action="?" method="POST" class="formMudarFoto">
                    <p>Escreva no campo que deseja mudar e click
                        na foto do contato que queira mudar.</p>

                    <ul>
                    <li>
                        <label for="texto">Nome do tipo de contato</label/>
                        <input type="text" name="texto" id="texto"/>
                    </li>
                    <li>
                        <label for="link">Link do contato</label/>
                        <input type="text" name="link" id="link"/>
                    </li>
                    <li>
                        <input type="checkbox" id="fotoSelecionada" name="fotoSelecionada"
                            value=""/>
                        <button type="submit" name="mudarInfo"> SUBMIT </button>
                    </li>
                    </ul>
                </form>
            ';
            echo $texto;
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		include '../login.php';
        
		if(isset($_POST['mudaFoto'])) {
            $texto = '  
                <table id="fotosMenu">
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image1.jpg"
                            id="1"
                            onclick="check(\'../imagens/icones/image1.jpg\', 1)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image2.jpg" 
                            id="2"
                            onclick="check(\'../imagens/icones/image2.jpg\', 2)"/>
                        </th>
                    </tr>
        
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image3.jpg"
                            id="3"
                            onclick="check(\'../imagens/icones/image3.jpg\', 3)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/icones/image4.jpg" 
                            id="4"
                            onclick="check(\'../imagens/icones/image4.jpg\', 4)"/>
                        </th>           
                    </tr>
                </table>
    
                <form enctype="multipart/form-data" action="?" method="POST" class="formMudarFoto">
                    <input type="checkbox" id="fotoSelecionada" name="fotoSelecionada"
                        value=""/>
                    <input type="file" name="file" />
                    <button type="submit" name="submit"> SUBMIT </button>
                </form>
            ';
            echo $texto;
		}
		else if(isset($_POST['mudarContato'])){
            mudarInfoTexto();
        }
		else if(isset($_POST['mudarInfo'])){
        echo "Mudar Info:: ";
            if(isset($_POST['texto'])){
			    $texto = $_POST['texto'];
            }else{
                echo "Texto vazio";
			}

            $id = "";
            $erro = false;

            if(isset($_POST['fotoSelecionada'])){
                $id = $_POST['fotoSelecionada'];
            }else{
                $erro = true;
                mudarInfoTexto();
                echo "Selcione uma foto.";
			}


            if(isset($_POST['link'])){
                $link = $_POST['link'];
            }else{
                echo "Link vazio";     
			}

			$mysqli = entrarDb("cadastro");
            $sql = "";
            if (!$erro){
                if(isset($_POST['link']) && $link != ""){
    			    $sql = "UPDATE `contatos` SET
                        `link` = '".
                        $link."' WHERE (`id` = '".
                        $id."');";
                    echo $sql;
			        $mysqli->query($sql);
                    mudarInfoTexto();
                    echo "Link mudado.";
                }
                else if(isset($_POST['texto']) && $texto != ""){
                    
    			    $sql = "UPDATE `contatos` SET `texto` = '".
                        $texto."' WHERE (`id` = '".
                        $id."');";       
                    echo $sql;
			        $mysqli->query($sql);
                    mudarInfoTexto();
                    echo "Nome mudado.";
			    }

            }
			$mysqli->close();
		}

        else if( isset($_POST["submit"]) && isset($_POST['fotoSelecionada'])) {
            $foto = $_POST['fotoSelecionada'];
            if($foto != ""){
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileType = $file['type'];
                $fileSize = $file['size'];
                $fileTemporaryLocation = $file['tmp_name'];
                $directory = "../imagens/icones/";
                $storeDirectory = $directory.$fileName;
                $newName = $foto;


                if (move_uploaded_file($fileTemporaryLocation, $storeDirectory)){
                    sleep(2);
                    if(rename($storeDirectory, $newName)){
                        echo "Foto atualizada";          
		                }else{
                            echo "ERRO: feche a pasta que a foto está localizada.";
           	                }
                        }
                    }
                }
            }
            else{
                $erro = "Foto a ser substituida não selecionada";
                echo $erro;
            }
        }

		else{
			$mysqli = entrarDb("cadastro");
			$sql = "SELECT * FROM contatos;";
			$resposta = $mysqli->query($sql);
			returnJson($resposta);
			$mysqli->close();
		}
	}
?>
</body>
</html>