<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->model('DashboardModel');
		$this->load->model('UserModel');
		$this->load->model('KaryawanModel');
		$this->load->model('NotifikasiModel');

    }

   
	public function index()
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
		$data['active_menu'] = 'Dashboard';
		$data['title'] = 'Dashboard';
		
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();

		$username = $this->session->userdata('username'); // Mendapatkan data username dari session

		$data['users'] = $this->UserModel->getUserById($username);


		$this->load->library('table');
		$data['departemen'] = $this->DashboardModel->getAllDatadepartemen();
		$data['bagianit'] = $this->DashboardModel->getAllDataBagianIT();
		$data['karyawan'] = $this->DashboardModel->getAllDatakaryawan();
		$data['teknisi'] = $this->DashboardModel->getAllDatateknisi();
		$usersQuery = $this->db->where('role_id', 2)->get('users');
        $data['totalKaryawan'] = $usersQuery->num_rows();
		$usersQuery2 = $this->db->where('role_id', 3)->get('users');
        $data['totalTeknisi'] = $usersQuery2->num_rows();
		$usersQuery3 = $this->db->get('departments');
        $data['totalDepartemen'] = $usersQuery3->num_rows();
		$usersQuery4 = $this->db->get('problemcategories');
        $data['totalBagianIT'] = $usersQuery3->num_rows();
		$this->load->view("administator/templates/header", $data);
		$this->load->view("administator/templates/sidebar", $data);
		$this->load->view("administator/dashboard", $data);
		$this->load->view("administator/templates/footer");
	
	}

	public function search(){
		// Memeriksa apakah pengguna sudah login
		if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		
		// Mendapatkan data peran (role) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}

		$data['title'] = 'Search User';

        $keyword = $this->input->get('keyword'); // Mendapatkan keyword pencarian dari input GET

		// Pencarian data berdasarkan keyword
		$data['karyawan'] = $this->KaryawanModel->searchKaryawan($keyword);
		$data['teknisi'] = $this->KaryawanModel->searchKaryawan($keyword);

		$username = $this->session->userdata('username'); // Mendapatkan data username dari session

		$data['users'] = $this->UserModel->getUserById($username);

		if (!empty($data['karyawan'])) {
			// Jika ditemukan data organisasi, arahkan ke view data-perangkat
			$data['active_menu'] = 'kelolaKaryawan';
			$this->load->view('administator/templates/header', $data);
			$this->load->view('administator/templates/sidebar', $data);
			$this->load->view("administator/viewsearch");
			$this->load->view('administator/templates/footer');

		}else{
			$data['title'] = 'Pencarian Keyword: '. $keyword . ' Tidak Ditemukan';
			$data['keyword'] = $keyword;
            $this->load->view('errorSearchNotFound', $data);
		}
    }
	public function kelolaNotifikasi(){
		// Memeriksa apakah pengguna sudah login
		if (!$this->session->userdata('logged_in')) {
			redirect('Home/loginPage');
		}
		
		// Mendapatkan data peran (role) pengguna dari session
		$role_id = $this->session->userdata('role_id');
		
		// Memeriksa apakah pengguna memiliki peran 'admin'
		if ($role_id !== '1') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
		$data['active_menu'] = 'Dashboard';
		$data['title'] = 'Dashboard';
		$username = $this->session->userdata('username'); // Mendapatkan data username dari session

		$data['users'] = $this->UserModel->getUserById($username);
		// Mendapatkan Semua Notifikasi
        $data['notif'] = $this->NotifikasiModel->getAllNotification();
        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();

		$this->load->view("administator/templates/header", $data);
		$this->load->view("administator/templates/sidebar", $data);
		$this->load->view("administator/kelolanotifikasi", $data);
		$this->load->view("administator/templates/footer");
	}


}
