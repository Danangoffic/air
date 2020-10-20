<?php

use phpDocumentor\Reflection\Types\Array_;

class Model_latih extends CI_Model{
    public $tc = 0;
	public $so4 = 0.0;
	public $mn = 0.0;
	public $fe = 0.0;
	public $th = 0;
	public $tds = 0;
	public $ph = 6.0;
    public $target = 0;
    public $id_data_latih;
    
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
                ->select_max('so4', 'max_so')
                ->select_max('tc', 'max_tc')
                ->select_max('target', 'max_target')
                ->select_min('ph', 'min_ph')
                ->select_min('tds', 'min_tds')
                ->select_min('th', 'min_th')
                ->select_min('fe', 'min_fe')
                ->select_min('mn', 'min_mn')
                ->select_min('so4', 'min_so')
                ->select_min('tc', 'min_tc')
                ->select_min('target', 'min_target')
                ->select('data_latih.*')
                // ->order_by('id_data_latih', 'ASC')
                ->from("data_latih");
        return $this->db->get();
    }

    public function set_data($data_set = array())
    {
        $this->db->set($data_set);
    }

    public function insert(Array $data)
    {
        $insert = $this->db->insert("data_latih", $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function insert_data()
    {
        $query = $this->db->insert("data_latih", $this);
        return $query;
    }

    public function id_data_latih()
    {
        return $this->id_data_latih;
    }
}