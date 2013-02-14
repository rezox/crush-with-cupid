<?php
/**
 * Look at routes for more information.
 */
class Pages extends CI_Controller {

	function display($page)
	{
		$this->load->view('include/header');
		$this->load->view($page);
		$this->load->view('include/facebook');
		$this->load->view('include/footer');

		$this->output->cache(1440);
	}

}