<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";

	if(isset($_GET['ac'])) {
		$pg = new PostgreSQL();
		$pg->ConnectServer();
		$user_id = $_GET['uid'];
		switch($_GET['ac']) {
			case "set":
				try {
					$pg->Query("UPDATE users SET user_level = 1337 WHERE user_id = $user_id");
				}
				catch(Exception $e) {
					$pg->Query("UPDATE users SET user_level = 1337 WHERE user_id = $user_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
				}

				break;
			case "unset":
				try {
					$pg->Query("UPDATE users SET user_level = 1 WHERE user_id = $user_id");
				}
				catch(Exception $e) {
					$pg->Query("UPDATE users SET user_level = 1 WHERE user_id = $user_id");
					?>
					<script>swal("Erro.", "Aconteceu algo de errado, tente novamente.", "warning");</script>
					<?php
					throw new Exception("Algo de errado aconteceu ao tentar excluir.");
				}
				break;
		}
		$pg->DisconnectServer();
		$pg = NULL;
		?>
		<script>window.location.href = "panel_admin_list.php"</script>
		<?php
	}

	$pg = new PostgreSQL();
	$pg->ConnectServer();
	$pg->Query("SELECT * FROM users ORDER BY user_level ASC, user_id DESC");
	$user_amount = $pg->NumRows();
	$pg->DisconnectServer();
	$pg = NULL;
?>
	<!--Início do conteúdo da página-->
	<div class="container">
		<div class="row">
			<div class="col s8">
				<div class="col s12">
					<h4>Usuários e administradores</h4>
					<h5>(<?php echo $user_amount ?> usuários cadastrados encontrados no total)</h5>
				</div>
				<div class="col s12">
					<h6>Aqui você pode visualizar todos os usuários e gerenciar administradores.</h6>
				</div>
			</div>
			<!--Início da pesquisa-->
			<div class="col s4">
				<br>
				<br>
				<div class="row input-field">
					<form action="panel_admin_list.php" method="get">
						<div class="col s8">
							<input name="sr" value="<?php echo((isset($_GET['sr'])) ? $_GET['sr'] : '') ?>" type="text" id="search_bar" required>
							<label for="search_bar">Pesquisar</label>
						</div>
						<div class="col s2">
							<button class="btn-flat tooltipped large waves-effect waves-light" type="submit" data-delay="5" data-tooltip="Pesquisar">
								<i class="material-icons">search</i>
							</button>
						</div>
						<div class="col s2">
							<a class="btn-flat tooltipped large waves-effect waves-light" onclick="window.location.href = 'panel_admin_list.php';" data-delay="5" data-tooltip="Limpar filtro">
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
						<th>Tipo</th>
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
						if($pg->NumRows()) {
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
                            $limite->Query("SELECT * FROM usuario LIMIT  $total_reg OFFSET  $inicio");


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
									$usuario = $pguser->FetchArray();
									$pguser->DisconnectServer();
									$user_id == $_SESSION['user_id'] ? $me = TRUE : $me = FALSE;
									?>
									<tr class="<?php echo(($me) ? 'red-text' : '') ?>">
										<th width="50px">
											<a data-tooltip="Ver tudo" data-position="bottom" data-delay="30" class="new-page <?php echo(($me) ? 'red-text' : 'black-text') ?> tooltipped" onclick="window.open('panel_users_details.php?user_id=<?php echo $usuario["id_usuario"] ?>', 'newwindow', 'width=650,height=700'); return false;" href='panel_users_details.php?user_id=<?php echo $usuario["id_usuario"] ?>'>
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
										<td>
											<?php echo ($prod['user_level'] == 1337) ? 'Administrador' : 'Usuário' ?>
										</td>
										<td>
											<?php
												$name_user = $usuario['login'];
												if($prod['user_level'] == 1337) {
													?>
													<a href="javascript:;" onclick="unsetAdmin(<?php echo $user_id ?>, '<?php echo $name_user ?>')" class="btn-floating <?php echo(($user_id == $_SESSION['user_id']) ? 'disabled' : '') ?> orange darken-3 waves-effect waves-light tooltipped" data-tooltip="Tornar usuário" data-position="bottom" data-delay="30">
														<i class="material-icons">stars</i>
													</a>
													<?php
												}
												else {

													?>
													<a href="javascript:;" onclick="setAdmin(<?php echo $user_id ?>, '<?php echo $name_user ?>')" class="btn-floating <?php echo(($user_id == $_SESSION['user_id']) ? 'disabled' : '') ?> green waves-effect waves-light tooltipped" data-tooltip="Tornar administrador" data-position="bottom" data-delay="30">
														<i class="material-icons">person</i>
													</a>
													<?php
												}
											?>
											<?php
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