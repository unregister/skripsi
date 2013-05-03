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
