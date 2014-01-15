<?php
use app\extensions\action\Functions;
$function = new Functions();

ini_set('memory_limit', '-1');

$pdf =& $this->Pdf;
$this->Pdf->setCustomLayout(array(
    'header'=>function() use($pdf){
        list($r, $g, $b) = array(200,200,200);
        $pdf->SetFillColor($r, $g, $b); 
        $pdf->SetTextColor(0 , 0, 0);
        $pdf->Cell(0,15, 'In Bitcoin We Trust: Paper / Cold Storage', 0,1,'C', 1);
        $pdf->Ln();
    },
    'footer'=>function() use($pdf){
        $footertext = sprintf('Copyright © %d https://ibwt.co.uk. All rights reserved.', date('Y')); 
        $pdf->SetY(-10); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'', 8); 
        $pdf->Cell(0,8, $footertext,'T',1,'C');
    }

));

$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetAuthor('https://ibwt.co.uk');
$pdf->SetCreator('support@ibwt.co.uk');
$pdf->SetSubject('In Bitcoin We Trust, Print ');
$pdf->SetKeywords('In Bitcoin We Trust, IBWT, Print');
$pdf->SetTitle('In Bitcoin We Trust, https://ibwt.co.uk');


$pdf->SetAutoPageBreak(true);

foreach($data as $d){
	$value = "";

			if($d['address'] != ""){
				$address = $d['address'];
				$private = $d['key'];		
				$btc = $value." BTC";
				$btcword = ucwords($function->number_to_words($value))." BTC";
				$image = '0';
		//		print_r($address);
				$pdf->AddPage('P');
				$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-ibwt-v.jpg', 30, 10, 143, 267, '', '', '', false, 300, '', false, false, 0);
				
				$pdf->SetTextColor(0, 0, 0);
				
				$pdf->SetFont($textfont,'B',20); 
				$pdf->SetXY(40,70,false);
				$pdf->Cell(0,13, $btc, 0,1,'L');
				$pdf->SetFont($textfont, 'B', 6);
				$pdf->SetXY(40,74,false);
				$pdf->Cell(0,13, $btcword, 0,10,'L');
				
				$pdf->Image(QR_OUTPUT_DIR.$address.".png", 90, 25, 55, 55, 'PNG', '', '', true, 300, '', false, false, 1, false, false, false);
				
				$pdf->SetFont($textfont, 'B', 9);
				$pdf->SetXY(51,109,false);
				$pdf->Cell(0,0, $private, 0,10,'L');
				
				
				$pdf->Image(QR_OUTPUT_DIR.$private.".png", 58, 117, 61, 61, 'PNG', '', '', true, 300, '', false, false, 1, false, false, false);
				
				
				$pdf->SetFont($textfont, 'B', 9);
				$pdf->SetXY(82,88,false);
				$pdf->Cell(0,0, $address, 0,10,'L');
				
				$pdf->SetXY(120,166,false);
				$pdf->SetFont($textfont,'B',20); 
				$pdf->Cell(0,13, $btc, 0,1,'L');
				$pdf->SetFont($textfont, 'B', 6);
				$pdf->SetXY(120,170,false);
				$pdf->Cell(0,13, $btcword, 0,10,'L');
				
				$pdf->SetXY(120,216,false);
				$pdf->SetFont($textfont,'B',20); 
				$pdf->Cell(0,13, $btc, 0,1,'L');
				$pdf->SetFont($textfont, 'B', 6);
				$pdf->SetXY(120,220,false);
				$pdf->Cell(0,13, $btcword, 0,10,'L');
	}
}
?>