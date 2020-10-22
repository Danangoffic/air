<?php
/**
 * 
 */
class Air extends CI_Controller
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
		$this->load->model('Model_air', 'air');
		$this->load->model('Model_klasifikasi', 'klasifikasi');
		$this->load->model('Model_rule_klasifikasi_air', 'rule_klasifikasi');
	}

	public function index()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'index_air', 'script'=>null, 'title' => 'Olah Data Air', 'data_air'=>$this->air->get_all());
		$this->load->view('templates/layout', $page);
	}

	public function add()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$page = array('page'=>'add_air', 'script'=>null, 'title' => 'Tambah Data Air', 'data_klasifikasi' => $this->klasifikasi->get_all());
		$this->load->view('templates/layout', $page);	
	}

	public function insert()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$array_data = array();
		$nama_air = $this->input->post('nama_air');
		$data_air = array('kategori_jenis' => $nama_air);
		$insert_air = $this->air->insert($data_air);
		if($insert_air){
			$last_id = $this->air->get_last_air()->row()->id_jenis;
			$klasifikasi = $this->input->post('klasifikasi');
			$id_klasifikasi = $this->input->post('id_klasifikasi');
			for($i=1; $i<=count($klasifikasi); $i++){
				$bobot = $klasifikasi[$i-1];
				$idKlasifikasi = $id_klasifikasi[$i-1];
				$new_data = array('id_air'=>$last_id, 'id_klasifikasi' => $idKlasifikasi, 'bobot' => $bobot);
				array_push($array_data,$new_data);
			}
			$insert_rule_air = $this->rule_klasifikasi->insert_batch($array_data);
			if($insert_rule_air){
				$this->session->set_flashdata('success', 'Berhasil tambahkan data klasifikasi air');
				redirect(base_url("air"));
			}else{
				$this->session->set_flashdata('error', 'Gagal tambahkan data klasifikasi air');
				redirect(base_url("air/add"));
			}
		}else{
			$this->session->set_flashdata('error', 'Gagal tambahkan data klasifikasi air');
			redirect(base_url("air/add"));
		}
	}

	public function detail($id_jenis=null){
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if($id_jenis!==null){
			$detail_air = $this->air->detail($id_jenis)->row();
			$detail_rule_klasifikasi = $this->rule_klasifikasi->detail_by_id_jenis_air($id_jenis);
			$nama_air = $detail_air->kategori_jenis;
			$title = "Detail Air " . $nama_air;
			$page = array('page' => 'detail_air', 'script' => null, 'title' => $title, 'nama_air' => $nama_air, 'detail_air' => $detail_air, 'detail_data' => $detail_rule_klasifikasi);
			return $this->load->view('templates/layout', $page);
		}else{
			redirect(base_url());
		}
		
	}

	public function edit($id_air)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		if($id_air!==null){
			$detail_air = $this->air->detail($id_air)->row();
			$detail_rule_klasifikasi = $this->rule_klasifikasi->detail_by_id_jenis_air($id_air);
			$nama_air = $detail_air->kategori_jenis;
			$title = "Edit Air " . $nama_air;
			$page = array('page' => 'edit_air', 'script' => null, 'title' => $title, 'nama_air' => $nama_air, 'detail_air' => $detail_air, 'detail_data' => $detail_rule_klasifikasi);
			return $this->load->view('templates/layout', $page);
		}else{
			redirect(base_url());
		}
	}

	public function update()
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$id_jenis = $this->input->post('id_jenis');
		$array_data = array();
		$nama_air = $this->input->post('nama_air');
		$data_air = array('kategori_jenis' => $nama_air);
		try {
			$update_air = $this->air->update($data_air, $id_jenis);
			if($update_air){
				$klasifikasi = $this->input->post('klasifikasi');
				$id_rule = $this->input->post('id_rule');
				for($i=1; $i<=count($klasifikasi); $i++){
					$bobot = $klasifikasi[$i-1];
					$new_data = array('bobot' => $bobot);
					$where = array('id_rule' => $id_rule[$i-1]);
					// $this->db->start_cache();
					$update_rule_air = $this->rule_klasifikasi->update_rule($where, $new_data);
					// $this->db->stop_cache();
					$this->db->reset_query();
					// array_push($array_data,$new_data);
				}
				// $this->db->flush_cache();
				// $update_rule_air = $this->rule_klasifikasi->update_batch($id_jenis, $array_data);
				if($update_rule_air){
					$this->session->set_flashdata('success', 'Berhasil Ubah data klasifikasi air');
					redirect(base_url("air/"));
				}else{
					$this->session->set_flashdata('error', 'Gagal Ubah data klasifikasi air');
					redirect(base_url("air/edit/".$id_jenis));
				}
			}else{
				$this->session->set_flashdata('error', 'Gagal Ubah data klasifikasi air');
				redirect(base_url("air/edit/".$id_jenis));
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Gagal Ubah data klasifikasi air ' . $e);
			redirect(base_url("air/edit/".$id_jenis));
		}
		

	}

	public function delete($id_air)
	{
		if(!$this->session->userdata('username')){
			redirect(base_url('users/login'));
		}
		$where = array('id_air' => $id_air);
		try {
			$delete_rule = $this->rule_klasifikasi->delete_rule($where);
			if($delete_rule){
				$where2 = array('id_jenis', $id_air);
				$delete_jenis_air = $this->air->delete_air($where2);
				if($delete_jenis_air){
					$this->session->set_flashdata('success', 'Berhasil Hapus Data Air');
					redirect(base_url('air'));
				}else{
					$this->session->set_flashdata('error', 'Gagal Hapus Data Air');
					redirect(base_url('air'));
				}
			}else{
				$this->session->set_flashdata('error', 'Gagal Hapus Data Air');
				redirect(base_url('air'));
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Gagal Hapus Data Air ' . $e);
			redirect(base_url('air'));
		}
		
	}

	// API
}
