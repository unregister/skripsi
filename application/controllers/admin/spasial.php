<?php

class Spasial extends Controller
{
	
	function Spasial()
	{
		parent::Controller();
		$this->load->model('spasial_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->spasial_model->get_data();
		$data['title'] = 'Spasial';
		$data['page'] = 'spasial';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('id_potensi','Id Potensi','trim|required');
			$this->form_validation->set_rules('id_kecamatan','Id Kecamatan','trim|required');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/spasial/add') );
				exit();	
			}
			else
			{
				$arr['id_potensi'] = $this->input->post('id_potensi');
				$arr['id_kecamatan'] = (int)$this->input->post('id_kecamatan');
				$arr['spasial_status'] = (int)$this->input->post('status');
				$arr['spasial_value'] = (int)$this->input->post('nilai');
				$spasial_id = $this->spasial_model->save_data( $arr );	
				if($spasial_id)
				{
					
					if( isset($_POST['latitude']) and isset($_POST['longitude'])  )
					{
						if( count($_POST['latitude']) > 0 and count($_POST['longitude']) > 0 )
						{
							for($i=0;$i<count($_POST['latitude']);$i++)
							{
								if( $_POST['latitude'][$i] != '' and $_POST['longitude'][$i] != '' )
								{
									$marker = array('id_spasial' => $spasial_id,'latitude' => $_POST['latitude'][$i],'longitude' => $_POST['longitude'][$i],'alamat' => $_POST['alamat'][$i]);
									$this->db->insert('marker',$marker);	
								}
							}
						}
					}
					
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/spasial/add') );
					exit();
				}
			}
		}
		$data['potensi'] = get_potensi();
		$data['kecamatan'] = get_kecamatan(true);
		$data['title'] = 'Tambah spasial';
		$data['page'] = 'add_spasial';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('id_potensi','Id Potensi','trim|required');
			$this->form_validation->set_rules('id_kecamatan','Id Kecamatan','trim|required');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/spasial/add') );
				exit();	
			}
			else
			{
				$arr['id_potensi'] = $this->input->post('id_potensi');
				$arr['id_kecamatan'] = (int)$this->input->post('id_kecamatan');
				$arr['spasial_status'] = (int)$this->input->post('status');
				$arr['spasial_value'] = (int)$this->input->post('nilai');
				$save = $this->spasial_model->save_data( $arr, $id );	
				if($save)
				{
					
					if( isset($_POST['latitude']) and isset($_POST['longitude'])  )
					{
						if( count($_POST['latitude']) > 0 and count($_POST['longitude']) > 0 )
						{
							$this->db->where('id_spasial',$id);
							$this->db->delete('marker');
							for($i=0;$i<count($_POST['latitude']);$i++)
							{
								if( $_POST['latitude'][$i] != '' and $_POST['longitude'][$i] != '' )
								{
									$marker = array('id_spasial' => $id,'latitude' => $_POST['latitude'][$i],'longitude' => $_POST['longitude'][$i],'alamat' => $_POST['alamat'][$i]);
									$this->db->insert('marker',$marker);	
								}
							}
						}
					}
					
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/spasial/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['marker'] = $this->spasial_model->get_marker($id);
		$data['potensi'] = get_potensi();
		$data['kecamatan'] = get_kecamatan(true);
		$data['id'] = $id;
		$data['result'] = $this->spasial_model->get_data($id);
		$data['title'] = 'Edit spasial';
		$data['page'] = 'edit_spasial';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->spasial_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/spasial') );
			exit();
		}
	}
	
	function satuan()
	{
		$id  = $_POST['id'];
		
		$this->db->where('id_potensi',$id);
		$run = $this->db->get('potensi') -> row_array();
		
		if( $run['potensi_parent'] == 0 )
		{
			switch($id)
			{
				case '1':
					$satuan = ' Ekor';
				break;
				case '2':
					$satuan = ' Kilogram';
				break;
				case '3':
					$satuan = ' Meter';
				break;
				case '4':
					$satuan = ' Kilogram';
				break;
				case '5':
					$satuan = ' Lokasi';
				break;
				case '6':
					$satuan = ' Lokasi';
				break;
				case '8':
					$satuan = ' SIUP';
				break;
				case '69':
					$satuan = ' Lokasi';
				break;
				case '70':
					$satuan = ' Lokasi';
				break;	
			}
		}
		else
		{
			$this->db->where('id_potensi',$run['id_potensi']);
			$runs = $this->db->get('potensi') -> row_array();
			//pr($runs);
			switch($runs['potensi_parent'])
			{
				case '1':
					$satuan = ' Ekor';
				break;
				case '2':
					$satuan = ' Kilogram';
				break;
				case '3':
					$satuan = ' Meter';
				break;
				case '4':
					$satuan = ' Kilogram';
				break;
				case '5':
					$satuan = ' Lokasi';
				break;
				case '6':
					$satuan = ' Lokasi';
				break;
				case '8':
					$satuan = ' SIUP';
				break;
				case '69':
					$satuan = ' Lokasi';
				break;
				case '70':
					$satuan = ' Lokasi';
				break;	
			}
		}
		echo $satuan;
	}
}
	