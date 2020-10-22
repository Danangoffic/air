<?php
/**
 * 
 */
class Model_air extends CI_Model
{
	
	public function get_all()
	{
		$this->db->order_by('kategori_jenis', 'ASC');
		return $this->db->get('master_jenis_air');
	}

	public function insert($data)
	{
		return $this->db->insert('master_jenis_air', $data);
	}

	public function get_last_air(){
		$this->db->limit(1);
		$this->db->order_by('id_jenis', 'DESC');
		return $this->db->get('master_jenis_air');
	}

	public function detail($id_jenis)
	{
		$this->db->where('id_jenis =', $id_jenis);
		$this->db->limit(1);
		return $this->db->get('master_jenis_air');
	}

	public function update($data, $id_jenis){
		return $this->db->update('master_jenis_air', $data, array('id_jenis' => $id_jenis));
	}

	public function delete_air($where)
	{
		return $this->db->delete('master_jenis_air', $where);
	}

	public function getByIdJenis($id_jenis)
	{
		$this->db->where("id_jenis", $id_jenis);
		$this->db->order_by('kategori_jenis', 'ASC');
		return $this->db->get('master_jenis_air');
	}
}