<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';

if(!isset($_SESSION['staff_name']) || !isset($_SESSION['staff_id'])){
		if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
			header("location: index.php?out=_yes");
		}
}

if(!isset($_GET['t_']) && !isset($_GET['r_']) && !isset($_GET['i_'])){
	header("location: index.php?out=_no");
}
$app_id = $_GET['t_'];
$rcnum= $_GET['r_'];
$idnum= $_GET['i_'];


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
		$this->Cell(0, 10, 'FIRS Application - 2018 - - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
				   <td align="left"  style="font-size:10;font-weight:bold;color:red">.: FIRS APPLICATION SLIP :.</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
		//retrieve for details
		$n_ = $d_ = "";
		$stmt_in = $conn->prepare("SELECT cname,dateSub,dateApprove, tin, rcnumber FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
		$stmt_in->execute(array($app_id,$rcnum,$idnum));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC); 
			$n_ = strtoupper($row_ret_two['cname']);
			$date500 = new DateTime($row_ret_two['dateSub']);
			$J = date_format($date500,"D");
			$Q = date_format($date500,"d-F-Y, h:i:s A");
			$dateprint_V = $J.", ".$Q;
			$d_ = $J.", ".$Q;	
		}
		
		$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="justify" colspan ="6" style="font-size:8;">
					<p><b>I hereby certified that all information provided in this FIRS Application are correct and a true representation of the actual information of '.$n_.' as at '.$d_.', which is the time of submitting the FIRS Application.</b></p>
				<p style="color:red"><b>I should be held responsible and be made to face the consequence there apply for any wrong information provided in the FIRS Application.</b></p>
					</td>
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
					<td align="Right" style="font-size:8;">'.$dateprint.'</td> 
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			
			$html ="";
			$full_name ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
			$stmt_in->execute(array($app_id,$rcnum,$idnum));
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
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}
		
			$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: ADDRESS INFORMATION</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			$html ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
			$stmt_in->execute(array($app_id,$rcnum,$idnum));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{   
				$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);    
				$html = '<table border="1" cellpadding="4" width="800">
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
						<tr>
							<td width="250">Address Of Operational Office :</td>
							<td width="390"><b>'.$row_ret_two['aoproffice'].'</b></td>
						</tr>
						<tr  >
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}
			
			$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: BUSINESS INFORMATION</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			$html ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
			$stmt_in->execute(array($app_id,$rcnum,$idnum));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{   
				$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
				$date500 = new DateTime($row_ret_two['doi']);
				$J = date_format($date500,"D");
				$Q = date_format($date500,"d-F-Y");
				$dateprint = $J.", ".$Q;
				$date500 = new DateTime($row_ret_two['ocd']);
				$J = date_format($date500,"D");
				$Q = date_format($date500,"d-F-Y");
				$dateprint2 = $J.", ".$Q;				
				$html = '<table border="1" cellpadding="4" width="800">   
						<tr  >
							<td width="250">Nature Of Business :</td>
							<td width="390"><b>'.$row_ret_two['nbusiness'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Business Form :</td>
							<td width="390"><b>'.$row_ret_two['bform'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Date Of Incorporation :</td>
							<td width="390"><b>'.$dateprint.'</b></td>
						</tr>
						<tr>
							<td width="250">Operation Commencement Date :</td>
							<td width="390"><b>'.$dateprint2.'</b></td>
						</tr>
						<tr  >
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}
			$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: FINANCE INFORMATION</td>
				</tr>
			</table><hr>';
			$pdf->writeHTML($html, true, false, false, false, '');
			$html ="";
			$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
			$stmt_in->execute(array($app_id,$rcnum,$idnum));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{   
				$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
				$date500 = new DateTime($row_ret_two['acntDate']);
				$J = date_format($date500,"D");
				$Q = date_format($date500,"d-F-Y");
				$dateprint = $J.", ".$Q;				
				$html = '<table border="1" cellpadding="4" width="800">        
						<tr  >
							<td width="250"> Account Name :</td>
							<td width="390"><b>'.$row_ret_two['accntname'].'</b></td>
						</tr>  
						<tr  >
							<td width="250">Account Number :</td>
							<td width="390"><b>'.$row_ret_two['accnnumber'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Sort Code :</td>
							<td width="390"><b>'.$row_ret_two['accnsc'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Bank Name :</td>
							<td width="390"><b>'.$row_ret_two['bankN'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Branch Name :</td>
							<td width="390"><b>'.$row_ret_two['bankB'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Branch Address :</td>
							<td width="390"><b>'.$row_ret_two['bankA'].'</b></td>
						</tr>
						<tr  >
							<td width="250">Account Date :</td>
							<td width="390"><b>'.$dateprint.'</b></td>
						</tr>
						<tr  >
							<td colspan="2"></td>
						</tr></table>';

				$pdf->writeHTML($html, true, false, false, false, '');
			}

