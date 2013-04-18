<a href="<?php echo site_url('admin/user/add');?>" class="btn btn-primary">Tambah user</a> <a href="<?php echo site_url('admin/group');?>" class="btn btn-primary">Data Group</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Admin</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Grup</th>
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
        <td><?php echo $row['id_admin'];?></td>
        <td><?php echo $row['username'];?></td>
        <td><?php echo $row['admin_nama'];?></td>
        <td><?php echo $row['nama_group'];?></td>
        <td><?php echo ($row['admin_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/user/delete/'.$row['id_admin']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/user/edit/'.$row['id_admin']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>