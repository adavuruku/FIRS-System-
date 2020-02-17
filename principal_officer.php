<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$sname=$spe=$shareA=$cname=$notice_msg="";
    
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

//remove principal officer
if(isset($_GET['rem'])){
	$stmt = $conn->prepare("DELETE FROM customer_officer where id=?");
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
	$sname =trim($_POST['sname']); $spe=trim($_POST['spe']);	$shareA=trim($_POST['shareA']);	$cname=trim($_POST['cname']);
		//check if email is valid
		if(checkempty($sname) && checkempty($spe) && checkempty($shareA)&& checkempty($cname)){
		
			$stmt_in = $conn->prepare("SELECT sname, tin FROM customer_officer where sname=? and tin=? and cname=?");
			$stmt_in->execute(array($sname,$app_id,$cname));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{
				$stmt = $conn->prepare("UPDATE customer_officer SET sname = ?, spe = ?, shareA = ?, cname = ?  where sname=? and tin=? and cname=? Limit 1");
				if($stmt->execute(array($sname,$spe,$shareA,$cname,$sname,$app_id,$cname))){
					$errPL="Success: Your Record Was Update Successfully - Verify!!!";
					$notice_msg='<div class="alert alert-success alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}
			}else{
				$sth = $conn->prepare("INSERT INTO customer_officer (sname, spe, shareA,cname,tin) VALUES (?,?,?,?,?)");
				$sth->bindValue (1, $sname);
				$sth->bindValue (2, $spe);
				$sth->bindValue (3, $shareA);
				$sth->bindValue (4, $cname);
				$sth->bindValue (5, $app_id);
				if($sth->execute()){
					$errPL="Success: The Principal Officer Record Was Created Successfully - Verify!!!";
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
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (7/11) - Principal Officers Information</h4>
				<?php echo $notice_msg;?>
					<div class="form-group">
						<label for="sname" class="control-label col-xs-5">Full Name <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<input type="text" class="form-control"  id="sname" name="sname" value="<?php echo $sname;?>" required="true" placeholder="FirstName MidlleName LastName" />
						</div>
					</div>
					<div class="form-group">
						<label for="cname" class="control-label col-xs-5">Office Title <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<textarea class="form-control"  rows="2" id="cname" name="cname" required="true" placeholder="Enter Company Name">
								<?php echo $cname;?>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="spe" class="control-label col-xs-5">Phone / Email <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<input type="text" class="form-control"  id="spe" name="spe" value="<?php echo $spe;?>" required="true" placeholder="Enter Phone Number Or Email" />
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
							<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Add Principal Officer" class="btn btn-primary btn-md"></input>
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
						<th>Office Title </th>
						<th>Phone/Email</th>
						<th>Address</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
			<?php
				//verify if it has been confirmed or is valid
				$stmt_in = $conn->prepare("SELECT * FROM customer_officer where tin=?");
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
									<td>'.$row_ret_two['cname'].'</td>
									<td>'.$row_ret_two['spe'].'</td>					
									<td>'.$row_ret_two['shareA'].'</td>					
									<td><a title="Remove Principal Officer" style="color:red;cursor: pointer; cursor: hand;" href=principal_officer.php?rem='.$row_ret_two['id'].'><img src="resource/delete-icon.jpg" style="height:20px" ></img></a></td>
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
				include 'settings/7.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
