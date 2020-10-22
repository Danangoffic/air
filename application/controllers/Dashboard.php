<?php
/**
 * 
 */
class Dashboard extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'dashboard', 'title'=>"Dashboard", 'script'=>null);
		$this->load->view('templates/layout', $page);
	}
}