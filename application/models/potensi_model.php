<?php

class Potensi_model extends Model
{
	var $table;
	var $primary;
	var $logindata;
	
	function Potensi_model()
	{
		parent::Model();
		$this->table = 'potensi';
		$this->primary = 'id_potensi';
	}
	
	function get_data($id = null, $array = false)
	{
		if( $id != null ){
			$this->db->where($this->primary,$id);	
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
	
	function get_potensi($parent=0)
	{
		$this->db->where('potensi_parent',$parent);	
		$query = $this->db->get($this->table);
		return $query->result_array();			
	}
	
	function save_data($arr, $id=null)
	{
		if( empty($arr) ){
			return false;	
		}
		if( $id == null ){
			return $this->db->insert($this->table,$arr);	
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
	
	function parent_nama($id)
	{
		$this->db->where($this->primary,$id);
		$query = $this->db->get($this->table);
		$result = $query->row_array();
		return $result['potensi_nama'];
	}
	
}

