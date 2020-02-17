<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$vattoDate=$vatfromDate=$vattoDate1=$vatfromDate1=$notice_msg=$errPL2="";
   $errPL2='List of Some Of Your Last Calculated / Uploaded VAT- SEARCH RESULT';
if(!isset($_SESSION['email']) || !isset($_SESSION['app_id'])){
		header("location: index.php?out=_yes");
}
//$rc = $_GET['rc']; 
$mail = $_SESSION['email']; 
$app_id = $_SESSION['app_id'];

//verify if it has been confirmed or is valid - if app not approved dissalowed VAT Computation
$stmt_in = $conn->prepare("SELECT cemail, tin, app_status FROM customer_record where cemail=? and tin=? and app_status=? Limit 1");
$stmt_in->execute(array($mail,$app_id,"2"));
$affected_rows_in = $stmt_in->rowCount();
if($affected_rows_in < 1) 
{
	header("location: account_home.php");
}

//update the new record
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	 $vattoDate1=$vattoDate=trim($_POST['vattoDate']);
$vatfromDate1 = $vatfromDate=trim($_POST['vatfromDate']);
		//check if email is valid
		if(checkempty($vattoDate) && checkempty($vatfromDate)){
			$date500 = new DateTime($vattoDate);
			$vattoDate1 = date_format($date500,"Y-m-d");
			
			$date500 = new DateTime($vattoDate1);
			$J = date_format($date500,"D");
			$Q = date_format($date500,"d-F-Y");
			$dateprint_V = $J.", ".$Q;
			$datetoprint = $J.", ".$Q;	
			
			$date500 = new DateTime($vatfromDate);
			$vatfromDate1 = date_format($date500,"Y-m-d");
			
			$date500 = new DateTime($vatfromDate1);
			$J = date_format($date500,"D");
			$Q = date_format($date500,"d-F-Y");
			$dateprint_V = $J.", ".$Q;
			$datefromprint = $J.", ".$Q;
			
			$errPL2='List Of All Your Calculated / Uploaded VAT From - '.$datefromprint.' - '.$datetoprint;
		}else{
			$errPL="Error: Invalid Datas Provided - Verify!!!";
			$notice_msg='<div class="alert alert-danger alert-dismissable">
		   <button type="button" class="close" data-dismiss="alert" 
			  aria-hidden="true">
			  &times;
		   </button> '.$errPL.' </div>';
		}
		$date500 = new DateTime($vattoDate);
		$vattoDate = date_format($date500,"d/m/Y");
		$date500 = new DateTime($vatfromDate);
		$vatfromDate = date_format($date500,"d/m/Y");
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
				include 'settings/nav_left_account.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
					<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Print / View Company Income Tax (CIT) and Education Tax (ET) Computation </h4>
					<?php echo $notice_msg;?>
						<div class="form-group" style="margin-top:25px">
							<label for="vatfromDate" class="control-label col-xs-5">Date From <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="vatfromDate" name="vatfromDate" value="<?php echo $vatfromDate;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="vattoDate" class="control-label col-xs-5">Date To <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="vattoDate" name="vattoDate" value="<?php echo $vattoDate;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group pull-right">
							<div class="col-xs-7">
								<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Search CIT and ET" class="btn btn-primary btn-md"></input>
							</div>
						</div>
						
					</form>
				</div>
		
		</div>
		
		
		
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				include 'settings/account.php';
			?> 
		</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
				<?php
					
						$stmt_in = $conn->prepare("SELECT * FROM customer_cit where tin=? and vatDate between ? and ? order by vatDate desc");
						$stmt_in->execute(array($app_id,$vatfromDate1,$vattoDate1));
						$affected_rows_in = $stmt_in->rowCount();
						if($affected_rows_in >= 1) 
						{
							echo '<p id="process" style="color:red;text-align:center;"><b>'.$errPL2.'</b></p>
							<hr/>
							<table class="table table-condensed" style="background-color:#FFFFFF;margin-top:0px">
									<thead style="background-color:none;color:blue">
										<tr>
											<th>S/N<u>o</u>.</th>
											<th>Tot. Turn Over</th>
											<th>Tot. Profit / Loss </th>
											<th>Status </th>
											<th >Depreciation</th>
											<th >Tot. ANE</th>
											<th >Tot. Capital.</th>
											<th >Tot. CIT.</th>
											<th >Tot. ET.</th>
											<th>VAT Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>';
							$j=1;$data="";
							while($row_two1 = $stmt_in->fetch(PDO::FETCH_ASSOC))
							{
								
								$date500 = new DateTime($row_two1['vatDate']);
								$vatDate1 = date_format($date500,"d-m-Y");
								$nprofitLoss =$row_two1['nprofitLoss'];
								$profitLoss =  number_format($row_two1['profitLoss'], 2);									
								$turnOver =  number_format($row_two1['turnOver'], 2);									
								$depreciation =  number_format($row_two1['depreciation'], 2);
								$ane =  number_format($row_two1['ane'], 2);									
								$capital =  number_format($row_two1['capital'], 2);
								$cit =  number_format($row_two1['cit'], 2);									
								$et =  number_format($row_two1['et'], 2);
								$data=$data.'<tr >
												<td>'.$j.'</td> 	
												<td> &#8358; '.$turnOver.'</td>
												<td> &#8358; '.$profitLoss.'</td>
												<td>'.$nprofitLoss.'</td>
												<td> &#8358; '.$depreciation.'</td>
												<td> &#8358; '.$ane.'</td>
												<td> &#8358; '.$capital.'</td>
												<td> &#8358; '.$cit.'</td>
												<td> &#8358; '.$et.'</td>
												<td>'.$vatDate1.'</td>
												<td><h4><a target="_blank" Title="Click to Print" style="color:blue" href=print_docs/print_CIT_slip.php?i_='.$row_two1['id'].'><span class="glyphicon glyphicon-print"></span></a></h4></td>
										</tr>';
								$j=$j + 1;
							}
							echo $data.'</tbody></table><a class="text-right" style="text-decoration:none;color:red;" target="_blank" href=print_docs/print_all_cit.php?f_='.$vatfromDate1.'&t_='.$vattoDate1.'> <h6><span class="glyphicon glyphicon-print" style="cursor:pointer;text-align:center;font-weight:900;padding:5px;"></span>Print All...</h6></a>';
						}
				
				
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
