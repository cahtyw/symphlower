<?php

	include "conexao.php";
	include("PHPMailer/class.phpmailer.php");
	include("PHPMailer/class.smtp.php");
	
	//$senha = $_SESSION['user_password'];
	$nome = $_POST['nome'];
	$assunto = $_POST['assunto'];
	$email = $_POST['email'];
	$mensagem = $_POST['mensagem'];

	$teste = "symphlower@gmail.com";
	$mail = new PHPMailer(true);// Inicia a classe PHPMailer


	$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl'; 
	$mail->Port=465;// Usa autenticação SMTP? (opcional)
	$mail->Username = $teste; // Usuário do servidor SMTP
	$mail->Password = 'omelhortrabalhodomundo123'; // Senha do servidor SMTP
	// Define o remetente
	
	$mail->SetFrom($email,$nome); 

	// Define os destinatário(s)

	$mail->AddAddress("symphlower@gmail.com", "Floricultura Symphlower");
	$mail->AddAddress("symphlower@gmail.com");
	$mail->IsHTML(true); 
	
	$mail->CharSet = 'iso-8859-1'; 
	$mail->Subject  = $assunto; // Assunto da mensagem
	$mail->Body = $corpo = 
	'<html>
	<head>
	</head>
	<body>
	
	
	<span><b>Nome: </b>'.$nome.'</span>
	<span><b>Email: </b>'.$email.'</span>
	<span><b>Assunto: </b>'.$assunto.'</span>
	<span><b>Mensagem: </b>'.$mensagem.'</span>		

	</body>
	</html>';
	$mail->AltBody = "Se você tiver problema para a reativação da nova senha nos comunique!";
	$enviado = $mail->Send(); 

	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
	// Exibe uma mensagem de resultado

	if ($enviado==true)
	{

		header("Location: index.php");


	}
	else
	{
		//echo "Não foi possível enviar o e-mail.";
		//echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
		header("Location: index.php");

	}
?>

