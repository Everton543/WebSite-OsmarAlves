var menuClick = 0;

function abrirMenu() {
    ++menuClick;
    if (menuClick % 2 != 0) {
        document.getElementById("menu").classList.remove("fechado");
    }

    else {
        fecharMenu();
    }
}

function fecharMenu() {    
    document.getElementById("menu").classList.add("fechado");
}

function certo(id) {
    document.getElementById(id).classList.remove("errado");
}

function errado(id) {
    document.getElementById(id).classList.add("errado");
}