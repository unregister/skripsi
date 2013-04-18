<?php

class Login extends Controller
{
	
	function Login()
	{
		parent::Controller();
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
	}
	
	function index()
	{
		
		
		
		$data['title'] = 'Login Administrator';
		$data['page'] = 'login';
		$this->load->view('admin/layout_login', $data);
	}
	
	function do_login()
	{
		
		$val = $this->form_validation;
		
		if( isset($_POST['login']) )
		{
		
			$val->set_rules('username','Username','trim|required');
			$val->set_rules('password','Password','trim|required');
			$val->set_error_delimiters('<div class="error">', '</div>');
			
			if( $val->run() == false )
			{
				$this->session->set_flashdata('login_msg',validation_errors());
				redirect( site_url('admin/login') );
				exit();	
			}
			else
			{
				$username = $this->input->post('username',true);
				$password = md5($this->input->post('password',true));
				
				$login = $this->user_model->login($username,$password);
				
				if( !$login )
				{				
					$this->session->set_flashdata('login_msg','Username or password is invalid');
					redirect( site_url('admin/login') );
					exit();	
				}
				else
				{
					$this->user_model->set_session();
					redirect( site_url('admin/dashboard') );
					exit();
				}
				
			}
		}
		
	}
		
	function logout()
	{
		$this->session->unset_userdata('admin_login');
		redirect('admin/login');	
	}
}


