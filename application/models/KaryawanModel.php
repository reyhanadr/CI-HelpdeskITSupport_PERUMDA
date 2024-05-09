<?php

class karyawanmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('KaryawanModel');
    }

    public function getAllData()
	{
        $this->db->select('u.*, d.nama_departemen');
        $this->db->from('users u');
        $this->db->join('departments d', 'u.departemen_id = d.departemen_id');
        $this->db->where('u.role_id', 2);
        $query = $this->db->get();
        return $query->result();
	}

	public function getDepartments() {
        $query = $this->db->get('departments'); // Ambil data dari tabel departments
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
			'role_id' => "2",
            'departemen_id' => $this->input->post('departemen', TRUE),
			'foto_user' => "user.jpg"
		);
		$this->db->insert('users', $data);
	}

	public function ubah_data()
	{
		$karyawan_id = $this->input->post('karyawan_id', true);
		$user_id = $this->input->post('user_id', true);
	
		// Mengambil data 'username' dari database berdasarkan 'karyawan_id'
		$existing_username = $this->db->get_where('users', array('karyawan_id' => $karyawan_id))->row()->username;
	
		// Mendapatkan 'username' yang diinputkan
		$new_username = $this->input->post('username', true);
	
		$data = array(
			'karyawan_id' => $karyawan_id,
			'nama' => $this->input->post('nama', true),
			'username' => $new_username, // Menggunakan username yang sudah diperiksa
			'email' => $this->input->post('email', TRUE),
			'departemen_id' => $this->input->post('departemen', TRUE),
		);
	
		$this->db->trans_start(); // Memulai transaksi database
	
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
	
		// Memperbarui departemen_id di tabel 'notification'
		$notification_data = array(
			'department_id' => $this->input->post('departemen', TRUE),
		);
		$this->db->where('user_id', $user_id); // Sesuaikan dengan kolom yang sesuai
		$this->db->update('notification', $notification_data);
	
		$this->db->trans_complete(); // Menyelesaikan transaksi database
	}


    public function resetPassword($karyawan_id, $data) {
        // Lakukan update berdasarkan karyawan_id
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->update('users', $data);

        // Periksa apakah update berhasil
        return $this->db->affected_rows() > 0;
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
		$this->db->select('u.*, d.nama_departemen');
		$this->db->from('users u');
		$this->db->join('departments d', 'd.departemen_id = u.departemen_id', 'left');
		$this->db->where('u.user_id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function searchKaryawan($keyword) {
        $this->db->select('u.*, d.nama_departemen, pc.nama_kategori');
        $this->db->from('users u');
        $this->db->join('departments d', 'u.departemen_id = d.departemen_id', 'left');
		$this->db->join('problemcategories pc', 'u.kategori_id = pc.kategori_id', 'left');
	
		$this->db->group_start();
		$this->db->like('u.nama', $keyword);
		$this->db->or_like('u.username', $keyword);
		$this->db->or_like('u.karyawan_id', $keyword);
		$this->db->or_like('u.email', $keyword);
		$this->db->or_like('d.nama_departemen', $keyword);
		$this->db->or_like('pc.nama_kategori', $keyword);
		$this->db->group_end();
	
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getPerangkatUser_id($id)
    {
        $this->db->select('perangkat.*, users.user_id, users.username, users.nama, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('perangkat');
        $this->db->join('users', 'users.user_id = perangkat.user_id', 'left');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = perangkat.kategori_id', 'left');
        $this->db->join('departments', 'departments.departemen_id = perangkat.departemen_id', 'left');
		$this->db->where('users.user_id', $id);
        return $this->db->get()->result();
    }

	public function getuser_idperangkat($user_id)
	{
		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->where('u.user_id', $user_id);
		$query = $this->db->get();
		return $query->row_array();
	}

}