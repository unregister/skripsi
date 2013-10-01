<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <title><?php echo ( isset($title) ) ? $title : 'Administrator'; ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="http://fonts.googleapis.com/css?family=Oxygen|Marck+Script" rel="stylesheet" type="text/css">
    <link href="<?php echo template_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo template_url();?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo template_url();?>css/admin.css" rel="stylesheet">
    <link href="<?php echo template_url();?>js/datepicker/jquery.datepick.css" rel="stylesheet">
    <script src="<?php echo template_url();?>js/jquery.js"></script>
	<script src="<?php echo template_url();?>js/bootstrap.js"></script>
    <script src="<?php echo template_url();?>js/excanvas.min.js"></script>
    <script src="<?php echo template_url();?>js/jquery.flot.min.js"></script>
    <script src="<?php echo template_url();?>js/jquery.flot.resize.js"></script>
    <script src="<?php echo template_url();?>js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo template_url();?>js/datepicker/jquery.datepick.js"></script>
    <script type="text/javascript" src="<?php echo template_url();?>js/custom.js"></script>
	<script type="text/javascript">
		var base_url = '<?php echo base_url();?>';
		$(document).ready(function(){
			$('#msg').fadeOut(400);
			$('.datepicker').datepick({showTrigger: '#calImg',dateFormat: 'dd-mm-yyyy'});
		});
	</script>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    

</head>    
<body>
<div style="display: none;">
	<img id="calImg" src="<?php echo template_url();?>js/datepicker/calendar-green.gif" alt="Popup" class="trigger">
</div>

<div class="container">
		
	<div class="row">
		
		<div class="span2">
		
		<div class="main-left-col">
		
			<ul class="side-nav">
            	<li><a href="<?php echo site_url('main/dashboard');?>">Data penduduk</a></li>
                <!--<li><a href="<?php echo site_url('main/add');?>">Tambah person</a></li> -->
                <li><a href="<?php echo site_url('main/spasial');?>">Data spasial</a></li>
                <!--<li><a href="<?php echo site_url('main/add_spasial');?>">Tambah spasial</a></li> -->
                <li><a href="<?php echo site_url('main/logout');?>">Logout</a></li>
            </ul>
			
			
		
		</div> <!-- end main-left-col -->
	
	</div> <!-- end span2 -->
	
	<div class="span10">
		
	<div class="secondary-masthead">
	
		<ul class="nav nav-pills pull-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <?php echo get_login('admin_nama'); ?> <b class="caret"></b>
				</a>
			</li>
		</ul>

		<ul class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin/dashboard');?>">Dashboard</a> <span class="divider">/</span>
			</li>
			<li class="active"><?php echo ( isset($title) ) ? $title : 'Administrator'; ?> </li>
		</ul>
		
	</div>
	
	<div class="main-area dashboard">
		
        <div class="row">
        <div class="span10">
        <div id="response" style="display:none"></div>
		<?php 
		if( isset($page) and !empty($page)  )
		{
			$this->load->view($page);	
		}
		else
		{
			$this->load->view('dashboard');	
		}
		?>
		</div>
        </div>
	
		
		
		
		<div class="row">
		
			<div class="span10 footer">
			
				<p>&copy; Website Name 2012</p>
			
			</div>
		
		</div>
		
	</div>
	
	</div> <!-- end span10 -->
		
	</div> <!-- end row -->
		
</div> <!-- end container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->


</body>
</html>
