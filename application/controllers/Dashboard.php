<?php
/**
 * 
 */
class Dashboard extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->has_userdata("username")){
			if($this->session->userdata('user_class')=="penguji"){
				$this->session->set_flashdata("error", "Bukan halaman untuk kelas pengguna " . $this->session->userdata("user_class"));
				redirect(base_url('pengujian'));
			}
		}else{
			redirect(base_url());
		}
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