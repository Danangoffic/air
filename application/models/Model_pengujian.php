<?php

use phpDocumentor\Reflection\Types\Array_;

class Model_pengujian extends CI_Model
{
    public $tc;
    public $mn;
    public $so4;
    public $fe;
    public $th;
    public $tds;
    public $ph;
    public $default_pengkali = 0.8;
    public $default_penambah = 0.1;
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
    public $closest=array();
    public $max_learning_rate = 1.0;
	public $encrease_learning_rate = 0.1;
	public $used_id = array();
	public $used_vector = array();

    // public function set_tc($tc)
    // {
    //     $this->tc = $tc;
    // }

    // public function get_tc()
    // {
    //     return $this->tc;
    // }

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
		return $this->default_penambah;
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

	public function get_converted_tc($TC)
	{
		if ($TC > 0 && $TC < 10) {
			return 1;
		} else if ($TC == 0) {
			return 2;
		} else if ($TC > 10) {
			return 3;
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
		if ($SO4 <= 200) {
			$this->v_so4 = 1;
		} elseif($SO4 > 200 && $SO4 < 401){
            $this->v_so4 = 2;
        } else {
			$this->v_so4 = 3;
		}
	}

	public function get_converted_so4($SO4)
	{
		if ($SO4 <= 200) {
			return 1;
		} elseif($SO4 > 200 && $SO4 < 401){
            return 2;
        } else {
			return 3;
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
		if ($Mn < 0.2) {
			$this->v_mn = 2;
		} else if ($Mn > 0.1 && $Mn < 0.6) {
			$this->v_mn = 1;
		} else if ($Mn > 0.5) {
			$this->v_mn = 3;
		}
	}

	public function get_converted_mn($Mn)
	{
		if ($Mn < 0.2) {
			return 2;
		} else if ($Mn > 0.1 && $Mn < 0.6) {
			return 1;
		} else if ($Mn > 0.5) {
			return 3;
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

	public function get_converted_fe($Fe)
	{
		if ($Fe <= 0.3) {
			return 2;
		} else if ($Fe > 0.3 && $Fe <= 1) {
			return 1;
		} else if ($Fe > 1) {
			return 3;
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
		if ($Th <= 250) {
			$this->v_th = 1;
		}elseif($Th < 501){
            $this->v_th = 2;
        } else if ($Th > 500) {
			$this->v_th = 3;
		}
	}

	public function get_converted_th($Th)
	{
		if ($Th <= 250) {
			return 1;
		}elseif($Th < 501){
            return 2;
        } else if ($Th > 500) {
			return 3;
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

	public function get_connverted_tds($TDS)
	{
		if ($TDS < 1000) {
			return 1;
		} else if ($TDS > 1000 && $TDS < 1501) {
			return 2;
		} else if ($TDS > 1500) {
			return 3;
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

	public function get_converted_ph($Ph)
	{
		if ($Ph >= 6.5 && $Ph <= 9.0) {
			return 1;
		} else if ($Ph >= 6.5 && $Ph <= 8.5) {
			return 2;
		} else if ($Ph > 9.0 || $Ph < 6.5) {
			return 3;
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

	public function getTargetFromDataLatih($TC_CONVERTED)
	{
		if ($TC_CONVERTED === 0) {
			return 1;
		} elseif ($TC_CONVERTED > 0 && $TC_CONVERTED < 11) {
			return 2;
		} else {
			return 3;
		}
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
    
    public function result_var(float $a = 0, float $min = 0, float $max = 0)
	{
		$min_result = $min - $a;
		$max_result = $max - $a;
		return ((0.8 * $min_result) / $max_result) + 0.1;
	}
    
    public function setClosestVector($search, array $arr)
	{
        $return=null;
		foreach ($arr as $item) {
			if ($return === null || abs($search - $return) > abs($item - $search)) {
				$return = $item;
			}
		}
		$this->closest = $return;
    }
    
    public function getClosestVector()
    {
        return $this->closest;
    }

    public function setDistanceXBetween($X, $closestVector)
    {
        
	}
	
	public function set_push_usedID($id)
	{
		array_push($this->used_id, $id);
	}

	public function get_usedID()
	{
		return $this->used_id;
	}
}
