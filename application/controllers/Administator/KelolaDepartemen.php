<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelolaDepartemen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('DepartemenModel');
		$this->load->library('form_validation');
		$this->load->model('UserModel');
		$this->load->model('NotifikasiModel');
		$this->load->library('session');
		$this->load->model('PerangkatModel');
    }

   
	public function index()
	{
		// Memeriksa apakah pengguna sudah login
		if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		
		// Mendapatkan data peran (role_id) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
		$username = $this->session->userdata('username'); // Mendapatkan data username dari session
		$data['users'] = $this->UserModel->getUserById($username);
		$this->load->library('table');
		$data['active_menu'] = 'KelolaDepartemen';
		$data['title'] = 'Kelola Departemen';
        $data['departemen'] = $this->DepartemenModel->getAllData();
		$this->load->view("administator/templates/header", $data);
		$this->load->view("administator/templates/sidebar", $data);
		$this->load->view("administator/departemen/view", $data);
		$this->load->view("administator/templates/footer");
	}

	public function tambah()
	{
		$this->form_validation->set_rules("nama", "Nama Departemen", "required|is_unique[departments.nama_departemen]");
		$this->form_validation->set_message("is_unique", "{field} sudah digunakan!");
		if ($this->form_validation->run() == FALSE) {
		// Memeriksa apakah pengguna sudah login
		if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
		// Mendapatkan data peran (role_id) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
			$username = $this->session->userdata('username'); // Mendapatkan data username dari session
			$data['users'] = $this->UserModel->getUserById($username);
			$data['active_menu'] = 'KelolaDepartemen';
			$data['title'] = 'Kelola Departemen';
			$this->load->view("administator/templates/header", $data);
			$this->load->view("administator/templates/sidebar", $data);
			$this->load->view('administator/departemen/tambah');
			$this->load->view("administator/templates/footer");
		} else {
			$this->DepartemenModel->tambah_data();
			$this->session->set_flashdata('succes', 'Disimpan');
			redirect('Administator/KelolaDepartemen');
		}
	}

	public function ubah($kd)
	{
		$this->form_validation->set_rules("nama", "Nama Departemen", "required");
		if ($this->form_validation->run() == FALSE) {
		// Memeriksa apakah pengguna sudah login
		if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
		// Mendapatkan data peran (role_id) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
			$username = $this->session->userdata('username'); // Mendapatkan data username dari session
			$data['users'] = $this->UserModel->getUserById($username);
			$data['active_menu'] = 'KelolaDepartemen';
			$data['title'] = 'Kelola Departemen';
			$data['ubah'] = $this->DepartemenModel->detail_data($kd);

			$this->load->view("administator/templates/header", $data);
			$this->load->view("administator/templates/sidebar", $data);
			$this->load->view('administator/departemen/ubah', $data);
			$this->load->view("administator/templates/footer");

		} else {
			$this->DepartemenModel->ubah_data();
			$this->session->set_flashdata('succes', 'DiUbah');
			redirect('Administator/KelolaDepartemen');
		}
	}

	public function hapus($id)
	{
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
		$this->DepartemenModel->hapus_data($id);
		$this->session->set_flashdata('succes', 'Dihapus');
		redirect('Administator/KelolaDepartemen');
	}

	public function PerangkatDepartemen($id) {
        if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
		// Mendapatkan data peran (role_id) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
		$data['active_menu'] = 'KelolaDepartemen';
		$data['title'] = 'Kelola Departemen';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        // Memanggil method get_user_perangkat dari model
        $data['perangkat'] = $this->DepartemenModel->getPerangkatDepartemen_id($id);
        $data['users'] = $this->UserModel->getUserById($username);

        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/departemen/kelolaperangkat');
        $this->load->view('administator/templates/footer');
    }
    public function DetailPerangkat($perangkat_id) {
        // Memeriksa apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        // Mendapatkan data peran (role_id) pengguna dari session
        $role_id = $this->session->userdata('role_id');
        // Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();
        // Memeriksa apakah pengguna memiliki peran 'admin'
        if ($role_id !== '1') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'KelolaDepartemen';
        $data['title'] = 'Kelola Departemen';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['perangkat'] = $this->PerangkatModel->getPerangkatWithDetailsById($perangkat_id);
        $data['riwayat_perangkat'] = $this->PerangkatModel->getSupportTicketsWithDetailsByPerangkatIdForKaryawan($perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/departemen/detail-perangkat', $data);
        $this->load->view('administator/templates/footer');
    }
}