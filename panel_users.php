<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";
	if(isset($_POST['item_registred'])) {
		$pgCompar = new PostgreSQL();
		$pgCompar->ConnectSharedServer();
		$pg = new PostgreSQL();
		$user_name = $_POST['user_name'];

		$user_level = $_POST['user_level'];
		$user_login = $_POST['login'];
		$user_password = $_POST['senha'];
		$user_email = $_POST['email'];

		$pg->ConnectServer();

		$pgCompar->Query("INSERT INTO usuario VALUES(DEFAULT, '$user_login', '$user_email', '$user_password', 'n', null, null)");
		$pgCompar->Query("SELECT id_usuario FROM usuario WHERE login = '$user_login'");
		$line = $pgCompar->FetchArray();
		$user_id = $line['id_usuario'];
		$pg->Query("INSERT INTO users VALUES('$user_id', '$user_level') ");
		if($pg->AffectedRows() && $pgCompar->AffectedRows()) {
			?>
			<script>alert("Produto salvo com sucesso!")</script>
			<?php
		}
		$pg->DisconnectServer();
		$pg = NULL;
		$pgCompar->DisconnectServer();
		$pgCompar = NULL;
		header("Refresh:1; url=panel_item.php");
		?>
		<script>alert("Erro no cadastro");</script>
		<?php
	}
	if(isset($_GET['act'])) {
		$pg = new PostgreSQL();
		$pg->ConnectSharedServer();
		$user_id = $_GET['user_id'];
		switch($_GET['act']) {
			case "delete":
				try {
					$pg->Query("UPDATE usuario SET excluido = 's' WHERE id_usuario = $user_id");
					$pg->Query("UPDATE cliente SET excluido = 's' WHERE id_usuario = $user_id");
				}
				catch(Exception $e) {
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
					$pg->Query("UPDATE usuario SET excluido = 'n' WHERE id_usuario = $user_id");
					$pg->Query("UPDATE cliente SET excluido = 'n' WHERE id_usuario = $user_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
				}
				break;
			case "reset":
				try {
					$pg->Query("UPDATE usuario SET excluido = 'n' WHERE id_usuario = $user_id");
					$pg->Query("UPDATE cliente SET excluido = 'n' WHERE id_usuario = $user_id");
				}
				catch(Exception $e) {
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
					$pg->Query("UPDATE usuario SET excluido = 's' WHERE id_usuario = $user_id");
					$pg->Query("UPDATE cliente SET excluido = 's' WHERE id_usuario = $user_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
				}
				break;
			case "edit":
				break;
		}
		$pg->DisconnectServer();
		$pg = NULL;
		?>
		<script>window.location.href = "panel_users.php"</script>
		<?php
	}

	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM users ORDER BY user_id");
	$user_amount = $pg->NumRows();
	$pg->DisconnectServer();
	$pg = NULL;
?>
	<!--Início do Modal de cadastro-->
	<div id="modal" class="modal">
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="modal-content">
				<div class="row">
					<div class="col s8">
						<h4 class="orange-text text-darken-3">
							<i class="material-icons">
								shopping_cart
							</i>
							Cadastrar Usuário
						</h4>
						<h6>Siga os passos abaixo para adicionar um usuário.</h6>
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
						<input id="name" placeholder="Ex: Caio Lucas Teixeira Ferraz de Oliveira" autocomplete="off"
							maxlength="150" type="text" required name="user_name" class="validate">
						<label for="name" class="active" data-error="Insira um usuario">Nome do Usuário:</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">extension</i>
						<select required name="user_level">
							<option value="" disabled selected>Escolha uma opção</option>
							<option value="1337">Administrador</option>
							<option value="1">Clientes</option>
						</select>
						<label>Nível de acesso:</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s8">
						<i class="material-icons prefix">create</i>
						<input id="name" placeholder="Ex: caio" autocomplete="off" maxlength="150" type="text" required
							name="login" class="validate">
						<label for="name" class="active" data-error="Insira um login">Login do Usuário:</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s8">
						<i class="material-icons prefix">create</i>
						<input id="name" placeholder="Ex: caio_ltfo@outlook.com" autocomplete="off" maxlength="150"
							type="text" required name="email" class="validate">
						<label for="name" class="active" data-error="Insira um e-mail">E-mail do Usuário:</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s8">
						<i class="material-icons prefix">create</i>
						<input id="name" placeholder="12344321" autocomplete="off" maxlength="150" type="password"
							required name="senha" class="validate">
						<label for="name" class="active" data-error="Insira uma Senha">Senha do Usuário:</label>
					</div>
				</div>
			</div>
			<input type="hidden" name="item_registred">
			<div class="modal-footer">
				<button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat">Cadastrar
				</button>
			</div>
		</form>
	</div>
	<!--Fim do modal-->
	<!--Início do conteúdo da página-->
	<script src="js/sorttable.js"></script>
	<div class="container">
		<div class="row">
			<div class="col s8">
				<div class="col s12">
					<h4>Listagem de Usuários</h4>
					<h5>(<?php echo $user_amount ?> usuários cadastrados encontrados no total)</h5>
				</div>
				<div class="col s12">
					<h6>Aqui você pode visualizar todos os usuários e cadastrar novos.</h6>
				</div>
			</div>
			<!--Início da pesquisa-->
			<div class="col s4">
				<br>
				<br>
				<div class="row input-field">
					<form action="panel_users.php" method="get">
						<div class="col s8">
							<input name="sr" value="<?php echo ((isset($_GET['sr'])) ? $_GET['sr'] : '') ?>" type="text" id="search_bar" required>
							<label for="search_bar">Pesquisar</label>
						</div>
						<div class="col s2">
							<button class="btn-flat tooltipped large waves-effect waves-light" type="submit" data-delay="5" data-tooltip="Pesquisar">
								<i class="material-icons">search</i>
							</button>
						</div>
						<div class="col s2">
							<a class="btn-flat tooltipped large waves-effect waves-light" onclick="window.location.href = 'panel_users.php';" data-delay="5" data-tooltip="Limpar filtro">
								<i class="material-icons">close</i>
							</a>
						</div>
					</form>
				</div>
			</div>
			<!--Fim da pesquisa-->
		</div>
		<div class="row">
			<table class="striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome e sobrenome</th>
						<th>Usuário</th>
						<th>E-mail</th>
						<th>C.e.</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<!--<tr>
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
					</tr>-->
					<?php
                        $total_reg = 15;
                        $pg = new PostgreSQL();
                        $pg->ConnectServer();
                        $pg->Query("SELECT * FROM users ORDER BY user_id");
                        if ($pg->NumRows()) {
                            $pguser = new PostgreSQL();
                            $pgbuy = new PostgreSQL();
                            $pgname = new PostgreSQL();
                            $psql = new PostgreSQL();
                            $psql->ConnectServer();
                            $psql->Query("SELECT * FROM users ORDER BY user_id");

                            $pagina = $_GET['pagina'];
                            if (!$pagina) {
                                $pc = "1";
                            } else {
                                $pc = $pagina;
                            }

                            $inicio = $pc - 1;
                            $inicio = $inicio * $total_reg;

                            $limite = new PostgreSQL();
                            $limite->ConnectSharedServer();
                            $limite->Query("SELECT id_usuario, login, email FROM usuario WHERE excluido = 'n' LIMIT  $total_reg OFFSET  $inicio");
                            $tr = $psql->NumRows();
                            $tp = $tr / $total_reg;
							while($prod = $limite->FetchArray()) {
								$user_id = $prod['id_usuario'];
								$pguser->ConnectSharedServer();
								if(isset($_GET['sr'])) {
									$search = strtolower($_GET['sr']);
									//$pguser->Query("SELECT * FROM usuario WHERE (LOWER(login) LIKE '%$search%') AND id_usuario = $user_id");
									$pguser->Query("SELECT * FROM usuario LEFT JOIN cliente ON LOWER(usuario.login) LIKE '%$search%' OR (LOWER(cliente.nome) LIKE '%$search%' OR LOWER(cliente.sobrenome) LIKE '%$search%') WHERE usuario.id_usuario = $user_id AND cliente.id_usuario = $user_id");
								}
								else {
									$pguser->Query("SELECT * FROM usuario WHERE id_usuario = $user_id");
								}
								if($pguser->NumRows()) {
                                    $pguser->ConnectSharedServer();
                                    $pguser->Query("SELECT * FROM usuario WHERE id_usuario = $user_id");
                                    $usuario = $pguser->FetchArray();
                                    $pguser->DisconnectServer();
                                    $user_id == $_SESSION['user_id'] ? $me = TRUE : $me = FALSE;
									?>
									<tr class="<?php echo(($me) ? 'red-text' : '') ?> <?php echo(($usuario['excluido'] == 's') ? 'black-text red accent-1' : '') ?>">
										<th width="50px">
											<a data-tooltip="Ver tudo" data-position="bottom" data-delay="30"
												class="new-page <?php echo(($me) ? 'red-text' : 'black-text') ?> tooltipped"
												onclick="window.open('panel_users_details.php?user_id=<?php echo $usuario["id_usuario"] ?>', 'newwindow', 'width=650,height=700'); return false;"
												href='panel_users_details.php?user_id=<?php echo $usuario["id_usuario"] ?>'>
												<?php echo $usuario['id_usuario'] ?>
											</a>
										</th>
										<td>
											<?php
												$pgname->ConnectSharedServer();
												$pgname->Query("SELECT * FROM cliente WHERE id_usuario = $user_id");
												if($pgname->NumRows()) {
													$name = $pgname->FetchArray();
													echo($name['nome'] . " " . $name['sobrenome']);
												}
												else {
													echo "[Desconhecido]";
												}
												$pgname->DisconnectServer();
											?>
										</td>
										<td>
											<?php echo $usuario['login'] ?>
										</td>
										<td>
											<?php echo $usuario['email'] ?>
										</td>
										<td width="50px">
											<?php
												$pgbuy->ConnectServer();
												$pgbuy->Query("SELECT order_user FROM orders WHERE order_user = $user_id AND order_active = TRUE");
												$qtde = $pgbuy->NumRows();
												echo $qtde;
												$pgbuy->DisconnectServer();
											?>
										</td>
										<td>
											<?php
												if($usuario['excluido'] == 'n') {
													?>
													<a href="javascript:;" onclick="deleteUser(<?php echo $user_id ?>)"
														class="btn-floating <?php echo(($user_id == $_SESSION['user_id']) ? 'disabled' : '') ?> red darken-3 waves-effect waves-light tooltipped"
														data-tooltip="Excluir" data-position="bottom" data-delay="30">
														<i class="material-icons">close</i>
													</a>
													<?php
												}
												else {
													?>
													<a href="javascript:;" onclick="resetUser(<?php echo $user_id ?>)"
														class="btn-floating <?php echo(($user_id == $_SESSION['user_id']) ? 'disabled' : '') ?> green waves-effect waves-light tooltipped"
														data-tooltip="Restaurar" data-position="bottom" data-delay="30">
														<i class="material-icons">check</i>
													</a>
													<?php
												}
											?>

										</td>
									</tr>
									<?php
								}
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