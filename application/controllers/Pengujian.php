<?php

use phpDocumentor\Reflection\Types\Array_;

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
		$this->load->model("Model_pengujian");
	}

	// protected $default_pengkali = 0.8;
	// protected $defual_penambah = 0.1;
	// public $tc = 0;
	// public $so4 = 0.0;
	// public $mn = 0.0;
	// public $fe = 0.0;
	// public $th = 0;
	// public $tds = 0;
	// public $ph = 6.0;
	// public $target = 0;
	// public $v_tc = 0;
	// public $v_so4 = 0;
	// public $v_mn = 0;
	// public $v_fe = 0;
	// public $v_th = 0;
	// public $v_tds = 0;
	// public $v_ph = 0;
	// public $data_terhitung = array();
	// public $max_epoch = 20;
	// public $new_epoch = 0;
	// public $kelas = 0;
	// public $klasifikasi = 0;



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
		$new_pengujian = $this->Model_pengujian;
		$new_latih = $this->Model_latih;
		$new_klasifikasi = $this->klasifikasi;
		$learningRate = $this->input->post('learningRate');
		$epoch = intval($this->input->post("epoch"));
		$target_input = $this->input->post("target", TRUE);
		$limit_learning_rate = $new_pengujian->max_learning_rate;
		// CEK LEARNING RATE LIMIT
		var_dump($this->input->post());
		// exit();
		if($learningRate > $limit_learning_rate){
			$this->session->set_flashdata("error", "Learning rate tidak bisa melewati batas " . $limit_learning_rate);
			return redirect(base_url("Pengujian"));
		}
		if($epoch < 1 ){
			$this->session->set_flashdata("error", "Epoch harus lebih besar dari 0");
			return redirect(base_url("Pengujian"));
		}
		$bobot = array();
		$data_klasifikasi = $new_klasifikasi->get_all();
		
		$new_data_latih = array();
		$array_data_latih = array();
		foreach ($data_klasifikasi->result() as $klasifikasi) {
			$lower_nama_klasifikasi = strtolower($klasifikasi->nama_klasifikasi);
			$bobot[$lower_nama_klasifikasi] = $this->input->post($lower_nama_klasifikasi);
			$b = $bobot[$lower_nama_klasifikasi];
			$array_data_latih[$lower_nama_klasifikasi] = $b;
			if ($new_klasifikasi === "tc") {
				$new_data_latih['tc'] = $b;
				// $new_pengujian->set_tc($b);
			}
			if ($new_klasifikasi === "so4") {
				$new_data_latih['so4'] = $b;
				// $new_pengujian->set_so4($b);
			}
			if ($new_klasifikasi === "mn") {
				$new_data_latih['mn'] = $b;
				// $new_pengujian->set_mn($b);
			}
			if ($new_klasifikasi === "fe") {
				$new_data_latih['fe'] = $b;
				// $new_pengujian->set_fe($b);
			}
			if ($new_klasifikasi === "th") {
				$new_data_latih['th'] = $b;
				// $new_pengujian->set_th($b);
			}
			if ($new_klasifikasi === "tds") {
				$new_data_latih['tds'] = $b;
				// $new_pengujian->set_tds($b);
			}
			if ($new_klasifikasi === "ph") {
				$new_data_latih['ph'] = $b;
				// $new_pengujian->set_ph($b);
			}
		}
		echo "<br>";
		var_dump($bobot);
		echo "<br>";
		// echo "tc dari model : " . $new_pengujian->get_tc() . "<br>";
		// GET TARGET BY INPUT HERE
		
		// $new_data_latih['target'] = $new_pengujian->set_get_target();
		// $new_latih->set_data($new_data_latih);
		$insert_data_latih = $this->Model_latih->insert_data($bobot);
		if(!$insert_data_latih){
			$this->session->set_flashdata("error", "Gagal Insert Data Latih Baru");
			redirect(base_url('Pengujian'));
		}
		$id_data_latih = $this->db->insert_id();
		// $new_pengujian->set_push_usedID($id_data_latih);
		echo "<br> id latih : " . $id_data_latih . "<br>";
		echo "<br> new pengujian : <br> " ; 
		// var_dump($new_pengujian);
		$dataInitResultWeightUji = $this->getResultInitWeightUji($bobot, $id_data_latih);
		$target_awal = $dataInitResultWeightUji['converted_target'];
		while ($epoch > 0) {
			# code...
			$result_kelas_iterasi = $this->iterasi($new_pengujian, $bobot, $id_data_latih);
			//PENENTUAN TARGET
			$WINNER = $result_kelas_iterasi[0];
			$target_winner = $WINNER['target'];
			if($target_awal === $target_winner){

			}
			// KONDISI TARGET SESUAI KELAS ATAU TIDAK
			$epoch -=0.1;
		}
		// for ($i=$epoch; $i == 0; $i--) { 
		// 	$result_kelas_iterasi = $this->iterasi($new_pengujian, $bobot, $id_data_latih);
			
		// }

		if (count($bobot) == 0) {
			$this->session->set_flashdata("error", "Data Bobot Belum Diisi");
		}
	}

	protected function getResultInitWeightUji(Array $dataUji, $id_taken){

		$tc = $dataUji['tc'];
		$so4 = $dataUji['so4'];
		$mn = $dataUji['mn'];
		$fe = $dataUji['fe'];
		$th = $dataUji['th'];
		$tds = $dataUji['tds'];
		$ph = $dataUji['ph'];

		$this->db->where('id_data_latih', $id_taken);
		$bobot_1 = $this->Model_latih->get_data_latih();
		$this->db->reset_query();
		$this->db->order_by('id_data_latih', 'DESC');
		$this->db->limit(4);
		$bobot_2 = $this->Model_latih->get_data_latih();
		$result_bobot_1 = $bobot_1->row();
		$id_bobot_1 = $result_bobot_1->id_data_latih;
		$data_bobot[] = array('tc' => $result_bobot_1->tc, 
		'so4' => $result_bobot_1->so4, 'mn' => $result_bobot_1->mn,
		'fe' => $result_bobot_1->fe, 'th' => $result_bobot_1->th,
		'tds' => $result_bobot_1->tds, 'ph' => $result_bobot_1->ph);

		$id_bobot_array[] = $id_bobot_1;
		foreach ($bobot_2->result() as $result_bobot_2) {
			$id_bobot_array[] = $result_bobot_2->id_data_latih;
			$data_bobot[] = array('tc' => $result_bobot_2->tc, 
			'so4' => $result_bobot_2->so4, 'mn' => $result_bobot_2->mn,
			'fe' => $result_bobot_2->fe, 'th' => $result_bobot_2->th,
			'tds' => $result_bobot_2->tds, 'ph' => $result_bobot_2->ph);
		}
		$bobot_ternormalisasi = $this->getNormalizeData($data_bobot);
		$this->db->reset_query();
		$this->db->where_not_in('id_data_latih', $id_bobot_array);
		$this->db->order_by("id_data_latih", 'DESC');
		$latih_data_db = $this->Model_latih->get_data_latih();
		$data_latih = array();
		$id_latih_array = array();
		foreach ($latih_data_db->result() as $result_bobot_2) {
			$id_latih_array[] = $result_bobot_2->id_data_latih;
			$data_latih[] = array('tc' => $result_bobot_2->tc, 
			'so4' => $result_bobot_2->so4, 'mn' => $result_bobot_2->mn,
			'fe' => $result_bobot_2->fe, 'th' => $result_bobot_2->th,
			'tds' => $result_bobot_2->tds, 'ph' => $result_bobot_2->ph);
		}
		$latih_ternormalisasi = $this->getNormalizeData($data_latih);
		
		return array('w' => $bobot_ternormalisasi, 'w_id' => $id_bobot_array, 'x' => $latih_ternormalisasi);
	}

	protected function getNormalizeData($data_awal)
	{
		foreach ($data_awal as $key) {
			$tc_atas = $key['tc'] - $key['min_tc'];
			$tc_bawah = $key['max_tc'] - $key['min_tc'];
			$tc = $tc_atas / $tc_bawah;

			$so4_atas = $key['so4'] - $key['min_so4'];
			$so4_bawah = $key['max_so4'] - $key['min_so4'];
			$so4 = $so4_atas / $so4_bawah;

			$mn_atas = $key['mn'] - $key['min_mn'];
			$mn_bawah = $key['max_mn'] - $key['min_mn'];
			$mn = $mn_atas / $mn_bawah;

			$fe_atas = $key['fe'] - $key['min_fe'];
			$fe_bawah = $key['max_fe'] - $key['min_fe'];
			$fe = $fe_atas / $fe_bawah;

			$th_atas = $key['th'] - $key['min_th'];
			$th_bawah = $key['max_th'] - $key['min_th'];
			$th = $th_atas / $th_bawah;

			$tds_atas = $key['tds'] - $key['min_tds'];
			$tds_bawah = $key['max_tds'] - $key['min_tds'];
			$tds = $tds_atas - $tds_bawah;

			$ph_atas = $key['ph'] - $key['min_ph'];
			$ph_bawah = $key['max_ph'] - $key['min_ph'];
			$ph = $ph_atas - $ph_bawah;

			return array('ph' => $ph, 'tds' => $tds, 'th' => $th, 'fe' => $fe, 'mn' => $mn, 'so4' => $so4, 'tc' => $tc);
		}
		
	}

	protected function iterasi(Model_pengujian $new_pengujian, Array $pengujian, $id_data_latih)
	{
		
		$this->db->where("id_data_latih !=", $id_data_latih);
		$data = $this->Model_latih->get_data_latih()->result();
		foreach($data as $data_latih){
			$new_tc = $data_latih->tc;
			$new_so4 = $data_latih->so4;
			$new_mn = $data_latih->mn;
			$new_fe = $data_latih->fe;
			$new_th = $data_latih->th;
			$new_tds = $data_latih->tds;
			$new_ph = $data_latih->ph;
			$id = $data_latih->id_data_latih;
			$array_latihan = array('tc' => $new_tc, 'so4' => $new_so4, 'mn' => $new_mn, 
									'fe' => $new_fe, 'th' => $new_th, 'tds' => $new_tds,
									'ph' => $new_ph);
			$getTrueWeightLatih = $this->getResultInitWeightUji($array_latihan);
			$converted_tc = $getTrueWeightLatih['converted_tc'];
			$converted_so4 = $getTrueWeightLatih['converted_so4'];
			$converted_mn = $getTrueWeightLatih['converted_mn'];
			$converted_fe = $getTrueWeightLatih['converted_fe'];
			$converted_th = $getTrueWeightLatih['converted_th'];
			$converted_tds = $getTrueWeightLatih['converted_tds'];
			$converted_ph = $getTrueWeightLatih['converted_ph'];

			$new_target = $this->Model_pengujian->getTargetFromDataLatih($converted_tc);
			$data_iterasi[] = array(
				'tc' => $converted_tc,
				'so4' => $converted_so4,
				'mn' => $converted_mn,
				'fe' => $converted_fe,
				'th' => $converted_th,
				'target' => $new_target,
				'id' => $id,
				'th' => $converted_th,
				'tds' => $converted_tds,
				'ph' => $converted_ph
			);
		}
		// EUCLIDEAN
		$kelas_euclidean_distance = $this->euclidean_distance_init($pengujian, $data_iterasi);
		// KELAS YANG DIDAPAT (HASIL YANG PALING MINIMUM)
		return $kelas_euclidean_distance;

	}

	protected function euclidean_distance_init(Array $pengujian, Array $IterasiPengujian)
	{
		$init_kelas = array();
		for ($i=0; $i < count($IterasiPengujian); $i++) { 
			$untuk_sum = array();
			$tc_awal = $pengujian['tc'];
			$tc_latih = $IterasiPengujian[$i]['tc'];
			$pow_tc = $this->get_in_pow($tc_awal, $tc_latih);
			array_push($untuk_sum, $pow_tc);

			$so4_awal = $pengujian['so4'];
			$so4_latih = $IterasiPengujian[$i]['so4'];
			$pow_so4 = $this->get_in_pow($so4_awal, $so4_latih);
			array_push($untuk_sum, $pow_so4);

			$mn_awal = $pengujian['mn'];
			$mn_latih = $IterasiPengujian[$i]['mn'];
			$pow_mn = $this->get_in_pow($mn_awal, $mn_awal);
			array_push($untuk_sum, $pow_mn);

			$fe_awal = $pengujian['fe'];
			$fe_latih = $IterasiPengujian[$i]['fe'];
			$pow_fe = $this->get_in_pow($fe_awal, $fe_latih);
			array_push($untuk_sum, $pow_fe);

			$th_awal = $pengujian['th'];
			$th_latih = $IterasiPengujian[$i]['th'];
			$pow_th = $this->get_in_pow($th_awal, $th_latih);
			array_push($untuk_sum, $pow_th);

			$tds_awal = $pengujian['tds'];
			$tds_latih = $IterasiPengujian[$i]['tds'];
			$pow_tds = $this->get_in_pow($tds_awal, $tds_latih);
			array_push($untuk_sum, $pow_tds);

			$ph_awal = $pengujian['ph'];
			$ph_latih = $IterasiPengujian[$i]['ph'];
			$pow_ph = $this->get_in_pow($ph_awal, $ph_latih);
			array_push($untuk_sum, $pow_ph);

			$sum_all = array_sum($untuk_sum);
			$sqrt = sqrt($sum_all);
			
			$id = intval($IterasiPengujian[$i]['id']);
			$init_kelas[$i] = array('kelas' => intval($i+1), 'hasil' => $sqrt, 
			'id' => $id, 'target' => $IterasiPengujian['target'],
			'tc' => $tc_latih,
			'so4' => $so4_latih,
			'mn' => $mn_latih,
			'fe' => $fe_latih,
			'th' => $th_latih,
			'tds' => $tds_latih,
			'ph' => $ph_latih);
		}
		asort($init_kelas);
		// $WINNER = $init_kelas[0];
		// $new_pengujian->set_push_usedID($WINNER['id']);
		// $new_pengujian->set_kelas($init_kelas[0]);
		return $init_kelas;
	}

	protected function targetAwalSamaDenganTargetHasil(Array $bobotAwal, Array $bobotAkhir){

	}

	

	// public function get_klasifikasi()
	// {
	// 	return $this->klasifikasi;
	// }

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

	// protected function normalisasi($data_a, $data_b)
	// {
	// 	$MP = new Model_pengujian();
	// 	$pengkali = $MP->get_pengkali();
	// 	$penambah = $MP->get_penambah();
	// 	$ph = floatval($data_a->ph);
	// 	$min_ph = floatval($data_b->min_ph);
	// 	$max_ph = floatval($data_b->max_pj);

	// 	$tds = floatval($data_a->tds);
	// 	$min_tds = floatval($data_b->min_tds);
	// 	$max_tds = floatval($data_b->max_tds);

	// 	$th = floatval($data_a->th);
	// 	$min_th = floatval($data_b->min_th);
	// 	$max_th = floatval($data_b->max_th);
	// 	$result_ph = $MP->result_var($ph, $min_ph, $max_ph);
	// 	$result_tds = $MP->result_var($tds, $min_tds, $max_tds);
	// 	$result_th = $MP->result_var($th, $min_th, $max_th);
	// }

	

	// protected function euclidean_kmeans($data_awal, $data_dalam)
	// {
	// 	foreach ($data_awal->result() as $awal) {
	// 		$first = new Model_pengujian();
	// 		$first->set_ph($awal->ph);

	// 		foreach ($data_dalam->result() as $dalam) {
	// 			$second = new Model_pengujian();
	// 			$second->set_ph($dalam->ph);
	// 			$result_ph = $this->normalisasi_euclidean($dalam->ph, $awal->ph);
	// 		}
	// 	}
	// }

	// protected function normalisasi_euclidean($a = 0, $b = 0)
	// {
	// 	return pow(($a - $b), 2);
	// }

	protected function array_data_latih()
	{
		return $this->Model_latih->get_rest_data()->result_array();
	}

	public function get_classification_data_latih()
	{
		$data = $this->Model_latih->get_rest_data();
	}

	// public function set_data_latih()
	// {
	// 	# code...
	// }


	// public function get_pengkali()
	// {
	// 	return $this->default_pengkali;
	// }

	// public function get_penambah()
	// {
	// 	return $this->defual_penambah;
	// }

	// public function set_tc($TC)
	// {
	// 	$this->tc = $TC;
	// 	if ($TC > 0 && $TC < 10) {
	// 		$this->v_tc = 1;
	// 	} else if ($TC == 0) {
	// 		$this->v_tc = 2;
	// 	} else if ($TC > 10) {
	// 		$this->v_tc = 3;
	// 	}
	// }

	// public function get_tc()
	// {
	// 	return $this->tc;
	// }

	// public function get_classification_tc()
	// {
	// 	return $this->v_tc;
	// }

	// public function set_so4($SO4)
	// {
	// 	$this->so4 = $SO4;
	// 	if ($SO4 <= 400) {
	// 		$this->v_so4 = 1;
	// 	} else {
	// 		$this->v_so4 = 3;
	// 	}
	// }

	// public function get_so4()
	// {
	// 	return $this->so4;
	// }

	// public function get_classification_so4()
	// {
	// 	return $this->v_so4;
	// }

	// public function set_mn($Mn)
	// {
	// 	$this->mn = $Mn;
	// 	if ($Mn <= 0.1) {
	// 		$this->v_mn = 2;
	// 	} else if ($Mn <= 0.5) {
	// 		$this->v_mn = 1;
	// 	} else if ($Mn > 0.5) {
	// 		$this->v_mn = 3;
	// 	}
	// }

	// public function get_mn()
	// {
	// 	return $this->mn;
	// }

	// public function get_classification_mn()
	// {
	// 	return $this->v_mn;
	// }

	// public function set_fe($Fe)
	// {
	// 	$this->fe = $Fe;
	// 	if ($Fe <= 0.3) {
	// 		$this->v_fe = 2;
	// 	} else if ($Fe > 0.3 && $Fe <= 1) {
	// 		$this->v_fe = 1;
	// 	} else if ($Fe > 1) {
	// 		$this->v_fe = 3;
	// 	}
	// }

	// public function get_fe()
	// {
	// 	return $this->fe;
	// }

	// public function get_classification_fe()
	// {
	// 	return $this->v_fe;
	// }

	// public function set_th($Th)
	// {
	// 	$this->th = $Th;
	// 	if ($Th <= 500) {
	// 		$this->v_th = 1;
	// 	} else if ($Th > 500) {
	// 		$this->v_th = 3;
	// 	}
	// }

	// public function get_th()
	// {
	// 	return $this->th;
	// }

	// public function get_classification_th()
	// {
	// 	return $this->v_th;
	// }

	// public function set_tds($TDS)
	// {
	// 	$this->tds = $TDS;
	// 	if ($TDS < 1000) {
	// 		$this->v_tds = 1;
	// 	} else if ($TDS > 1000 && $TDS < 1501) {
	// 		$this->v_tds = 2;
	// 	} else if ($TDS > 1500) {
	// 		$this->v_tds = 3;
	// 	}
	// }

	// public function get_tds()
	// {
	// 	return $this->tds;
	// }

	// public function get_classification_tds()
	// {
	// 	return $this->v_tds;
	// }

	// public function set_ph($Ph)
	// {
	// 	$this->ph = $Ph;
	// 	if ($Ph >= 6.5 && $Ph <= 9.0) {
	// 		$this->v_ph = 1;
	// 	} else if ($Ph >= 6.5 && $Ph <= 8.5) {
	// 		$this->v_ph = 2;
	// 	} else if ($Ph > 9.0 || $Ph < 6.5) {
	// 		$this->v_ph = 3;
	// 	}
	// }

	// public function get_ph()
	// {
	// 	return $this->ph;
	// }

	// public function get_classification_ph()
	// {
	// 	return $this->v_ph;
	// }

	// public function set_get_target()
	// {
	// 	$TC = $this->get_tc();
	// 	if ($TC === 0) {
	// 		$this->target = 1;
	// 	} elseif ($TC > 0 && $TC < 11) {
	// 		$this->target = 2;
	// 	} else {
	// 		$this->target = 3;
	// 	}
	// 	return $this->target;
	// }

	// protected function set_max_epoch($epoch = 0)
	// {
	// 	$this->max_epoch = $epoch;
	// }

	// protected function get_max_epoch()
	// {
	// 	return $this->max_epoch;
	// }

	// public function set_kelas($kelas)
	// {
	// 	$this->kelas = $kelas;
	// }

	// public function get_kelas()
	// {
	// 	return $this->kelas;
	// }

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
