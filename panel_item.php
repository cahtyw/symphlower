<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";
	if (isset($_POST['item_registred'])) {
		$pg = new PostgreSQL();
		$product_name = $_POST['product_name'];
		$product_description = $_POST['product_description'];
		$product_color = $_POST['product_color'];
		$product_costvalue = number_format($_POST['product_costvalue'], '2', '.', '');
		$product_salevalue = number_format($_POST['product_salevalue'], '2', '.', '');
		$product_stock = $_POST['product_stock'];
		$product_image = $_POST['product_image'];
		$pg->ConnectServer();
		$pg->Query("INSERT INTO product VALUES(DEFAULT, '$product_name', '$product_description', '$product_color', '$product_image', '$product_costvalue', '$product_salevalue', $product_stock, TRUE)");
		if ($pg->AffectedRows()) {
			?>
            <script>alert("Produto salvo com sucesso!")</script>
			<?php
		}
		$pg->DisconnectServer();
		$pg = NULL;
		header("Refresh:1; url=panel_item.php");
	}
	if (isset($_POST['item_edited'])) {
		$product_id = $_POST['product_id'];
		$pg = new PostgreSQL();
		$total = 0;
		if (isset($_POST['product_stock']) && $_POST['product_stock'] != NULL) {
			$product_stock = $_POST['product_stock'];
			$total += 1;
		}
		if (isset($_POST['product_image']) && $_POST['product_image'] != NULL) {
			$product_image = $_POST['product_image'];
			$total += 2;
		}
		$pg->ConnectServer();
		switch ($total) {
			case 1:
				$pg->Query("UPDATE product SET product_stock = $product_stock WHERE product_id = $product_id");
				break;
			case 2:
				$pg->Query("UPDATE product SET product_image = '$product_image' WHERE product_id = $product_id");
				break;
			case 3:
				$pg->Query("UPDATE product SET product_stock = $product_stock, product_image = '$product_image' WHERE product_id = $product_id");
				break;
		}
		?>
        <script>editProduct();</script>
		<?php
		$pg->DisconnectServer();
		$pg = NULL;
	}
	if (isset($_GET['act'])) {
		$pg = new PostgreSQL();
		$pg->ConnectServer();
		$product_id = $_GET['product_id'];
		switch ($_GET['act']) {
			case "delete":
				$pg->Query("UPDATE product SET product_active = FALSE WHERE product_id = $product_id");
				break;
			case "reset":
				$pg->Query("UPDATE product SET product_active = TRUE WHERE product_id = $product_id");
				break;
			case "edit":
				break;
		}
		$pg->DisconnectServer();
		$pg = NULL;
		?>
        <script>window.location.href = "panel_item.php"</script>
		<?php
	}
