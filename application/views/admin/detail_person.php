<div class="slate">

    <div class="page-header">
        <h2><?php echo $title; ?></h2>
    </div>
	
   <?php show_message();?>
    
    <?php echo form_open( site_url('admin/person/edit/'), array('class' => 'form-horizontal') );?>
    <fieldset>
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor urut</label>
        <div class="controls">
        <?php echo $result['person_nomorurut']; ?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Nama lengkap</label>
        <div class="controls">
        <?php echo $result['person_namalengkap'];	?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Kecamatan</label>
        <div class="controls">
        <?php 
			echo $kecamatan[$result['id_kecamatan']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Agama</label>
        <div class="controls">
        <?php 
			echo $agama[$result['id_agama']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status perkawinan</label>
        <div class="controls">
        <?php 
			echo $statusperkawinan[$result['id_statusperkawinan']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Penyandang cacat</label>
        <div class="controls">
        <?php 
			if( $result['id_penyandangcacat'] > 0 ){
			echo $penyandangcacat[$result['id_penyandangcacat']];
			}else{
			echo 'Bukan penyandang cacat';
			}
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Golongan darah</label>
        <div class="controls">
        <?php 
			echo $golongandarah[$result['id_golongandarah']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Pekerjaan</label>
        <div class="controls">
        <?php 
			echo $pekerjaan[$result['id_pekerjaan']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Pendidikan</label>
        <div class="controls">
        <?php 
			echo $pendidikan[$result['id_pendidikan']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor KTP</label>
        <div class="controls">
        <?php 
			echo $result['person_ktp']
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor paspor</label>
        <div class="controls">
        <?php 
			echo $result['person_nomorpasspor'];
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal berakhir paspor</label>
        <div class="controls">
         <?php 
			echo $result['person_tanggalberakhirpasspor'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Jenis kelamin</label>
        <div class="controls">
        <?php
			$gender = array('1'=>'Laki-laki','2'=>'Perempuan');			
			echo $gender[$result['person_jeniskelamin']];
		?>
        </div>
      </div>
      
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tempat lahir</label>
        <div class="controls">
        <?php 
			echo $result['person_tempatlahir'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal lahir</label>
        <div class="controls">
       <?php 
			echo $result['person_tanggallahir'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Akta lahir</label>
        <div class="controls">
        <?php 
			$lahir = array('1'=>'Ya','0'=>'Tidak');			
			echo $lahir[$result['person_aktalahir']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor akta lahir</label>
        <div class="controls">
        <?php 
			echo $result['person_nomoraktalahir'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Akta nikah</label>
        <div class="controls">
        <?php 
			$nikah = array('1'=>'Ya','0'=>'Tidak');			
			echo $nikah[$result['person_aktanikah']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nomor akta nikah</label>
        <div class="controls">
        <?php 
			echo $result['person_nomoraktanikah'];
		?>
        </div>
      </div>
      
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal nikah</label>
        <div class="controls">
         <?php 
			echo $result['person_tanggalkawin'];
		?>
        </div>
      </div>
      
       <div class="control-group">
        <label for="focusedInput" class="control-label">Akta cerai</label>
        <div class="controls">
         <?php 
			$cerai = array('1'=>'Ya','0'=>'Tidak');			
			echo $cerai[$result['person_aktacerai']];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Tanggal cerai</label>
        <div class="controls">
         <?php 
			echo $result['person_tanggalcerai'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">NIK Ibu</label>
        <div class="controls">
        <?php 
			echo $result['person_nikibu'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama Ibu</label>
        <div class="controls">
        <?php 
			echo $result['person_namalengkapibu'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">NIK Ayah</label>
        <div class="controls">
        <?php 
			echo $result['person_nikayah'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama Ayah</label>
        <div class="controls">
        <?php 
			echo $result['person_namalengkapayah'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama ketua RT</label>
        <div class="controls">
        <?php 
			echo $result['person_namaketua_rt'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Nama ketua RW</label>
        <div class="controls">
        <?php 
			echo $result['person_namakertua_rw'];
		?>
        </div>
      </div>
      
      <div class="control-group">
        <label for="focusedInput" class="control-label">Status</label>
        <div class="controls">
        <?php 
			$status = array('1' => 'Aktif','0'=>'Tidak aktif');
			echo $status[$result['person_status']];
		?> 
        </div>
      </div>
      
      
      
      
      	
      
    </fieldset>
     
     
     
    <?php echo form_close();?>

</div>