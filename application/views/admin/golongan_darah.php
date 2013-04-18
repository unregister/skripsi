<a href="<?php echo site_url('admin/golongan_darah/add');?>" class="btn btn-primary">Tambah golongan darah</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Golongan darah</th>
        <th>Nama Golongan darah</th>
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
        <td><?php echo $row['id_golongandarah'];?></td>
        <td><?php echo $row['golongandarah_nama'];?></td>
        <td><?php echo ($row['golongandarah_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/golongan_darah/delete/'.$row['id_golongandarah']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/golongan_darah/edit/'.$row['id_golongandarah']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>