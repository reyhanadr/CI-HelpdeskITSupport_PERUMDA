<?php
defined('BASEPATH') or exit('No direct script access allowed');
class KelolaTeknisi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('TeknisiModel');
        $this->load->library('form_validation');
        $this->load->model('UserModel');
		$this->load->model('NotifikasiModel');
        $this->load->library('session');
    }
	public function validation_rulesForTambah() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_usernamefortambah');
		$this->form_validation->set_rules('karyawan_id', 'ID Teknisi', 'required|callback_unique_IDKaryawan');
    }
	public function validation_rulesForUbah() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_usernameforubah');
    }
    public function index() {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        $data['users'] = $this->UserModel->getUserById($username);
        $this->load->library('table');
        $data['active_menu'] = 'KelolaTeknisi';
        $data['title'] = 'Kelola Teknisi';
        $data['teknisi'] = $this->TeknisiModel->getAllData();
        $this->load->view("administator/templates/header", $data);
        $this->load->view("administator/templates/sidebar", $data);
        $this->load->view("administator/teknisi/view", $data);
        $this->load->view("administator/templates/footer");
    }
    public function tambah() {
        $this->validation_rulesForTambah();
        if ($this->form_validation->run() == false) {
            // Memeriksa apakah pengguna sudah login
            if (!$this->session->userdata('logged_in')) {
                redirect('Home/loginPage');
            }
            // Mendapatkan data peran (role_id) pengguna dari session
            $role_id = $this->session->userdata('role_id');
            // Memeriksa apakah pengguna memiliki peran 'admin'
            if ($role_id !== '1') {
                // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
                redirect('Home/errorPage');
            }
    		// Mendapatkan Semua Notifikasi
            $data['notif'] = $this->NotifikasiModel->getAllNotification();
            $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
            $username = $this->session->userdata('username'); // Mendapatkan data username dari session
            $data['users'] = $this->UserModel->getUserById($username);
            $data['active_menu'] = 'KelolaTeknisi';
            $data['title'] = 'Kelola Teknisi';
            $data['kategori'] = $this->TeknisiModel->getKategori(); // Ambil data departemen dari model
            $this->load->view("administator/templates/header", $data);
            $this->load->view("administator/templates/sidebar", $data);
            $this->load->view('administator/teknisi/tambah', $data); // Tampilkan view dengan data
            $this->load->view("administator/templates/footer");
        } else {
            $this->TeknisiModel->tambah_data();
            $this->session->set_flashdata('succes', 'Disimpan');
            redirect('Administator/KelolaTeknisi');
        }
    }
	public function unique_IDKaryawan($karyawan_id) {
		// Mengambil data dari tabel users dengan karyawan_id yang sesuai
		$existing_karyawan = $this->db->get_where('users', array('karyawan_id' => $karyawan_id))->row();
		
		// Jika data dengan karyawan_id yang sama sudah ada
		if ($existing_karyawan) {
			$this->form_validation->set_message('unique_IDKaryawan', "{field} sudah digunakan!");
			return false;
		}
	
		return true;
	}

