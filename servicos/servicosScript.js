
function aparecerTextoServico() {
    var texto = "";
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/servicos/servicos.php',
            data: {
                consultar: ""
            },
            success: function (data) {
                try {
                    texto = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, por favor avise a empresa");
                }

                document.getElementById("servicos").innerHTML = texto.texto;
            }
        });
    });
}