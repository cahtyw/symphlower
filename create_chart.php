<?php
	session_start();
	require "_libs/_postgresql.php";
	$graphic_id = $_GET['gr'];
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
					<?php
						switch($graphic_id){
							case 0:
								require "_libs/_clientes-por-genero.php";
								break;
							case 1:
								require "_libs/_pedidos-por-data.php";
								break;
							case 2:
								require "_libs/_produto-por-quantidade.php";
								break;
						}
					?>
				</div>
			</div>
		</fieldset>
	</div>
</body>