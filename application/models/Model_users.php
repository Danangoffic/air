<?php
/**
 * 
 */
class Model_users extends CI_Model
{
	public function get_all()
	{
		# code...
	}

	public function get_by($username, $password)
	{
		$this->db->where('username =', $username);
		$this->db->where('password =', $password);
		$this->db->select('id_user, username, user_class');
		$this->db->from('master_user');
		return $this->db->get();
	}
}