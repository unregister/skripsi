<?php

class Pekerjaan extends Controller
{
	
	function Pekerjaan()
	{
		parent::Controller();
		$this->load->model('pekerjaan_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->pekerjaan_model->get_data();
		$data['title'] = 'Pekerjaan';
		$data['page'] = 'pekerjaan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama pekerjaan','trim|required|alpha');
			
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
				redirect( site_url('admin/pekerjaan/add') );
				exit();	
			}
			else
			{
				$arr['pekerjaan_nama'] = $this->input->post('nama');
				$arr['pekerjaan_status'] = (int)$this->input->post('status');
				$save = $this->pekerjaan_model->save_data( $arr );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/pekerjaan/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah pekerjaan';
		$data['page'] = 'add_pekerjaan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama pekerjaan','trim|required|alpha');
			
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
				redirect( site_url('admin/pekerjaan/add') );
				exit();	
			}
			else
			{
				$arr['pekerjaan_nama'] = $this->input->post('nama');
				$arr['pekerjaan_status'] = (int)$this->input->post('status');
				$save = $this->pekerjaan_model->save_data( $arr, $id );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/pekerjaan/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->pekerjaan_model->get_data($id);
		$data['title'] = 'Edit pekerjaan';
		$data['page'] = 'edit_pekerjaan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->pekerjaan_model->delete($id);
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
			redirect( site_url('admin/pekerjaan') );
			exit();
		}
	}
}
	