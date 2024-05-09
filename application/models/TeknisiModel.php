<?php

class TeknisiModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('TeknisiModel');
    }

    public function getAllData()
	{
        $this->db->select('u.*, pc.nama_kategori');
        $this->db->from('users u');
        $this->db->join('problemcategories pc', 'u.kategori_id = pc.kategori_id');
        $this->db->where('u.role_id', 3);
        $query = $this->db->get();
        return $query->result();
	}

	public function getKategori() {
        $query = $this->db->get('problemcategories'); // Ambil data dari tabel departments
        return $query->result_array(); // Kembalikan hasil dalam bentuk array
    }
	

	public function tambah_data()
	{
		$query = $this->db->select_max('user_id')->get('users');
		$result = $query->row();
		$last_user_id = $result->user_id;

		// Membuat nomor berikutnya
		$new_user_id = $last_user_id + 1;
		$data = array(
			'user_id' => $new_user_id,
			'karyawan_id' => $this->input->post('karyawan_id', true),
			'nama' => $this->input->post('nama', true),
            'username' => $this->input->post('username', TRUE),
            'password' => md5($this->input->post('password', TRUE)),
            'email' => $this->input->post('email', TRUE),
			'departemen_id' => "3",
			'role_id' => "3",
            'kategori_id' => $this->input->post('kategori', TRUE),
			'foto_user' => "user.jpg"
		);
		$this->db->insert('users', $data);
	}


	public function ubah_data()
	{
		$karyawan_id = $this->input->post('karyawan_id', true);
	
		// Mengambil data 'username' dari database berdasarkan 'karyawan_id'
		$existing_username = $this->db->get_where('users', array('karyawan_id' => $karyawan_id))->row()->username;
	
		// Mendapatkan 'username' yang diinputkan
		$new_username = $this->input->post('username', true);
	
		$data = array(
			'karyawan_id' => $karyawan_id,
			'nama' => $this->input->post('nama', true),
			'username' => $new_username, // Menggunakan username yang sudah diperiksa
			'email' => $this->input->post('email', TRUE),
			'kategori_id' => $this->input->post('bidang', TRUE),
		);
	
	
		// Memeriksa apakah 'username' yang diinputkan sama dengan yang ada di database
		$existing_username = $this->db->get_where('users', array('karyawan_id' => $karyawan_id))->row()->username;
		if ($new_username != $existing_username) {
			// Jika 'username' berubah, maka update 'username' juga
			$this->db->where('karyawan_id', $karyawan_id);
			$this->db->update('users', array('username' => $new_username));
		}
	
		// Update data di tabel 'users'
		$this->db->where('karyawan_id', $karyawan_id);
		$this->db->update('users', $data);
	
	}
	
	public function nonaktivasi($user_id) {
		$data = array('status' => 'Tidak Aktif');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}

	public function aktivasi($user_id) {
		$data = array('status' => 'Aktif');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}	

	public function detail_data($id)
	{
        $this->db->select('u.*, pc.nama_kategori');
        $this->db->from('users u');
        $this->db->join('problemcategories pc', 'u.kategori_id = pc.kategori_id');
		$this->db->where('u.user_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

    public function resetPassword($karyawan_id, $data) {
        // Lakukan update berdasarkan karyawan_id
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->update('users', $data);

        // Periksa apakah update berhasil
        return $this->db->affected_rows() > 0;
    }
}