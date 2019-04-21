<?php
    session_start();
    include 'fdpf181\fpdf.php';
    $pgsql = new PostgreSQL();
    $pgsql->ConnectServer();
    $pgsql2 = new PostgreSQL();
    $pgsql2->ConnectServer();

    if(isset($_SESSION['user_id']))
    {
        $pgsql->Query("SELECT * FROM cart WHERE cart_user = ".$_SESSION['user_id']);
        $cart = $pgsql->FetchArray();
        $pgsql2->Query("SELECT * FROM product WHERE product_id = ".$cart['cart_product']." AND product_deleted = false");
        $product = $pgsql2->FetchArray();
        $nome_user = $_SESSION['name'];

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', '22');
        $pdf->Cell(190, 10, utf8_decode( 'Symphlower'), 0, 0, "C");
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', '18');
        $pdf->Cell(190, 10, utf8_decode( 'Relatório de Venda'), 0, 0, "C");
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(50, 7, utf8_decode( 'Nome:'), 1, 0, "C");
        $pdf->Cell(50, 7, utf8_decode( 'Preço Unitário:'), 1, 0, "C");
        $pdf->Cell(50, 7, utf8_decode( 'Quantidade:'), 1, 0, "C");
        foreach($cart as $car)
        {
            $pdf->SetFont('Arial', 'I', '12');
            $pdf->Cell(50, 7, utf8_decode($car['cart_product']), 1, 0, "C");
            $pdf->Cell(50, 7, utf8_decode($product['product_salevalue']), 1, 0, "C");
            $pdf->Cell(50, 7, utf8_decode($car['cart_amount']), 1, 0, "C");
        }
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(150, 7, utf8_decode( 'Preço Total'), 1, 0, "C");
        $pdf->Output();


    }

?>