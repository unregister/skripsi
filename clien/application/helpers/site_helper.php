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

function array_path_potensi($data, $par_id = 0, $separate = '#', $prefix = '&nbsp;')
{
	$output = array();
	$count = 1;
	foreach((array)$data AS $dt)
	{
		if($dt['potensi_parent'] == $par_id)
		{
			$text = ($par_id==0) ? "<strong>".$prefix.$dt['potensi_nama']."</strong>" : $prefix.$separate.' '.$dt['potensi_nama'];
			$to_replace = $dt['potensi_nama'];
			$output[$dt['id_potensi']] = $text;
			$r = array_path_potensi($data, $dt['id_potensi'], $separate, $text);
			if(!empty($r)) {
				foreach($r AS $i => $j){

					if( strpos($j,$separate) ){
						$ex = explode($separate,$j);
						$count = count($ex);
						$j = $ex[$count-1];
					}

					$output[$i] = str_repeat('-',$count).''.str_replace($separate,'',$j);
				}
			}
		}
	}
	
	return $output;
}

function createTreeOption($arr, $select = '', $name = 'parent_id')
{
	$output = "<select name=\"".$name."\">\n";
	if( $select == 0 ){
		$sel = ' selected="selected"';
	}else{
		$sel = '';
	}
	$valueiskey	= $check_first = false;
	foreach((array)$arr AS $key => $dt){
		if(is_array($dt)){
			list($value, $caption) = array_values($dt);
			if(empty($caption)) $caption = $value;
		}else{
			if(!$check_first) {
				if((is_numeric($key) && $key != 0) || (is_string($key) && !is_numeric($key)))
					$valueiskey = true;
				$check_first = true;
			}
			if(empty($dt) && !empty($key)) $dt = $key;
			$value = $valueiskey ? $key : $dt;
			$caption = $dt;
		}
		if(isset($select)){
			if(is_array($select)) $selected = (in_array($value, $select)) ? ' selected="selected"':'';
			else    $selected = ($value==$select) ? ' selected="selected"':'';
		}else{
			$selected = '';
		}
		$output .= "<option value=\"$value\"$selected>|$caption</option>\n";
	}
	$output .= "</select>\n";
	return $output;
}

function pr($arr)
{
	echo '<pre>'.print_r($arr,1).'</pre>';
}

?>