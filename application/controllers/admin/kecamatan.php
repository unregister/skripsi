<?php

class Kecamatan extends Controller
{
	function Kecamatan()
	{
		parent::Controller();
		$this->load->model('kecamatan_model');
		$this->load->library('form_validation');
		cek_login();
	}
	
	function index()
	{
		//pr( $this->session->userdata('admin_login') );
		$data['kecamatan'] = $this->kecamatan_model->get_kecamatan();
		$data['title'] = 'Kecamatan';
		$data['page'] = 'kecamatan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama kecamatan','trim|required|alpha');
			$this->form_validation->set_rules('latitude','Koordinat latitude kecamatan','trim|required|callback_koordinat_cek');
			$this->form_validation->set_rules('longitude','Koordinat longitude kecamatan','trim|required|callback_koordinat_cek');	
			$this->form_validation->set_rules('luas','Luas kecamatan','trim|required|numeric');
			$this->form_validation->set_message('koordinat_cek','Koordinat hanya boleh berupa angka, tanda "-" dan tanda "."');
			$this->form_validation->set_message('numeric','Luas wilayah hanya boleh berupa angka');
			
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
				redirect( site_url('admin/kecamatan/add') );
				exit();	
			}
			else
			{
				$arr['kecamatan_name'] = $this->input->post('nama');
				$arr['kecamatan_latitude'] = $this->input->post('latitude');
				$arr['kecamatan_longitude'] = $this->input->post('longitude');
				$arr['kecamatan_luas'] = $this->input->post('luas');
				$save = $this->kecamatan_model->save_data( $arr );	
				if($save)
				{
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/kecamatan/add') );
					exit();
					
				}
			}
		}
		
		$data['title'] = 'Tambah Kecamatan';
		$data['page'] = 'add_kecamatan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$kecamatan_id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nama','Nama kecamatan','trim|required|alpha');
			$this->form_validation->set_rules('latitude','Koordinat latitude kecamatan','trim|required|callback_koordinat_cek');
			$this->form_validation->set_rules('longitude','Koordinat longitude kecamatan','trim|required|callback_koordinat_cek');
			$this->form_validation->set_rules('luas','Luas kecamatan','trim|required|numeric');	
			$this->form_validation->set_message('koordinat_cek','Koordinat hanya boleh berupa angka, tanda "-" dan tanda "."');
			$this->form_validation->set_message('numeric','Luas wilayah hanya boleh berupa angka');
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
				redirect( site_url('admin/kecamatan/edit/'.$kecamatan_id) );
				exit();	
			}
			else
			{
				$arr['kecamatan_name'] = $this->input->post('nama');
				$arr['kecamatan_latitude'] = $this->input->post('latitude');
				$arr['kecamatan_longitude'] = $this->input->post('longitude');
				$arr['kecamatan_luas'] = $this->input->post('luas');
				$save = $this->kecamatan_model->save_data( $arr, $kecamatan_id );	
				if($save){
					if( $_POST['ajax'] == '1' )
					{
						$msg['msg'] = success('Data berhasil disimpan');
						echo json_encode($msg);
						die();
					}
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/kecamatan/edit/'.$kecamatan_id) );
					exit();
				}
			}
		}
		
		$data['kecamatan_id'] = $kecamatan_id;
		$data['edit_kecamatan'] = $this->kecamatan_model->get_kecamatan($kecamatan_id);
		$data['title'] = 'Edit kecamatan';
		$data['page'] = 'edit_kecamatan';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$kecamatan_id = $this->uri->segment(4,0);
		$delete = $this->kecamatan_model->delete($kecamatan_id);
		if($delete){
			if( $_POST['ajax'] == '1' )
			{
				$msg['status'] = 1;
				$msg['msg'] = success('Data berhasil dihapus');
				echo json_encode($msg);
				die();
			}
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/kecamatan') );
			exit();
		}
	}
	
	function koordinat_cek($val)
	{
		if( !preg_match('#[0-9\.\-]#',$val) ){
			return false;	
		}
		return true;
	}
	
	function getdata()
	{
			
	}
	
}
	