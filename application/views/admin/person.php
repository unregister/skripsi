<a href="<?php echo site_url('admin/person/add');?>" class="btn btn-primary">Tambah person</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Prson</th>
        <th>Nama Person</th>
        <th>Jenis kelamin</th>
        <th>Kecamatan</th>
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
        <td><?php echo $row['id_person'];?></td>
        <td><?php echo $row['person_namalengkap'];?></td>
        <td><?php echo ($row['person_jeniskelamin'] == 1)?'Laki-laki':'Perempuan';?></td>
        <td><?php echo single_data(array('id'=>$row['id_kecamatan'],'primary'=>'kecamatan_id','field'=>'kecamatan_name','table'=>'kecamatan'));?></td>
        <td><?php echo ($row['person_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/person/delete/'.$row['id_person']);?>" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/person/edit/'.$row['id_person']);?>">Ubah</a>
            <a class="btn btn-small btn-success" href="<?php echo site_url('admin/person/detail/'.$row['id_person']);?>">Detail</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>