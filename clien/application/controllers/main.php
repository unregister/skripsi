<?php

class Main extends Controller 
{
	
	var $request;
	var $error;
	var $kecamatan_id;
	
	function Main()
	{
		parent::Controller();
		$server_url = $this->config->item('server_url');
		$this->load->library('Nusoap_lib');
		$this->request = new nusoap_client( $server_url );
		$this->error = $this->request->getError();
		$this->kecamatan_id = get_login('id_kecamatan');
	}
	
	function index()
	{
		if( isset($_POST['login']) )
		{
			$this->form_validation->set_rules('username','Username','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			if( $this->form_validation->run() == false ){
				$this->session->set_flashdata('_msg','<div class="error">'.validation_errors().'</div>');
				redirect( site_url('main') );
				exit();	
			}else{
				$username = $this->input->post('username');
				$password = $this->input->post('password');	
				$request = $this->request->call('getSOAPLogin',array( $username,$password) );
				$result = json_decode($request,1);
				if( !empty($result) )
				{
					//if( $result )
					$this->session->set_userdata('client_login',$result);	
					redirect( site_url('main/dashboard') );
					exit();	
				}else{
					$this->session->set_flashdata('_msg','<div class="error">Username atau password tidak benar</div>');
					redirect( site_url('main') );
				}
			}
		}
		$this->load->view('layout_login');
	}
	
	function dashboard()
	{
		cek_login();

		$result = $this->request->call('getSOAPPersonByKecamatan',array($this->kecamatan_id));
		$kecamatan = $this->request->call('getSOAPKecamatan');
		
		$data['kecamatan'] = json_decode($kecamatan,1);
		$data['result'] = json_decode($result,1);
		$data['title'] = 'Data Penduduk';
		$data['page'] = 'person';
		$this->load->view('layout_main',$data);
	}
	
