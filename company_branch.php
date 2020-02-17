<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$shareA=$txtlgov=$txtstate=$notice_msg="";
$txtstate="Select State";$txtlgov="Select Local Government";    
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
	$stmt = $conn->prepare("DELETE FROM customer_branch where id=?");
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
	$txtstate =trim($_POST['txtstate']); $txtlgov=trim($_POST['txtlgov']);	$shareA=trim($_POST['shareA']);
		//check if email is valid
		if(checkempty($txtstate) && checkempty($txtlgov) && checkempty($shareA)&& $txtlgov != "Select State" && $txtlgov != "Select Local Government" ){
			$stmt_in = $conn->prepare("SELECT address, tin FROM customer_branch where address=? and tin=?");
			$stmt_in->execute(array($shareA,$app_id));
			$affected_rows_in = $stmt_in->rowCount();
			if($affected_rows_in >= 1) 
			{
				$stmt = $conn->prepare("UPDATE customer_branch SET state = ?, lgv = ?, address = ?  where address=? and tin=? Limit 1");
				if($stmt->execute(array($txtstate,$txtlgov,$shareA,$shareA,$app_id))){
					$errPL="Success: Your Record Was Update Successfully - Verify!!!";
					$notice_msg='<div class="alert alert-success alert-dismissable">
				   <button type="button" class="close" data-dismiss="alert" 
					  aria-hidden="true">
					  &times;
				   </button> '.$errPL.' </div>';
				}
			}else{
				$sth = $conn->prepare("INSERT INTO customer_branch (state, lgv, address,tin) VALUES (?,?,?,?)");
				$sth->bindValue (1, $txtstate);
				$sth->bindValue (2, $txtlgov);
				$sth->bindValue (3, $shareA);
				$sth->bindValue (4, $app_id);
				if($sth->execute()){
					$errPL="Success: The Company Branch Record Was Created Successfully - Verify!!!";
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
<link rel="stylesheet" type="text/css" href="settings/css/select2.css"/>
<link rel="stylesheet" type="text/css" href="settings/css/select2.min.css"/>
<script type="text/javascript" src="settings/js/select2.js"></script>
<script type="text/javascript" src="settings/js/select2.min.js"></script>
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
				<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (8/11) - Company Branches Information</h4>
				<?php echo $notice_msg;?>
					<div class="form-group">
						<label for="sname" class="control-label col-xs-5">State <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<select class="form-control js-example-basic-single" id="cmbstate" name="txtstate" onchange="stateComboChange();">
								
								<option value="<?php echo $txtstate; ?>" ><?php echo $txtstate; ?></option>
								<option value="Abuja" title="Abuja">Abuja</option>
								<option value="Abia" title="Abia">Abia</option>
								<option value="Adamawa" title="Adamawa">Adamawa</option>
								<option value="Akwa Ibom" title="Akwa Ibom">Akwa Ibom</option>
								<option value="Anambra" title="Anambra">Anambra</option>
								<option value="Bauchi" title="Bauchi">Bauchi</option>
								<option value="Bayelsa" title="Bayelsa">Bayelsa</option>
								<option value="Benue" title="Benue">Benue</option>
								<option value="Bornu" title="Bornu">Bornu</option>
								<option value="Cross River" title="Cross River">Cross River</option>
								<option value="Delta" title="Delta">Delta</option>
								<option value="Ebonyi" title="Ebonyi">Ebonyi</option>
								<option value="Edo" title="Edo">Edo</option>
								<option value="Ekiti" title="Ekiti">Ekiti</option>
								<option value="Enugu" title="Enugu">Enugu</option>
								<option value="Gombe" title="Gombe">Gombe</option>
								<option value="Imo" title="Imo">Imo</option>
								<option value="Jigawa" title="Jigawa">Jigawa</option>
								<option value="Kaduna" title="Kaduna">Kaduna</option>
								<option value="Kano" title="Kano">Kano</option>
								<option value="Katsina" title="Katsina">Katsina</option>
								<option value="Kebbi" title="Kebbi">Kebbi</option>
								<option  value="Kogi" title="Kogi">Kogi</option>
								<option value="Kwara" title="Kwara">Kwara</option>
								<option value="Lagos" title="Lagos">Lagos</option>
								<option value="Nassarawa" title="Nassarawa">Nassarawa</option>
								<option value="Niger" title="Niger">Niger</option>
								<option value="Ogun" title="Ogun">Ogun</option>
								<option value="Ondo" title="Ondo">Ondo</option>
								<option value="Osun" title="Osun">Osun</option>
								<option value="Oyo" title="Oyo">Oyo</option>
								<option value="Plateau" title="Plateau">Plateau</option>
								<option value="Rivers" title="Rivers">Rivers</option>
								<option value="Sokoto" title="Sokoto">Sokoto</option>
								<option value="Taraba" title="Taraba">Taraba</option>
								<option value="Yobe" title="Yobe">Yobe</option>
								<option value="Zamfara" title="Zamfara">Zamfara</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="cname" class="control-label col-xs-5">Local Gov't <span style="color:red">*</span> : </label>
						<div class="col-xs-7">
							<select class="form-control js-example-basic-single" id="cmblgov" name="txtlgov">
										<option value="<?php echo $txtlgov; ?>" ><?php echo $txtlgov; ?></option>
							</select>
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
							<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Add Company Branch" class="btn btn-primary btn-md"></input>
						</div>
					</div>
				</form>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
				<thead style="color:blue;">
					<tr>
						<th>S/No.</th>
						<th>State</th>
						<th>Local Government </th>
						<th>Address</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
			<?php
				//verify if it has been confirmed or is valid
				$stmt_in = $conn->prepare("SELECT * FROM customer_branch where tin=?");
				$stmt_in->execute(array($app_id));
				$affected_rows_in = $stmt_in->rowCount();
				if($affected_rows_in >= 1) 
				{
					$numbering_two = 1;
					while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
						{
							echo '<tr>
									<td>'.$numbering_two.'</td>
									<td>'.$row_ret_two['state'].'</td>
									<td>'.$row_ret_two['lgv'].'</td>					
									<td>'.$row_ret_two['address'].'</td>					
									<td><a title="Remove Company Branch" style="color:red;cursor: pointer; cursor: hand;" href=company_branch.php?rem='.$row_ret_two['id'].'><img src="resource/delete-icon.jpg" style="height:20px" ></img></a></td>
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
				include 'settings/8.php';
			?> 
		</div>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
  <script type="text/javascript">
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
</script>
</body>
</html>  
