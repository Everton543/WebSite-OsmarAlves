class HistoricoMes {
    constructor(mes, primeiroDiaSemana, primeiroMes) {
        this.mes = mes;
        this.primeiroDiaSemana = primeiroDiaSemana;
        this.primeiroMes = primeiroMes;
    }

    ePrimeiro() {
        return this.primeiroMes;
    }

    primeiraSemana() {
        return this.primeiroDiaSemana;
    }
}

var diaOcupado = {};

var agMes = {
    "1": [],
    "2": [],
    "3": [],
    "4": [],
    "5": [],
    "6": [],
    "7": [],
    "8": [],
    "9": [],
    "10": [],
    "11": [],
    "12": []
    };
/********************************************************
 * FUNCTION: tamanhoTelefone
 * DESCRIPTION: Checa se o tamanho do telefone é grande o
 * suficiente.
 ********************************************************/
function tamanhoTelefone(tamanho, id, proximoId) {
    var texto = document.getElementById(id).value;
    if (texto.length > tamanho) {
        errado(id);
    }
    if (texto.length == tamanho) {
        certo(id);
        document.getElementById(proximoId).focus();
    }
}

/********************************************************
 * FUNCTION: diasOcupado
 * DESCRIPTION: encontrar todos os dias lotados do mês.
 ********************************************************/
function diasOcupado() {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/diasOcupado.php',
            data: {
                ano: ano,
                mes: mes,
                consultar: ""
            },
            success: function (data) {
                try {
                    var info = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }

                for (var i = 0; i < info.length; i++) {
                    var dia = info[i].dia;
                    diaOcupado[dia] = info[i].cheio;
                }
                criarCalendario();

            }
        });
    });

}

/********************************************************
 * FUNCTION: horariosAgendados
 * DESCRIPTION: Salvar todos os horarios agendados na
 * variavel agMes.
 ********************************************************/
function horariosAgendados() {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/agendado.php',
            data: {
                ano: ano,
                mes: mes,
                horas: ""
            },
            success: function (data) { 
                try {
                    var info = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }
                diaOcupado = {};
                for (var i = 0; i < info.length; i++) {
                
                    var mes = info[i].mes;
                    agMes[mes].push(info[i]);
                }
                diasOcupado();
            }
        });
    });
}

var meses = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
     "Novembro",
     "Dezembro"
]

var servicos = [];

var nomeSemana = [
    "Domingo",
    "Segunda",
    "Terça",
    "Quarta",
    "Quinta",
    "Sexta",
    "Sábado"
]

var diasMaxMes = [
    31,
    28,
    31,
    30,
    31,
    30,
    31,
    31,
    30,
    31,
    30,
    31
];

var horaTempoLivreMax = {};

var horaIntervalo = {inicio : "1100", fim: 1300};

var horaEscolhida = 0;
var diaEscolhido = 0;
var semanaEscolhida = 0;
var data = new Date();
var dia = data.getDate();
var diaSemana = data.getDay() + 1; //0 = domingo por isso a soma
var mes = data.getMonth(); //0 = janeiro
var ano = data.getFullYear();
var primeiroDiaSemanaMes = diaSemana;
var historico = [];
var diaAtual = [diaSemana, dia];


/********************************************************
 * FUNCTION: colocarMes
 * DESCRIPTION: colocar o título do mês, colocando o nome
 * do mês e o número do ano.
 ********************************************************/
function colocarMes() {
    document.getElementById("nomeMes").innerHTML = meses[mes] + " - " + ano;
}


/********************************************************
 * FUNCTION: checarBissexto
 * DESCRIPTION: checa se o ano é bissexto, para saber
 * se fevereiro tem 28 ou 29 dias
 ********************************************************/
function checarBissexto() {
    if (((ano % 4 == 0) && (ano % 100 != 0)) || (ano % 400 == 0)) {
        diasMaxMes[1] = 29;
    }
    else {
        diasMaxMes[1] = 28;
    }
}

/********************************************************
 * FUNCTION: tirarDiasAnterios
 * DESCRIPTION: tira dias anteriores do mes atual
 ********************************************************/
