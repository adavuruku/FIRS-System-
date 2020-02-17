<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$errPL=$vatDate=$totBuy=$totSales=$notice_msg="";
    
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
	 $vatDate=trim($_POST['vatDate']);	$totBuy=trim($_POST['totBuy']);
	$totSales=trim($_POST['totSales']);
		//check if email is valid
		if( checkempty($vatDate) && checkempty($totBuy)&& checkempty($totSales)){
			$date500 = new DateTime($vatDate);
			$vatDate = date_format($date500,"Y-m-d");
			$vatSales= 0.05 * $totSales;
			$vatPurchase= 0.05 * $totBuy;
			$vat  = $vatSales - $vatPurchase;
			$formattedNum_one =  number_format($vat, 2);
			$stmt = $conn->prepare("INSERT INTO customer_vat (vatDate, tin, totSales, totBuy,vatSales,vatPurchase, vat) values (?,?,?,?,?,?,?)");
			if($stmt->execute(array($vatDate,$app_id,$totSales,$totBuy,$vatSales,$vatPurchase,$vat))){
				$errPL="Success: VAT Was Calculated And Saved Successfully - VAT WAS -  &#8358; ".$formattedNum_one;
				$notice_msg='<div class="alert alert-success alert-dismissable">
			   <button type="button" class="close" data-dismiss="alert" 
				  aria-hidden="true">
				  &times;
			   </button> '.$errPL.' </div>';
			}else{
				$errPL="Error: Unable To Calculate And Update VAT - Verify!!!";
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
	$date500 = new DateTime($vatDate);
	$vatDate = date_format($date500,"d/m/Y");
}
$date500 = new DateTime($vatDate);
$vatDate = date_format($date500,"d/m/Y");
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
					<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Value Added Tax(VAT) Computation </h4>
					<?php echo $notice_msg;?>
						<div class="form-group" style="margin-top:25px">
							<label for="totBuy" class="control-label col-xs-5">Total Purchase (VAT Exclusive) <span style="color:red">*</span> &#8358; : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control" onkeydown="return noNumbers(event,this)" id="totBuy" name="totBuy" value="<?php echo $totBuy;?>" required="true" placeholder="Enter Total Purchase (VAT Exclusive)" />
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="totSales" class="control-label col-xs-5">Total Sales (VAT Exclusive) <span style="color:red">*</span> &#8358; : </label>
							<div class="col-xs-7">
								<input type="text" class="form-control" onkeydown="return noNumbers(event,this)" id="totSales" name="totSales" value="<?php echo $totSales;?>" required="true" placeholder="Enter Total Sales (VAT Exclusive)" />
							</div>
						</div>
						<div class="form-group" style="margin-top:25px">
							<label for="vatDate" class="control-label col-xs-5">VAT Computation Date <span style="color:red">*</span> : </label>
							<div class="col-xs-7">
								<div class="input-group date" data-provide="datepicker">
										
										<input type="text" class="form-control"  id="vatDate" name="vatDate" value="<?php echo $vatDate;?>" required="true" />
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group pull-right">
							<div class="col-xs-7">
								<input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Calculate / Upload VAT" class="btn btn-primary btn-md"></input>
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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
						
							$stmt_in = $conn->prepare("SELECT * FROM customer_vat where tin=? order by vatDate desc Limit 5");
							$stmt_in->execute(array($app_id));
							$affected_rows_in = $stmt_in->rowCount();
							if($affected_rows_in >= 1) 
							{
								echo '<p id="process" style="color:blue;text-align:center;">List of Some Of Your Last Calculated / Uploaded VAT </p>
								<hr/>
								<table class="table table-condensed" style="background-color:#FFFFFF;margin-top:0px">
										<thead style="background-color:none;color:blue">
											<tr>
												<th>S/N<u>o</u>.</th>
												<th>Tot. Purchase</th>
												<th>Tot. Sales</th>
												<th >Purchase VAT</th>
												<th >Sales VAT.</th>
												<th >Tot. VAT.</th>
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
									
									$totSales1 =  number_format($row_two1['totSales'], 2);
									$totBuy1 =  number_format($row_two1['totBuy'], 2);
									$vatSales1 =  number_format($row_two1['vatSales'], 2);
									$vatPurchase1 =  number_format($row_two1['vatPurchase'], 2);
									$vat1 =  number_format($row_two1['vat'], 2);
									$data=$data.'<tr >
													<td>'.$j.'</td> 	
													<td> &#8358; '.$totBuy1.'</td>
													<td> &#8358; '.$totSales1.'</td>
													<td> &#8358; '.$vatPurchase1.'</td>
													<td> &#8358; '.$vatSales1.'</td>
													<td> &#8358; '.$vat1.'</td>
													<td>'.$vatDate1.'</td>
													<td><h4><a target="_blank" Title="Click to Print" style="color:blue" href=print_docs/print_VAT_slip.php?i_='.$row_two1['id'].'><span class="glyphicon glyphicon-print"></span></a></h4></td>
											</tr>';
									$j=$j + 1;
								}
								echo $data.'</tbody></table><a class="text-right" style="text-decoration:none;color:red;" href=view_vat.php> <h6><span class="glyphicon glyphicon-list" style="cursor:pointer;text-align:center;font-weight:900;padding:5px;"></span>View More...</h6></a>';
							}else{
								echo '<div class="alert alert-info alert-dismissable">
										   <button type="button" class="close" data-dismiss="alert" 
											  aria-hidden="true">
											  &times;
										   </button><h3>There is no VAT Calculated Yet..</h3></div>';
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
