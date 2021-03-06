<?php

function template_url()
{
	return base_url()."application/views/public/";	
}

function admin_template_url()
{
	return base_url()."application/views/admin/";	
}

function pr($arr)
{
	echo '<pre>'.print_r($arr,1).'</pre>';
}



function cek_login( $redirect = true )
{
	$ci =& get_instance();
	$userdata = $ci->session->userdata('admin_login');
	
	/*if( isset($_POST['loggedin']) and $_POST['loggedin'] == 1 ){
		return true;	
	}*/
	
	if(!empty($userdata)){
		return true;	
	}
	else
	{
		if( $redirect )
		{
			redirect( site_url('admin/login') );
			exit();
		}
		else
		{
			return false;
		}
	}
}

function topmenu()
{
	$out  = "";
	$out .= "<ul class=\"side-nav\">\n";
	$ci =& get_instance();
	
	$url = $ci->uri->segment(2);
	$group_id = get_login('id_group');
	
	$sql = "SELECT m.* FROM admin_menu m LEFT JOIN admin_menu_group g ON(m.id_menu=g.id_menu) WHERE m.menu_parent = 0 AND g.id_group = $group_id ORDER BY m.menu_orderby ASC";
	$query = $ci->db->query($sql);
	if($query->num_rows() > 0)
	{
		foreach($query->result_array() as $row)
		{
			$menuurl = str_replace('admin/','',$row['menu_url']);
			$active = ($url == $menuurl)?" class=\"active\"":"";
			$out .= "<li$active>";
			$out .= "<a href=\"".site_url($row['menu_url'])."\" class=\"getpage\"><i class=\"icon-sitemap\"></i>&nbsp;&nbsp;".$row['menu_title']."</a>";
			$out .= "</li>\n";
			
		}
	}
	$out .= "</ul>\n";
	return $out;
}

function confirm($msg)
{
	$html = "javascript:delete_data('$msg');";	
	return $html;
}

function error($msg)
{
	return '<div class="alert alert-error"><a href="#" data-dismiss="alert" class="close">x</a><h4 class="alert-heading">Error</h4>'.$msg.'</div>';	
}

function success($msg)
{
	return '<div class="alert alert-success"><a href="#" data-dismiss="alert" class="close">x</a><h4 class="alert-heading">Success</h4>'.$msg.'</div>';	
}

function show_message()
{
	$ci =& get_instance();
	if( $ci->session->flashdata('_msg') ){
		echo $ci->session->flashdata('_msg');
	}
}

function get_login($var)
{
	$ci =& get_instance();
	$login = $ci->session->userdata('admin_login');
	return $login[$var];
}

