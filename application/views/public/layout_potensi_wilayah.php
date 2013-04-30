<ul class="nav nav-list"> 
  <li class="nav-header">Potensi Ekonomi Kecamatan <?php echo $kecamatan_nama; ?></li>        
	<?php foreach((array)$potensi as $pot): 
	if( $pot['id_potensi'] > 0 )
	{
	?>
    	<li><a href="#"><strong><?php echo $pot['potensi_nama'];?></strong></a></li>
        <?php 
			$sub = get_sub_potensi($pot['id_potensi'],$kecamatan_id);
			foreach((array)$sub as $child):
		?>
        	<li><a href="javascript:void(0);" onclick="showMarker(<?php echo $child['id_spasial'];?>)">&nbsp;&nbsp;&nbsp;<?php echo $child['potensi_nama'];?></a></li>
        <?php
			endforeach;
		?>
    <?php 
	}
	endforeach; ?>
</ul>