<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open( site_url('admin/user/password'), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Password lama</label>
        <div class="controls">
        <?php 
			$pass1 = array('name' => 'old_password', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_password($pass1);
		?>
        </div>
      </div>
	  
	  <div class="control-group">
        <label for="focusedInput" class="control-label">Password baru</label>
        <div class="controls">
        <?php 
			$pass2 = array('name' => 'new_password', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_password($pass2);
		?>
        </div>
      </div>
	  
	  <div class="control-group">
        <label for="focusedInput" class="control-label">Password  baru (ulangi)</label>
        <div class="controls">
        <?php 
			$pass3 = array('name' => 'ret_password', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_password($pass3);
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