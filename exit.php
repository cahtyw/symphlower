<?php
	session_start();
	$_SESSION['login'] = false;
	session_destroy();
	require "_libs/_meta.html";
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
			<h4 class="orange-text text-darken-3">Saindo...</h4>
		</div>
	</div>
<?php
	header("Refresh:1; url=login.php");
?>
