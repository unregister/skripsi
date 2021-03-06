<?php
$url = ($this->uri->segment(4))?'/'.$this->uri->segment(4) : ''; 
?>
<a href="<?php echo site_url('admin/potensi/add'.$url);?>" class="btn btn-primary">Tambah <?php echo ($this->uri->segment(4)) ? 'sub' : ''; ?> potensi</a>
<br />
<br />
<?php show_message();?>
<table class="orders-table table">
<thead>
    <tr>
        <th>ID Potensi</th>
        <?php if( $this->uri->segment(3) == 'sub'):?>
        <th>Parent</th>
        <?php endif ?>
        <th>Nama Potensi</th>
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
        <td><?php echo $row['id_potensi'];?></td>
        <?php if( $this->uri->segment(3) == 'sub'):?>
        <td><?php echo $this->potensi_model->parent_nama($row['potensi_parent']);?></td>
        <?php endif ?>
        <td><?php echo $row['potensi_nama'];?></td>
        <td><?php echo ($row['potensi_status'] == 1 )?'Aktif':'Tidak aktif';?></td>
        <td class="actions">
            <a class="btn btn-small btn-danger" href="<?php echo site_url('admin/potensi/delete/'.$row['id_potensi']);?>" onclick="">Hapus</a>
            <a class="btn btn-small btn-primary" href="<?php echo site_url('admin/potensi/edit/'.$row['id_potensi']);?>">Ubah</a>
            <?php if( $this->uri->segment(3) != 'sub'):?>
            <a class="btn btn-small btn-success" href="<?php echo site_url('admin/potensi/sub/'.$row['id_potensi']);?>">Sub Potensi</a>
            <?php endif ?>
        </td>
    </tr>
<?php
}
?>
</tbody> 
</table>



