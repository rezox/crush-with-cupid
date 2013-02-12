<?php

function is_logged_in()
{
	$CI =& get_instance();
	$CI->load->library('fb');
	$CI->load->library('session');

	if ($CI->fb->is_logged_in() && $CI->session->userdata('user'))
   		return true;

   	return false;
}

function get_auth_url($uri)
{
	$CI =& get_instance();
	$CI->load->library('fb');

	return $CI->fb->get_auth_url(site_url($uri));
}

function get_app_id()
{
	$CI =& get_instance();
	$CI->load->library('fb');

	return $CI->fb->get_app_id();
}