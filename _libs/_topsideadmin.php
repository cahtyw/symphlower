<?php
    session_start();
    //include "_postgresql.php";
    $user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>symphlower - Em desenvolvimento...</title>
    <link rel="icon" href="images/site/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/site/favicon.ico" type="image/x-icon"/>
    <!--Não mexer-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/custom.css"/>
    <link type="text/css" rel="stylesheet" href="css/custom_admin.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
    <script type="text/javascript" src="js/initialize_materialize.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="js/sweetalert/sweetalert.js"></script>
</head>
<body>
<div id="global-site">
    <header>
        <nav>
            <div class="nav-wrapper white">
                <ul id="nav-mobile" class="right grey-text">
                    <li><a class="black-text" href="index.php"><i class="material-icons left">home</i>Área do
                            usuário</a></li>
                </ul>
	            <ul id="nav-mobile" class="right grey-text">
		            <li><a class="black-text" href="panel_admin.php"><i class="material-icons left">home</i>Área do
		                                                                                                    administrador</a></li>
	            </ul>
            </div>
        </nav>
    </header>
    <ul id="slide-out" class="side-nav fixed">
        <li>
            <div class="user-view">
                <div class="background center-align ">
                    <a href="panel_admin.php">
                        <img src="images/site/logo.png">
                    </a>
                </div>
                <br>
                <div>
                    <span class="black-text name">Olá, <?php echo $_SESSION['name'] ?>!</span>
                </div>
                <div>
                    <span class="black-text email">Você está no modo administrador!</span>
                </div>
            </div>
        </li>
        <li>
            <div class="divider"></div>
        </li>
        <div class="user-menu">
            <li>
                <a class="subheader">
                    Contas
                </a>
            </li>
            <li>
                <a href="panel_admin_list.php" class="waves-light waves-effect">
                    <i class="material-icons">work</i>Administradores
                </a>
            </li>
            <li>
                <a href="panel_users.php" class="waves-light waves-effect">
                    <i class="material-icons">account_circle</i>Usuários
                </a>
            </li>
            <li>
                <div class="divider"></div>
            </li>
            <li>
                <a class="subheader">
                    E-commerce
                </a>
            </li>
            <li>
                <a href="panel_item.php" class="waves-light waves-effect">
                    <i class="material-icons">motorcycle</i>Produtos
                </a>
            </li>
            <li>
                <a href="panel_orders.php" class="waves-light waves-effect">
                    <i class="material-icons">shopping_cart</i>Vendas
                </a>
            </li>
            <li>
                <div class="divider"></div>
            </li>
            <li>
                <a class="subheader">
                    Relatórios
                </a>
            </li>
            <li>
                <a href="panel_info.php" class="waves-light waves-effect">
                    <i class="material-icons">details</i>Detalhes
                </a>
            </li>
            <li>
                <a href="panel_chart.php" class="waves-light waves-effect">
                    <i class="material-icons">assessment</i>Gráficos
                </a>
            </li>
            <li>
                <div class="divider"></div>
            </li>
            <li>
                <a class="subheader">
                    Outros
                </a>
            </li>
            <li>
                <a href="#!" class="waves-light waves-effect">
                    <i class="material-icons">build</i>Changelogs
                </a>
            </li>
            <li>
                <a href="#!" class="waves-light waves-effect">
                    <i class="material-icons">grid_on</i>Tabelas
                </a>
            </li>
        </div>
    </ul>
    <main class="">