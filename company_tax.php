<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$sname=$phone=$shareA=$email=$notice_msg="";
    
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

//remove shareholder
if(isset($_GET['rem'])){
	$stmt = $conn->prepare("DELETE FROM customer_tax where id=?");
	$stmt->execute(array($_GET['rem']));
	$errPL="Success: Record Removed - Verify!!!";
		$notice_msg='<div class="alert alert-success alert-dismissable">
	   <button type="button" class="close" data-dismiss="alert" 
		  aria-hidden="true">
		  &times;
	   </button> '.$errPL.' </div>';
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$sname =trim($_POST['sname']); $phone=trim($_POST['phone']);	$shareA=trim($_POST['shareA']);	$email=trim($_POST['email']);
		//check if email is valid
		if(checkempty($sname) && checkempty($phone) && checkempty($shareA)&& checkempty($email)){
		
			$stmt_in = $conn->prepare("SELECT sname, phone, tin FROM customer_tax where sname=? and tin=? and phone=?");
			$stmt_in->execute(array($sname,$app_id,$phone));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{
				$stmt = $conn->prepare("UPDATE customer_tax SET sname = ?, phone = ?, address = ?, email = ?  where sname=? and tin=? and phone=? Limit 1");
				if($stmt->execute(array($sname,$spe,$shareA,$vshare,$sname,$app_id,$phone))){
					$errPL="Success: Your Record Was Update Successfully - Verify!!!";
					$notice_msg='<div class="alert alert-success alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}
			}else{
				$sth = $conn->prepare("INSERT INTO customer_tax (sname, phone, address,email,tin) VALUES (?,?,?,?,?)");
				$sth->bindValue (1, $sname);
				$sth->bindValue (2, $phone);
				$sth->bindValue (3, $shareA);
				$sth->bindValue (4, $email);
				$sth->bindValue (5, $app_id);
				if($sth->execute()){
					$errPL="Success: The Auditor Record Was Created Successfully - Verify!!!";
					$notice_msg='<div class="alert alert-success alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}else{
					$errPL="Error: Unable To Create Record - Verify!!!";
					$notice_msg='<div class="alert alert-danger alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}
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
			<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (11/11) - Company Tax Representative Information</h4>
				<?php echo $notice_msg;?>
					<div class="form-group">
						<label for="sname" class="control-label col-xs-5">Full Name <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<input type="text" class="form-control"  id="sname" name="sname" value="<?php echo $sname;?>" required="true" placeholder="FirstName MidlleName LastName" />
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="control-label col-xs-5">Phone Number <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<input type="text" class="form-control"  id="phone" name="phone" value="<?php echo $phone;?>" required="true" placeholder="Enter Phone Number" />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="control-label col-xs-5">Email Address<span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<input type="email" class="form-control"  id="email" name="email" value="<?php echo $email;?>" required="true" placeholder="Enter  Email Address" />
						</div>
					</div>
					<div class="form-group">
						<label for="shareA" class="control-label col-xs-5">Contact Address <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<textarea class="form-control"  rows="2" id="shareA" name="shareA" required="true" placeholder="Enter Shareholder Contact Address">
								<?php echo $shareA;?>
							</textarea>
						</div>
					</div>
					<div class="form-group pull-right">
						<div class="col-xs-7">
							<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Add Auditor" class="btn btn-primary btn-md"></input>
						</div>
					</div>
				</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
				<thead style="color:blue;">
					<tr>
						<th>S/No.</th>
						<th>Name</th>
						<th>Phone </th>
						<th>Email</th>
						<th>Address</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
			<?php
				//verify if it has been confirmed or is valid
				$stmt_in = $conn->prepare("SELECT * FROM customer_tax where tin=?");
				$stmt_in->execute(array($app_id));
				$affected_rows_in = $stmt_in->rowCount();
				if($affected_rows_in >= 1) 
				{
					$numbering_two = 1;
					while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
						{
							echo '<tr>
									<td>'.$numbering_two.'</td>
									<td>'.$row_ret_two['sname'].'</td>
									<td>'.$row_ret_two['phone'].'</td>
									<td>'.$row_ret_two['email'].'</td>					
									<td>'.$row_ret_two['address'].'</td>					
									<td><a title="Remove Auditor" style="color:red;cursor: pointer; cursor: hand;" href=company_auditor.php?rem='.$row_ret_two['id'].'><img src="resource/delete-icon.jpg" style="height:20px" ></img></a></td>
								</tr>';
								$numbering_two =$numbering_two + 1;
						}
				}
			?>
				</tbody>
			</table>
			</div>
		</div>
		
		
		
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/11.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
