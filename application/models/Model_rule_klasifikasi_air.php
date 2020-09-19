<?php
/**
 * 
 */
class Model_rule_klasifikasi_air extends CI_Model
{
	public function get_all()
	{
		$this->db->order_by('id_rule', 'ASC');
		return $this->db->get('data_rule_klasifikasi_air');
	}

	public function get_by($id_rule)
	{
		$this->db->where('id_rule =', $id_rule);
		return $this->db->get('data_rule_klasifikasi_air');
	}

	public function insert_batch($data)
	{
		return $this->db->insert_batch('data_rule_klasifikasi_air', $data);
    }
    
    public function insert($data)
	{
		return $this->db->insert('data_rule_klasifikasi_air', $data);
	}

	public function update($id_klasifikasi, $data)
	{
		$this->db->where('id_klasifikasi =', $id_klasifikasi);
		return $this->db->update('master_klasifikasi_air', $data);
	}

	public function update_rule($where, $data)
	{
		$this->db->limit(1);
		return $this->db->update('data_rule_klasifikasi_air', $data, $where);
	}

	public function update_batch_rule($id_air, $data){
		$this->db->where('id_air = ', $id_air);
		return $this->db->update_batch('data_rule_klasifikasi_air', $data, 'id_air');
	}

	public function detail_by_id_jenis_air($id_jenis_air)
	{
		$this->db->select('*');
		$this->db->from('data_rule_klasifikasi_air a');
		$this->db->join('master_jenis_air b', 'a.id_air = b.id_jenis');
		$this->db->join('master_klasifikasi_air c', 'a.id_klasifikasi = c.id_klasifikasi');
		$this->db->where(' a.id_air =', $id_jenis_air);
		$this->db->order_by('a.id_rule');
		return $this->db->get();
	}

	public function delete_rule($where)
	{
		return $this->db->delete('data_rule_klasifikasi_air', $where);
	}
}