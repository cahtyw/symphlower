<?php

	include("PHPMailer/class.phpmailer.php");
	include("PHPMailer/class.smtp.php");
	//include ("conexao.php");
	require "_libs/_postgresql.php";
	$user_name = strtolower($_POST['user_name']);
	$user_email = strtolower($_POST['user_email']);
	$pgsql = new PostgreSQL();
	$pgsql->ConnectSharedServer();
	$pgsql->QueryWithoutReturn("SELECT * FROM usuario WHERE login = '$user_name' AND email = '$user_email'");
	if(!$pgsql->NumRows()){
		$pgsql->DisconnectServer();
		require "_libs/_meta.html";
		?>
		<div class="global-loading">
			<div class="loading">
				<img src="images/site/loading_logo.png">
				<div class="progress">
					<div class="indeterminate"></div>
				</div>
				<h4 class="orange-text text-darken-3">Usuário ou e-mail inseridos são inválidos ou não existem.</h4>
				<h5 class="orange-text text-darken-3">Redirecionando para a página de login...</h5>
			</div>
		</div>
		<?php
		header("Refresh:2; url=login.php");
	}
	else {

		// Inicia a classe PHPMailer
		$mail = new PHPMailer(TRUE);
		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;// Usa autenticação SMTP? (opcional)
		$mail->Username = 'symphlower@gmail.com'; // Usuário do servidor SMTP
		$mail->Password = 'omelhortrabalhodomundo123'; // Senha do servidor SMTP
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

		$mail->SetFrom("symphlower@gmail.com", "Symphlower"); // Seu e-mail
		// Seu nome
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

		$mail->AddAddress($user_email, $user_name);
		$mail->AddAddress($user_email);
		//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
		//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsHTML(TRUE);

		//------------------------- SOLUÇÃO DO ERRO: --------------------------------
		//A FUNÇÃO ABAIXO NÃO FOI DEFINIDA CORRETAMENTE, SÒ COMENTE E ELA ENVIOU O EMAAIL
		//SE TA FUNCIONANDO, NÂO MEXE :v

		//$mail->IsMail();// Define que o e-mail será enviado como HTML
		$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
		// Define a mensagem (Texto e Assunto)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		for ($i = 0; $i < 1; $i++) {
			$senha = uniqid();


		}

		$mail->Subject = "Symphlower - Solicitação de troca de senha"; // Assunto da mensagem

		$mail->Body = "<center><img src='http://200.145.153.175/gabrielgoncalves/images/site/loading_logo.png'><br><h1>$user_name, você pediu para trocar sua senha?</h1><br><h3>Caso você tenha pedido para alterar sua senha, sua nova senha é: <b>$senha</b></h3><br>Caso não tenha feito esse pedido, entre em contato conosco para resolvermos este problema.</center>";
		$mail->AltBody = "Este é um email para renovação de senha para acesso á conta da Floricultura Symphlower";


		// Envia o e-mail

		$enviado = $mail->Send(); //PROBLEMA
		// Limpa os destinatários e os anexos
		// Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo


		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		// Exibe uma mensagem de resultado

		if ($enviado == TRUE) {
			$pgsql->ConnectSharedServer();
			$Novasenha = md5($senha);
			$pgsql->QueryWithoutReturn("UPDATE usuario SET senha= '$Novasenha' WHERE email = '$user_email'");
			$pgsql->DisconnectServer();
			require "_libs/_meta.html";
			?>
			<div class="global-loading">
				<div class="loading">
					<img src="images/site/loading_logo.png">
					<div class="progress">
						<div class="indeterminate"></div>
					</div>
					<h4 class="orange-text text-darken-3">Senha enviada para o e-mail do usuário solicitado.</h4>
					<h5 class="orange-text text-darken-3">Redirecionando para a página de login...</h5>
				</div>
			</div>
			<?php
			header("Refresh:2; url=login.php");
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
					<h4 class="orange-text text-darken-3">Um erro ocorreu no envio do e-mail, favor entrar em contato com o suporte.</h4>
					<h5 class="orange-text text-darken-3">Redirecionando para a página de login...</h5>
				</div>
			</div>
			<?php
			header("Refresh:2; url=login.php");
		}
	}
?>