<?php

/**
 * 
 */
class Pengujian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if($this->session->has_userdata("username")){
			if($this->session->userdata('user_class')!=="penguji"){
				$this->session->set_flashdata("error", "Bukan halaman untuk kelas pengguna " . $this->session->userdata("user_class"));
				redirect(base_url());
			}
		}else{
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
		if($this->session->has_userdata('input_user')){
			$input_user = $this->session->userdata("input_user");
		}else{
			foreach ($data_klasifikasi->result() as $key) {
			$new = strtolower($key->nama_klasifikasi);
			$input_user[$new] = 0;
			}
		}
		$page = array('page' => 'index_pengujian', 'script' => null, 'title' => 'Pengujian', 'data_klasifikasi' => $data_klasifikasi, 'act' => 'Pengujian', 'input_user' =>$input_user);
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
		$window = $this->input->post("window", TRUE);
		// CEK LEARNING RATE LIMIT
		// var_dump($this->input->post());
		// exit();

		//GET INPUT VALUE
		$DataPengujianUser = $this->setPengujianValue();
		// $DataPengujianUser = $PengujianValue['DataPengujianUser'];
		// echo "<p>Data pengujian user :</p>";
		// echo json_encode($DataPengujianUser);

		$insert_data_latih = $this->Model_latih->insert_data($DataPengujianUser);
		// echo "<p> query insert : " . $this->db->last_query() . "</p>";
		if (!$insert_data_latih) {
			$this->session->set_flashdata("error", "Gagal Insert Data Latih Baru");
			redirect(base_url('Pengujian'));
		}
		$id_data_latih = $this->db->insert_id();
		// $new_pengujian->set_push_usedID($id_data_latih);
		// echo "<br> id latih : " . $id_data_latih . "<br>";
		// var_dump($new_pengujian);

		//TODO: INISIALISASI
		// $dataInitResultWeightUji = $this->getResultInitWeightUji($DataPengujianUser, $id_data_latih);
		// $target_awal = $target_input;
		$totalTrue = 0;
		$totalAll = 0;
		$resultCalculation = array();
		$BobotAwal = $this->getBobotAwalNormalized($id_data_latih);
		$id_bobot = $BobotAwal['id_bobot'];
		$nilaiDataLatih = $this->getBobotDataLatih($id_bobot);
		$dataLatihan = $nilaiDataLatih['x'];
		$DATA_UJI = $BobotAwal['w'];
		// echo "Data Uji : " . json_encode($DATA_UJI, JSON_PRETTY_PRINT) . "<br>";
		$target_awal = null;
		$pos1 = FALSE;
		$index_real = 0;
		$index_next = 1;
		$kondisiEpoch = ($epoch < $max_epoch) ? TRUE : FALSE;
		$kondisiLeraningRate = ($learningRate > $mina) ? TRUE : FALSE;
		$indexEpoch = 0;
		while (($epoch < $max_epoch) || ($learningRate > $mina)) {
			# code...
			$arrayTarget0 = array();
			$arrayTarget1 = array();
			$epoch++;
			$HitunganLVQ2 = $this->iterasiAndEuclideanDistance($DATA_UJI, $dataLatihan, $window, $learningRate);
			$DATA_UJI = $HitunganLVQ2['DATA_UJI'];
			$Hasilnya = $HitunganLVQ2['minDistanceEucl'];
			$FinalX = $Hasilnya['x_nya'];
			$TotalDataLatihan = $HitunganLVQ2['total_data_latih'];
			$TotalDataSesuai = $HitunganLVQ2['total_benar'];
			$Persentase = $HitunganLVQ2['persentase'];
			

			// PENGURANGAN LEARNING RATE
			$learningRate = $this->getNewLearningRate($learningRate, $deca);

			//CEK KONDISI UNTUK MENGEMBALIKAN HASIL PERHITUNGAN
			if (($epoch >= $max_epoch) || ($learningRate <= $mina)) {
				
				// echo "<p><b> Hasil Akhir : " . json_encode($Hasilnya, JSON_PRETTY_PRINT) . "</b></p>";
				$kondisiEpoch = ($epoch < $max_epoch) ? TRUE : FALSE;
				$kondisiLeraningRate = ($learningRate > $mina) ? TRUE : FALSE;
				// echo "<br>Kondisi epoch ($epoch < $max_epoch) : " . $kondisiEpoch . ". <br> Kondisi learning rate ($learningRate > $mina) : " . $kondisiLeraningRate . " . <br>";
				// echo "Total success : " . $TotalDataSesuai . "<br>";
				// echo "Total All : " . $TotalDataLatihan . "<br>";
				// $percentOfSuccess = ($totalTrue / $totalAll) * 100;
				$percentOfSuccess = round($Persentase, 2);
				$kelasTarget = $FinalX['target'];
				$nilaiKelas = $Hasilnya['hasil'];
				// echo "akurasi : " . $percentOfSuccess . "% untuk kelas " . $kelasTarget;
				$resultCalculation = array(
					'learning_rate' => $learningRate,
					'window' => $window,
					'percentage' => $percentOfSuccess,
					'kelas' => $kelasTarget,
					'nilai' => $nilaiKelas,
					'bobot' => $FinalX,
					'user_input' => $this->input->post(),
					'TotalDataLatihan' => $TotalDataLatihan,
					'TotalDataSesuai' => $TotalDataSesuai
				);
				break;
			}
			$indexEpoch++;
		}
		// echo "<p> END HASIL : " . json_encode($resultCalculation) . "<p>";
		$data_page = array('page' => 'hasil_pengujian', 'script' => null, 'title' => 'Hasil Pengujian', 'hasil' => $resultCalculation, 'act' => 'Pengujian', 'data_klasifikasi' => $this->klasifikasi->get_all());
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
		$target = $this->input->post("target", TRUE);
		$DataPengujianUser = array(
			"ph" => $ph,
			"tds" => $tds,
			"th" => $th,
			"fe" => $fe,
			"mn" => $mn,
			"so4" => $so4,
			"tc" => $tc,
			"target" => $target
		);
		$this->session->set_userdata('input_user', $DataPengujianUser);
		return $DataPengujianUser;
	}

	protected function iterasiAndEuclideanDistance($pengujian = array(), $dataLatihan, $window, $learningRate)
	{
		// $nilaiDataLatih = $this->getBobotDataLatih($id_data_bobot);
		// $dataLatihan = $nilaiDataLatih['x'];
		// EUCLIDEAN
		// $kelas_euclidean_distance = 
		// KELAS YANG DIDAPAT (HASIL YANG PALING MINIMUM)
		return $this->euclidean_distance_init($pengujian, $dataLatihan, $window, $learningRate);
	}

	protected function getBobotDataLatih($id_bobot_array)
	{
		$data_latih = $this->Model_latih->getDataLatih($id_bobot_array, 12);
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

	protected function euclidean_distance_init($pengujian = array(), $data_latih, $window, $learningRate)
	{
		// echo "<br> nilai pengujian : <br>";
		// var_dump($pengujian);
		// echo "<p> nilai data latih : </p>";
		// var_dump($data_latih);
		// echo "<p> Total data pengujian : " . count($pengujian) . "<p>";
		// echo "<p> Data pengujian sebagai berikut : " . json_encode($pengujian, JSON_PRETTY_PRINT);
		$HitungPerPelatihan = array();
		$totalAll = count($data_latih);
		$totalTrue = 0;
		$DJ = array();
		$indexKelas = 0;
		$DISTANCES = array();
		$DISTANCES_LATIH = array();
		$indexX = 0;
		foreach ($data_latih as $i) {
			$smallestPengujian = array();
			$indexW = 0;
			foreach ($pengujian as $j) {
				$UJIDATA = $this->klasifikasi->get_all();
				
				$untuk_sum = array();
				$w = array();
				$x = array();
				foreach ($UJIDATA->result() as $k) {
					// echo json_encode($k);
					$lower = strtolower($k->nama_klasifikasi);
					$awal = $j[$lower];
					$latih = $i[$lower];
					$pow = $this->get_in_pow($awal, $latih);
					array_push($untuk_sum, $pow);
					$w[$lower] = round($awal, 2);
					$x[$lower] = round($latih, 2);
				}
				
				$w['target'] =  $j['target'];
				$x['target'] =  $i['target'];
				$sum_all = array_sum($untuk_sum);
				$sqrt = round(sqrt($sum_all), 2);
				$HitungPerPelatihan = array(
					'hasil' => $sqrt,
					'x_nya' => $x,
					'x' => $data_latih,
					'w_nya' => $w,
					'w' => $pengujian,
					'indexX' => $indexX,
					'indexW' => $indexW,
				);
				$smallestPengujian[$indexW] = $HitungPerPelatihan;
				$indexW++;
			}
			// $DISTANCES[$i] = $smallestPengujian;
			$DISTANCES = $this->array_sort($smallestPengujian, "hasil");
			// echo "<p>D $indexW terendah adalah : " . json_encode($DISTANCES[0]) . "<p>";
			$DISTANCES_LATIH[$indexX] = $DISTANCES[0];
			$DJ[$indexX] = $DISTANCES[0];
			$D_I_J = $DISTANCES_LATIH[$indexX];
			$WIJ = $D_I_J['w_nya'];
			$XIJ = $D_I_J['x_nya'];
			$WTarget = $WIJ['target'];
			$XTarget = $XIJ['target'];
			if ($WTarget === $XTarget) {
				$totalTrue++;
			}
			$indexX++;
		}
		// for ($i = 0; $i < $totalAll; $i++) {

		$DISTANCES_LATIH = $this->array_sort($DISTANCES_LATIH, "hasil");

		// }
		// echo "<p><b>Total Data: $totalAll . total true : $totalTrue</b></p>";
		$persentase = (floatval($totalTrue / $totalAll)) * 100;
		// $verySmallest
		// $DistanceEucl = $this->array_sort($DJ, "hasil");
		$minDistanceEucl = $DISTANCES_LATIH[0];
		$targetWMin = $minDistanceEucl['w_nya']['target'];
		$targetxMin = $minDistanceEucl['x_nya']['target'];
		$BobotDistanceMin =$DISTANCES_LATIH[0]['w'];
		$LatihDistanceMin = $DISTANCES_LATIH[0]['x'];
		if ($targetWMin === $targetxMin) {
			// $totalTrue++;
			// echo "<p> WINNER IS : " . json_encode($minDistanceEucl) . "<p>";
			$pengujian = $this->targetAwalSamaDenganTargetHasil($pengujian, $minDistanceEucl['x'], $learningRate, $minDistanceEucl);
		} else {
			$result_hasil_akhir = $DISTANCES_LATIH[1]['hasil'];
			$pengujian = $this->targetAwalTidakSamaDenganTargetHasil($pengujian, $DISTANCES_LATIH, $window, $learningRate);
		}
		// echo "<p>Very smallest last : " . json_encode($verySmallest, JSON_PRETTY_PRINT) . " </p>";
		// echo "<p><b>Target: $targetWMin . Persentase : " . $persentase . " %</b></p>";
		// exit();
		// echo "<br> hasil array euclidean: <br>";
		// echo json_encode($init_kelas);
		// $WINNER = $init_kelas[0];
		// $new_pengujian->set_push_usedID($WINNER['id']);
		// $new_pengujian->set_kelas($init_kelas[0]);
		$returnMap = array('DATA_UJI' => $pengujian, 'minDistanceEucl' => $minDistanceEucl, 'persentase' => $persentase, 'total_data_latih' => $totalAll, 'total_benar' => $totalTrue);
		return $returnMap;
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

	protected function targetAwalSamaDenganTargetHasil(array $wLama, $x, $learningRate, $hasil)
	{
		$indexXYangDipakai = $hasil['indexX'];
		$indexWYangDiUbah = $hasil['indexW'];
		$ModelKlasifikasi = $this->klasifikasi;
		$data_klasifikasi = $ModelKlasifikasi->get_all();
		$revisiW = $wLama[$indexWYangDiUbah];
		$XNYA = $x[$indexXYangDipakai];
		// echo "<p>WLama nya  adalah : </p>";
		// echo json_encode($wLama, JSON_PRETTY_PRINT);
		// echo "<p>Index bobot yang diubah : $indexWYangDiUbah </p>";
		// echo "<p>X yang dipakai : " . json_encode( $x[$indexXYangDipakai] , JSON_PRETTY_PRINT) . "<p>";
		// exit();
		foreach ($data_klasifikasi->result() as $klasifikasi) {
			$klasifikasiName = $klasifikasi->nama_klasifikasi;
			$lName = strtolower($klasifikasiName);
			// echo "$ x [$lName] : " . $revisiW[$lName] . "<br>";
			// echo "<p>w [$lName] :" . $revisiW[$lName] . " </p>";
			$lastCalculationKlasifikasi = round($learningRate * ($XNYA[$lName] - $revisiW[$lName]), 2);
			$wLama[$indexWYangDiUbah][$lName] = round($revisiW[$lName] + $lastCalculationKlasifikasi, 2);
		}
		$wLama[$indexWYangDiUbah]['target'] = $revisiW['target'];

		// echo "<p>WBaru adalah : </p>";
		// echo json_encode($wLama[$indexWYangDiUbah], JSON_PRETTY_PRINT);
		// echo "<p>Sehingga W yang dibawa akan menjadi seperti ini : " . json_encode($wLama). " </p>";
		// foreach ($wLama as $key => $value) {
		// 	# code...
		// 	$w = $wLama[$key];
			
		// }
		return $wLama;
	}

	protected function targetAwalTidakSamaDenganTargetHasil($pengujian, $winners, $window, $learningRate)
	{
		# code...
		$yc = $winners[0]['w'];
		$yr = $winners[1]['w'];
		$dc = $winners[0]['hasil'];
		$dr = $winners[1]['hasil'];
		$dcCondition = 1 - $window;
		$drCondition = 1 + $window;
		if ($dc > $dcCondition && $dr < $drCondition) {
			return $this->windowTerpenuhi($pengujian, $winners, $learningRate);
		} else {
			$x = $winners[0];
			return $this->windowTidakTerpenuhi($pengujian, $winners, $learningRate);
		}
	}

	protected function windowTerpenuhi($pengujian, $winners, $learningRate)
	{
		# code...
		$new_klasifikasi = $this->klasifikasi;
		$data_klasifikasi = $new_klasifikasi->get_all();
		$yc = $winners[0]['w'];
		$yr = $winners[1]['w'];
		$x = $winners[0]['x'];
		$newYC = array();
		$newYR = array();
		foreach ($data_klasifikasi->result() as $klasifikasi) {
			$klasifikasiName = $klasifikasi->nama_klasifikasi;
			$lName = strtolower($klasifikasiName);
			$Y = round($yc[$lName], 2);
			$lastCalculationY = round(($learningRate * ($x[$lName] - $yc[$lName])), 2);
			// PERBARUI NILAI YC
			$newYC[$lName] = round($Y - $lastCalculationY, 2);
			// PERBARUI NILAI YR
			$newYR[$lName] = round($Y + $lastCalculationY, 2);
		}
		$winners[0]['w'] = $newYC;
		$winners[1]['w'] = $newYR;
		return $winners;
	}

	protected function windowTidakTerpenuhi($pengujian, $winner2, $learningRate)
	{
		# code...
		$new_klasifikasi = $this->klasifikasi;
		$data_klasifikasi = $new_klasifikasi->get_all();
		$returnArray = $pengujian;
		$w = $winner2[0]['w'];
		$yr = $winner2[1]['w'];
		$x = $winner2[0]['x'];
		$wBaru = array();
		foreach ($data_klasifikasi->result() as $klasifikasi) {
			$klasifikasiName = $klasifikasi->nama_klasifikasi;
			$lName = strtolower($klasifikasiName);

			$lastCalculationWBaru = ($learningRate * ($x[$lName] - $w[$lName]));
			// PERBARUI NILAI YC
			$wBaru[$lName] = $w[$lName] - $lastCalculationWBaru;
			// PERBARUI NILAI YR
		}
		$returnArray[0]['w'] = $wBaru;
		return $returnArray;
	}



	// public function get_klasifikasi()
	// {
	// 	return $this->klasifikasi;
	// }

	protected function get_in_pow($bobot_terbawa, $bobot_latih)
	{
		$calculate = round($bobot_latih - $bobot_terbawa, 4);
		return round(pow($calculate, 2), 2);
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
