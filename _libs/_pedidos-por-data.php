<?php
	$connect = pg_connect("host=localhost port=5432 dbname=2017_72d_01_03_04_05_07 user=alunocti password=alunocti");
	if(!$connect)
		echo("Não foi possível conectar com o Banco de Dados.");
?>
<?php
	$lista = array();
	$qtde = array();
	$cor = array();
	
	/*for($cor = 0; $cor <= 20; $cor++){
		$cor[] = '#0000ff';
	}*/
	
	$cor[0] = '#B22222';
	$cor[1] = '#FFA500';
	$cor[2] = '#006600';
	$cor[3] = '#ff0066';
	$cor[5] = '#2F4F4F';
	$cor[6] = '#FFDEAD';
	$cor[7] = '#000000';
	$cor[8] = '#696969';
	$cor[9] = '#000080';
	$cor[10] = '#FFAEB9';
	$cor[11] = '#FFFF00';
	$cor[12] = '#FF00FF';
	$cor[13] = '#D8BFD8';
	$cor[14] = '#F0FFFF';
	$cor[15] = '#FFA500';
	
	$i = 0;
	$sql = "SELECT order_date, order_id FROM orders";
	$resultado = pg_query($sql);
	while ($row = pg_fetch_object($resultado)){
		$data = $row->order_date;
		$order = $row->order_id;
		$lista[$i] = $data;
		$qtde[$i] = $order;
		$i = $i + 1;
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset= "utf-8">
        <meta name="author" content="Jose Almino" />  
        <title> </title>
    </head>
    <body>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load("current", {packages:['corechart']});
			google.charts.setOnLoadCallback(drawChart);  
			function drawChart() {
			  var data = google.visualization.arrayToDataTable([
				["Element", "Quantidade", { role: "style" } ],
				<?php
					$k = $i;
					for($i = 0; $i < $k; $i++){
					?>
					['<?php echo $lista[$i] ?>', <?php echo $qtde[$i] ?>, '<?php echo $cor[$i] ?>'],
					<?php } ?>	
			  ]);

			  var view = new google.visualization.DataView(data);
			  view.setColumns([0, 1,
							   { calc: "stringify",
								 sourceColumn: 1,
								 type: "string",
								 role: "annotation" },
							   2]);

			  var options = {
				title: "Quantidade de produtos vendido por data",
				width: 900,
				height: 700,
				bar: {groupWidth: "95%"},
				legend: { position: "none" },
			  };
			  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
			  chart.draw(view, options);
		  }
		  </script>
		<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
    </body>
</html>

