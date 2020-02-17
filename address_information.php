<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$phone=$aregoffice=$website=$aoproffice=$notice_msg="";

if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
		header("location: index.php?out=_yes");
}
//$rc = $_GET['rc']; 
$mail = $_SESSION['email']; 
$app_id = $_SESSION['app_id'];

//verify if it has been confirmed or is valid
$stmt_in = $conn->prepare("SELECT * FROM customer_record where cemail=? and tin=? and confirm=? Limit 1");
$stmt_in->execute(array($mail,$app_id,"1"));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in >= 1) 
{
	$row = $stmt_in->fetch(PDO::FETCH_ASSOC);
	$phone=$row['phone'];
	$aregoffice=$row['aregoffice'];
	$aoproffice=$row['aoproffice'];
	$website=$row['website'];
	if($row['app_status']!="0"){
		header("location: account_home.php");
	}
}else{
	header("location: index.php");
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$phone =trim($_POST['phone']); $aregoffice=trim($_POST['aregoffice']);	$aoproffice=trim($_POST['aoproffice']);
	$website=trim($_POST['website']);
		//check if email is valid
		if(checkempty($phone) && checkempty($aregoffice) && checkempty($aoproffice)){
			$stmt = $conn->prepare("UPDATE customer_record SET phone = ?, aregoffice = ?, aoproffice = ?, website = ?  where cemail=? and tin=? Limit 1");
			if($stmt->execute(array($phone,$aregoffice,$aoproffice,$website,$mail,$app_id))){
				header("location: bussiness_information.php");
			}else{
				$errPL="Error: Unable To Update Record - Verify!!!";
				$notice_msg='<div class="alert alert-danger alert-dismissable">
			   <button type="button" class="close" data-dismiss="alert" 
				  aria-hidden="true">
				  &times;
			   </button> '.$errPL.' </div>';
			}
		}else{
			$errPL="Error: Invalid Datas Provided - Verify!!!";
			$notice_msg='<div class="alert alert-danger alert-dismissable">
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
				<form role="form"  name="reg_form"  id="form" class="form-vertical" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
					<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (2/11) - Address Information </h4>
					<?php echo $notice_msg;?>
					<div class="form-group">
						<label for="txtPhone">Phone N<u>o</u> <span style="color:red">*</span> : </label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<input type="text" class="form-control" onkeydown="return noNumbers(event,this)" id="phone" name="phone" value="<?php echo $phone;?>" required="true" placeholder="Enter Main Phone No" />
						</div>
					</div>
					<div class="form-group">
						<label for="txtPermadd">Address Of Registered Office <span style="color:red">*</span> : </label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<textarea class="form-control"  rows="2" id="aregoffice" name="aregoffice" required="true" placeholder="Enter Address Of Registered Office">
								<?php echo $aregoffice;?>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="txtPermadd">Address Of Operational Office <span style="color:red">*</span> : </label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<textarea class="form-control"  rows="2" id="aoproffice" name="aoproffice" placeholder="Enter Address Of Operational Office">
								<?php echo $aoproffice;?>
							</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="txtPhone">Company Official Website : </label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<input type="web" class="form-control" id="website" name="website" value="<?php echo $website;?>" placeholder="Enter Company Official Website" />
						</div>
					</div>
					<div class="form-group pull-right">
							<div class="input-group">
								<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Update Record" class="btn btn-primary btn-md"></input>
							</div>
						</div>
						
					</form>
					</div>
		</div>
		
		
		
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/2.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
