<a href="<?php echo site_url('admin/group/add');?>" class="btn btn-primary">Tambah group</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Group</th>
        <th>Nama Group</th>
        <th>Mengelola kecamatan</th>
        <th class="actions">Actions</th>
    </tr>
</thead>
<tbody>
<?php

foreach((array)$result as $row)
{
	$single = array('primary'=>'kecamatan_id','field'=>'kecamatan_name','table'=>'kecamatan','id'=>$row['id_kecamatan']);
	$kecamatan = ($row['id_kecamatan'] == 'all')?'Semua kecamatan':single_data($single);
?>
	<tr>
        <td><?php echo $row['id_group'];?></td>
        <td><?php echo $row['nama_group'];?></td>
        <td><?php echo $kecamatan; ?></td>
        <td class="actions">
        <?php
		if( $row['id_group'] > 1 ):
		?>
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/group/delete/'.$row['id_group']);?>" onclick="<?php echo confirm('Menghapus group ini akan sekaligus menhapus data user dengan Group ini. Yakin?');?>">Hapus</a>
        <?php
		endif;
		?>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/group/edit/'.$row['id_group']);?>">Ubah</a>
            <a class="btn btn-small btn-success" href="<?php echo site_url('admin/group/access/'.$row['id_group']);?>">Hak akses</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>