<h1>Peta kecamatan <?php echo $kecamatan_nama; ?></h1>
<div id="map_canvas" class="subset" style="padding-top:30px; height:500px; border:1px solid #666"></div>
<script type="text/javascript" src="<?php echo site_url('home/maparea/'.$kecamatan_id);?>"></script>
<script type="text/javascript" language="javascript">

var base_url = '<?php echo template_url(); ?>';

function initialize() {
	var latlng = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);
	var myOptions = {
		zoom: 13,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	LoadStates();
}


function content_onload()
{
	initialize();
}


if(window.content_onload != null)
{
	window.content_onload();
}
var markersArray = [];
var m = 0;
function showMarker(lat)
{
	
	var url = '<?php echo site_url('home/getmarker');?>';

	$.post(url,{id:lat},function(d){
		for( var i=0; i<d.length; i++ )
		{
			var myLatlng = new google.maps.LatLng(d[i].lat,d[i].long);	
			var marker = new google.maps.Marker({position: myLatlng,map: map,icon: base_url + 'icon/'+d[i].icon});
			
			var infoWindow = new google.maps.InfoWindow();
			var alamat = d[i].alamat;
			var lat = d[i].lat;
			var long = d[i].long;
			var id = d[i].id;
			var coor = getCoor(id);
			var val = d[i].value
			
			google.maps.event.addListener(marker, 'click', function (d) {
				
				//alert(coor);
				var markerContent = 'Alamat : '+alamat+'<br> Latitude : '+lat+'<br>Longitude : '+long+'<br>Value : '+val+'<br> <a href="<?php echo base_url()?>home/rute/'+id+'">Rute</a>';
				infoWindow.setContent(markerContent);
				infoWindow.open(map, this);
			});
			
		}
		
		markersArray.push(marker);
		
	},'json');
	

}

function getCoor(id)
{
	var x = [];
	var url = '<?php echo site_url('home/getcoor');?>';
	$.post(url,{id:id},function(r){
		x[0] = r.latitude;
		x[1] = r.longitude;
	},'json');	
	return x;
}

function clearMarker()
{
	//alert(markersArray.length);
	if (markersArray) {
		for (i in markersArray) {
		  markersArray[i].setMap(null);
		}
	  }
}


</script>

