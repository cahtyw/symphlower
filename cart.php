<?php
	//session_start();
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
	}

	if (isset($_GET['cart_action'])) {
		//Função Adicionar no carrinho
		if ($_GET['cart_action'] == 'add') {
			$codProduct = intval($_GET['codproduto']);
			//se o produto já foi selecionado no carrinho
			if (!isset($_SESSION['cart'][$codProduct])) {
				$_SESSION['cart'][$codProduct] = 1;

			} else {
				// add se existir
				$_SESSION['cart'][$codProduct] += 1;
			}
		}
		// Função Excluir no carrinho
		if ($_GET['cart_action'] == 'del') {
			$codProduct = intval($_GET['codproduto']);
			if (isset($_SESSION['cart'][$codProduct])) {
				unset($_SESSION['cart'][$codProduct]);
			}
		}
		// FUNÇÃO ALTERAR QUANTIDADE OU ATUALIZAR
		/*if ($_GET['cart_action'] == 'up' && is_array($_POST['prod'])) {
			foreach ($_POST['prod'] as $codProduct => $qtd) {
				$codProduct = intval($codProduct);
				$qtd = intval($qtd);
				if (!empty($qtd) || $qtd <> 0) {
					$_SESSION['cart'][$codProduct] = $qtd;
				} else {
					unset($_SESSION['cart'][$codProduct]);
				}
			}
		}*/
	}
?>
<!--
--><?php
/*	if (count($_SESSION['cart']) == 0) {
		echo "<tr><td colspan='5'>N&atilde;o h&aacute; produto no carrinho</td></tr>";
	} else {
		require "_libs/_postgresql.php";
		//require "_libs/_meta.html";

		$pgsql = new PostgreSQL();
		$pgsql->ConnectServer();
		$total = 0;
		foreach ($_SESSION['cart'] as $codProduct => $qtd) {
			$pgsql->Query("SELECT product_name, product_salevalue from product WHERE product_id = $codProduct AND product_active = true ORDER BY product_name");
			$regs = $pgsql->NumRows();
			if ($regs > 0) {
				$linha = $pgsql->FetchArray();
				$nome = $linha['product_name'];
				$preco = $linha['product_salevalue'];
				$sub *= $qtd;
				$total += $sub;
				$sub = number_format($sub, 2, ',', '.');//formata para padrão brasileiro.
			}
			echo '<tr>       
                                 <td>' . $nome . '</td>
                                 <td><input type="text" size="3" name="product_id[' . $codProduct . ']" value="' . $qtd . '" /></td>
                                 <td>' . $preco . '</td>
                                 <td> R$ ' . $sub . '</td>
                                 <td><a href="?cart_action=del&codproduto=' . $codProduct . '">Remove</a></td>
                              </tr>';
		}
		$total = number_format($total, 2, ',', '.');
		echo '<tr>
                                    <td colspan="3">Total</td>
                                    <td> R$ ' . $total . '</td>
                                  </tr>';

	}
*/?>