function tirarDiasAnteriores() {
    var id = "19";
    var dias = 1;
    var id2 = historico[0].primeiraSemana();
    var semana = historico[0].primeiraSemana();
    var diaClick = "diaClick(9)"; 
    for (dias; dias <= diaAtual[1]; dias++) {
        id = "19";
        id = id.replace("1", semana)
        id = id.replace("9", id2);
        diaClick = "diaClick(9)";
        diaClick = diaClick.replace("9", dias);
        document.getElementById(id).innerHTML = dias;
        document.getElementById(id).classList.remove("agendaLivre");
        document.getElementById(id).classList.remove("clicavel");
        document.getElementById(id).classList.add("agendaCheia");
        document.getElementById(id).removeAttribute("onclick");

        ++semana;
        ++id2;
        if (semana> 7) {
            semana = 1;
        }
    }
}

/********************************************************
 * FUNCTION: desenharCalendario
 * DESCRIPTION: Colocar as informações do calendário de 
 * acordo com o mês.
 ********************************************************/
function desenharCalendario() {
    var id = "ab";
    var dias = 1;
    var id2 = historico[historico.length - 1].primeiroDiaSemana;
    var diaClick = "diaClick(9, s)";
    var texto = "<a href=#horariosDia> $ </a>";
    primeiroDiaSemanaMes = historico[historico.length - 1].primeiroDiaSemana;
    var ocupado = "d";

    for (dias; dias <= diasMaxMes[mes]; dias++) {
        ocupado = "d";
        id = "ab";
        diaClick = "diaClick(9, s)";
        texto = "<a href=#horariosDia> $ </a>";
        texto = texto.replace("$", dias);
        id = id.replace("a", primeiroDiaSemanaMes)
        id = id.replace("b", id2);
        diaClick = diaClick.replace("9", dias);
        diaClick = diaClick.replace("s", primeiroDiaSemanaMes);

        document.getElementById(id).innerHTML = texto;
        if (primeiroDiaSemanaMes == 1 || primeiroDiaSemanaMes == 7) {
            document.getElementById(id).innerHTML = dias;
            document.getElementById(id).classList.remove("agendaLivre");
            document.getElementById(id).classList.remove("clicavel");
            document.getElementById(id).classList.add("agendaCheia");
            document.getElementById(id).removeAttribute("onclick");
        }
        else {
            document.getElementById(id).classList.add("agendaLivre");
            document.getElementById(id).classList.add("clicavel");
            document.getElementById(id).setAttribute("onclick", diaClick);
        }

        ocupado = ocupado.replace("d", dias);

        if (diaOcupado[ocupado] != null && diaOcupado[ocupado] == 1) {
            document.getElementById(id).innerHTML = dias;
            document.getElementById(id).classList.remove("agendaLivre");
            document.getElementById(id).classList.add("clicavel");
            document.getElementById(id).classList.add("agendaCheia");
            document.getElementById(id).removeAttribute("onclick");
            document.getElementById(id).setAttribute("onclick", "abrirDesmarcar()");    
        } 


        ++primeiroDiaSemanaMes;
        ++id2;
        if (primeiroDiaSemanaMes > 7) {
            primeiroDiaSemanaMes = 1;
        }
    }
}

/********************************************************
 * FUNCTION: abrirDesmarcar
 * DESCRIPTION: Abrir o formulário para desmarcar uma hora
 * agendada.
 ********************************************************/
function abrirDesmarcar() {
    aparecer("desmarcar");
    esconder("calendario");
    esconder("horariosDia");
    esconder("formulario");
}

/********************************************************
 * FUNCTION: desmarcar
 * DESCRIPTION: Desmarcar um agendamento feito.
 ********************************************************/
function desmarcar() {
    var id = document.getElementById("id").value;
    var senha = document.getElementById("senha").value;
    var dia = id[0];

    if (dia == "1" || dia == "2" || dia == "3") {
        dia += id[1];
    }

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/cancelarAgenda.php',
            data: {
                id: id,
                senha: senha
            },
            success: function (data) {
                console.log(data);
                try {
                    var resultado = JSON.parse(data)
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }
                if (resultado.resultado == "true" &&
                    diaOcupado[dia] != null) {
                    abrirDia(dia);
                }
            }
        });
    });
}

/********************************************************
 * FUNCITON: abrirDia
 * DESCRIPTION: Quando alguém desmarca uma atividade de um
 * dia lotado essa função deixa o dia como livre novamente.
 *********************************************************/
function abrirDia(dia) {
    if (diaOcupado[dia] != null) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: 'http://lvh.me/src/agendar/agendado.php',
                data: {
                    dia: dia,
                    mes: mes,
                    ano: ano,
                    cheio: 0
                },
                success: function (data) {
                    console.log(data);
                }
            });
        });
    }
}

