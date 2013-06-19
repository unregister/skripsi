<?php

class Dashboard extends Controller
{
	function Dashboard()
	{
		parent::Controller();
		cek_login();
	}
	
	function index()
	{
		$data['title'] = 'Beranda';
		$data['page'] = 'dashboard';
		$this->load->view('admin/layout_main',$data);
	}
	
	function grafik()
	{
		
	}
	
	function request()
	{		
		
		//$page = file_get_contents( 'http://localhost/skripsi/admin/kecamatan' );
		$url=$_POST['page'];
							
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);				
		$html = curl_exec($curl);
		curl_close ($curl);

		
		$data['page'] = $html;
		echo json_encode($data);
		die;
	}
}
	