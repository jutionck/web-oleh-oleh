<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_provinces()
    {
        $query = $this->db->get('provinces');
        return $query->result();
    }

    public function get_regencies_by_province($province_id)
    {
        $this->db->where('province_id', $province_id);
        $query = $this->db->get('regencies');
        return $query->result();
    }

    public function get_districts_by_regency($regency_id)
    {
        $this->db->where('regency_id', $regency_id);
        $query = $this->db->get('districts');
        return $query->result();
    }

    public function get_villages_by_district($district_id)
    {
        $this->db->where('district_id', $district_id);
        $query = $this->db->get('villages');
        return $query->result();
    }
}
