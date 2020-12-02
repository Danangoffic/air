<?php

/**
 * 
 */
class Model_klasifikasi extends CI_Model
{
	public $id_klasifikasi;
	public function get_all()
	{
		$this->db->order_by('id_klasifikasi', 'ASC');
		return $this->db->get('master_klasifikasi_air');
	}

	public function set_id_klasifikasi($id_klasifikasi = 0)
	{
		$this->id_klasifikasi = $id_klasifikasi;
	}

	public function get_id_klasifikasi()
	{
		return $this->id_klasifikasi;
	}

	public function get_by($id_klasifikasi = 0)
	{
		$this->db->where('id_klasifikasi =', $id_klasifikasi);
		return $this->db->get('master_klasifikasi_air');
	}

	public function insert($data = array())
	{
		return $this->db->insert('master_klasifikasi_air', $data);
	}

	public function update($id_klasifikasi = 0, $data = array())
	{
		$this->db->where('id_klasifikasi =', $id_klasifikasi);
		return $this->db->update('master_klasifikasi_air', $data);
	}

	public function get_data_normalisasi($nilai = 0.0, $type = "")
	{
		$this->db->select("$type, min($type) as minimum_latih, max($type) as maximum_latih");
		$this->db->from("data_latih");
		$this->db->order_by("id_data_latih", "ASC");
		$data = $this->db->get();
		foreach ($data->result as $latih) {
			$normalisasi = ($nilai - $latih->minimum_latih) / ($latih->maximum_latih - $latih->minimum_latih);
		}
	}

	protected function FindEuclidean($a = array(), $b = array())
	{
		return array_sum(array_map(function ($x, $y) {
			return abs($x - $y) ** 2;
		}, $a, $b)) ** (1 / 2);
	}
}