/********************************************************
 * FUNCTION: criarCalendario
 * DESCRIPTION: atualizar as informações do calendário
 * e tirando os dias já passados do mês
 *********************************************************/
function criarCalendario() {
    colocarMes();
    checarBissexto();

    while (dia > 1) {
        --dia;
        --diaSemana;
        if (diaSemana <= 0) {
            diaSemana = 7
        }
    }
    primeiroDiaSemanaMes = diaSemana;

    if (historico.length == 0) {
        historico[0] = new HistoricoMes(mes, primeiroDiaSemanaMes, true);

    }
    
    desenharCalendario();

    if (mes == historico[0].mes) {
        tirarDiasAnteriores();
    }
}

/********************************************************
 * FUNCTION: apagarCalendario
 * DESCRIPTION: Colocar todo os dias do calendário como vazio
 *********************************************************/
function apagarCalendario() {
    var apagar = document.getElementsByClassName("dias");
    for (var id = 0; id < apagar.length; id++) {
        apagar[id].innerHTML = " ";
        apagar[id].classList.remove("agendaLivre");
        apagar[id].classList.remove("agendaCheia");
    } 
}

function proximoMes() {
    apagarCalendario();
    ++mes;
    if (mes > 11) {
        mes = 0;
        ++ano;
    }

    historico[historico.length] = new HistoricoMes(mes, primeiroDiaSemanaMes, false);
    horariosAgendados();

}

function voltarMes() {
    if (historico[historico.length - 1].ePrimeiro() != true) {
        historico.pop();
        apagarCalendario();
        --mes;
        if (mes < 0) {
            mes = 11
            --ano;
        }

        primeiroDiaSemanaMes = historico[historico.length - 1].primeiraSemana();

        horariosAgendados();
    }
     
}

/**********************************************************
 * FUNCTION: horaClick
 * DESCRIPTION: Ao cliente clicar em uma hora aparecer as
 * atividades que o cliente pode agendar, como também o
 * formulário de agendamento.
 **********************************************************/
function horaClick(hora) {
    horaEscolhida = hora;
    servicos = [];
    var escolhas = "";
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/agendado.php',
            data: {
                semana: semanaEscolhida -1,
                total: horaTempoLivreMax[hora].tempo
            },
            success: function (data) {
                try {
                    var atividades = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }

                for (var i = 0; i < atividades.length; i++) {
                    escolhas += "<option value='";
                    escolhas += atividades[i]["servico_id"];
                    escolhas += "'>" + atividades[i]["tipo"] + "</option > ";
                }

                document.getElementById("pedido").innerHTML = escolhas;
            }
        });
    });
    aparecer("formulario");
    esconder("horariosDia");
    esconder("calendario");

}

/***********************************************
 * FUNCTION: checaHora
 * DESCRIPTION: Checa todas as horas do dia e tira
 * os horarios marcados juntamente com o tempo 
 * gasto de cada atividade
 **********************************************/
function checaHora(diaEscolhido) {
    var mesId = "d";
    var mesAt = mes + 1;
    mesId = mesId.replace("d", mesAt);
    

    var checaDia = "d";
    var checaDia = checaDia.replace("d", diaEscolhido);

    tirarHoraGasta(horaIntervalo.inicio, horaIntervalo.fim);

    if (agMes[mesId] != null) {
        for (var i = 0; i < agMes[mesId].length; i++) {

            if (agMes[mesId][i].dia == checaDia) {

                var minutoM = 0; //minuto marcado
                var horaM = 0; //hora marcada

                //se for igual a 3 para saber se a hora é
                //menor que 10
                if (agMes[mesId][i].hora.length == 3) {
                    horaM = parseInt(agMes[mesId][i].hora[0]);
                    minutoM = agMes[mesId][i].hora[1] + agMes[mesId][i].hora[2];
                    minutoM = parseInt(minutoM);
                }
                else {
                    horaM = agMes[mesId][i].hora[0] + agMes[mesId][i].hora[1];
                    minutoM = agMes[mesId][i].hora[2] + agMes[mesId][i].hora[3];
                    horaM = parseInt(horaM);
                    minutoM = parseInt(minutoM);
                }
                var horaG = agMes[mesId][i].horaGasta; //hora gasta
                var minutoG = agMes[mesId][i].minutoGasto; // minuto gasto
                horaG = parseInt(horaG);
                minutoG = parseInt(minutoG);

                var horaS = horaM + horaG; //hora somada
                var minutoS = minutoM + minutoG; //minuto somado
                
                if (minutoS > 30) {
                    minutoS = 0;
                    ++horaS;
                }

                var tMinuto = "d"; //texto Minuto
                var tHora = "d"; //texto hora
                if (minutoS == 0) {
                    tMinuto = tMinuto.replace("d", "00");
                }
                else {
                    tMinuto = tMinuto.replace("d", minutoS);
                }

                tHora = tHora.replace("d", horaS);

                var fim = tHora + tMinuto;
                fim = parseInt(fim);
                var inicio = agMes[mesId][i].hora;
                tirarHoraGasta(inicio, fim);
            }
        }
    }
}

