<div class="slate">
<script type="text/javascript">
$(document).ready(function(){
	$('#ispc').change(function(){
		if( $(this).val() == 1 ){
			$('.dropdown-cacat').show();	
		}else{
			$('.dropdown-cacat').hide();	
		}
	});	
	$('#aktlhr').change(function(){
		if( $(this).val() == 1 ){
			$('.aktlhr').show();	
		}else{
			$('.aktlhr').hide();	
		}
	});	
	
	$('#aktnkh').change(function(){
		if( $(this).val() == 1 ){
			$('.aktnkh').show();
			$('.tglnkh').show();	
		}else{
			$('.aktnkh').hide();
			$('.tglnkh').show();	
		}
	});
	
	$('#aktcri').change(function(){
		if( $(this).val() == 1 ){
			$('.aktcri').show();	
		}else{
			$('.aktcri').hide();	
		}
	});	
});
</script>
    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open( site_url('main/add'), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor urut</label>
        <div class="controls">
        <?php 
			$nourut = array('name' => 'nourut', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($nourut);
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Nama lengkap</label>
        <div class="controls">
        <?php 
			$nama = array('name' => 'nama', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($nama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Kecamatan</label>
        <div class="controls">
        <?php 
			echo $kecamatan[$current_kecamatan];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Agama</label>
        <div class="controls">
        <?php 
			echo form_dropdown('agama',$agama);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status perkawinan</label>
        <div class="controls">
        <?php 
			echo form_dropdown('perkawinan',$statusperkawinan);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Penyandang cacat</label>
        <div class="controls">
        <?php 
			$drp = array( 0 => 'Tidak', 1 => 'Ya');
			echo form_dropdown('ispenyandangcacat',$drp,0,' id="ispc"');
		?>
        </div>
      </div>
      
      <div class="control-group dropdown-cacat" style="display:none">
        <label for="focusedInput" class="control-label">Jenis cacat</label>
        <div class="controls">
        <?php 
			echo form_dropdown('penyandangcacat',$penyandangcacat);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Golongan darah</label>
        <div class="controls">
        <?php 
			echo form_dropdown('golongandarah',$golongandarah);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Pekerjaan</label>
        <div class="controls">
        <?php 
			echo form_dropdown('pekerjaan',$pekerjaan);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Pendidikan</label>
        <div class="controls">
        <?php 
			echo form_dropdown('pendidikan',$pendidikan);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor KTP</label>
        <div class="controls">
        <?php 
			$noktp = array('name' => 'noktp', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($noktp);
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor paspor</label>
        <div class="controls">
        <?php 
			$nopaspor = array('name' => 'nopaspor', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($nopaspor);
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal berakhir paspor</label>
        <div class="controls">
         <?php 
			$endpaspor = array('name' => 'endpaspor', 'class' => 'input-xlarge focused datepicker','id' => 'focusedInput', 'value'=>'' );
			echo form_input($endpaspor);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Jenis kelamin</label>
        <div class="controls">
        <?php
			$gender = array('1'=>'Laki-laki','2'=>'Perempuan');			
			echo form_dropdown('gender',$gender);
		?>
        </div>
      </div>
      
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tempat lahir</label>
        <div class="controls">
        <?php 
			$tmplahir = array('name' => 'tmplahir', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($tmplahir);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal lahir</label>
        <div class="controls">
       <?php 
			$tgllahir = array('name' => 'tgllahir', 'class' => 'input-xlarge focused datepicker','id' => 'focusedInput', 'value'=>'' );
			echo form_input($tgllahir);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Akta lahir</label>
        <div class="controls">
        <?php 
			$lahir = array('1'=>'Ya','0'=>'Tidak');			
			echo form_dropdown('aktalahir',$lahir,1,' id="aktlhr"');
		?>
        </div>
      </div>
      
      <div class="control-group aktlhr">
        <label for="focusedInput" class="control-label">Nomor akta lahir</label>
        <div class="controls">
        <?php 
			$noaktalahir = array('name' => 'noaktalahir', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($noaktalahir);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Akta nikah</label>
        <div class="controls">
        <?php 
			$nikah = array('1'=>'Ya','0'=>'Tidak');			
			echo form_dropdown('aktanikah',$nikah,0,'id="aktnkh"');
		?>
        </div>
      </div>
      
      <div class="control-group aktnkh" style="display:none">
        <label for="focusedInput" class="control-label">Nomor akta nikah</label>
        <div class="controls">
        <?php 
			$noaktanikah = array('name' => 'noaktanikah', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($noaktanikah);
		?>
        </div>
      </div>
      
      
      <div class="control-group tglnkh" style="display:none">
        <label for="focusedInput" class="control-label">Tanggal nikah</label>
        <div class="controls">
         <?php 
			$tglnikah = array('name' => 'tglnikah', 'class' => 'input-xlarge focused datepicker','id' => 'focusedInput', 'value'=>'' );
			echo form_input($tglnikah);
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Akta cerai</label>
        <div class="controls">
        <?php 
			$cerai = array('1'=>'Ya','0'=>'Tidak');			
			echo form_dropdown('aktacerai',$cerai,0,'id="aktcri"');
		?>
        </div>
      </div>
      
      <div class="control-group aktcri" style="display:none">
        <label for="focusedInput" class="control-label">Tanggal cerai</label>
        <div class="controls">
         <?php 
			$tglcerai = array('name' => 'tglcerai', 'class' => 'input-xlarge focused datepicker','id' => 'focusedInput', 'value'=>'' );
			echo form_input($tglcerai);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">NIK Ibu</label>
        <div class="controls">
        <?php 
			$nikibu = array('name' => 'nikibu', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($nikibu);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama Ibu</label>
        <div class="controls">
        <?php 
			$namaibu = array('name' => 'namaibu', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($namaibu);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">NIK Ayah</label>
        <div class="controls">
        <?php 
			$nikayah = array('name' => 'nikayah', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($nikayah);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama Ayah</label>
        <div class="controls">
        <?php 
			$namaayah = array('name' => 'namaayah', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($namaayah);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama ketua RT</label>
        <div class="controls">
        <?php 
			$namart = array('name' => 'namart', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($namart);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama ketua RW</label>
        <div class="controls">
        <?php 
			$namarw = array('name' => 'namarw', 'class' => 'input-xlarge focused','id' => 'focusedInput', 'value'=>'' );
			echo form_input($namarw);
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			$lat = array('name' => 'latitude', 'class' => 'input-xlarge focused','id' => 'focusedInput');
			echo form_checkbox('status', '1', TRUE);
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