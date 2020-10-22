<?php

use phpDocumentor\Reflection\Types\String_;

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

	public function insert_user($data)
	{
		return $this->db->insert("master_user", $data);
	}

	public function getUserByUsername(String $username="")
	{
		$this->db->where('username =', $username);
		$this->db->select('id_user, username, user_class');
		$this->db->from('master_user');
		$this->db->limit(1);
		return $this->db->get();
	}

	public function getByUsernameAndPassword(string $username, string $password)
	{
		$this->db->where('username =', $username);
		$this->db->where('password =', $password);
		$this->db->select('*');
		$this->db->from('master_user');
		$this->db->limit(1);
		return $this->db->get();
	}
}