/***********************************************
 * FUNCTION: tituloAgenda
 * DESCRIPTION: colocar o título da agenda do dia.
 **********************************************/
function tituloAgenda(dia, semana) {
    diaEscolhido = dia;
    semanaEscolhida = semana;

    var nomeDia = nomeSemana[semana - 1] + " - ";
    nomeDia += "dia - " + meses[mes];
    nomeDia = nomeDia.replace("dia", dia);
    nomeDia = unescape(nomeDia);

    document.getElementById("nomeDia").innerHTML = nomeDia;
}

/***********************************************
 * FUNCTION: tiraHora
 * DESCRIPTION: de acordo com o id enviado coloca
 * a hora como não disponível para marcar.
 **********************************************/
function tiraHora(id) {
    document.getElementById(id).classList.add("horaCheia");
    document.getElementById(id).classList.remove("horaLivre");    
    document.getElementById(id).removeAttribute("onclick", diaClick);
    document.getElementById(id).setAttribute("onclick", "abrirDesmarcar()");    
}

/***********************************************
 * FUNCTION: tirarHoraGasta
 * DESCRIPTION: tirar as horas da agenda do dia
 * que tiver ocupadas.
 **********************************************/
function tirarHoraGasta(inicio, fim) {
    //inicio é string e fim é int

    var hora = 0;
    var minuto = 0;

    if (inicio.length == 3) {
        hora = inicio[0];
        minuto = inicio[1] + inicio[2];
        minuto = parseInt(minuto);
    }
    else {
        hora = inicio[0] + inicio[1];
        minuto = inicio[2] + inicio[3];
        hora = parseInt(hora);
        Minuto = parseInt(minuto);
    }

    if (minuto == "00") {
        minuto = 0;
    }

    var tempo = "hm";

    tempo = tempo.replace("h", hora);
    tempo = tempo.replace("m", minuto);
    tempo = parseInt(tempo);
    var id = "";
    var horaClick = "";
    while (tempo < fim) {

        tempo = "hm";
        tempo = tempo.replace("h", hora);
        if (minuto == 0) {
            tempo = tempo.replace("m", "00");
        } else {
            tempo = tempo.replace("m", minuto);
        }
        tempo = parseInt(tempo);

        id = "d";
        horaClick = "horaClick('d')";
        id = id.replace("d", tempo);

        horaClick = horaClick.replace("d", tempo);
        if (tempo < fim) {
            tiraHora(id);
        } 

        minuto += 30;
        if (minuto > 30) {
            ++hora;
            minuto = 0;
        }
    }
}

/***********************************************
 * FUNCTION: abrirAgenda
 * DESCRIPTION: mostrar os horarios da agenda 
 * resetando todos os horarios como disponível
 **********************************************/
function abrirAgenda() {
    document.getElementById("horariosDia").classList.remove("fechado");
    var hora = 800;
    //var horaId = "d";
    var passaHora = false; //Know when an hour has passed.
    var id = "";
    var horaClick = "";
    while (hora <= 1700) {
        id = "d";
        horaClick = "horaClick('d')";
        id = id.replace("d", hora);
        horaClick = horaClick.replace("d", hora);

        document.getElementById(id).classList.remove("horaCheia");
        document.getElementById(id).classList.add("horaLivre");
        document.getElementById(id).classList.add("clicavel");
        document.getElementById(id).setAttribute("onclick", horaClick);
        
        if (passaHora == false) {
            hora += 30;
            passaHora = true;
        } else {
            hora += 70;
            passaHora = false;
        }
    }
}

/******************************************************
 * function: hasClass
 * Author: I found this function at stackoverflow;
 *      I decided to use it for the sake of working with
 *      all browsers, old or new.
 ******************************************************/
