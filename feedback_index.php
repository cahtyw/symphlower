<?php
	session_start();
	require "_libs/_postgresql.php";
	require "_libs/_topside.php";
?>
	<div class="row container">
		<div class="row">
		</div>
		<div class="row">
			<div class="col l6">
				<h4 class="orange-text text-darken-3">Entrar em contato</h4>
				<hr>
				<h6>Nos envie um email e lhe responderemos o mais rápido possível.</h6>
				<div class="row"></div>
				<?php
					if(isset($_SESSION['login_error']) && $_SESSION['login_error']) {
						?>
						<blockquote>
							Usuário ou senha inseridos <strong>incorretamente</strong>.<br>
							Verifique os dados e tente novamente.
						</blockquote>
						<?php
						$_SESSION['login_error'] = FALSE;
					}
				?>
				<form class="col l12" autocomplete="off" action="feedback_envio.php" method="post">
					<div class="input-field col l10">
						<i class="material-icons prefix">person</i>
						<input id="name" name="nme" type="text" autocomplete="off"
							class="validate">
						<label for="naome">Nome</label>
					</div>
					<div class="input-field col l10">
						<i class="material-icons prefix">email</i>
						<input id="text" name="email" autocomplete="off" type="text"
							class="validate">
						<label for="text">E-mail</label>
					</div>
					<div class="input-field col l10">
						<i class="material-icons prefix">star_rate</i>
						<input id="subject" name="assunto" type="text" autocomplete="off"
							class="validate">
						<label for="assunto">Insira o assunto</label>
					</div>
					<div class="input-field col l10">
						<i class="material-icons prefix">feedback</i>
						<textarea id="message" name="mensagem" type="text" autocomplete="off"
							class="validate materialize-textarea" rows="10" cols="50"></textarea>
						<label for="mensagem">Digite uma mensagem</label>
					</div>
					<div class="col 18">
					</div>
					<p>
					<p>
					<div class="row"></div>
					<div class="row">
						<div class="col 120 center">
							<button class="btn-large waves-effect waves-light orange darken-3"
								type="submit"
								name="action">Enviar
								<i class="material-icons left">send</i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	require "_libs/_footer.php";
?>