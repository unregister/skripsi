<?php

class Group extends Controller
{
	
	function Group()
	{
		parent::Controller();
		$this->load->model('group_model');

	}
	
	function index()
	{
		$data['result'] = $this->group_model->get_data();
		$data['title'] = 'Data group';
		$data['page'] = 'group';
		$this->load->view('admin/layout_main', $data);
	}
	
	function add()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama','trim|required');
			
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
				redirect( site_url('admin/group/add') );
				exit();	
			}
			else
			{				
				$arr['nama_group'] = $this->input->post('nama');
				$arr['id_kecamatan'] = $this->input->post('kecamatan');
				$save = $this->group_model->save_data( $arr );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/group/add') );
					exit();
				}
			}
		}
		
		$kec = $this->_get_kecamatan();
		$arrkec = array();
		$arrkec['all'] = 'Semua kecamatan';
		foreach((array)$kec as $k){
			$arrkec[$k['kecamatan_id']] = $k['kecamatan_name'];	
		}
		
		$data['kecamatan'] = $arrkec;
		$data['title'] = 'Tambah group';
		$data['page'] = 'add_group';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama','trim|required');
			
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
				redirect( site_url('admin/group/edit/'.$id) );
				exit();	
			}
			else
			{
				$arr['nama_group'] = $this->input->post('nama');
				$arr['id_kecamatan'] = $this->input->post('kecamatan');

				$save = $this->group_model->save_data( $arr,$id );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/group/edit/'.$id) );
					exit();
				}
			}
		}
		
		$kec = $this->_get_kecamatan();
		$arrkec = array();
		$arrkec['all'] = 'Semua kecamatan';
		foreach((array)$kec as $k){
			$arrkec[$k['kecamatan_id']] = $k['kecamatan_name'];	
		}
		
		$data['kecamatan'] = $arrkec;
		$data['id'] = $id;
		$data['result'] = $this->group_model->get_data($id);
		$data['title'] = 'Edit group';
		$data['page'] = 'edit_group';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->group_model->delete($id);
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
			redirect( site_url('admin/group') );
			exit();
		}
	}
	
	function access()
	{
		$group_id = (int)$this->uri->segment(4,0);
		$single = array('primary'=>'id_group','field'=>'nama_group','table'=>'admin_group','id'=>$group_id);
		
		$this->db->where('id_group',$group_id);
		$rows = $this->db->get('admin_menu_group') -> result_array();
		
		$rowmenu = array();
		foreach((array)$rows as $ro)
		{
			$rowmenu[$ro['id_menu']] = $ro['id_menu'];
		}

		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			if( isset($_POST['access']) and count($_POST['access']) > 0 )
			{
				$this->db->where('id_group',$group_id);
				$this->db->delete('admin_menu_group');
				$_POST['access'][] = 1;
				$_POST['access'][] = 80;
				foreach((array)$_POST['access'] as $key=>$val)
				{
					$this->db->insert('admin_menu_group', array('id_group'=>$group_id,'id_menu'=>$val));
				}
			}
			
			$msg = array();
			if( $_POST['ajax'] == '1' )
			{
				$msg['msg'] = error(validation_errors());
				echo json_encode($msg);
				die();
			}
			$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
			redirect( site_url('admin/group/access/'.$group_id) );
		}
		
		
		$data['rowmenu'] = $rowmenu;
		$data['menu'] = get_menu();
		$data['nama_group'] = single_data($single);
		$data['title'] = 'Edit hak akses';
		$data['page'] = 'access_group';
		$this->load->view('admin/layout_main',$data);	
	}
	
	function _get_kecamatan()
	{
		$query = $this->db->query("SELECT * FROM kecamatan");
		return $query->result_array();
	}
	
	
	
}


