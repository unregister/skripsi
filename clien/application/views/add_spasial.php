<div class="slate">
<script type="text/javascript">
$(document).ready(function(){
	$('.addform').click(function(){
		$('div.formcontrol').append('<div class="controls">Latitude : <input type="text" name="latitude[]" id="latitude" value="" />&nbsp;&nbsp;&nbsp;Longitude : <input type="text" name="longitude[]" id="longitude" value="" /> <div style="padding-top:2px"></div><br />Alamat :&nbsp;&nbsp;<textarea name="alamat[]" cols="60" rows="3" class="input-xxlarge"></textarea>&nbsp;&nbsp;&nbsp;<div style="padding-top:2px"></div></div>');
	});
	
	$('select[name="id_potensi"]').change(function(){
		var u = '<?php echo site_url('admin/spasial/satuan');?>';
		var n = $(this).val();
		$.post(u,{id:n},function(d){
			$('.vl').html(d);
		});
	});
		
});
</script>
    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open( site_url('admin/spasial/add'), array('class' => 'form-horizontal') );?>
    <fieldset>
       <div class="control-group">
        <label for="focusedInput" class="control-label">Kecamatan</label>
        <div class="controls">
        <?php 
			echo form_dropdown('id_kecamatan',$kecamatan );
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Potensi</label>
        <div class="controls">
        <?php 
			$array = array_path_potensi( $potensi );
            echo createTreeOption( $array,'','id_potensi' );
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Value</label>
        <div class="controls">
        <?php 
			$value = array('name' => 'nilai', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($value);
		?><span class="vl"> ekor</span>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			echo form_checkbox('status', '1', TRUE);
		?> Aktif
        </div>
      </div>
      
      <div class="control-group formcontrol">
        <label for="focusedInput" class="control-label">Marker lokasi</label>
        <div class="controls">
        Latitude : <input type="text" name="latitude[]" id="latitude" value="" />&nbsp;&nbsp;&nbsp;
        Longitude : <input type="text" name="longitude[]" id="longitude" value="" />&nbsp;
        <div style="padding-top:2px"></div>
        <br />Alamat :&nbsp;&nbsp;<textarea name="alamat[]" cols="60" rows="3" class="input-xxlarge"></textarea>
        &nbsp;&nbsp;&nbsp;
         <div style="padding-top:2px"></div>
        </div>
        
        
         
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