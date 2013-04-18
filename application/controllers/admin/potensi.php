<?php

class Potensi extends Controller
{
	
	function Potensi()
	{
		parent::Controller();
		$this->load->model('potensi_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->potensi_model->get_potensi();
		$data['title'] = 'Potensi';
		$data['page'] = 'potensi';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama potensi','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/potensi/add') );
				exit();	
			}
			else
			{
				$arr['potensi_nama'] = $this->input->post('nama');
				$arr['potensi_parent'] = $this->input->post('parent');
				$arr['potensi_status'] = (int)$this->input->post('status');
				
				if( isset($_FILES['icon']) and $_FILES['icon']['name'] != '' )
				{
					move_uploaded_file($_FILES['icon']['tmp_name'],APPPATH."views/public/icon/"	.$_FILES['icon']['name']);
					$arr['potensi_icon'] = $_FILES['icon']['name'];

				}
				
				
				$save = $this->potensi_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/potensi/add') );
					exit();
				}
			}
		}
		
		$parent = array();
		$parent[0] = 'Tanpa parent';
		$par = $this->potensi_model->get_potensi(0);
		foreach((array)$par as $row)
		{
			$parent[$row['id_potensi']] = $row['potensi_nama'];
		}
		
		$data['parent'] = $parent;
		$data['title'] = 'Tambah potensi';
		$data['page'] = 'add_potensi';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nama','Nama potensi','trim|required|alpha');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/potensi/add') );
				exit();	
			}
			else
			{
				$arr['potensi_nama'] = $this->input->post('nama');
				$arr['potensi_parent'] = $this->input->post('parent');
				$arr['potensi_status'] = (int)$this->input->post('status');
				
				if( isset($_FILES['icon']) and $_FILES['icon']['name'] != '' )
				{
					if( isset($_POST['img_icon']) and $_POST['img_icon'] != '' )
					{
						@unlink(APPPATH."views/public/icon/".$_POST['img_icon']);	
					}
					move_uploaded_file($_FILES['icon']['tmp_name'],APPPATH."views/public/icon/"	.$_FILES['icon']['name']);
					$arr['potensi_icon'] = $_FILES['icon']['name'];

				}
				
				$save = $this->potensi_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/potensi/edit/'.$id) );
					exit();
				}
			}
		}
		$par = $this->potensi_model->get_potensi(0);
		$parent[0] = 'Tanpa parent';
		foreach((array)$par as $row)
		{
			$parent[$row['id_potensi']] = $row['potensi_nama'];
		}
		
		$data['parent'] = $parent;
		$data['id'] = $id;
		$data['result'] = $this->potensi_model->get_data($id);
		$data['title'] = 'Edit potensi';
		$data['page'] = 'edit_potensi';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->potensi_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/potensi') );
			exit();
		}
	}
	
	function sub()
	{
		$id = $this->uri->segment(4,0);
		$data['result'] = $this->potensi_model->get_potensi($id);
		$data['title'] = 'Potensi';
		$data['page'] = 'potensi';
		$this->load->view('admin/layout_main',$data);
	}
}
