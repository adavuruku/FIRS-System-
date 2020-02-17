<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';

if(!isset($_SESSION['staff_name']) || !isset($_SESSION['staff_id'])){
		header("location: index.php?out=_no");
}

if(!isset($_GET['m_']) && !isset($_GET['l_w'])){
	header("location: index.php?out=_no");
}
$display="";
$status ="1";
$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint_V = $J.", ".$Q;
$dateprint = "Printed On: ".$J.", ".$Q;	

// create new PDF document

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
$pdf->SetTitle('FIRS Application');
$pdf->SetSubject('Approved List');

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

		// add a page - 100 level heading
		$pdf->AddPage('L');
		$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
			<tr>
				<td><img src="../settings/images/headlogo.jpg"/></td>
			</tr>
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');
		
		$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
			<tr style="bottom-border:1 solid;">
				<td align="Left" style="font-size:8;font-weight:bold;color:brown"> Printed By: '.$_SESSION['staff_name'].'</td> 
				<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
			</tr>
		</table><hr>';

		$pdf->writeHTML($html, true, false, false, false, '');
		
		$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
			<tr style="bottom-border:1 solid;">
				<td align="Left" style="font-size:8;font-weight:bold;color:blue"> REPORT LIST OF ALL PENDING FIRS APPLICATION</td> 
			</tr>
		</table><hr>';

		$pdf->writeHTML($html, true, false, false, false, '');

		// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
		$pdf->SetAlpha(0.3);
		$img_file = K_PATH_IMAGES.'ksu.jpg';
		$pdf->Image($img_file, 95, 55, 100, 100, '', '', '', false, 300, '', false, false, 0);
		$pdf->SetAlpha(1);

		$html1 ="";
		$sql = "";
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where app_status=?");
		$stmt_in->execute(array("1"));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			 $html1 .= '<thead style="background-color:none;color:blue">
								<tr>
									<th width="60">S/N<u>o</u>.</th>
									<th width="280">Company Name</th>
									<th width="100">TIN N<u>o</u></th>
									<th width="100">RC N<u>o</u></th>
									<th width="150">Phone N<u>o</u> / Email Add.</th>
									<th width="250">Contact Address</th>
								</tr>
							</thead><tbody>';
				//$id=1;
				//$staff_name ="";$tot_unit=0;
				$j=1;$data="";
					while($row_two = $stmt_in->fetch(PDO::FETCH_ASSOC))
					{
						$nameAll = $row_two['phone']." ".$row_two['cemail'];
						 $html1 .='<tr >
										<td  width="60">'.$j.'</td> 	
										<td width="280">'.$row_two['cname'].'</td>
										<td width="100">'.$row_two['tin'].'</td>
										<td width="100">'.$row_two['rcnumber'].'</td>
										<td width="150">'.$nameAll.'</td>
										<td width="250">'.$row_two['aregoffice'].'</td>
										
								</tr>';
								$j=$j + 1;
					}
					$j=$j - 1;
					$html  = '<table border="1" cellpadding="4" width="800">'.$html1.'
					<tr >
						<td colspan="6" align="center" ><h5 style="color:red">You have Not Yet Approved - '.$j.' - FIRS Application </h5></td>
					</tr></tbody></table>';
					// output the HTML content
					$pdf->writeHTML($html, true, false, false, false, '');
		}

//$file_name = 'All_Upload_'.str_replace(" ","_",$_GET['course']).' Courses_For_'.$department;
$pdf->Output('All_Pending_Application.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

?>