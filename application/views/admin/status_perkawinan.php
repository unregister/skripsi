<a href="<?php echo site_url('admin/status_perkawinan/add');?>" class="btn btn-primary">Tambah status perkawinan</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID status perkawinan</th>
        <th>Nama status perkawinan</th>
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
        <td><?php echo $row['id_statusperkawinan'];?></td>
        <td><?php echo $row['statusperkawinan_nama'];?></td>
        <td><?php echo ($row['statusperkawinan_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/status_perkawinan/delete/'.$row['id_statusperkawinan']);?>" onclick="">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/status_perkawinan/edit/'.$row['id_statusperkawinan']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>