/**
 * Função para criar um objeto XMLHTTPRequest
 */
function CriaRequest() {
    //var result_error = document.getElementById("result_search");
    try {
        request = new XMLHttpRequest();
    } catch (IEAtual) {

        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (IEAntigo) {

            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (falha) {
                request = false;
            }
        }
    }

    if (!request) {
        //result_error("Seu Navegador não suporta Ajax!");
    }
    else
        return request;
}

/**
 * Função para checar os dados de usuário
 */
function getUser() {

    // Declaração de Variáveis
    var nome = document.getElementById("user_name").value;
    var result = document.getElementById("result_user");
    var xmlreq = CriaRequest();

    // Iniciar uma requisição
    xmlreq.open("GET", "search_ajax.php?user_name=" + nome, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            } else {
                result.innerHTML = "Insira um usuário entre 2-40 caracteres.";
            }
        }
    };
    xmlreq.send(null);
}


/**
 * Função para checar os dados de e-mail
 */
function getEmail() {

    // Declaração de Variáveis
    //var email   = document.getElementById("client_email").value;
    var email = $.trim($("input[name='client_email']").val());
    var result = document.getElementById("result_email");
    var xmlreq = CriaRequest();

    // Iniciar uma requisição
    xmlreq.open("GET", "search_ajax.php?client_email=" + email, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            } else {
                result.innerHTML = "Insira um e-mail válido";
            }
        }
    };
    xmlreq.send(null);
}

/**
 * Função para verificar o CPF
 */
function getCPF() {

    // Declaração de Variáveis
    //var email   = document.getElementById("client_email").value;
    var cpf = document.getElementById("client_cpf").value;
    var result = document.getElementById("result_cpf");
    var xmlreq = CriaRequest();

    // Iniciar uma requisição
    xmlreq.open("GET", "search_ajax.php?client_cpf=" + cpf, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            } else {
                result.innerHTML = "Insira um CPF válido";
            }
        }
    };
    xmlreq.send(null);
}

/*
* Função para editar produto
*/

function getProduct() {

}