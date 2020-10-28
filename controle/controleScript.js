/********************************
 * TO-DO:
 *  0- salvar em duas variaveis o id
 *  e a senha usada para entrar no site
 *  para depois serem usados para
 *  desmarcar agendamento de clientes
 *  de acordo com cancelarAgenda.php
 *  
 *  1- Criar uma formar de Osmar Alves poder
 *  ver todos os clientes agendados como também
 *  desmarcar o agendamento deles.
 **/

var erroLog = false;
var logChance = 0;
const tentativaMax = 3;
const tamanhoMinSenha = 8;
var idCliente = "";
var mostrar = 6;
var prox= false; //proximo
var ant = false; //anterior
var maximo = 0;
var lastCheck = 0;

function proximo(src, max) {
    prox = true;
    maximo = max;
    var antes = mostrar;
    mostrar += 6;
    if (mostrar > maximo) {
        antes = 0;
        mostrar = 6;
    }

    if (ant == true) {
        ant = false;
        proximo(src, maximo);
        return;
    }
    proximaFoto(antes, mostrar, src);
}

function anterior(src, max) {
    maximo = max;
    ant = true;
    var depois = mostrar;
    mostrar -= 6;
    if (mostrar < 0) {
        depois = maximo;
        mostrar = maximo - 6;
    }

    if (prox == true) {
        prox = false;
        anterior(src, maximo);
        return;
    }
    proximaFoto(mostrar, depois, src);
}

function proximaFoto(antes, depois, src) {
    var id = "z";
    var count = 1;
    var source = src;
    var check = "check('zy', kw)";
    ++antes;
    for (antes; antes <= depois; antes++) {
        check = "check('zy', kw)";
        id = "z";
        source = src;
        source += antes + ".jpg";
        id = id.replace("z", count);
        check = check.replace('zy', source);
        check = check.replace('kw', id);
        count += 1;
        console.log(check);
        document.getElementById(id).src = source;
        document.getElementById(id).removeAttribute("onclick");
        document.getElementById(id).setAttribute("onclick", check);
        normal(id);
    }
}

function mostrarCodigo() {
    esconder("acessar");
    aparecer("codigo");
}

function checarEmail() {
    var email = document.getElementById("email").value;

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/controle/mudarSenha.php',
            data: {
                email: email,
                salva: ""
            },
            success: function (data) {

                //quando conseguir enviar o código por email
                //tirar o codigo do json;
                var resultado = JSON.parse(data);
                console.log(resultado);

                
                if (resultado.certo != null) {
                    esconder("codigo");
                    aparecer("checarCodigo");
                    idCliente = resultado.id;
                }
                else {
                    document.getElementById("msgErro").innerHTML = 
                        resultado.erro;
                    errado("email");
                    aparecer("msgErro");
                }
            }
        });
    });
}

function checarCodigo() {
    var email = document.getElementById("email").value;
    var codigo = document.getElementById("senhaCod").value;

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/controle/mudarSenha.php',
            data: {
                email: email,
                codigo: codigo,
                id: idCliente
            },
            success: function (data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.resultado == true) {
                    console.log("Acertou dinoviu mizeraviu");
                    aparecer('cadastrarSenha');
                } else {
                    console.log("NUM DEU");
                }
            }
        });
    });
}

/*function certo(id) {
    document.getElementById(id).classList.remove("errado");
}

function errado(id) {
    document.getElementById(id).classList.add("errado");
}*/

//atualizar
function cadastrar() {
    
}

function verAtividades() {
    var diaSemana = ["Domingo",
        "Segunda",
        "Terça",
        "Quarta",
        "Quinta",
        "Sexta",
        "Sábado"];

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/controle/mostrarAtividades.php',
            data: {
                nada: "nada"
            },
            success: function (data) {
                var text = "<table class='tabelaAtividades'> <tr> <th class='tabelaTopo'>";
                text += "Dia da semana</th>";
                text += "<th class='tabelaTopo'>Atividade</th>";
                text += "<th class='tabelaTopo'>Hora gasta</th>";
                text += "<th class='tabelaTopo'>Minuto gasto</th> <tr>";

                var info = JSON.parse(data);
                for (var i = 0; i < info.length; i++) {
                    text += "<tr>";
                    text += "<th class='atividades'>" + diaSemana[info[i]["dia_semana"]]+ "</th>"; 
                    text += "<th class='atividades'>" + info[i]["tipo"] + "</th>";
                    text += "<th class='atividades'>" + info[i]["horaGasta"] + "</th>";
                    text += "<th class='atividades'>" + info[i]["minutoGasto"] + "</th>";
                    text += "</tr>";
                }

                document.getElementById("verAtividades").innerHTML = text;
                aparecer("verAtividades");
            }
        });
    });
}


function colocarAtividade() {
    var selecionado = document.getElementById("semanaEscolhida");
    var diaSemana = selecionado.options[selecionado.selectedIndex].value;
    var atividade = document.getElementById("addAtividade").value;
    var pesoHora = document.getElementById("pesoHora").value;
    var pesoMinuto = document.getElementById("pesoMinuto").value;

    if (pesoMinuto == null) {
        pesoMinuto = 0;
    }

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/controle/addAtividade.php',
            data: {
                diaSemana: diaSemana,
                atividade: atividade,
                pesoHora: pesoHora,
                pesoMinuto: pesoMinuto
            },
            success: function () {
                window.alert("Atividade adicionada com sucesso.")
            }
        });
    });
}

