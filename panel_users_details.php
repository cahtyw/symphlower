<?php
	session_start();
	require "_libs/_postgresql.php";
	$user_id = $_GET['user_id'];
	$pguser = new PostgreSQL();
	$pgclient = new PostgreSQL();
	$pgend = new PostgreSQL();
	$pgorder = new PostgreSQL();
	$pgitems = new PostgreSQL();
	$pgprod = new PostgreSQL();
	$pguser->ConnectSharedServer();
	$pgclient->ConnectSharedServer();
	$pguser->Query("SELECT * FROM usuario WHERE id_usuario = $user_id");
	$pgclient->Query("SELECT * FROM cliente WHERE id_usuario = $user_id");
	$user = $pguser->FetchArray();
	$client = $pgclient->FetchArray();
	$pguser->DisconnectServer();
	$pgclient->DisconnectServer();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="images/site/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="images/site/favicon.ico" type="image/x-icon"/>
		<!--Não mexer-->
		<title>symphlower</title>
		<link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script type="application/javascript" src="js/custom.js"></script>
	</head>
</html>
<body>
	<div class="">
		<fieldset>
			<div class="row">
				<div class="col s10 left">
					<img src="images/site/logo.png">
				</div>
				<div class="col s2 right">
					<div class="row"></div>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col s12">
					<h4>Informações do cliente</h4>
					<span><b>ID: </b><?php echo $user_id ?></span><br>
					<span><b>Nome: </b><?php echo $client['nome'] . " " . $client['sobrenome'] ?></span><br>
					<span><b>CPF: </b><?php echo $user_id ?></span><br>
					<span><b>Sexo: </b><?php echo(($client['sexo'] == 'm') ? 'Masculino' : "Feminino") ?></span><br>
					<span><b>Data de nascimento: </b><?php echo $client['data_nasc'] ?></span><br>
					<span><b>Telefone: </b><?php echo $client['telefone'] ?></span><br>
					<span><b>Celular: </b><?php echo $client['celular'] ?></span><br>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col s12">
					<h4>Informações de usuário</h4>
					<span><b>Login: </b><?php echo $user['login'] ?></span><br>
					<span><b>Login: </b><?php echo $user['email'] ?></span><br>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col s12">
					<h4>Informações de endereco</h4>
					<?php
						$pgend->ConnectSharedServer();
						$pgend->Query("SELECT * FROM endereco WHERE id_usuario = $user_id");
						while($end = $pgend->FetchArray()) {
							?>
							<span><b>ID: </b><?php echo $end['id_endereco'] ?></span><br>
							<span><b>Endereco: </b><?php echo $end['endereco'] ?></span><br>
							<span><b>Número: </b><?php echo $end['numero'] ?></span><br>
							<span><b>Complemento: </b><?php echo $end['complemento'] ?></span><br>
							<span><b>Bairro: </b><?php echo $end['bairro'] ?></span><br>
							<span><b>CEP: </b><?php echo $end['CEP'] ?></span><br>
							<span><b>Cidade: </b><?php echo $end['cidade'] ?></span><br>
							<span><b>Estado: </b><?php echo $end['estado'] ?></span><br>
							<span><b>País: </b><?php echo $end['pais'] ?></span><br>
							<br>
							<?php
						}
						$pgend->DisconnectServer();
					?>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col s12">
					<h4>Informações de pedidos</h4>
					<?php
						$pgorder->ConnectServer();
						$pgorder->Query("SELECT * FROM orders WHERE order_user = $user_id AND order_active = TRUE");
						if($pgorder->NumRows()) {
							$pgitems->ConnectServer();
							$pgprod->ConnectServer();
							while($orders = $pgorder->FetchArray()) {
								?>
								<span><b>ID do pedido: </b><?php echo $orders['order_id'] ?></span><br>
								<span><b>Data: </b><?php echo $orders['order_date'] ?></span><br>
								<span><b>ID do endereco: </b><?php echo $orders['order_address'] ?></span><br>
								<h5>Itens comprados:</h5>
								<?php
								$order_id = $orders['order_id'];
								$pgitems->Query("SELECT * FROM items WHERE item_order = $order_id");
								while($items = $pgitems->FetchArray()) {
									$prod_id = $items['item_product'];
									$pgprod->Query("SELECT * FROM product WHERE product_id = $prod_id");
									$prod = $pgprod->FetchArray();
									?>
									<span><b>Produto: </b><?php echo $prod['product_name'] ?></span><br>
									<span><b>Cor: </b><?php echo $prod['product_color'] ?></span><br>
									<span><b>Valor unt.: </b><?php echo $prod['product_salevalue'] ?></span><br>
									<span><b>Qtde: </b><?php echo $items['item_amount'] ?></span><br>
									<span><b>Valor total: </b><?php echo $item['item_total'] ?></span><br>
									<br>
									<?php
								}
							}
						}
						$pgorder->DisconnectServer();
						$pgitems->DisconnectServer();
						$pgprod->DisconnectServer();
					?>
				</div>
			</div>
		</fieldset>
	</div>
</body>