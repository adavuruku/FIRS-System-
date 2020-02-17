<?php
session_start();
require_once 'settings/all_header.php';
//logout for applicants
if(isset($_GET['out']) && $_GET['out']=="_yes"){
	if(isset($_SESSION['email']) || isset($_SESSION['app_id']) || isset($_SESSION['cname']) ){
		unset($_SESSION['email']); unset($_SESSION['app_id']); unset($_SESSION['cname']);
	}
}

//logout for staff
if(isset($_GET['out']) && $_GET['out']=="_no"){
	if(isset($_SESSION['staff_name']) || isset($_SESSION['staff_id'])){
		unset($_SESSION['staff_name']); unset($_SESSION['staff_id']);
	}
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").modal('show');		
	});
</script>
 
</head>
<body style="width:80%;margin:auto">
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-sm modal-md">
        <div class="modal-content">
            <div class="modal-header label-primary" >
                <button type="button" style="color:RED;font-family:comic sans ms;font-size:20px;font-weight:bold" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:WHITE;font-family:comic sans ms;font-size:25px;font-weight:bold">ABOUT THE PROJECT - COLLECTION AND CALCULATION OF AUTOMATED VALUE ADDED TAX (VAT)</h4>
            </div>
            <div class="modal-body" style="font-family:comic sans ms;font-size:15px;font-weight:bold">
                <p>Abubakar Tafawa Balewa University, Bauchi - Bauchi State Nigeria.</p>
				<p>The Project Collection And Calculation Of Automated Value Added Tax (VAT). is Design By :</p>
				<p> Bilikisu Ishaq Muhammad - Registration N<u>o</u> : 14/36759D/1 .</p>
				<br>
				<p >For the Partial Fulfillment of the requirement for the Award of Bachelor Of Technology (BTech) in Computer Science - Abubakar Tafawa Balewa University, Bauchi - 2018</p><br>
				<p  style="color:red">Supervised By : Prof. M. S. Atureta.</p>
                <p  class="text-warning"><small >Copyright © 2018</small></p>
            </div>
            <div class="modal-footer label-primary">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid" >
	<div class="row">
			<?php
				require_once 'settings/nav_top.php';
			?> 
	</div>	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row" style="background-color:#CCFFFF;">
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="vertical-spacing:3px;margin-bottom:0px;word-spacing:3px;line-height:150%;background-color:#CCCCFF;text-align:justify">
			<?php
				require_once 'settings/project_info.php';
			?> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 style="font-weight:bold;background-color:#CC99CC;color:white;padding:10px 5px 10px 5px"> Procedures For New Application <h4/>
				<p class="btn btn-primary" style="margin-bottom:10px;margin-top:10px;">Step 1 : Generate Tax Identification N<u>o</u> (TIN)</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Generate Tax Identification N<u>o</u> (TIN)</li>
					<li>Key in your Email Address, Company Name, RC Number and Provide Your Password</li>
					<li><strong>Click Generate TIN to Generate TIN N<u>o</u> </strong>  <a style="color:red;" href="generate_pin.php">Click Here To Start >> </a></li> 
				</ol>
				
				</P>
				<p class="btn btn-info" style="margin-bottom:10px;margin-top:10px;">Step 2 : Login To Complete Your Application</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Complete Application</li>
					<li>Provide your Tax Identification N<u>o</u> (TIN) And Password </li>
					<li style="color:red"><strong>Click Continue</strong></li>
					<li><strong>Fill All the required Information in all the Forms</strong></li>
					<li><strong>Click Submit to Preview all the information you provided</strong></li>
					<li><strong>Click Continue to Complete the registration or edit to Edit the informations</strong>  <a style="color:red;" href="login_to_profile.php">Click Here To Start >> </a></li> 
				</ol></P>
				<p class="btn btn-success" style="margin-bottom:10px;margin-top:10px;">Step 3 : Check Application Status</p>
				<p>Follow the steps bellow :</p>
				<P><ol>
					<li>Click on Check Application Status</li>
					<li>Provide your Tax Identification N<u>o</u> (TIN) And Password</li>
					<li style="color:red"><strong>Click Continue</strong></li>
					<li><strong>After Login Successfully Click on Check Application Status</strong></li>
					<li>Your TIN Application Slip will be downloaded to your system if the Application is successfully Approved <a style="color:red;" href="login_status.php">Click Here To Start >> </a></li> 
				</ol></P>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:grey;text-align:centre">
			<hr/>
				<p style="text-align:center"><a href="generate_pin.php"><span class="btn btn-primary">Generate Tax Identification N<u>o</u></span></a> | <a href="login_to_profile.php"><span class="btn btn-info">Complete Application</span></a> | <a href="login_status.php"><span class="btn btn-success">Check Application Status</span></a></p>
			<hr/>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;margin-top:10px;background-color:#CC99CC;padding:0px;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);border-top-left-radius:55px;border-bottom-right-radius:55px;background-color:white;text-align:centre">
				<h5 style="color:black;font-family:comic sans ms;font-size:20px;font-weight:bold;text-align:center">ABOUT THE PROJECT - COLLECTION AND CALCULATION OF AUTOMATED VALUE ADDED TAX (VAT)</h5>
                <h5 style="color:black;font-family:comic sans ms;font-size:20px;font-weight:bold;text-align:center" >Abubakar Tafawa Balewa University, Bauchi - Bauchi State Nigeria.</h5>
				<h5 style="color:black;font-family:comic sans ms;font-size:20px;">The Project Collection And Calculation Of Automated Value Added Tax (VAT) is Design By :</h5>
				<h5 style="color:black;font-family:comic sans ms;font-size:20px;"> Bilikisu Ishaq Muhammad - Registration N<u>o</u> : 14/36759D/1.</h5>
				<br>
				<h5 style="color:black;font-family:comic sans ms;font-size:20px;text-align: justify;">For the Partial Fulfillment of the requirement for the Award of Bachelor Of Technology (BTech) in Computer Science - Abubakar Tafawa Balewa University, Bauchi - 2018</h5><br>
				<h5  style="color:red;font-family:comic sans ms;font-size:16px;">Supervised By : Prof. M. S. Atureta.</h5>
				
                <h5 style="font-family:comic sans ms;font-size:16px;" class="text-warning"><small>Copyright © 2018</small></h5>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" style="font-weight:bold;background-color:grey;padding:20px 15px 20px 15px;color:black">
		<?php
			require_once 'settings/index_comment.php';
		?>
	</div>
		<?php require_once 'settings/footer_file.php';?>
 </div>
</body>
</html>  
