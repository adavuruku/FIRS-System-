<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$sname=$spe=$shareA=$cname=$notice_msg1=$notice_msg="";
    
if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
		header("location: index.php?out=_yes");
}
$app_id = $_SESSION['app_id'];

//check if application completed
$stmt_in = $conn->prepare("SELECT app_status, tin FROM customer_record where tin=?");
$stmt_in->execute(array($app_id));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
		if($row_ret_two['app_status']=="0"){
			$errPL="Information: You have Neither Complete Nor Submit Your FIRS Application - Verify!!!";
			$notice_msg1='<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
		}
}

//check application approval
if(isset($_GET['check']) && $_GET['check']=="_yes"){
	$stmt_in = $conn->prepare("SELECT app_status, tin FROM customer_record where tin=?");
	$stmt_in->execute(array($app_id));
	$affected_rows_in = $stmt_in->rowCount();
	if($affected_rows_in >= 1) 
	{
		$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
		if($row_ret_two['app_status']=="1"){
			$errPL="Your FIRS Application is not Yet Approved - Please Endeavour to Check Back Later.";
			$notice_msg='<div class="alert alert-info alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
		}
		if($row_ret_two['app_status']=="2"){
			$errPL="Congratulations!!!. Your FIRS Application has been Approved - You can Use the [Print Menu] to Print Your Approved FIRS Slip.";
			$notice_msg='<div class="alert alert-success alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
		}
	}
}
?>
</head>
<body style="width:80%;margin:auto">
<div class="container-fluid" >
		<div class="row">
			<?php
				require_once 'settings/nav_top_login.php';
			?> 
		</div>
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row" style="background-color:white;">
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="background-color:#CCCCFF;">
			<?php
				include 'settings/nav_left_account.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<?php echo $notice_msg;?>
			<?php echo $notice_msg1;?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
					<tbody>
					<?php
						$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? Limit 1");
						$stmt_in->execute(array($app_id));
						$affected_rows_in = $stmt_in->rowCount();
						if($affected_rows_in >= 1) 
						{
							while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
								{
									$cname = strtoupper($row_ret_two['cname']);
									echo '<tr>
											<td align="right">Company Name : </td>
											<td></td>
											<td>'.strtoupper($row_ret_two['cname']).'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">TIN Number : </td>
											<td></td>
											<td style="color:red"><b>'.$row_ret_two['tin'].'</b></td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">RC Number : </td>
											<td></td>
											<td>'.$row_ret_two['rcnumber'].'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Form Of Business : </td>
											<td></td>
											<td><b>'.$row_ret_two['bform'].'.</b></td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Phone Number : </td>
											<td></td>
											<td>'.$row_ret_two['phone'].'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Email Address : </td>
											<td></td>
											<td>'.$row_ret_two['cemail'].'</td>
										</tr>
										
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Company Website : </td>
											<td></td>
											<td>'.$row_ret_two['website'].'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Registered Address : </td>
											<td></td>
											<td>'.$row_ret_two['aregoffice'].'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
										</tr>
										<tr>
											<td align="right">Operational Address : </td>
											<td></td>
											<td>'.$row_ret_two['aoproffice'].'</td>
										</tr>';
								}
						}
					?>
				</tbody>
			</table>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/account.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
