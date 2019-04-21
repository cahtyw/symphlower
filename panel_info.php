<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";
	$pg = new PostgreSQL();
?>
<div class="container">
	<h3>Painel de estatísticas</h3>
	<h6>Através deste painel você poderá verificar/checar algumas estatísticas do site.</h6>
	<div class="divider"></div>
	<br>
	<br>
	<table class="highlight">
		<thread>
			<tr>
				<th></th>
				<th></th>
			</tr>
		</thread>
		<tbody>
			<tr>
				<th width="400px">Usuários presentes no total:</th>
				<td>
					<?php
						$pg->ConnectSharedServer();
						$pg->Query("SELECT COUNT(id_usuario) AS conta FROM usuario;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo $print['conta'];
					?> usuários
				</td>
			</tr>
			<tr>
				<th>Usuários cadastrados/que acessaram o site:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT COUNT(user_id) AS conta FROM users;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo $print['conta'];
					?> usuários
				</td>
			</tr>
			<tr>
				<th>Porcentagem de acessos:</th>
				<td>
					<?php
						$pg->ConnectSharedServer();
						$pg->Query("SELECT COUNT(id_usuario) AS conta FROM usuario");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						$shared = $print['conta'];
						$pg->ConnectServer();
						$pg->Query("SELECT COUNT(user_id) AS conta FROM users");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						$mine = $print['conta'];
						echo number_format((100 * $mine) / $shared, '2', ',', '');
					?>%
				</td>
			</tr>
			<tr>
				<th>Administradores:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT COUNT(user_id) AS conta FROM users WHERE user_level = 1337;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo $print['conta'];
					?> administradores
				</td>
			</tr>
			<tr>
				<th>Produtos restantes:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT SUM(product_stock) AS conta FROM product WHERE product_active = TRUE;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						$vendas = $print['conta'];
						echo $print['conta'];
					?> produtos
				</td>
			</tr>
			<tr>
				<th>Vendas efetuadas:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT COUNT(order_id) AS conta FROM orders WHERE order_active = TRUE;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						$vendas = $print['conta'];
						echo $print['conta'];
					?> vendas
				</td>
			</tr>
			<tr>
				<th>Média de vendas por dia:</th>
				<td>
					<?php
						echo number_format($vendas / 3, '1', ',', '');
					?> vendas
				</td>
			</tr>
			<tr>
				<th>Produtos vendidos:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT COUNT(item_order) AS conta FROM items;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						$items = $print['conta'];
						echo $print['conta'];
					?> produtos
				</td>
			</tr>
			<tr>
				<th>Vendas efetuadas p/ mulheres:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg2 = new PostgreSQL();
						$pg2->ConnectSharedServer();
						$homens = 0;
						$mulheres = 0;
						$pg->Query("SELECT users.user_id, orders.order_id FROM users INNER JOIN orders ON users.user_id = orders.order_user AND orders.order_active = TRUE");
						while($soma = $pg->FetchArray()) {
							$user_id = $soma['user_id'];
							$pg2->Query("SELECT sexo FROM cliente WHERE id_usuario = $user_id");
							$sexo = $pg2->FetchArray();
							if($sexo['sexo'] == 'm' || $sexo == 'M')
								$homens++;
							else
								$mulheres++;
						}
						$pg2->DisconnectServer();
						echo $mulheres . " vendas (" . number_format((100 * $mulheres) / $vendas, '1', ',', '') . "%)";
					?>
				</td>
			</tr>
			<tr>
				<th>Vendas efetuadas p/ homens:</th>
				<td>
					<?php
						echo $homens . " vendas (" . number_format((100 * $homens) / $vendas, '1', ',', '') . "%)";
					?>
				</td>
			</tr>
			<tr>
				<th>Arrecadação total:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT SUM(item_total) AS conta FROM items;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo 'R$' . number_format($print['conta'], '2', ',', '');
					?>
				</td>
			</tr>
			<tr>
				<th>Média de arrecadação p/ dia:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT SUM(item_total) AS conta FROM items;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo 'R$' . number_format($print['conta'] / 3, '2', ',', '');
					?>
				</td>
			</tr>
			<tr>
				<th>Lucro aproximado:</th>
				<td>
					<?php
						$pg->ConnectServer();
						$pg->Query("SELECT SUM(item_total) AS conta FROM items;");
						$print = $pg->FetchArray();
						$pg->DisconnectServer();
						echo 'R$' . number_format(($print['conta'] - ((40 * $print['conta']) / 100)), '2', ',', '');
					?>
				</td>
			</tr>
			<tr>
				<th>-</th>
				<td>-</td>
			</tr>
			<tr>
				<th>Informações por produto:</th>
				<td>-</td>
			</tr>
			<?php
				$pg->ConnectServer();
				$pg->Query("SELECT items.item_product AS product_id, SUM(items.item_amount) AS soma  FROM items GROUP BY item_product");
				while($produto = $pg->FetchArray()) {
					$product_id = $produto['product_id'];
					$soma = $produto['soma'];
					$pg2 = new PostgreSQL();
					$pg2->ConnectServer();
					$pg2->Query("SELECT product_name FROM product WHERE product_id = $product_id");
					$prod = $pg2->FetchArray();
					?>
					<tr>
						<th><?php echo $prod['product_name'] ?></th>
						<td><?php echo $soma . " vendidos (" . number_format((100 * $soma) / $items, '2', ',', '') . "%)" ?></td>
					</tr>
					<?php
				}
			?>
			<tr>
				<th>-</th>
				<td>
					-
				</td>
			</tr>
			<tr>
				<th>Frameworks/Bibliotecas/APIs utilizados(as):</th>
				<td>
					<a href="http://materializecss.com/" class="black-text">Materialize v0.100.1 (Material design)</a>
				</td>
			</tr>
			<tr>
				<th>-</th>
				<td>
					<a href="https://jquery.com/" class="black-text">jQuery v3.2.1</a>
				</td>
			</tr>
			<tr>
				<th>-</th>
				<td>
					<a href="https://sweetalert.js.org/" class="black-text">SweetAlert v?</a>
				</td>
			</tr>
			<tr>
				<th>-</th>
				<td>
					<a href="https://correiosapi.apphb.com/" class="black-text">Correios RESTful API</a>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<br>
</div>
<?php
	$pg = NULL;
	require "_libs/_footeradm.php";
?>
