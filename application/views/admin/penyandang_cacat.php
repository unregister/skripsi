<a href="<?php echo site_url('admin/penyandang_cacat/add');?>" class="btn btn-primary">Tambah penyandang cacat</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Penyandang cacat</th>
        <th>Nama penyandang cacat</th>
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
        <td><?php echo $row['id_penyandangcacat'];?></td>
        <td><?php echo $row['penyandangcacat_nama'];?></td>
        <td><?php echo ($row['penyandangcacat_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/penyandang_cacat/delete/'.$row['id_penyandangcacat']);?>" onclick="">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/penyandang_cacat/edit/'.$row['id_penyandangcacat']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>