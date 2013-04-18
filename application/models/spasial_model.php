<?php

class Spasial_model extends Model
{
	var $table;
	var $primary;
	var $logindata;
	
	function Spasial_model()
	{
		parent::Model();
		$this->table = 'spasial';
		$this->primary = 'id_spasial';
	}
	
	function get_data($id = null, $array = false)
	{
		if( $id != null ){
			$this->db->where($this->primary,$id);	
		}
		
		$group_id = get_login('id_group');
		if( $group_id > 1 )
		{
			$single = array('primary'=>'id_group','field'=>'id_kecamatan','table'=>'admin_group','id'=>$group_id);
			$kecamatan_id = single_data($single);
			$this->db->where('id_kecamatan',$kecamatan_id);
		}
		
		
		$query = $this->db->get($this->table);
		if( $id != null )
		{
			if( $array ){
				return $query->result_array();
			}else{
				return $query->row_array();
			}
		}
		else
		{
			return $query->result_array();
		}
		
			
	}
	
	function save_data($arr, $id=null)
	{
		if( empty($arr) ){
			return false;	
		}
		if( $id == null ){
			$insert = $this->db->insert($this->table,$arr);	
			return $this->db->insert_id();
		}
		else
		{
			$this->db->where($this->primary,(int)$id);
			return $this->db->update($this->table,$arr);	
		}
	}
	
	function delete( $id )
	{
		if( empty($id) ){
			return false;	
		}
		
		$this->db->where($this->primary,$id);
		return $this->db->delete($this->table);
	}
	
	function get_spasial_by_kecamatan($id)
	{
		if(empty($id)){
			return false;
		}
		
		$where = "";
		$group_id = get_login('id_group');
		
		
		$sql = "SELECT 
					p.id_potensi,
					p.potensi_parent,
					p.potensi_nama,
					k.kecamatan_id
				FROM spasial s 
				LEFT JOIN potensi p ON(s.id_potensi = p.id_potensi)
				LEFT JOIN kecamatan k ON(s.id_kecamatan = k.kecamatan_id) WHERE k.kecamatan_id = $id ";
		$query = $this->db->query( $sql );
		if( $query->num_rows() > 0 )
		{
			return $query->result_array();	
		}
		else
		{
			return false;	
		}
	}
	
	function get_marker( $spasial_id )
	{
		$this->db->where('id_spasial',$spasial_id);
		return $this->db->get('marker') -> result_array();	
	}
	
}