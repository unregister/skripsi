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
}
	