<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();
		$arr = array('spasial_model','potensi_model','kecamatan_model');
		
		$this->load->model( $arr );	
	}
	
	function index()
	{
		
		
		$kecamatan = get_kecamatan();
		if( isset($_POST['keyword']) and $_POST['keyword'] != '' )
		{
			$keyword = $this->input->post('keyword',true);
			$sql = "SELECT s.id_spasial,s.id_potensi,s.id_spasial,p.potensi_nama,k.kecamatan_id,k.kecamatan_name FROM spasial s 
				LEFT JOIN potensi p ON(s.id_potensi=p.id_potensi)
				LEFT JOIN kecamatan k ON(s.id_kecamatan=k.kecamatan_id)
				WHERE p.potensi_nama LIKE '%$keyword%' GROUP BY s.id_kecamatan";
			$run = $this->db->query($sql);
			$kecamatan = $run->result_array();
		}
		
		//pr($kecamatan);
		if( count($kecamatan) < 1 ){
			$data['nosidebar'] = true;
			$data['hide_map'] = true;
		}
		$data['kecamatans'] = $kecamatan;	
		$data['sidebar'] = 'layout_left.php';
		$this->load->view('public/layout_main',$data);
	}
	
	function data_wilayah()
	{
		
		/*$c = Array ( 
						0 => "56.948813,24.704004" ,
						1 => "-7.640561,110.473194", 
						2 => "-7.64005,110.480919", 
						3 => "-7.631713,110.48418" ,
						4 => "-7.622356,110.49036" ,
						5 => "-7.619293,110.477486" ,
						6 => "-7.62712,110.471992" ,
						7 => "-7.611636,110.470963" ,
						8 => "-7.608233,110.484867" ,
						9 => "-7.599385,110.471992" ,
						10 => "-7.622696,110.479889" ,
						11 => "-7.636477,110.489159" ,
						12 => "-7.613678,110.48418" ,
						13 => "-7.614018,110.472507", 
						14 => "-7.60415,110.475941" );
		foreach($c as $x)
		{
			$a = explode(',',$x);
			$this->db->insert('marker',array('id_spasial'=>201,'latitude'=>$a[0],'longitude'=>$a[1]));	
		}*/
		
		$kecamatan_id = (int)$this->uri->segment(3,0);
		
		$sql = "SELECT p.*,s.* ,k.kecamatan_name,k.kecamatan_id FROM spasial s 
				LEFT JOIN potensi p ON(s.id_potensi = p.id_potensi)
				LEFT JOIN kecamatan k ON(s.id_kecamatan = k.kecamatan_id) 
				WHERE k.kecamatan_id = $kecamatan_id GROUP BY p.potensi_parent";
		$run = $this->db->query($sql) -> result_array();
		$parentid = array();
		foreach((array)$run as $dt)
		{
			$r = array('primary'=>'id_potensi','field'=>'potensi_nama','table'=>'potensi','id'=>$dt['potensi_parent']);		
			$item['id_potensi'] = $dt['potensi_parent'];
			$item['potensi_parent'] = single_data($r);
			$item['potensi_nama'] = single_data($r);
			$item['id_spasial'] = $dt['id_spasial'];

			$parentid[] = $item;
		}
		
		//pr($parentid);
		
		/*$pot = $this->potensi_model->get_data();
		pr($parentid);
		
		$spasial = $this->spasial_model->get_spasial_by_kecamatan($kecamatan_id);
		//$arrpotensi = array_path_potensi( $this->potensi_model->get_data() );
		$arrpotensi = array_path_potensi( $parentid );
		pr($arrpotensi);*/
		
		$this->db->where('kecamatan_id',$kecamatan_id);
		$que = $this->db->get('kecamatan') -> row_array();
		
		$data['latitude'] = $que['kecamatan_latitude'];	
		$data['longitude'] = $que['kecamatan_longitude'];	
		$data['potensi'] = $parentid;
		$data['kecamatan_id'] = $kecamatan_id;
		$data['sidebar'] = 'layout_potensi_wilayah.php';
		$data['kecamatan_nama'] = $this->kecamatan_model->kecamatan_by_id($kecamatan_id);
		//$data['potensi'] = tree_potensi($arrpotensi);
		$data['page'] = 'data_wilayah';
		//$data['spasial'] = $spasial;
		$this->load->view('public/layout_main',$data);
			
	}
	
	function grafik()
	{
		$main = array(1,2,3,4,5,6,7,8);
		$kecamatan_id = (int)$this->uri->segment(3,0);
		
		$sql = "SELECT p.*,s.* ,k.kecamatan_name,k.kecamatan_id FROM spasial s 
				LEFT JOIN potensi p ON(s.id_potensi = p.id_potensi)
				LEFT JOIN kecamatan k ON(s.id_kecamatan = k.kecamatan_id) 
				WHERE k.kecamatan_id = $kecamatan_id GROUP BY p.potensi_parent";
		$run = $this->db->query($sql) -> result_array();
		$parentid = array();
		foreach((array)$run as $dt)
		{
			$r = array('primary'=>'id_potensi','field'=>'potensi_nama','table'=>'potensi','id'=>$dt['potensi_parent']);		
			$item['parent_id'] = $dt['potensi_parent'];
			$item['potensi_id'] = $dt['id_potensi'];
			$item['parent_name'] = single_data($r);

			$parentid[] = $item;
		}
		
		//pr($parentid);
		
		# AGAMA
		$agama = get_agama();
		$agm = array();
		foreach((array)$agama as $a){
			$agm[] = "['".$a['agama_nama']."',".count_data_grafik('id_agama',$a['id_agama'],$kecamatan_id)."]";
		}
		
		# PENYANDANG CACAT
		$pcacat = get_penyandangcacat();
		$cct = array();
		foreach((array)$pcacat as $b){
			$cct[] = "['".$b['penyandangcacat_nama']."',".count_data_grafik('id_penyandangcacat',$b['id_penyandangcacat'],$kecamatan_id)."]";
		}	
		
		# GOLONGAN DARAH
		$goldar = get_golongandarah();
		$gol = array();
		foreach((array)$goldar as $c){
			$gol[] = "['".$c['golongandarah_nama']."',".count_data_grafik('id_golongandarah',$c['id_golongandarah'],$kecamatan_id)."]";
		}
		
		# PENDIDIKAN
		$pendidikan = get_pendidikan();
		$pend = array();
		foreach((array)$pendidikan as $d){
			$pend[] = "['".$d['pendidikan_nama']."',".count_data_grafik('id_pendidikan',$d['id_pendidikan'],$kecamatan_id)."]";
		}	
		
		# PERKAWINAN
		$kawin = get_statusperkawinan();
		$kwn = array();
		foreach((array)$kawin as $e){
			$kwn[] = "['".$e['statusperkawinan_nama']."',".count_data_grafik('id_statusperkawinan',$e['id_statusperkawinan'],$kecamatan_id)."]";
		}	
		
		# GRAFIK USIA
		$arrusia = array(
							'0 - 10 tahun'=>0,
							'11 - 20 tahun'=>0,
							'21 - 30 tahun'=>0,
							'31 - 40 tahun' => 0,
							'41 - 50 tahun'=>0,
							'51 - 60 tahun'=>0,
							'61 - 70 tahun'=>0,
							'71 - 80 tahun'=>0,
							'81 - 90 tahun'=>0,
							'91 - 100 tahun'=>0,
							' > 100 tahun'=>0
							);
		$range = array();
		$grafusia = array();
		
		if( $this->uri->segment(3) ){
			$this->db->where('id_kecamatan',$kecamatan_id);	
		}
		$usia = $this->db->get('person') -> result_array();
		$num=0;
		foreach((array)$usia as $us)
		{
			
			
			$jmlhari = $this->hitung_usia($us['person_tanggallahir']);
			if( $jmlhari <= 3650 ){
				$range['satu'][] = $us['id_person'];
				$arrusia['0 - 10 tahun'] = count($range['satu']);
			}
			
			if( $jmlhari > 3650 and $jmlhari <= 7300 ){
				$range['dua'][] = $us['id_person'];
				$arrusia['11 - 20 tahun'] = count($range['dua']);
			}
			
			if( $jmlhari > 7300 and $jmlhari <= 10950 ){
				$range['tiga'][] = $us['id_person'];
				$arrusia['21 - 30 tahun'] = count($range['tiga']);
			}
			
			if( $jmlhari > 10950 and $jmlhari <= 14600 ){
				$range['empat'][] = $us['id_person'];
				$arrusia['31 - 40 tahun'] = count($range['empat']);
			}
			
			if( $jmlhari > 14600 and $jmlhari <= 18250 ){
				$range['lima'][] = $us['id_person'];
				$arrusia['41 - 50 tahun'] = count($range['lima']);
			}
			
			if( $jmlhari > 18250 and $jmlhari <= 21900 ){
				$range['enam'][] = $us['id_person'];
				$arrusia['51 - 60 tahun'] = count($range['enam']);
			}
			
			if( $jmlhari > 21900 and $jmlhari <= 25550 ){
				$range['tujuh'][] = $us['id_person'];
				$arrusia['61 - 70 tahun'] = count($range['tujuh']);
			}
			
			if( $jmlhari > 25550 and $jmlhari <= 29200 ){
				$range['delapan'][] = $us['id_person'];
				$arrusia['71 - 80 tahun'] = count($range['delapan']);
			}
			
			if( $jmlhari > 29200 and $jmlhari <= 32850 ){
				$range['sembilan'][] = $us['id_person'];
				$arrusia['81 - 90 tahun'] = count($range['sembilan']);
			}
			
			if( $jmlhari > 32850 and $jmlhari <= 36500 ){
				$range['sepuluh'][] = $us['id_person'];
				$arrusia['91 - 100 tahun'] = count($range['sepuluh']);
			}
			
			if( $jmlhari > 36500 ){
				$range['sebelas'][] = $us['id_person'];
				$arrusia[' > 100 tahun'] = count($range['sebelas']);
			}
		}
		
		foreach(($arrusia)as $key=>$val)
		{
			$grafusia[] = "['".$key."',$val]";	
		}
		
		//pr($grafusia);
		//die;
		# POTENSI
		
		# get sub parent
		
		$idpar = array();
		$parent = get_potensi();
		foreach((array)$parent as $par){
			$idpar['id'][] = $par['id_potensi'];
			$idpar['name'][] = $par['potensi_nama'];
		}
		
		$arrsub = array();
		foreach((array)$idpar['id'] as $key=>$val){
			$this->db->where('potensi_parent',$val);
			$this->db->where('potensi_status',1);
			$query = $this->db->get('potensi');
			//$arrsub[$val]['parent'][] = $idpar[$val]['name'];
			foreach((array)$query->result_array() as $row)
			{
				$arrsub[$val]['parent'] = $idpar['name'][$key];
				$arrsub[$val]['child'][$row['id_potensi']] = $row['potensi_nama'];				
			}
		}
		
		
		foreach((array)$arrsub as $co)
		{
			$in = implode(',', array_keys($co['child']));
			$where = "";
			if( $kecamatan_id > 0 ){
				$where = " AND id_kecamatan = $kecamatan_id ";	
			}
			
			$query = $this->db->query("SELECT *,COUNT(*) AS jumlah FROM spasial WHERE id_potensi IN($in) $where");
			$num = $query->row_array();
			
			$pot[] = "['".$co['parent']."',".$num['jumlah']."]";
			//$pot[] = "['".$p['parent']."',".get_count_potensi($p['id_potensi'],$kecamatan_id)."]";	
		}
		
		//pr($arrsub);
		//die;
		
		
		
		$data['grafik_agama'] = implode(',',$agm);
		$data['grafik_penyandangcacat'] = implode(',',$cct);
		$data['grafik_golongandarah'] = implode(',',$gol);
		$data['grafik_pendidikan'] = implode(',',$pend);
		$data['grafik_statusperkawinan'] = implode(',',$kwn);
		$data['grafik_potensi'] = implode(',',$pot);
		$data['grafik_usia'] = implode(',',$grafusia);
		
		$data['nosidebar'] = true;
		$data['page'] = 'grafik';
		$this->load->view('public/layout_main',$data);
	}
	
	
	
	function maparea()
	{
		$id = (int)$this->uri->segment(3,0);
		$this->db->where('kecamatan_id',$id);
		$query = $this->db->get( 'kecamatan' );
		$row = $query->row_array();
		
		header("content-type: application/javascript");
		
		$js  = "";
		/*$js .= 'function initialize() {'."\n";
		$js .= '	var latlng = new google.maps.LatLng('.$row['kecamatan_latitude'].','.$row['kecamatan_longitude'].');'."\n";
		$js .= '	var myOptions = {'."\n";
		$js .= '		zoom: 13,'."\n";
		$js .= '		center: latlng,'."\n";
		$js .= '		mapTypeId: google.maps.MapTypeId.ROADMAP'."\n";
		$js .= '	};'."\n";
		$js .= '	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);'."\n";
					
		$js .= '	LoadStates();'."\n";
		$js .= '}'."\n\n";
		*/
		$js .= 'function LoadStates()'."\n";
		$js .= '{'."\n";
		

		$name = preg_replace('#[^a-zA-Z]#','', strtolower($row['kecamatan_name']));
		$coor = unserialize($row['kecamatan_koordinat']);
		$arr = array();
		foreach($coor as $co)
		{
			$arr[] = "new google.maps.LatLng(".$co.")\n";
		}
		
		$point = implode(',',$arr);
		$js .= 'var points = ['."\n";
		$js .= $point;
		$js .= ']'."\n\n";
		
		$js .= 'var '.$name.' = new google.maps.Polygon({'."\n";
		$js .= '    paths: points,'."\n";
		$js .= '    strokeColor: \'#000000\','."\n";
		$js .= '    strokeOpacity: 0,'."\n";
		$js .= '    strokeWeight: 1,'."\n";
		$js .= '    fillColor: \'#000000\','."\n";
		$js .= '    fillOpacity: 0.4'."\n";
		$js .= '});'."\n\n";
		
		$js .= 'google.maps.event.addListener('.$name.',\'mouseover\',function(){'.$name.'.setOptions({strokeOpacity: 1}); tooltip.show(\'Kecamatan '.$row['kecamatan_name'].'\'); });'."\n";
		$js .= 'google.maps.event.addListener('.$name.',\'mouseout\',function(){'.$name.'.setOptions({strokeOpacity: 0}); tooltip.hide(); });'."\n";
		//$js .= 'google.maps.event.addListener('.$name.',\'click\',function(){document.getElementById("StateName").innerHTML = "Diisi data kecamatan '.$row['kecamatan_name'].'"; extend(); });'."\n";
		$js .= $name.'.setMap(map);'."\n\n";
			
		$js .= '}';
		
		$js .= 'function createMarker(lat,lang) {';
		$js .= '	var myLatLng = new google.maps.LatLng(lat, lang);';
		
		$js .= '	var marker = new google.maps.Marker({';
		$js .= '		position: myLatLng,';
		//$js .= '		icon: data.icon,';
		$js .= '		map: map,';
		//$js .= '		title: data.title';
		$js .= '	});';
		$js .= '	google.maps.event.addListener(marker, \'click\', function() {';
		$js .= '		window.location.href = data.url;';
		$js .= '	});';
		
		//$js .= '	return marker;';
		$js .= '}';

		echo $js;
	}
	
	function jsmap()
	{
		header("content-type: application/javascript");
		$js  = "";
		$js .= 'var invisColor = "#000000";'."\n";
		$js .= 'var outlineColor = "#0ABA02";   //green'."\n";
		$js .= 'var map = null;'."\n";
		$js .= 'var currentState = "";'."\n";
				
		$js .= 'function extend() {'."\n";
		$js .= '	$(\'.dropbox\').animate({ height: \'25\' }, 100);'."\n";
		$js .= '	$(\'.dropbox\').css(\'padding-top\', \'5px\');'."\n";
		$js .= '}'."\n\n";
				
		$js .= 'function initialize() {'."\n";
		$js .= '	var latlng = new google.maps.LatLng(-7.657914,110.664597);'."\n";
		$js .= '	var myOptions = {'."\n";
		$js .= '		zoom: 11,'."\n";
		$js .= '		center: latlng,'."\n";
		$js .= '		mapTypeId: google.maps.MapTypeId.ROADMAP'."\n";
		$js .= '	};'."\n";
		$js .= '	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);'."\n";
					
		$js .= '	LoadStates();'."\n";
		$js .= '}'."\n\n";	
		
		
		$js .= 'function LoadStates()'."\n";
		$js .= '{'."\n";
		
			$data = $this->db->get("kecamatan");
			foreach($data->result_array() as $row)
			{
				$name = preg_replace('#[^a-zA-Z]#','', strtolower($row['kecamatan_name']));
				$coor = unserialize($row['kecamatan_koordinat']);
				$arr = array();
				foreach($coor as $co)
				{
					$arr[] = "new google.maps.LatLng(".$co.")\n";
				}
				
				$point = implode(',',$arr);
				$js .= 'var points = ['."\n";
				$js .= $point;
				$js .= ']'."\n\n";
				
				$js .= 'var '.$name.' = new google.maps.Polygon({'."\n";
                $js .= '    paths: points,'."\n";
                $js .= '    strokeColor: \''.$row['kecamatan_warna'].'\','."\n";
                $js .= '    strokeOpacity: 0,'."\n";
                $js .= '    strokeWeight: 1,'."\n";
                $js .= '    fillColor: \''.$row['kecamatan_warna'].'\','."\n";
                $js .= '    fillOpacity: 0.4'."\n";
                $js .= '});'."\n\n";
				
				$js .= 'google.maps.event.addListener('.$name.',\'mouseover\',function(){'.$name.'.setOptions({strokeOpacity: 1}); tooltip.show(\'Kecamatan '.$row['kecamatan_name'].'\'); });'."\n";
  				$js .= 'google.maps.event.addListener('.$name.',\'mouseout\',function(){'.$name.'.setOptions({strokeOpacity: 0}); tooltip.hide(); });'."\n";
  				//$js .= 'google.maps.event.addListener('.$name.',\'click\',function(){document.getElementById("StateName").innerHTML = "Diisi data kecamatan '.$row['kecamatan_name'].'"; extend(); });'."\n";
  				$js .= $name.'.setMap(map);'."\n\n";
				
			}
			
		$js .= '}';
		echo $js;
	}
	
	function get_data()
	{
		if( isset($_POST['action']) and $_POST['action'] == 'get_data' )
		{
			$kecamatan_id = (int)$_POST['kecamatan_id'];
			$this->db->where("kecamatan_id",$kecamatan_id);
			$row = $this->db->get('kecamatan') -> row_array();
			
			$kepadatan = (jumlah_penduduk($kecamatan_id)/$row['kecamatan_luas']);
			
			$tmp  = "Nama kecamatan : ".$row['kecamatan_name']."<br>";
			$tmp .= "Jumlah penduduk : ".jumlah_penduduk($kecamatan_id)." jiwa <br>";
			$tmp .= "Luas wilayah : ".$row['kecamatan_luas']." Km <br>";
			$tmp .= "Kepadatan penduduk : ".ceil($kepadatan)." jiwa/Km <br>";
			$tmp .= "<a href=\"".site_url('home/data_wilayah/'.$kecamatan_id)."\">Lihat data</a>";
			
			$json = array();
			$json['latitude'] 	= $row['kecamatan_latitude'];
			$json['longitude']	= $row['kecamatan_longitude'];
			$json['content'] = $tmp;
			
			echo json_encode($json);
			die;
				
		}
	}
	
	function getmarker()
	{

		$id = $_POST['id'];
		$this->db->where('id_spasial',$id);
		$data = $this->db->get('marker') -> result_array();
		
		$r = array();
		foreach((array)$data as $row)
		{
			$a = array('primary'=>'id_spasial','field'=>'id_potensi','table'=>'spasial','id'=>$row['id_spasial']);
			$b = single_data($a);
			
			$c = array('primary'=>'id_potensi','field'=>'potensi_icon','table'=>'potensi','id'=>$b);					
			$d = single_data($c);
			
			$v = array('primary'=>'id_potensi','field'=>'potensi_value','table'=>'potensi','id'=>$b);					
			$w = single_data($v);
			
			$satuan = $this->_satuan($b);
			$o = $this->getvalue($row['id_marker']);
;			
			$r[] = array('lat' => $row['latitude'],'long' => $row['longitude'],'icon' => $d,'id' => $row['id_marker'],'alamat' => $row['alamat'],'direction' => url_title($row['alamat']),'value' => $o);
		}
		
		echo json_encode($r);
		//echo '{"xxx":"ccc","vvvv":"hhhh"}';
		die;
	}
	
	function rute()
	{
		$id = (int)$this->uri->segment(3,0);
		
		$this->db->where('id_marker', $id);
		$row = $this->db->get('marker') -> row_array();
		
		$data['tujuan'] = $row['alamat'];		
		$data['nosidebar'] = true;
		$data['page'] = 'rute';
		$this->load->view('public/layout_main',$data);
	}
	
	function getcoor()
	{
		$id = $_POST['id'];
		$this->db->where('id_marker',$id);
		$run = $this->db->get('marker')->row_array();
		echo json_encode($run);
		exit();
	}
	
	function hitung_usia($lhr)
	{
		list($tgl,$bln,$thn) = explode('-',$lhr);
		$format = "$thn-$bln-$tgl";
		$query = $this->db->query("SELECT DATEDIFF( NOW(), '$format') AS jml");	
		$run = $query->row_array();
		return @$run['jml'];
	}
	
	function _satuan($id)
	{
		
		$this->db->where('id_potensi',$id);
		$run = $this->db->get('potensi') -> row_array();
		
		if( $run['potensi_parent'] == 0 )
		{
			switch($id)
			{
				case '1':
					$satuan = ' Ekor';
				break;
				case '2':
					$satuan = ' Kilogram';
				break;
				case '3':
					$satuan = ' Meter';
				break;
				case '4':
					$satuan = ' Kilogram';
				break;
				case '5':
					$satuan = ' Lokasi';
				break;
				case '6':
					$satuan = ' Lokasi';
				break;
				case '8':
					$satuan = ' SIUP';
				break;
				case '69':
					$satuan = ' Lokasi';
				break;
				case '70':
					$satuan = ' Lokasi';
				break;	
			}
		}
		else
		{
			$this->db->where('id_potensi',$run['id_potensi']);
			$runs = $this->db->get('potensi') -> row_array();
			//pr($runs);
			switch($runs['potensi_parent'])
			{
				case '1':
					$satuan = ' Ekor';
				break;
				case '2':
					$satuan = ' Kilogram';
				break;
				case '3':
					$satuan = ' Meter';
				break;
				case '4':
					$satuan = ' Kilogram';
				break;
				case '5':
					$satuan = ' Lokasi';
				break;
				case '6':
					$satuan = ' Lokasi';
				break;
				case '8':
					$satuan = ' SIUP';
				break;
				case '69':
					$satuan = ' Lokasi';
				break;
				case '70':
					$satuan = ' Lokasi';
				break;	
			}
		}
		return $satuan;
	}
	
	function getvalue($id)
	{
		$this->db->select('id_spasial');
		$this->db->where('id_marker',$id);
		$run = $this->db->get('marker')->row_array();
		if( !empty($run) ){
			$id_spasial = (int)$run['id_spasial'];
			$this->db->select('spasial_value');
			$this->db->select('id_potensi');
			$this->db->where('id_spasial',$id_spasial);	
			$go = $this->db->get('spasial')->row_array();
			if( !empty($go) ){
				$sat = $this->_satuan($go['id_potensi']);
				return mformat($go['spasial_value']).$sat;
			}else{
				return "0" . $sat;
			}
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */