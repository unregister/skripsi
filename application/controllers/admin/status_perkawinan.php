<?php

class Status_perkawinan extends Controller
{
	
	function Status_perkawinan()
	{
		parent::Controller();
		$this->load->model('status_perkawinan_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->status_perkawinan_model->get_data();
		$data['title'] = 'Pendidikan';
		$data['page'] = 'status_perkawinan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama status perkawinan ','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/status_perkawinan/add') );
				exit();	
			}
			else
			{
				$arr['statusperkawinan_nama'] = $this->input->post('nama');
				$arr['statusperkawinan_status'] = (int)$this->input->post('status');
				$save = $this->status_perkawinan_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/status_perkawinan/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah status perkawinan';
		$data['page'] = 'add_status_perkawinan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama status perkawinan','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/status_perkawinan/add') );
				exit();	
			}
			else
			{
				$arr['statusperkawinan_nama'] = $this->input->post('nama');
				$arr['statusperkawinan_status'] = (int)$this->input->post('status');
				$save = $this->status_perkawinan_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/status_perkawinan/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->status_perkawinan_model->get_data($id);
		$data['title'] = 'Edit status perkawinan';
		$data['page'] = 'edit_status_perkawinan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->status_perkawinan_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/status_perkawinan') );
			exit();
		}
	}
}
	