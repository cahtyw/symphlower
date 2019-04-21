<?php
	$connect = pg_connect("host=localhost port=5432 dbname=2017_cadastro_compartilhado user=alunocti password=alunocti");
	if(!$connect)
		echo("Não foi possível conectar com o Banco de Dados.");
?>
<?php
	$sql = "SELECT * FROM cliente";
	$resultado = pg_query($sql);
	$cont_masculino = 0;
	$cont_feminino = 0;
	$cont_nao_informado = 0;
	while ($linha = pg_fetch_assoc($resultado)){
		if($linha['sexo'] == 'f'){
			$cont_feminino++;
		}else if($linha['sexo'] == 'm'){
			$cont_masculino++;
		}else{
			$cont_nao_informado++;
		}
	}
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['Feminino',     <?php echo $cont_feminino; ?>],
          ['Masculino',      <?php echo $cont_masculino; ?>],
          ['Não informado',  <?php echo $cont_nao_informado; ?>],
        ]);

        var options = {
          title: 'Clientes por gênero'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>






