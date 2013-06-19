<div class="slate">
<script type="text/javascript">
$(document).ready(function(){
	$('#parentid').change(function(){
		if( $(this).val() == 0 ){
			$('#tohide').slideUp(400);	
		}else{
			$('#tohide').slideDown(400);	
		}
	});
});
</script>
    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open_multipart( site_url('admin/potensi/add'), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama potensi</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_input($nama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Parent</label>
        <div class="controls">
        <?php 
			$par = ($this->uri->segment(4))?$this->uri->segment(4) : '';
			echo form_dropdown('parent',$parent,$par,' id="parentid"');
		?>
        </div>
      </div>
      <?php if( $this->uri->segment(4) ): ?>
      <div id="tohide">
      <div class="control-group tohidden">
        <label for="focusedInput" class="control-label">Icon</label>
        <div class="controls">
        <?php 
			$icon = array('name' => 'icon', 'class' => 'input-file uniform_on','id' => 'focusedInput');
			echo form_upload($icon);
		?>
        </div>
      </div>
      </div>
      <?php endif; ?>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			echo form_checkbox('status', '1', TRUE);
		?> Aktif
        </div>
      </div>
      
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">&nbsp;</label>
        <div class="controls">
        <?php 
			$submit = array('name' => 'save_data', 'class' => 'btn btn-info1','value' => 'Simpan');
			echo form_submit($submit);
		?>
        </div>
      </div>
      
      	
      
    </fieldset>
     
     
     
    <?php echo form_close();?>

</div>