<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang="en"> <!--<![endif]-->
<head>

	<!-- General Metas -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>Login Form</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo admin_template_url();?>css/base.css">
	<link rel="stylesheet" href="<?php echo admin_template_url();?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo admin_template_url();?>css/layout.css">
	<script src="<?php echo admin_template_url();?>js/jquery-1.9.0.min.js"></script>
	<script src="<?php echo admin_template_url();?>js/app.js"></script>
</head>
<body>

	<!-- Primary Page Layout -->

	<div class="container">
		
		<div class="form-bg">
			<?php echo form_open( site_url('admin/login/do_login') );?>
				<h2>Login</h2>
                <?php if($this->session->flashdata('login_msg')) echo $this->session->flashdata('login_msg'); ?>
				<p><?php echo form_input('username','','placeholder="Username"'); ?></p>
				<p><?php echo form_password('password','','placeholder="Password"'); ?></p>
				
				<button type="submit" name="login"></button>
			<?php echo form_close();?>
		</div>


	</div><!-- container -->

<!-- End Document -->
</body>
</html>