//page for shareholders
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: SHAREHOLDERS INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_share where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="180">Name</th>
							<th width="120">Value Of Share</th>
							<th width="120">Phone N<u>o</u> / Email Add.</th>
							<th width="160">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$formattedNum_one =  number_format($row_ret_two['vshare'], 2);
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="180">'.$row_ret_two['sname'].'</td>
							<td width="120"> &#8358; '.$formattedNum_one.'</td>
							<td width="120">'.$row_ret_two['spe'].'</td>					
							<td width="160">'.$row_ret_two['shareA'].'</td>					
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for Directorship
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: DIRECTORSHIP INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_director where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="180">Name</th>
							<th width="140">Company</th>
							<th width="120">Phone N<u>o</u> / Email Add.</th>
							<th width="140">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="180">'.$row_ret_two['sname'].'</td>
							<td width="140">'.$row_ret_two['cname'].'</td>
							<td width="120">'.$row_ret_two['spe'].'</td>					
							<td width="140">'.$row_ret_two['shareA'].'</td>					
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for principal officers
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: PRINCIPAL OFFICERS INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_officer where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="180">Name</th>
							<th width="140">Officer Title</th>
							<th width="120">Phone N<u>o</u> / Email Add.</th>
							<th width="140">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="180">'.$row_ret_two['sname'].'</td>
							<td width="140">'.$row_ret_two['cname'].'</td>
							<td width="120">'.$row_ret_two['spe'].'</td>					
							<td width="140">'.$row_ret_two['shareA'].'</td>					
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for Company Branch
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: COMPANY BRANCH INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_branch where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="120">State</th>
							<th width="180">Local Government</th>
							<th width="280">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="120">'.$row_ret_two['state'].'</td>
							<td width="180">'.$row_ret_two['lgv'].'</td>
							<td width="280">'.$row_ret_two['address'].'</td>				
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for Associated Company
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: ASSOCIATED COMPANY INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_company where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="200">Name Of Company</th>
							<th width="160">RC Number</th>
							<th width="220">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="200">'.$row_ret_two['cname'].'</td>
							<td width="160">'.$row_ret_two['rc'].'</td>
							<td width="220">'.$row_ret_two['address'].'</td>				
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}
//page for Company Auditors
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: COMPANY AUDITORS INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_auditor where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="180">Name</th>
							<th width="100">Phone</th>
							<th width="100">Email Add.</th>
							<th width="200">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="180">'.$row_ret_two['sname'].'</td>
							<td width="100">'.$row_ret_two['phone'].'</td>
							<td width="100">'.$row_ret_two['email'].'</td>
							<td width="200">'.$row_ret_two['address'].'</td>				
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for Company Tax Representative
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
//student details
	$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
				<tr style="bottom-border:1 solid;">
					<td align="left" colspan ="6" style="font-size:8;">.: COMPANY TAX REPRESENTATIVE INFORMATION</td>
				</tr>
			</table><hr>';
	$pdf->writeHTML($html, true, false, false, false, '');
	
	$html ="";
	$stmt_in = $conn->prepare("SELECT * FROM customer_tax where tin=? Limit 1");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$html .= '<table border="1" cellpadding="4" ><thead style="background-color:none;color:blue">
						<tr>
							<th width="60">S/N<u>o</u>.</th>
							<th width="180">Name</th>
							<th width="100">Phone</th>
							<th width="100">Email Add.</th>
							<th width="200">Contact Address.</th>
						</tr>
					</thead><tbody>';
		$numbering_two = 1;
		while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
		{
			$html .= '<tr>
							<td width="60">'.$numbering_two.'</td>
							<td width="180">'.$row_ret_two['sname'].'</td>
							<td width="100">'.$row_ret_two['phone'].'</td>
							<td width="100">'.$row_ret_two['email'].'</td>
							<td width="200">'.$row_ret_two['address'].'</td>				
						</tr>';
			$numbering_two =$numbering_two + 1;
		}
		$html .='</tbody></table>';
		$pdf->writeHTML($html, true, false, false, false, '');
	}

//page for Company Tax Representative
$pdf->AddPage();
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'ksu.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
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
				<td width="590px"><p style="color:black;">This Slip is Just an Applicantion slip and in no circustance will it stand in place of the Approved FIRS Application Slip.</p></td>
			</tr>
			<tr>
				<td>2.</td>
				<td><p style="color:black;">Note: Always Login To Your Portal to check the approval status of your FIRS application. The Approved Application Slip can only be printed once your FIRS Management has attend / approve your application.</p></td>
			</tr>
			<tr>
				<td>3.</td>
				<td><p style="color:red;">Note: Always Login to Your Application Portal with your Tax Identification N<u>o</u> (TIN) and Your Account Password.</p></td>
			</tr>
		</tbody>
	</table>';
	$pdf->writeHTML($html, true, false, false, false, '');	
$file_name = str_replace(" ","_",$full_name).'_Application_Slip';
$pdf->Output($file_name.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

