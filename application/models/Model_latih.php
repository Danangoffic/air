<?php

use phpDocumentor\Reflection\Types\Array_;

class Model_latih extends CI_Model
{
	public $tc = 0;
	public $so4 = 0.0;
	public $mn = 0.0;
	public $fe = 0.0;
	public $th = 0;
	public $tds = 0;
	public $ph = 6.0;
	public $target = 0;
	public $id_data_latih;

	public function findAll($id = false)
	{
		if ($id) $this->db->where('id_data_latih', $id);
		$this->db->order_by('id_data_latih', 'ASC');
		return $this->db->get("data_latih");
	}

	public function get_first()
	{
		$this->db->order_by('id_data_latih', 'ASC');
		$this->db->limit(1);
		return $this->db->get('data_latih');
	}

	public function get_data_latih()
	{
		$this->db->select_max('ph', 'max_ph')
			->select_max('tds', 'max_tds')
			->select_max('th', 'max_th')
			->select_max('fe', 'max_fe')
			->select_max('mn', 'max_mn')
			->select_max('so4', 'max_so4')
			->select_max('tc', 'max_tc')
			->select_max('target', 'max_target')
			->select_min('ph', 'min_ph')
			->select_min('tds', 'min_tds')
			->select_min('th', 'min_th')
			->select_min('fe', 'min_fe')
			->select_min('mn', 'min_mn')
			->select_min('so4', 'min_so4')
			->select_min('tc', 'min_tc')
			->select_min('target', 'min_target')
			->select("target")
			->select('data_latih.*')
			// ->order_by('id_data_latih', 'ASC')
			->from("data_latih");
		return $this->db->get();
	}

	public function getDataMinMax()
	{
		$this->db->select_max('ph', 'max_ph')
			->select_max('tds', 'max_tds')
			->select_max('th', 'max_th')
			->select_max('fe', 'max_fe')
			->select_max('mn', 'max_mn')
			->select_max('so4', 'max_so4')
			->select_max('tc', 'max_tc')
			->select_max('target', 'max_target')
			->select_min('ph', 'min_ph')
			->select_min('tds', 'min_tds')
			->select_min('th', 'min_th')
			->select_min('fe', 'min_fe')
			->select_min('mn', 'min_mn')
			->select_min('so4', 'min_so4')
			->select_min('tc', 'min_tc')
			->select_min('target', 'min_target')
			->select("target")
			->select('data_latih.*')
			// ->order_by('id_data_latih', 'ASC')
			->from("data_latih");
		return $this->db->get();
	}

	public function getDataUjiUser()
	{
		$this->db->select('data_latih.*')
			->order_by('id_data_latih', 'ASC')
			->from("data_latih")
			->limit(3);
		// ->group_by("target");
		return $this->db->get();
	}

	public function getDataUji(array $id_data_bobot)
	{
		# code...
		$this->db->select('data_latih.*')
			->order_by('id_data_latih', 'ASC')
			->from("data_latih")
			->where_not_in("id_data_latih", $id_data_bobot)
			->limit(15);
		// ->group_by("target");
		return $this->db->get();
	}

	public function getDataUjiUserNotInWhere($id_bobot = array())
	{
		$this->db->select('data_latih.*')
			->order_by('target', 'ASC')
			->from("data_latih")
			->where_not_in($id_bobot)
			// ->limit(9);
			->group_by("target");
		return $this->db->get();
	}

	public function getDataLatih($array_id_bobot, $limit = 60)
	{
		$this->db->where_not_in("id_data_latih", $array_id_bobot);
		$this->db->select('data_latih.*')
			->order_by('id_data_latih', 'DESC')
			->limit($limit)
			->from("data_latih");
		return $this->db->get();
	}

	public function getDataLatihSpesifikWithException($tipe = "x", $exception = null, $limit = null)
	{
		// x untuk latih , w untuk bobot
		if ($exception !== null) {
			if (is_array($exception)) {
				$this->db->where_not_in("id_data_latih", $exception);
			} else {
				$this->db->where("id_data_latih !=", $exception);
			}
		}
		if ($tipe == "w") {
			$limit = 6;
			$this->db->limit($limit);
		} else {
			if ($limit !== null || $limit > 5) {
				$this->db->limit($limit);
			}
		}
		$this->db->reset_query();
		$this->db->order_by('id_data_latih', 'DESC');

		return $this->get_data_latih();
	}

	public function getDataLatihSpesifikWithNoException($Noexception, $limit = 5)
	{
		// x untuk latih , w untuk bobot
		if ($Noexception !== null) {
			if (is_array($Noexception)) {
				$this->db->where_in("id_data_latih", $Noexception);
			} else {
				$this->db->where("id_data_latih =", $Noexception);
			}
		}
		$this->db->limit($limit);
		$this->db->reset_query();
		$this->db->order_by('id_data_latih', 'DESC');

		return $this->get_data_latih();
	}

	public function set_data($data_set = array())
	{
		$this->db->set($data_set);
	}

	public function insert($data)
	{
		return $this->db->insert("data_latih", $data);
	}

	public function returnAutoIncrement($last_id = 0)
	{
		return $this->db->query("ALTER TABLE `data_latih` auto_increment = $last_id;");
	}

	public function getByIdLatih($id_data_latih)
	{
		# code...
		return $this->db->get_where("data_latih", array('id_data_latih' => $id_data_latih), 1);
	}

	public function delete($id_data_latih)
	{
		return $this->db->delete("data_latih", array('id_data_latih' => $id_data_latih), 1);
	}

	public function insert_data($data)
	{
		$query = $this->db->insert("data_latih", $data);
		return $query;
	}

	public function update($data, $id_data_latih)
	{
		$this->db->where("id_data_latih", $id_data_latih);
		return $this->db->update("data_latih", $data);
	}

	public function id_data_latih()
	{
		return $this->id_data_latih;
	}
}
