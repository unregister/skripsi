<?php

function template_url()
{
	return base_url()."application/views/";	
}

function cek_login( $redirect = true )
{
	$ci =& get_instance();
	if( $ci->session->userdata('client_login') ){
		return true;	
	}else{
		if( $redirect ){
			header( 'location:'.site_url('main') );	
		}else{
			return false;	
		}
	}
}

function get_login( $str )
{
	$ci =& get_instance();
	$login = $ci->session->userdata('client_login');
	return $login[$str];	
}


function error($msg)
{
	return '<div class="alert alert-error"><a href="#" data-dismiss="alert" class="close">x</a><h4 class="alert-heading">Error</h4>'.$msg.'</div>';	
}

function success($msg)
{
	return '<div class="alert alert-success"><a href="#" data-dismiss="alert" class="close">x</a><h4 class="alert-heading">Success</h4>'.$msg.'</div>';	
}

function show_message()
{
	$ci =& get_instance();
	if( $ci->session->flashdata('_msg') ){
		echo $ci->session->flashdata('_msg');
	}
}



function pr($arr)
{
	echo '<pre>'.print_r($arr,1).'</pre>';
}

?>