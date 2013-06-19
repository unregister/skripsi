<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open( site_url('admin/user/edit/'.$id), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Username</label>
        <div class="controls">
        <?php 
			$username = array('name' => 'username', 'class' => 'input-xlarge focused','id' => 'focusedInput','value'=>$result['username']);
			echo form_input($username);
		?>
        </div>
      </div>
	  
	  <div class="control-group">
        <label for="focusedInput" class="control-label">Password</label>
        <div class="controls">
        <?php 
			$password = array('name' => 'password', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_password($password);
		?>
        </div>
      </div>
	  
	  <div class="control-group">
        <label for="focusedInput" class="control-label">Nama petugas</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput','value'=>$result['admin_nama']);
			echo form_input($nama);
		?>
        </div>
      </div>
	  
	  <div class="control-group">
        <label for="focusedInput" class="control-label">Group</label>
        <div class="controls">
        <select name="group_id">
		<?php
		foreach((array)$group as $g)
		{
			$sel = ($g['id_group'] == $result['id_group'] )?' selected="selected"':"";
		?>
			<option value="<?php echo $g['id_group'];?>"<?php echo $sel; ?>><?php echo $g['nama_group'];?></option>
		<?php
		}
		?>
		</select>
        </div>
      </div>
	  
	  
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php ;
			$true = ($result['admin_status']==1)?TRUE:FALSE;
			echo form_checkbox('status', '1', $true);
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