<?php
class Model_latih extends CI_Model{
    public $tc = 0;
	public $so4 = 0.0;
	public $mn = 0.0;
	public $fe = 0.0;
	public $th = 0;
	public $tds = 0;
	public $ph = 6.0;
    public $target = 0;
    public $id_latih;
    
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
                ->select('*')
                ->where_not_in("id", array('1','2','3'))
                ->group_by('target')
                ->order_by('id_data_latih', 'ASC')
                ->order_by('target', 'ASC');
        return $this->db->get("data_latih");
    }

    public function set_data($data_set = array())
    {
        $this->db->set($data_set);
    }

    public function insert()
    {
        $query = $this->db->insert("data_latih");
        $this->id_latih = $this->db->insert_id();
        return $query;
    }

    public function get_id()
    {
        return $this->id_latih;
    }
}