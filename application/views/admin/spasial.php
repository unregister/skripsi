<a href="<?php echo site_url('admin/spasial/add');?>" class="btn btn-primary">Tambah spasial</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Spasial</th>
        <th>Kecamatan</th>
        <th>Potensi</th>
        <th>Status</th>
        <th class="actions">Actions</th>
    </tr>
</thead>
<tbody>
<?php

foreach((array)$result as $row)
{
	$kec = array('primary'=>'kecamatan_id','field'=>'kecamatan_name','table'=>'kecamatan','id'=>$row['id_kecamatan']);
	$pot = array('primary'=>'id_potensi','field'=>'potensi_nama','table'=>'potensi','id'=>$row['id_potensi']);
	$kecamatan = ($row['id_kecamatan'] == 'all')?'Semua kecamatan':single_data($kec);
	$potensi = single_data($pot);
?>
	<tr>
        <td><?php echo $row['id_spasial'];?></td>
        <td><?php echo $kecamatan;?></td>
        <td><?php echo $potensi;?></td>
        <td><?php echo ($row['spasial_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/spasial/delete/'.$row['id_spasial']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/spasial/edit/'.$row['id_spasial']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>