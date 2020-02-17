<?php $cname="";?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Company Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<tbody>
	<?php
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=? and rcnumber=? and id=? Limit 1");
		$stmt_in->execute(array($app_id,$rcnum,$idnum));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					$cname = strtoupper($row_ret_two['cname']);
					echo '<tr>
							<td align="right">Company Name : </td>
							<td></td>
							<td>'.strtoupper($row_ret_two['cname']).'</td>
						</tr>
						<tr>
							<td align="right">TIN Number : </td>
							<td></td>
							<td style="color:red"><b>'.$row_ret_two['tin'].'</b></td>
						</tr>
						<tr>
							<td align="right">RC Number : </td>
							<td></td>
							<td>'.$row_ret_two['rcnumber'].'</td>
						</tr>
						<tr>
							<td align="right">Email Address : </td>
							<td></td>
							<td>'.$row_ret_two['cemail'].'</td>
						</tr>';
				}
		}else{
			header("location: index.php?out=_no");
		}
	?>
		</tbody>
	</table>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Address Information </h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<tbody>
	<?php
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=?");
		$stmt_in->execute(array($app_id));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					echo '<tr>
							<td align="right">Business Phone N<u>o</u> : </td>
							<td></td>
							<td>'.$row_ret_two['phone'].'</td>
						</tr>
						<tr>
							<td align="right">Official Website : </td>
							<td></td>
							<td>'.$row_ret_two['website'].'</td>
						</tr>
						<tr>
							<td align="right">Address Of Registered Office : </td>
							<td></td>
							<td>'.$row_ret_two['aregoffice'].'</td>
						</tr>
						<tr>
							<td align="right">Address Of Operational Office : </td>
							<td></td>
							<td>'.$row_ret_two['aoproffice'].'</td>
						</tr>';
				}
		}
	?>
		</tbody>
	</table>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Business Information  </h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<tbody>
	<?php
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=?");
		$stmt_in->execute(array($app_id));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					$date500 = new DateTime($row_ret_two['doi']);
					$J = date_format($date500,"D");
					$Q = date_format($date500,"d-F-Y");
					$dateprint = $J.", ".$Q;
					$date500 = new DateTime($row_ret_two['ocd']);
					$J = date_format($date500,"D");
					$Q = date_format($date500,"d-F-Y");
					$dateprint2 = $J.", ".$Q;
					echo '<tr>
							<td align="right">Nature Of Business : </td>
							<td></td>
							<td>'.$row_ret_two['nbusiness'].'</td>
						</tr>
						<tr>
							<td align="right">Business Form : </td>
							<td></td>
							<td>'.$row_ret_two['bform'].'</td>
						</tr>
						<tr>
							<td align="right">Business Line : </td>
							<td></td>
							<td>'.$row_ret_two['bline'].'</td>
						</tr>
						<tr>
							<td align="right">Date Of Incorporation : </td>
							<td></td>
							<td>'.$dateprint.'</td>
						</tr>
						<tr>
							<td align="right">Operation Commencement Date : </td>
							<td></td>
							<td>'.$dateprint2.'</td>
						</tr>';
				}
		}
	?>
		</tbody>
	</table>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Finance Information </h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<tbody>
	<?php
		$stmt_in = $conn->prepare("SELECT * FROM customer_record where tin=?");
		$stmt_in->execute(array($app_id));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			$date500 = new DateTime($row_ret_two['acntDate']);
			$J = date_format($date500,"D");
			$Q = date_format($date500,"d-F-Y");
			$dateprint = $J.", ".$Q;
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					echo '<tr>
							<td align="right">Account Name : </td>
							<td></td>
							<td>'.$row_ret_two['accntname'].'</td>
						</tr>
						<tr>
							<td align="right">Account Number : </td>
							<td></td>
							<td>'.$row_ret_two['accnnumber'].'</td>
						</tr>
						<tr>
							<td align="right">Sort Code : </td>
							<td></td>
							<td>'.$row_ret_two['accnsc'].'</td>
						</tr>
						<tr>
							<td align="right">Bank Name : </td>
							<td></td>
							<td>'.$row_ret_two['bankN'].'</td>
						</tr>
						<tr>
							<td align="right">Branch Name : </td>
							<td></td>
							<td>'.$row_ret_two['bankB'].'</td>
						</tr>
						<tr>
							<td align="right">Branch Address : </td>
							<td></td>
							<td>'.$row_ret_two['bankA'].'</td>
						</tr>
						<tr>
							<td align="right">Account Date : </td>
							<td></td>
							<td>'.$dateprint.'</td>
						</tr>';
				}
		}
	?>
		</tbody>
	</table>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Shareholders Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<thead style="color:blue;">
			<tr>
				<th>S/No.</th>
				<th>Name</th>
				<th>Value Of Share </th>
				<th>Phone/Email</th>
				<th>Address</th>
			</tr>
		</thead>
		<tbody>
	<?php
		//verify if it has been confirmed or is valid
		$stmt_in = $conn->prepare("SELECT * FROM customer_share where tin=?");
		$stmt_in->execute(array($app_id));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			$numbering_two = 1;
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					$formattedNum_one =  number_format($row_ret_two['vshare'], 2);
					echo '<tr>
							<td>'.$numbering_two.'</td>
							<td>'.$row_ret_two['sname'].'</td>
							<td> &#8358; '.$formattedNum_one.'</td>
							<td>'.$row_ret_two['spe'].'</td>					
							<td>'.$row_ret_two['shareA'].'</td>					
						</tr>';
						$numbering_two =$numbering_two + 1;
				}
		}
	?>
		</tbody>
	</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Directorship Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<thead style="color:blue;">
			<tr>
				<th>S/No.</th>
				<th>Name</th>
				<th>Company </th>
				<th>Phone/Email</th>
				<th>Address</th>
			</tr>
		</thead>
		<tbody>
	<?php
		//verify if it has been confirmed or is valid
		$stmt_in = $conn->prepare("SELECT * FROM customer_director where tin=?");
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
						</tr>';
						$numbering_two =$numbering_two + 1;
				}
		}
	?>
		</tbody>
	</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Principal Officers Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<thead style="color:blue;">
			<tr>
				<th>S/No.</th>
				<th>Name</th>
				<th>Office Title </th>
				<th>Phone/Email</th>
				<th>Address</th>
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
						</tr>';
						$numbering_two =$numbering_two + 1;
				}
		}
	?>
		</tbody>
	</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Company Branches Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<thead style="color:blue;">
			<tr>
				<th>S/No.</th>
				<th>State</th>
				<th>Local Government </th>
				<th>Address</th>
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
						</tr>';
						$numbering_two =$numbering_two + 1;
				}
		}
	?>
		</tbody>
	</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Associated Company Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
		<thead style="color:blue;">
			<tr>
				<th>S/No.</th>
				<th>Name Of Company</th>
				<th>RC Number </th>
				<th>Address</th>
			</tr>
		</thead>
		<tbody>
	<?php
		//verify if it has been confirmed or is valid
		$stmt_in = $conn->prepare("SELECT * FROM customer_company where tin=?");
		$stmt_in->execute(array($app_id));
		$affected_rows_in = $stmt_in->rowCount();
		if($affected_rows_in >= 1) 
		{
			$numbering_two = 1;
			while($row_ret_two = $stmt_in->fetch(PDO::FETCH_ASSOC)) 
				{
					echo '<tr>
							<td>'.$numbering_two.'</td>
							<td>'.$row_ret_two['cname'].'</td>
							<td>'.$row_ret_two['rc'].'</td>					
							<td>'.$row_ret_two['address'].'</td>
						</tr>';
						$numbering_two =$numbering_two + 1;
				}
		}
	?>
		</tbody>
	</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Company Auditors Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
	<thead style="color:blue;">
		<tr>
			<th>S/No.</th>
			<th>Name</th>
			<th>Phone </th>
			<th>Email</th>
			<th>Address</th>
		</tr>
	</thead>
	<tbody>
<?php
	//verify if it has been confirmed or is valid
	$stmt_in = $conn->prepare("SELECT * FROM customer_auditor where tin=?");
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
					</tr>';
					$numbering_two =$numbering_two + 1;
			}
	}
?>
	</tbody>
</table>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h4 style="margin-bottom:20px;background-color:#CCCCFF;padding:10px">Company Tax Representative Information</h4>
	<table class="table table-condensed" style="background-color:white;margin_top:10px;margin_bottom:10px;padding:10px;">
	<thead style="color:blue;">
		<tr>
			<th>S/No.</th>
			<th>Name</th>
			<th>Phone </th>
			<th>Email</th>
			<th>Address</th>
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
					</tr>';
					$numbering_two =$numbering_two + 1;
			}
	}
?>
	</tbody>
</table>
</div>