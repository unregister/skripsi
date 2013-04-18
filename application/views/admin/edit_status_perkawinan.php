<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>

    <?php echo form_open( site_url('admin/status_perkawinan/edit/'.$result['id_statusperkawinan']), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama status perkawinan</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput','value' => $result['statusperkawinan_nama']);
			echo form_input($nama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			$lat = array('name' => 'latitude', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_checkbox('status', '1', ($result['statusperkawinan_status'] == 1)?TRUE:FALSE );
		?> Aktif
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