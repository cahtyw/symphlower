<?php
    session_start();
	require "_libs/_postgresql.php";
	require "_libs/_topside.php";
    
	$user_id = $_SESSION['user_id'];
	$pgsql = new PostgreSQL();
	$pgsql->ConnectSharedServer();
	$pgsql->Query("SELECT * FROM cliente WHERE id_usuario = $user_id");
	$content = $pgsql->FetchArray();
    $pgsql->Query("SELECT * FROM endereco WHERE id_usuario = $user_id");
    $endereco = $pgsql->FetchArray();
    $pgsql->Query("SELECT * FROM usuario WHERE id_usuario =  $user_id");
    $usuario = $pgsql->FetchArray();
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
    <hr>
            <div class="row"></div>
        <div class="row"></div>
			
            <div class="row container">
            <div class="row">
                <div class="col l12 s12 m12">
                    <h4 class="orange-text text-darken-3">Formulário de Alteração de Dados</h4>
                </div>
            </div>
            <div class="row"></div>
            <div class="row">
                <form action="" autocomplete="off" method="post" class="col s12">
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
                                    <div class="input-field col s2">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input readonly="true" value="<?php echo($content['id_usuario']) ?>" name="id_usuario" type="text">
                                        <label for="id">Código</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">email</i>
                                        <input readonly="true" id="email" value="<?php echo($usuario['email']) ?>" onkeyup="getEmail();" onmouseleave="getEmail();" ondragexit="getEmail();" autocomplete="off" maxlength="40" type="email" required name="email" class="validate">
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
                                        <input readonly="true" name="login" value="<?php echo($usuario['login']) ?>" onkeyup="getUser();" onmouseleave="getUser();" ondragexit="getUser();" autocomplete="off" minlength="2" maxlength="40" id="user_name" type="text" class="validate" required>
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
                                        <input type="password" class="validate" placeholder="********" autocomplete="off" minlength="6" maxlength="32" class="" onkeyup="verifica();" required name="senha" id="password-3">
                                        <label class="active" data-error="*Sua senha deve ter pelo menos 6 caracteres e no mínimo um dígito" for="password-3">*Senha</label>
                                    </div>
                                    <div class="col s2">
                                        <div class="row"></div>
                                        <div class="row"></div>
                                        <div class="row">
                                            <div id="password_strength" class="col s12"></div>
                                        </div>
                                    </div>
                                    
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
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input readonly="true" value="<?php echo($endereco['id_usuario']) ?>" name="id_usuario" type="text">
                                        <label for="id">Código</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix">face</i>
                                        <select name="sexo" required>
                                            <option value="<?php echo($content['sexo']) ?>" readonly="true" selected><?php echo($content['sexo']) ?></option>
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
                                        <input id="client_firstname" value="<?php echo($content['nome']) ?>" autocomplete="off" name="nome" maxlength="30" required type="text" class="validate">
                                        <label for="client_firstname" class="active" data-error="*Este é um campo obrigatório">*Nome</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="client_lastname" value="<?php echo($content['sobrenome']) ?>" autocomplete="off" name="sobrenome" maxlength="40" required type="text" class="validate">
                                        <label for="client_lastname" class="active" data-error="*Este é um campo obrigatório">*Sobrenome</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="docs-datepicker">
                                        <div class="input-field col s8">
                                            <i class="material-icons prefix">date_range</i>
                                            <input type="text" value="<?php echo($content['data_nasc']) ?>" autocomplete="off" maxlength="10" minlength="10" class="form-control docs-date validate" name="data_nasc" id="client_born">
                                            <label for="client_born" class="active" data-error="*Você deve selecionar uma data válida (formato USA) antes de avançar" required>*Data de nascimento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">phone</i>
                                        <input name="telefone" value="<?php echo($content['telefone']) ?>" autocomplete="off" maxlength="14" minlength="14" id="client_phone" type="text" class="">
                                        <label for="client_phone" data-error="*Este é um campo obrigatório" class="active">Telefone</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">phone</i>
                                        <input name="celular" value="<?php echo($content['celular']) ?>" autocomplete="off" minlength="14" maxlength="15" id="client_cellphone" type="text" class="">
                                        <label for="client_cellphone" data-error="*Este é um campo obrigatório" class="active">Celular</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input name="cpf" value="<?php echo($content['cpf']) ?>" onkeyup="getCPF();" onmouseleave="getCPF();" ondragexit="getCPF();" autocomplete="off" maxlength="14" minlength="14" required id="client_cpf" required type="text" class="">
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
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">perm_identity</i>
                                        <input readonly="true" value="<?php echo($endereco['id_usuario']) ?>" name="id_usuario" type="text">
                                        <label for="id">Código</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix">home</i>
                                        <input name="cep" value="<?php echo($endereco['cep']) ?>" autocomplete="off" minlength="9" maxlength="9" required id="address_postcode" required type="text" class="">
                                        <label for="address_postcode" data-error="*Insira um CEP válido" class="active">*CEP</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s8">
                                        <i class="material-icons prefix">home</i>
                                        <input name="endereco" value="<?php echo($endereco['endereco']) ?>" autocomplete="off" required id="address_street" required type="text" class="validate">
                                        <label for="address_street" data-error="*Este é um campo obrigatório" class="active">*Rua</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input name="bairro" value="<?php echo($endereco['bairro']) ?>" autocomplete="off" required id="address_neiborhood" required type="text" class="validate">
                                        <label for="address_neiborhood" data-error="*Este é um campo obrigatório" class="active">*Bairro</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s4">
                                        <i class="material-icons prefix">home</i>
                                        <input name="numero" value="<?php echo($endereco['numero']) ?>" autocomplete="off" required id="address_number" required type="text" class="validate">
                                        <label for="address_number" data-error="*Este é um campo obrigatório" class="active">*Número</label>
                                    </div>
                                    <div class="input-field col s8">
                                        <input name="complemento" value="<?php echo($endereco['complemento']) ?>" autocomplete="off" id="address_complement" type="text" class="validate">
                                        <label for="address_complement" class="active">Complemento</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s5">
                                        <i class="material-icons prefix">home</i>
                                        <input name="pais" value="<?php echo($endereco['pais']) ?>" autocomplete="off" required id="address_country" required type="text" class="validate">
                                        <label for="address_country" data-error="*Este é um campo obrigatório" class="active">*País</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input name="estado" value="<?php echo($endereco['estado']) ?>" autocomplete="off" required id="address_state" required data-length="2" minlength="2" maxlength="2" type="text" class="validate">
                                        <label for="address_state" data-error="*Este é um campo obrigatório" class="active">*Estado</label>
                                    </div>
                                    <div class="input-field col s5">
                                        <input name="cidade" value="<?php echo($endereco['cidade']) ?>" autocomplete="off" required id="address_city" required type="text" class="validate">
                                        <label for="address_city" data-error="*Este é um campo obrigatório" class="active">*Cidade</label>
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
                                Atualizar
                                <i class="material-icons left">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>               
            
		</div>
    </div>
	
