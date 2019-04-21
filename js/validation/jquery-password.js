window.onload = function () {
    verifica();
}


function validaSenha(input) {
    if (input.value != document.getElementById('user_password').value) {
        input.setCustomValidity('Repita a senha corretamente');
    } else {
        input.setCustomValidity('');
    }
}


function verifica() {
    senha = document.getElementById("password-3").value;
    forca = 0;
    mostra = document.getElementById("password_strength");
    if ((senha.length >= 4) && (senha.length <= 7)) {
        forca += 10;
    } else if (senha.length > 7) {
        forca += 25;
    }
    if (senha.match(/[a-z]+/)) {
        forca += 10;
    }
    if (senha.match(/[A-Z]+/)) {
        forca += 25;
    }
    if (senha.match(/[0-9]+/)) {
        forca += 25;
    }
    return mostra_res();
}

function mostra_res() {
    if (forca == 0) {
        mostra.innerHTML = '<div class="progress red">\n' +
            '      <div class="determinate" style="width: 0%"></div>\n' +
            '  </div>';
    }
    else if ((forca < 30) && forca > 0) {
        mostra.innerHTML = '<div class="progress red lighten-3">\n' +
            '      <div class="determinate" style="width: 25%; background-color: RED;"></div>\n' +
            '  </div>';
    } else if ((forca >= 30) && (forca < 60)) {
        mostra.innerHTML = '<div class="progress orange lighten-3">\n' +
            '      <div class="determinate" style="width: 50%; background-color: ORANGE;"></div>\n' +
            '  </div>';
    } else if ((forca >= 60) && (forca < 85)) {
        mostra.innerHTML = '<div class="progress light-green lighten-3">\n' +
            '      <div class="determinate" style="width: 75%; background-color: #6b8e23;"></div>\n' +
            '  </div>';
    } else {
        mostra.innerHTML = '<div class="progress  green lighten-3">\n' +
            '      <div class="determinate" style="width: 100%; background-color: #006a00;"></div>\n' +
            '  </div>';
    }
}