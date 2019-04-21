<?php
	session_start();
	if(!isset($_SESSION['login'])) {
		require "_libs/_meta.html";
		?>
		<div class="global-loading">
			<div class="loading">
				<img src="images/site/loading_logo.png">
				<div class="progress">
					<div class="indeterminate"></div>
				</div>
				<h4 class="orange-text text-darken-3">Você deve estar logado para continuar.</h4>
				<h5 class="orange-text text-darken-3">Redirecionando para a página de login...</h5>
			</div>
		</div>
		<?php
		header("Refresh:2; url=login.php");
	}
	else {
		require "_libs/_postgresql.php";
		require "_libs/_topside.php";
		?>
		<!--<script>
			$('.new-page').click(function(){
			   $.get('order_details.php', {
			       url: $(this).attr('href')
			   });
			});
		</script>-->
		<div class="container">
			<br>
			<h4>Meus pedidos</h4>
			<h6>Você pode clicar no número do pedido para obter mais informações.</h6>
			<div class="divider"></div>
			<div class="row"></div>
			<div class="row">
				<div class="col s12">
					<table class="highlight">
						<thead>
							<tr>
								<th>N° Pedido</th>
								<th>Data e Hora</th>
								<th>Valor total</th>
								<th>Pagamento</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$user_id = $_SESSION['user_id'];
								$pgsql = new PostgreSQL();
								$total = 0;
								$pgsql->ConnectServer();
								$pgsql->Query("SELECT * FROM orders WHERE order_user = $user_id AND order_active = TRUE ORDER BY order_date");
								$pgcalc = new PostgreSQL();
								$pgcalc->ConnectServer();
								if($pgsql->NumRows()) {
									while($order = $pgsql->FetchArray()) {
										?>
										<tr>
											<th>
												<a class="new-page" onclick="window.open('order_details.php?order_id=<?php echo $order["order_id"] ?>', 'newwindow', 'width=650,height=700'); return false;" href="order_details?order_id=<?php echo $order['order_id'] ?>">
													0-000<?php
														echo(($order['order_id'] > 9) ? (($order['order_id'] > 99) ? "0" : "00") : "000");
														echo $order['order_id'];
														$order_id = $order['order_id']
													?>
												</a>
											</th>
											<td><?php echo $order['order_date'] ?></td>
											<td>
												R$
												<?php
													$pgcalc->Query("SELECT item_total FROM items WHERE item_order = $order_id");
													$price = 0;
													while($calc = $pgcalc->FetchArray()) {
														$price += $calc['item_total'];
													}
													$price = number_format($price, 2, ',', '');
													echo $price;
												?>
											</td>
											<td>À vista</td>
											<td>Entregue</td>
										</tr>
										<?php
										$total++;
									}
								}
								else {
									?>
									<tr>
										<th>-</th>
										<td>Nenhum pedido foi encontrado</td>
										<td>-</td>
										<td>-</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					<div class="divider"></div>
					<br>
					<br>
				</div>
			</div>
		</div>
		<?php
		if($total < 5) {
			for($i = 0; $i < $total; $i++) {
				?>
				<div class="row"></div>
				<?php
			}
		}
	}
	$pgcalc->DisconnectServer();
	$pgsql->DisconnectServer();
	require "_libs/_footer.php";
?>