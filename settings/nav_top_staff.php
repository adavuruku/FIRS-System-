<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<img src="settings/images/headlogo.jpg"  class="img-responsive"></img>
			</div>
		
		<!-- navigation menu -->
		<div class="col-xs-12 col-sm-12">
			<nav role="navigation" class="navbar navbar-default">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header navedit">
				<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navedit">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				 <a href="index.php?out=_no" class="navbar-brand">Sign Out</a>
			</div>
			<!-- Collection of nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse navedit">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#"><?php echo $_SESSION['staff_id'];?></a></li>
				 </ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#"><?php echo $_SESSION['staff_name'];?></a></li>
				</ul>
			</div>
		</nav>
	</div>