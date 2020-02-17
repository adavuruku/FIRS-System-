<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$datecert = $J.", ".$Q;
$errPL=$sname=$shareA=$rc=$notice_msg="";
    
if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
		header("location: index.php?out=_yes");
}
//$rc = $_GET['rc']; 
$mail = $_SESSION['email']; 
$app_id = $_SESSION['app_id'];

//if application submited go home
$stmt_in = $conn->prepare("SELECT * FROM customer_record where app_status <> ? and tin=? Limit 1");
$stmt_in->execute(array("0",$app_id));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	header("location: account_home.php");
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
				$stmt = $conn->prepare("UPDATE customer_record SET app_status = ?, dateSub=now() where tin=? Limit 1");
				if($stmt->execute(array("1",$app_id))){
					header("location: account_home.php");
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
				include 'settings/nav_left_staff.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Preview Of All Information</h4>
			</div>
			<?php
				include 'preview_all.php';
			?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Certification And Submission</h4>
				<p><b> I hereby certified that all information provided in this FIRS Application are correct and a true representation of the actual information of <?php echo $cname;?> as at <?php echo $datecert;?>, which is the time of submitting the FIRS Application.</b></p>
				<p style="color:red"><b> I should be held responsible and be made to face the consequence there apply for any wrong information provided in the FIRS Application.</b></p>				
					<div class="form-group pull-right">
						<div class="col-xs-7">
							<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Submit Application" class="btn btn-primary btn-md"></input>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		
		
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/preview.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
