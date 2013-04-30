<?php

class User extends Controller
{
	
	function User()
	{
		parent::Controller();
		$this->load->model('user_model');

	}
	
	function index()
	{
		$data['result'] = $this->user_model->get_data();
		$data['title'] = 'Data user';
		$data['page'] = 'user';
		$this->load->view('admin/layout_main', $data);
	}
	
	function add()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('username','Username','trim|required|callback__cek_username');
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('group_id','Grup','trim|required');
			$this->form_validation->set_rules('nama','Nama','trim|required');
			
			$this->form_validation->set_message('_cek_username','Username sudah ada');
			
			if( $this->form_validation->run() == false )
			{
				$msg = array();
				if( $_POST['ajax'] == '1' )
				{
					$msg['msg'] = error(validation_errors());
					echo json_encode($msg);
					die();
				}
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/user/add') );
				exit();	
			}
			else
			{
				$arr['username'] = $this->input->post('username');
				$arr['password'] = md5($this->input->post('password'));
				$arr['id_group'] = $this->input->post('group_id');
				$arr['admin_nama'] = $this->input->post('nama');
				$arr['admin_status'] = (int)$this->input->post('status');
				$save = $this->user_model->save_data( $arr );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/user/add') );
					exit();
				}
			}
		}
		
		$data['group'] = $this->_get_groups();
		//$data['kecamatan'] = $this->_get_kecamatan();
		//$data['result'] = $this->user_model->get_data($id);
		$data['title'] = 'Tambah user';
		$data['page'] = 'add_user';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('username','Username','trim|required');
			$this->form_validation->set_rules('group_id','Grup','trim|required');
			$this->form_validation->set_rules('nama','Nama','trim|required');
			
			//$this->form_validation->set_message('_cek_username','Username sudah ada');
			
			if( $this->form_validation->run() == false )
			{
				$msg = array();
				if( $_POST['ajax'] == '1' )
				{
					$msg['msg'] = error(validation_errors());
					echo json_encode($msg);
					die();
				}
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/user/edit/'.$id) );
				exit();	
			}
			else
			{
				$arr['username'] = $this->input->post('username');
				if( isset($_POST['password']) and !empty($_POST['password']) ){
					$arr['password'] = md5($this->input->post('password'));
				}
				$arr['id_group'] = $this->input->post('group_id');
				$arr['admin_nama'] = $this->input->post('nama');
				$arr['admin_status'] = (int)$this->input->post('status');
				$save = $this->user_model->save_data( $arr,$id );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/user/edit/'.$id) );
					exit();
				}
			}
		}
		$data['group'] = $this->_get_groups();
		$data['id'] = $id;
		$data['result'] = $this->user_model->get_data($id);
		$data['title'] = 'Edit user';
		$data['page'] = 'edit_user';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->user_model->delete($id);
		if($delete)
		{
			if( $_POST['ajax'] == '1' )
			{
				$msg['status'] = 1;
				$msg['msg'] = success('Data berhasil dihapus');
				echo json_encode($msg);
				die();
			}
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/user') );
			exit();
		}
	}
	
	function _cek_username( $str )
	{
		if( empty($str) ){
			return false;	
		}
		
		$this->db->where('username',$str);
		$query = $this->db->get('admin');
		if($query->num_rows() > 0){
			return false;	
		}
		return true;		
	}
	
	function _get_groups()
	{
		$query = $this->db->query("SELECT * FROM admin_group");
		return $query->result_array();
	}
	
	function _get_kecamatan()
	{
		$query = $this->db->query("SELECT * FROM kecamatan");
		return $query->result_array();
	}
	
	function _cekpass($pas)
	{
		$pass = md5($pas);
		$this->db->where('id_admin',get_login('id_admin'));
		$this->db->select('password');	
		$run = $this->db->get('admin') -> row_array();
		
		if( $run['password'] != $pass ){
			return false;	
		}
		
		return true;
	}
	
	function password()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('old_password','Password lama','trim|required|callback__cekpass');
			$this->form_validation->set_rules('new_password','Password baru','trim|required');
			$this->form_validation->set_rules('ret_password','Password ulangi','trim|required|matches[new_password]');
			
			$this->form_validation->set_message('_cekpass','Password lama Anda tidak sesuai');
			//$this->form_validation->set_message('matches','Password lama Anda tidak sesuai');
			
			if( $this->form_validation->run() == false )
			{
				$msg = array();
				if( $_POST['ajax'] == '1' )
				{
					$msg['msg'] = error(validation_errors());
					echo json_encode($msg);
					die();
				}
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/user/password') );
				exit();	
			}
			else
			{
				$password = md5($this->input->post('new_password'));
				$save = $this->user_model->change_password( $password );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Password berhasil diubah'));
					redirect( site_url('admin/user/password') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Ubah password';
		$data['page'] = 'password';
		$this->load->view('admin/layout_main', $data);
	}
	
}


