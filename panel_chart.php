<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";
?>
	<!--Início do conteúdo da página-->
	<script src="js/sorttable.js"></script>
	<div class="container">
		<div class="row">
			<div class="col s12">
				<h4>Gerar gráficos</h4>
				<h6>Escolha um gráfico e clique sobre para gerar!</h6>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row"></div>
		<div class="row">
			<a href="" onclick="window.open('create_chart.php?gr=0', 'newwindow', 'width=900,height=700'); return false;" class="black-text">
				<div class="col s6 m6">
					<div class="card">
						<div class="card-image">
							<img src="https://i.imgur.com/0NNTVBd.png">
						</div>
						<div class="card-content">
							<span class="card-title black-text"><b>Gráfico de Setor</b></span>
							<p>Clientes por gênero.</p>
						</div>
					</div>
				</div>
			</a>
			<a onclick="window.open('create_chart.php?gr=1', 'newwindow', 'width=900,height=700'); return false;" class="black-text">
				<div class="col s6 m6">
					<div class="card">
						<div class="card-image">
							<img src="https://i.imgur.com/1vK4Iby.png">
						</div>
						<div class="card-content">
							<span class="card-title black-text"><b>Gráfico alguma coisa</b></span>
							<p>Alguma coisa por outra.</p>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="row">
			<a onclick="window.open('create_chart.php?gr=2', 'newwindow', 'width=1000,height=800'); return false;" class="black-text">
				<div class="col s6 m6">
					<div class="card">
						<div class="card-image">
							<img src="https://i.imgur.com/1vK4Iby.png">
						</div>
						<div class="card-content">
							<span class="card-title black-text"><b>Gráfico em Barra</b></span>
							<p>Produto por quantidade vendida.</p>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<!--Fim do conteúdo-->
<?php
	require "_libs/_footeradm.php";
?>