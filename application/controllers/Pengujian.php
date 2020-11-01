<?php

/**
 * 
 */
class Pengujian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->has_userdata("username")) {
			if ($this->session->userdata('user_class') !== "penguji") {
				$this->session->set_flashdata("error", "Bukan halaman untuk kelas pengguna " . $this->session->userdata("user_class"));
				redirect(base_url());
			}
		} else {
			redirect(base_url());
		}
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
		$input_user = array();
		if ($this->session->has_userdata('input_user')) {
			$input_user = $this->session->userdata("input_user");
		} else {
			foreach ($data_klasifikasi->result() as $key) {
				$new = strtolower($key->nama_klasifikasi);
				$input_user[$new] = 0;
			}
		}
		$page = array('page' => 'index_pengujian', 'script' => null, 'title' => 'Pengujian', 'data_klasifikasi' => $data_klasifikasi, 'act' => 'Pengujian', 'input_user' => $input_user);
		$this->load->view('templates/layout', $page);
	}

	public function doPengujian()
	{
		// DAPETIN DATA YANG DI INPUT
		$learningRate = floatval($this->input->post('learningRate'));
		$max_epoch = intval($this->input->post("epoch"));
		$epoch = 0;
		$deca = 0.1;
		$mina = 0.001;
		$window = floatval($this->input->post("window", TRUE));

		//GET INPUT VALUE
		$DataPengujianUser = $this->setPengujianValue();


		$resultCalculation = array();
		$BobotAwal = $this->getBobotAwalNormalized();
		$id_bobot = $BobotAwal['id_bobot'];
		$nilaiDataLatih = $this->getBobotDataLatih($id_bobot);
		$dataLatihan = $nilaiDataLatih['x'];
		$DATA_UJI = $BobotAwal['w'];
		$indexEpoch = 0;

		$HitunganLVQ2 = array();
		// PELATIHAN LVQ 2
		while (($epoch < $max_epoch) || ($learningRate > $mina)) {
			# code...
			$akurasi_data = floatval(0);
			$epoch++;
			$HitunganLVQ2 = $this->euclidean_distance_init($DATA_UJI, $dataLatihan, $window, $learningRate);
			$DATA_UJI = $HitunganLVQ2['DATA_UJI'];

			$TotalDataLatihan = $HitunganLVQ2['total_data_latih'];
			$TotalDataSesuai = $HitunganLVQ2['total_benar'];
			$Persentase = $HitunganLVQ2['persentase'];
			// PENGURANGAN LEARNING RATE
			$learningRate = $this->getNewLearningRate($learningRate, $deca);

			//CEK KONDISI UNTUK MENGEMBALIKAN HASIL PERHITUNGAN
			if (($epoch >= $max_epoch) || ($learningRate <= $mina)) {

				$akurasi_data = round($Persentase, 2);
				break;
			}
			$indexEpoch++;
		}

		$resultCalculation = array();


		// PENGUJIAN LVQ 2
		$PengujianLVQ2 = $this->euclidean_distance_pengujian($DataPengujianUser, $DATA_UJI);
		// echo "Hasil Pengujian : " . json_encode($PengujianLVQ2, JSON_PRETTY_PRINT);
		// exit();

		$hasil_perhitungan = array(
			'learning_rate' => $learningRate,
			'window' => $window,
			'percentage' => $akurasi_data,
			'hasil_pengujian' => $PengujianLVQ2['data'],
			'user_input' => $this->input->post(),
			'TotalDataLatihan' => $TotalDataLatihan,
			'TotalDataSesuai' => $TotalDataSesuai,
			'kelas' => $PengujianLVQ2['data'][0]['target'],
			'hasil_pengujian' => $PengujianLVQ2
		);
		echo "<p> END HASIL : " . json_encode($hasil_perhitungan) . "<p>";
		exit();
		$data_page = array('page' => 'hasil_pengujian', 'script' => null, 'title' => 'Hasil Pengujian', 'hasil' => $hasil_perhitungan, 'act' => 'Pengujian', 'data_klasifikasi' => $this->klasifikasi->get_all());
		$this->load->view("templates/layout", $data_page);
	}

	protected function setPengujianValue()
	{
		$ph = $this->input->post("ph", TRUE);
		$tds = $this->input->post("tds", TRUE);
		$th = $this->input->post("th", TRUE);
		$fe = $this->input->post("fe", TRUE);
		$mn = $this->input->post("mn", TRUE);
		$so4 = $this->input->post("so4", TRUE);
		$tc = $this->input->post("tc", TRUE);
		// $target = $this->input->post("target", TRUE);
		$DataPengujianUser = array(
			"ph" => $ph,
			"tds" => $tds,
			"th" => $th,
			"fe" => $fe,
			"mn" => $mn,
			"so4" => $so4,
			"tc" => $tc
		);
		$this->session->set_userdata('input_user', $DataPengujianUser);
		return $DataPengujianUser;
	}

	protected function getBobotDataLatih($id_bobot_array)
	{
		$data_latih = $this->Model_latih->getDataLatih($id_bobot_array, null);
		// echo "<p> query data latih : " . $this->db->last_query() . "</p>";
		$id_latih_array = array();
		foreach ($data_latih->result() as $result_bobot_2) {
			$id_latih_array[] = $result_bobot_2->id_data_latih;
		}
		$latih_ternormalisasi = $this->getNormalizeData($data_latih);

		return array('w_id' => $id_bobot_array, 'x' => $latih_ternormalisasi);
	}

	protected function getBobotAwalNormalized()
	{
		$bobot0 = $this->Model_latih->getDataUjiUser();
		// echo "<p> query data bobot awal : " . $this->db->last_query() . "</p>";
		foreach ($bobot0->result() as $key) {
			# code...
			$id_bobot_array[]  = $key->id_data_latih;
		}
		$bobot_ternormalisasi = $this->getNormalizeData($bobot0);
		return array('w' => $bobot_ternormalisasi, 'id_bobot' => $id_bobot_array);
	}

	protected function getNormalizeData($data_awal)
	{
		$data_normalisasi = array();
		$dataMinMax = $this->Model_latih->getDataMinMax()->row_array();
		// echo "<p> Data awal yang dibutuhkan : " . json_encode($data_awal->result_array()) . "</p>";
		foreach ($data_awal->result_array() as $key) {
			$tc_atas = $key['tc'] - $dataMinMax['min_tc'];
			$tc_bawah = $dataMinMax['max_tc'] - $dataMinMax['min_tc'];
			$tc = $tc_atas / $tc_bawah;

			$so4_atas = $key['so4'] - $dataMinMax['min_so4'];
			$so4_bawah = $dataMinMax['max_so4'] - $dataMinMax['min_so4'];
			$so4 = $so4_atas / $so4_bawah;

			$mn_atas = $key['mn'] - $dataMinMax['min_mn'];
			$mn_bawah = $dataMinMax['max_mn'] - $dataMinMax['min_mn'];
			$mn = $mn_atas / $mn_bawah;

			$fe_atas = $key['fe'] - $dataMinMax['min_fe'];
			$fe_bawah = $dataMinMax['max_fe'] - $dataMinMax['min_fe'];
			$fe = $fe_atas / $fe_bawah;

			$th_atas = $key['th'] - $dataMinMax['min_th'];
			$th_bawah = $dataMinMax['max_th'] - $dataMinMax['min_th'];
			$th = $th_atas / $th_bawah;

			$tds_atas = $key['tds'] - $dataMinMax['min_tds'];
			$tds_bawah = $dataMinMax['max_tds'] - $dataMinMax['min_tds'];
			$tds = $tds_atas - $tds_bawah;

			$ph_atas = $key['ph'] - $dataMinMax['min_ph'];
			$ph_bawah = $dataMinMax['max_ph'] - $dataMinMax['min_ph'];
			$ph = $ph_atas - $ph_bawah;

			$data_normalisasi[] = array('ph' => $ph, 'tds' => $tds, 'th' => $th, 'fe' => $fe, 'mn' => $mn, 'so4' => $so4, 'tc' => $tc, 'target' => $key['target']);
		}
		return $data_normalisasi;
	}

	protected function euclidean_distance_init($pengujian = array(), $data_latih = array(), float $window = 0.1, float $learningRate = 0.1)
	{
		// "Masuk Pelatihan euclidean distance";

		$totalAll = count($data_latih);
		$total_benar = 0;

		$indexX = 0;
		$parameterAir = $this->klasifikasi->get_all();
		foreach ($data_latih as $i) {

			$indexW = 0;
			$pelatihanDataUji = array();
			foreach ($pengujian as $j) {
				$untuk_sum = array();
				$w = array();
				$x = array();

				foreach ($parameterAir->result() as $k) {

					$lower = strtolower($k->nama_klasifikasi);
					$bobotAwal = $j[$lower];
					$latih = $i[$lower];

					$pow = $this->get_in_pow($bobotAwal, $latih);
					array_push($untuk_sum, $pow);
					$w[$lower] = round($bobotAwal, 2);
					$x[$lower] = round($latih, 2);
				}
				$sum_all = array_sum($untuk_sum);
				$sqrt = round(sqrt($sum_all), 2);

				$j['hasil'] = $sqrt;
				$pelatihanDataUji[$indexW] = $j;

				$indexW++;
			}

			// SORTING DATA UJI DAN PER DATA LATIH
			$pengujian = $this->array_sort($pelatihanDataUji, "hasil");

			$targetLatih = $i['target'];
			$winner = $pengujian[0];
			$runnerUp = $pengujian[0];

			$targetPemenang = $winner['target'];
			$hasilPemenang = $winner['hasil'];
			$hasilRunnerUp = $runnerUp['hasil'];
			if ($targetLatih == $targetPemenang) {
				$total_benar++;
				$pengujian[0] = $this->updatePemenang($pengujian[0], $i, $learningRate, $targetPemenang, $targetLatih);
			} else {
				$kondisi = $this->cekDcDr($hasilPemenang, $hasilRunnerUp, $window);
				if ($kondisi) {
					$pengujian = $this->updateYCYR($pengujian, $i, $learningRate, $targetLatih);
				} else {
					$pengujian[0] = $this->updatePemenang($pengujian[0], $i, $learningRate, $targetPemenang, $targetLatih);
					$pengujian[1] = $this->updateRunner($pengujian[1], $i, $learningRate);
				}
			}
			$indexX++;
		}
		

		$akurasi = (floatval(floatval($total_benar) / floatval($totalAll))) * 100;
		// echo " akurasi : " . $akurasi;
		$returnMap = array('DATA_UJI' => $pengujian, 'persentase' => $akurasi, 'total_data_latih' => $totalAll, 'total_benar' => $total_benar);
		return $returnMap;
	}

	public function euclidean_distance_pengujian($pengujian, $hasilBobotPelatihan)
	{
		// echo "========Masuk Pengujian========<br>";


		$indexX = 0;
		foreach ($hasilBobotPelatihan as $i) {
			$PengujianInput = array();
			$j = $pengujian;
			$ParameterAir = $this->klasifikasi->get_all();

			$untuk_sum = array();
			// $w = array();
			$x = array();
			foreach ($ParameterAir->result() as $k) {
				// echo json_encode($k);
				$lower = strtolower($k->nama_klasifikasi);
				$awal = $j[$lower];
				$latih = $i[$lower];
				$pow = $this->get_in_pow($awal, $latih);
				array_push($untuk_sum, $pow);
			}

			// $w['target'] =  $j['target'];
			$x['target'] =  $i['target'];
			$sum_all = array_sum($untuk_sum);
			$sqrt = round(sqrt($sum_all), 2);
			// $j['hasil'] = $sqrt;
			$i['hasil'] = $sqrt;
			$PengujianInput[$indexX] = $i;

			$indexX++;
		}
		// for ($i = 0; $i < $totalAll; $i++) {

		$HasilPengujian = $this->array_sort($PengujianInput, "hasil");

		$new_array_pelatihan = array('data' => $HasilPengujian, 'x' => $hasilBobotPelatihan, 'w' => $pengujian);


		return $new_array_pelatihan;
	}

	//MANUAL SORTING and Maintains index association.
	protected function array_sort($array, $on, $order = SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}
			$newIndex = 0;
			foreach ($sortable_array as $k => $v) {
				$new_array[$newIndex] = $array[$k];
				$newIndex++;
			}
		}

		return $new_array;
	}

	protected function getNewLearningRate($a, $deca)
	{
		return floatval($a - ($a * $deca));
	}

	public function updatePemenang($w, $x, $learningRate, $kelas_latih, $kelas_uji)
	{
		$parameterAir = $this->klasifikasi->get_all();
		$wBaru = array();
		foreach ($parameterAir->result() as $paramAir) {
			# code...
			$namaParam = $paramAir->nama_klasifikasi;
			$newName = strtolower($namaParam);
			$newX = $x[$newName];
			$newW = $w[$newName];
			$delta_w = $learningRate * ($newX - $newW);
			if ($kelas_latih == $kelas_uji) {
				$wBaru[$newName] = $newW + $delta_w;
			} else {
				$wBaru[$newName] = $newW - $delta_w;
			}
		}
		$wBaru['target'] = $w['target'];
		$wBaru['hasil'] = $w['hasil'];
		return $wBaru;
	}

	public function updateYCYR($w, $x, $learningRate, $kelas_latih)
	{
		# code...
		$parameterAir = $this->klasifikasi->get_all();
		$wBaru = array();
		$indexW = 0;
		foreach ($w as $key) {
			# code...
			foreach ($parameterAir->result() as $paramAir) {
				# code...
				$namaParam = $paramAir->nama_klasifikasi;
				$newName = strtolower($namaParam);
				$newX = $x[$newName];
				$newW = $key[$newName];
				$delta_w = $learningRate * ($newX - $newW);
				$targetPemenang = $key['target'];
				if ($kelas_latih == $targetPemenang) {
					$wBaru[$indexW][$newName] = $newW + $delta_w;
				} else {
					$wBaru[$indexW][$newName] = $newW - $delta_w;
				}
				$wBaru[$indexW]['target'] = $newX['target'];
				$wBaru[$indexW]['hasil'] = $newX['hasil'];
			}
			$indexW++;
		}
		return $wBaru;
	}

	public function updateRunner($w, $x, $learningRate)
	{
		# code...
		$parameterAir = $this->klasifikasi->get_all();
		$wBaru = array();
		foreach ($parameterAir->result() as $paramAir) {
			# code...
			$namaParam = $paramAir->nama_klasifikasi;
			$newName = strtolower($namaParam);
			$newX = $x[$newName];
			$newW = $w[$newName];
			$delta_w = $learningRate * ($newX - $newW);
			$wBaru[$newName] = $newW - $delta_w;
		}
		$wBaru['target'] = $w['target'];
		$wBaru['hasil'] = $w['hasil'];
		return $wBaru;
	}

	protected function cekDcDr($dc, $dr, $window)
	{
		return ($dc > (1 - $window) && $dr < (1 + $window)) ? true : false;
	}

	protected function get_in_pow($bobot_terbawa, $bobot_latih)
	{
		$calculate = round($bobot_latih - $bobot_terbawa, 4);
		return round(pow($calculate, 2), 2);
	}
}
