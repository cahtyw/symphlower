<?php
    $connect = pg_connect("host=localhost port=5432 dbname=2017_cadastro_compartilhado user=alunocti password=alunocti");
    if(!$connect)
        echo("Não foi possível conectar com o Banco de Dados.");
?>
<?php
    $id_usuario=$_POST["id_usuario"];
    $nome=$_POST["nome"];
    $sobrenome=$_POST["sobrenome"];
    $cpf=$_POST["cpf"];
    $sexo=$_POST["sexo"];
    $data_nasc=$_POST["data_nasc"];
    $telefone=$_POST["telefone"];
    $celular=$_POST["celular"];
    $sql="update cliente
            set
            nome = '$nome',
            sobrenome = '$sobrenome',
            cpf = '$cpf',
            sexo = '$sexo',
            data_nasc = '$data_nasc',
            telefone = '$telefone',
            celular = '$celular'
            where id_usuario = $id_usuario";
    $resultado=pg_query($connect,$sql);
    $qtde=pg_affected_rows($resultado);

    if ($qtde > 0)
    {
        echo "<script type='text/javascript'>alert('Dados do cliente alterado e gravado com sucesso.')</script>";
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=registration_data.php?id_usuario=$id_usuario'>";
    }
?>