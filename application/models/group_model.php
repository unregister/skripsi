<?php

class Group_model extends Model
{
	var $table;
	var $primary;
	var $logindata;
	
	function Group_model()
	{
		parent::Model();
		$this->table = 'admin_group';
		$this->primary = 'id_group';
	}
	
	
	function get_data( $id = null )
	{
		$where = "";
		if( $id != null )
		{
			$where = " WHERE id_group = $id ";
		}
		$sql = "SELECT * FROM {$this->table} $where ORDER BY id_group DESC";
		$query = $this->db->query($sql);
		if( $id != null ){
			return $query->row_array();	
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
		$action = $this->db->delete($this->table);
		
		if($action){
			$this->db->where('id_group',$id);
			$this->db->delete('admin');	
		}
		
		return true;
	}
}