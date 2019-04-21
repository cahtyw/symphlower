<?php
	session_start();
	require "_libs/_postgresql.php";
	if (!$_SESSION['login']) {
		require "_libs/_topside.php";
		?>
        <!--DATEPICKER-->
        <link rel="stylesheet" href="https://fengyuanchen.github.io/datepicker/css/datepicker.css">
        <script src="https://fengyuanchen.github.io/js/common.js"></script>
        <script src="https://fengyuanchen.github.io/datepicker/js/datepicker.js"></script>
        <script src="https://fengyuanchen.github.io/datepicker/js/datepicker.pt-BR.js"></script>
        <script src="https://fengyuanchen.github.io/datepicker/js/main.js"></script>
        <script>
            $().datepicker({
                language: 'pt-BR'
            });
        </script>

        <!--VALIDAÇÃO-->
        <script src="js/validation/hideShowPassword.min.js"></script>

        <!--ESCONDER PASSWORD-->
        <script src="js/validation/jquery-password.js"></script>

        <!--CONSULTA-->
        <script type="text/javascript" src="js/ajax/ajax.js"></script>
    <script type="text/javascript" >
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('address_street').value=("");
            document.getElementById('address_neiborhood').value=("");
            document.getElementById('address_city').value=("");
            document.getElementById('address_state').value=("");

    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('address_street').value=(conteudo.logradouro);
            document.getElementById('address_neiborhood').value=(conteudo.bairro);
            document.getElementById('address_city').value=(conteudo.localidade);
            document.getElementById('address_state').value=(conteudo.uf);

        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            swal('Erro!', 'O CEP que você digitou não existe, confira e tente novamente.', 'warning');
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var address_postcode = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (address_postcode != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(address_postcode)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('address_street').value="...";
                document.getElementById('address_neiborhood').value="...";
                document.getElementById('address_city').value="...";
                document.getElementById('address_state').value="...";


                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ address_postcode + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>


        <!--HTML-->
        <div class="row"></div>
        <div class="row"></div>
        <div class="row container">
            <div class="row">
                <div class="col l12 s12 m12">
                    <h4 class="orange-text text-darken-3">Formulário de Cadastro</h4>
                    <h6>Preencha os campos a seguir para realizar o cadastro.</h6>
                </div>
            </div>
            <div class="row"></div>
            <div class="row">
                <form action="register_user_validate.php" autocomplete="off" method="post" class="col s12">
                    <div class="row">
                        <div class="col s12">
                            <fieldset>
                                <div class="col s12">
                                    <h5 class="orange-text text-darken-3">
                                        Dados para acesso:
                                    </h5>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">email</i>
                                        <input id="email" placeholder="Ex: exemplo@exemplo.com" onkeyup="getEmail();" onmouseleave="getEmail();" ondragexit="getEmail();" autocomplete="off" maxlength="40" type="email" required name="client_email" class="validate">
                                        <label for="email" class="active" data-error="*Insira um e-mail válido">*E-mail</label>
                                    </div>
                                    <div class="col s6">
                                        <br>
                                        <div id="result_email">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">account_circle</i>
                                        <input name="user_name" placeholder="Ex: Gabriel123" onkeyup="getUser();" onmouseleave="getUser();" ondragexit="getUser();" autocomplete="off" minlength="2" maxlength="40" id="user_name" type="text" class="validate" required>
                                        <label for="user_name" class="active" data-error="*Insira um usuário entre 2-40 caracteres">*Usuário</label>
                                    </div>
                                    <div class="col s6">
                                        <br>
                                        <div id="result_user">

                                        </div>
                                    </div>
                                </div>
                                <script>

                                </script>
                                <div class="row">
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">lock</i>
                                        <input type="password" class="validate" placeholder="********" autocomplete="off" minlength="6" maxlength="32" class="" onkeyup="verifica();" required name="user_password" id="password-3">
                                        <label class="active" data-error="*Sua senha deve ter pelo menos 6 caracteres e no mínimo um dígito" for="password-3">*Senha</label>
                                    </div>
                                    <div class="col s2">
                                        <div class="row"></div>
                                        <div class="row"></div>
                                        <div class="row">
                                            <div id="password_strength" class="col s12"></div>
                                        </div>
                                    </div>
                                    <!--<div class="input-field col s6">
                                        <i class="material-icons prefix">vpn_key</i>
                                        <input type="password" placeholder="(Repita sua senha)" autocomplete="off" minlength="8" maxlength="32" class="" required name="user_password" id="user_password oninput="validaSenha(this)"">
                                        <label for="user_password" class="active">Repita sua senha</label>
                                    </div>-->
                                </div>

                                <div class="row">
                                    <div class="col l6">
                                        &nbsp;
                                        <input type="checkbox" id="show-password">
                                        <label for="show-password" class="black-text">Ver senha</label>
                                    </div>
                                </div>
                                <script>
                                    $('#show-password').change(function(){
                                        $('#password-3').hideShowPassword($(this).prop('checked'));
                                    });
                                </script>
                                <div class="row">
                                    <div class="col l12">
                                        <div id="result_search">

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <fieldset>
                                <div class="col s12">
                                    <h5 class="orange-text text-darken-3">
                                        Dados Pessoais:
                                    </h5>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix">face</i>
                                        <select name="client_sex" required>
                                            <option value="0" disabled selected>Selecione</option>
                                            <option value="f">Feminino</option>
                                            <option value="m">Masculino</option>
                                            <!--<option value="Srta.">Outro</option>-->
                                        </select>
                                        <label>*Sexo</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">person</i>
                                        <input id="client_firstname" placeholder="Ex: Gabriel" autocomplete="off" name="client_firstname" maxlength="30" required type="text" class="validate">
                                        <label for="client_firstname" class="active" data-error="* Campo obrigatório">*Nome</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="client_lastname" placeholder="Ex: Santos" autocomplete="off" name="client_lastname" maxlength="40" required type="text" class="validate">
                                        <label for="client_lastname" class="active" data-error="* Campo obrigatório">*Sobrenome</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="docs-datepicker">
                                        <div class="input-field col s8">
                                            <i class="material-icons prefix">date_range</i>
                                            <input type="text" placeholder="Ex: 04/23/1998" autocomplete="off" maxlength="10" minlength="10" class="form-control docs-date validate" name="client_born" id="client_born">
                                            <label for="client_born" class="active" data-error="*Você deve selecionar uma data válida (formato USA) antes de avançar" required>*Data de nascimento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">phone</i>
                                        <input name="client_phone" placeholder="Ex: (99) 9999-9999" autocomplete="off" maxlength="14" minlength="14" id="client_phone" type="text" class="">
                                        <label for="client_phone" data-error="* Campo obrigatório" class="active">Telefone</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">phone</i>
                                        <input name="client_cellphone" placeholder="Ex: (99) 99999-9999" autocomplete="off" minlength="14" maxlength="15" id="client_cellphone" type="text" class="">
                                        <label for="client_cellphone" data-error="* Campo obrigatório" class="active">Celular</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input name="client_cpf" placeholder="Ex: 999.999.999-99" onkeyup="getCPF();" onmouseleave="getCPF();" ondragexit="getCPF();" autocomplete="off" maxlength="14" minlength="14" required id="client_cpf" required type="text" class="">
                                        <label for="client_cpf" data-error="*Insira um CPF válido" class="active">*CPF</label>
                                    </div>
                                    <div class="col s6">
                                        <br>
                                        <div id="result_cpf">

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col s6">
                            <fieldset>
                                <div class="col s12">
                                    <h5 class="orange-text text-darken-3">
                                        Endereço:
                                    </h5>
                                    <br>
                                </div>
                            
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">home</i>
                                        <!--<input name="cep" value="" onblur="pesquisacep(this.value);" placeholder="Ex: 99999-999" autocomplete="off" minlength="9" maxlength="9" required id="cep" required type="text" class="">-->
                                        <input name="address_postcode" type="text" id="address_postcode"  placeholder="Ex: 99999-999" required value="" size="10" maxlength="9" onblur="pesquisacep(this.value);" />
                                        <label for="" data-error="*Insira um CEP válido" class="active">*CEP</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s8">
                                        <i class="material-icons prefix">home</i>
                                        <!--<input name="rua" placeholder="Ex: Avenida Paulista" autocomplete="off" required id="rua" required type="text" class="validate">-->
                                        <input name="address_street" type="text" id="address_street" size="60" placeholder="Ex: Avenida Paulista" required class="validate" />
                                        <label for="address_street" data-error="* Campo obrigatório" class="active">*Rua</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <!--<input name="bairro" placeholder="Ex: Centro" autocomplete="off" required id="bairro" required type="text" class="validate">-->
                                        <input name="address_neiborhood" placeholder="Ex: Centro" type="text" id="address_neiborhood" required size="40" />
                                        <label for="address_neiborhood" data-error="* Campo obrigatório" class="active">*Bairro</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">home</i>
                                        <input name="address_number" placeholder="Ex: 1514" autocomplete="off" required id="address_number" required type="text" class="validate">
                                        <label for="address_number" data-error="* Campo obrigatório" class="active">*Número</label>
                                    </div>
                                    <div class="input-field col s8">
                                        <input name="address_complement" placeholder="Ex: Apto 02, bloco 7A" autocomplete="off" id="address_complement" type="text" class="validate">
                                        <label for="address_complement" class="active">Complemento</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix">home</i>
                                        <input name="address_country" value="Brasil" placeholder="Ex: Brasil" autocomplete="off" required id="address_country" required type="text" class="validate">
                                        <label for="address_country" data-error="* Campo obrigatório" class="active">*País</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input name="address_state" placeholder="Ex: SP" autocomplete="off" required id="address_state" required data-length="2" minlength="2" maxlength="2" type="text" class="validate">
                                        <label for="address_state" data-error="* Campo obrigatório" class="active">*Estado</label>
                                    </div>
                                    <div class="input-field col s5">
                                        <!--<input name="cidade" placeholder="Ex: Bauru" autocomplete="off" required id="cidade" required type="text" class="validate">-->
                                        <input name="address_city" type="text" id="address_city" placeholder="Ex: Bauru" required class="validate" size="40" />
                                        <label for="address_city" data-error="* Campo obrigatório" class="active">*Cidade</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="col s6 center">
                            <a href="login.php" class="btn-large waves-effect waves-light black">
                                Cancelar
                                <i class="material-icons left">cancel</i>
                            </a>
                        </div>
                        <div class="col s6 center">
                            <button class="btn-large waves-effect waves-light orange darken-3"
                                    type="submit"
                                    name="action">
                                Registrar
                                <i class="material-icons left">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        <!--VALIDAÇÃO-->
        <!--<script src="js/validation/jquery.validate.js"></script>
        <script src="js/validation/signup-form.js"></script>-->

        <!--MÁSCARAS-->
        <script src="js/mask/mask.js"></script>

		<?php
		require "_libs/_footer.php";
	}
	else {
		require "_libs/_meta.html";
		?>

        <div class="global-loading">
            <div class="loading">
                <img src="images/site/loading_logo.png">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
                <h4 class="orange-text text-darken-3">Você precisa estar deslogado para acessar esse formulário.</h4>
                <h5 class="orange-text text-darken-3">Redirecionando para a página inicial...</h5>
            </div>
        </div>
		<?php
		header("Refresh:2; url=index.php");
	}
?>
