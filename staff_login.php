<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
if(isset($_SESSION['staff_name']) || isset($_SESSION['clearance_section']) ){
	unset($_SESSION['staff_name']);
	unset($_SESSION['clearance_section']);
} 
$txtreg =$txtAppID=$errPL="";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$txtStaffid =trim($_POST['txtStaffid']); 
	$txtPassword =trim($_POST['txtPassword']); 
	if($txtStaffid!="" && $txtPassword!=""){
		$stmt_in = $conn->prepare("SELECT * FROM staff_record where staff_id=? and staff_password=?  Limit 1");
		$stmt_in->execute(array($txtStaffid,$txtPassword));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in < 1) 
		{	
			$errPL="Error: The Staff ID or Password does not exist . Contact ICT !!!";
		}else{
			//check if application form is filled
				$_SESSION['page_authy'] = SHA1("W@YERADAVURUKUSTAS#YUR");
				$sec="Act_Me";
				$row = $stmt_in->fetch(PDO::FETCH_ASSOC);
				$_SESSION['staff_name'] = $row['staff_name'];
				$_SESSION['staff_id'] = $row['staff_id'];
				
				header("location: staff_account_home.php");
			}
	}else{
		$errPL="Error: Empty Data's Provided !!!";
	}									
}
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
	<div class="row" style="background-color:#CCFFFF;">
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				require_once 'settings/project_info2.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:#CCCCCC;text-align:centre">
			<form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
				<h4 style="margin-bottom:20px;background-color:#CCFF33;padding:10px">Please Login - Staff</h4>
			<hr/>
				<div class="form-group">
					<label for="txtPasswordC2">Staff ID : </label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" onkeypress="wipeboxeror('4')" id="txtStaffid" name="txtStaffid" value="" required="true" placeholder="Enter Staff ID">
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Password : </label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span> 
						<input type="password" onkeypress="wipeboxeror('4')" class="form-control" id="txtPassword" name="txtPassword" required="true" placeholder="Enter Password">
					</div>
					<span class="help-block" id="result4" style="color:brown;text-weight:bold;text-align:center;"><?php echo $errPL;?></span>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Continue" class="btn btn-primary btn-md"></input>
					</div>
				</div>
				<h4 style="color:yellow;">Forget Your Password ID <a href="#" style="color:black;">Click Here to Retrieve it</a></h4>
			</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;">
			<p class="btn btn-success" style="margin-bottom:10px;margin-top:10px;">Steps : Staff Clearance Process</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Staff Login</li>
					<li>Provide your Staff ID and Password </li>
					<li style="color:red"><strong>Click Continue</strong></li>
					<li><strong>Use Either [Pending or Approved Application Menu] to Clear Application</strong></li>
				</ol></P>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:grey;text-align:centre">
				<hr/>
					<p style="text-align:center"><a href="generate_pin.php"><span class="btn btn-primary">Generate application ID</span></a> | <a href="#"><span class="btn btn-info">Complete Application</span></a> | <a href="login_status.php"><span class="btn btn-success">Check Application Status</span></a></p>
				<hr/>
			</div>
		</div>
	</div>
	
	<div class="row" style="font-weight:bold;background-color:grey;padding:20px 15px 20px 15px;color:black">
		<?php
			require_once 'settings/index_comment.php';
		?>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
