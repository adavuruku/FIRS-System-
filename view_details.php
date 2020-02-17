<?php
session_start();
require_once 'settings/all_header.php';
require_once 'settings/connection.php';
$notice_msg1=$notice_msg2=$notice_msg3=$dateprint=$errPL="";
if(!isset($_SESSION['staff_name']) || !isset($_SESSION['staff_id'])){
		header("location: index.php?out=_no");
}

if(!isset($_GET['t_']) && !isset($_GET['r_']) && !isset($_GET['i_'])){
	header("location: index.php?out=_no");
}
$app_id = $_GET['t_'];
$rcnum= $_GET['r_'];
$idnum= $_GET['i_'];


$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint_V = $J.", ".$Q;
$dateprint = $J.", ".$Q;


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
					<?php
						include 'view_details_all.php';					
					?>
				</div>
			</div>
	</div>

		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
