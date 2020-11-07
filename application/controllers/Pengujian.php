<?php

use phpDocumentor\Reflection\Types\Boolean;

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
		$mina = 0.01;
		$window = floatval($this->input->post("window", TRUE));

		//GET INPUT VALUE
		$DataPengujianUser = $this->setPengujianValue();


		$resultCalculation = array();
		$BobotAwal = $this->getBobotAwalNormalized();
		$id_bobot = $BobotAwal['id_bobot'];
		$dataUji = $this->getDataUji($id_bobot);
		$used_id = $dataUji['used_id'];
		$nilaiDataLatih = $this->getBobotDataLatih($used_id);
		$dataLatihan = $nilaiDataLatih['x'];
		$DATA_BOBOT_AWAL = $BobotAwal['w'];
		$indexEpoch = 0;
		$BobotTeroptimalisasi = null;
		$HitunganLVQ2 = array();
		// PELATIHAN LVQ 2
		$KondisiEpoch1 = ($epoch < $max_epoch) ? TRUE : FALSE;
		$KondisiAlpha1 = ($learningRate > $mina) ? TRUE : FALSE;
		while ($KondisiEpoch1 || $KondisiAlpha1) {
			# code...
			$epoch++;

			$HitunganLVQ2 = $this->euclidean_distance_init($DATA_BOBOT_AWAL, $dataLatihan, $window, $learningRate);
			$DATA_BOBOT_AWAL = $HitunganLVQ2['BobotOptimal'];

			$TotalDataLatihan = $HitunganLVQ2['total_data_latih'];
			$TotalDataSesuai = $HitunganLVQ2['total_benar'];
			$Persentase = $HitunganLVQ2['persentase'];


			//CEK KONDISI UNTUK MENGEMBALIKAN HASIL PERHITUNGAN
			$kondisiEpoch2 = ($epoch >= $max_epoch) ? TRUE : FALSE;
			$kondisiAlpha2 = ($learningRate <= $mina) ? TRUE : FALSE;
			if ($kondisiEpoch2 || $kondisiAlpha2) {
				$BobotTeroptimalisasi = $DATA_BOBOT_AWAL;
				break;
			}
			// PENGURANGAN LEARNING RATE		
			$learningRate = $this->getNewLearningRate($learningRate, $deca);
			$indexEpoch++;
		}

		$resultCalculation = array();


		// PENGUJIAN LVQ 2
		$PengujianLVQ2 = $this->euclidean_distance_pengujian($dataUji['x'], $BobotTeroptimalisasi);
		// echo "Hasil Pengujian : " . json_encode($PengujianLVQ2, JSON_PRETTY_PRINT);
		// exit();
		$KlasifikasiLVQ2 = $this->euclidean_klasifikasi($DataPengujianUser, $BobotTeroptimalisasi);
		$total_data_uji = $PengujianLVQ2['total_data_uji'];
		$total_benar = $PengujianLVQ2['total_data_uji_benar'];
		$total_data_latih = count($dataLatihan);
		$akurasi_data = floatval (($total_benar/$total_data_latih) * 100);
		$hasil_perhitungan = array(
			'learning_rate' => $learningRate,
			'window' => $window,
			'percentage' => round($akurasi_data, 3),
			// 'hasil_pengujian' => $KlasifikasiLVQ2['data'],
			'user_input' => $this->input->post(),
			'TotalDataLatihan' => $total_data_latih,
			'TotalDataUji' => $total_data_uji,
			'TotalDataSesuai' => $total_benar,
			'kelas' => $KlasifikasiLVQ2['target'],
			'hasil_pengujian' => $KlasifikasiLVQ2
		);
		// echo "<p> END HASIL : " . json_encode($hasil_perhitungan) . "<p>";
		// exit();
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
		$result_data_latih = $data_latih->result_array();
		$latih_ternormalisasi = $this->getNormalizeData($result_data_latih);

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
		$data_uji = $bobot0->result_array();
		$bobot_ternormalisasi = $this->getNormalizeData($data_uji);
		return array('w' => $bobot_ternormalisasi, 'id_bobot' => $id_bobot_array);
	}

	public function getDataUji($id_bobot_awal)
	{
		# code...
		$data = $this->Model_latih->getDataUji($id_bobot_awal);
		$used_id = $id_bobot_awal;
		foreach ($data->result() as $key) {
			# code...
			$used_id[] = $key->id_data_latih;
		}
		$result_data = $data->result_array();
		$normalized_data = $this->getNormalizeData($result_data);
		return array('x' => $normalized_data, 'used_id' => $used_id);
	}

	protected function getNormalizeData($data)
	{
		$data_normalisasi = array();
		$dataMinMax = $this->Model_latih->getDataMinMax()->row_array();
		// echo "<p> Data awal yang dibutuhkan : " . json_encode($data_awal->result_array()) . "</p>";
		foreach ($data as $key) {
			$tc_atas = $key['tc'] - $dataMinMax['min_tc'];
			$tc_bawah = $dataMinMax['max_tc'] - $dataMinMax['min_tc'];
			$tc = round($tc_atas / $tc_bawah, 3);

			$so4_atas = $key['so4'] - $dataMinMax['min_so4'];
			$so4_bawah = $dataMinMax['max_so4'] - $dataMinMax['min_so4'];
			$so4 = round($so4_atas / $so4_bawah, 3);

			$mn_atas = $key['mn'] - $dataMinMax['min_mn'];
			$mn_bawah = $dataMinMax['max_mn'] - $dataMinMax['min_mn'];
			$mn = round($mn_atas / $mn_bawah, 3);

			$fe_atas = $key['fe'] - $dataMinMax['min_fe'];
			$fe_bawah = $dataMinMax['max_fe'] - $dataMinMax['min_fe'];
			$fe = round($fe_atas / $fe_bawah, 3);

			$th_atas = $key['th'] - $dataMinMax['min_th'];
			$th_bawah = $dataMinMax['max_th'] - $dataMinMax['min_th'];
			$th = round($th_atas / $th_bawah, 3);

			$tds_atas = $key['tds'] - $dataMinMax['min_tds'];
			$tds_bawah = $dataMinMax['max_tds'] - $dataMinMax['min_tds'];
			$tds = round($tds_atas - $tds_bawah, 3);

			$ph_atas = $key['ph'] - $dataMinMax['min_ph'];
			$ph_bawah = $dataMinMax['max_ph'] - $dataMinMax['min_ph'];
			$ph = round($ph_atas - $ph_bawah, 3);

			$data_normalisasi[] = array('ph' => $ph, 'tds' => $tds, 'th' => $th, 'fe' => $fe, 'mn' => $mn, 'so4' => $so4, 'tc' => $tc, 'target' => $key['target']);
		}
		return $data_normalisasi;
	}

	protected function euclidean_distance_init($BobotAwal = array(), $data_latih = array(), float $window = 0.1, float $learningRate = 0.1)
	{
		// "Masuk Pelatihan euclidean distance";
		// echo "Data Bobot Awal : " . json_encode($pengujian);
		$totalAll = count($data_latih);
		// exit();
		$total_benar = 0;

		$index_W = 0;
		$parameterAir = $this->klasifikasi->get_all();
		$result = array();
		$a = 0;
		// BACA DATA LATIH
		foreach ($data_latih as $i) {
			$X = $i;
			$target_x = $i['target'];
			$untuk_sum = array();
			$b = 0;
			// BACA DATA BOBOT AWAL
			foreach ($BobotAwal as $j) {
				foreach ($parameterAir->result() as $k) {
					# code...
					$lower = strtolower($k->nama_klasifikasi);
					$bobotAwal = round($i[$lower], 2);
					$bobotLatih = round($j[$lower], 2);

					$pow = $this->get_in_pow($bobotLatih, $bobotAwal);
					array_push($untuk_sum, round($pow, 3));
				}
				$sum = array_sum($untuk_sum);
				$dst = sqrt($sum);
				$target_w = $j['target'];
				$j['index_w'] = $b;
				$j['index_X'] = $a;
				$j['hasil'] = $dst;
				$j['target_x'] = $target_x;
				$j['target_w'] = $target_w;
				// array_push($j, array('index_w' => $b, 'index_x' => $a, 'hasil' => $dst, 'target_x' => $target_x, 'target_w' => $target_w));
				$BobotAwal[$b] = $j;
				// $result[$b] = array('w' => $j, 'index_w' => $b, 'index_x' => $a, 'hasil' => $dst, 'target_x' => $target_x, 'target_w' => $target_w);
				$b++;
			}
			// SORTING UNTUK DAPATKAN WINNER
			$BobotAwal = $this->array_sort($BobotAwal, "hasil", SORT_ASC);
			
			// UPDATE BOBOT AWAL UNTUK OPMILAISASI NILAI
			$update = $this->update_pengujian($BobotAwal, $i, $learningRate, $window, $total_benar);
			$BobotAwal = $update['w'];
			$total_benar = $update['total_benar'];
			$a++;
		}
		// echo "<p>Hasil Pelatihan : " . json_encode($BobotAwal) . "</p>";
		// exit();

		// echo "<p>Hasil terupdate pengujian : " . json_encode($BobotAwal) . "</p>";
		$akurasi = (floatval(floatval($total_benar) / floatval($totalAll))) * 100;
		// echo " akurasi : " . $akurasi;
		$returnMap = array('BobotOptimal' => $BobotAwal, 'persentase' => $akurasi, 'total_data_latih' => $totalAll, 'total_benar' => $total_benar);
		return $returnMap;
	}

	public function update_pengujian($pengujian, $i = array(), $learningRate, $window, $total_benar = 0)
	{
		# code...
		$pemenang = $pengujian[0];
		$runnerup = $pengujian[1];
		$targetPemenang = $pemenang['target_x'];
		$targetRunnerup = $runnerup['target_x'];

		$targetWPemenang = $pemenang['target_w'];
		$targetWRunnerup = $runnerup['target_w'];

		$distancePemenang = $pemenang['hasil'];
		$distanceRunnerup = $runnerup['hasil'];

		$array_latih_pemenang = $pemenang['index_X'];
		$array_latih_runnerup = $runnerup['index_X'];

		if ($targetPemenang == $targetWPemenang) {
			$total_benar++;
			$pengujian[0] = $this->updatePemenang($pengujian[0], $i, $learningRate, $targetWPemenang, $targetPemenang);
		} else {
			$kondisi = $this->cekDcDr($distancePemenang, $distanceRunnerup, $window);
			if ($kondisi) {

				$pengujian = $this->updateYCYR($pengujian, $i, $learningRate, $targetPemenang);
			} else {
				// echo "FALSE";
				// exit();
				$pengujian[0] = $this->updatePemenang($pengujian[0], $i, $learningRate, $targetWPemenang, $targetPemenang);
				$pengujian[1] = $this->updateRunner($pengujian[1], $array_latih_runnerup, $learningRate);
			}
		}
		return array('w' => $pengujian, 'total_benar' => $total_benar);
	}

	public function euclidean_distance_pengujian($pengujian, $hasilBobotPelatihan)
	{
		// echo "========Masuk Pengujian========<br>";
		$total_benar = 0;
		$total_data_uji = count($pengujian);
		// echo "Data Uji : " . json_encode($pengujian) . "<br>";
		foreach ($pengujian as $j) {
			# code...
			$indexX = 0;
			$PengujianBobotOptimal = array();
			
			foreach ($hasilBobotPelatihan as $i) {

				// $j = $pengujian;
				$ParameterAir = $this->klasifikasi->get_all();

				$untuk_sum = array();
				// $w = array();
				$x = array();
				foreach ($ParameterAir->result() as $k) {
					// echo json_encode($k);
					$lower = strtolower($k->nama_klasifikasi);
					$awal = floatval(round($j[$lower], 3));
					$latih = floatval(round($i[$lower], 3));
					$pow = $this->get_in_pow($awal, $latih);
					array_push($untuk_sum, $pow);
				}

				// $w['target'] =  $j['target'];
				$x['target'] =  $i['target'];
				$sum_all = array_sum($untuk_sum);
				$sqrt = round(sqrt($sum_all), 3);
				// $j['hasil'] = $sqrt;
				$i['hasil'] = $sqrt;
				$i['target_opt'] = $i['target'];
				$i['target_uji'] = $j['target'];
				$i['data_uji'] = $j;
				$PengujianBobotOptimal[$indexX] = $i;

				$indexX++;
			}
			$PengujianBobotOptimal = $this->array_sort($PengujianBobotOptimal, "hasil", SORT_ASC);
			$WinnerPengujianBobotOptimal = $PengujianBobotOptimal[0];
			$target_opt = $WinnerPengujianBobotOptimal['target_opt'];
			$target_uji = $WinnerPengujianBobotOptimal['target_uji'];
			$kondisiTarget = ($target_opt == $target_uji) ? TRUE : FALSE;
			$total_benar = ($kondisiTarget) ? $total_benar + 1 : $total_benar + 0;
		}

		// for ($i = 0; $i < $totalAll; $i++) {

		// $HasilPengujian = $this->array_sort($PengujianInput, "hasil");

		$new_array_pelatihan = array('data_uji' => $pengujian, 'bobot_optimal' => $hasilBobotPelatihan, 'total_data_uji' => $total_data_uji, 'total_data_uji_benar' => $total_benar);


		return $new_array_pelatihan;
	}

	public function euclidean_klasifikasi($user_input, $bobot_optimal)
	{
		# code...
		$indexX = 0;
		$KlasifikasiInput = array();
		foreach ($bobot_optimal as $i) {

			$j = $user_input;
			$ParameterAir = $this->klasifikasi->get_all();

			$untuk_sum = array();
			// $w = array();
			$x = array();
			foreach ($ParameterAir->result() as $k) {
				// echo json_encode($k);
				$lower = strtolower($k->nama_klasifikasi);
				$awal = floatval(round($j[$lower], 3));
				$latih = floatval(round($i[$lower], 3));
				$pow = $this->get_in_pow($awal, $latih);
				array_push($untuk_sum, $pow);
			}
			
			$x['target'] =  $i['target'];
			$sum_all = array_sum($untuk_sum);
			$sqrt = round(sqrt($sum_all), 3);
			
			$i['hasil'] = $sqrt;
			$i['data_uji'] = $j;
			$KlasifikasiInput[$indexX] = $i;
			$indexX++;
		}
		$result = $this->array_sort($KlasifikasiInput, "hasil", SORT_ASC);
		$win = $result[0];
		return $win;
	}

	public function euclidean_distance_pengujianV2($pengujian, $bobot)
	{
		# code...
		$indexX = 0;
		foreach ($bobot as $i) {
			$PengujianInput = array();
			$j = $pengujian;
			$ParameterAir = $this->klasifikasi->get_all();

			$untuk_sum = array();
			// $w = array();
			$x = array();
			foreach ($ParameterAir->result() as $k) {
				// echo json_encode($k);
				$lower = strtolower($k->nama_klasifikasi);
				$awal = floatval(round($j[$lower], 3));
				$latih = floatval(round($i[$lower], 3));
				$pow = $this->get_in_pow($awal, $latih);
				array_push($untuk_sum, $pow);
			}

			// $w['target'] =  $j['target'];
			$x['target'] =  $i['target'];
			$sum_all = array_sum($untuk_sum);
			$sqrt = round(sqrt($sum_all), 3);
			// $j['hasil'] = $sqrt;
			$i['hasil'] = $sqrt;
			$PengujianInput[$indexX] = $i;

			$indexX++;
		}
		// for ($i = 0; $i < $totalAll; $i++) {

		$HasilPengujian = $this->array_sort($PengujianInput, "hasil");

		$new_array_pelatihan = array('data' => $HasilPengujian, 'x' => $bobot, 'w' => $pengujian);


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

	protected function get_in_pow($bobot_latih, $bobot_terbawa)
	{
		$calculate = round($bobot_latih - $bobot_terbawa, 4);
		return round(pow($calculate, 2), 2);
	}
}
