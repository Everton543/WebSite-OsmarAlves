
var atualId = 1;
var timer = setInterval(slide, 4000);

function slide() {
    var id = "1";
    id = id.replace(id, atualId)
    document.getElementById(id).classList.remove("selecionado");
    atualId += 1;

    if (atualId > 4) {
        atualId = 1;
    }

    id = id.replace(id, atualId)
    document.getElementById(id).classList.add("selecionado");
}