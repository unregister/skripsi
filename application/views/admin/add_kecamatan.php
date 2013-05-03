<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
   
    
    <?php echo form_open( site_url('admin/kecamatan/add'), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama kecamatan</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($nama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Latitude</label>
        <div class="controls">
        <?php 
			$lat = array('name' => 'latitude', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($lat);
		?>
        </div>
      </div>
      
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Longitude</label>
        <div class="controls">
        <?php 
			$long = array('name' => 'longitude', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($long);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Luas kecamatan</label>
        <div class="controls">
        <?php 
			$luas = array('name' => 'luas', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($luas);
		?>
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