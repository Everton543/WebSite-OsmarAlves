function aparecer(id) {
    document.getElementById(id).classList.remove("fechado");
}

function esconder(id) {
    document.getElementById(id).classList.add("fechado");
}

function certo(id) {
    document.getElementById(id).classList.remove("errado");
}

function errado(id) {
    document.getElementById(id).classList.add("errado");
}