<?php
class Latih extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata("username")) {
			if ($this->session->userdata('user_class') != "admin") {
				$this->session->set_flashdata("error", "Bukan halaman untuk kelas pengguna " . $this->session->userdata("user_class"));
				redirect(base_url());
			}
		} else {
			redirect(base_url());
		}
		$this->load->model('Model_klasifikasi', 'klasifikasi');
		$this->load->model("Model_latih");
		$this->load->model('Model_air');
	}

	public function index()
	{
		$data_latih = $this->Model_latih->findAll();
		$data_klasifikasi = $this->klasifikasi->get_all();
		$page = array('page' => 'index_latih', 'title' => "Data latih", 'script' => null, 'data_latih' => $data_latih, 'data_klasifikasi' => $data_klasifikasi);
		$this->load->view('templates/layout', $page);
	}

	public function add()
	{
		$data_klasifikasi = $this->klasifikasi->get_all();
		$page = array('page' => 'add_latih', 'title' => "Tambah Data latih", 'script' => null, 'data_klasifikasi' => $data_klasifikasi);
		$this->load->view('templates/layout', $page);
	}

	public function insert()
	{
		$data_klasifikasi = $this->klasifikasi->get_all();
		$input_user = $this->input->post();
		$array_insert = array();
		foreach ($data_klasifikasi->result() as $key) {
			$new = strtolower($key->nama_klasifikasi);
			$array_insert[$new] = $input_user[$new];
		}
		$array_insert['target'] = $input_user['target'];
		$insert = $this->Model_latih->insert($array_insert);
		if ($insert) {
			$this->session->set_flashdata("success", "Sukses tambahkan data latih");
			redirect(base_url('Latih'));
		} else {
			$this->session->set_flashdata("error", "Gagal tambahkan data latih");
			redirect(base_url('Latih/add'));
		}
	}

	public function delete($id_data_latih)
	{
		$delete = $this->Model_latih->delete($id_data_latih);
		if ($delete) {
			$this->session->set_flashdata("success", "Sukses Hapus data latih");
			redirect(base_url('Latih'));
		} else {
			$this->session->set_flashdata("error", "Gagal Hapus data latih");
			redirect(base_url('Latih/add'));
		}
	}

	public function edit($id_latih)
	{
		# code...
		$data_klasifikasi = $this->klasifikasi->get_all();
		$detail = $this->Model_latih->getByIdLatih($id_latih);
		$page = array('page' => 'edit_latih', 'title' => "Uabh Data latih", 'script' => null, 'data_klasifikasi' => $data_klasifikasi, 'detail' => $detail->row());
		$this->load->view('templates/layout', $page);
	}

	public function update()
	{
		# code...
		$id_latih = $this->input->post("id_data_latih");
		$data = $this->Model_latih->getByIdLatih($id_latih);
		if ($data->num_rows() > 0) {
			$updateArray = $this->input->post();
			$update = $this->Model_latih->update($updateArray, $id_latih);
			if ($update) {
				$this->session->set_flashdata("success", "Sukses Ubah data latih");
				redirect(base_url('Latih'));
			} else {
				$this->session->set_flashdata("error", "Gagal Ubah data latih");
				redirect(base_url('Latih/edit/' . $id_latih));
			}
		}
	}
}
