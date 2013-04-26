<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div class="row-fluid">
	<?php echo fluid_open('Grafik agama');?>
    <script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  ['Agama', 'Jumlah penganut'],
			  <?php echo $grafik_agama;?>
			]);
	
			var options = {
			  title: 'Grafik Agama',
			  hAxis: {title: 'Agama', titleTextStyle: {color: 'red'}}
			};
	
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_agama'));
			chart.draw(data, options);
		  }
	</script>
	<div id="chart_agama" style="width: 100%; height: 300px;"></div>
    <?php echo fluid_close();?>

	<?php echo fluid_open('Grafik Penyandang Cacat');?>
	<script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Jenis cacat', 'Jumlah'],
              <?php echo $grafik_penyandangcacat;?>
            ]);
    
            var options = {
              title: 'Grafik Penyandang cacat',
              hAxis: {title: 'Jenis cacat', titleTextStyle: {color: 'red'}}
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_penyandangcacat'));
            chart.draw(data, options);
          }
    </script>
    <div id="chart_penyandangcacat" style="width: 100%; height: 300px;"></div>
   <?php echo fluid_close();?>
</div>

<div class="row-fluid">
	<?php echo fluid_open('Grafik golongan darah');?>
    <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Golongan darah', 'Jumlah'],
              <?php echo $grafik_golongandarah;?>
            ]);
    
            var options = {
              title: 'Grafik golongan darah',
              hAxis: {title: 'Golongan darah', titleTextStyle: {color: 'red'}}
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_golongandarah'));
            chart.draw(data, options);
          }
    </script>
    <div id="chart_golongandarah" style="width: 100%; height: 300px;"></div>
    <?php echo fluid_close();?>
    
    <?php echo fluid_open('Grafik Pendidikan');?>
    <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Pendidikan', 'Jumlah'],
              <?php echo $grafik_pendidikan;?>
            ]);
    
            var options = {
              title: 'Grafik pendidikan',
              hAxis: {title: 'Pendidikan', titleTextStyle: {color: 'red'}}
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_pendidikan'));
            chart.draw(data, options);
          }
    </script>
    <div id="chart_pendidikan" style="width: 100%; height: 300px;"></div>
	<?php echo fluid_close();?>
</div>

<div class="row-fluid">
	 <?php echo fluid_open('Status Perkawinan');?>
      <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Status perkawinan', 'Jumlah'],
              <?php echo $grafik_statusperkawinan;?>
            ]);
    
            var options = {
              title: 'Grafik Status perkawinan',
              hAxis: {title: 'Status perkawinan', titleTextStyle: {color: 'red'}}
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_statusperkawinan'));
            chart.draw(data, options);
          }
    </script>
     <div id="chart_statusperkawinan" style="width: 100%; height: 300px;"></div>
     <?php echo fluid_close();?>
     
     <?php echo fluid_open('Grafik Potensi');?>
    <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Potensi', 'Jumlah'],
              <?php echo $grafik_potensi;?>
            ]);
    
            var options = {
              title: 'Grafik Potensi',
			  width:550,
			  height:400,
              hAxis: {title: 'Potensi', titleTextStyle: {color: 'red'}}
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_potensi'));
            chart.draw(data, options);
          }
    </script>
    <div id="chart_potensi" style="width: 100%; height: 400px;"></div>
    <?php echo fluid_close();?>
</div>
