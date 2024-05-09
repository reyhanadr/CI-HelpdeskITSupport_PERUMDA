<?php

class BagianITModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('BagianITModel');
    }

    public function getAllData()
	{
		return $this->db->get('problemcategories')->result();
	}

	public function tambah_data()
	{
		$query = $this->db->select_max('kategori_id')->get('problemcategories');
		$result = $query->row();
		$last_kategori_id = $result->kategori_id;

		// Membuat nomor berikutnya
		$new_kategori_id = $last_kategori_id + 1;
		$data = array(
			'kategori_id' => $new_kategori_id,
			'nama_kategori' => $this->input->post('nama', true)
		);
		$this->db->insert('problemcategories', $data);
	}

	public function ubah_data()
	{
		$data = array(
			'nama_kategori' => $this->input->post('nama', true)
		);
		$this->db->where('kategori_id', $this->input->post('id', true));
		$this->db->update('problemcategories', $data);
	}

	public function hapus_data($id)
	{
		$this->db->delete('problemcategories', ['kategori_id' => $id]);
	}

	public function detail_data($id)
	{
		return $this->db->get_where('problemcategories', ['kategori_id' => $id])->row_array();
	}
}