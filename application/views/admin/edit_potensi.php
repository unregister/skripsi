<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open_multipart( site_url('admin/potensi/edit/'.$id), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama potensi</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput','value'=>$result['potensi_nama']);
			echo form_input($nama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Parent</label>
        <div class="controls">
        <?php 
			echo form_dropdown('parent',$parent,$result['potensi_parent']);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			$op = ($result['potensi_status'] == 1)?true:false;
			echo form_checkbox('status', '1', $op);
		?> Aktif
        </div>
      </div>
      <?php
	  if( isset($use_icon) and $use_icon == true ):
	  ?>
     <div class="control-group">
        <label for="focusedInput" class="control-label">Icon</label>
        <div class="controls">
        <?php
		if( $result['potensi_icon'] != '' ):
		?>
        	<img src="<?php echo template_url();?>icon/<?php echo $result['potensi_icon'];?>" /><br />
            <input type="hidden" name="img_icon" value="<?php echo $result['potensi_icon'];?>" />
        <?php
		endif;
		?>
        <?php 
			$icon = array('name' => 'icon', 'class' => 'input-file uniform_on','id' => 'focusedInput');
			echo form_upload($icon);
		?>
        </div>
      </div>
      <?php
	  endif;
	  ?>
       <div class="control-group">
        <label for="focusedInput" class="control-label">&nbsp;</label>
        <div class="controls">
        <?php 
			$submit = array('name' => 'save_data', 'class' => 'btn btn-info1','value' => 'Simpan');
			echo form_submit($submit);
		?>
        </div>
      </div>'
      
      	
      
    </fieldset>
     
     
     
    <?php echo form_close();?>

</div>
						