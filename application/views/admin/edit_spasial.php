<div class="slate">
<script type="text/javascript">
$(document).ready(function(){
	$('.addform').click(function(){
		$('div.formcontrol').append('<div class="controls">Latitude : <input type="text" name="latitude[]" id="latitude" value="" />&nbsp;&nbsp;&nbsp;Longitude : <input type="text" name="longitude[]" id="longitude" value="" /> <div style="padding-top:2px"></div><br />Alamat :&nbsp;&nbsp;<textarea name="alamat[]" cols="60" rows="3" class="input-xxlarge"></textarea>&nbsp;&nbsp;&nbsp;<div style="padding-top:2px"></div></div>');
	});
});
</script>
    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>

    <?php echo form_open( site_url('admin/spasial/edit/'.$result['id_spasial']), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Kecamatan</label>
        <div class="controls">
        <?php 
			echo form_dropdown('id_kecamatan',$kecamatan,$result['id_kecamatan'] );
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Potensi</label>
        <div class="controls">
        <?php 
			$array = array_path_potensi( $potensi );
            echo createTreeOption( $array,$result['id_potensi'],'id_potensi' );
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Value</label>
        <div class="controls">
        <?php 
			$value = array('name' => 'nilai', 'class' => 'input-xlarge focused','id' => 'focusedInput','value'=>$result['spasial_value']);
			echo form_input($value);
		?> *dalam KG
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			$lat = array('name' => 'latitude', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_checkbox('status', '1', ($result['spasial_status'] == 1)?TRUE:FALSE );
		?> Aktif
        </div>
      </div>
      
      <div class="control-group formcontrol">
        <label for="focusedInput" class="control-label">Marker lokasi</label>
        <?php
		if( count($marker) > 0 ):
		foreach((array)$marker as $mar):
		?>
            <div class="controls">
            Latitude : <input type="text" name="latitude[]" id="latitude" value="<?php echo $mar['latitude'];?>" />&nbsp;&nbsp;&nbsp;
            Longitude : <input type="text" name="longitude[]" id="longitude" value="<?php echo $mar['longitude'];?>" />&nbsp;
            <div style="padding-top:2px"></div>
            <br />Alamat :&nbsp;&nbsp;<textarea name="alamat[]" cols="60" rows="3" class="input-xxlarge"><?php echo $mar['alamat'];?></textarea>
            &nbsp;&nbsp;&nbsp;
             <div style="padding-top:2px"></div>
            &nbsp;&nbsp;&nbsp;
            </div>
        <?php
		endforeach;
		else:
		?>
            <div class="controls">
            Latitude : <input type="text" name="latitude[]" id="latitude" value="" />&nbsp;&nbsp;&nbsp;
            Longitude : <input type="text" name="longitude[]" id="longitude" value="" />&nbsp;
            <div style="padding-top:2px"></div>
            <br />Alamat :&nbsp;&nbsp;<textarea name="alamat[]" cols="60" rows="3" class="input-xxlarge"></textarea>
            &nbsp;&nbsp;&nbsp;
             <div style="padding-top:2px"></div>
            &nbsp;&nbsp;&nbsp;
            </div>
        <?php
		endif;
		?>
      </div>
      
      <div class="control-group">
       <label for="focusedInput" class="control-label">&nbsp;</label>
       <div class="controls">
         <a href="javascript:void(0);" class="addform"> [+] Tambah</a>
         </div>
       </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">&nbsp;</label>
        <div class="controls">
        <?php 
			$submit = array('name' => 'save_data', 'class' => 'btn btn-info','value' => 'Simpan');
			echo form_submit($submit);
		?>
        </div>
      </div>
      
      	
      
    </fieldset>
     
     
     
    <?php echo form_close();?>

</div>