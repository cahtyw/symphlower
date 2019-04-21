<?php
session_start();

require "_postgresql.php";

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['code']);

if ($_GET['do'] == "up") {
	if (isset($_SESSION['login'])) {
		$pgsql = new PostgreSQL();
		$pgsql->ConnectServer();
		$pgsql->Query("UPDATE cart SET cart_amount = (cart_amount + 1) WHERE cart_user = $user_id AND cart_product = $product_id");
		$pgsql->DisconnectServer();
		$pgsql = NULL;
	}
	$_SESSION['cart'][$product_id]++;
}

if ($_GET['do'] == "down") {
	if (isset($_SESSION['login'])) {
		$pgsql = new PostgreSQL();
		$pgsql->ConnectServer();
		$pgsql->Query("UPDATE cart SET cart_amount = (cart_amount - 1) WHERE cart_user = $user_id AND cart_product = $product_id");
		$pgsql->DisconnectServer();
		$pgsql = NULL;
	}
	$_SESSION['cart'][$product_id]--;
}
?>
