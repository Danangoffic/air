<?php

/**
 * 
 */
class Pengujian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_air', 'air');
		$this->load->model('Model_klasifikasi', 'klasifikasi');
		$this->load->model('Model_rule_klasifikasi_air', 'rule_klasifikasi');
		$this->load->model('Model_latih');
	}

	protected $default_pengkali = 0.8;
	protected $defual_penambah = 0.1;
	public $tc = 0;
	public $so4 = 0.0;
	public $mn = 0.0;
	public $fe = 0.0;
	public $th = 0;
	public $tds = 0;
	public $ph = 6.0;
	public $target = 0;
	public $v_tc = 0;
	public $v_so4 = 0;
	public $v_mn = 0;
	public $v_fe = 0;
	public $v_th = 0;
	public $v_tds = 0;
	public $v_ph = 0;
	public $data_terhitung = array();
	public $max_epoch = 20;
	public $new_epoch = 0;
	public $kelas = 0;
	public $klasifikasi = 0;



	public function index()
	{
		if (!$this->session->userdata('username')) {
			redirect(base_url('users/login'));
		}
		$klasifikasi = new Model_klasifikasi();
		$data_klasifikasi = $klasifikasi->get_all();
		$page = array('page' => 'index_pengujian', 'script' => null, 'title' => 'Pengujian', 'data_klasifikasi' => $data_klasifikasi, 'act' => 'Pengujian');
		$this->load->view('templates/layout', $page);
	}

	public function doPengujian()
	{
		// DAPETIN DATA YANG DI INPUT
		$new_pengujian = new Pengujian();
		$new_latih = new Model_latih();
		$new_klasifikasi = new Model_klasifikasi();
		$learningRate = $this->input->post('learningRate');
		$bobot = array();
		$data_klasifikasi = $new_klasifikasi->get_all();
		
		$new_data_latih = array();
		foreach ($data_klasifikasi->result() as $klasifikasi) {
			$bobot[$klasifikasi->nama_klasifikasi] = $this->input->post($klasifikasi->nama_klasifikasi);
			$new_klasifikasi = strtolower($klasifikasi->nama_klasifikasi);
			$b = $bobot[$new_klasifikasi];
			if ($new_klasifikasi === "tc") {
				$new_data_latih['tc'] = $b;
				$new_pengujian->set_tc($b);
			}
			if ($new_klasifikasi === "so4") {
				$new_data_latih['so4'] = $b;
				$new_pengujian->set_so4($b);
			}
			if ($new_klasifikasi === "mn") {
				$new_data_latih['mn'] = $b;
				$new_pengujian->set_mn($b);
			}
			if ($new_klasifikasi === "fe") {
				$new_data_latih['fe'] = $b;
				$new_pengujian->set_fe($b);
			}
			if ($new_klasifikasi === "th") {
				$new_data_latih['th'] = $b;
				$new_pengujian->set_th($b);
			}
			if ($new_klasifikasi === "tds") {
				$new_data_latih['tds'] = $b;
				$new_pengujian->set_tds($b);
			}
			if ($new_klasifikasi === "ph") {
				$new_data_latih['ph'] = $b;
				$new_pengujian->set_ph($b);
			}
		}

		$new_data_latih['target'] = $new_pengujian->set_get_target();
		$new_latih->set_data($new_data_latih);
		$insert_data_latih = $new_latih->insert();
		if(!$insert_data_latih){
			$this->session->set_flashdata("error", "Gagal Insert Data Latih Baru");
			redirect(base_url('Pengujian'));
		}
		$id_latih = $new_latih->get_id();
		$result_iterasi = $this->iterasi($new_pengujian);
		if (count($bobot) == 0) {
			$this->session->set_flashdata("error", "Data Bobot Belum Diisi");
		}
	}

	protected function iterasi(Pengujian $new_pengujian)
	{
		$Model_latih = new Model_latih();
		$IterasiPengujian = new Pengujian();
		$data_iterasi = array();
		$klasifikasi_tc = $new_pengujian->get_classification_tc();
		$klasifikasi_so4 = $new_pengujian->get_classification_so4();
		$klasifikasi_mn = $new_pengujian->get_classification_mn();
		$klasifikasi_fe = $new_pengujian->get_classification_fe();
		$klasifikasi_th = $new_pengujian->get_classification_th();
		$klasifikasi_tds = $new_pengujian->get_classification_tds();
		$klasifikasi_ph = $new_pengujian->get_classification_th();
		$klasifikasi_target = $new_pengujian->set_get_target();
		$data = $Model_latih->get_data_latih()->result();
		foreach($data as $data_latih){
			$IterasiPengujian->set_tc($data_latih->tc);
			$IterasiPengujian->set_so4($data_latih->so4);
			$IterasiPengujian->set_mn($data_latih->mn);
			$IterasiPengujian->set_fe($data_latih->fe);
			$IterasiPengujian->set_th($data_latih->th);
			
			$new_tc = $IterasiPengujian->get_tc();
			$new_so4 = $IterasiPengujian->get_so4();
			$new_mn = $IterasiPengujian->get_mn();
			$new_fe = $IterasiPengujian->get_fe();
			$new_th = $IterasiPengujian->get_th();
			$new_target = $IterasiPengujian->set_get_target();
			$data_iterasi[] = array(
				'tc' => $data_latih->tc,
				'so4' => $data_latih->so4,
				'mn' => $data_latih->mn,
				'fe' => $data_latih->fe,
				'th' => $data_latih->th,
				'target' => $new_target
			);
		}
		// EUCLIDEAN
		$this->calculate_bobot($new_pengujian, $data_iterasi);
		// KELAS YANG DIDAPAT
		$kelas = $this->get_kelas();
	}

	protected function calculate_bobot(Pengujian $new_pengujian, Array $IterasiPengujian)
	{
		$init_kelas = array();
		for ($i=0; $i < count($IterasiPengujian); $i++) { 
			$untuk_sum = array();
			$tc_awal = $new_pengujian->get_classification_tc;
			$tc_latih = $IterasiPengujian[$i]['tc'];
			$pow_tc = $this->get_in_pow($tc_awal, $tc_latih);
			array_push($untuk_sum, $pow_tc);

			$so4_awal = $new_pengujian->get_classification_so4();
			$so4_latih = $IterasiPengujian[$i]['so4'];
			$pow_so4 = $this->get_in_pow($so4_awal, $so4_latih);
			array_push($untuk_sum, $pow_so4);

			$mn_awal = $new_pengujian->get_mn();
			$mn_latih = $IterasiPengujian[$i]['mn'];
			$pow_mn = $this->get_in_pow($mn_awal, $mn_awal);
			array_push($untuk_sum, $pow_mn);

			$fe_awal = $new_pengujian->get_fe();
			$fe_latih = $IterasiPengujian[$i]['fe'];
			$pow_fe = $this->get_in_pow($fe_awal, $fe_latih);
			array_push($untuk_sum, $pow_fe);

			$th_awal = $new_pengujian->get_th();
			$th_latih = $IterasiPengujian[$i]['th'];
			$pow_th = $this->get_in_pow($th_awal, $th_latih);
			array_push($untuk_sum, $pow_th);

			$sum_all = array_sum($untuk_sum);
			$sqrt = sqrt($sum_all);
			$init_kelas[$i] = array('kelas' => $i+1, 'hasil' => $sqrt);
		}
		asort($init_kelas);
		$this->set_kelas($init_kelas[0]);
	}

	

	public function get_klasifikasi()
	{
		return $this->klasifikasi;
	}

	protected function get_in_pow($bobot_terbawa, $bobot_latih)
	{
		$calculate = $bobot_terbawa - $bobot_latih;
		return pow($calculate, 2);
	}

	protected function prediksi()
	{
		# berisi iterasi data pangkat 2
	}

	public function updating_rate_lvq2()
	{
		
	}

	protected function normalisasi($data_a, $data_b)
	{
		$pengkali = $this->get_pengkali();
		$penambah = $this->get_penambah();
		$ph = floatval($data_a->ph);
		$min_ph = floatval($data_b->min_ph);
		$max_ph = floatval($data_b->max_pj);

		$tds = floatval($data_a->tds);
		$min_tds = floatval($data_b->min_tds);
		$max_tds = floatval($data_b->max_tds);

		$th = floatval($data_a->th);
		$min_th = floatval($data_b->min_th);
		$max_th = floatval($data_b->max_th);
		$result_ph = $this->result_var($ph, $min_ph, $max_ph);
		$result_tds = $this->result_var($tds, $min_tds, $max_tds);
		$result_th = $this->result_var($th, $min_th, $max_th);
	}

	protected function result_var(float $a = 0, float $min = 0, float $max = 0)
	{
		$min_result = $min - $a;
		$max_result = $max - $a;
		return ((0.8 * $min_result) / $max_result) + 0.1;
	}

	protected function euclidean_kmeans($data_awal, $data_dalam)
	{
		foreach ($data_awal->result() as $awal) {
			$first = new Pengujian();
			$first->set_ph($awal->ph);

			foreach ($data_dalam->result() as $dalam) {
				$second = new Pengujian();
				$second->set_ph($dalam->ph);

				$result_ph = $this->normalisasi_euclidean($dalam->ph, $awal->ph);
			}
		}
	}

	protected function normalisasi_euclidean($a = 0, $b = 0)
	{
		return pow(($a - $b), 2);
	}

	protected function getClosest($search, $arr)
	{
		$closest = null;
		foreach ($arr as $item) {
			if ($closest === null || abs($search - $closest) > abs($item - $search)) {
				$closest = $item;
			}
		}
		return $closest;
	}

	protected function array_data_latih()
	{
		return $this->Model_latih->get_rest_data()->result_array();
	}

	public function get_classification_data_latih()
	{
		$data = $this->Model_latih->get_rest_data();
	}

	public function set_data_latih()
	{
		# code...
	}


	public function get_pengkali()
	{
		return $this->default_pengkali;
	}

	public function get_penambah()
	{
		return $this->defual_penambah;
	}

	public function set_tc($TC)
	{
		$this->tc = $TC;
		if ($TC > 0 && $TC < 10) {
			$this->v_tc = 1;
		} else if ($TC == 0) {
			$this->v_tc = 2;
		} else if ($TC > 10) {
			$this->v_tc = 3;
		}
	}

	public function get_tc()
	{
		return $this->tc;
	}

	public function get_classification_tc()
	{
		return $this->v_tc;
	}

	public function set_so4($SO4)
	{
		$this->so4 = $SO4;
		if ($SO4 <= 400) {
			$this->v_so4 = 1;
		} else {
			$this->v_so4 = 3;
		}
	}

	public function get_so4()
	{
		return $this->so4;
	}

	public function get_classification_so4()
	{
		return $this->v_so4;
	}

	public function set_mn($Mn)
	{
		$this->mn = $Mn;
		if ($Mn <= 0.1) {
			$this->v_mn = 2;
		} else if ($Mn <= 0.5) {
			$this->v_mn = 1;
		} else if ($Mn > 0.5) {
			$this->v_mn = 3;
		}
	}

	public function get_mn()
	{
		return $this->mn;
	}

	public function get_classification_mn()
	{
		return $this->v_mn;
	}

	public function set_fe($Fe)
	{
		$this->fe = $Fe;
		if ($Fe <= 0.3) {
			$this->v_fe = 2;
		} else if ($Fe > 0.3 && $Fe <= 1) {
			$this->v_fe = 1;
		} else if ($Fe > 1) {
			$this->v_fe = 3;
		}
	}

	public function get_fe()
	{
		return $this->fe;
	}

	public function get_classification_fe()
	{
		return $this->v_fe;
	}

	public function set_th($Th)
	{
		$this->th = $Th;
		if ($Th <= 500) {
			$this->v_th = 1;
		} else if ($Th > 500) {
			$this->v_th = 3;
		}
	}

	public function get_th()
	{
		return $this->th;
	}

	public function get_classification_th()
	{
		return $this->v_th;
	}

	public function set_tds($TDS)
	{
		$this->tds = $TDS;
		if ($TDS < 1000) {
			$this->v_tds = 1;
		} else if ($TDS > 1000 && $TDS < 1501) {
			$this->v_tds = 2;
		} else if ($TDS > 1500) {
			$this->v_tds = 3;
		}
	}

	public function get_tds()
	{
		return $this->tds;
	}

	public function get_classification_tds()
	{
		return $this->v_tds;
	}

	public function set_ph($Ph)
	{
		$this->ph = $Ph;
		if ($Ph >= 6.5 && $Ph <= 9.0) {
			$this->v_ph = 1;
		} else if ($Ph >= 6.5 && $Ph <= 8.5) {
			$this->v_ph = 2;
		} else if ($Ph > 9.0 || $Ph < 6.5) {
			$this->v_ph = 3;
		}
	}

	public function get_ph()
	{
		return $this->ph;
	}

	public function get_classification_ph()
	{
		return $this->v_ph;
	}

	public function set_get_target()
	{
		$TC = $this->get_tc();
		if ($TC === 0) {
			$this->target = 1;
		} elseif ($TC > 0 && $TC < 11) {
			$this->target = 2;
		} else {
			$this->target = 3;
		}
		return $this->target;
	}

	protected function set_max_epoch($epoch = 0)
	{
		$this->max_epoch = $epoch;
	}

	protected function get_max_epoch()
	{
		return $this->max_epoch;
	}

	public function set_kelas($kelas)
	{
		$this->kelas = $kelas;
	}

	public function get_kelas()
	{
		return $this->kelas;
	}

	// public function tc(float $nilai)
	// {
	// 	if ($nilai > 0 && $nilai < 10) {
	// 		return 1;
	// 	} else if ($nilai == 0) {
	// 		return 2;
	// 	} else if ($nilai > 10) {
	// 		return 3;
	// 	}
	// }

	// public function so4(float $nilai)
	// {
	// 	if ($nilai <= 400) {
	// 		return 1;
	// 	} else {
	// 		return 3;
	// 	}
	// }

	// public function mn(float $nilai)
	// {
	// 	if ($nilai <= 0.1) {
	// 		return 2;
	// 	} else if ($nilai <= 0.5) {
	// 		return 1;
	// 	} else if ($nilai > 0.5) {
	// 		return 3;
	// 	}
	// }

	// public function fe(float $nilai)
	// {
	// 	if ($nilai <= 0.3) {
	// 		return 2;
	// 	} else if ($nilai > 0.3 && $nilai <= 1) {
	// 		return 1;
	// 	} else if ($nilai > 1) {
	// 		return 3;
	// 	}
	// }

	// public function TH(float $nilai)
	// {
	// 	if ($nilai <= 500) {
	// 		return 1;
	// 	} else if ($nilai > 500) {
	// 		return 3;
	// 	}
	// }

	// public function tds(float $nilai)
	// {
	// 	if ($nilai < 1000) {
	// 		return 1;
	// 	} else if ($nilai > 1000 && $nilai < 1501) {
	// 		return 2;
	// 	} else if ($nilai > 1500) {
	// 		return 3;
	// 	}
	// }

	// public function ph(float $nilai)
	// {
	// 	if ($nilai >= 6.5 && $nilai <= 9.0) {
	// 		return 1;
	// 	} else if ($nilai >= 6.5 && $nilai <= 8.5) {
	// 		return 2;
	// 	} else if ($nilai > 9.0 || $nilai < 6.5) {
	// 		return 3;
	// 	}
	// }
}
