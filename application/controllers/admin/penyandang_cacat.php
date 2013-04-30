<?php

class Penyandang_cacat extends Controller
{
	
	function Penyandang_cacat()
	{
		parent::Controller();
		$this->load->model('penyandang_cacat_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->penyandang_cacat_model->get_data();
		$data['title'] = 'Pendidikan';
		$data['page'] = 'penyandang_cacat';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama penyandang cacat ','trim|required|alpha');
			
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
				redirect( site_url('admin/penyandang_cacat/add') );
				exit();	
			}
			else
			{
				$arr['penyandangcacat_nama'] = $this->input->post('nama');
				$arr['penyandangcacat_status'] = (int)$this->input->post('status');
				$save = $this->penyandang_cacat_model->save_data( $arr );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/penyandang_cacat/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah penyandang cacat';
		$data['page'] = 'add_penyandang_cacat';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama penyandang cacat','trim|required|alpha');
			
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
				redirect( site_url('admin/penyandang_cacat/add') );
				exit();	
			}
			else
			{
				$arr['penyandangcacat_nama'] = $this->input->post('nama');
				$arr['penyandangcacat_status'] = (int)$this->input->post('status');
				$save = $this->penyandang_cacat_model->save_data( $arr, $id );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/penyandang_cacat/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->penyandang_cacat_model->get_data($id);
		$data['title'] = 'Edit penyandang cacat';
		$data['page'] = 'edit_penyandang_cacat';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->penyandang_cacat_model->delete($id);
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
			redirect( site_url('admin/penyandang_cacat') );
			exit();
		}
	}
}
	