</div>
<?php
if ($_SESSION['level'] == 1337) {
    ?>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large orange darken-3 pulse tooltipped" href="panel_admin.php" data-delay="20" data-tooltip="Painel do administrador" data-position="left">
            <i class="large material-icons">star</i>
        </a>
        <!--<ul>
            <li>
                <a href="panel_admin.php" class="btn-floating orange darken-3 pulse tooltipped" data-delay="20" data-tooltip="Acessar painel" data-position="left">
                    <i class="material-icons">forward</i>
                </a>
            </li>-->
            <!--<li>
                <a class="btn-floating black tooltipped" data-delay="20" data-tooltip="Relatórios" data-position="left">
                    <i class="material-icons">multiline_chart</i>
                </a>
            </li>
            <li>
                <a class="btn-floating black tooltipped" data-delay="20" data-tooltip="Reports" data-position="left">
                    <i class="material-icons">report</i>
                </a>
            </li>-->
        <!--</ul>-->
    </div>
    <?php
}
?>
<footer class="page-footer orange darken-2">
    <div class="container">
        <div class="row">
            <div class="col l5">
                <h5 class="white-text">Desenvolvedores:</h5>
                <h6 class="white-text">01 - Caio Lucas Teixeira Ferraz de Oliveira</h6>
                <h6 class="white-text">03 - Gabriel dos Santos Gonçalves</h6>
                <h6 class="white-text">04 - Gisele Reis de Almeida</h6>
                <h6 class="white-text">05 - Isabella Prado da Silva</h6>
                <h6 class="white-text">07 - José Almino de Araújo Júnior</h6>
            </div>
            <div class="col l3">
                <!--<h5>Rede social</h5>-->
                <h5 class="white-text">Mapa do site</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="index.php">Página Inicial</a></li>
                    <li><a class="grey-text text-lighten-3" href="catalog_products.php">Produtos</a></li>
                    <li><a class="grey-text text-lighten-3" href="#">Sobre</a></li>
                    <li><a class="grey-text text-lighten-3" href="#">Contato</a></li>
                </ul>
            </div>
	        <div class="col l4">
		        <h5 class="white-text">Apoio:</h5>
		        <img src="https://i.imgur.com/ZSDXzVT.png">
	        </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2017 Symphlower. Todos os direitos reservados.
            <!--<a class="grey-text text-lighten-4 right" href="#!">More Links</a>-->
        </div>
    </div>
</footer>
</body>
</html>