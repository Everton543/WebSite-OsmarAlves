var texto = "";
function aparecerTexto() {
    
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/contato/contatos.php',
            data: {
                consultar: ""
            },
            success: function (data) {
                console.log(data);
                try {
                    texto = JSON.parse(data);
                    console.log(texto);
                } catch (e) {
                    window.alert("Erro no código do site, por favor avise a empresa");
                }

                mudarTextoContato();
            }
        });
    });
}

function mudarTextoContato() {
    var textoId = "textoz";
    var id = 0;
    for (var i = 0; i < 4; i++) {
        textoId = "textoz";
        id = i + 1;
        textoId = textoId.replace("z", id);

        if (texto[i].link != null) {
            document.getElementById(texto[i].id).setAttribute('href', texto[i].link);
        }
        document.getElementById(textoId).innerHTML = texto[i].texto;
    }
}