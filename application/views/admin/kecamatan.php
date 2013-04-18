
			
<a href="<?php echo site_url('admin/kecamatan/add');?>" class="btn btn-primary">Tambah kecamatan</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>Nama Kecamatan</th>
       <!-- <th>Latitude</th>
        <th>Longitude</th> -->
        <th class="actions">Actions</th>
    </tr>
</thead>
<tbody>
<?php
foreach((array)$kecamatan as $kec)
{
?>
	<tr>
        <td><?php echo $kec['kecamatan_name'];?></td>
       <!-- <td><?php echo $kec['kecamatan_longitude'];?></td>
        <td><?php echo $kec['kecamatan_latitude'];?></td> -->
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/kecamatan/delete/'.$kec['kecamatan_id']);?>" href="#removeItem" onclick="<?php echo confirm('Yakin mau hapus data ini?');?>">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/kecamatan/edit/'.$kec['kecamatan_id']);?>">Ubah</a>
        </td>
    </tr>
<?php
}
?>
</tbody>
</table>