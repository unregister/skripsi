<ul class="nav nav-list"> 
  <li class="nav-header">Kecamatan</li>        
	<?php
	//pr($kecamatan);
	foreach((array)$kecamatans as $row)
	{
	?>
  		<li><a href="#" onClick="findAddress(<?php echo $row['kecamatan_id'];?>)"><i class="icon-picture"></i> <?php echo $row['kecamatan_name'];?></a></li>
    <?php
	}
	?>
  
</ul>