function selecionado(id) {
    var selecionado = document.getElementById(id);
    selecionado.classList.add('escolhido');
}

function normal(id) {
    var selecionado = document.getElementById(id);
    selecionado.classList.remove('escolhido');
    var check = document.getElementById('fotoSelecionada');
    check.checked = false;
    check.value = "";
}

function check(value, id) {
    var check = document.getElementById('fotoSelecionada');
    if (lastCheck != 0) {
        normal(lastCheck);
    }
    check.value = value;
    lastCheck = id;
    selecionado(id);
    check.checked = true;
}


function removerAtividade() {
    var selecionado = document.getElementById("semanaEscolhida");
    var diaSemana = selecionado.options[selecionado.selectedIndex].value;
    var escolhas = "";
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/atividadesDia.php',
            data: {
                diaSemana: diaSemana,
            },
            success: function (data) {
                var atividades = JSON.parse(data);
                for (var i = 0; i < atividades.length; i++) {
                    escolhas += "<option value='";
                    escolhas += atividades[i]["servico_id"];
                    escolhas += "'>" + atividades[i]["tipo"] + "</option > ";
                }
                document.getElementById("atividadesExistente").innerHTML = escolhas;
            }
        });
    });

    aparecer('tirar');
}

function tirarAtividade() {
    var selecionado = document.getElementById("atividadesExistente");
    var atividadeId = selecionado.options[selecionado.selectedIndex].value;

    var diaSelecionado = document.getElementById("semanaEscolhida");
    var diaSemana = diaSelecionado.options[diaSelecionado.selectedIndex].text;
    var atividadeSelecionada = selecionado.options[selecionado.selectedIndex].text;

    var mensagem = "Deletar atividade: " + atividadeSelecionada;
    mensagem += " dos dias de " + diaSemana;
    var deleta = confirm(mensagem);

    if (deleta) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: 'http://lvh.me/src/controle/tirarAtividade.php',
                data: {
                    atividadeId: atividadeId,
                },
                success: function () {
                    window.alert("Atividade Deletada.");
                }
            });
        });
    }
}

function mostrarMudarAtividade() {
    var selecionado = document.getElementById("semanaEscolhida");
    var diaSemana = selecionado.options[selecionado.selectedIndex].value;
    var escolhas = "";
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/atividadesDia.php',
            data: {
                diaSemana: diaSemana,
            },
            success: function (data) {
                var atividades = JSON.parse(data);
                for (var i = 0; i < atividades.length; i++) {
                    escolhas += "<option value='";
                    escolhas += atividades[i]["servico_id"];
                    escolhas += "'>" + atividades[i]["tipo"] + "</option > ";
                }
                document.getElementById("atividadesExistenteM").innerHTML = escolhas;
            }
        });
    });

    aparecer('muda');
}

function mudarSenha() {
    var email = document.getElementById("email").value;
    var novaSenha = document.getElementById("novaSenha").value;
    var repSenha = document.getElementById("repSenha").value;

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/controle/mudarSenha.php',
            data: {
                email: email,
                senha: novaSenha,
                repSenha: repSenha,
                id: idCliente
            },
            success: function (data) {
                //var resultado = JSON.parse(data);
                //console.log(resultado);
                console.log(data);
            }
        });
    });
    
}

function mudarAtividade() {
    var selecionado = document.getElementById("atividadesExistenteM");
    var atividadeId = selecionado.options[selecionado.selectedIndex].value;

    var diaSelecionado = document.getElementById("semanaEscolhida");
    var diaSemana = diaSelecionado.options[diaSelecionado.selectedIndex].text;
    var atividadeSelecionada = selecionado.options[selecionado.selectedIndex].text;

    var novoDiaSelecionado = document.getElementById("novoDia");
    var novoDia = novoDiaSelecionado.options[novoDiaSelecionado.selectedIndex].value;


    var atividade = document.getElementById("novaAtividade").value;
    var pesoHora = document.getElementById("mudaHora").value;
    var pesoMinuto = document.getElementById("mudaMinuto").value;

    var mensagem = "Mudar atividade: " + atividadeSelecionada;
    mensagem += " dos dias de " + diaSemana;
    var muda = confirm(mensagem);

    var test = "novoDia: " + novoDia + " Id: " + atividadeId + " novoTipo: " + atividade
        + " novaHora: " + pesoHora + " novoMinuto: " + pesoMinuto;
    console.log(test);
    if (muda) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: 'http://lvh.me/src/controle/mudarAtividade.php',
                data: {
                    atividadeId: atividadeId,
                    atividade: atividade,
                    pesoHora: pesoHora,
                    pesoMinuto: pesoMinuto,
                    diaSemana: novoDia
                },
                success: function (data) {
                    //window.alert("Atividade Deletada.");
                    console.log(data);
                }
            });
        });
    }
}