<a href="<?php echo site_url('admin/pendidikan/add');?>" class="btn btn-primary">Tambah pendidikan</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Pendidikan</th>
        <th>Nama Pendidikan</th>
        <th>Status</th>
        <th class="actions">Actions</th>
    </tr>
</thead>
<tbody>
<?php

foreach((array)$result as $row)
{
?>
	<tr>
        <td><?php echo $row['id_pendidikan'];?></td>
        <td><?php echo $row['pendidikan_nama'];?></td>
        <td><?php echo ($row['pendidikan_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/pendidikan/delete/'.$row['id_pendidikan']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/pendidikan/edit/'.$row['id_pendidikan']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>