<?php
	require "_libs/_footer.php";
?>
<?php
    $connect = pg_connect("host=localhost port=5432 dbname=2017_cadastro_compartilhado user=alunocti password=alunocti");
    if(!$connect)
        echo("Não foi possível conectar com o Banco de Dados.");
?>
<?php
	$id_usuario = $_POST["id_usuario"];
	$login = $_POST["login"];
	$email = $_POST["email"];
	$senha = md5($_POST["senha"]);
	$sql = "update usuario
            set
            login = '$login',
            email = '$email',
            senha = '$senha'
            where id_usuario = $id_usuario";
	$pgsql->Query($sql);
	$resultado = pg_query($connect, $sql);
	$qtde = pg_affected_rows($resultado);

	if($qtde > 0) {
		echo "<script type='text/javascript'>alert('Dados de acesso alterado e gravado com sucesso.')</script>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=user_account.php'>";
	}
?>
<?php
    $id_usuario=$_POST["id_usuario"];
    $nome=$_POST["nome"];
    $sobrenome=$_POST["sobrenome"];
    $cpf=$_POST["cpf"];
    $sexo=$_POST["sexo"];
    $data_nasc=$_POST["data_nasc"];
    $telefone=$_POST["telefone"];
    $celular=$_POST["celular"];
    $sql="update cliente
            set
            nome = '$nome',
            sobrenome = '$sobrenome',
            cpf = '$cpf',
            sexo = '$sexo',
            data_nasc = '$data_nasc',
            telefone = '$telefone',
            celular = '$celular'
            where id_usuario = $id_usuario";
    $resultado=pg_query($connect,$sql);
    $qtde=pg_affected_rows($resultado);

    if ($qtde > 0)
    {
        echo "<script type='text/javascript'>alert('Dados do cliente alterado e gravado com sucesso.')</script>";
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=user_account.php'>";
    }
?>
<?php
    $id_usuario=$_POST["id_usuario"];
    $endereco=$_POST["endereco"];
    $numero=$_POST["numero"];
    $complemento=$_POST["complemento"];
    $bairro=$_POST["bairro"];
    $cep=$_POST["cep"];
    $cidade=$_POST["cidade"];
    $estado=$_POST["estado"];
    $pais=$_POST["pais"];
    $sql="update endereco
            set
            endereco = '$endereco',
            numero = '$numero',
            complemento = '$complemento',
            bairro = '$bairro',
            cep = '$cep',
            cidade = '$cidade',
            estado = '$estado',
            pais = '$pais'
            where id_usuario = $id_usuario";
    $resultado=pg_query($connect,$sql);
    $qtde=pg_affected_rows($resultado);

    if ($qtde > 0)
    {
        echo "<script type='text/javascript'>alert('Dados do endereço alterado e gravado com sucesso.')</script>";
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=user_account.php'>";
    }
?>
