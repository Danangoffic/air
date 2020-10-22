<?php
/**
 * 
 */
class Users extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_users', 'user');
	}

	public function index()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if($this->session->userdata('user_class')!=='admin'){
			redirect(base_url());
		}
	}

	public function login()
	{
		if($this->session->userdata('username')){
			redirect(base_url());
		}
		$page = array('title' => 'Login');
		$this->load->view('login', $page);
	}

	public function sign_in()
	{
		if(empty($this->input->post('username'))){
			$this->session->set_flashdata('error', 'Username Kosong, harap diisi');
			redirect(base_url('users/login'));
		}
		if(empty($this->input->post('password'))){
			$this->session->set_flashdata('error', 'Password Kosong, harap diisi');
			redirect(base_url('users/login'));
		}
		$username = $this->input->post('username', TRUE);
		$password = md5($this->input->post('password', TRUE));
		$where = array('username' => $username, 'password' => $password);
		$cek = $this->user->getByUsernameAndPassword($username,$password);
		if($cek->num_rows() > 0){
			$data = $cek->row();
			$this->session->set_userdata($cek->row_array());
			// $set_data = array('username' => $data->username,'user_class' => $data->user_class, 'id_user' => $data->id_user);
			// $this->session->set_userdata($set_data);
			$this->session->set_flashdata('success', 'Anda Berhasil Login');
			$userclass = $data->user_class;
			if($userclass=="penguji"){
				redirect(base_url('pengujian'));
			}elseif($userclass=="admin"){
				redirect(base_url());
			}else{
				redirect(base_url());
			}
			
		}else{
			$error = $this->db->error();
			$this->session->set_flashdata('error', 'Login gagal, Username / Password yang anda masukkan salah');
			redirect(base_url('users/login'));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function add()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
	}

	public function detail($id_user=null)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if($this->session->userdata('user_class')!=='admin'){
			redirect(base_url());
		}
		if($id_user==null){
			redirect(base_url('users'));
		}
	}

	public function edit($id_user)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
	}

	public function insert()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
	}

	public function update()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
	}

	public function delete($id_user)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
	}

	public function createUser()
	{
		# code...
		$username = $this->input->post("username", TRUE);
		$password = $this->generatePassword();
		$user_class = $this->input->post("user_class", TRUE);
		$array_insert = array('username' => $username, 'password' => $password, 'user_class' => $user_class);
		$insert = $this->user->insert_user($array_insert);
		if($insert){
			$user = $this->user->getUserByUsername($username)->row_array();
			$user['encrypted_password'] = $password;
			response(201, array('data' => $user, 'statusMessage' => "success create"));
		}
	}

	public function generatePassword()
	{
		# code...
		$password = $this->input->post("password", TRUE);
		$newPassword = md5($password);
		return $newPassword;
	}
}