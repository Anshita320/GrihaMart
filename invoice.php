<?php
ob_start();
session_start();
include("config.php");
require('fpdf/fpdf.php');

if (!isset($_SESSION['user_name'])) {
    die("Unauthorized Access");
}

if (!isset($_GET['id'])) {
    die("Order ID missing");
}

$order_id = mysqli_real_escape_string($conn,$_GET['id']);
$user_name = $_SESSION['user_name'];

/* FETCH ORDER */
$order_query = mysqli_query($conn,
"SELECT * FROM orders WHERE id='$order_id' AND user_name='$user_name'"
);

$order = mysqli_fetch_assoc($order_query);

if(!$order){
    die("Unauthorized Access");
}

/* FETCH ORDER ITEMS */
$items_query = mysqli_query($conn,
"SELECT p.name,p.image,oi.quantity,oi.price
 FROM order_items oi
 JOIN products p ON oi.product_id=p.id
 WHERE oi.order_id='$order_id'"
);

/* CREATE PDF */
$pdf = new FPDF();
$pdf->AddPage();

/* PAGE BORDER */
$pdf->SetLineWidth(0.3);
$pdf->Rect(5,5,200,287);

/* LOGO */
$pdf->Image("images/logo2.png",12,8,36);

/* GRIHAMART TITLE WITHOUT SPACE */

$pdf->SetFont("Arial","B",24);

/* TEXT WIDTH CALCULATION */
$griha_width = $pdf->GetStringWidth("Griha");
$mart_width  = $pdf->GetStringWidth("Mart");
$total_width = $griha_width + $mart_width;

/* CENTER POSITION */
$x = (210 - $total_width) / 2;
$pdf->SetX($x);

/* GRIHA COLOR */
$pdf->SetTextColor(0,121,137);
$pdf->Cell($griha_width,12,"Griha",0,0);

/* MART COLOR */
$pdf->SetTextColor(230,140,30);
$pdf->Cell($mart_width,12,"Mart",0,1);

/* TAGLINE */
$pdf->SetFont("Arial","",11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,6,"Your Home, Our Market",0,1,"C");

$pdf->Ln(5);

/* INVOICE TITLE */
$pdf->SetFont("Arial","B",16);
$pdf->Cell(0,10,"INVOICE",0,1,"C");

/* ORDER INFO */
$pdf->SetFont("Arial","",11);

$pdf->Cell(100,8,"Order ID : ".$order['id'],0,0);
$pdf->Cell(90,8,"Date : ".$order['order_date'],0,1,"R");

$pdf->Cell(100,8,"Customer : ".$order['user_name'],0,0);
$pdf->Cell(90,8,"Order Status : ".$order['status'],0,1,"R");

$pdf->Ln(8);

/* BILL / SHIP */
$pdf->SetFont("Arial","B",11);
$pdf->Cell(95,8,"Bill To",1);
$pdf->Cell(95,8,"Ship To",1);
$pdf->Ln();

$pdf->SetFont("Arial","",10);

$pdf->Cell(95,8,$order['user_name'],1);
$pdf->Cell(95,8,$order['user_name'],1);
$pdf->Ln();

$pdf->Cell(95,8,$order['address'],1);
$pdf->Cell(95,8,$order['address'],1);

$pdf->Ln(12);

/* TABLE HEADER */
$pdf->SetFont("Arial","B",11);
$pdf->SetFillColor(230,230,230);

$pdf->Cell(30,10,"Image",1,0,"C",true);
$pdf->Cell(60,10,"Product",1,0,"C",true);
$pdf->Cell(30,10,"Price",1,0,"C",true);
$pdf->Cell(20,10,"Qty",1,0,"C",true);
$pdf->Cell(50,10,"Subtotal",1,1,"C",true);

$pdf->SetFont("Arial","",10);

$total = 0;

while($item=mysqli_fetch_assoc($items_query)){

$subtotal=$item['price']*$item['quantity'];
$total+=$subtotal;

/* IMAGE FIX */
$x = $pdf->GetX();
$y = $pdf->GetY();

/* IMAGE CELL */
$pdf->Cell(30,20,"",1);

/* IMAGE PATH */
$image = "images/".$item['image'];

if(!empty($item['image']) && file_exists($image)){

    /* IMAGE CENTER POSITION */
    $img_width = 29.5;
    $img_height = 19.5;

    $img_x = $x + (30 - $img_width) / 2;
    $img_y = $y + (20 - $img_height) / 2;

    $pdf->Image($image,$img_x,$img_y,$img_width,$img_height);
}

/* PRODUCT CENTER ALIGN */
$pdf->Cell(60,20,$item['name'],1,0,"C");
$pdf->Cell(30,20,"Rs ".$item['price'],1,0,"C");
$pdf->Cell(20,20,$item['quantity'],1,0,"C");
$pdf->Cell(50,20,"Rs ".$subtotal,1,1,"C");

}

/* TOTAL */
$pdf->SetFont("Arial","B",12);
$pdf->SetFillColor(255,230,153);

$pdf->Cell(140,10,"Grand Total",1,0,"C",true);
$pdf->Cell(50,10,"Rs ".$total,1,1,"C",true);

$pdf->Ln(10);

/* PAYMENT */
$pdf->SetFont("Arial","",11);
$pdf->Cell(0,8,"Payment Method : ".$order['payment_method'],0,1);

/* FOOTER */
$pdf->Ln(15);

$pdf->SetFont("Arial","I",10);
$pdf->Cell(0,8,"Thank you for shopping with GrihaMart!",0,1,"C");
$pdf->Cell(0,8,"Visit Again - www.grihamart.com",0,1,"C");

$pdf->Output("D","GrihaMart_Invoice_".$order_id.".pdf");
exit();