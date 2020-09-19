<?php
/**
 * 
 */
class Klasifikasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_klasifikasi', 'klasifikasi');
	}

	public function index()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'v_klasifikasi', 'title'=>"Klasifikasi Air", 'script'=>null, 'data' => $this->klasifikasi->get_all());
		$this->load->view('templates/layout', $page);
	}

	public function add()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}

		$page = array(
			'page' => 'v_add_klasifikasi',
			'title' => 'Tambah Klasifikasi Air',
			'script' => null);
		$this->load->view('templates/layout', $page);
	}

	public function edit($id)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array(
			'page' => 'v_edit_klasifikasi',
			'title' => 'Ubah Data Klasifikasi Air',
			'script' => null,
			'data' => $this->klasifikasi->get_by($id)->row());
		$this->load->view('templates/layout', $page);
	}

	public function insert()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$jenis_klasifikasi = $this->input->post('jenis_klasifikasi');
		$data = array('nama_klasifikasi' => $jenis_klasifikasi);
		$insert = $this->klasifikasi->insert($data);
		if($insert){
			$this->session->set_flashdata('success', 'Berhasil Tambahkan Data Klasifikasi Air');
			redirect(base_url('klasifikasi'));
		}else{
			$this->session->set_flashdata('error', 'Gagal Tambahkan Data Klasifikasi Air');
			redirect(base_url('klasifikasi/add'));
		}
	}

	public function update()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$id_klasifikasi = $this->input->post('id_klasifikasi');
		$nama = $this->input->post('jenis_klasifikasi');
		$data = array('nama_klasifikasi' => $nama);
		$update = $this->klasifikasi->update($id_klasifikasi, $data);
		if($update){
			$this->session->set_flashdata('success', 'Berhasil Ubah Data Klasifikasi Air');
			redirect(base_url('klasifikasi'));
		}else{
			$this->session->set_flashdata('error', 'Gagal Ubah Data Klasifikasi Air');
			redirect(base_url('klasifikasi/add'));
		}
	}
}