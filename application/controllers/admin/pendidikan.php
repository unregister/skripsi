<?php

class Pendidikan extends Controller
{
	
	function Pendidikan()
	{
		parent::Controller();
		$this->load->model('pendidikan_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->pendidikan_model->get_data();
		$data['title'] = 'Pendidikan';
		$data['page'] = 'pendidikan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama pendidikan','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/pendidikan/add') );
				exit();	
			}
			else
			{
				$arr['pendidikan_nama'] = $this->input->post('nama');
				$arr['pendidikan_status'] = (int)$this->input->post('status');
				$save = $this->pendidikan_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/pendidikan/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah pendidikan';
		$data['page'] = 'add_pendidikan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama pendidikan','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/pendidikan/add') );
				exit();	
			}
			else
			{
				$arr['pendidikan_nama'] = $this->input->post('nama');
				$arr['pendidikan_status'] = (int)$this->input->post('status');
				$save = $this->pendidikan_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/pendidikan/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->pendidikan_model->get_data($id);
		$data['title'] = 'Edit pendidikan';
		$data['page'] = 'edit_pendidikan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->pendidikan_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/pendidikan') );
			exit();
		}
	}
}
	