<?php
	session_start();
	require "_libs/_postgresql.php";
	if(isset($_SESSION['login'])) {
	require "_libs/_topside.php";
?>
<div class="container">
	<div class="row"></div>
	<div class="row"></div>
	<?php
		$pgsql = new PostgreSQL();
		$pgsql->ConnectServer();
		$user_id = $_SESSION['user_id'];
		$pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id");
		if($pgsql->NumRows()) {
			?>
			<div class="row">
				<div class="col s7">
					<h4>Finalizar pedido</h4>
					<h6>Verifique os produtos selecionados e clique no botão para seguir com a compra.</h6>
				</div>
				<div class="col s5 right">
					<br>
					<br>
					<a href="catalog_products.php" class="btn-large waves-light waves-effect right orange darken-3">
						<i class="material-icons left">arrow_back</i>
						Continuar comprando
					</a>
				</div>
			</div>
		<br>
			<div class="divider"></div>
			<div class="row"></div>
			<table class="highlight">
				<thead>
					<tr>
						<th>Foto</th>
						<th>Nome</th>
						<th>Quantidade</th>
						<th>Preço</th>
						<th>Sub-total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$pgselect = new PostgreSQL();
						$pgselect->ConnectServer();
						$total2 = 0;
						$total = 0;
						while($line = $pgsql->FetchArray()) {
							$product_id = $line['cart_product'];
							$pgselect->Query("SELECT * FROM product WHERE product_id = $product_id");
							$line2 = $pgselect->FetchArray();
							$price = $line2['product_salevalue'];
							$price = number_format($price, 2, ',', '');
							$sub_total = $line2['product_salevalue'] * $line['cart_amount'];
							$total += $sub_total;
							$sub_total = number_format($sub_total, 2, ',', '');

							$total2++;
							?>
							<tr>
								<td class="product_image">
									<div class="material-placeholder">
										<img width="100px" src="<?php echo $line2['product_image'] ?>" class="">
									</div>
								</td>
								<td><?php echo $line2['product_name'] ?></td>
								<td><?php echo $line['cart_amount'] ?></td>
								<td>R$<?php echo $price ?></td>
								<td>R$<?php echo $sub_total ?></td>
							</tr>
							<?php
						}
						$total = number_format($total, 2, ',', '');
					?>
				</tbody>
			</table>
			<div class="divider"></div>
			<div class="row">
				<div class="col l6">
					<br>
					<br>
					<br>
					<div class="input-field l8">
						<select id="end">
							<?php
								$pgend = new PostgreSQL();
								$pgend->ConnectSharedServer();
								$pgend->Query("SELECT * FROM endereco WHERE id_usuario = $user_id");
								while($end = $pgend->FetchArray()) {
									?>
									<option value=""><?php echo($end['endereco'] . ", " . $end['numero'] . " - " . $end['bairro'] . " - " . $end['cidade'] . ", " . $end['estado']); ?></option>
									<?php
								}
							?>
						</select>
						<label for="end">Endereço para entrega:</label>
					</div>
				</div>
			</div>
			<div class="row">
				<br>
				<div class="col l9">
					<h5><b>Total:</b> R$<?php echo $total ?></h5>
				</div>
				<div class="col l3 right">
					<a href="finish_order_confirm.php" class="btn-flat waves-effect waves-light">
						<i class="material-icons left">check</i>
						Finalizar Compra
					</a>
				</div>
			</div>
			<?php
		if($total2 < 4) {
		for($i = 0;
		    $i < $total2;
		    $i++) {
			?>
		<br>
		<?php
			}
			}
			}
			else {
		?>
			<script>alert("Nenhum produto foi encontrado no carrinho de compras");</script>
		<meta HTTP-EQUIV='refresh' CONTENT='0;URL=catalog_products.php'>
			<?php
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
					<h4 class="orange-text text-darken-3">Você deve estar logado para finalizar uma compra.</h4>
					<h5 class="orange-text text-darken-3">Entre em sua conta e tente novamente.</h5>
				</div>
			</div>
			<?php
			header("Refresh:2; url=login.php");
		}

	?>
</div>
<?php
	$pgselect->DisconnectServer();
	$pgsql->DisconnectServer();
	require "_libs/_footer.php";
?>
