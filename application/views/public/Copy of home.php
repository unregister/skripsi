<html>
<head>
<title>Welcome to CodeIgniter</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

#map_canvas 
{
	border:2px solid #CCCCCC;	
	padding: 10px;
}

</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>application/views/public/css/atooltip.css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/public/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/public/js/jquery.atooltip.js"></script>
<script type="text/javascript" src="<?php echo site_url('home/jsmap');?>"></script>
<script type="text/javascript" language="javascript">
	function content_onload()
	{
		initialize(document.getElementById('StateName'));
	}
</script>
<style type="text/css">
	.dropbox
	{
		height:0px;
		background-color:#708dcf;
		color:White;
		font-family:Arial, Sans-Serif;
		margin-left:16px;
		padding-left:8px;
	}
</style>

	
	
	
	
	<script type="text/javascript" language="javascript">
		function masterpage_onload()
		{
			if(window.content_onload != null) //does onload exist
				window.content_onload();
		}
		
		$(document).ready(function(){
			
		});
		
		function tip(te)
			{
				 
				 $.aToolTip({tipContent: te}); 	
			}
		
	</script>

</head>
<body id="ctl00_MyBody" onload="masterpage_onload()">
    <div id="map_canvas" class="subset" style="width:800px;height:600px"></div>
    <div style="height:35px;width:816px;">
            <div id="StateName" class="dropbox"></div>
        </div>
        
    </body>
</html>