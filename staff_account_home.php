<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
$notice_msg1=$notice_msg2=$notice_msg3=$dateprint=$errPL="";
if(!isset($_SESSION['staff_name']) || !isset($_SESSION['staff_id'])){
		header("location: index.php?out=_no");
}

$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint_V = $J.", ".$Q;
$dateprint = $J.", ".$Q;

//List of all cleared Application
$stmt_in = $conn->prepare("SELECT count(app_status) as totNo FROM customer_record where app_status=?");
$stmt_in->execute(array("2"));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
	if($row_ret_two['totNo'] > 0){
		$errPL="Information: The Total Number of Cleared Application as at ".$dateprint.", is ".$affected_rows_in;
		$notice_msg1='<div class="alert alert-info alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
	}
	
}

//List of all Uncleared Application
$stmt_in = $conn->prepare("SELECT count(app_status) as totNo FROM customer_record where app_status=?");
$stmt_in->execute(array("1"));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
	if($row_ret_two['totNo'] > 0){
		$errPL="Information: The Total Number of Completed But Yet Uncleared Application as at ".$dateprint.", is ".$affected_rows_in;
		$notice_msg2='<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
	}
	
}

//List of all Incomplete Application
$stmt_in = $conn->prepare("SELECT count(app_status) as totNo FROM customer_record where app_status=?");
$stmt_in->execute(array("0"));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
	if($row_ret_two['totNo'] > 0){
		$errPL="Information: The Total Number of Applications that are not yet completed as at ".$dateprint.", is ".$affected_rows_in;
		$notice_msg3='<div class="alert alert-warning alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
	}
	
}

?>

</head>
<body style="width:80%;margin:auto">
<div class="container-fluid" >
		<div class="row hidden-print">
			<?php
				require_once 'settings/nav_top_staff.php';
			?> 
		</div>
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row" >
		<div class="imageupload panel panel-info">
			<div class="panel-heading clearfix">
				<h3 class="panel-title pull-left">Welcome - <?php echo $_SESSION['staff_name']; ?> , To Staff Dashboard !!</h3>
			</div>
		</div>
	</div>
	<div class="row" >
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="margin-bottom:10px;background-color:#CCCCFF;margin-top:5px;text-align:centre;padding-top:10px">
					<?php
						require_once 'settings/staff_nav_left.php';
					?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="margin-bottom:10px;margin-top:5px;text-align:centre;padding-top:5px">
				<h4 style="margin-bottom:10px;background-color:#CCCCFF;padding:10px">FIRS APPLICATION STATUS AT - <?php echo $dateprint;?></h4>
				<?php echo $notice_msg1;?>
				<?php echo $notice_msg2;?>
				<?php	echo $notice_msg3;?>
			</div>
	</div>

		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
