<?php
	require "_libs/_postgresql.php";
	require "_libs/_topside.php";

	$id_usuario = $_GET['id_usuario'];
	$pgsql = new PostgreSQL();
	$pgsql->ConnectSharedServer();
	$pgsql->Query("SELECT * FROM usuario WHERE id_usuario = $id_usuario");
	$content = $pgsql->FetchArray();
?>
	<!--VALIDAÇÃO-->
	<script src="js/validation/hideShowPassword.min.js"></script>
	<!--ESCONDER PASSWORD-->
	<script src="js/validation/jquery-password.js"></script>
	<!--CONSULTA-->
	<script type="text/javascript" src="js/ajax/ajax.js"></script>
	<hr>
	<div class="container">
		<div class="row">
			<div class="col s12 m4 l3 collection">
				<a href="registration_data.php?id_usuario=<?php echo $content['id_usuario'] ?>" class="collection-item"><i class="grey-text darken-3 material-icons left">account_box</i><b>Meus dados cadastrais</b></a>
			</div>
			<div class="col s12 m4 l3 collection">
				<a href="client_adress.php?id_usuario=<?php echo $content['id_usuario'] ?>" class="collection-item"><i class="grey-text darken-3 material-icons left">map</i><b>Meus endereços</b></a>
			</div>
			<div class="col s12 m4 l3 collection">
				<a href="client_access.php?id_usuario=<?php echo $content['id_usuario'] ?>" class="collection-item"><i class="grey-text darken-3 material-icons left">near_me</i><b>Meus dados de acesso</b></a>
			</div>
			<div class="col s12 m4 l3 collection">
				<a href="purchase_requests.php?id_usuario=<?php echo $content['id_usuario'] ?>" class="collection-item"><i class="grey-text darken-3 material-icons left">bookmark_border</i><b>Meus pedidos</b></a>
			</div>
			<div class="col s12 m4 l12 collection">
				<div class="row">
					<form action="" method="post" class="col s12 center">
						
						<script type='text/javascript'>alert('EM DESENVOLVIMENTO MEU AMIGÃO, VOLTE PARA SUAS COMPRINHAS!!! :)')</script>
                        <img src="images/site/loading_logo.png"/>
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
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=client_access.php?id_usuario=$id_usuario'>";
	}
?>