<?php
session_start();
require "_libs/_postgresql.php";
require "_libs/_topside.php";
$user_id = $_SESSION['user_id'];
if(isset($_GET['cart_action'])){
	if($_GET['cart_action']== 'add'){
		?>
		<!--<script>Materialize.toast('Adicionado ao carrinho', 500);</script>-->
		<?php
	}
	else if($_GET['cart_action'] == 'del'){
		?>
		<!--<script>Materialize.toast('Removido do carrinho', 500);</script>-->
		<?php
	}
	?>
	<script>window.location.href = 'catalog_products.php'</script>
	<?php
}
//echo("<script>alert(".$_GET['id_product'].")</script>");
?>
    <div class="container">
        <div class="row">
            <div class="col l12 s12 m12">
                <h4 class="orange-text text-darken-3">Catálogo de Produtos</h4>
                
            </div>
        </div>
        <div class="row">
            <div class="col s3">
                <fieldset>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <input type="hidden" value="1" name="filter_option">
                        <?php
                        $cont = 0;

                        $pgsql = new PostgreSQL();
                        $pgsql->ConnectServer();
                        $pgsql->Query("SELECT DISTINCT product_name FROM product WHERE product_active = TRUE ORDER BY product_name");
                        ?>
                        <h5 class="text-darken-3 orange-text">Filtro por categoria:</h5>
                        <?php
                        while ($column = $pgsql->FetchArray()) {
                            ?>
                            <input name="filter_cat" type="radio"
                                   value="<?php echo $column['product_name'] ?>"
                                   id="<?php echo 'cat' . $cont; ?>"/>
                            <label for="<?php echo 'cat' . $cont; ?>"><?php echo $column['product_name'] ?></label>
                            <br>
                            <?php
                            $cont++;
                        }
                        $cont = 0;
                        $pgsql->Query("SELECT DISTINCT product_color FROM product WHERE product_active = TRUE ORDER BY product_color");
                        ?>
                        <hr>
                        <h5 class="text-darken-3 orange-text">Filtro por cor:</h5>
                        <?php
                        while ($column = $pgsql->FetchArray()) {
                            ?>
                            <input name="filter_color" type="radio"
                                   value="<?php echo $column['product_color'] ?>"
                                   id="<?php echo 'color' . $cont; ?>"/>
                            <label for="<?php echo 'color' . $cont; ?>"><?php echo $column['product_color'] ?></label>
                            <br>
                            <?php
                            $cont++;
                        }
                        ?>
                        <hr>
                        <h5 class="text-darken-3 orange-text">Filtro por preço:</h5>
                        <input type="radio" name="filter_price" value="1" id="price1">
                        <label for="price1">R$ 1,00 - R$ 2,99</label>
                        <br>
                        <input type="radio" name="filter_price" value="2" id="price2">
                        <label for="price2">R$ 3,00 - R$ 6,99 </label>
                        <br>
                        <input type="radio" name="filter_price" value="3" id="price3">
                        <label for="price3">R$ 7,00 - R$ 10,00 </label>
                        <br>
                        <hr>
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-light waves-effect orange darken-3">
                                <i class="material-icons left">filter_list</i>
                                Filtrar
                            </button>
                        </div>
                    </form>
                </fieldset>
            </div>
            <div class="col s9">
                <?php
                //limite de produtos por página
                $limit = 9;
                if (isset($_GET['filter_option']) && $_GET['filter_option'] == 1) {
                    //c filtro
                    $filter_cat = $_GET['filter_cat'];
                    $filter_color = $_GET['filter_color'];
                    $filter_price = $_GET['filter_price'];
                    $option = 0;
                    if ($filter_cat != NULL)
                        $option += 1;
                    if ($filter_color != NULL)
                        $option += 2;
                    if ($filter_price != NULL)
                        $option += 4;

                    switch ($option) {
                        case 1:
                            $sql = " product_name = '$filter_cat' ";
                            break;
                        case 2:
                            $sql = " product_color = '$filter_color' ";
                            break;
                        case 3:
                            $sql = " product_name = '$filter_cat' AND product_color = '$filter_color' ";
                            break;
                        case 4:
                            $sql = " product_virtualprice = $filter_price ";
                            break;
                        case 5:
                            $sql = " product_name = '$filter_cat' AND product_virtualprice = $filter_price ";
                            break;
                        case 6:
                            $sql = " product_name = '$filter_cat' AND product_color = '$filter_color' ";
                            break;
                        case 7:
                            $sql = " product_name = '$filter_cat' AND product_virtualprice = $filter_price AND product_color = '$filter_color' ";
                            break;
                    }
                    $option = 0;
                    $pgsql->Query("SELECT * FROM v_product WHERE product_active = TRUE ORDER BY product_name");
                    $totalItems = $pgsql->NumRows();
                    $total = ceil(($pgsql->NumRows()) / $limit);
                    $page = (isset($_GET['page'])) ? ($_GET['page']) : 1;
                    $begin = ($page * $limit) - $limit;
                    $query = "SELECT * FROM v_product WHERE " . $sql . " AND product_active = TRUE ORDER BY product_stock <= 0, product_name";
                    //echo $query;
                    //$pgsql->ConnectServer();
                    $pgsql->Query($query);

                    /*while($column = $pgsql->FetchArray()){
                        echo "äaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
                    }*/

                } else if (isset($_GET['filter_option']) && $_GET['filter_option'] == 2) {
                    //pesquisa por palavras
                    $search = strtolower($_GET['search_bar']);
                    $string = "%" . $search . "%";
                    $pgsql->Query("SELECT * FROM product WHERE product_active = TRUE ORDER BY product_name");
                    $totalItems = $pgsql->NumRows();
                    $total = ceil(($pgsql->NumRows()) / $limit);
                    $page = (isset($_GET['page'])) ? ($_GET['page']) : 1;
                    $begin = ($page * $limit) - $limit;
                    //$pgsql->Query("SELECT * FROM product WHERE LOWER(product_name) LIKE '$string' OR LOWER (product_description) LIKE '$string' ORDER BY product_name");
                    $pgsql->Query("SELECT * FROM product WHERE LOWER(product_name) LIKE '$string' ORDER BY product_stock <= 0, product_name");
                    $z = 0;

                } else {
                    //s filtro
                    $pgsql->Query("SELECT * FROM product WHERE product_active = TRUE ORDER BY product_name");
                    $totalItems = $pgsql->NumRows();
                    $total = ceil(($pgsql->NumRows()) / $limit);
                    $page = (isset($_GET['page'])) ? ($_GET['page']) : 1;
                    $begin = ($page * $limit) - $limit;
                    $pgsql->Query("SELECT * FROM product WHERE product_active ORDER BY product_stock <= 0, product_name LIMIT $limit OFFSET $begin;");
                    $z = 0;
                }
                if ($total) {
                    ?>
                   <!-- <h4 class="orange-text text-darken-3"><?php echo $totalItems ?> produtos
                        encontrados:</h4>
<!--                    <h5>Filtros utilizados: (nenhum)</h5>-->
                    <hr>
                    <?php
                    while ($column = $pgsql->FetchAssoc()) {

                        if ($z % 3 == 0) {
                            $newRow = 1;
                            ?>
                            <div class="row">
                        <?php } ?>
                        <div class="col s4">
                            <div class="card">
                                <div class="card-image">
	                                <?php
		                                if($column['product_stock']){
		                                	?>
			                                <img src="<?php echo $column['product_image'];?>">
			                                <?php
		                                }
		                                else{
		                                	?>
			                                <img src="https://i.imgur.com/VPdhM0E.png">
			                                <?php
		                                }
	                                ?>

                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col l9">
                                                                <span id="product_name"
                                                                      class="orange-text text-darken-3"><?php echo $column['product_name'] ?></span>
                                        </div>
                                        <div class="col l3">
                                            <span class="grey-text text-darken-1">R$<?php echo number_format($column['product_salevalue'],"2",",",""); ?></span>
                                        </div>
                                    </div>
                                    <div id="product_stock" class="col l12">
                                                            <span class="orange-text text-darken-3 right">
                                                                <?php echo($column['product_stock'] ? " " : "* Sem estoque"); ?>
                                                            </span>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <a href="details_product.php?product_id=<?php echo $column['product_id'] ?>"
                                       class="tooltipped btn waves-light waves-effect orange darken-3" data-delay="5"
                                       data-tooltip="Detalhes do produto">
                                        <i class="material-icons">info_outline</i>
                                    </a>
                                    <?php
                                    if (!isset($_SESSION['login'])) {
                                        if (!isset($_SESSION['cart'][$column['product_id']])) {
                                            ?>
                                            <a href="catalog_products.php?cart_action=add&code=<?php echo($column['product_id']) ?>" <?php echo($column['product_stock'] ? " " : "disabled") ?>
                                               class="btn-floating small waves-effect waves-light orange darken-3 right tooltipped"
                                               data-tooltip="Adicionar ao carrinho" data-delay="5" onclick="Materialize.toast('Adicionado ao carrinho', 500);">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </a>
                                            <br>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="catalog_products.php?cart_action=del&code=<?php echo($column['product_id']) ?>" <?php echo($column['product_stock'] ? " " : "disabled") ?>
                                               class="btn-floating small waves-effect waves-light red darken-3 right tooltipped"
                                               data-tooltip="Remover do carrinho" data-delay="5" onclick="Materialize.toast('Removido do carrinho', 500);">
                                                <i class="material-icons">remove_shopping_cart</i>
                                            </a>
                                            <br>
                                            <?php
                                        }
                                    } else {
                                        $pgselect = new PostgreSQL();
                                        $pgselect->ConnectServer();
                                        $product_id = $column['product_id'];
                                        $pgselect->Query("SELECT cart_amount FROM cart WHERE cart_user = $user_id AND cart_product = $product_id");
                                        if ($pgselect->NumRows()) {
                                            ?>
                                            <a href="catalog_products.php?cart_action=del&code=<?php echo($column['product_id']) ?>" <?php echo($column['product_stock'] ? " " : "disabled") ?>
                                               class="btn-floating small waves-effect waves-light red darken-3 right tooltipped"
                                               data-tooltip="Remover do carrinho" data-delay="5">
                                                <i class="material-icons">remove_shopping_cart</i>
                                            </a>
                                            <br>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="catalog_products.php?cart_action=add&code=<?php echo($column['product_id']) ?>" <?php echo($column['product_stock'] ? " " : "disabled") ?>
                                               class="btn-floating small waves-effect waves-light orange darken-3 right tooltipped"
                                               data-tooltip="Adicionar ao carrinho" data-delay="5">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </a>
                                            <br>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($newRow == 3) { ?>
                            </div>
                            <?php
                        }
                        $z++;
                        $newRow++;
                    }
                } else {
                    ?>
                    <h4 class="orange-text text-darken-3">Nenhum produto foi
                        encontrado.</h4>
                    <?php
                }
                $pgsql->DisconnectServer();
                ?>
                <div class="row">
                    <div class="col l12 center">
                        <ul class="pagination">
                            <li class="waves-effect"><a
                                        href="catalog_products.php?page=1"><i
                                            class="material-icons">chevron_left</i></a>
                            </li>
                            <?php
                            //$page = $_GET['page'];
                            for ($i = 1; $i < $total + 1; $i++) {
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
    </div>
<?php
require "_libs/_footer.php";
?>