function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}

/***********************************************
 * FUNCTION: tempoLivreMax
 * DESCRIPTION: Pega o tempo livre disponível de cada
 * horario da agenda.
 **********************************************/
function tempoLivreMax(id, hora, minuto) {
    var tx = "";
    var hora = hora;
    var minuto = minuto;

    var idInicial = id;

    var id = id;
    var tempo = parseInt(id);
    var horaM = 0; //hora máxima
    var minutoM = 0; //minuto maximo

    while (tempo < 1700) {

        tempo = "hm";
        tempo = tempo.replace("h", hora);
        if (minuto == 0) {
            tempo = tempo.replace("m", "00");
        } else {
            tempo = tempo.replace("m", minuto);
        }
        tempo = parseInt(tempo);

        id = "d";
        id = id.replace("d", tempo);

        if (hasClass(document.getElementById(id), "horaCheia")) {
            tempo = "hm";
            tempo = tempo.replace("h", horaM);
            if (minutoM == 0) {
                tempo = tempo.replace("m", "00");
            } else {
                tempo = tempo.replace("m", minutoM);
            }
            tempo = parseInt(tempo);
            tx = "{ ";
            tx += '"id" : ' + idInicial + ', "tempo": ' + tempo + ' }';
            try {
                tx = JSON.parse(tx);
            } catch (e) {
                window.alert("Erro no código do site, avise a empresa");
            }

            //horaTempoLivreMax[idInicial] = tempo; 
            horaTempoLivreMax[idInicial] = tx; 
            return;
        }

        minuto += 30;
        minutoM += 30;

        if (minuto > 30) {
            ++hora;
            minuto = 0;
        }

        if (minutoM > 30) {
            ++horaM;
            minutoM = 0;
        }
    }

    tempo = "hm";
    tempo = tempo.replace("h", horaM);
    if (minutoM == 0) {
        tempo = tempo.replace("m", "00");
    } else {
        tempo = tempo.replace("m", minutoM);
    }
    tempo = parseInt(tempo);

    if (tempo == 0) {
        tempo = 30;
        tx = "{ ";
        tx += '"id" : ' + idInicial + ', "tempo": ' + tempo + ' }';
        try {
            tx = JSON.parse(tx);
        } catch (e) {
            window.alert("Erro no código do site, avise a empresa");
        }
        horaTempoLivreMax[idInicial] = tx;
        return;
    } else {
        tx = "{ ";
        tx += '"id" : ' + idInicial + ', "tempo": ' + tempo + ' }';
        try {
            tx = JSON.parse(tx);
        } catch (e) {
            window.alert("Erro no código do site, avise a empresa");
        }
        horaTempoLivreMax[idInicial] = tx;
        return;
    }
}

/******************************************************
 * function: atividadesPossiveis
 * description: Checar as posssíveis atividades de acordo 
 *  com os horários disponíveis.
 ******************************************************/
function atividadesPossiveis() {
    //salvar todas as atividades disponíveis em uma variavel
    //de acordo com o tempo livre máximo de cada hora;
    //criar uma função que pegue um horário e retorne o tempo livre máximo;
    var hora = 8;
    var minuto = 0;
    var tempo = "hm";

    tempo = tempo.replace("h", hora);
    tempo = tempo.replace("m", minuto);
    tempo = parseInt(tempo);
    var id = "";

    while (tempo < 1700) {

        tempo = "hm";
        tempo = tempo.replace("h", hora);
        if (minuto == 0) {
            tempo = tempo.replace("m", "00");
        } else {
            tempo = tempo.replace("m", minuto);
        }
        tempo = parseInt(tempo);

        id = "d";
        id = id.replace("d", tempo);

        if (!hasClass(document.getElementById(id), "horaCheia")) {
            tempoLivreMax(id, hora, minuto);
        }

        minuto += 30;
        if (minuto > 30) {
            ++hora;
            minuto = 0;
        }
    }
}

/***********************************************
 * FUNCTION: servicoVazio
 * DESCRIPTION: Checar se de acordo com o tempo 
 * informado o horario fica vazio ou não.
 **********************************************/
function servicoVazio(tempo, id) {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/agendado.php',
            data: {
                semana: semanaEscolhida - 1,
                total: tempo
            },
            success: function (data) {
                try {
                    info = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }

                if (info.length <= 0) {
                    var tira = "d";
                    tira = tira.replace("d", id);
                    tiraHora(tira);
                }
            }
        });
    });
} 

