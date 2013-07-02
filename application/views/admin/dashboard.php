<?php
$kecamatan = get_kecamatan(1,true);
$jml_kecamatan = count($kecamatan);

$agama = get_agama(1,true);
$jml_agama = count($agama);

$goldarah = get_golongandarah(1,true);
$jml_goldarah = count($goldarah);

$pendidikan = get_pendidikan(1,true);
$jml_pend = count($pendidikan);

$pekerjaan = get_pekerjaan(1,true);
$jml_kerja = count($pekerjaan);

$cacat = get_penyandangcacat(1,true);
$jml_cacat = count($cacat);

$kawin = get_statusperkawinan(1,true);
$jml_kawin = count($kawin);

$potensi = get_potensi_select(1,true);
$jml_potensi = count($potensi);

$arrusia = array(	1 => '0 - 10 tahun',
					2 => '11 - 20 tahun',
					3 => '21 - 30 tahun',
					4 => '31 - 40 tahun',
					5 => '41 - 50 tahun',
					6 => '51 - 60 tahun',
					7 => '61 - 70 tahun',
					8 => '71 - 80 tahun',
					9 => '81 - 90 tahun',
					10 => '91 - 100 tahun',
					11 => ' > 100 tahun'
					);
?>

<script>
  $(function () {
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})
  })
</script>

<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#agama">Grafik Agama</a></li>
    <li><a href="#goldarah">Grafik Gol Darah</a></li>
    <li><a href="#pendidikan">Grafik Pendidikan</a></li>
    <li><a href="#pekerjaan">Grafik Pekerjaan</a></li>
    <li><a href="#cacat">Grafik Peny. Cacat</a></li>
    <li><a href="#kawin">Grafik Perkawinan</a></li>
    <li><a href="#potensi">Grafik Potensi</a></li>
    <li><a href="#usia">Grafik Usia</a></li>
</ul>


<div class="tab-content">
	<div class="tab-pane active" id="agama">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_agama+1);?>">Grafik Agama</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$agama as $gAgm): ?>
                <th><?php echo $gAgm;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$agama as $agmId=>$agmNama): ?>
                <td><?php echo grafik_data('agama',$kecId,$agmId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="goldarah">
    	 <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_goldarah+1);?>">Grafik Golongan Darah</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$goldarah as $drh): ?>
                <th><?php echo $drh;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$goldarah as $golId=>$golNama): ?>
                <td><?php echo grafik_data('goldarah',$kecId,$golId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="pendidikan">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_pend+1);?>">Grafik Pendidikan</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$pendidikan as $pnd): ?>
                <th><?php echo $pnd;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$pendidikan as $pendId=>$pendNama): ?>
                <td><?php echo grafik_data('pendidikan',$kecId,$pendId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="pekerjaan">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_kerja+1);?>">Grafik Pekerjaan</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$pekerjaan as $pek): ?>
                <th><?php echo $pek;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$pekerjaan as $pekId=>$pekNama): ?>
                <td><?php echo grafik_data('pekerjaan',$kecId,$pekId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="cacat">
     <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_cacat+1);?>">Grafik Penyandang Cacat</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$cacat as $cat): ?>
                <th><?php echo $cat;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$cacat as $cId=>$cNama): ?>
                <td><?php echo grafik_data('cacat',$kecId,$cId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="kawin">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_kawin+1);?>">Grafik Status Perkawinan</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$kawin as $ka): ?>
                <th><?php echo $ka;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$kawin as $kId=>$kNama): ?>
                <td><?php echo grafik_data('kawin',$kecId,$kId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="potensi">
    	<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ($jml_potensi+1);?>">Grafik Potensi</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$potensi as $po): ?>
                <th><?php echo $po;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$potensi as $pId=>$pNama): ?>
                <td><?php echo grafik_data('potensi',$kecId,$pId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="usia">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
            <tr>
                <td colspan="<?php echo ( count($arrusia)+1);?>">Grafik Usia</td>
            </tr>
            <tr>
                <th>Nama kecamatan</th>
                <?php foreach((array)$arrusia as $us): ?>
                <th><?php echo $us;?></th>
                <?php endforeach; ?>
            </tr>
            
            <?php foreach((array)$kecamatan as $kecId=>$kecNama):?>
            <tr>
                <td><?php echo $kecNama;?></td>
                <?php foreach((array)$arrusia as $uId=>$uNama): ?>
                <td><?php echo grafik_data('usia',$kecId,$uId);?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

