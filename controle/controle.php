
<!DOCTYPE html>
<html>
<head>
    <title>Osmar Studio</title>
    <meta name="author" content="Everton Alves" />
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="http://lvh.me/src/mainStyle.css" rel="stylesheet" type="text/css" />
    <link href="controleStyle.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<!--
    TO-DO:
      final- When the user click on confirm in the button checar, 
             it will send an email to the owner of the web page with a 
             button, where pressing it the user will be succesfully loged in;
-->

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

    <?php 
        function logTx(){
            $texto = '    <form id="acessar" method="POST" action="#">
                <h3>Acessar</h3>
                <ul>
                    <li>
                        <label for="usuario">Usuário</label>
                        <input type="text" id="usuario"
                            name="id" />
                    </li>
    
                    <li>
                        <label for="senha">Senha</label>
                        <input type="password" id="senha"
                            name="senha" />
                    </li>

                    <li id="bLog">
                        <button type="submit">
                            CONFIRMAR
                        </button>
                    </li>

                    <li>
                        <button type="button" onclick="mostrarCodigo()">
                            ESQUECI A SENHA
                        </button>
                    </li>
                </ul> </form>
                    
                <form id="codigo" class="fechado">
                    <ul>
                        <li>
                            <label for="email">Email: </label>
                            <input type="text" id="email" />
                        </li>

                        <li>
                            <button type="button" onclick="checarEmail()">
                                CONFIRMAR
                            </button>
                        </li>

                        <li id="msgErro" class="fechado">
                        </li>
                    </uL>
                </form>
                    
                <form id="checarCodigo"  class="fechado">
                    <uL>
                        <li>
                            Digite o Código enviado ao seu email:
                        </li>
                        <li>
                            <label for="senhaCod">
                                Codigo: 
                            </label>
                            <input type="number" id="senhaCod" />
                        </li>

                        <li>
                            <button type="button" onclick="checarCodigo()">
                                CONFIRMAR
                            </button>
                        </li>
                    </ul>
                </form>
                
                <form id="cadastrarSenha" class="fechado">
                    <uL>
                        <li>
                            <label for="novaSenha">
                                Nova Senha:
                            </label>
                            <input type="password" id="novaSenha" />
                        </li>

                        <li>
                            <label for="repSenha">
                                Repita a senha:
                            </label>
                            <input type="password" id="repSenha" />
                        </li>

                        <li>
                            <button type="button" onclick="mudarSenha()">
                                CONFIRMAR
                            </button>
                        </li>
                    </uL>
                </form>';
            echo $texto;

		}

        include '../login.php';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $logId = $_POST['id'];
            $logSenha = $_POST['senha'];
            $log = login($logId, $logSenha);
            if($log){
                $texto = '
                <div id="formulario" class="">
                    <form>

                        <ul>
                            <li>
                                <button type="button" onclick="aparecer(\'cadastrar\')">Mudar cadastro</button>
                            </li>

                            <li>
                                <button type="button" onclick="aparecer(\'controleSobreNos\')">
                                    MUDAR PÁGINA SOBRE NÓS
                                </button>
                            </li>
                            
                            <li>
                                <button type="button" onclick="aparecer(\'controleContato\')">
                                    MUDAR PÁgina CONTATO
                                </button>
                            </li>


                            <li>
                                <button type="button" onclick="aparecer(\'controleProdutos\')">
                                    MUDAR PÁGINA PRODUTOS
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="aparecer(\'controleServicos\')">
                                    MUDAR PÁGINA SERVIÇOS
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="aparecer(\'mudarFotos\')">
                                    MUDAR FOTOS
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="aparecer(\'atividade\')">
                                    MUDAR ATIVIDADE
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="verAtividades()">
                                    VER ATIVIDADES
                                </button>
                            </li>
                        </ul>
                    </form>

                    <form id="cadastrar" class="fechado">
                        <uL>
                            <li>
                                <label for="novaSenha">
                                    Nova Senha:
                                </label>
                                <input type="text" id="novaSenha" />
                            </li>
                        </uL>
                    </form>
                    
                    <div id="verAtividades" class="fechado">

                    </div>

                    <form id="controleSobreNos" class="fechado" action="http://lvh.me/src/sobreNos/sobreNos.php" method="post">
                        <ul>
                            <li>
                                <label for="sobreNos">
                                    Escreva sobre sua empresa.
                                </label>
                            </li>
    
                            <li>
                                <textarea id="sobreNos" cols="50" rows="10" name="textoSN"> </textarea>
                            </li>
            
                            <li>
                                <button type="submit"> Enviar texto </button>
                            </li>

                            <li>
                                <a href="http://lvh.me/src/sobreNos/sobreNos.html">Página sobre nos</a>
                            </li>
                        </ul>
                    </form>

                    <form id="controleContato"  class="fechado" action="http://lvh.me/src/contato/contatos.php" method="post">
                        <button type="submit" name="mudarContato">MUDAR CONTATO </button>
                    </form>
                    
                    <form id="controleProdutos" class="fechado" action="http://lvh.me/src/sobreNos/sobreNos.php" method="post">
                        <ul>
                            <li>
                                <label for="textoProdutos">
                                    Escreva sobre seus produtos e o link do site de vendas.
                                </label>
                            </li>
    
                            <li>
                                <textarea id="textoProdutos" cols="50" rows="10" name="textoSN"> </textarea>
                            </li>
            
                            <li>
                                <button type="submit"> Enviar texto </button>
                            </li>

                            <li>
                                <a href="http://lvh.me/src/produtos/produtos.html">Página produtos</a>
                            </li>
                        </ul>
                    </form>

                    <form id="controleServicos" class="fechado" action="http://lvh.me/src/servicos/servicos.php" method="post">
                        <ul>
                            <li>
                                <label for="servico">
                                    Escreva seus serviços prestados.
                                </label>
                            </li>
    
                            <li>
                                <textarea id="servico" cols="50" rows="10" name="textoServico"> </textarea>
                            </li>
            
                            <li>
                                <button type="submit"> Enviar texto </button>
                            </li>

                            <li>
                                <a href="http://lvh.me/src/servicos/servicos.html">Página serviços</a>
                            </li>
                        </ul>
                    </form>
    
                    <div id="mudarFotos" class="fechado">
                        <form action="atualizarSlide.php" method="POST">
                            <button type="submit"> FOTOS SLIDER </button>
                        </form>

                        <form action="../contato/contatos.php" method="POST">
                            <select name="mudaFoto" class="fechado">
                                <option value="1">Muda</option>
                            </select>
                            <button type="submit"> FOTOS CONTATO ICONE </button>
                        </form>
                        
                        <form action="atualizarFotoAlbuns.php" method="POST">
                            <button type="submit"> FOTOS ALBUNS </button>
                        </form>

                        <form action="atualizarFotoAniversario.php" method="POST">
                            <button type="submit"> FOTOS ANIVERSÁRIO </button>
                        </form>
                        
                        <form action="atualizarFotoBatizados.php" method="POST">
                            <button type="submit"> FOTOS BATIZADOS </button>
                        </form>
                                                
                        <form action="atualizarFotoBook.php" method="POST">
                            <button type="submit"> FOTOS BOOK </button>
                        </form>

                        <form action="atualizarFotoBebeMeninas.php" method="POST">
                            <button type="submit"> FOTOS BEBE MENINAS </button>
                        </form>          

                        <form action="atualizarFotoBebeMeninos.php" method="POST">
                            <button type="submit"> FOTOS BEBE MENINOS </button>
                        </form>
                                                
                        <form action="atualizarFotoCasal.php" method="POST">
                            <button type="submit"> FOTOS CASAL </button>
                        </form>
                                                                        
                        <form action="atualizarFotoCasamento.php" method="POST">
                            <button type="submit"> FOTOS CASAMENTO </button>
                        </form>
                                                                        
                        <form action="atualizarFotoFamilia.php" method="POST">
                            <button type="submit"> FOTOS FAMÍLIA </button>
                        </form>                      
                        
                        <form action="atualizarFotoFeriado.php" method="POST">
                            <button type="submit"> FOTOS FERIADO </button>
                        </form>
                                                                        
                        <form action="atualizarFotoFormatura.php" method="POST">
                            <button type="submit"> FOTOS FORMATURA </button>
                        </form>
                                                                        
                        <form action="atualizarFotoGastronomia.php" method="POST">
                            <button type="submit"> FOTOS GASTRONOMIA </button>
                        </form>
                                                                        
                        <form action="atualizarFotoGestante.php" method="POST">
                            <button type="submit"> FOTOS GESTANTE </button>
                        </form>
                                                                        
                        <form action="atualizarFotoNewborn.php" method="POST">
                            <button type="submit"> FOTOS NEWBORN </button>
                        </form>
                                                                        
                        <form action="atualizarFotoPrewedding.php" method="POST">
                            <button type="submit"> FOTOS PRÉ-WEDDING </button>
                        </form>
                                                                        
                        <form action="atualizarFotoRestauracao.php" method="POST">
                            <button type="submit"> FOTOS RESTAURAÇÃO </button>
                        </form>
                                                                        
                        <form action="atualizarFotoSensuais.php" method="POST">
                            <button type="submit"> FOTOS SENSUAIS </button>
                        </form>
                                                                        
                        <form action="atualizarFotoShows.php" method="POST">
                            <button type="submit"> FOTOS SHOWS </button>
                        </form>
                                                                        
                        <form action="atualizarFotoSmashCake.php" method="POST">
                            <button type="submit"> FOTOS SMASH THE CAKE </button>
                        </form>
                                                                        
                        <form action="atualizarFotoTrashDress.php" method="POST">
                            <button type="submit"> FOTOS TRASH THE DRESS </button>
                        </form>


                    </div>

                    <form id="atividade" action="addAtividade.php" class="fechado" method="post">
                        <ul>
                            <li>
                                <label for="semanaEscolhida">
                                    Escolha o dia da semana
                                </label>
                                <select id="semanaEscolhida" name="diaSemana">
                                    <option value="0">Domingo</option>
                                    <option value="1">Segunda</option>
                                    <option value="2">Terça</option>
                                    <option value="3">Quarta</option>
                                    <option value="4">Quinta</option>
                                    <option value="5">Sexta</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </li>
            
                            <li>
                                <button type="button" onclick="aparecer(\'adicionar\')">
                                    ADICIONAR ATIVIDADE
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="removerAtividade()">
                                    REMOVER ATIVIDADE
                                </button>
                            </li>

                            <li>
                                <button type="button" onclick="mostrarMudarAtividade()">
                                    ALTERAR ATIVIDADE
                                </button>
                            </li>

                        </ul>

                        <ul id="adicionar" class="fechado">
                            <li>
                                <label for="addAtividade">Adicionar atividade:</label>
                                <input type="text" id="addAtividade" name="addAtividade"  />
                            </li>

                            <li>
                                <label for="pesoHora">Adicionar quantas horas dura a atividade, 
                                        coloque 0 para atividades que duram menos de 1 hora </label>
                                <input type="number" id="pesoHora" name="pesoHora"/>
                            </li>

                            <li>
                                <label for="pesoMinuto">Adicionar quantos minutos dura a atividade, 
                                        coloque 0 para atividades que tenham minutos zerados </label>
                                <input type="number" id="pesoMinuto" name="pesoMinuto"/>
                            </li>

                            <li>
                                <button type="button" onclick="colocarAtividade()">
                                    ADICIONAR
                                </button>
                            </li>
                        </ul>
            
                        <ul id="tirar" class="fechado">
                        
                            <li id="tirarAtividade">
                                <label for="atividadesExistente">
                                    Atividades existentes:
                                </label>
                                <select id="atividadesExistente">
            
                                </select>
                            </li>

                                <li>
                                <button type="button" onclick="tirarAtividade()">
                                    REMOVER
                                </button>
                            </li>
                        </ul>

                        <ul id="muda" class="fechado">
                            <li>Caso não queira mudar um dos campos deixe em branco</li>
                            <li>No caso do dia da semana deixe na opção "Escolha um novo dia"</li>
                            <li>
                                <label for="novoDia">
                                    Escolha o dia da semana
                                </label>
                                <select id="novoDia">
                                    <option value= "">Escolha um novo dia</option>
                                    <option value="0">Domingo</option>
                                    <option value="1">Segunda</option>
                                    <option value="2">Terça</option>
                                    <option value="3">Quarta</option>
                                    <option value="4">Quinta</option>
                                    <option value="5">Sexta</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </li>

                            <li id="mudaAtividade">
                                <label for="atividadesExistenteM">
                                    Atividades existentes:
                                </label>
                                <select id="atividadesExistenteM">
            
                                </select>
                            </li>

                            <li>
                                <label for="novaAtividade">Alterar atividade:</label>
                                <input type="text" id="novaAtividade"/>
                            </li>

                            <li>
                                <label for="mudaHora">Alterar quantas horas dura a atividade</label>
                                <input type="number" id="mudaHora"/>
                            </li>

                            <li>
                                <label for="mudaMinuto">Alterar quantos minutos dura a atividade </label>
                                <input type="number" id="mudaMinuto" name="pesoMinuto"/>
                            </li>

                            <li>
                                <button type="button" onclick="mudarAtividade()">
                                    ALTERAR ATIVIDADE
                                </button>
                            </li>
                        </ul>
                    </form>
                </div>
                ';

            echo $texto;
    	    }
            else {
                logTx();
            }
        }

        else{
            logTx();
	    }
?>


</body>
</html>
