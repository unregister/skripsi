<?php

class User_model extends Model
{
	var $table;
	var $primary;
	var $logindata;
	
	function User_model()
	{
		parent::Model();
		$this->table = 'admin';
		$this->primary = 'id_admin';
	}
	
	function login($username,$password)
	{
		if( empty($username) or empty($password) ){
			return false;	
		}
		
		$where = array('username' => $username, 'password' => $password);
		$this->db->where( $where );
		$query = $this->db->get( $this->table );
		
		if( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			$this->logindata = $row;
			
			return $this->logindata;	
		}
		else
		{
			return false;	
		}
		
	}
	
	function set_session()
	{
		if( empty($this->logindata) ){
			return false;	
		}
		
		$login = $this->logindata;
		$setsession = $this->session->set_userdata('admin_login',$login);
		if( $setsession ){
			return true;	
		}else{
			return false;	
		}
	}
	
	function get_data( $id = null )
	{
		$where = "";
		if( $id != null )
		{
			$where = " WHERE a.id_admin = $id ";
		}
		$sql = "SELECT a.*,g.nama_group FROM admin a LEFT JOIN admin_group g ON(a.id_group=g.id_group) $where";
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
		return $this->db->delete($this->table);
	}
	
	function change_password($newpassword)
	{
		$id = get_login('id_admin');
		$pass = $newpassword;
		$this->db->where('id_admin',$id);
		return $this->db->update('admin',array('password' => $pass));	
	}
}