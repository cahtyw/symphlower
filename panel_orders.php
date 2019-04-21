<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";

	if(isset($_GET['act'])) {
		$pg = new PostgreSQL();
		$pg->ConnectServer();
		$order_id = $_GET['order_id'];
		switch($_GET['act']) {
			case "delete":
				try {
					$pg->Query("UPDATE orders SET order_active = FALSE WHERE order_id = $order_id");
				}
				catch(Exception $e) {
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
					$pg->Query("UPDATE orders SET order_active = FALSE WHERE order_id = $order_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
				}
				break;
			case "reset":
				try {
					$pg->Query("UPDATE orders SET order_active = TRUE WHERE order_id = $order_id");
				}
				catch(Exception $e) {
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
					$pg->Query("UPDATE orders SET order_active = TRUE WHERE order_id = $order_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
				}
				break;
			case "edit":
				break;
		}
		$pg->DisconnectServer();
		$pg = NULL;
		?>
		<script>window.location.href = "panel_orders.php"</script>
		<?php
	}

	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM orders ORDER BY order_id");
	$order_amount = $pg->NumRows();
	$pg->DisconnectServer();
	$pg = NULL;
?>
	<!--In�cio do conte�do da p�gina-->
	<script src="js/sorttable.js"></script>
	<div class="container">
		<div class="row">
			<div class="col s8">
				<div class="col s12">
					<h4>Listagem de Pedidos</h4>
					<h5>(<?php echo $order_amount ?> pedidos cadastrados encontrados)</h5>
				</div>
				<div class="col s12">
					<h6>Aqui voc&ecirc pode visualizar todos os pedidos e cadastrar novos.</h6>
				</div>
			</div>
			<!--Início da pesquisa-->
			<div class="col s4">
				<br>
				<br>
				<div class="row input-field">
					<form action="panel_orders.php" method="get">
						<div class="col s8">
							<input name="sr" value="<?php echo((isset($_GET['sr'])) ? $_GET['sr'] : '') ?>" type="text" id="search_bar" required>
							<label for="search_bar">Pesquisar</label>
						</div>
						<div class="col s2">
							<button class="btn-flat tooltipped large waves-effect waves-light" type="submit" data-delay="5" data-tooltip="Pesquisar">
								<i class="material-icons">search</i>
							</button>
						</div>
						<div class="col s2">
							<a class="btn-flat tooltipped large waves-effect waves-light" onclick="window.location.href = 'panel_orders.php';" data-delay="5" data-tooltip="Limpar filtro">
								<i class="material-icons">close</i>
							</a>
						</div>
					</form>
				</div>
			</div>
			<!--Fim da pesquisa-->
		</div>
		<div class="row">
			<table class="striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome e sobrenome</th>
						<th>Data e hora</th>
						<th>ID de endere&ccedilo</th>
						<th>Pre&ccedilo total</th>
						<th>A &ccedil&otildees</th>
					</tr>
				</thead>
				<tbody>
					<!--<tr>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>
							<a href="#modal" class="btn-floating green modal-trigger waves-effect waves-light tooltipped" data-tooltip="Adicionar Novo" data-position="bottom" data-delay="10">
								<i class="material-icons">add</i>
							</a>
						</td>
					</tr>-->
					<?php
                        $total_reg = 15;
						$pg = new PostgreSQL();
						$pg->ConnectServer();
						$pg->Query("SELECT * FROM orders ORDER BY order_id");

						if($pg->NumRows()) {
                            $pgorder = new PostgreSQL();
                            $pgbuy = new PostgreSQL();
                            $pgname = new PostgreSQL();
                            $psql = new PostgreSQL();
                            $psql->ConnectServer();
                            $psql->Query("SELECT * FROM orders ORDER BY order_id");
                            $pagina = $_GET['pagina'];
                            if (!$pagina) {
                                $pc = "1";
                            } else {
                                $pc = $pagina;
                            }
                            $inicio = $pc - 1;
                            $inicio = $inicio * $total_reg;

                            $limite = new PostgreSQL();
                            $limite->ConnectServer();
                            $limite->Query("SELECT * FROM orders LIMIT  $total_reg OFFSET  $inicio");
                            $tr = $psql->NumRows();
                            $tp = $tr / $total_reg;
							while($order = $limite->FetchArray()) {
								$teste = false;
								$user_id = $order['order_user'];
								$order_id = $order['order_id'];
								if(isset($_GET['sr'])) {
									$search = strtolower($_GET['sr']);
									$pgname->ConnectSharedServer();
									$pgname->Query("SELECT * FROM cliente WHERE (LOWER(nome) LIKE '%$search%' OR LOWER(sobrenome) LIKE '%$search%') AND id_usuario = $user_id");
									if($pgname->NumRows()) {
										$teste = true;
									}
									$pgname->DisconnectServer();
								}
								else{
									$teste = true;
								}

								if($teste) {
									?>
									<tr class="<?php echo(($order['order_active'] == 'f') ? 'black-text red accent-1' : '') ?>">
										<th width="">
											<!--<a data-tooltip="Ver tudo" data-position="bottom" data-delay="30" class="new-page <?php /*echo(($me) ? 'red-text' : 'black-text') */ ?> tooltipped" onclick="window.open('panel_users_details.php?user_id=<?php /*echo $usuario["id_usuario"] */ ?>', 'newwindow', 'width=650,height=700'); return false;" href='panel_users_details.php?user_id=<?php /*echo $usuario["id_usuario"] */ ?>'>-->
											<?php echo $order['order_id'] ?>
											<!--</a>-->
										</th>
										<td>
											<?php
												$pgname->ConnectSharedServer();
												$pgname->Query("SELECT * FROM cliente WHERE id_usuario = $user_id");
												$name = $pgname->FetchArray();
												echo($name['nome'] . " " . $name['sobrenome']);
												$pgname->DisconnectServer();
											?>
										</td>
										<td>
											<?php echo $order['order_date'] ?>
										</td>
										<td>
											<?php echo $order['order_address'] ?>
										</td>
										<td width="">
											R$
											<?php
												$pgtotal = new PostgreSQL();
												$pgtotal->ConnectServer();
												$pgtotal->Query("SELECT item_total FROM items WHERE item_order = $order_id");
												$total_item = 0;
												while($ptotal = $pgtotal->FetchArray()) {
													$total_item += $ptotal['item_total'];
												}
												$total_item = number_format($total_item, '2', ',', '');
												$pgtotal->DisconnectServer();
												echo $total_item;
											?>
										</td>
										<td>
											<?php
												if($order['order_active'] == 't') {
													?>
													<a href="javascript:;" onclick="deleteOrder(<?php echo $order_id ?>)" class="btn-floating red darken-3 waves-effect waves-light tooltipped" data-tooltip="Excluir" data-position="bottom" data-delay="30">
														<i class="material-icons">close</i>
													</a>
													<?php
												}
												else {
													?>
													<a href="javascript:;" onclick="resetOrder(<?php echo $order_id ?>)" class="btn-floating green waves-effect waves-light tooltipped" data-tooltip="Restaurar" data-position="bottom" data-delay="30">
														<i class="material-icons">check</i>
													</a>
													<?php
												}
											?>
											<?php
											?>
										</td>
									</tr>
									<?php
								}
							}
                            $anterior =  $pc - 1;
                            $proximo = $pc +1;
                            if($pc > 1)
                            {

                                echo "<a href='?pagina=$anterior'><- Anterior</a>";

                            }
                            echo "|";
                            if($pc<$tp)
                            {

                                echo "<a href='?pagina=$proximo''> Proxima -></a>";

                            }
						}
					?>
				</tbody>
			</table>
			<div class="row">
				<div class="col l12 center">
					<ul class="pagination">
						<li class="waves-effect"><a
								href="catalog_products.php?page=1"><i
									class="material-icons">chevron_left</i></a>
						</li>
						<?php
							//$page = $_GET['page'];
							for($i = 1; $i < $total + 1; $i++) {
								?>
								<li class="<?php echo(($page == $i) ? 'active disable orange darken-3' : 'waves-effect'); ?>">
									<a href="catalog_products.php?page=<?php echo $i ?>"><?php echo $i ?></a>
								</li>
								<?php
							}
						?>
						<li class="waves-effect"><a
								href="catalog_products.php?page=<?php echo $total ?>"><i
									class="material-icons">chevron_right</i></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--Fim do conte�do-->
<?php
	$pg->DisconnectServer();
	require "_libs/_footeradm.php";
?>