<?php

class DashboardModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('DashboardModel');
    }

    public function getAllDatadepartemen()
	{
		return $this->db->get('departments')->result();
	}

    public function getAllDataBagianIT()
	{
		return $this->db->get('problemcategories')->result();
	}

	public function getAllDatakaryawan()
	{
        $this->db->select('u.user_id, u.nama, u.username, u.email, u.password, u.role_id, u.departemen_id, d.nama_departemen');
        $this->db->from('users u');
        $this->db->join('departments d', 'u.departemen_id = d.departemen_id');
        $this->db->where('u.role_id', 2);
        $query = $this->db->get();
        return $query->result();
	}

	public function getAllDatateknisi()
	{
        $this->db->select('u.user_id, u.nama, u.username, u.email, u.role_id, u.kategori_id, pc.nama_kategori');
        $this->db->from('users u');
        $this->db->join('problemcategories pc', 'u.kategori_id = pc.kategori_id');
        $this->db->where('u.role_id', 3);
        $query = $this->db->get();
        return $query->result();
	}

}