public function unique_usernameforubah($username) {
		if (!empty($this->input->post('username'))) {
			$usernameDuplikat = $this->input->post('username');
			$data['users_duplikat'] = $this->UserModel->getUserById($usernameDuplikat);
			$user_idDuplikat = $data['users_duplikat']->user_id;
			$linkDuplicateProfilKaryawan = base_url("index.php/Administator/KelolaTeknisi/detail/$user_idDuplikat");
		} else {
			$linkDuplicateProfilKaryawan = "";
		}
		$karyawan_id = $this->input->post('karyawan_id');
		$existing_username = $this->db->get_where('users', array('karyawan_id' => $karyawan_id))->row()->username;
	
		if ($username != $existing_username) {
			// Check if the new username is unique
			$is_unique = $this->db->where('username', $username)->count_all_results('users') == 0;
			
			if (!$is_unique) {
				$this->form_validation->set_message('unique_usernameforubah', "{field} sudah digunakan oleh: <a target='blank' href='$linkDuplicateProfilKaryawan'>Profil Username Duplikat</a>");
				return false;
			}
		}
	
		return true;
	}
	public function unique_usernamefortambah($username) {
		// Check if the username is empty
		if (empty($username)) {
			return true; // Username is not required
		}
	
		// Check if the new username is unique
		$existing_username = $this->db->get_where('users', ['username' => $username])->row();
	
		if ($existing_username) {
			// Username is not unique, fetch the user_id for the duplicate user
			$user_idDuplikat = $existing_username->user_id;
			$linkDuplicateProfilKaryawan = base_url("index.php/Administator/KelolaTeknisi/detail/$user_idDuplikat");
			$this->form_validation->set_message('unique_usernamefortambah', "{field} sudah digunakan! oleh: <a target='blank' href='$linkDuplicateProfilKaryawan'>Profil Username Duplikat</a>");
			return false;
		}
	
		return true;
	}	
    public function ubah($id) {
        $this->validation_rulesForUbah();
        if ($this->form_validation->run() == false) {
            // Memeriksa apakah pengguna sudah login
            if (!$this->session->userdata('logged_in')) {
                redirect('Home/loginPage');
            }
            // Mendapatkan data peran (role_id) pengguna dari session
            $role_id = $this->session->userdata('role_id');
            // Memeriksa apakah pengguna memiliki peran 'admin'
            if ($role_id !== '1') {
                // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
                redirect('Home/errorPage');
            }
    		// Mendapatkan Semua Notifikasi
            $data['notif'] = $this->NotifikasiModel->getAllNotification();
            $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
            $username = $this->session->userdata('username'); // Mendapatkan data username dari session
            $data['users'] = $this->UserModel->getUserById($username);
            $data['active_menu'] = 'KelolaTeknisi';
            $data['title'] = 'Kelola Teknisi';
            $data['ubah'] = $this->TeknisiModel->detail_data($id);
            $data['kategori'] = $this->TeknisiModel->getKategori(); // Ambil data departemen dari model
            $this->load->view("administator/templates/header", $data);
            $this->load->view("administator/templates/sidebar", $data);
            $this->load->view('administator/teknisi/ubah', $data);
            $this->load->view("administator/templates/footer");
        } else {
            $this->TeknisiModel->ubah_data();
            $this->session->set_flashdata('succes', 'DiUbah');
            redirect('Administator/KelolaTeknisi');
        }
    }
    public function detail($id) {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
        $data['active_menu'] = 'KelolaTeknisi';
        $data['title'] = 'Detail';
        $data['detail'] = $this->TeknisiModel->detail_data($id);
        $data['departemen'] = $this->TeknisiModel->getKategori(); // Ambil data departemen dari model
        // Kueri Data User
        $username = $this->session->userdata('username');
        $data['users'] = $this->UserModel->getUserById($username);
        // load view
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/teknisi/detail', $data);
        $this->load->view('administator/templates/footer');
    }
    public function konfirmasiResetPassword($karyawan_id) {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $user = $this->UserModel->get_user($username, $password);
        if ($user) {
            $this->resetPASSWORD($karyawan_id);
            $this->session->set_flashdata('succes', 'Password User telah direset!.');
            // Jika berhasil mereset kata sandi, arahkan ke halaman detail karyawan dengan $user_id
            $user_id = $this->getUserIDFromKaryawanID($karyawan_id); // Gantilah dengan cara Anda mendapatkan $user_id dari $karyawan_id
            redirect('Administator/KelolaTeknisi/detail/' . $user_id);
        } else {
            $this->session->set_flashdata('gagal', 'Verifikasi Password Admin Gagal!.');
            $user_id = $this->getUserIDFromKaryawanID($karyawan_id); // Gantilah dengan cara Anda mendapatkan $user_id dari $karyawan_id
            redirect('Administator/KelolaTeknisi/detail/' . $user_id);
        }
    }
    public function resetPASSWORD($karyawan_id) {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        // Kata sandi default menggunakan karyawan_id
        $default_password = $karyawan_id;
        // Hash kata sandi default
        $hashed_password = md5($default_password);
        // Data yang akan diupdate
        $data = array('password' => $hashed_password);
        // Panggil model untuk mengupdate kata sandi berdasarkan karyawan_id
        $this->load->model('KaryawanModel'); // Gantilah 'User_model' dengan nama model yang sesuai
        $result = $this->KaryawanModel->resetPassword($karyawan_id, $data);
    }
    // Fungsi untuk mendapatkan $user_id dari $karyawan_id
    private function getUserIDFromKaryawanID($karyawan_id) {
        // Misalnya, Anda memiliki tabel 'karyawan' yang memiliki kolom 'user_id',
        // Anda dapat mengambil $user_id berdasarkan $karyawan_id seperti ini:
        $this->db->select('user_id');
        $this->db->where('karyawan_id', $karyawan_id);
        $query = $this->db->get('users');
        // Periksa apakah query berhasil dan hasilnya ada
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->user_id;
        } else {
            // Jika tidak ditemukan, Anda dapat mengembalikan nilai default atau menangani error sesuai kebutuhan
            return null;
        }
    }
    public function nonaktivasi($user_id) {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        // Ubah status pengguna menjadi "Tidak Aktif"
        $this->TeknisiModel->nonaktivasi($user_id);
        // Set flash message jika perlu
        $this->session->set_flashdata('succes', 'Akun telah dinonaktifkan.');
        // Redirect kembali ke halaman yang sesuai atau memberikan respons sesuai kebutuhan Anda
        redirect('Administator/KelolaTeknisi/detail/' . $user_id); // Contoh pengalihan ke halaman daftar pengguna
        
    }
    public function aktivasi($user_id) {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        // Ubah status pengguna menjadi "Tidak Aktif"
        $this->TeknisiModel->aktivasi($user_id);
        // Set flash message jika perlu
        $this->session->set_flashdata('succes', 'Akun telah diaktifkan.');
        // Redirect kembali ke halaman yang sesuai atau memberikan respons sesuai kebutuhan Anda
        redirect('Administator/KelolaTeknisi/detail/' . $user_id); // Contoh pengalihan ke halaman daftar pengguna
        
    }
}
