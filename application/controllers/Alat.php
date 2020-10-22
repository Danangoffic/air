<?php
/**
 * 
 */
class Alat extends CI_Controller
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
		$this->API = "http://localhost/air";
		$this->load->model('Model_alat', 'alat');
		$this->load->library('curl');

	}

	public function index()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'index_alat', 'script'=>null, 'title' => 'Olah Data Alat', 'data_alat'=>$this->alat->get_all(), 'data_all_alat' => json_encode($this->curl->simple_get($this->API.'/alat')));
		$this->load->view('templates/layout', $page);
	}

	public function add()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'add_alat', 'script'=>null, 'title' => 'Tambah Data Alat');
		$this->load->view('templates/layout', $page);
	}

	public function edit($id_alat)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'edit_alat', 'script'=>null, 'title' => 'Tambah Data Alat', 'data'=>$this->alat->get_by($id_alat)->row(), 'id_alat' => $id_alat);
		$this->load->view('templates/layout', $page);
	}

	public function insert()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$nama_alat = $this->input->post('nama_alat');
		$array = array('nama_alat' => $nama_alat);
		$proses = $this->alat->insert($array);
		if($proses){
			$this->session->set_flashdata('success', 'Berhasil Tambah Data Alat');
			redirect('alat');
		}else{
			$this->session->set_flashdata('error', 'Gagal Tambah Data Alat');
			redirect('alat/add');
		}
	}

	public function update($id_alat)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$nama_alat = $this->input->post('nama_alat');
		$array = array('nama_alat' => $nama_alat);
		$proses = $this->alat->update($id_alat, $array);
		if($proses){
			$this->session->set_flashdata('success', 'Berhasil Ubah Data Alat');
			redirect('alat');
		}else{
			$this->session->set_flashdata('error', 'Gagal Ubah Data Alat');
			redirect('alat/edit/'.$id_alat);
		}
	}

	public function delete($id_alat=null)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if($id_alat===null){
			redirect(base_url('alat'));
		}
		$proses = $this->alat->delete($id_alat);
		if($proses){
			$this->session->set_flashdata('success', 'Berhasil Hapus Data Alat');
			redirect('alat');
		}else{
			$this->session->set_flashdata('error', 'Gagal Hapus Data Alat');
			redirect('alat/add');
		}
	}

}