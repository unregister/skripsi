<a href="<?php echo site_url('admin/agama/add');?>" class="btn btn-primary">Tambah agama</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Agama</th>
        <th>Nama Agama</th>
        <th>Status</th>
        <th class="actions">Actions</th>
    </tr>
</thead>
<tbody>
<?php
foreach((array)$agama as $agm)
{
?>
	<tr>
        <td><?php echo $agm['id_agama'];?></td>
        <td><?php echo $agm['agama_nama'];?></td>
        <td><?php echo ($agm['agama_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/agama/delete/'.$agm['id_agama']);?>" href="#removeItem" onclick="">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/agama/edit/'.$agm['id_agama']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>