<?php

class Golongan_darah extends Controller
{
	
	function Golongan_darah()
	{
		parent::Controller();
		$this->load->model('golongan_darah_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->golongan_darah_model->get_data();
		$data['title'] = 'Golongan darah';
		$data['page'] = 'golongan_darah';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama golongan darah','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/golongan_darah/add') );
				exit();	
			}
			else
			{
				$arr['golongandarah_nama'] = $this->input->post('nama');
				$arr['golongandarah_status'] = (int)$this->input->post('status');
				$save = $this->golongan_darah_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/golongan_darah/add') );
					exit();
				}
			}
		}
		
		$data['title'] = 'Tambah golongan darah';
		$data['page'] = 'add_golongan_darah';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama golongan darah','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/golongan_darah/add') );
				exit();	
			}
			else
			{
				$arr['golongandarah_nama'] = $this->input->post('nama');
				$arr['golongandarah_status'] = (int)$this->input->post('status');
				$save = $this->golongan_darah_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/golongan_darah/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['id'] = $id;
		$data['result'] = $this->golongan_darah_model->get_data($id);
		$data['title'] = 'Edit golongan darah';
		$data['page'] = 'edit_golongan_darah';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->golongan_darah_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/golongan_darah') );
			exit();
		}
	}
}
	