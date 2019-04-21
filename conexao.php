<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Jose Almino" />
    </head>
    <body>
        <?php
            $connect = pg_connect("host=localhost port=5432 dbname=2017_cadastro_compartilhado user=alunocti password=alunocti");
            if(!$connect)
                echo("Não foi possível conectar com o Banco de Dados.");
        ?>
    </body>
</html>
