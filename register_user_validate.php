<?php
	require "_libs/_postgresql.php";
	require "_libs/_meta.html";



	$user_name = strtolower($_POST['user_name']);
	$user_password = md5($_POST['user_password']);


	//$client_prefix = $_POST['client_prefix'];
	$client_firstname = $_POST['client_firstname'];
	$client_lastname = $_POST['client_lastname'];
	$client_email = strtolower($_POST['client_email']);
	$client_phone = $_POST['client_phone'];
	$client_cpf = $_POST['client_cpf'];
	$client_born = $_POST['client_born'];
	$new_date = date("d-m-y", strtotime($client_born));

	$client_sex = $_POST['client_sex'];
	$client_cellphone = $_POST['client_cellphone'];

	$address_postcode = $_POST['address_postcode'];
	$address_street = $_POST['address_street'];
	$address_number = $_POST['address_number'];
	$address_complement = $_POST['address_complement'];
	$address_neiborhood = $_POST['address_neiborhood'];
	$address_city = $_POST['address_city'];
	$address_state = $_POST['address_state'];
	$address_country = $_POST['address_country'];

	//$address = $address_street.", ".$address_neiborhood." - ".$address_postcode;

	$active = 'n';
	$pgsql = new PostgreSQL();
	$pgsql->ConnectSharedServer();

	$pgsql->Query("INSERT INTO usuario VALUES(DEFAULT, '$user_name', '$client_email', '$user_password', '$active')");
	$pgsql->Query("SELECT * FROM usuario WHERE login = '$user_name'");
	$line = $pgsql->FetchArray();
	$user_id = $line['id_usuario'];
	$pgsql->Query("INSERT INTO cliente VALUES($user_id, '$client_firstname' , '$client_lastname', '$client_cpf', '$client_sex', '$new_date', '$client_phone', '$client_cellphone', '$active')");
	//echo ("INSERT INTO cliente VALUES($user_id, '$client_firstname' , '$client_lastname', '$client_cpf', '$client_sex', '$client_born', '$client_phone', '$client_cellphone', '$active')");
    $pgsql->Query("INSERT INTO endereco VALUES(DEFAULT, $user_id, '$address_street', '$address_number', '$address_complement', '$address_neiborhood', '$address_postcode', '$address_city', '$address_state', '$address_country', '$active')");
	$pgsql->DisconnectServer();
	$pgsql->ConnectServer();
	$pgsql->Query("INSERT INTO users VALUES($user_id, 1)");
	$pgsql->DisconnectServer();
	/*$pgsql->Query("SELECT client_id FROM client WHERE client_userid = $user_id");
	$line = $pgsql->FetchArray();
	$client_id = $line['client_id'];

	$pgsql->Query("INSERT INTO address VALUES($client_id, '$address_postcode', '$address_street', '$address_number', '$address_complement', '$address_neiborhood', '$address_city',  '$address_state', '$address_country')");*/
?>
	<br>
	<br>
	<br>
	<br>
	<div class="global-loading">
		<div class="loading">
            <img src="images/site/loading_logo.png">
			<div class="progress">
				<div class="indeterminate"></div>
			</div>
			<h4 class="orange-text text-darken-3">Cadastro efetuado com sucesso...</h4>
		</div>
	</div>
<?php

	//echo("<script>alert(\"Usuário registrado.\")</script>");
	header("Refresh:1; url=login.php");
?>