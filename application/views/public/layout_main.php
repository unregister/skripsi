<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Pemetaan Fungsi Ekonomi dan Visualisasi Demografi Kependudukan Kabupaten Klaten</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="HTML5 Admin Simplenso Template" />
  <meta name="author" content="ahoekie" />

  <!-- Bootstrap -->
  <link href="<?php echo template_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet" id="main-theme-script" />
  <link href="<?php echo template_url(); ?>css/themes/default.css" rel="stylesheet" id="theme-specific-script" />
  <link href="<?php echo template_url(); ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />

  <!-- Full Calender -->
  <link rel="stylesheet" type="text/css" href="<?php echo template_url(); ?>scripts/fullcalendar/fullcalendar/fullcalendar.css" />

  <!-- Bootstrap Date Picker --> 
  <link href="<?php echo template_url(); ?>scripts/datepicker/css/datepicker.css" rel="stylesheet" />
  
  <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
  <link rel="stylesheet" href="<?php echo template_url(); ?>scripts/blueimp-jQuery-File-Upload/css/jquery.fileupload-ui.css" />
  
  <!-- Bootstrap Image Gallery styles -->
  
  <!-- Uniform -->
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo template_url(); ?>scripts/uniform/css/uniform.default.css" />
  
  <!-- Chosen multiselect -->
  <link type="text/css" href="<?php echo template_url(); ?>scripts/chosen/chosen/chosen.intenso.css" rel="stylesheet" />   

  <!-- Simplenso -->
  <link href="<?php echo template_url(); ?>css/simplenso.css" rel="stylesheet" />
  
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
	
  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="images/ico/favicon.ico" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png" />
  
  <link rel="stylesheet" type="text/css" href="<?php echo template_url(); ?>css/atooltip.css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body id="dashboard" class="hidden">
<!-- Top navigation bar -->
<div class="navbar logo"></div>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container-fluid">

      
      
      
      <div class="btn-group pull-right">
      <form method="post" action="<?php echo site_url('home/index');?>" style="margin:0;">
        <input type="text" name="keyword" placeholder="Search">
      </form>
      </div>
      
      
		<div class="nav-collapse">
        <ul class="nav">
          <li><a  href="<?php echo site_url();?>">
                      Beranda
                </a></li>
          <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Grafik Statistik Demografi Kecamatan <b class="caret"></b></a>
              <?php
			  $kecamatan = get_kecamatan();
			  ?>
              <ul class="dropdown-menu">
              <?php
			  foreach((array)$kecamatan as $kec)
			  {
			  ?>
                  <li><a href="<?php echo site_url('home/grafik/'.$kec['kecamatan_id']); ?>">Kecamatan <?php echo $kec['kecamatan_name'];?></a></li>
           	  <?php
			  }
			  ?>
              </ul>
          </li>
          <!--<li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                      Settings
                      <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Personal Info</a></li>
                    <li><a href="#">Preferences</a></li>
                    <li><a href="#">Alerts</a></li>
                    <li><a href="#" class="cookie-delete">Delete Cookies</a></li>
                </ul>
          </li> -->
          <li class="dropdown">
                <a  class="dropdown-toggle" href="<?php echo site_url('home/grafik');?>">
                      Grafik Statistik Demografi Kabupaten 
                </a>
               
          </li>
          
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Main Content Area | Side Nav | Content -->    
<div class="container-fluid">
  <div class="row-fluid">
    <!-- Side Navigation -->
    <?php
	if( !isset($nosidebar)  ):
	$sp = ( $this->uri->segment(2) == 'data_wilayah' ) ? 3 : 2;
	
	?>
    <div class="span<?php echo $sp; ?>">
          
      <div class="sidebar-nav">
      	<div class="well" style="padding: 8px 0;">
        <?php ( isset($sidebar) and $sidebar != '') ? include $sidebar : ""; ?>
        </div>

      </div><!--/.well -->
    </div><!--/span-->
    <?php
	endif;
	$sc = ( $this->uri->segment(2) == 'data_wilayah' ) ? 9 : 10;
	?>
    <!-- Bread Crumb Navigation -->
	<div class="<?php echo (isset($nosidebar) and $nosidebar == true ) ? '' :'span'.$sc; ?> ">

      <!-- Geographic Page Visit Map -->
      <?php if( !isset($nosidebar)  ): ?>
      <div class="row-fluid">
      <?php endif; ?>
      
      <?php
	  if( isset($page) and !empty($page) ){
		include "$page.php";  
	  }else{
		include "home.php";  
	  }
	  ?>
      <?php if( !isset($nosidebar)  ): ?>
      </div>
	  <?php endif; ?>
      
    </div><!--/span-->
  </div><!--/row-->
</div><!--/.fluid-container-->

<script type="text/javascript" src="<?php echo template_url(); ?>js/jquery.atooltip.js"></script>

   <script src="<?php echo template_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo template_url(); ?>scripts/bootbox/bootbox.min.js"></script>
 
	<!-- Bootstrap Date Picker -->
   

		
    <!-- jQuery Cookie -->    
    <script src="<?php echo template_url(); ?>scripts/jquery.cookie/jquery.cookie.js"></script>

    
    <script src="<?php echo template_url(); ?>scripts/simplenso/simplenso.js"></script>
    <script src="<?php echo template_url(); ?>js/goMap.js"></script>
  </body>
</html>