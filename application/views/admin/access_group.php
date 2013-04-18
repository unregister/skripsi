<br />
<br />
<script type="text/javascript">
$(function () {
  $('input[name="all"]').click(function () {
          $('.case').attr('checked', this.checked);
    });
});
</script>
<?php show_message(); ?>
<h2>Ubah hak akses group "<?php echo $nama_group;?>"</h2><br />
<form method="post" action="">
 <?php 
	$submit = array('name' => 'save_data', 'class' => 'btn btn-info','value' => 'Simpan');
	echo form_submit($submit);
?>
<table class="orders-table table">
<thead>
    <tr>
        <th><input type="checkbox" id="selectall" name="all" /></th>
        <th>Menu</th>
    </tr>
</thead>
<tbody>
<?php
foreach((array)$menu['parent'] as $mn)
{
	$ca = (isset($rowmenu[$mn['id_menu']]) and $rowmenu[$mn['id_menu']] == $mn['id_menu'])?' checked="checked"':'';
?>
	<tr>
        <td style="width:30px"><input type="checkbox" class="case" name="access[]" value="<?php echo $mn['id_menu'];?>" id="akses<?php echo $mn['id_menu'];?>"<?php echo $ca;?> /></td>
        <td><label for="akses<?php echo $mn['id_menu'];?>"><strong><?php echo $mn['menu_title'];?></strong></label></td>
    </tr>
    <?php
	if( isset($mn['child']) and count($mn['child']) > 0 )
	{
		foreach((array)$mn['child'] as $sub)
		{
			$co = (isset($rowmenu[$sub['id_menu']]) and $rowmenu[$sub['id_menu']] == $sub['id_menu'])?' checked="checked"':'';
	?>
    		<tr>
                <td><input type="checkbox" name="access[]" class="case" value="<?php echo $sub['id_menu'];?>" id="akses<?php echo $sub['id_menu'];?>"<?php echo $ca;?> /></td>
                <td style="padding-left:30px"><label for="akses<?php echo $sub['id_menu'];?>"><?php echo $sub['menu_title'];?></label></td>
            </tr>
    <?php
		}
	}
	?>
    
<?php
}
?>
</tbody>
</table>
</form>