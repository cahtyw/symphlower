<?php
	require "_libs/_postgresql.php";
	require "_libs/_topside.php";


	if(isset($_GET['cart_action'])){
		if(isset($_GET['buy']) && $_GET['buy']){
			?>
			<script>window.location.href = 'finish_order.php'</script>
			<?php
		}
		$id = $_GET['code'];
		?>
		<script>window.location.href = 'details_product.php?product_id=<?php echo $id ?>'</script>
		<?php
	}
	$product_id = $_GET['product_id'];
	$pgsql = new PostgreSQL();
	$pgsql->ConnectServer();
	$pgsql->Query("SELECT * FROM product WHERE product_id = $product_id");
	$content = $pgsql->FetchArray();
	$user_id = $_SESSION['user_id'];
?>
	<br>
	<div class="container">
		<div class="row z-depth-1">
			<div class="col s12">
				<h5 class="text-darken-2 grey-text">
					<b>Produto: </b><?php echo($content['product_name'] . " (FL-" . $content['product_id'] . ")") ?>
				</h5>
			</div>
		</div>
		<div class="row z-depth-1">
			<br>
			<div class="col s7" id="product_image">
				<br>
				<br>
				<img class="materialboxed" width="350px" src="<?php echo $content['product_image'] ?>">
			</div>
			<div class="col s5 center-align">
				<div class="row">
					<div class="col s12 left-align">
						<h5 class="<?php echo($content['product_stock'] ? "green-text" : "red-text") ?>">
							<i class="material-icons small left"><?php echo($content['product_stock'] ? "check" : "close") ?></i>
							<?php echo($content['product_stock'] ? "Imediata, em estoque!" : "Indisponível no estoque"); ?>
						</h5>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<?php
							if($content['product_stock']) {
								if(!isset($_SESSION['cart'][$product_id])) {
									?>
									<a class="btn waves-light waves-effect orange darken-3"
										href="details_product.php?product_id=<?php echo $content['product_id'] ?>&cart_action=add&code=<?php echo $content['product_id'] ?>">
										<i class="material-icons left">add_shopping_cart</i>
										Adicionar ao carrinho
									</a>
									<?php
								}
								else {
									?>
									<a class="btn waves-light waves-effect red darken-3"
										href="details_product.php?product_id=<?php echo $content['product_id'] ?>&cart_action=del&code=<?php echo $content['product_id'] ?>">
										<i class="material-icons left">close</i>
										Remover do carrinho
									</a>
									<?php
								}
							}
							else {
								?>
								<a class="btn waves-light waves-effect grey darken-3" onclick="swal('Feito!', 'Você será avisado assim que o produto der entrada no estoque de nossa loja!', 'success');" href="javascript:;">
									<i class="material-icons left">mail</i>
									Avise-me quando chegar
								</a>
								<?php
							}
						?>
					</div>
				</div>
				<div class="divider"></div>
				<div class="row">
					<div class="col s12">
						<?php
							$valor = $content['product_salevalue'] * 1.2456;
							$valor = number_format($valor, 2, ',', '');
						?>
						<h5 class=""><b>De R$<?php echo($valor) ?> por</b></h5>
						<h4 class="orange-text text-darken-3">
							<b>R$<?php echo number_format($content['product_salevalue'], '2', ',', '') ?></b> à
							                                                                                  vista
							                                                                                  no
							                                                                                  boleto
							                                                                                  presencial
						</h4>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<a href="details_product.php?product_id=<?php echo $content['product_id'] ?>&cart_action=add&code=<?php echo $content['product_id']?>&buy=true" class="btn-large orange darken-3 waves-effect waves-light" <?php echo($content['product_stock'] ? "" : "disabled") ?>><i
								class="material-icons left">shopping_cart</i>COMPRAR</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<ul class="collapsible" data-collapsible="expandable">
				<li>
					<div class="collapsible-header active"><i class="material-icons">info</i>Descrição</div>
					<div class="collapsible-body"><span><?php echo $content['product_description'] ?></span></div>
				</li>
				<li>
					<div class="collapsible-header"><i class="material-icons">dehaze</i>Especificações do Produto</div>
					<div class="collapsible-body"><span><b>Cor: </b><?php echo $content['product_color'] ?></span></div>
				</li>
			</ul>
		</div>
	</div>
<?php
	require "_libs/_footer.php";
?>