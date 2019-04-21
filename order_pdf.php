<?php
	include '_libs/mpdf60/mpdf.php';
	include '_libs/_postgresql.php';
	session_start();
	$order_id = $_GET['order_id'];
	$email = $_SESSION['email'];
	$nome = $_SESSION['name'];
	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM orders WHERE order_id = $order_id");
	if ($pg->NumRows()) {
		$info = $pg->FetchArray();
		$pg->DisconnectServer();
		$order_date = $info['order_date'];
		$pg->ConnectSharedServer();
		$end = $_SESSION['address'];
		$pg->Query("SELECT * FROM endereco WHERE id_endereco = $end");
		$end = $pg->FetchArray();
		$rua = $end['endereco'];
		$bairro = $end['bairro'];
		$numero = $end['numero'];
		$cidade = $end['cidade'];
		$cep = $end['cep'];
		$html = "
				<body >
                <center><img src='http://200.145.153.175/gabrielgoncalves/images/site/logo.png'></center>
				<fieldset style='border-color: rgba(0,0,0,0.87);'>
					<h3 class='' style='color: #000000;'>Informações do Pedido 0 - 000$order_id:</h3>
					<b class='' style ='color: #ff6600;' > Pedido realizado em:</b> <b style='color :#000000' > $order_date</b>
				</fieldset >
				<br >
				<hr>
				<fieldset style = 'border-color: rgba(0,0,0,0.87);' >
					<h3 class='' style = 'color: #ff6600;' >Dados do pedido:</h3><br>
							<b > Data do pedido: </b > $order_date <br>
							<b > Forma de pagamento: </b > Á vista.<br>
							<b > Status do pedido: </b > Entregue.<br>
				</fieldset >
				<br >
				<hr>
				<fieldset style = 'border-color: rgba(0,0,0,0.87);' >
					<h4 style = 'color: #ff6600;' > Dados da entrega:</h4 ><br>
					<b > Endereço: </b > $rua, $numero <br>
					<b>  Bairro: </b > $bairro<br>
					<b > Cidade: </b > $cidade<br>
					<b > CEP: </b > $cep<br>
				</fieldset >
				<br >
				<hr>
				<fieldset style = 'border-color: rgba(0,0,0,0.87);' >
					<h4 style = 'color: #ff6600;' > Conteúdo do pedido:</h4>
				</fieldset >
				<table class='striped'>
				<thead>
				<tr>
					<th align='left' width='400px'>Produto</th>
					<th align='left' width='100px'>Preco Unt.</th>
					<th align='left' width='100px'>Qtde.</th>
					<th align='left' width='100px'>Total</th>
				</tr>
				</thead>
				<tbody>
				";
		$pg->DisconnectServer();
		$pg->ConnectServer();
		$pg->Query("SELECT * FROM items WHERE item_order = $order_id");
		$pgprod = new PostgreSQL();
		$pgprod->ConnectServer();
		while ($item = $pg->FetchArray()) {
			$produto = $item['item_product'];
			$pgprod->Query("SELECT * FROM product WHERE product_id = $produto");
			$prod = $pgprod->FetchArray();
			$produto = $prod['product_name'];
			$preco = $prod['product_salevalue'];
			$quantidade = $item['item_amount'];
			$total = $item['item_total'];
			$total = number_format($total, '2', ',', '');
			$preco = number_format($preco, '2', ',', '');
			$html .= "
				<tr>
					<td>$produto</td>
					<td>R$$preco</td>
					<td>$quantidade</td>
					<td>R$$total</td>
				</tr>";
		}
		$html .= "</tbody>
					</table>
		";

		/*
		<table class='striped'>
								<thead>
									<tr>
										<th>Produto</th>
										<th>Preco Unt.</th>
										<th>Quantidade</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									"
										$pgprod = new PostgreSQL();
										$pgprod->ConnectServer();
										$pg->ConnectServer();
										$pg->Query('SELECT * FROM items WHERE item_order = $item_order');
										$total = 0;
										while ($item = $pg->FetchArray()) {
											$item_product = $item['item_product'];
											$pgprod->Query('SELECT * FROM product WHERE product_id = $item_product');
											$product = $pgprod->FetchArray();
											"<tr>
												<td> <?php echo $product['product_name']?></td>
												<td><?php echo $product['product_salevalue']?></td>
												<td><?php echo $item['item_amount']?></td>
												<td>R$ <?php $total+=$item['item_total']; echo $item['item_total']?></td>
											</tr>"

										}

									"
								</tbody>
							</table>
		 */
		$mpdf = new mPDF();
		$mpdf->SetDisplayMode('fullpage');
		// $css = file_get_contents("css/estilo.css");
		//$mpdf->WriteHTML($css,1);
		$mpdf->WriteHTML($html);
		$mpdf->Output("Relatorio_de_Vendas_Symplhower.pdf", "D");
	}


