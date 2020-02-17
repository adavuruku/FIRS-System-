<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
$txtreg =$txtAppID=$errPL="";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$txtAppID =trim($_POST['txtAppID']); 
	$txtreg =trim($_POST['txtreg']);
	if($txtAppID!="" && $txtreg!=""){
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and cpassword=? and confirm=?  Limit 1");
		$stmt_in->execute(array($txtreg,$txtAppID,"1"));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{	
			$row = $stmt_in->fetch(PDO::FETCH_ASSOC);
			$_SESSION['app_id'] = $row['tin'];
			$_SESSION['email'] = $row['cemail'];
			$_SESSION['cname'] = $row['cname'];
			if($row['app_status'] =="0"){
				header("location: address_information.php");
			}else{
				header("location: account_home.php");
			}
		}else{
			$errPL="Error: The TIN No or Password does not exist or Account is not yet Verified !. Contact FIRS ICT Office!!!";
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
				<h4 style="margin-bottom:20px;background-color:#CCFF33;padding:10px">Please Login - Applicant</h4>
			<hr/>
				<div class="form-group">
					<label for="txtPasswordC2">Tax Identification Number (TIN) : </label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" onkeypress="wipeboxeror('4')" id="txtreg" name="txtreg" value="<?php echo $txtreg;?>" required="true" placeholder="Enter Tax Identification Number (TIN) e.g (05-12345678)"/>
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Application Password: </label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span> 
						<input type="password" class="form-control" id="txtAppID"  name="txtAppID" required="true" placeholder="Enter Your Application Password"/>
					</div>
					<span class="help-block" id="result4" style="color:brown;text-weight:bold;text-align:center;"><?php echo $errPL;?></span>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Continue" class="btn btn-primary btn-md"></input>
					</div>
				</div>
				<h4 style="color:yellow;">Forget Your TIN N<u>o</u> <a href="#" style="color:black;">Click Here to Retrieve it</a></h4>
			</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;">
			<p class="btn btn-info" style="margin-bottom:10px;margin-top:10px;">Step 2 : Login To Complete Your Application</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Complete Application</li>
					<li>Provide your Tax Identification N<u>o</u> (TIN) And Password</li>
					<li style="color:red"><strong>Click Continue</strong></li>
					<li><strong>Fill All the required Information in all the Forms</strong></li>
					<li><strong>Click Submit to Preview all the information you provided</strong></li>
					<li><strong>Click Continue to Complete the registration or edit to Edit the informations</strong>  </li> 
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
