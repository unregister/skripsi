<?php

class Person extends Controller
{
	
	function Person()
	{
		parent::Controller();
		$this->load->model('person_model');
		cek_login();
	}
	
	function index()
	{
		$data['result'] = $this->person_model->get_data();
		$data['title'] = 'Person';
		$data['page'] = 'person';
		$this->load->view('admin/layout_main',$data);
	}
	
	function add()
	{
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nourut','Nomor urut','trim|required|numeric');
			$this->form_validation->set_rules('nama','Nama person','trim|required|alpha');
			$this->form_validation->set_rules('kecamatan','Kecamatan','trim|required');
			$this->form_validation->set_rules('agama','Agama','trim|required');
			$this->form_validation->set_rules('perkawinan','Status perkawinan','trim|required');
			$this->form_validation->set_rules('penyandangcacat','Penyandang cacat','trim|required');
			$this->form_validation->set_rules('golongandarah','Golongan darah','trim|required');
			$this->form_validation->set_rules('pekerjaan','Pekerjaan','trim|required');
			$this->form_validation->set_rules('pendidikan','Pendidikan','trim|required');
			$this->form_validation->set_rules('noktp','Nomor KTP','trim|required|max_length[16]|callback_cekKtp');
			if( isset($_POST['nopaspor']) and !empty($_POST['nopaspor']) ){
				$this->form_validation->set_rules('nopaspor','Nomor paspor','trim|required|max_length[7]');
				$this->form_validation->set_rules('endpaspor','Tanggal berakhir paspor','trim|required');
			}
			$this->form_validation->set_rules('gender','Jenis kelamin','trim|required');
			$this->form_validation->set_rules('tmplahir','Tempat lahir','trim|required');
			$this->form_validation->set_rules('tgllahir','Tanggal lahir','trim|required');
			if( $_POST['aktalahir'] == 1 ){
				$this->form_validation->set_rules('noaktalahir','Nomor akta lahir','trim|required|max_length[12]|alpha_numeric|callback_cekAktaLahir');
			}
			if( $_POST['perkawinan'] == 4 ){
				$this->form_validation->set_rules('aktanikah','Akta nikah','trim|required');
				$this->form_validation->set_rules('noaktanikah','Nomor akta nikah','trim|required|max_length[14]|callback_cekAktaNikah');
				$this->form_validation->set_rules('tglnikah','Tanggal nikah','trim|required');
			}
			
			if( $_POST['perkawinan'] == 2 or $_POST['perkawinan'] == 3 ){
				$this->form_validation->set_rules('aktacerai','Akta cerai','trim|required|max_length[16]');
				$this->form_validation->set_rules('tglcerai','Tanggal cerai','trim|required');
			}
			
			$this->form_validation->set_rules('nikibu','NIK Ibu','trim|required|callback_cekNikIbu');
			$this->form_validation->set_rules('namaibu','Nama lengkap ibu','trim|required');
			$this->form_validation->set_rules('nikayah','NIK Ayah','trim|required|callback_cekNikAyah');
			$this->form_validation->set_rules('namaayah','Nama lengkap ayah','trim|required');
			$this->form_validation->set_rules('namart','Nama ketua RT','trim|required');
			$this->form_validation->set_rules('namarw','Nama ketua RW','trim|required');
			
			$this->form_validation->set_message('cekKtp','No KTP sudah ada');
			$this->form_validation->set_message('cekNikIbu','NIK Ibu sudah ada');
			$this->form_validation->set_message('cekNikAyah','NIK Ayah sudah ada');
			$this->form_validation->set_message('cekAktaNikah','No Akta Nikah sudah ada');
			$this->form_validation->set_message('cekAktaLahir','No Akta Lahir sudah ada');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/person/add') );
				exit();	
			}
			else
			{
				$arr['person_nomorurut'] 				= $this->input->post('nourut');
				$arr['person_namalengkap'] 				= $this->input->post('nama');
				$arr['id_kecamatan'] 					= $this->input->post('kecamatan');
				$arr['id_agama'] 						= $this->input->post('agama');
				$arr['id_statusperkawinan'] 			= $this->input->post('perkawinan');
				$arr['id_penyandangcacat'] 				= ($this->input->post('ispenyandangcacat')==1)?$this->input->post('penyandangcacat'):0;
				$arr['id_golongandarah'] 				= $this->input->post('golongandarah');
				$arr['person_penyandangcacat'] 			= $this->input->post('ispenyandangcacat');
				$arr['id_pekerjaan'] 					= $this->input->post('pekerjaan');
				$arr['id_pendidikan'] 					= $this->input->post('pendidikan');
				$arr['person_ktp'] 						= $this->input->post('noktp');
				$arr['person_nomorpasspor'] 			= $this->input->post('nopaspor');
				$arr['person_tanggalberakhirpasspor'] 	= $this->input->post('endpaspor');
				$arr['person_jeniskelamin'] 			= $this->input->post('gender');
				$arr['person_tempatlahir'] 				= $this->input->post('tmplahir');
				$arr['person_tanggallahir'] 			= $this->input->post('tgllahir');
				$arr['person_aktalahir'] 				= $this->input->post('aktalahir');
				$arr['person_nomoraktalahir'] 			= $this->input->post('noaktalahir');
				$arr['person_aktanikah'] 				= $this->input->post('aktanikah');
				$arr['person_nomoraktanikah'] 			= $this->input->post('noaktanikah');
				$arr['person_tanggalkawin'] 			= $this->input->post('tglnikah');
				$arr['person_aktacerai'] 				= $this->input->post('aktacerai');
				$arr['person_tanggalcerai'] 			= $this->input->post('tglcerai');
				$arr['person_nikibu'] 					= $this->input->post('nikibu');
				$arr['person_namalengkapibu'] 			= $this->input->post('namaibu');
				$arr['person_nikayah'] 					= $this->input->post('nikayah');
				$arr['person_namalengkapayah'] 			= $this->input->post('namaayah');
				$arr['person_namaketua_rt'] 			= $this->input->post('namart');
				$arr['person_namakertua_rw'] 			= $this->input->post('namarw');
				$arr['person_status'] 					= (int)$this->input->post('status');
				
				$save = $this->person_model->save_data( $arr );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/person/add') );
					exit();
				}
			}
		}
		$data['kecamatan'] = get_kecamatan(true);
		$data['agama'] = get_agama(1,true);
		$data['penyandangcacat'] = get_penyandangcacat(1,true);
		$data['golongandarah'] = get_golongandarah(1,true);
		$data['statusperkawinan'] = get_statusperkawinan(1,true);
		$data['pekerjaan'] = get_pekerjaan(1,true);
		$data['pendidikan'] = get_pendidikan(1,true);
		$data['title'] = 'Tambah person';
		$data['page'] = 'add_person';
		$this->load->view('admin/layout_main',$data);
	}
	
	function edit()
	{
		$id = $this->uri->segment(4,0);
		
		if( isset($_POST['save_data']) )
		{
			$this->form_validation->set_rules('nourut','Nomor urut','trim|required|numeric');
			$this->form_validation->set_rules('nama','Nama person','trim|required|alpha');
			$this->form_validation->set_rules('kecamatan','Kecamatan','trim|required');
			$this->form_validation->set_rules('agama','Agama','trim|required');
			$this->form_validation->set_rules('perkawinan','Status perkawinan','trim|required');
			$this->form_validation->set_rules('penyandangcacat','Penyandang cacat','trim|required');
			$this->form_validation->set_rules('golongandarah','Golongan darah','trim|required');
			$this->form_validation->set_rules('pekerjaan','Pekerjaan','trim|required');
			$this->form_validation->set_rules('pendidikan','Pendidikan','trim|required');
			$this->form_validation->set_rules('noktp','Nomor KTP','trim|required');
			if( isset($_POST['nopaspor']) and !empty($_POST['nopaspor']) ){
				$this->form_validation->set_rules('nopaspor','Nomor paspor','trim|required|max_length[7]');
				$this->form_validation->set_rules('endpaspor','Tanggal berakhir paspor','trim|required');
			}
			$this->form_validation->set_rules('gender','Jenis kelamin','trim|required');
			$this->form_validation->set_rules('tmplahir','Tempat lahir','trim|required');
			$this->form_validation->set_rules('tgllahir','Tanggal lahir','trim|required');
			if( $_POST['aktalahir'] == 1 ){
				$this->form_validation->set_rules('noaktalahir','Nomor akta lahir','trim|required|max_length[12]|alpha_numeric');
			}
			if( $_POST['perkawinan'] == 4 ){
				$this->form_validation->set_rules('aktanikah','Akta nikah','trim|required');
				$this->form_validation->set_rules('noaktanikah','Nomor akta nikah','trim|required|max_length[14]');
				$this->form_validation->set_rules('tglnikah','Tanggal nikah','trim|required');
			}
			
			if( $_POST['perkawinan'] == 2 or $_POST['perkawinan'] == 3 ){
				$this->form_validation->set_rules('aktacerai','Akta cerai','trim|required|max_length[16]');
				$this->form_validation->set_rules('tglcerai','Tanggal cerai','trim|required');
			}
			
			$this->form_validation->set_rules('nikibu','NIK Ibu','trim|required');
			$this->form_validation->set_rules('namaibu','Nama lengkap ibu','trim|required');
			$this->form_validation->set_rules('nikayah','NIK Ayah','trim|required');
			$this->form_validation->set_rules('namaayah','Nama lengkap ayah','trim|required');
			$this->form_validation->set_rules('namart','Nama ketua RT','trim|required');
			$this->form_validation->set_rules('namarw','Nama ketua RW','trim|required');
			
			//$this->form_validation->set_message('cekKtp','No KTP sudah ada');
			//$this->form_validation->set_message('cekNikIbu','NIK Ibu sudah ada');
			//$this->form_validation->set_message('cekNikAyah','NIK Ayah sudah ada');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('admin/person/edit/'.$id) );
				exit();	
			}
			else
			{
				$arr['person_nomorurut'] 				= $this->input->post('nourut');
				$arr['person_namalengkap'] 				= $this->input->post('nama');
				$arr['id_kecamatan'] 					= $this->input->post('kecamatan');
				$arr['id_agama'] 						= $this->input->post('agama');
				$arr['id_statusperkawinan'] 			= $this->input->post('perkawinan');
				$arr['id_penyandangcacat'] 				= ($this->input->post('ispenyandangcacat')==1)?$this->input->post('penyandangcacat'):0;
				$arr['person_penyandangcacat'] 			= $this->input->post('ispenyandangcacat');
				$arr['id_golongandarah'] 				= $this->input->post('golongandarah');
				$arr['id_pekerjaan'] 					= $this->input->post('pekerjaan');
				$arr['id_pendidikan'] 					= $this->input->post('pendidikan');
				$arr['person_ktp'] 						= $this->input->post('noktp');
				$arr['person_nomorpasspor'] 			= $this->input->post('nopaspor');
				$arr['person_tanggalberakhirpasspor'] 	= $this->input->post('endpaspor');
				$arr['person_jeniskelamin'] 			= $this->input->post('gender');
				$arr['person_tempatlahir'] 				= $this->input->post('tmplahir');
				$arr['person_tanggallahir'] 			= $this->input->post('tgllahir');
				$arr['person_aktalahir'] 				= $this->input->post('aktalahir');
				$arr['person_nomoraktalahir'] 			= $this->input->post('noaktalahir');
				$arr['person_aktanikah'] 				= $this->input->post('aktanikah');
				$arr['person_nomoraktanikah'] 			= $this->input->post('noaktanikah');
				$arr['person_tanggalkawin'] 			= $this->input->post('tglnikah');
				$arr['person_aktacerai'] 				= $this->input->post('aktacerai');
				$arr['person_tanggalcerai'] 			= $this->input->post('tglcerai');
				$arr['person_nikibu'] 					= $this->input->post('nikibu');
				$arr['person_namalengkapibu'] 			= $this->input->post('namaibu');
				$arr['person_nikayah'] 					= $this->input->post('nikayah');
				$arr['person_namalengkapayah'] 			= $this->input->post('namaayah');
				$arr['person_namaketua_rt'] 			= $this->input->post('namart');
				$arr['person_namakertua_rw'] 			= $this->input->post('namarw');
				$arr['person_status'] 					= (int)$this->input->post('status');
				
				$save = $this->person_model->save_data( $arr, $id );	
				if($save){
					$this->session->set_flashdata('_msg',success('Data berhasil disimpan'));
					redirect( site_url('admin/person/edit/'.$id) );
					exit();
				}
			}
		}
		
		$data['kecamatan'] = get_kecamatan(true);
		$data['agama'] = get_agama(1,true);
		$data['penyandangcacat'] = get_penyandangcacat(1,true);
		$data['golongandarah'] = get_golongandarah(1,true);
		$data['statusperkawinan'] = get_statusperkawinan(1,true);
		$data['pekerjaan'] = get_pekerjaan(1,true);
		$data['pendidikan'] = get_pendidikan(1,true);
		$data['id'] = $id;
		$data['result'] = $this->person_model->get_data($id);
		$data['title'] = 'Edit person';
		$data['page'] = 'edit_person';
		$this->load->view('admin/layout_main',$data);
	}
	
	function detail()
	{
		$id = $this->uri->segment(4,0);
		$data['kecamatan'] = get_kecamatan(true);
		$data['agama'] = get_agama(1,true);
		$data['penyandangcacat'] = get_penyandangcacat(1,true);
		$data['golongandarah'] = get_golongandarah(1,true);
		$data['statusperkawinan'] = get_statusperkawinan(1,true);
		$data['pekerjaan'] = get_pekerjaan(1,true);
		$data['pendidikan'] = get_pendidikan(1,true);
		$data['result'] = $this->person_model->get_data($id);
		$data['title'] = 'Detail person';
		$data['page'] = 'detail_person';
		$this->load->view('admin/layout_main',$data);
	}
	
	function delete()
	{
		$id = $this->uri->segment(4,0);
		$delete = $this->person_model->delete($id);
		if($delete)
		{
			$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			redirect( site_url('admin/person') );
			exit();
		}
	}
	
	function cekKtp($i)
	{
		$this->db->where('person_ktp',$i);
		$run = $this->db->get('person') -> num_rows();
		if($run > 0){
			return false;	
		}
		return true;
	}
	
	function cekNikAyah($i)
	{
		$this->db->where('person_nikayah',$i);
		$run = $this->db->get('person') -> num_rows();
		if($run > 0){
			return false;	
		}
		return true;
	}
	
	function cekNikIbu($i)
	{
		$this->db->where('person_nikibu',$i);
		$run = $this->db->get('person') -> num_rows();
		if($run > 0){
			return false;	
		}
		return true;
	}
	
	function cekAktaLahir($i)
	{
		$this->db->where('person_nomoraktalahir',$i);
		$run = $this->db->get('person') -> num_rows();
		if($run > 0){
			return false;	
		}
		return true;
	}
	
	function cekAktaNikah($i)
	{
		$this->db->where('person_nomoraktanikah',$i);
		$run = $this->db->get('person') -> num_rows();
		if($run > 0){
			return false;	
		}
		return true;
	}
	
	
	
}
	