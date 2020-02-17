<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$regno=$txtcpassword=$rc=$txtrc=$mail=$data=$txtcname=$numL=$txtcname = "";
$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint = $J.", ".$Q;	
if(!isset($_GET['rc']) || !isset($_GET['mail']) || !isset($_GET['data'])){
		header("location: index.php");
}
$rc = $_GET['rc']; $mail = $_GET['mail']; $data = $_GET['data'];

//verify if it has been confirmed or is valid
$stmt_in = $conn->prepare("SELECT * FROM customer_record where cemail=? and rcnumber=? and cid=? Limit 1");
$stmt_in->execute(array($mail,$rc,$data));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row = $stmt_in->fetch(PDO::FETCH_ASSOC);
	if($row['confirm']=="1"){
		header("location: index.php");
	}
	$txtcname=$row['cname'];
}else{
	header("location: index.php");
}

//generate TIN Number
$numL=mt_rand(144057180,930729567);
$app_id = "05-".$numL;


?>
</head>
<body style="width:80%;margin:auto">
<div class="container-fluid" >
		<div class="row">
			<?php
				require_once 'settings/nav_top.php';
			?> 
		</div>
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row" style="background-color:white;">
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				require_once 'settings/project_info2.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:white;text-align:centre">
				<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" 
				  aria-hidden="true">
				  &times;
			   </button>
					<h4 style="margin-bottom:20px;align:center"><b>Dear <?php echo $txtcname;?>,</b></h4>
					<h4 style="margin-bottom:20px;align:center"><b>Detail Of Your Tax Identification Number (TIN)<b> </h4>
					<h2 style="margin-bottom:20px;align:center"><b>TIN NUMBER: <?php echo $app_id;?> </b></h2>
					<p><?php echo $dateprint;?></p>
					<a href="address_information.php"><span class="btn btn-primary">Continue Application</span></a>
			   </div>
			</div>
			<?php
				//update the student information
				$_SESSION['email'] =$mail;
				$_SESSION['app_id'] =$app_id;
				$_SESSION['cname'] = $txtcname;
				$stmt = $conn->prepare("UPDATE customer_record SET confirm = ?, tin = ?, app_status=? where cemail=? and rcnumber=? and cid=? Limit 1");
				$stmt->execute(array("1",$app_id,"0",$mail,$rc,$data));
			?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:#CCFFFF">
				<p class="btn btn-primary" style="margin-bottom:10px;margin-top:10px;">Step 1 : Generate Application ID</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Generate Tax Identification N<u>o</u> (TIN)</li>
					<li>Key in your Email Address, Company Name, RC Number and Provide Your Password</li>
					<li><strong>Click Generate TIN to Generate TIN N<u>o</u> </strong>  <a style="color:red;" href="generate_pin.php">Click Here To Start >> </a></li> 
				</ol></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:grey;text-align:centre">
				<hr/>
					<p style="text-align:center"><a href=""><span class="btn btn-primary">Generate application ID</span></a> | <a href="login_to_profile.php"><span class="btn btn-info">Complete Application</span></a> | <a href="login_status.php"><span class="btn btn-success">Check Application Status</span></a></p>
				<hr/>
			</div>
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
