<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$nbusiness=$doi=$ocd=$bform=$bline=$notice_msg="";
    
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
	$nbusiness=$row['nbusiness'];
	$doi=$row['doi'];
	$ocd=$row['ocd'];
	$bform=$row['bform'];
	$bline=$row['bline'];
	if($row['app_status']!="0"){
		header("location: account_home.php");
	}
}else{
	header("location: index.php");
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$nbusiness =trim($_POST['nbusiness']); $doi=trim($_POST['doi']);	$ocd=trim($_POST['ocd']);
	$bform=trim($_POST['bform']); $bline=trim($_POST['bline']);
		//check if email is valid
		if(checkempty($nbusiness) && checkempty($doi) && checkempty($ocd)&& checkempty($bform) && checkempty($bline) && $nbusiness!="-Business Nature-" && $bform!="-Business Form-" ){
			$date500 = new DateTime($doi);
			$doi = date_format($date500,"Y-m-d");
			$date500 = new DateTime($ocd);
			$ocd = date_format($date500,"Y-m-d");
			$stmt = $conn->prepare("UPDATE customer_record SET nbusiness = ?, doi = ?, ocd = ?, bform = ?, bline = ?  where cemail=? and tin=? Limit 1");
			if($stmt->execute(array($nbusiness,$doi,$ocd,$bform,$bline,$mail,$app_id))){
				header("location: finance_information.php");
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

$date500 = new DateTime($doi);
$doi = date_format($date500,"m/d/Y");
$date500 = new DateTime($ocd);
$ocd = date_format($date500,"m/d/Y");
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
					<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Step (3/11) - Business Information </h4>
					<?php echo $notice_msg;?>
						<div class="form-group">
							<label for="nbusiness" class="control-label col-xs-5">Nature Of Business <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<select class="form-control js-example-basic-single"  id="nbusiness" name="nbusiness" value="<?php echo $nbusiness; ?>" >
									<option value="-Business Nature-" title="-Business Nature-">-Business Nature-</option>
									<option value="Ltd" title="Ltd">Ltd</option>
									<option value="Plc" title="Plc">Plc</option>
									<option value="Inc" title="Inc">Inc</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="bform" class="control-label col-xs-5">Business Form <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<select class="form-control js-example-basic-single"  id="bform" name="bform" value="<?php echo $bform; ?>" >
									<option value="-Business Nature-" title="-Business Nature-">-Business Form-</option>
									<option value="Bank And Financial Institutions" title="Bank And Financial Institutions">Bank And Financial Institutions</option>
									<option value="Agric And Plantation" title="Agric And Plantation">Agric And Plantation</option>									
									<option value="Conglomerate" title="Conglomerate">Conglomerate</option>
									<option value="Textile And Garment Industry" title="Textile And Garment Industry">Textile And Garment Industry</option>
									<option value="Building And Construction" title="Building And Construction">Building And Construction</option>
									<option value="Commercial And Trading" title="Commercial And Trading">Commercial And Trading</option>									
									<option value="Property And Investment" title="Property And Investment">Property And Investment</option>
									<option value="Automobile Assembly" title="Automobile Assembly">Automobile Assembly</option>
									<option value="Steredorin, Cleaning And FRWD" title="Steredorin, Cleaning And FRWD">Steredorin, Cleaning And FRWD</option>
									<option value="Professional Service" title="Professional Service">Professional Service</option>
									<option value="Breweries, Bottling And Beverages" title="Breweries, Bottling And Beverages">Breweries, Bottling And Beverages</option>
									<option value="Pharmaceutical, Soap And Toileting" title="Pharmaceutical, Soap And Toileting">Pharmaceutical, Soap And Toileting</option>
									<option value="Publishing, Printing And Packaging" title="Publishing, Printing And Packaging">Publishing, Printing And Packaging</option>
									<option value="Hotel And Catering" title="Hotel And Catering">Hotel And Catering</option>									
									<option value="Chemicals, Paints And Allied Products" title="Chemicals, Paints And Allied Products">Chemicals, Paints And Allied Products</option>
									<option value="Other Manufacturing" title="Other Manufacturing">Other Manufacturing</option>
									<option value="Oil Production" title="Oil Production">Oil Production</option>
									<option value="Pioneering" title="Pioneering">Pioneering</option>
									<option value="Transport And Haulage" title="Transport And Haulage">Transport And Haulage</option>
									<option value="Oil Marketing" title="Oil Marketing">Oil Marketing</option>
									<option value="Offshore Operaion" title="Offshore Operaion">Offshore Operaion</option>
									<option value="Petrol-Chemicals And Refineries" title="Petrol-Chemicals And Refineries">Petrol-Chemicals And Refineries</option>
									<option value="Gas" title="Gas">Gas</option>									
									<option value="Minning" title="Minning">Minning</option>
									<option value="Federal Ministries And Parastatals" title="Federal Ministries And Parastatals">Federal Ministries And Parastatals</option>
									<option value="State Ministries And Parastatals" title="State Ministries And Parastatals">State Ministries And Parastatals</option>
									<option value="Local Government Councils" title="Local Government Councils">Local Government Councils</option>
									<option value="Banking" title="Banking">Banking</option>
									<option value="Insurance" title="Insurance">Insurance</option>									
									<option value="Communication" title="Communication">Communication</option>
									<option value="Cyber Industry" title="Cyber Industry">Cyber Industry</option>
									<option value="Information Technology" title="Information Technology">Information Technology</option>
									<option value="Pension Fund Administrator" title="Pension Fund Administrator">Pension Fund Administrator</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="doi" class="control-label col-xs-5">Date Of Incorporation <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="doi" name="doi" value="<?php echo $doi;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="ocd" class="control-label col-xs-5">Operation Commencement Date <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="ocd" name="ocd" value="<?php echo $ocd;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						
						<div class="form-group" style="margin-top:25px">
							<label for="bline" class="control-label col-xs-5">Business Line <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control" onkeydown="return noNumbers(event,this)" id="bline" name="bline" value="<?php echo $bline;?>" required="true" placeholder="Enter Business Line" />
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
				include 'settings/3.php';
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
