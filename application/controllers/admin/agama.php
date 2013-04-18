<?php

class Agama extends Controller
{
	
	function Agama()
	{
		parent::Controller();
		$this->load->model('agama_model');
		cek_login();
	}
	
	function index()
	{
		$data['agama'] = $this->agama_model->get_data();
		$data['title'] = 'Agama';
		$data['page'] = 'agama';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama agama','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/agama/add') );
				exit();	
			}
			else
			{
				$arr['agama_nama'] = $this->input->post('nama');
				$arr['agama_status'] = (int)$this->input->post('status');
				$save = $this->agama_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/agama/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah agama';
		$data['page'] = 'add_agama';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama agama','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/agama/add') );
				exit();	
			}
			else
			{
				$arr['agama_nama'] = $this->input->post('nama');
				$arr['agama_status'] = (int)$this->input->post('status');
				$save = $this->agama_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/agama/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->agama_model->get_data($id);
		$data['title'] = 'Edit agama';
		$data['page'] = 'edit_agama';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->agama_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/agama') );
			exit();
		}
	}
}
	