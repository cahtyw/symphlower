<?php
	session_start();
	require "_libs/_postgresql.php";
	if (!$_SESSION['login']) {
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
                <script type="text/javascript" src="js/materialize.min.js"></script>
                <script>
                    $('.dropdown-button').dropdown({
                            inDuration: 300,
                            outDuration: 225,
                            constrainWidth: true, // Does not change width of dropdown to that of the activator
                            hover: true, // Activate on hover
                            gutter: 0, // Spacing from edge
                            belowOrigin: false, // Displays dropdown below the button
                            alignment: 'left', // Displays dropdown with edge aligned to the left of button
                            stopPropagation: false // Stops event propagation
                        }
                    );
                    $(document).ready(function () {
                        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
                        $('.modal').modal({
                            opacity: 0.1
                        });
                    });
                </script>
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
                                    <a href="#modal_search" class="modal-trigger grey-text text-darken-1"
                                       onClick="search()">
                                        <i class="material-icons left">search</i>
                                        Pesquisar
                                    </a>
                                </li>
                                <li><a href="index.php" class="grey-text text-darken-1">Página Inicial</a></li>
                                <li><a href="catalog_products.php" class="grey-text text-darken-1">Produtos</a></li>
                                <li><a href="#" class="grey-text text-darken-1">Sobre</a></li>
                                <li><a href="#" class="grey-text text-darken-1">Contato</a></li>
                                <li>
                                    <a href="#modal_cart" class="grey-text text-darken-1 modal-trigger">
                                        <i class="material-icons">shopping_cart</i>
                                    </a>
                                </li>
                                <li>
									<?php
										if ($_SESSION['login']) {
											?>
                                            <a class="dropdown-button grey-text text-darken-1" data-beloworigin="true"
                                               data-activates="dropdown_profile">
                                                <i class="material-icons left">person</i>
												<?php echo "Olá, " . $_SESSION['name'] . "." ?>
                                                <i class="material-icons right">arrow_drop_down</i>
                                            </a>
                                            <ul id='dropdown_profile' class='dropdown-content'>
                                                <li>
                                                    <a href="#" class="grey-text text-darken-1">
                                                        <i class="material-icons left">chevron_right</i>
                                                        Minha Conta
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="grey-text text-darken-1">
                                                        <i class="material-icons left">chevron_right</i>
                                                        Meu Histórico
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="grey-text text-darken-1">
                                                        <i class="material-icons left">chevron_right</i>
                                                        Preferências
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="exit.php" class="grey-text text-darken-1">
                                                        <i class="material-icons left">close</i>
                                                        Sair
                                                    </a>
                                                </li>
                                            </ul>
											<?php
										} else {
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
                            <h6 class="text-darken-3 orange-text right">*Clique fora do retângulo para desistir da
                                                                        pesquisa</h6>
                        </div>
                    </div>
                    <div id="modal_cart" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            <div class="content">
								<?php
									require "cart.php";
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
									$total = number_format($sub_value, 2, ',', '.');
									if (count($_SESSION['cart']) == 0) {
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
									} else {
										?>
                                        <table class="striped">
                                        <thead>
                                        <tr>
                                            <th>Produto(s)</th>
                                            <th>Preço</th>
                                            <th>Quantidade</th>
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
											foreach ($_SESSION['cart'] as $codProduct => $qtd) {
												$pgsql->Query("SELECT product_name, product_salevalue from product WHERE product_id = $codProduct AND product_active = true ORDER BY product_name");
												if ($pgsql->NumRows()) {
													$linha = $pgsql->FetchArray();
													$sub_value = $linha['product_salevalue'] * $qtd;
													$total += $sub_value;
													$id = $linha['product_id'];
													//formata para padrão brasileiro.
													$sub_value = number_format($sub_value, 2, ',', '.');

												}
												?>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col l4">
                                                                <img src="images/site/flower.png" width="70px">
                                                            </div>
                                                            <div class="col l8">
                                                                <br>
																<?php echo strtoupper($linha['product_name']) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>R$<?php echo $linha['product_salevalue'] ?></td>
                                                    <td width="150px">
                                                        <div class="row">
                                                            <div class="col l5">
                                                                <div class="input-field">
                                                                    <select>
																		<?php
																			$pgselect = new PostgreSQL();
																			$pgselect->ConnectServer();
																			$pgselect->Query("SELECT product_stock FROM product WHERE product_id = $id");
																			$linha2 = $pgselect->FetchArray();
																			$max_stock = $linha2['product_stock'];
																			for ($i = 1; $i <= $max_stock; $i++) {
																				?>
                                                                                <option value="<?php echo $i ?>" <?php //editar aqui quantidade selecionada
																				?><?php echo $i ?></option>
																				<?php
																			}
																		?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>R$<?php echo $total ?></td>
                                                    <td width="100px">
                                                        <a href="#" class="btn-floating orange darken-3"><i class="material-icons">save</i></a>
                                                        <a href="#" class="btn-floating red"><i class="material-icons">close</i></a>
                                                    </td>
                                                </tr>
											<?php }
										?>
                                        </tbody>
                                        </table><?php
									}
								?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <h5 class="left"><strong>Total:</strong> R$<?php echo $total ?> </h5>
                            <a href="#!" class="modal-action waves-effect waves-light btn-flat">
                                <i class="material-icons left">save</i>
                                Salvar
                            </a>
                            <a href="#!" class="modal-action waves-effect waves-light btn-flat">
                                <i class="material-icons left">check</i>
                                Finalizar Compra
                            </a>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------------------------------->
                    <div class="fadeIn" id="global-content">
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row container">
                            <div class="row">
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col l6">
                                    <h5 class="orange-text text-darken-3">Informe os campos a seguir novamente.</h5>
                                    <h6>Uma nova senha será enviada em seu email.</h6>
                                    <div class="row"></div>
									<?php
										if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
											?>
                                            <blockquote>
                                                Usuário ou senha inseridos <strong>incorretamente</strong>.<br>
                                                Verifique os dados e tente novamente.
                                            </blockquote>
											<?php
                                            $_SESSION['login_error'] = FALSE;
										}
									?>
                                    <form class="col l12" autocomplete="off" action="teste_envio_email.php" method="post">
                                        <div class="input-field col l10">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="user_name" name="user_name" type="text" autocomplete="off"
                                                   class="validate">
                                            <label for="user_name">Usuário:</label>
                                        </div>
                                        <div class="input-field col l10">
                                            <i class="material-icons prefix">https</i>
                                            <input id="text" name="user_email" autocomplete="off" type="text"
                                                   class="validate">
                                            <label for="user_email">Email:</label>
                                        </div>
                                        <div class="col l8">
                                            
                                        </div>
                                        <div class="row"></div>
                                        <div class="row">
                                            <div class="col l10 center">
                                                <button class="btn-large waves-effect waves-light orange darken-3"
                                                        type="submit"
                                                        name="action">Enviar
                                                    <i class="material-icons left">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                   
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--------------------------------------------------------------------------------------------------------------->
                    <footer class="page-footer orange darken-2">
                        <div class="container">
                            <div class="row">
                                <div class="col l6 s12">
                                    <h5 class="white-text">Desenvolvedores:</h5>
                                    <h6 class="white-text">01 - Caio Lucas Teixeira Ferraz de Oliveira</h6>
                                    <h6 class="white-text">03 - Gabriel dos Santos Gonçalves</h6>
                                    <h6 class="white-text">04 - Gisele Reis de Almeida</h6>
                                    <h6 class="white-text">05 - Isabella Prado da Silva</h6>
                                    <h6 class="white-text">07 - José Almino Junior</h6>
                                </div>
                                <div class="col l4 offset-l2 s12">
                                    <!--<h5>Rede social</h5>-->
                                    <h5 class="white-text">Mapa do site</h5>
                                    <ul>
                                        <li><a class="grey-text text-lighten-3" href="index.php">Página Inicial</a></li>
                                        <li><a class="grey-text text-lighten-3" href="catalog_products.php">Produtos</a>
                                        </li>
                                        <li><a class="grey-text text-lighten-3" href="#">Sobre</a></li>
                                        <li><a class="grey-text text-lighten-3" href="feedback_index.php">Contato</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="footer-copyright">
                            <div class="container">
                                © 2017 Symphlower. Todos os direitos reservados.
                                <!--<a class="grey-text text-lighten-4 right" href="#!">More Links</a>-->
                            </div>
                        </div>
                    </footer>
                </div>
            </body>
        </html>
		<?php
	} else {
		require "_libs/_meta.html";
		?>

        <div class="global-loading">
            <div class="loading">
                <img src="images/site/loading_logo.png">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
                <h4 class="orange-text text-darken-3">Você já está logado.</h4>
                <h5 class="orange-text text-darken-3">Redirecionando para a página inicial...</h5>
            </div>
        </div>
		<?php
		header("Refresh:2; url=index.php");
	}
?>