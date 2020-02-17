<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$acntDate=$bankA = $bankB = $bankN=$accnsc=$accnnumber = $accntname=$notice_msg="";
    
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
	$acntDate=$row['acntDate'];
	$bankA=$row['bankA'];
	$bankB=$row['bankB'];
	$bankN=$row['bankN'];
	$accnsc=$row['accnsc'];
	$accnnumber=$row['accnnumber'];
	$accntname=$row['accntname'];
	if($row['app_status']!="0"){
		header("location: account_home.php");
	}
}else{
	header("location: index.php");
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$acntDate =trim($_POST['acntDate']); $bankA=trim($_POST['bankA']);	$bankB=trim($_POST['bankB']);
	$bankN=trim($_POST['bankN']); $accnsc=trim($_POST['accnsc']);$accnnumber=trim($_POST['accnnumber']);$accntname=trim($_POST['accntname']);
		//check if email is valid
		if(checkempty($acntDate) && checkempty($bankA) && checkempty($bankB)&& checkempty($bankN) && checkempty($accnsc) && checkempty($accnnumber) && checkempty($accntname)){
			$date500 = new DateTime($acntDate);
			$acntDate = date_format($date500,"Y-m-d");
			$stmt = $conn->prepare("UPDATE customer_record SET acntDate = ?, bankA = ?, bankB = ?, bankN = ?, accnsc = ?, accnnumber = ?, accntname = ?  where cemail=? and tin=? Limit 1");
			if($stmt->execute(array($acntDate,$bankA,$bankB,$bankN,$accnsc,$accnnumber,$accntname,$mail,$app_id))){
				header("location: shareholders.php");
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

$date500 = new DateTime($acntDate);
$acntDate = date_format($date500,"d/m/Y");
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
				<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
					<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (4/11) - Finance Information </h4>
					<?php echo $notice_msg;?>
						<div class="form-group">
							<label for="accntname" class="control-label col-xs-5">Account Name <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control"  id="accntname" name="accntname" value="<?php echo $accntname;?>" required="true" placeholder="Enter Account Name" />
							</div>
						</div>
						<div class="form-group">
							<label for="accnnumber" class="control-label col-xs-5">Account Number <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control"  onkeydown="return noNumbers(event,this)" id="accnnumber" name="accnnumber" value="<?php echo $accnnumber;?>" required="true" placeholder="Enter Account Number" />
							</div>
						</div>
						<div class="form-group">
							<label for="accnsc" class="control-label col-xs-5">Sort Code <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control" onkeydown="return noNumbers(event,this)" id="accnsc" name="accnsc" value="<?php echo $accnsc;?>" required="true" placeholder="Enter Bank Sort Code" />
							</div>
						</div>
						<div class="form-group">
							<label for="bankN" class="control-label col-xs-5">Bank Name <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control" id="bankN" name="bankN" value="<?php echo $bankN;?>" required="true" placeholder="Enter Bank Name" />
							</div>
						</div>
						<div class="form-group">
							<label for="bankB" class="control-label col-xs-5">Branch Name <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control"  id="bankB" name="bankB" value="<?php echo $bankB;?>" required="true" placeholder="Enter Bank Branch Name" />
							</div>
						</div>
						<div class="form-group">
							<label for="bankA" class="control-label col-xs-5">Branch Address <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<textarea class="form-control"  rows="2" id="bankA" name="bankA" required="true" placeholder="Enter Bank Branch Address">
									<?php echo $bankA;?>
								</textarea>
							</div>
						</div>
						
						<div class="form-group" style="margin-top:25px">
							<label for="acntDate" class="control-label col-xs-5">Accounting Date <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="acntDate" name="acntDate" value="<?php echo $acntDate;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group pull-right">
							<div class="col-xs-7">
								<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Update Record" class="btn btn-primary btn-md"></input>
							</div>
						</div>
						
					</form>
			</div>
		</div>
		
		
		
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/4.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
