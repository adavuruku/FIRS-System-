<div id="accordion" class="panel-group" style="margin-top:20px;">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title ">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> My Menu </a>
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="glyphicon glyphicon-chevron-down pull-right"></a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="list-group">
					<a style="color:blue;text-weight:bold;" class="list-group-item" href="account_home.php" >
						<span class="glyphicon glyphicon-home"></span> View Profile <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;text-weight:bold;" class="list-group-item" href="address_information.php" >
						<span class="glyphicon glyphicon-edit"></span> Complete Application <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:green;text-weight:bold;" class="list-group-item"  href="account_home.php?check=_yes">
						<span class="glyphicon glyphicon-lock"></span> Check Application Status <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:red"  href="index.php?out=_yes" class="list-group-item">
							<span class="glyphicon glyphicon-log-out"></span> Log Out  <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title ">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> Tax Menu</a>
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="glyphicon glyphicon-chevron-down pull-right"></a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="list-group">
					<a style="color:black;text-weight:bold;" class="list-group-item" href="calc_vat.php" >
						<span class="glyphicon glyphicon-pencil"></span> Compute / Upload VAT <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;text-weight:bold;" class="list-group-item"  href="calc_cit.php">
						<span class="glyphicon glyphicon-pencil"></span> Compute / Upload CIT and ET <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title ">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> Print Slips</a>
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="glyphicon glyphicon-chevron-down pull-right"></a>
			</h4>
		</div>
		<div id="collapseThree" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="list-group">
					<?php
						$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=?");
						$stmt_in->execute(array($app_id));
						$affected_rows_in = $stmt_in->rowCount();
						if($affected_rows_in >= 1) 
						{
							$row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
							if($row_ret_two['app_status']=="1" || $row_ret_two['app_status']=="2"){
								echo '<a style="color:black;text-weight:bold;" class="list-group-item"  target="_blank" href=print_docs/print_application_slip.php?t_='.$row_ret_two['tin'].'&i_='.$row_ret_two['id'].'&r_='.$row_ret_two['rcnumber'].'>
										<span class="glyphicon glyphicon-print"></span> Print Application Slip <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
									</a>';
							}
							if($row_ret_two['app_status']=="2"){
								echo '<a style="color:black;text-weight:bold;" class="list-group-item"  target="_blank" href=print_docs/print_approval_slip.php?t_='.$row_ret_two['tin'].'&i_='.$row_ret_two['id'].'&r_='.$row_ret_two['rcnumber'].'>
										<span class="glyphicon glyphicon-print"></span> Print Approved FIRS Slip <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
									</a>';
							}
							
						}
					?>
					<a style="color:black;text-weight:bold;" class="list-group-item" href="view_vat.php">
						<span class="glyphicon glyphicon-print"></span> Print FIRS VAT Slip <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;text-weight:bold;" class="list-group-item" href="view_cit.php">
						<span class="glyphicon glyphicon-print"></span> Print FIRS CIT and ET Slip <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>