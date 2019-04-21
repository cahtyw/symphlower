<?php
	session_start();
	require "_libs/_postgresql.php";

	$item_order = $_GET['order_id'];
	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM items WHERE item_order = $item_order");
	$pgorder = new PostgreSQL();
	$pgorder->ConnectServer();
	$pgorder->Query("SELECT * FROM orders WHERE order_id = $item_order");
	$order = $pgorder->FetchArray();
	$info = $pg->FetchArray();
	$pg->DisconnectServer();
	$pgorder->DisconnectServer();
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
                    <a href="order_pdf.php?order_id=<?php echo $item_order ?>" class="waves-effect waves-light red btn-floating">
                        <i class="material-icons">picture_as_pdf</i>
                    </a>
                </div>
            </div>

            <div class="row grey lighten-5">
                <fieldset>
                    <div class="col s12">
                        <h6 class="orange-text text-darken-3"><b>Informações do Pedido:</b>
                                <span class="black-text"> 0-000<?php
										echo(($info['item_order'] > 9) ? (($info['item_order'] > 99) ? "0" : "00") : "000");
										echo $info['item_order'];
									?></span></h6>
                        <span><b>Pedido realizado em:</b> <?php echo $order['order_date'] ?></span>
                    </div>
                </fieldset>
            </div>
            <div class="row grey lighten-5">
                <fieldset>
                    <div class="col s12">
                        <h6 class="orange-text text-darken-3">Dados do Pedido</h6>
                        <div class="divider"></div>
                        <span><b>Data do pedido: </b><?php echo $order['order_date'] ?></span><br>
                        <span><b>Forma de pagamento: </b>À vista.</span><br>
                        <span><b>Status do pedido: </b>Entregue.</span><br>
                    </div>
                </fieldset>
            </div>
            <div class="row grey lighten-5">
                <fieldset>
                    <div class="col s12">
                        <h6 class="orange-text text-darken-3">Dados da Entrega</h6>
                        <div class="divider"></div>
						<?php
							$pgad = new PostgreSQL();
							$pgad->ConnectSharedServer();
							$add = $_SESSION['address'];
							$pgad->Query("SELECT * FROM endereco WHERE id_endereco = $add");
							$address = $pgad->FetchArray();
							$pgad->DisconnectServer();
						?>
                        <span><b>Endereço: </b><?php echo $address['endereco'] . " - " . $address['numero'] ?></span><br>
                        <span><b>Bairro: </b><?php echo $address['bairro'] ?></span><br>
                        <span><b>Cidade: </b><?php echo $address['cidade'] . ", " . $address['estado'] ?></span><br>
                        <span><b>CEP: </b><?php echo $address['cep'] ?></span><br>
                    </div>
                </fieldset>
            </div>
            <div class="row grey lighten-5">
                <fieldset>
                    <div class="col s12">
                        <h6 class="orange-text text-darken-3">Conteúdo do Pedido</h6>
                        <div class="divider"></div>
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preco Unt.</th>
                                    <th>Quantidade</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php
									$pgprod = new PostgreSQL();
									$pgprod->ConnectServer();
									$pg->ConnectServer();
									$pg->Query("SELECT * FROM items WHERE item_order = $item_order");
									$total = 0;
									$total = number_format($total, '2', ',', '');
									while ($item = $pg->FetchArray()) {
										$item_product = $item['item_product'];
										$pgprod->Query("SELECT * FROM product WHERE product_id = $item_product");
										$product = $pgprod->FetchArray();
										?>
                                        <tr>
                                            <td><?php echo $product['product_name'] ?></td>
                                            <td><?php echo number_format($product['product_salevalue'], '2', ',', '')?></td>
                                            <td><?php echo $item['item_amount'] ?></td>
                                            <td>R$<?php $total += $item['item_total'];
													echo number_format($item['item_total'], '2', ',', '') ?></td>
                                        </tr>
										<?php
									}
								?>
                            </tbody>
                        </table>
                        <h5><b>Total:</b> R$<?php echo number_format($total, '2', ',', '') ?></h5>
                    </div>
                </fieldset>
            </div>
        </fieldset>
    </div>
</body>