function get_kecamatan($selectbox = false)
{
	$ci =& get_instance();
	$ci->db->order_by('kecamatan_name','ASC');
	$query = $ci->db->get('kecamatan');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['kecamatan_id']] = $row['kecamatan_name'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_agama( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('agama_status',$status);
	$query = $ci->db->get('agama');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_agama']] = $row['agama_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_golongandarah( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('golongandarah_status',$status);
	$query = $ci->db->get('golongandarah');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_golongandarah']] = $row['golongandarah_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_pekerjaan( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('pekerjaan_status',$status);
	$query = $ci->db->get('pekerjaan');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_pekerjaan']] = $row['pekerjaan_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_pendidikan( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('pendidikan_status',$status);
	$query = $ci->db->get('pendidikan');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_pendidikan']] = $row['pendidikan_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_penyandangcacat( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('penyandangcacat_status',$status);
	$query = $ci->db->get('penyandangcacat');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_penyandangcacat']] = $row['penyandangcacat_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_statusperkawinan( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('statusperkawinan_status',$status);
	$query = $ci->db->get('statusperkawinan');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_statusperkawinan']] = $row['statusperkawinan_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_potensi_select( $status = 1, $selectbox = false )
{
	$ci =& get_instance();
	$ci->db->where('potensi_status',$status);
	$ci->db->where('potensi_parent',0);
	$query = $ci->db->get('potensi');
	
	$arr = array();
	if( $selectbox ){
		foreach((array)$query->result_array() as $row){
			$arr[$row['id_potensi']] = $row['potensi_nama'];	
		}
		return $arr;
	}
	return $query->result_array();
}

function get_potensi( $status = 1, $parent = null )
{
	$ci =& get_instance();
	if( $parent != null ){
		$ci->db->where('potensi_parent',$parent);
	}
	$ci->db->where('potensi_status',$status);
	$query = $ci->db->get('potensi');
	return $query->result_array();
}

function get_spasial_select( $status = 1 )
{
	$ci =& get_instance();
	$ci->db->where('potensi_status',1);
	$query = $ci->db->get('spasial');
	return $query->result_array();
}


function single_data( $arr )
{
	extract($arr);
	$ci =& get_instance();
	$ci->db->where($primary,$id);
	$query = $ci->db->get($table)->row_array();
	return @$query[$field];
}

function array_path_potensi($data, $par_id = 0, $separate = '#', $prefix = '&nbsp;')
{
	$output = array();
	$count = 1;
	foreach((array)$data AS $dt)
	{
		if($dt['potensi_parent'] == $par_id)
		{
			$text = ($par_id==0) ? "<strong>".$prefix.$dt['potensi_nama']."</strong>" : $prefix.$separate.' '.$dt['potensi_nama'];
			$to_replace = $dt['potensi_nama'];
			$output[$dt['id_potensi']] = $text;
			$r = array_path_potensi($data, $dt['id_potensi'], $separate, $text);
			if(!empty($r)) {
				foreach($r AS $i => $j){

					if( strpos($j,$separate) ){
						$ex = explode($separate,$j);
						$count = count($ex);
						$j = $ex[$count-1];
					}

					$output[$i] = str_repeat('-',$count).''.str_replace($separate,'',$j);
				}
			}
		}
	}
	
	return $output;
}

function createTreeOption($arr, $select = '', $name = 'parent_id')
{
	$output = "<select name=\"".$name."\">\n";
	if( $select == 0 ){
		$sel = ' selected="selected"';
	}else{
		$sel = '';
	}
	$valueiskey	= $check_first = false;
	foreach((array)$arr AS $key => $dt){
		if(is_array($dt)){
			list($value, $caption) = array_values($dt);
			if(empty($caption)) $caption = $value;
		}else{
			if(!$check_first) {
				if((is_numeric($key) && $key != 0) || (is_string($key) && !is_numeric($key)))
					$valueiskey = true;
				$check_first = true;
			}
			if(empty($dt) && !empty($key)) $dt = $key;
			$value = $valueiskey ? $key : $dt;
			$caption = $dt;
		}
		if(isset($select)){
			if(is_array($select)) $selected = (in_array($value, $select)) ? ' selected="selected"':'';
			else    $selected = ($value==$select) ? ' selected="selected"':'';
		}else{
			$selected = '';
		}
		$output .= "<option value=\"$value\"$selected>|$caption</option>\n";
	}
	$output .= "</select>\n";
	return $output;
}



function tree_potensi($arr)
{
	$output = "";
	
	$valueiskey	= $check_first = false;
	foreach((array)$arr AS $key => $dt){
		if(is_array($dt)){
			list($value, $caption) = array_values($dt);
			if(empty($caption)) $caption = $value;
		}else{
			if(!$check_first) {
				if((is_numeric($key) && $key != 0) || (is_string($key) && !is_numeric($key)))
					$valueiskey = true;
				$check_first = true;
			}
			if(empty($dt) && !empty($key)) $dt = $key;
			$value = $valueiskey ? $key : $dt;
			$caption = $dt;
		}
		/*if(isset($select)){
			if(is_array($select)) $selected = (in_array($value, $select)) ? ' selected="selected"':'';
			else    $selected = ($value==$select) ? ' selected="selected"':'';
		}else{
			$selected = '';
		}*/
		$output .= "<li><a href=\"".site_url('home/potensi/'.$value)."\">$caption</a></li>\n";
	}

	return $output;
}

function jumlah_penduduk($kecid)
{
	$ci =& get_instance();
	$ci->db->where('id_kecamatan', $kecid);
	$ci->db->from('person');
	return $ci->db->count_all_results();
}

function get_menu()
{
	$ci =& get_instance();
	$ci->db->where('menu_parent', '0');
	$ci->db->where('id_menu !=', '1');
	$ci->db->where('id_menu !=', ' 80');
	$go = $ci->db->get('admin_menu') -> result_array();
	//echo $ci->db->last_query();
	//die;
	$arr = array();
	
	foreach((array)$go as $x)
	{
		$arr['parent'][$x['id_menu']] = $x;
		
		$ci->db->where('menu_parent', $x['id_menu']);
		$ga = $ci->db->get('admin_menu') -> result_array();
		foreach((array)$ga as $y)
		{
			$arr['parent'][$x['id_menu']]['child'][] = $y;	
		}
	}
	
	return $arr;
}

function get_sub_potensi( $id, $kecamatan_id )
{
	$ci =& get_instance();
	$sql = "SELECT p.*,s.*  FROM spasial s LEFT JOIN potensi p ON(s.id_potensi = p.id_potensi) WHERE s.id_kecamatan = $kecamatan_id AND p.potensi_parent = $id";
	return $ci->db->query( $sql ) -> result_array();	
}

function get_koordinat($id)
{
	$ci =& get_instance();
	$ci->db->where('id_spasial',$id);
	return $ci->db->get('marker') -> row_array(); 
}

function count_data_grafik( $primary, $id, $kec_id = 0  )
{
	$ci =& get_instance();
	
	if( $kec_id > 0 ){
		$ci->db->where('id_kecamatan',$kec_id);	
	}	
	$ci->db->where($primary,$id);
	$ci->db->from('person');
	return $ci->db->count_all_results();	
}



function fluid_open( $title = '', $span = 6 )
{
	$html  = '<div class="span'.$span.'">';
    $html .= '<div class="box">';
    $html .= '<h4 class="box-header round-top">'.$title.'</h4>';
    $html .= '<div class="box-container-toggle">';
    $html .= '<div class="box-content"> ';
	return $html;
}

function fluid_close()
{
	$html  = '</div>';	
    $html .= '</div>';	
    $html .= '</div>';	
    $html .= '</div>';
	return $html;	
}

function get_count_potensi( $potensi_id, $kec_id = 0 )
{
	$ci =& get_instance();
	if($kec_id > 0){
		$ci->db->where('id_kecamatan',$kec_id);	
	}
	$ci->db->where('spasial_value > ','1000');
	$ci->db->where('id_potensi',$potensi_id);
	$ci->db->from('spasial');
	return $ci->db->count_all_results();
}

function grafik_data($mode,$kec,$id)
{
	$ci =& get_instance();
	switch( strtolower($mode) )
	{
		case 'agama':
			$ci->db->where('id_agama',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;
		
		case 'pendidikan':
			$ci->db->where('id_pendidikan',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;	
		
		case 'cacat':
			$ci->db->where('id_penyandangcacat',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;
		
		case 'pekerjaan':
			$ci->db->where('id_pekerjaan',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;
		
		case 'goldarah':
			$ci->db->where('id_golongandarah',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;
		
		case 'kawin':
			$ci->db->where('id_statusperkawinan',$id);
			$ci->db->where('id_kecamatan',$kec);
			$result = $ci->db->count_all_results('person') . ' jiwa';
		break;
		
		case 'potensi':
			$ar = array();
			$ci->db->where('potensi_parent',$id);
			$par = $ci->db->get('potensi')->result_array();
			foreach((array)$par as $p){
				$ar[] = $p['id_potensi'];
			}
			
			$idpot = implode(',',$ar);
			$sql = "SELECT SUM(spasial_value) AS jml FROM spasial WHERE id_potensi IN($idpot) AND id_kecamatan = $kec ";
			$run = $ci->db->query($sql) ->row_array();
			$result = (empty($run['jml']) ? 0 : mformat($run['jml'])).' '.satuan($id);
		break;
		
		case 'usia':
			switch($id)
			{
				case '1':
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari <= 3650 ){
							$arr++;
						}
					}
					$result = $arr;
				break;
				case '2':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 3650 and $jmlhari <= 7300 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '3':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 7300 and $jmlhari <= 10950 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '4':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 10950 and $jmlhari <= 14600 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '5':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 14600 and $jmlhari <= 18250 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '6':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 18250 and $jmlhari <= 21900 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '7':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 21900 and $jmlhari <= 25550 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '8':
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 25550 and $jmlhari <= 29200 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '9':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 29200 and $jmlhari <= 32850 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '10':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 32850 and $jmlhari <= 36500 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
				case '11':
					
					$arr = 0;
					$go = $ci->db->query("SELECT * FROM person WHERE id_kecamatan = $kec") -> result_array();
					foreach((array)$go as $usia){
						$jmlhari = hitung_usia($usia['person_tanggallahir']);
						if( $jmlhari > 36500 ){
							$arr++;
						}
					}
					$result = $arr;
					
				break;
			}
		break;
	}
	return $result;
}

function satuan( $id )
{
	switch($id)
	{
		case '1':
			$satuan = ' Ekor';
		break;
		case '2':
			$satuan = ' Kg';
		break;
		case '3':
			$satuan = ' M';
		break;
		case '4':
			$satuan = ' Kg';
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
	return $satuan;
}

function mformat($val)
{
	return number_format( $val, 0,',','.');
}

function hitung_usia($lhr)
{
	list($tgl,$bln,$thn) = explode('-',$lhr);
	$format = "$thn-$bln-$tgl";
	$ci =& get_instance();
	$query = $ci->db->query("SELECT DATEDIFF( NOW(), '$format') AS jml");	
	$run = $query->row_array();
	return @$run['jml'];
}