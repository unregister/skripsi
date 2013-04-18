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
			
			
			
			$r[] = array('lat' => $row['latitude'],'long' => $row['longitude'],'icon' => $d,'id' => $row['id_marker'],'alamat' => $row['alamat'],'direction' => url_title($row['alamat']) );
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
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */