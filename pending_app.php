<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
$notice_msg1=$notice_msg2=$notice_msg3=$dateprint=$errPL="";
if(!isset($_SESSION['staff_name']) || !isset($_SESSION['staff_id'])){
		header("location: index.php?out=_no");
}

$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint_V = $J.", ".$Q;
$dateprint = $J.", ".$Q;

//approve application
if(isset($_GET['t_']) && isset($_GET['r_']) && isset($_GET['i_']) && isset($_GET['opr'])){
	$app_id = $_GET['t_'];
	$rcnum= $_GET['r_'];
	$idnum= $_GET['i_'];
	$stmt = $conn->prepare("UPDATE customer_record SET app_status = ?, dateApprove=now()  where tin=? and rcnumber=? and id=? Limit 1");
	$stmt->execute(array("2",$app_id,$rcnum,$idnum));
}

?>

</head>
<body style="width:80%;margin:auto">
<div class="container-fluid" >
		<div class="row hidden-print">
			<?php
				require_once 'settings/nav_top_staff.php';
			?> 
		</div>
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row" >
		<div class="imageupload panel panel-info">
			<div class="panel-heading clearfix">
				<h3 class="panel-title pull-left">Welcome - <?php echo $_SESSION['staff_name']; ?> , To Staff Dashboard !!</h3>
			</div>
		</div>
	</div>
	<div class="row" >
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="margin-bottom:10px;background-color:#CCCCFF;margin-top:5px;text-align:centre;padding-top:10px">
					<?php
						require_once 'settings/staff_nav_left.php';
					?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="margin-bottom:10px;margin-top:5px;text-align:centre;padding-top:5px">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 style="margin-bottom:10px;background-color:#CCCCFF;padding:10px">ALL PENDING FIRS APPLICATION AS AT - <?php echo $dateprint;?></h4>
					<?php
						
							$stmt_in = $conn->prepare("SELECT * FROM customer_record where app_status=?");
							$stmt_in->execute(array("1"));
							$affected_rows_in = $stmt_in->rowCount();
							if($affected_rows_in >= 1) 
							{
								echo '<p id="process" style="color:blue;text-align:center;"></p>
								<a class="text-right" style="text-decoration:none;color:black;" target="_blank" href=print_docs/print_pending_app.php?m_=oprt&l_w=tueq><h4><span class="glyphicon glyphicon-print" style="cursor:pointer;text-align:center;font-weight:900;padding:5px;"></span>Print List</h4></a>
								<table class="table table-condensed" style="background-color:#FFFFFF;margin-top:0px">
										<thead style="background-color:none;color:blue">
											<tr>
												<th>S/N<u>o</u>.</th>
												<th>Company Name</th>
												<th>TIN N<u>o</u></th>
												<th >RC N<u>o</u></th>
												<th >Phone N<u>o</u> / Email Add.</th>
												<th >Contact Add.</th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
										</thead>
										<tbody>';
								$j=1;$data="";
								while($row_two1 = $stmt_in->fetch(PDO::FETCH_ASSOC))
								{
									$data=$data.'<tr >
													<td>'.$j.'</td> 	
													<td>'.$row_two1['cname'].'</td>
													<td>'.$row_two1['tin'].'</td>
													<td>'.$row_two1['rcnumber'].'</td>
													<td>'.$row_two1['phone'].' / '.$row_two1['cemail'].'</td>
													<td>'.$row_two1['aregoffice'].'</td>
													<td><h4><a Title="Click to Approve" style="color:black" href=pending_app.php?t_='.$row_two1['tin'].'&i_='.$row_two1['id'].'&r_='.$row_two1['rcnumber'].'&opr=approve><span class="glyphicon glyphicon-book"></span></a></h4></td>
													<td><h4><a target="_blank" Title="Click to View Details" style="color:red" href=view_details.php?t_='.$row_two1['tin'].'&i_='.$row_two1['id'].'&r_='.$row_two1['rcnumber'].'><span class="glyphicon glyphicon-open"></span></a></h4></td>
													<td><h4><a target="_blank" Title="Click to Print" style="color:blue" href=print_docs/print_application_slip.php?t_='.$row_two1['tin'].'&i_='.$row_two1['id'].'&r_='.$row_two1['rcnumber'].'><span class="glyphicon glyphicon-print"></span></a></h4></td>
											</tr>';
									$j=$j + 1;
								}
								echo $data.'</tbody></table><a class="text-right" style="text-decoration:none;color:black;" target="_blank" href=print_docs/print_pending_app.php?m_=oprt&l_w=tueq> <h4><span class="glyphicon glyphicon-print" style="cursor:pointer;text-align:center;font-weight:900;padding:5px;"></span>Print List</h4></a>';
							}else{
								echo '<div class="alert alert-info alert-dismissable">
										   <button type="button" class="close" data-dismiss="alert" 
											  aria-hidden="true">
											  &times;
										   </button><h3>There is no more Pending FIRS Application..</h3></div>';
							}
					
					
					?>
				</div>
			</div>
	</div>

		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
