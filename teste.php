<?php

	$html = 'o meu HTML pronto tal como vai para o navegador!';

	$documentTemplate = '
<!doctype html> 
<html> 
 <head>
  <link rel="stylesheet" type="text/css" href="http://www.example.com/style.css">
 </head> 
 <body>
  <div id="wrapper">
   '.$html.'
  </div>
 </body> 
</html>';

	require_once("dompdf/dompdf_config.inc.php");

	if ( get_magic_quotes_gpc() )
		$documentTemplate = stripslashes($documentTemplate);

	$dompdf = new DOMPDF();
	$dompdf->load_html($documentTemplate);
	$dompdf->set_paper("A4", "portrail");
	$dompdf->render();

// enviar documento destino para download
	$dompdf->stream("dompdf_out.pdf");

	exit(0);

?>