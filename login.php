<?php
	session_start();
	require "_libs/_postgresql.php";
	if (!$_SESSION['login']) {
		require "_libs/_topside.php";
		?>
        <div class="row container">
            <div class="row">
                <div class="col l12 s12 m12">
                    <h4 class="orange-text text-darken-3">Seu cadastro</h4>
                    <h6>Você precisa ser cadastrado ou já possuir um cadastro para continuar desta
                        página.</h6>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col l6">
                    <h5 class="orange-text text-darken-3">Já é cadastrado?</h5>
                    <h6>Então entre com os dados do seu login e senha.</h6>
                    <div class="row"></div>
					<?php
						if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
							?>
                            <blockquote>
                                Usuário ou senha inseridos <strong>incorretamente</strong>.<br>
                                Verifique os dados e tente novamente.
                            </blockquote>
							<?php
							$_SESSION['login_error'] = FALSE;
						}
					?>
                    <form class="col l12" autocomplete="off" action="login_validate.php" method="post">
                        <div class="input-field col l10">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="user_name" name="user_name" type="text" autocomplete="off"
                                   class="validate">
                            <label for="user_name">Usuário</label>
                        </div>
                        <div class="input-field col l10">
                            <i class="material-icons prefix">https</i>
                            <input id="password" name="user_password" autocomplete="off" type="password"
                                   class="validate">
                            <label for="password">Senha</label>
                        </div>
                        <div class="col l8">
                            <a class="text-darken-3 orange-text" href="teste_index_email.php">
                                <u>ESQUECI MINHA SENHA</u>
                                <i class="material-icons left">help</i>
                            </a>
                        </div>
                        <div class="row"></div>
                        <div class="row">
                            <div class="col l10 center">
                                <button class="btn-large waves-effect waves-light orange darken-3"
                                        type="submit"
                                        name="action">Entrar
                                    <i class="material-icons left">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col l6">
                    <h5 class="orange-text text-darken-3">Ainda não é cadastrado?</h5>
                    <h6>Siga para o formulário de cadastro clicando no botão abaixo.</h6>
                    <div class="row"></div>
                    <div class="row">
                        <div class="col l10 center">
                            <a href="register_user.php"
                               class="waves-effect waves-light btn-large orange darken-3"><i
                                        class="material-icons left">person_add</i>Cadastrar-se</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <h4 class="orange-text text-darken-3">Você já está logado.</h4>
                <h5 class="orange-text text-darken-3">Redirecionando para a página inicial...</h5>
            </div>
        </div>
		<?php
		header("Refresh:2; url=index.php");
	}
?>