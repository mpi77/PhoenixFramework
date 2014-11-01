<?php if(Acl::isLoggedin() === true){ /* loggedin user */?>
<div class="container" role="main">
	<div class="page-header">
		<h1>Dashboard</h1>
	</div>
</div>
<?php /* end of loggedin user*/ } else {?>
<div class="container" role="main">
	<div class="page-header">
		<h1><?php $tpd->es("greeting");?></h1>
	</div>
	<?php Breadcrumbs::e();?>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<a href="user/login/" class="btn btn-lg btn-default btn-block">Log in</a>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
		</div>
		<div class="spacer-20"></div>
	</div>
</div>
<?php }?>