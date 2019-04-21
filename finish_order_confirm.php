<?php
	session_start();
	setlocale(LC_CTYPE,"pt_BR");
	if(isset($_SESSION['login'])) {
		require "_libs/_postgresql.php";
		$pgsql = new PostgreSQL();
		$pgsql->ConnectServer();
		$pgsql->Query("SELECT * FROM cart");
		if($pgsql->NumRows()) {
			date_default_timezone_set('America/Sao_Paulo');
			//$date = date("Y-m-d - H:i:s");
			$date = date('Y-m-d H:i:s', time());
			$user_id = $_SESSION['user_id'];
			$address = $_SESSION['address'];
			$pgsql->Query("INSERT INTO orders VALUES(DEFAULT, $user_id, '$date', $address, TRUE)");
			$pgsql->Query("SELECT order_id FROM orders WHERE order_user = $user_id AND order_date = '$date'");
			$line = $pgsql->FetchArray();
			$order_id = $line['order_id'];
			$pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id");
			$pgselect = new PostgreSQL();
			$pgselect->ConnectServer();
			$pgvalue = new PostgreSQL();
			$pgvalue->ConnectServer();
			while($product = $pgsql->FetchArray()) {
				$product_id = $product['cart_product'];
				$cart_amount = $product['cart_amount'];
				$pgvalue->Query("SELECT product_salevalue FROM product WHERE product_id = $product_id");
				$price_array = $pgvalue->FetchArray();
				$pgvalue->Query("UPDATE product SET product_stock = (product_stock - $cart_amount) WHERE product_id = $product_id");
				$price = $price_array['product_salevalue'] * $cart_amount;
				$price = number_format($price, 2, '.', '');
				$pgselect->Query("INSERT INTO items VALUES($order_id, $product_id, $cart_amount, $price)");
			}
			try {
				$pgvalue->Query("DELETE FROM cart WHERE cart_user = $user_id");
				unset($_SESSION['cart']);
			}
			catch(Exception $e) {
				throw new Exception("ERROR");
			}
			$pgvalue->DisconnectServer();
			$pgselect->DisconnectServer();
			$pgsql->DisconnectServer();

			require "_libs/_meta.html";
			?>
			<div class="global-loading">
				<div class="loading">
					<img src="images/site/loading_logo.png">
					<div class="progress">
						<div class="indeterminate"></div>
					</div>
					<h4 class="orange-text text-darken-3">Compra finalizada com sucesso!</h4>
					<h5 class="orange-text text-darken-3">Informações da venda e um relatório serão enviado para seu e-mail nos próximos minutos!</h5>
				</div>
			</div>
			
			<?php
			include("PHPMailer/class.phpmailer.php");
			include("PHPMailer/class.smtp.php");
			session_start();
			$email = $_SESSION['email'];
			$nome = $_SESSION['name'];
			$pg = new PostgreSQL();
			$pg->ConnectServer();
			$pg->Query("SELECT * FROM orders WHERE order_id = $order_id");
			if($pg->NumRows()) {
				
				$mail = new PHPMailer(TRUE);
				$mail->IsSMTP();
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = TRUE;
				$mail->SMTPSecure = 'ssl';
				$mail->Port = 465;
				$mail->Username = 'symphlower@gmail.com';
				$mail->Password = 'omelhortrabalhodomundo123';
				$mail->SetFrom("symphlower@gmail.com", "Symphlower");
				$mail->AddAddress($email, $nome);
				$mail->AddAddress($email);
				$info = $pg->FetchArray();
				$pg->DisconnectServer();
				$order_date = $info['order_date'];
				$pg->ConnectSharedServer();
				$end = $_SESSION['address'];
				$pg->Query("SELECT * FROM endereco WHERE id_endereco = $end");
				$end = $pg->FetchArray();
				$rua = $end['endereco'];
				$bairro = $end['bairro'];
				$numero = $end['numero'];
				$cidade = $end['cidade'];
				$cep = $end['cep'];

				

				//$mail->AddAddress($nome);

				$email_body = "
				
				<center><img src='http://200.145.153.175/gabrielgoncalves/images/site/loading_logo.png'></center>
				<div class=\"col s2 right\">
                    <div class=\"row\"></div>
                    <a href=\"http://200.145.153.175/gabrielgoncalves/order_pdf.php?order_id=$order_id\" class=\"waves-effect waves-light red btn-floating\">
                        <i class=\"material-icons\">picture_as_pdf</i>
                    </a>
                </div>
				<fieldset style=\"background-color: lightgrey;\">
					<h3 class=\"\" style=\"color: #ef6c00;\"><b>Informações do Pedido:<p>
							<span style='color: #000;'> 0-000$order_id</span></b></h3>
					<span style='color: #000;'><b>Pedido realizado em:</b> $order_date</span>
				</fieldset>
				<br>
				<fieldset style=\"background-color: lightgrey;\">
					<h3 class=\"\" style=\"color: #ef6c00;\"><b>Dados do pedido:<br>
							<span style='color: #000;'><b>Data do pedido: </b>$order_date </span><br>
							<span style='color: #000;'><b>Forma de pagamento: </b>Á vista.</span><br>
							<span style='color: #000;'><b>Status do pedido: </b>Entregue.</span><br>
				</fieldset>
				<br>
				<fieldset style=\"background-color: lightgrey;\">
					<h6 style=\"color: #ef6c00;\">Dados da entrega:</h6>
					<span><b>Endereço: </b>$rua, $numero</span>
					<span><b>Bairro: </b>$bairro</span>
					<span><b>Cidade: </b>$cidade</span>
					<span><b>CEP: </b>$cep</span>
				</fieldset>
				<br>
				<fieldset style=\"background-color: lightgrey;\">
					<h6 style=\"color: #ef6c00;\">ConteÃºdo do produto:</h6>
				</fieldset>"
?>
				<?php
				

				//$mail->IsMail();// Define que o e-mail serÃ¡ enviado como HTML
				$mail->CharSet = 'utf-8'; 
				$mail->IsHTML(TRUE);

				$mail->Subject = "Compra finalizada com sucesso!";
				$mail->Body = "$email_body";
				$mail->AltBody = "Este email é para lhe informar sobre os dados de uma compra efetuada em nossa loja, em caso de dúvidas entre em contato conosco.";


				// Envia o e-mail

				$enviado = $mail->Send();
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
			}
			header("Refresh:3; url=index.php");
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
					<h4 class="orange-text text-darken-3">Ocorreu algum erro para finalizar o procedimento!</h4>
					<h5 class="orange-text text-darken-3">Entre em contato conosco e tente novamente.</h5>
				</div>
			</div>
			<?php
			header("Refresh:3; url=finish_order.php");
		}
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
				<h4 class="orange-text text-darken-3">VocÃª deve estar logado para finalizar uma compra.</h4>
				<h5 class="orange-text text-darken-3">Entre em sua conta e tente novamente.</h5>
			</div>
		</div>
		<?php
		header("Refresh:2; url=login.php");
	}
?>