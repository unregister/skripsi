<?php
if( !defined('BASEPATH') ){ die("Access Not Alowed"); }

function getSOAPPersonById( $person_id )
{
	$ci =& get_instance();
	$ci->db->where("id_person",$person_id);
	$result = $ci->db->get("person") -> row_array();
	return json_encode($result);	
}

function getSOAPPersonByKecamatan( $kec_id )
{
	$ci =& get_instance();
	$ci->db->where("id_kecamatan",$kec_id);
	$result = $ci->db->get("person") -> result_array();
	return json_encode($result);	
}

function getSOAPKecamatan()
{
	$ci =& get_instance();
	$result = get_kecamatan(true);
	return json_encode($result);
}

function getSOAPAgama()
{
	$ci =& get_instance();
	$result = get_agama(1,true);
	return json_encode($result);
}

function getSOAPGolonganDarah()
{
	$ci =& get_instance();
	$result = get_golongandarah(1,true);
	return json_encode($result);
}

function getSOAPPekerjaan()
{
	$ci =& get_instance();
	$result = get_pekerjaan(1,true);
	return json_encode($result);
}

function getSOAPPendidikan()
{
	$ci =& get_instance();
	$result = get_pendidikan(1,true);
	return json_encode($result);
}

function getSOAPPenyandangCacat()
{
	$ci =& get_instance();
	$result = get_penyandangcacat(1,true);
	return json_encode($result);
}

function getSOAPStatusPerkawinan()
{
	$ci =& get_instance();
	$result = get_statusperkawinan(1,true);
	return json_encode($result);
}

function getSOAPLogin($username,$password)
{
	$ci =& get_instance();
	$password = md5($password);
	$sql = "SELECT a.id_admin,a.username,a.admin_nama,a.id_group,g.id_kecamatan 
			FROM admin a LEFT JOIN admin_group g ON(a.id_group=g.id_group) 
			WHERE a.username = '$username' AND a.password = '$password'";
	
	$run = $ci->db->query($sql);
	if( $run->num_rows() > 0 )
	{
		# Admin gak boleh login lewat sini
		$result = $run->row_array();
		if( $result['id_kecamatan'] != 'all' ){
			return json_encode($result);
		}else{
			return json_encode( array() );	
		}
	}else{
		$result = array();
		return json_encode( $result );	
	}
}

function getSOAPInsertPerson( $data )
{
	$ci =& get_instance();
	if( empty($data) ){
		return false;	
	}
	$data = json_decode($data,1);
	
	$insert = $ci->db->insert("person",$data);
	if($insert){
		$arr = array("status"=>1,"msg"=>success("Data berhasil disimpan"));
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal disimpan"));
		return json_encode($arr);	
	}
}

function getSOAPUpdatePerson( $id,$data )
{
	$ci =& get_instance();
	if( empty($data) ){
		return false;	
	}
	$data = json_decode($data,1);
	
	$ci->db->where("id_person",$id);
	$insert = $ci->db->update("person",$data);
	if($insert){
		$arr = array("status"=>1,"msg"=>success("Data berhasil disimpan"));
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal disimpan"));
		return json_encode($arr);	
	}
}

function getSOAPDeletePerson($id)
{
	$ci =& get_instance();
	$ci->db->where("id_person",$id);
	$delete = $ci->db->delete("person");
	if($delete){
		$arr = array("status"=>1,"msg"=>success("Data berhasil dihapus"));
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal dihapus"));
		return json_encode($arr);	
	}
}

function getSOAPCekData( $id, $kolom )
{
	$ci =& get_instance();
	$ci->db->where($kolom,$id);
	$run = $ci->db->get('person') -> num_rows();
	if($run > 0){
		return json_encode( array('status' => 1) );	
	}
	return json_encode( array('status' => 0) );
}

function getSOAPPotensi( $combo = false )
{
	$ci =& get_instance();
	$result = get_potensi();
	
	if( $combo == 1 )
	{
		$arr = array();
		foreach((array)$result as $row){
			$arr[$row['id_potensi']] = $row['potensi_nama'];
		}
		return json_encode($arr);
	}
	
	return json_encode($result);
}

function getSOAPSpasial($id_kecamatan)
{
	$ci =& get_instance();
	$ci->db->where("id_kecamatan",$id_kecamatan);
	$result = $ci->db->get("spasial") -> result_array();
	return json_encode($result);
}

function getSOAPInsertSpasial( $data )
{
	$ci =& get_instance();
	if( empty($data) ){
		return false;	
	}
	$data = json_decode($data,1);

	$insert = $ci->db->insert("spasial",$data);
	if($insert){
		$spasial_id = $ci->db->insert_id();
		$arr = array("status"=>1,"msg"=>success("Data berhasil disimpan"),"id_spasial" => $spasial_id);
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal disimpan"),"id_spasial" => NULL);
		return json_encode($arr);	
	}

}

function getSOAPDeleteSpasial($id)
{
	$ci =& get_instance();
	$ci->db->where("id_spasial",$id);
	$delete = $ci->db->delete("spasial");
	if($delete){
		$arr = array("status"=>1,"msg"=>success("Data berhasil dihapus"));
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal dihapus"));
		return json_encode($arr);	
	}
}

function getSOAPGetMarker($id)
{
	$ci =& get_instance();
	$ci->db->where("id_spasial",$id);
	$result = $ci->db->get("marker") -> result_array();
	return json_encode($result);
}

function getSOAPPotensiById( $id )
{
	$ci =& get_instance();
	$ci->db->where("id_potensi",$id);
	$result = $ci->db->get("potensi") -> row_array();
	return json_encode($result);	
}

function getSOAPInsertMarker($arr_marker)
{
	$ci =& get_instance();
	if( empty($arr_marker) ){
		return false;	
	}

	$marker = json_decode($arr_marker,1);
	if( !empty($marker) )
	{
		foreach((array)$marker as $m)
		{
			$sql = "INSERT INTO marker SET id_spasial = '".$m['id_spasial']."',latitude= '".$m['latitude']."',longitude='".$m['longitude']."',alamat='".$m['alamat']."'";
			$ci->db->query($sql);
		}
	}

}

function getSOAPSpasialById( $spasial_id )
{
	$ci =& get_instance();
	$ci->db->where("id_spasial",$spasial_id);
	$result = $ci->db->get("spasial") -> row_array();
	return json_encode($result);	
}

function getSOAPUpdateSpasial($spasial_id, $data )
{
	$ci =& get_instance();
	if( empty($data) ){
		return false;	
	}
	$data = json_decode($data,1);
	$ci->db->where('id_spasial',$spasial_id);
	$insert = $ci->db->update("spasial",$data);
	if($insert){
		$arr = array("status"=>1,"msg"=>success("Data berhasil disimpan"),"id_spasial" => $spasial_id);
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0,"msg"=>success("Data gagal disimpan"),"id_spasial" => NULL);
		return json_encode($arr);	
	}

}

function getSOAPDeleteMarker($id)
{
	$ci =& get_instance();
	$ci->db->where("id_spasial",$id);
	$delete = $ci->db->delete("marker");
	if($delete){
		$arr = array("status"=>1);
		return json_encode($arr);	
	}else{
		$arr = array("status"=>0);
		return json_encode($arr);	
	}
}