/***********************************************
 * FUNCTION: tirarHoras Invalidas
 * DESCRIPTION: Tira horas onde de acordo com o
 * tempo livre máximo não caiba nenhuma atividade
 * cadastrada no banco de dados.
 **********************************************/
function tirarHorasInvalidas() {
    var tempo = 0;
    var id = "";
    for (var i in horaTempoLivreMax) {
        tempo = horaTempoLivreMax[i].tempo;
        id = horaTempoLivreMax[i].id;
        servicoVazio(tempo, id);
    }
}

/*************************************************************
 * FUNCTION: tirarDiaCheio
 * DESCRIPTION: Checa se o dia está cheio, se estiver colocar
 *  o dia como ocupado no banco de dados.
 *************************************************************/
function tirarDiaCheio(dia) {
    var hora = 8;
    var minuto = 0;
    var tempo = "hm";
    var checar = 0; //Este número vai indicar se tem ao menos 1 horario livre

    tempo = tempo.replace("h", hora);
    tempo = tempo.replace("m", minuto);
    tempo = parseInt(tempo);
    var id = "";

    while (tempo < 1700) {

        tempo = "hm";
        tempo = tempo.replace("h", hora);
        if (minuto == 0) {
            tempo = tempo.replace("m", "00");
        } else {
            tempo = tempo.replace("m", minuto);
        }
        tempo = parseInt(tempo);

        id = "d";
        id = id.replace("d", tempo);

        if (!hasClass(document.getElementById(id), "horaCheia")) {
            ++checar;
        }

        minuto += 30;
        if (minuto > 30) {
            ++hora;
            minuto = 0;
        }
    }

    if (checar == 0) {

        if (diaOcupado[dia] == null) {
            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    url: 'http://lvh.me/src/agendar/agendado.php',
                    data: {
                        dia: dia,
                        mes: mes,
                        ano: ano,
                        novo: ""
                    },
                    success: function (data) {
                        //PRONTO: tirar o console
                        console.log(data);
                    }
                });
            });
        }
        else {
            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    url: 'http://lvh.me/src/agendar/agendado.php',
                    data: {
                        dia: dia,
                        mes: mes,
                        ano: ano,
                        cheio: 1
                    },
                    success: function (data) {
                        //PRONTO: tirar o console
                        console.log(data);
                    }
                });
            });
        }
    }
}

/***********************************************
 * FUNCTION: diaClick
 * DESCRIPTION: Chama todas as funções necessárias
 * para abrir e mostrar os horarios disponíveis 
 * do dia escolhido pelo cliente.
 **********************************************/
function diaClick(dia, semana) {
    horaTempoLivreMax = {};
    tituloAgenda(dia, semana);
    abrirAgenda();

    checaHora(diaEscolhido);
    atividadesPossiveis();
    tirarHorasInvalidas();
    tirarDiaCheio(dia);
}

/***********************************************
 * FUNCTION: cadastrar
 * DESCRIPTION: Cadastra um horario marcado do cliente
 **********************************************/
function cadastrar() {

    var nome = document.getElementById('nome').value;
    var ddd = document.getElementById('ddd').value;
    var telefone1 = document.getElementById('telefone1').value;
    var telefone2 = document.getElementById('telefone2').value;

    if (ddd.length != 2) {
        errado('ddd');
        return;
    }
    else if (telefone1.length != 5) {
        errado('telefone1');
        return;
    }
    else if (telefone2.length != 4) {
        errado('telefone2');
        return;
    }

    var telefone = "(" + ddd + ") " + telefone1 + "-" + telefone2;
    var email = document.getElementById('email').value;

    //pedido escolhido pelo cliente
    var selecionado = document.getElementById("pedido");
    var atividade = selecionado.options[selecionado.selectedIndex].text;
    var atividadeId = selecionado.options[selecionado.selectedIndex].value;

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/agendar/agendado.php',
            data: {
                email: email,
                telefone: telefone,
                atividade: atividade,
                atividadeId: atividadeId,
                dia: diaEscolhido,
                mes: mes + 1,
                ano: ano,
                hora: horaEscolhida,
                nome: nome,
            },
            success: function (data) {
                try {
                    var info = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, avise a empresa");
                }
                if (info.mensagem != null) {
                    window.alert(info.mensagem);
                }
            }
        });
    });    
}

