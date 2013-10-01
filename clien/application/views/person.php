<a href="<?php echo site_url('main/add');?>" class="btn btn-primary">Tambah penduduk</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Penduduk</th>
        <th>Nama Penduduk</th>
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
        <td><?php echo $kecamatan[$row['id_kecamatan']];?></td>
        <td><?php echo ($row['person_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('main/delete/'.$row['id_person']);?>" onclick="if(confirm('Anda yakin ingin menghapus data ini?')){return true;}else{return false;}">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('main/edit/'.$row['id_person']);?>">Ubah</a>
            <a class="btn btn-small btn-success" href="<?php echo site_url('main/detail/'.$row['id_person']);?>">Detail</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>