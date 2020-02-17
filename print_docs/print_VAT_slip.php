<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';

if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
		header("location: ../index.php?out=_yes");
}

if(!isset($_GET['i_'])){
	header("location: ../index.php?out=_no");
}
$app_id = $_SESSION['app_id'];
$idnum = $_GET['i_'];


$display="";
$status ="1";
$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint_V = $J.", ".$Q;
$dateprint = "Printed On: ".$J.", ".$Q;	


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{
	// Page footer
		public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('dejavusans', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'FIRS Portal - 2018 - - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdulraheem Sherif A');
$pdf->SetTitle('FIRS Applicantion Slip');
$pdf->SetSubject('FIRS Applicantion');

$pdf->SetKeywords('Federal, Inland, Revenue, Service, Nigeria, Abuja');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// to remove default header use this
$pdf->setPrintHeader(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();
		$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
			<tr>
				<td><img src="../settings/images/headlogo.jpg"/></td>
			</tr>
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr>
				   <td align="left"  style="font-size:8;font-weight:bold;color:red">.: VALUE ADDED TAX (VAT) SLIP :.</td>
				   <td align="right"  style="font-size:8;font-weight:bold;color:red">'.$dateprint.'</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->SetAlpha(0.3);
		$img_file = K_PATH_IMAGES.'ksu.jpg';
		$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
		$pdf->SetAlpha(1);
		//student details
			$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" style="font-size:8;">.: Company Information</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			
			$html ="";
			$full_name ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? Limit 1");
			$stmt_in->execute(array($app_id));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{
				$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);   
				$full_name =$row_ret_two['tin'];
				$html = '<table border="1" cellpadding="4" width="800">
						<tr  >
							<td width="250">Company Name :</td>
							<td width="390"><b>'.strtoupper($row_ret_two['cname']).'</b></td>
						</tr>
						<tr  >
							<td width="250">TIN Number :</td>
							<td width="390"><b>'.$row_ret_two['tin'].'</b></td>
						</tr>
						<tr  >
							<td width="250">RC Number :</td>
							<td width="390"><b>'.$row_ret_two['rcnumber'].'</b></td>
						</tr>
						<tr>
							<td width="250">Email Address :</td>
							<td width="390"><b>'.$row_ret_two['cemail'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Business Phone N<u>o</u> :</td>
							<td width="390"><b>'.$row_ret_two['phone'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Official Website :</td>
							<td width="390"><b>'.$row_ret_two['website'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Address Of Registered Office :</td>
							<td width="390"><b>'.$row_ret_two['aregoffice'].'</b></td>
						</tr>
						<tr  >
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}
		
			$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: VAT INFORMATION</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			$html ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_vat where tin=? and id=? Limit 1");
			$stmt_in->execute(array($app_id,$idnum));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{   
				$row_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
						
				$date500 = new DateTime($row_two['vatDate']);
				$J = date_format($date500,"D");
				$Q = date_format($date500,"d-F-Y");
				$dateprint_V = $J.", ".$Q;
				$vatDate1 = $J.", ".$Q;
				
				$totSales1 =  number_format($row_two['totSales'], 2);
				$totBuy1 =  number_format($row_two['totBuy'], 2);
				$vatSales1 =  number_format($row_two['vatSales'], 2);
				$vatPurchase1 =  number_format($row_two['vatPurchase'], 2);
				$vat1 =  number_format($row_two['vat'], 2);				
				$html = '<table border="1" cellpadding="4" width="800">
						<tr  >
							<td width="250">Total Purchase (VAT Excluded) :</td>
							<td width="390"><b> &#8358; '.$totBuy1.'</b></td>
						</tr>
						<tr  >
							<td width="250">Total Sales (VAT Excluded) :</td>
							<td width="390"><b> &#8358; '.$totSales1.'</b></td>
						</tr>
						<tr  >
							<td width="250">Purchase VAT :</td>
							<td width="390"><b> &#8358; '.$vatPurchase1.'</b></td>
						</tr>
						<tr>
							<td width="250">Sales VAT :</td>
							<td width="390"><b> &#8358; '.$vatSales1.'</b></td>
						</tr>
						<tr>
							<td width="250">Total VAT :</td>
							<td width="390"><b> &#8358; '.$vat1.'</b></td>
						</tr>
						<tr>
							<td width="250">VAT Date :</td>
							<td width="390"><b>'.$vatDate1.'</b></td>
						</tr>
						<tr  >
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
		<tr style="bottom-border:1 solid;">
			<td align="left" colspan ="6" style="font-size:8;">.: INSTRUCTIONS</td>
		</tr>
	</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	
	$html ='<table border="0" class="table table-condensed table-bordered">
		<tbody>
			<tr>
				<td width="50px">1.</td>
				<td width="590px"><p style="color:black;">This Slip is The Receipt of Your Value Added Tax (VAT) Calculated / Uploaded on the FIRS Portal on the date indicated in the slip.</p></td>
			</tr>
			<tr>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td>2.</td>
				<td><p style="color:black;">Note: VAT On Purchase = 0.05 * Total Sales (VAT Excluded) and VAT On Sales = 0.05 * Total Purchase (VAT Excluded). VAT Paid = VAT On Sales - VAT On Purchase</p></td>
			</tr>
			<tr>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td>3.</td>
				<td><p style="color:red;">Note: This Slip Can Always Be Printed free of any Charges from FIRS Portal.</p></td>
			</tr>
		</tbody>
	</table>';
	$pdf->writeHTML($html, true, false, false, false, '');	
$file_name =$app_id.'_VAT_Slip';
$pdf->Output($file_name.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

