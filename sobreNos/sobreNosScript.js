
function aparecerTextoSobreNos() {
    var sobreNos = "";
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: 'http://lvh.me/src/sobreNos/sobreNos.php',
            data: {
                consultar: ""
            },
            success: function (data) {
                try {
                    sobreNos = JSON.parse(data);
                } catch (e) {
                    window.alert("Erro no código do site, por favor avise a empresa");
                }
                document.getElementById("sobreNosTexto").innerHTML = sobreNos.texto;
            }
        });
    });
}