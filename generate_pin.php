<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$regno=$txtcpassword=$txtpassword=$txtrc=$txtcEmail=$txtEmail=$txtcname=$notice_msg="";

//send mail function
function send_email_to_user($txtEmail, $txtcname, $txtrc,$txtpassword,$numL)
{
	global $conn; 
	global $notice_msg;
	require 'PHPMailer-master/PHPMailerAutoload.php';
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	//$mail->Username = "aabdulraheemsherif@gmail.com";
	//$mail->Password = "sherif419419";
	//$mail->setFrom('aabdulraheemsherif@gmail.com', 'Federal Inland Revenue Service');
	$mail->Username = "mbilikisu10@gmail.com";
	$mail->Password = "ishaq1994";
	$mail->setFrom('mbilikisu10@gmail.com', 'Federal Inland Revenue Service');
	$mail->addAddress($txtEmail, $txtcname);
	$mail->Subject = 'FIRS APPLICATION';
	$message = '<html>
		<body bgcolor="#5F9EA0">
		Dear ' .$txtcname. ',
		<br /><br />
		<P style="color:black;font-weight:bold">Use The Link bellow to Continue Your FIRS Application </P>
		<br /><br />
		Your Details are as follows: 
		<br /><br />
		Company Name : ' . $txtcname . ' <br />
		E-mail Address: ' . $txtEmail . ' <br />
		RC Number: ' . $txtrc . ' <br />
		Password: #########
		<br /><br /> 
		You can Click on these Button Bellow to Continue Application<br /><br /> 
		<a style="color:yellow;background-color:#5F9EA0;padding:10px;text-decoration:none;font-size:25;font-family: comic sans ms;font-weight:bold" href="Adavuruku-PC/firs/email_verify.php?rc=' .$txtrc.'&mail='.$txtEmail.'&data='.$numL.'"> Complete Application </a>
		<br /><br />
		Regards! <br />
		Bilikis Umar <br />
		DG FIRS.
		</body>
		</html>';
	$mail->Body=$message;
	$mail->AltBody=$message;
	if ($mail->send())
	{
		$sth = $conn->prepare ("INSERT INTO customer_record (cname, cemail, cpassword,rcnumber,confirm,cid) VALUES (?,?,?,?,?,?)");	
		$sth->bindValue (1, $txtcname);
		$sth->bindValue (2, $txtEmail);
		$sth->bindValue (3, $txtpassword);
		$sth->bindValue (4, $txtrc);
		$sth->bindValue (5, "0");
		$sth->bindValue (6, $numL);
		
		if($sth->execute()){
			$errPL="Success: Record Saved Successfully - A Link has been Send to Your Email - ".$txtEmail." Please Follow the Link to Complete Your Application !!";
		$notice_msg='<div class="alert alert-success alert-dismissable">
	   <button type="button" class="close" data-dismiss="alert" 
		  aria-hidden="true">
		  &times;
	   </button>'.$errPL.' </div>';
		}
	}
	else
	{
		$errPL="Error: Unable To Create Account - Retry!!!";
					$notice_msg='<div class="alert alert-danger alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button>'.$errPL.' </div>';
	}
}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$txtEmail =trim($_POST['txtEmail']); $txtcpassword=trim($_POST['txtcpassword']);	$txtpassword=trim($_POST['txtpassword']);
	$txtrc=trim($_POST['txtrc']);$txtcEmail=trim($_POST['txtcEmail']);
	$txtcname=trim($_POST['txtcname']);
		//check if email is valid
		if(filterName($txtcname) && filterEmail($txtEmail) && filterEmail($txtcEmail) 
			&& checkempty($txtpassword) && checkempty($txtcpassword) && checksize($txtrc)){
			//verify email are thesame
			if (($txtEmail == $txtcEmail) && ($txtpassword == $txtcpassword)){
				$stmt_in = $conn->prepare("SELECT * FROM customer_record where cemail=? or rcnumber=? Limit 1");
				$stmt_in->execute(array($txtEmail,$txtrc));
				$affected_rows_in = $stmt_in->rowCount();
				if($affected_rows_in >= 1) 
				{	
					$errPL="Error: The Email - ".$txtEmail." or RC Number - ".$txtrc." has already been used for Registration. Follow the Link Send to Your Email to Continue Application or Contact ICT Department!!!";
					$notice_msg='<div class="alert alert-danger alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}else{
					$numL=mt_rand(57180233,95675333);
					send_email_to_user($txtEmail, $txtcname, $txtrc,$txtpassword,$numL);
				}							
		}else{
			$errPL="Error: Invalid Data's Provided - Either Email is Not Identify with Confirm Email or same to Pasword - Verify!!!";
			$notice_msg='<div class="alert alert-danger alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button>'.$errPL.' </div>';
		}
		
	}else{$errPL="Error: Invalid Data's Provided - Verify!!!";
			$notice_msg='<div class="alert alert-danger alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button>'.$errPL.' </div>';}
			
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
	<div class="row" style="background-color:white;">
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				require_once 'settings/project_info2.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:white;text-align:centre">
			<form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (1/11) Generate Tax Identification Number </h4>
			<hr/>
			<?php echo $notice_msg; ?>
				<div class="form-group">
					<label for="txtPasswordC2">Company Name : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" id="txtcname" name="txtcname" value="<?php echo $txtcname;?>" required="true" placeholder="Enter Your Company Name" />
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Email Address : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span> 
						<input type="email" class="form-control" id="txtEmail" name="txtEmail" required="true" value="<?php echo $txtEmail;?>" placeholder="Enter Email Address" />
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Confirm Email Address : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span> 
						<input type="email" class="form-control" id="txtcEmail" name="txtcEmail" required="true" value="<?php echo $txtcEmail;?>" placeholder="Re-Type Email Address" />
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">RC Number : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" id="txtrc" name="txtrc" value="<?php echo $txtrc;?>" required="true" placeholder="Enter RC Number" />
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Select Password : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" class="form-control" id="txtpassword" name="txtpassword" value="<?php echo $txtpassword;?>" required="true" placeholder="Enter Password" />
					</div>
				</div>
				<div class="form-group">
					<label for="txtPasswordC2">Confirm Password : <span style="color:red">*</span></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" class="form-control"  id="txtcpassword" name="txtcpassword" value="<?php echo $txtcpassword;?>" required="true" placeholder="Re-Type Password" />
					</div>
				</div>
				<div class="form-group pull-right">
					<div class="input-group">
						<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Generate TIN No" class="btn btn-primary btn-md"></input>
					</div>
				</div>
				
			</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:#CCFFFF">
				<p class="btn btn-primary" style="margin-bottom:10px;margin-top:10px;">Step 1 : Generate TIN N<u>o</u></p>
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