?>

    <!-- Início do modal de edição -->
    <div id="modal_edit" class="modal">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="modal-content">
                <div class="row">
                    <div class="col s8">
                        <h4 class="orange-text text-darken-3">
                            <i class="material-icons">
                                shopping_cart
                            </i>
                            Editar Produto
                        </h4>
                        <h6>Siga os passos abaixo para editar um produto.</h6>
                    </div>
                    <div class="col s4">
                        <a href="#!" class="right modal-action modal-close  waves-effect waves-light btn-flat">
                            <i class="material-icons left">exit_to_app</i>
                            Fechar
                        </a>
                    </div>
                </div>
                <div class="divider"></div>
                <br>
                <br>
                <div class="row">
                    <div class="input-field col s5">
                        <i class="material-icons prefix">extension</i>
                        <select required name="product_id">
                            <option value="" disabled selected>Escolha um produto</option>
							<?php
								$pg = new PostgreSQL();
								$pg->ConnectServer();
								$pg->Query("SELECT * FROM product ORDER BY product_active DESC, product_name ASC");
								while ($product = $pg->FetchArray()) {
									?>
                                    <option value="<?php echo $product['product_id'] ?>"><?php echo $product['product_id'] ?> - <?php echo $product['product_name'] ?></option>
									<?php
								}
								$pg->DisconnectServer();
								$pg = NULL;
							?>
                        </select>
                        <label>Produto</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">shopping_basket</i>
                        <input id="stock" min="0" max="50" step='1' value='' placeholder="Ex: 24" autocomplete="off" maxlength="150" type="number" name="product_stock" class="">
                        <label for="stock" class="active" data-error="Insira uma quantidade">Estoque</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">insert_photo</i>
                        <input id="image" placeholder="Ex: https://i.imgur.com/AALZSPl.png" autocomplete="off" maxlength="150" type="text" name="product_image" class="">
                        <label for="image" class="active" data-error="Você deve inserir uma url de uma imagem 170x170px">Cole a url da imagem do produto (140x140px)</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="item_edited">
            <div class="modal-footer">
                <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Cadastrar</button>
            </div>
        </form>
    </div>
    <!--Fim do modal-->

    <!--Início do Modal de cadastro-->
    <script src="js/sorttable.js"></script>
    <div id="modal" class="modal">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="modal-content">
                <div class="row">
                    <div class="col s8">
                        <h4 class="orange-text text-darken-3">
                            <i class="material-icons">
                                shopping_cart
                            </i>
                            Cadastrar Produto
                        </h4>
                        <h6>Siga os passos abaixo para adicionar um produto ao estoque.</h6>
                    </div>
                    <div class="col s4">
                        <a href="#!" class="right modal-action modal-close  waves-effect waves-light btn-flat">
                            <i class="material-icons left">exit_to_app</i>
                            Fechar
                        </a>
                    </div>
                </div>
                <div class="divider"></div>
                <br>
                <br>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">create</i>
                        <input id="name" placeholder="Ex: Violeta-africana" autocomplete="off" maxlength="150" type="text" required name="product_name" class="validate">
                        <label for="name" class="active" data-error="Insira um produto">Produto</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">details</i>
                        <textarea id="description" placeholder="Ex: Com folhas em formato de coração, a violeta-africana é pequena e delicada, se tornando o presente ideal para oferecer a quem se ama." data-length="150" required name="product_description" class="materialize-textarea validate"></textarea>
                        <label for="description" class="active" data-error="Dê uma descrição ao produto">Descrição</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">extension</i>
                        <select required name="product_color">
                            <option value="" disabled selected>Escolha uma opção</option>
                            <option value="Amarela">Amarela</option>
                            <option value="Azul">Azul</option>
                            <option value="Branca">Branca</option>
                            <option value="Laranja">Laranja</option>
                            <option value="Lilás">Lilás</option>
                            <option value="Rosa">Rosa</option>
                            <option value="Roxa">Roxa</option>
                            <option value="Vermelha">Vermelha</option>
                            <option value="Outras">Outras</option>
                        </select>
                        <label>Cor</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">attach_money</i>
                        <input id="costvalue" min="3.00" max="20.00" step='0.01' value='3.00' placeholder="Ex: 13.50" autocomplete="off" maxlength="150" type="number" required name="product_costvalue" class="validate">
                        <label for="costvalue" class="active" data-error="Insira um valor em reais">Valor de custo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">attach_money</i>
                        <input id="salevalue" min="3.00" max="20.00" step='0.01' value='3.00' placeholder="Ex: 13.50" autocomplete="off" maxlength="150" type="number" required name="product_salevalue" class="validate">
                        <label for="salevalue" class="active" data-error="Insira um valor em reais">Valor de venda</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">shopping_basket</i>
                        <input id="stock" min="1" max="50" step='1' value='1' placeholder="Ex: 24" autocomplete="off" maxlength="150" type="number" required name="product_stock" class="validate">
                        <label for="stock" class="active" data-error="Insira uma quantidade">Estoque</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">insert_photo</i>
                        <input id="image" placeholder="Ex: https://i.imgur.com/AALZSPl.png" autocomplete="off" maxlength="150" type="text" required name="product_image" class="validate">
                        <label for="image" class="active" data-error="Você deve inserir uma url de uma imagem 170x170px">Cole a url da imagem do produto (140x140px)</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="item_registred">
            <div class="modal-footer">
                <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Cadastrar</button>
            </div>
        </form>
    </div>
    <!--Fim do modal-->
    <!--Início do conteúdo da página-->
    <script src="js/sorttable.js"></script>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h4>Listagem de Produtos</h4>
            </div>
            <div class="col s12">
                <h6>Aqui você pode visualizar todos os produtos e cadastrar novos.</h6>
            </div>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <div class="row">
                <div class="col s10">
                    <div class="input-field col s4">
                        <select id="nome" name="nome">
                            <option value="" selected>Escolha uma opção</option>
							<?php
								$pgprod = new PostgreSQL();
								$pgprod->ConnectServer();
								$pgprod->Query("SELECT product_id, product_name FROM product ORDER BY product_name");
								while ($produ = $pgprod->FetchArray()) {
									?>
                                    <option value="<?php echo strtolower($produ['product_id']) ?>"><?php echo($produ['product_name']) ?></option>
									<?php
								}
								$pgprod->DisconnectServer();
							?>
                        </select>
                        <label for="nome">Produto</label>
                    </div>
                    <div class="input-field col s4">
                        <select id="cor" name="cor">
                            <option value="" selected>Escolha uma opção</option>
							<?php
								$pgprod = new PostgreSQL();
								$pgprod->ConnectServer();
								$pgprod->Query("SELECT DISTINCT product_color FROM product ORDER BY product_color");
								while ($produ = $pgprod->FetchArray()) {
									?>
                                    <option value="<?php echo($produ['product_color']) ?>"><?php echo($produ['product_color']) ?></option>
									<?php
								}
								$pgprod->DisconnectServer();
							?>
                        </select>
                        <label for="cor">Cor</label>
                    </div>
	                <div class="col s4">
		                <div class="col s12">
			                <br>
			                <button class="btn-flat waves-effect waves-light">
				                <i class="material-icons left">search</i>
				                Pesquisar
			                </button>
		                </div>
	                </div>
                </div>
            </div>
        </form>
        <div class="row">
            <table class="striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Preço Custo</th>
                        <th>Preço Venda</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
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
                    </tr>
					<?php
                        $total_reg = 15;
						$pg = new PostgreSQL();
						$pg->ConnectServer();
                        $pg->Query("SELECT * FROM product ORDER BY product_id");
                        if($pg->NumRows()) {
                            $psql = new PostgreSQL();
                            $psql->ConnectServer();
                            $psql->Query("SELECT * FROM product ORDER BY product_id");
                            $pagina = $_GET['pagina'];
                            if (!$pagina) {
                                $pc = "1";
                            } else {
                                $pc = $pagina;
                            }
                            $soma = 0;
                            if (isset($_GET['nome']) && $_GET['nome'] != NULL) {
                                $prod_id = $_GET['nome'];
                                $soma += 1;
                            } else if (isset($_GET['cor']) && $_GET['cor'] != NULL) {
                                $prod_color = $_GET['cor'];
                                $soma += 2;
                            }

                            $prequery = "SELECT * FROM product WHERE ";
                            $suquery = " ORDER BY product_active DESC, product_name ASC";

                            switch ($soma) {
                                case 1:
                                    $pg->Query($prequery . "product_id = $prod_id" . $suquery);
                                    break;
                                case 2:
                                    $pg->Query($prequery . "product_color = '$prod_color'" . $suquery);
                                    break;
                                case 3:
                                    $pg->Query($prequery . "product_id = $prod_id AND product_color = '$prod_color'" . $suquery);
                                    break;
                                default:
                                    $pg->Query("SELECT * FROM product ORDER BY product_id");
                            }
                            $inicio = $pc - 1;
                            $inicio = $inicio * $total_reg;

                            $limite = new PostgreSQL();
                            $limite->ConnectServer();
                            $limite->Query("SELECT * FROM product ORDER BY product_id LIMIT  $total_reg OFFSET $inicio");
                            $tr = $psql->NumRows();
                            $tp = $tr / $total_reg;
                            while ($prod = $limite->FetchArray()) {
                                ?>
                                <tr class="<?php if ($prod['product_active'] == 'f') echo ' red accent-1'; else echo(($prod['product_stock'] < 1) ? 'red-text' : ''); ?>">
                                    <td>
                                        <?php echo($prod['product_id']) ?>
                                    </td>
                                    <td>
                                        <?php echo($prod['product_name']) ?>
                                    </td>
                                    <td>
                                        <?php echo($prod['product_color']) ?>
                                    </td>
                                    <td>
                                        R$ <?php
                                        $price = number_format($prod['product_costvalue'], '2', ',', '');
                                        echo($price);
                                        ?>
                                    </td>
                                    <td>
                                        R$ <?php
                                        $price = number_format($prod['product_salevalue'], '2', ',', '');
                                        echo($price);
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo($prod['product_stock']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        $active = $prod['product_active'];
                                        if ($active == 't') {
                                            ?>
                                            <a href="javascript:;"
                                               onclick="deleteProduct(<?php echo $prod['product_id'] ?>)"
                                               class="btn-floating red darken-3 waves-effect waves-light tooltipped"
                                               data-tooltip="Excluir" data-position="bottom" data-delay="30">
                                                <i class="material-icons">close</i>
                                            </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="javascript:;"
                                               onclick="resetProduct(<?php echo $prod['product_id'] ?>)"
                                               class="btn-floating green waves-effect waves-light tooltipped"
                                               data-tooltip="Restaurar" data-position="bottom" data-delay="30">
                                                <i class="material-icons">check</i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                        &nbsp;
                                        <a href="#modal_edit"
                                           class="btn-floating yellow darken-1 waves-effect waves-light tooltipped modal-trigger"
                                           data-tooltip="Editar Produtos" data-position="bottom" data-delay="30">
                                            <i class="material-icons">create</i>
                                        </a>
                                        <?php
                                        ?>
                                    </td>
                                </tr>
                                <?php
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
        </div>
    </div>

    <!--Fim do conteúdo-->
<?php
	require "_libs/_footeradm.php";
?>