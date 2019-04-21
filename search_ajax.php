<?php
	// Verifica se existe a variável txtnome
	if (isset($_GET["user_name"])) {
		$nome = strtolower($_GET["user_name"]);

		// Verifica se a variável está vazia
		if (!empty($nome) && (strlen($nome) > 1)) {
			// Conexao com o banco de dados
			require "_libs/_postgresql.php";
			$pgsql = new PostgreSQL();
			$pgsql->ConnectSharedServer();
			//echo $nome . "<br>";
			//echo $sql = "SELECT * FROM usuario WHERE login = '$nome'";

			//sleep(1);
			$pgsql->QueryWithoutReturn("SELECT * FROM usuario WHERE login = '$nome'");

			// Verifica se a consulta retornou linhas
			if ($pgsql->NumRows()) {
				?>
                <h6 class="red-text">
                    <i class="material-icons left">close</i>
                    Usuário já está sendo utilizado.
                </h6>
				<?php
			} else {
				?>
                <h6 class="green-text">
                    <i class="material-icons left">done</i>
                    Usuário disponível.
                </h6>
				<?php
			}
		} else {
			?>
            <h6 class="red-text">
                <i class="material-icons left">close</i>
                Digite um usuário válido.
            </h6>
			<?php
		}
		$pgsql->DisconnectServer();
	} else if (isset($_GET['client_email'])) {
		$email = strtolower($_GET['client_email']);
		if (!empty($email) && (strpos($email, "@") && (strpos($email, ".")))) {
			require "_libs/_postgresql.php";
			$pgsql = new PostgreSQL();
			$pgsql->ConnectSharedServer();
			//echo $email."<br>";
			//echo $sql = "SELECT * FROM usuario WHERE email = '$email'";
			$pgsql->QueryWithoutReturn("SELECT * FROM usuario WHERE email = '$email'");
			if ($pgsql->NumRows()) {
				?>
                <h6 class="red-text">
                    <i class="material-icons left">close</i>
                    E-mail está sendo utilizado.
                </h6>
				<?php
			} else {
				?>
                <h6 class="green-text">
                    <i class="material-icons left">done</i>
                    E-mail disponível.
                </h6>
				<?php
			}
		} else {
			?>
            <h6 class="red-text">
                <i class="material-icons left">close</i>
                Digite um e-mail válido.
            </h6>
			<?php
		}
		$pgsql->DisconnectServer();
	} else if (isset($_GET['client_cpf'])) {
		$cpf = $_GET['client_cpf'];
		if (validaCPF($cpf)) {
			require "_libs/_postgresql.php";
			$pgsql = new PostgreSQL();
			$pgsql->ConnectSharedServer();
			$pgsql->QueryWithoutReturn("SELECT * FROM cliente WHERE cpf = '$cpf'");
			if ($pgsql->NumRows()) {
				?>
                <h6 class="red-text">
                    <i class="material-icons left">close</i>
                    Este CPF já está em uso.
                </h6>
				<?php
			} else {
				?>
                <h6 class="green-text">
                    <i class="material-icons left">done</i>
                    CPF disponível.
                </h6>
				<?php
			}
		} else {
			?>
            <h6 class="red-text">
                <i class="material-icons left">close</i>
                Digite um CPF válido.
            </h6>
			<?php
		}
	}


	function validaCPF($cpf) {
		// Verifica se um número foi informado
		if (empty($cpf)) {
			return FALSE;
		}

		// Elimina possivel mascara
		//$cpf = preg_replace('[^0-9]', '', $cpf);
        //$cpf = str_replace(".", "", $cpf);
		//$cpf = str_replace("-", "", $cpf);
		$cpf = preg_replace("/[^0-9]/", "", $cpf);

		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// Verifica se o numero de digitos informados é igual a 11
		if (strlen($cpf) != 11) {
			return FALSE;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' ||
			$cpf == '11111111111' ||
			$cpf == '22222222222' ||
			$cpf == '33333333333' ||
			$cpf == '44444444444' ||
			$cpf == '55555555555' ||
			$cpf == '66666666666' ||
			$cpf == '77777777777' ||
			$cpf == '88888888888' ||
			$cpf == '99999999999') {
			return FALSE;
			// Calcula os digitos verificadores para verificar se o
			// CPF é válido
		} else {

			for ($t = 9; $t < 11; $t++) {

				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return FALSE;
				}
			}
			return TRUE;
		}
	}

?>




