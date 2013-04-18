<?php

class Person_model extends Model
{
	var $table;
	var $primary;
	var $logindata;
	
	function Person_model()
	{
		parent::Model();
		$this->table = 'person';
		$this->primary = 'id_person';
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
	
}