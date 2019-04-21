<?php
	session_start();
	//include "_postgresql.php";
	$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>symphlower - Em desenvolvimento...</title>
		<link rel="icon" href="images/site/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="images/site/favicon.ico" type="image/x-icon"/>
		<!--Não mexer-->
		<link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/custom.css"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.js"></script>
		<script type="text/javascript" src="js/initialize_materialize.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script type="text/javascript" src="js/sweetalert/sweetalert.js"></script>
	</head>
	<body>
		<div id="global-site">
			<nav class="navbar-fixed white">
				<div class="container nav-wrapper">
					<a href="index.php" class="brand-logo grey-text text-darken-1">
						<img src="images/site/logo.png">
					</a>
					<ul class="right hide-on-med-and-down">
						<li>
							<a href="#modal_search" class="modal-trigger grey-text text-darken-1" onClick="search()">
								<i class="material-icons left">search</i>
								Pesquisar
							</a>
						</li>
						<li><a href="index.php" class="grey-text text-darken-1">Página Inicial</a></li>
						<li><a href="catalog_products.php" class="grey-text text-darken-1">Produtos</a></li>
						<li><a href="about.php" class="grey-text text-darken-1">Sobre</a></li>
						<li><a href="feedback_index.php" class="grey-text text-darken-1">Contato</a></li>
						<li>
							<a href="#modal_cart" class="grey-text text-darken-1 modal-trigger">
								<i class="material-icons">shopping_cart</i>
							</a>
						</li>
						<li>
							<?php
								if($_SESSION['login']) {
									?>
									<a class="dropdown-button grey-text text-darken-1" data-beloworigin="true"
										data-activates="dropdown_profile">
										<i class="material-icons left">person</i>
										<?php echo "Olá, " . ($_SESSION['name']?:"[Usuário]") . "." ?>
										<i class="material-icons right">arrow_drop_down</i>
									</a>
									<ul id='dropdown_profile' class='dropdown-content'>
										<li>
											<a href="user_account.php?user_id=<?php echo $_SESSION['user_id'] ?>" class="grey-text text-darken-1">
												<i class="material-icons left">chevron_right</i>
												Minha Conta
											</a>
										</li>
										<li>
											<a href="orders.php" class="grey-text text-darken-1">
												<i class="material-icons left">chevron_right</i>
												Meu Histórico
											</a>
										</li>
										<!--<li>
											<a href="#" class="grey-text text-darken-1">
												<i class="material-icons left">chevron_right</i>
												Preferências
											</a>
										</li>-->
										<li>
											<a href="exit.php" class="grey-text text-darken-1">
												<i class="material-icons left">close</i>
												Sair
											</a>
										</li>
									</ul>
									<?php
								}
								else {
									?>
									<a href="login.php" class="grey-text text-darken-1">
										<i class="material-icons left">person</i>
										Iniciar Sessão
									</a>
									<?php
								}
							?>
						</li>
					</ul>
				</div>
			</nav>
			<div id="modal_search" class="modal">
				<div class="modal-content">
					<!--<h4>Barra de pesquisa</h4>-->
					<div class="row input-field">
						<br>
						<form action="catalog_products.php" method="get">
							<div class="col s9">
								<i class="material-icons prefix">search</i>
								<input name="search_bar" type="text" id="search_bar" required>
								<input type="hidden" value="2" name="filter_option">
								<label for="search_bar">Pesquisar</label>
							</div>
							<div class="col s3">
								<button class="btn small orange darken-3 waves-effect waves-light" type="submit">
									<i class="material-icons left">send</i>Buscar
								</button>
							</div>
						</form>
					</div>
					<h6 class="text-darken-3 orange-text right">*Clique fora do retângulo para desistir da pesquisa</h6>
				</div>
			</div>
			<div id="modal_cart" class="modal modal-fixed-footer">
				<div class="modal-content">
					<div class="content">
						<?php
							//require "cart.php";
							if(!isset($_SESSION['cart'])) {
								$_SESSION['cart'] = array();
							}

							if(isset($_GET['cart_action'])) {
								//Função Adicionar no carrinho
								if($_GET['cart_action'] == 'add') {
									$product_id = intval($_GET['code']);
									if(isset($_SESSION['login'])) {
										$pgsql = new PostgreSQL();
										$pgsql->ConnectServer();
										$user_id = $_SESSION['user_id'];
										//$pgsql->Query("WITH cart AS(UPDATE cart SET cart_amount += 1 WHERE cart_user = $user_id AND cart_product = $product_id RETURNING) INSERT INTO cart VALUES($user_id, $product_id, 1)");
										//$pgsql->Query("IF NOT EXISTS (SELECT * FROM cart WHERE cart_user = $user_id AND cart_product = $product_id");
										$pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id AND cart_product = $product_id");
										if($pgsql->NumRows()) {
											$pgsql->Query("UPDATE cart SET cart_amount = (cart_amount + 1) WHERE cart_user = $user_id AND cart_product = $product_id");
										}
										else {
											$pgsql->Query("INSERT INTO cart VALUES($user_id, $product_id, 1)");
										}
										$pgsql->DisconnectServer();
										$pgsql = NULL;
									}

									//se o produto já foi selecionado no carrinho
									if(!isset($_SESSION['cart'][$product_id])) {
										$_SESSION['cart'][$product_id] = 1;

									}
									else {
										// add se existir
										$_SESSION['cart'][$product_id]++;
									}
								}

								if($_GET['cart_action'] == "plus") {
									$product_id = intval($_GET['code']);
									if(isset($_SESSION['login'])) {
										$pgsql = new PostgreSQL();
										$pgsql->ConnectServer();
										$pgsql->Query("UPDATE cart SET cart_amount = (cart_amount + 1) WHERE cart_user = $user_id AND cart_product = $product_id");
										$pgsql->DisconnectServer();
										$pgsql = NULL;
									}

									$_SESSION['cart'][$product_id]++;
								}

								if($_GET['cart_action'] == "remove") {
									$product_id = intval($_GET['code']);
									if(isset($_SESSION['login'])) {
										$pgsql = new PostgreSQL();
										$pgsql->ConnectServer();
										$pgsql->Query("UPDATE cart SET cart_amount = (cart_amount - 1) WHERE cart_user = $user_id AND cart_product = $product_id");
										$pgsql->DisconnectServer();
										$pgsql = NULL;
									}
									$_SESSION['cart'][$product_id]--;
								}


								// Função Excluir no carrinho
								if($_GET['cart_action'] == 'del') {
									$product_id = intval($_GET['code']);
									if(isset($_SESSION['cart'][$product_id])) {
										unset($_SESSION['cart'][$product_id]);
									}
									if(isset($_SESSION['login'])) {
										$pgsql = new PostgreSQL();
										$pgsql->ConnectServer();
										$user_id = $_SESSION['user_id'];
										$pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id AND cart_product = $product_id");
										if($pgsql->NumRows()) {
											$pgsql->Query("DELETE FROM cart WHERE cart_user = $user_id AND cart_product = $product_id");
										}
									}
								}
							}
						?>
						<h4 class="orange-text text-darken-3">
							<i class="material-icons">
								shopping_cart
							</i>
							Carrinho de Compras
							<a href="#!" class="right modal-action modal-close  waves-effect waves-light btn-flat">
								<i class="material-icons left">exit_to_app</i>
								Fechar
							</a>
						</h4>
						<?php
							$total = 0;
							if(count($_SESSION['cart']) == 0) {
								?>
								<div class="row">
									<div class="col l12">
										<h5 id="cart_info" class="center-align">
											<i class="material-icons large red-text">error</i>
											<br>
											<br>
											Nenhum produto encontrado no carrinho de compras.
										</h5>
									</div>
								</div>
							<?php
								}
								else {
							?>
								<table class="striped" id="cart">
									<thead>
										<tr>
											<th>Produto(s)</th>
											<th>Preço</th>
											<th>Quantidade</th>
											<th></th>
											<th>Subtotal</th>
											<th>Ação</th>
										</tr>
									</thead>
									<?php
										//require "_libs/_meta.html";
										$pgsql = new PostgreSQL();
										$pgsql->ConnectServer();
										$pgsql->Query("SELECT * FROM product WHERE product_active = TRUE AND product_stock != 0 ORDER BY product_name");
									?>
									<tbody>
										<?php
											//while ($linha = $pgsql->FetchArray()) {
											foreach($_SESSION['cart'] as $product_id => $qtd) {
												$pgsql->ConnectServer();
												$pgsql->Query("SELECT product_id, product_name, product_salevalue FROM product WHERE product_id = $product_id AND product_active = TRUE ORDER BY product_name");
												if($pgsql->NumRows()) {
													$linha = $pgsql->FetchArray();

													$id = $linha['product_id'];
													//formata para padrão brasileiro.

												}
												$pgselect = new PostgreSQL();
												$pgselect->ConnectServer();
												$pgselect->Query("SELECT product_id, product_salevalue, product_stock FROM product WHERE product_id = $id");
												$linha2 = $pgselect->FetchArray();
												$max_stock = $linha2['product_stock'];
												if(isset($_SESSION['login'])) {
													$pgselect->Query("SELECT cart_amount FROM cart WHERE cart_user = $user_id AND cart_product = $id");
													$line = $pgselect->FetchArray();
												}
												/* if($line['cart_amount'] == $i){ echo "selected";}*/
												/*for ($i = 1; $i <= $max_stock; $i++) {*/
												?>
												<tr data-stock="<?php echo $linha2['product_stock'] ?>" data-value="<?php echo $linha2['product_salevalue'] ?>" data-qtde="<?php echo $_SESSION['cart'][$linha2['product_id']]; ?>" data-id="<?php echo($linha2['product_id']); ?>">
													<td>
														<!--<div class="col l4">
															<img src="images/site/flower.png" width="70px">
														</div>-->
														<div class="col l8" id="product_name">
															<?php echo $linha['product_name'] ?>
														</div>
													</td>
													<td>R$<?php echo number_format($linha['product_salevalue'], "2", ",", ""); ?></td>
													<td width="30px">
														<!--<div class="input-field">-->
														<!--<select --><?php /*echo(isset($_SESSION['login']) ? "" : "disabled") */ ?>
														<button class="cart-down" <?php echo(($_SESSION['cart'][$linha2['product_id']] <= 1) ? 'disabled' : '') ?> type="button" style="all: unset;">
															<i class="material-icons small left black-text">remove</i>
														</button>
														<span class="cart_amount">
									&nbsp;
															<?php
																/*if(isset($_SESSION['login'])) {
																	echo(($line['cart_amount'] < 10) ? "&nbsp;" : "");
																	echo $line['cart_amount'];
																}
																else{*/
																echo $_SESSION['cart'][$linha2['product_id']];
																//}

															?>
								</span>
													</td>
													<td width="60px">
														<button class="cart-up" <?php echo(($_SESSION['cart'][$linha2['product_id']] >= $linha2['product_stock']) ? 'disabled' : '') ?> type="button" style="all: unset;">
															<i class="material-icons small black-text">add</i>
														</button>
														<?php
															/*}*/
															$pgselect->DisconnectServer();
														?>
														<!--</select>-->
														<!--</div>-->
													</td>
													<td width="200px">R$
														<span class="cart_subvalue">
													<?php
														/*if (isset($_SESSION['login'])) {
															$sub_value = $linha['product_salevalue'] * $line['cart_amount'];
														}
														else {*/
														$sub_value = $linha['product_salevalue'] * $_SESSION['cart'][$linha2['product_id']];
														//}
														$sub_value = number_format($sub_value, '2', ',', '');
														echo $sub_value;
													?>
													</span>
													</td>
													<td width="100px">
														<a href="<?php echo $_SERVER['PHP_SELF'] ?>?cart_action=del&code=<?php echo($linha['product_id']) ?>"
															class="btn-floating tooltipped red waves-light waves-effect" data-delay="1"
															data-tooltip="Excluir"><i
																class="material-icons">close</i></a>
													</td>
												</tr>
												<?php $pgsql->DisconnectServer();
												$total += $sub_value;
											}
										?>
									</tbody>
								</table>
								<script>
                                    {
                                        let total = () => {
                                            let t = 0;
                                            for (let tr of document.querySelectorAll("#cart tr[data-value]")) {
                                                t += tr.dataset.value * tr.dataset.qtde;
                                            }
                                            document.querySelector("#cart-total").textContent = t.toFixed(2).replace(".", ",");
                                        };

                                        let downs = document.querySelectorAll(".cart-down");

                                        for (let btn of downs) {
                                            btn.addEventListener("click", () => {
                                                let tr = btn.closest("tr");
                                                fetch("_libs/_update_cart.php?do=down&code=" + tr.dataset.id, {credentials: "include"});
                                                btn.disabled = (--tr.dataset.qtde) <= 1;
                                                tr.querySelector(".cart-up").disabled = false;
                                                tr.querySelector(".cart_amount").textContent = tr.dataset.qtde;
                                                tr.querySelector(".cart_subvalue").textContent = (tr.dataset.value * tr.dataset.qtde).toFixed(2).replace(".", ",");
                                                if(tr.dataset.qtde >= 1)
                                                    Materialize.toast('Removido', 500);
                                                total();
                                            });
                                        }

                                        let ups = document.querySelectorAll(".cart-up");

                                        for (let btn of ups) {
                                            btn.addEventListener("click", () => {
                                                let tr = btn.closest("tr");
                                                fetch("_libs/_update_cart.php?do=up&code=" + tr.dataset.id, {credentials: "include"});
                                                tr.querySelector(".cart-down").disabled = false;
                                                if ((++tr.dataset.qtde) > +tr.dataset.stock) {
                                                    btn.disabled = true;
                                                }
                                                tr.querySelector(".cart_amount").textContent = tr.dataset.qtde;
                                                tr.querySelector(".cart_subvalue").textContent = (tr.dataset.value * tr.dataset.qtde).toFixed(2).replace(".", ",");
                                                if((tr.dataset.qtde + 1) > +tr.dataset.stock)
                                                    Materialize.toast('Adicionado', 500);
                                                total();
                                            });
                                        }
                                    }
								</script>
								<?php
							}
						?>
					</div>
				</div>
				<div class="modal-footer">
					<h5 class="left"><strong>Total:</strong> R$
						<span id="cart-total"><?php
								$total = number_format($total, 2, ',', '');
								echo $total;
							?></span></h5>
					<a href="finish_order.php" class="modal-action waves-effect waves-light btn-flat">
						<i class="material-icons left">check</i>
						Finalizar Compra
					</a>
				</div>
			</div>
			<div class="fadeIn" id="global-content">
				<div class="row"></div>
				<div class="row"></div>
				<div class="row"></div>