	function add()
	{
		cek_login();
		$data['current_kecamatan']	= get_login('id_kecamatan');
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nourut','Nomor urut','trim|required|numeric');
			$this->form_validation->set_rules('nama','Nama person','trim|required|alpha');
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
			
			if( $_POST['tglcerai'] == 1 ){
				$this->form_validation->set_rules('aktacerai','Akta cerai','trim|required|max_length[16]');
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
				$msg = array();
				if( $_POST['ajax'] == '1' )
				{
					$msg['msg'] = error(validation_errors());
					echo json_encode($msg);
					die();
				}
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('main/add') );
				exit();	
			}
			else
			{
				$arr['person_nomorurut'] 				= $this->input->post('nourut');
				$arr['person_namalengkap'] 				= $this->input->post('nama');
				$arr['id_kecamatan'] 					= $data['current_kecamatan'];
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
				
				$arrdata = json_encode($arr);
				$request = json_decode( $this->request->call( 'getSOAPInsertPerson',array($arrdata) ),1);
				if( !empty($request) ){
					$this->session->set_flashdata('_msg',$request['msg']);
					redirect( site_url('main/add') );
					exit();
				}
			}
		}
		
		$requestKecamatan 			= $this->request->call('getSOAPKecamatan');
		$requestAgama 				= $this->request->call('getSOAPAgama');
		$requestPenyandangCacat 	= $this->request->call('getSOAPPenyandangCacat');
		$requestGolonganDarah 		= $this->request->call('getSOAPGolonganDarah');
		$requestStatusPerkawinan 	= $this->request->call('getSOAPStatusPerkawinan');
		$requestPekerjaan 			= $this->request->call('getSOAPPekerjaan');
		$requestPendidikan 			= $this->request->call('getSOAPPendidikan');
		
		$data['kecamatan'] 			= json_decode($requestKecamatan,1);
		$data['agama'] 				= json_decode($requestAgama,1);
		$data['penyandangcacat'] 	= json_decode($requestPenyandangCacat,1);
		$data['golongandarah'] 		= json_decode($requestGolonganDarah,1);
		$data['statusperkawinan'] 	= json_decode($requestStatusPerkawinan,1);
		$data['pekerjaan'] 			= json_decode($requestPekerjaan,1);
		$data['pendidikan'] 		= json_decode($requestPendidikan,1);
		
		$data['title'] = 'Tambah penduduk';
		$data['page'] = 'add_person';
		$this->load->view('layout_main',$data);
	}
	
	function edit()
	{
		cek_login();
		$id = $this->uri->segment(3,0);
		$data['current_kecamatan']	= get_login('id_kecamatan');
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('nourut','Nomor urut','trim|required|numeric');
			$this->form_validation->set_rules('nama','Nama person','trim|required');
			$this->form_validation->set_rules('agama','Agama','trim|required');
			$this->form_validation->set_rules('perkawinan','Status perkawinan','trim|required');
			$this->form_validation->set_rules('penyandangcacat','Penyandang cacat','trim|required');
			$this->form_validation->set_rules('golongandarah','Golongan darah','trim|required');
			$this->form_validation->set_rules('pekerjaan','Pekerjaan','trim|required');
			$this->form_validation->set_rules('pendidikan','Pendidikan','trim|required');
			$this->form_validation->set_rules('noktp','Nomor KTP','trim|required|max_length[16]');
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
			
			if( $_POST['tglcerai'] == 1 ){
				$this->form_validation->set_rules('aktacerai','Akta cerai','trim|required|max_length[16]');
			}
			
			$this->form_validation->set_rules('nikibu','NIK Ibu','trim|required');
			$this->form_validation->set_rules('namaibu','Nama lengkap ibu','trim|required');
			$this->form_validation->set_rules('nikayah','NIK Ayah','trim|required');
			$this->form_validation->set_rules('namaayah','Nama lengkap ayah','trim|required');
			$this->form_validation->set_rules('namart','Nama ketua RT','trim|required');
			$this->form_validation->set_rules('namarw','Nama ketua RW','trim|required');
			
			/*$this->form_validation->set_message('cekKtp','No KTP sudah ada');
			$this->form_validation->set_message('cekNikIbu','NIK Ibu sudah ada');
			$this->form_validation->set_message('cekNikAyah','NIK Ayah sudah ada');
			$this->form_validation->set_message('cekAktaNikah','No Akta Nikah sudah ada');
			$this->form_validation->set_message('cekAktaLahir','No Akta Lahir sudah ada');
			*/
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
				redirect( site_url('main/edit/'.$id) );
				exit();	
			}
			else
			{
				$arr['person_nomorurut'] 				= $this->input->post('nourut');
				$arr['person_namalengkap'] 				= $this->input->post('nama');
				$arr['id_kecamatan'] 					= $data['current_kecamatan'];
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
				
				$arrdata = json_encode($arr);
				$request = json_decode( $this->request->call( 'getSOAPUpdatePerson',array($id,$arrdata) ),1);
				if( !empty($request) ){
					$this->session->set_flashdata('_msg',$request['msg']);
					redirect( site_url('main/edit/'.$id) );
					exit();
				}
			}
		}
		
		$requestPerson				= $this->request->call('getSOAPPersonById',array($id));
		$requestKecamatan 			= $this->request->call('getSOAPKecamatan');
		$requestAgama 				= $this->request->call('getSOAPAgama');
		$requestPenyandangCacat 	= $this->request->call('getSOAPPenyandangCacat');
		$requestGolonganDarah 		= $this->request->call('getSOAPGolonganDarah');
		$requestStatusPerkawinan 	= $this->request->call('getSOAPStatusPerkawinan');
		$requestPekerjaan 			= $this->request->call('getSOAPPekerjaan');
		$requestPendidikan 			= $this->request->call('getSOAPPendidikan');
		
		
		$data['kecamatan'] 			= json_decode($requestKecamatan,1);
		$data['agama'] 				= json_decode($requestAgama,1);
		$data['penyandangcacat'] 	= json_decode($requestPenyandangCacat,1);
		$data['golongandarah'] 		= json_decode($requestGolonganDarah,1);
		$data['statusperkawinan'] 	= json_decode($requestStatusPerkawinan,1);
		$data['pekerjaan'] 			= json_decode($requestPekerjaan,1);
		$data['pendidikan'] 		= json_decode($requestPendidikan,1);
		$data['result']				= json_decode($requestPerson,1);
		$data['id']					= $id;
		
		$data['title'] = 'Edit penduduk';
		$data['page'] = 'edit_person';
		$this->load->view('layout_main',$data);
	}
	
	function detail()
	{
		cek_login();
		$id = $this->uri->segment(3,0);
		$requestPerson				= $this->request->call('getSOAPPersonById',array($id));
		$requestKecamatan 			= $this->request->call('getSOAPKecamatan');
		$requestAgama 				= $this->request->call('getSOAPAgama');
		$requestPenyandangCacat 	= $this->request->call('getSOAPPenyandangCacat');
		$requestGolonganDarah 		= $this->request->call('getSOAPGolonganDarah');
		$requestStatusPerkawinan 	= $this->request->call('getSOAPStatusPerkawinan');
		$requestPekerjaan 			= $this->request->call('getSOAPPekerjaan');
		$requestPendidikan 			= $this->request->call('getSOAPPendidikan');
		
		$data['kecamatan'] 			= json_decode($requestKecamatan,1);
		$data['agama'] 				= json_decode($requestAgama,1);
		$data['penyandangcacat'] 	= json_decode($requestPenyandangCacat,1);
		$data['golongandarah'] 		= json_decode($requestGolonganDarah,1);
		$data['statusperkawinan'] 	= json_decode($requestStatusPerkawinan,1);
		$data['pekerjaan'] 			= json_decode($requestPekerjaan,1);
		$data['pendidikan'] 		= json_decode($requestPendidikan,1);
		$data['result']				= json_decode($requestPerson,1);
		
		$data['title'] = 'Detail penduduk';
		$data['page'] = 'detail_person';
		$this->load->view('layout_main',$data);
	}
	
	function delete()
	{
		cek_login();
		$id = $this->uri->segment(3,0);
		$request = $this->request->call('getSOAPDeletePerson',array($id));
		$result = json_decode($request,true);
		if( !empty($result) )
		{
			if($result['status'] == 1)
			{
				$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			}else{
				$this->session->set_flashdata('_msg',error('Data gagal dihapus'));
			}
			redirect( site_url('main/dashboard') );
			exit();
		}
	}
	
	function spasial()
	{
		cek_login();
		$potensi = $this->request->call('getSOAPPotensi', array($combo = 1) );
		$potensi = json_decode($potensi,1);		
		
		$request = $this->request->call('getSOAPSpasial',array($this->kecamatan_id));
		$result = json_decode($request,true);
		
		$requestKecamatan 	= $this->request->call('getSOAPKecamatan');
		$kecamatan = json_decode($requestKecamatan,true);
		
		$data['kecamatan'] = $kecamatan;
		$data['potensi'] = $potensi;
		$data['result'] = $result;
		$data['title'] = 'Data spasial';
		$data['page'] = 'spasial';
		$this->load->view('layout_main',$data);
	}
	
	
	function add_spasial()
	{
		cek_login();
		$requestKecamatan 	= $this->request->call('getSOAPKecamatan');
		$kecamatan = json_decode($requestKecamatan,true);
		
		$potensi = $this->request->call('getSOAPPotensi', array($combo = "") );
		$potensi = json_decode($potensi,1);
		
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('id_potensi','Id Potensi','trim|required');
			$this->form_validation->set_rules('nilai','Value','trim|required');
			$this->form_validation->set_rules('latitude[]','Latitude','trim|required');
			$this->form_validation->set_rules('longitude[]','Longitude','trim|required');
			$this->form_validation->set_rules('alamat[]','Alamat','trim|required');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('main/add_spasial') );
				exit();	
			}
			else
			{
				
				$arr['id_potensi'] = $this->input->post('id_potensi');
				$arr['id_kecamatan'] = (int)$this->kecamatan_id;
				$arr['spasial_status'] = (int)$this->input->post('status');
				$arr['spasial_value'] = (int)$this->input->post('nilai');
				
				$arrdata = json_encode($arr);
				$request = $this->request->call('getSOAPInsertSpasial',array($arrdata));
				$result = json_decode($request,true);
				
				#pr($result);
				
				$spasial_id = $result['id_spasial'];
				if($spasial_id)
				{
					$marker = array();
					if( isset($_POST['latitude']) and isset($_POST['longitude'])  )
					{
						if( count($_POST['latitude']) > 0 and count($_POST['longitude']) > 0 )
						{
							for($i=0;$i<count($_POST['latitude']);$i++)
							{
								if( $_POST['latitude'][$i] != '' and $_POST['longitude'][$i] != '' )
								{
									$marker[] = array('id_spasial' => $spasial_id,'latitude' => $_POST['latitude'][$i],'longitude' => $_POST['longitude'][$i],'alamat' => $_POST['alamat'][$i]);
									
								}
							}
							$marker = json_encode($marker);
							$request = $this->request->call('getSOAPInsertMarker',array($marker));
						}
					}	
					
					$this->session->set_flashdata('_msg',$result['msg']);
					redirect( site_url('main/add_spasial') );
					exit();
				}
			}
		}
		
	
		$data['kecamatan'] = $kecamatan[$this->kecamatan_id];
		$data['potensi'] = $potensi;
		$data['title'] = 'Tambah spasial';
		$data['page'] = 'add_spasial';
		$this->load->view('layout_main',$data);
	}
	
	function edit_spasial()
	{
		cek_login();
		$id = $this->uri->segment(3,0);
		$marker = $this->request->call('getSOAPGetMarker', array($id) );
		$marker = json_decode($marker,1);
		
		$spasial = $this->request->call('getSOAPSpasialById', array($id) );
		$spasial = json_decode($spasial,1);
		
		$potensi = $this->request->call('getSOAPPotensi', array($combo = "") );
		$potensi = json_decode($potensi,1);
		
		$requestKecamatan 	= $this->request->call('getSOAPKecamatan');
		$kecamatan = json_decode($requestKecamatan,true);
		
		if( isset($_POST['save_data'])  or isset($_POST['ajax']) )
		{
			$this->form_validation->set_rules('id_potensi','Id Potensi','trim|required');
			$this->form_validation->set_rules('nilai','Value','trim|required');
			$this->form_validation->set_rules('latitude[]','Latitude','trim|required');
			$this->form_validation->set_rules('longitude[]','Longitude','trim|required');
			$this->form_validation->set_rules('alamat[]','Alamat','trim|required');
			
			if( $this->form_validation->run() == false )
			{
				$this->session->set_flashdata('_msg', error(validation_errors()));
				redirect( site_url('main/edit_spasial/'.$id) );
				exit();	
			}
			else
			{
				
				$arr['id_potensi'] = $this->input->post('id_potensi');
				$arr['id_kecamatan'] = (int)$this->kecamatan_id;
				$arr['spasial_status'] = (int)$this->input->post('status');
				$arr['spasial_value'] = (int)$this->input->post('nilai');
				
				$arrdata = json_encode($arr);
				$request = $this->request->call('getSOAPUpdateSpasial',array($id,$arrdata));
				$result = json_decode($request,true);
				
				pr($result);
				
				$spasial_id = $id;
				$status = $result['status'];
				if($status == 1)
				{
					$marker = array();
					if( isset($_POST['latitude']) and isset($_POST['longitude'])  )
					{
						if( count($_POST['latitude']) > 0 and count($_POST['longitude']) > 0 )
						{
							$this->request->call('getSOAPDeleteMarker',array($spasial_id));
							for($i=0;$i<count($_POST['latitude']);$i++)
							{
								if( $_POST['latitude'][$i] != '' and $_POST['longitude'][$i] != '' )
								{
									$marker[] = array('id_spasial' => $spasial_id,'latitude' => $_POST['latitude'][$i],'longitude' => $_POST['longitude'][$i],'alamat' => $_POST['alamat'][$i]);
									
								}
							}
							$marker = json_encode($marker);
							$request = $this->request->call('getSOAPInsertMarker',array($marker));
						}
					}	
					
					$this->session->set_flashdata('_msg',$result['msg']);
					redirect( site_url('main/edit_spasial/'.$id) );
					exit();
				}
			}
		}
		
		$data['result'] = $spasial;
		$data['marker'] = $marker;
		$data['spasial'] = $spasial;
		$data['kecamatan'] = $kecamatan[$this->kecamatan_id];
		$data['potensi'] = $potensi;
		$data['title'] = 'Ubah data spasial';
		$data['page'] = 'edit_spasial';
		$this->load->view('layout_main',$data);
		
	}
	
	function delete_spasial()
	{
		cek_login();
		$id = $this->uri->segment(3,0);
		$request = $this->request->call('getSOAPDeleteSpasial',array($id));
		$result = json_decode($request,true);
		if( !empty($result) )
		{
			if($result['status'] == 1)
			{
				$this->session->set_flashdata('_msg',success('Data berhasil dihapus'));
			}else{
				$this->session->set_flashdata('_msg',error('Data gagal dihapus'));
			}
			redirect( site_url('main/spasial') );
			exit();
		}
	}
	
	function logout()
	{
		$this->session->unset_userdata('client_login');
		redirect('main');
		exit();	
	}
	
	function cekKtp($i)
	{
		$request = $this->request->call('getSOAPCekData',array($i,'person_ktp'));
		$result = json_decode($request,1);
		if( $result['status'] == 1 ){
			return false;	
		}
		return true;
	}
	
	function cekNikAyah($i)
	{
		$request = $this->request->call('getSOAPCekData',array($i,'person_nikayah'));
		$result = json_decode($request,1);
		if( $result['status'] == 1 ){
			return false;	
		}
		return true;
	}
	
	function cekNikIbu($i)
	{
		$request = $this->request->call('getSOAPCekData',array($i,'person_nikibu'));
		$result = json_decode($request,1);
		if( $result['status'] == 1 ){
			return false;	
		}
		return true;
	}
	
	function cekAktaLahir($i)
	{
		$request = $this->request->call('getSOAPCekData',array($i,'person_nomoraktalahir'));
		$result = json_decode($request,1);
		if( $result['status'] == 1 ){
			return false;	
		}
		return true;
	}
	
	function cekAktaNikah($i)
	{
		$request = $this->request->call('getSOAPCekData',array($i,'person_nomoraktanikah'));
		$result = json_decode($request,1);
		if( $result['status'] == 1 ){
			return false;	
		}
		return true;
	}
	
	function satuan()
	{
		$id  = $_POST['id'];
		
		#$this->db->where('id_potensi',$id);
		#$run = $this->db->get('potensi') -> row_array();
		
		$request = $this->request->call('getSOAPPotensiById',array($id));
		$run = json_decode($request,1);

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
			#$this->db->where('id_potensi',$run['id_potensi']);
			#$runs = $this->db->get('potensi') -> row_array();
			
			$request = $this->request->call('getSOAPPotensiById',array($run['id_potensi']));
			$runs = json_decode($request,1);

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

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */