<?php
	session_start();
	require "_libs/_topsideadmin.php";
	require "_libs/_postgresql.php";
?>
<div class="container">
	<h3>Bem-vindo ao modo administrador!</h3>
	<h6>Este recurso está em fase teste e poderá (ou não) ser aplicado ao site oficial.</h6>
	<div class="divider"></div>
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s2">
				<div class="icon-block">
					<h2 class="center black-text">
						<img src="https://i.imgur.com/PFHDGID.png" width="100px" class="circle"></h2>
					<h5 class="center">Caio</h5>
					<p class="light">Back-end dev.</p>
				</div>
			</div>
			<div class="col s2">
				<div class="icon-block">
					<h2 class="center black-text">
						<img src="https://i.imgur.com/4yfEEbk.png" width="100px" class="circle"></h2>
					<h5 class="center"><b>Gabriel</b></h5>
					<p class="light">Front-end and back-end developer.<br>CEO of Symphlower CO.</p>
				</div>
			</div>
			<div class="col s2">
				<div class="icon-block">
					<h2 class="center black-text">
						<img src="https://i.imgur.com/AALZSPl.png" width="100px" class="circle"></h2>
					<h5 class="center">Gisele</h5>
					<p class="light">Back-end dev.</p>
				</div>
			</div>
			<div class="col s2">
				<div class="icon-block">
					<h2 class="center black-text">
						<img src="https://i.imgur.com/zlg3iYR.png" width="100px" class="circle"></h2>
					<h5 class="center">Isabella</h5>
					<p class="light">Back-end dev.<br>Marketing consultant.</p>
				</div>
			</div>
			<div class="col s2">
				<div class="icon-block">
					<h2 class="center black-text">
						<img src="https://i.imgur.com/EChXdgk.png" width="100px" class="circle"></h2>
					<h5 class="center">José</h5>
					<p class="light">Front-end and back-end developer.</p>
				</div>
			</div>
			<br><br>
		</div>
	</div>
	<?php
		require "_libs/_footeradm.php";
	?>
