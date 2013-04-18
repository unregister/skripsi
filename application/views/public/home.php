<div id="map_canvas" class="subset" style="padding-top:30px; height:500px; border:1px solid #666"></div>
<script type="text/javascript" src="<?php echo site_url('home/jsmap');?>"></script>
<script type="text/javascript" language="javascript">
var base_url = '<?php echo template_url(); ?>';
	function content_onload()
	{
		initialize(document.getElementById('StateName'));
	}
	

		if(window.content_onload != null) //does onload exist
			window.content_onload();
	
	
	
	
	function tip(te)
		{
			 
			 $.aToolTip({tipContent: te}); 	
		}
	
	var map;
	var infowindow = new google.maps.InfoWindow();
		

		function findAddress (kecamatan_id) 
		{
			var actionurl = '<?php echo site_url('home/get_data/');?>';
			$.post(actionurl,{"action":"get_data","kecamatan_id":kecamatan_id},function(respon)
			{
				if(respon)
				{
					if(respon.latitude == null || respon.longitude == null)
					{
						alert('Data tidak ditemukan');
						return false;
					}
					else
					{
						var myLatlng = new google.maps.LatLng(respon.latitude, respon.longitude);
						var marker = new google.maps.Marker({position: myLatlng,map: map,icon: base_url + 'icon/home.png'});
						map.setCenter(myLatlng);
						map.setZoom(13); 
						contentString=respon.content;
						center=map.getCenter();
						infowindow.setPosition(center);
						infowindow.setContent(contentString); 
						infowindow.open(map);
					
					}
				}
			},'json');
			
			
		}

     // google.maps.event.addDomListener(window, 'load', initialize);
	
</script>
