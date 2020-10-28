var id = 0;
var source = "";
var total = 0;

function abrirCaixa(src, fotoId, max) {
    id = parseInt(fotoId);
    source = src;
    total = parseInt(max);
    console.log("SRC: " + src + " id: " + id);
    source = source.replace(id, "$");
    source = source.replace("$", id);
    document.getElementById("idFoto").src = source;
    aparecer("idCaixa");
}

function proximaImagem() {
    source = source.replace(id, "$");
    ++id;

    if (id > total) {
        id = 1;
    }

    source = source.replace("$", id);
    document.getElementById("idFoto").src = source;
}

function voltarImagem() {
    source = source.replace(id, "$");
    --id;

    if (id <= 0) {
        id = total;
    }

    source = source.replace("$", id);
    document.getElementById("idFoto").src = source;
}