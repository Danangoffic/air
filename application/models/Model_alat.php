<?php
/**
 * 
 */
class Model_alat extends CI_Model
{
	public function get_all()
	{
		return $this->db->get('master_alat');
	}

	public function get_by($id_alat)
	{
		$this->db->where('id_alat =', $id_alat);
		$this->db->limit(1);
		return $this->db->get('master_alat');
	}

	public function insert($data)
	{
		return $this->db->insert('master_alat', $data);
	}

	public function update($id_alat, $data)
	{
		$this->db->where('id_alat =', $id_alat);
		return $this->db->update('master_alat', $data);
	}

	public function delete($id_alat)
	{
		$this->db->where('id_alat =', $id_alat);
		$this->db->limit(1);
		return $this->db->delete('master_alat');
	}
}