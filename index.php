<?php
	session_start();
	require "_libs/_postgresql.php";
	require "_libs/_topside.php";
	if(isset($_GET['cart_action'])) {
		?>
		<script>window.location.href = 'index.php'</script>
		<?php
	}
?>
<div class="parallax-container hide-on-med-and-down">
	<div class="parallax"><img src="images/site/index_banner2.jpg"></div>
</div>
<div class="row">
	<div class="col l12 center">
		<div id="title-content">
			<h1 class="orange-text text-darken-2">SIMPATIA E DELICADEZA EM CADA PÉTALA</h1>
			<a href="catalog_products.php" class="waves-effect waves-light orange darken-2  btn-large">IR PARA A
			                                                                                           LOJA</a>
			<h4 class="orange-text text-darken-2">FLORES PARA QUALQUER OCASIÃO</h4>
		</div>
	</div>
</div>
<div class="parallax-container hide-on-med-and-down">
	<div class="parallax"><img src="images/site/index_banner2.jpg"></div>
</div>
<div class="row container">
	<div class="row"></div>
	<div class="col l12">
	</div>
</div>
<?php
	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM product WHERE product_id = 49");
	$cacto = $pg->FetchArray();
	$pg->Query("SELECT * FROM product WHERE product_id = 44");
	$kalanchoe = $pg->FetchArray();
	$pg->Query("SELECT * FROM product WHERE product_id = 47");
	$violeta = $pg->FetchArray();
	$pg->DisconnectServer();
	$pg = NULL;
?>
<div class="row">
	<div class="col l12">
		<div class="content container">
			<div class="col s4 l4 m4">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="<?php echo $cacto['product_image'] ?>">
					</div>
					<div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4"><?php echo $cacto['product_name']?><i
		                                        class="material-icons right">more_vert</i></span>
						<p><a class="orange-text darken-3" href="details_product.php?product_id=<?php echo $cacto['product_id']?>">IR PARA A LOJA</a></p>
					</div>
					<div class="card-reveal">
                                        <span class="card-title orange-text text-darken-3"><?php echo $cacto['product_name'] ?><i
		                                        class="material-icons right">close</i></span>
						<p><?php echo $cacto['product_description']?></p>
					</div>
				</div>
			</div>
			<div class="col s4 l4 m4">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="<?php echo $kalanchoe['product_image'] ?>">
					</div>
					<div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4"><?php echo $kalanchoe['product_name']?><i
		                                        class="material-icons right">more_vert</i></span>
						<p><a class="orange-text darken-3" href="details_product.php?product_id=<?php echo $kalanchoe['product_id']?>">IR PARA A LOJA</a></p>
					</div>
					<div class="card-reveal">
                                        <span class="card-title orange-text text-darken-3"><?php echo $kalanchoe['product_name'] ?><i
		                                        class="material-icons right">close</i></span>
						<p><?php echo $kalanchoe['product_description']?></p>
					</div>
				</div>
			</div>
			<div class="col s4 l4 m4">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="<?php echo $violeta['product_image'] ?>">
					</div>
					<div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4"><?php echo $violeta['product_name']?><i
		                                        class="material-icons right">more_vert</i></span>
						<p><a class="orange-text darken-3" href="details_product.php?product_id=<?php echo $violeta['product_id']?>">IR PARA A LOJA</a></p>
					</div>
					<div class="card-reveal">
                                        <span class="card-title orange-text text-darken-3"><?php echo $violeta['product_name'] ?><i
		                                        class="material-icons right">close</i></span>
						<p><?php echo $violeta['product_description']?></p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="parallax-container hide-on-med-and-down">
	<div class="parallax"><img src="images/site/index_banner2.jpg"></div>
</div>
<div class="row"></div>
<div class="row"></div>
<div class="row">
	<div class="col l12">
		<div class="content container">
			<div class="col l7">
				<iframe width="500" height="281" src="https://www.youtube.com/embed/9vNYDgrUx54"
					frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="col l5">
				<div class="card-panel teal orange darken-3">
					<span class="white-text">As hortências são flores delicadas e sensível as estações do ano, sendo assim precisam de cuidados especiais. Se quiser saber como cuidar das hortênsias e desfrutar de sua beleza, assista o video a cima.</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row"></div>
<?php
	require "_libs/_footer.php";
?>

