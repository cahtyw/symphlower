<?php
	session_start();

	require "_libs/_postgresql.php";
	require "_libs/_meta.html";



	$user_name = strtolower($_POST['user_name']);
	$user_password = md5($_POST['user_password']);
	$pgsql = new PostgreSQL();
	$pgsql->ConnectSharedServer();
	$pgsql->Query("SELECT * FROM usuario WHERE (login = '$user_name' OR email = '$user_name') AND senha = '$user_password' AND excluido = 'n'");
	if ($pgsql->NumRows() > 0) {
		$line = $pgsql->FetchArray();
		$user_id = $line['id_usuario'];
		$_SESSION['email'] = $line['email'];
		$pgsql->Query("SELECT * FROM cliente WHERE id_usuario = $user_id");
		$line = $pgsql->FetchArray();
		$pgaddress = new PostgreSQL();
		$pgaddress->ConnectSharedServer();
		$pgaddress->Query("SELECT id_endereco FROM endereco WHERE id_usuario = $user_id AND excluido = 'n'");
		$end = $pgaddress->FetchArray();
		$_SESSION['address'] = $end['id_endereco'];
		/*$_SESSION['address'] = array();
		$i = 0;
		while($end = $pgaddress->FetchArray()){
			$_SESSION['address'][$i] = $end['id_endereco'];
			$i++;
		}*/
		$_SESSION['user_id'] = $line['id_usuario'];
		$_SESSION['login'] = TRUE;
		$_SESSION['name'] = $line['nome'];
		$_SESSION['surname'] = $line['sobrenome'];
		$pgsql->DisconnectServer();
		$pgsql->ConnectServer();
        //echo "<BR>PRIMEIRO TRY";
        $pgsql->Query("SELECT * FROM users WHERE user_id = $user_id");
        if(!$pgsql->NumRows()){
            try {
                $pgsql->QueryWithoutReturn("INSERT INTO users VALUES($user_id, 1)");
            }
            catch (Exception $e){
                ?>
                <script>alert("<?php echo $e ?>")</script>
                <?php
            }
        }
		$line = $pgsql->FetchArray();
		if ($line['user_level'] != 1 && $line['user_level'] != 1337) {
            ?>
            <?php
			//echo "<BR>PRIMEIRO IF $level";
			try {
				//echo "<BR>SEGUNDO TRY";
				$pgsql->Query("UPDATE users SET user_level = 1 WHERE user_id = $user_id");
				$_SESSION['level'] = 1;
			} catch (Exception $ex) {
				//echo "<BR>SEGUNDO CATCH";
				$pgsql->Query("INSERT INTO users VALUES($user_id, 1)");
				$_SESSION['level'] = 1;
			}
		} else {
			$_SESSION['level'] = $line['user_level'];
		}

		if(isset($_SESSION['cart'])){
		    $pgsql->Query("SELECT * FROM product WHERE product_id = (SELECT MAX(product_id) FROM product)");
            $max = $pgsql->FetchArray();
		    for($i=1;$i<=$max['product_id'];$i++){
                if(isset($_SESSION['cart'][$i])){
                    $cart_amount = $_SESSION['cart'][$i];
                    $pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id AND cart_product = $i");
                    if ($pgsql->NumRows()) {
                        $pgsql->Query("UPDATE cart SET cart_amount = ($cart_amount) WHERE cart_user = $user_id AND cart_product = $i");
                    } else {
                        $pgsql->Query("INSERT INTO cart VALUES($user_id, $i, $cart_amount)");
                    }
                }
            }
        }

		$pgsql->Query("SELECT * FROM cart WHERE cart_user = $user_id");
		if($pgsql->NumRows()){
            for($i=0;$i<$pgsql->NumRows();$i++){
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }
                $line = $pgsql->FetchArray();
                $_SESSION['cart'][$line['cart_product']] = $line['cart_amount'];
            }
        }


		$pgsql->DisconnectServer();
		?>
        <br>
        <br>
        <br>
        <br>
        <div class="global-loading">
            <div class="loading">
                <img src="images/site/loading_logo.png">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
                <h4 class="orange-text text-darken-3">Login efetuado com sucesso...</h4>
            </div>
        </div>
		<?php

		$_SESSION['login_error'] = FALSE;
		//$pgsql->DisconnectServer();
		header("Refresh:1; url=index.php");
	} else {
		$pgsql->DisconnectServer();
		$_SESSION['login_error'] = TRUE;
		$_SESSION['cart'] = null;
		header("Refresh:0; url=login.php");
	}


?>

<!--
--><?php
	/*	session_start();

		require_once "conexao.php";
		$user=$_POST['user'];
		$senha=$_POST['senha'];
		$senhaNova= md5($senha);
		$sql="select * from users where user_login = '$user' and user_password = '$senhaNova'";
		$result= pg_query($connect,$sql);
		$qtd=pg_num_rows($result);
		if($qtd>0)
		{
			$linha= pg_fetch_array($result);
			$_SESSION["logou"]="s";
			$_SESSION["email"]=$linha['user_login'];
			echo "Você foi autenticado ".$_SESSION['email'];
			//echo "<script>LoginFeito()</script";
		}
		else
		{
			echo "email ou login inválidos,aguarde um instante";
			//echo "<script>loginFalhou()</script>";
		}
	*/ ?>

