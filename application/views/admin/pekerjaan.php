<a href="<?php echo site_url('admin/pekerjaan/add');?>" class="btn btn-primary">Tambah pekerjaan</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Pekerjaan</th>
        <th>Nama Pekerjaan</th>
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
        <td><?php echo $row['id_pekerjaan'];?></td>
        <td><?php echo $row['pekerjaan_nama'];?></td>
        <td><?php echo ($row['pekerjaan_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/pekerjaan/delete/'.$row['id_pekerjaan']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/pekerjaan/edit/'.$row['id_pekerjaan']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>