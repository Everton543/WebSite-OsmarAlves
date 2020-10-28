<!DOCTYPE html>
<html>
<head>
    <title>Osmar Studio</title>
    <meta name="author" content="Everton Alves" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="http://lvh.me/src/mainStyle.css" rel="stylesheet" type="text/css" />
    <link href="controleStyle.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <script src="controleScript.js"></script>
    <script src="http://lvh.me/src/js/menuScript.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://lvh.me/src/js/mudaHTMLScript.js"></script>

    <div id="background">
        <header>
            <a href="http://lvh.me/src/main.html">
                <img src="http://lvh.me/src/imagens/logo.jpg" alt="logo da empresa" class="logo" />
            </a>
        </header>
    </div>

    <div class="menu">
        <div class="header">
            <div onclick="abrirMenu()" class="clicavel" id="botaoMenu">
                Menu
            </div>

            <div class="caixaPesquisar">
                <form>
                    <input type="text" id="barraPesquisa" name="pesquisa"
                           placeholder="Pesquisar..." />
                    <button type="button">
                        <i class="fa fa-search"> </i>
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div id="menu" class="fechado">
        <ul class='listaMenu'>
            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/agendar/agendar.html" class='listaMenu'>
                    Agendamento
                </a>
            </li>

            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/portfolio/portfolio.html" class='listaMenu'>
                    Portfólio
                </a>
            </li>

            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/servicos/servicos.html" class='listaMenu'>
                    Serviços
                </a>
            </li>

            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/produtos/produtos.html" class='listaMenu'>
                    Produtos
                </a>
            </li>

            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/contato/contato.html" class='listaMenu'>
                    Contato
                </a>
            </li>

            <li class='listaMenu clicavel'>
                <a href="http://lvh.me/src/sobreNos/sobreNos.html" class='listaMenu'>
                    Sobre nós
                </a>
            </li>
        </ul>
    </div>

    <div id="margin" />
    <div> </div>

    <h1>Atualizar Foto Gastronomia</h1>

    <?php
	    if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $texto = '  
                <table id="fotosMenu">
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image1.jpg"
                            id="1"
                            onclick="check(\'../imagens/gastronomia/image1.jpg \', 1)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image2.jpg" 
                            id="2"
                            onclick="check(\'../imagens/gastronomia/image2.jpg \', 2)"/>
                        </th>

                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image3.jpg"
                            id="3"
                            onclick="check(\'../imagens/gastronomia/image3.jpg \', 3)"/>
                        </th>
                    </tr>
        
                    <tr>
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image4.jpg" 
                            id="4"
                            onclick="check(\'../imagens/gastronomia/image4.jpg \', 4)"/>
                        </th>
            
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image5.jpg" 
                            id="5"
                            onclick="check(\'../imagens/gastronomia/image5.jpg \', 5)"/>
                        </th>
                
                        <th class="escolherFoto">
                            <img class="escolher clicavel" src="../imagens/gastronomia/image6.jpg" 
                            id="6"
                            onclick="check(\'../imagens/gastronomia/image6.jpg \', 6)"/>
                        </th>
                    </tr>
                </table>
                <i class="fa fa-arrow-left clicavel"
                onclick="anterior(\'../imagens/gastronomia/image\', 12)"></i>

                <i class="fa fa-arrow-right clicavel"
                onclick="proximo(\'../imagens/gastronomia/image\', 12)"></i>
    
                <form enctype="multipart/form-data" action="?" method="POST" class="formMudarFoto">
                    <input type="checkbox" id="fotoSelectionada" name="fotoSelectionada"
                        value=""/>
                    <input type="file" name="file" />
                    <button type="submit" name="submit"> SUBMIT </button>
                </form>
            ';
            echo $texto;

            if(isset($_POST["submit"]) && isset($_POST['fotoSelectionada'])) {
                $foto = $_POST['fotoSelectionada'];

                if($foto != ""){
                    $file = $_FILES['file'];
                    $fileName = $file['name'];
                    $fileType = $file['type'];
                    $fileSize = $file['size'];
                    $fileTemporaryLocation = $file['tmp_name'];
    
                    $storeDirectory = "../imagens/".$fileName;

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
                $erro = "Foto a ser substituida não selecionada";
                echo $erro;
		    }
        }
    ?>
</body>
</html>