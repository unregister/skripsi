<div class="row-fluid">
<?php echo fluid_open('Cari rute',9);?>
     <div id="map" style="width: 100%; height: 500px;"></div> 
<?php echo fluid_close();?>

<?php echo fluid_open('Cari rute',3);?>
    <form class="form-horizontal">
    <table width="100%" border="0">
      <tr>
        <td width="20%">Dari</td>
        <td width="80%"><input type="text" value="Klaten tengah" id="focusedInput" class="input-medium focused dari"></td>
      </tr>
      <tr>
        <td>Tujuan</td>
        <td><input type="text" value="<?php echo $tujuan;?>" id="focusedInput" class="input-medium focused ke"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
        	<button class="btn btn-primary" id="go" type="submit">Cari</button>&nbsp;&nbsp;
            <button class="btn btn-primary" id="reset" type="submit">Reset</button>
        </td>
      </tr>
    </table>       
    </form>
<?php echo fluid_close();?>
<?php echo fluid_open('Jalur',3);?>
<div id="panel" style="width: 100%; height: auto;"></div> 
<?php echo fluid_close();?>

  <script>
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
	
	function initialize() {
	  directionsDisplay = new google.maps.DirectionsRenderer();
	  var chicago = new google.maps.LatLng(-7.702021, 110.602788);
	  var mapOptions = {
		zoom:12,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		center: chicago
	  }
	  map = new google.maps.Map(document.getElementById('map'), mapOptions);
	  directionsDisplay.setMap(map);
	}
	//directionsDisplay.setMap(map);

	
	google.maps.event.addDomListener(window, 'load', initialize);
	
	
	$(document).ready(function(){
		$('#go').click(function(){
			
			var start = $('.dari').val();
			var end = $('.ke').val();
			var request = {
			  origin:start,
			  destination:end,
			  travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
			  directionsDisplay.setDirections(response);
			  directionsDisplay.setPanel(document.getElementById('panel'));
			}
			});
			return false;
		});	
		
		$('#reset').click(function(){
			$('.dari').val('');
			$('.ke').val('');
			directionsDisplay.setMap(map);
			return false;
		});
		
	});
	
    </script>

</div>