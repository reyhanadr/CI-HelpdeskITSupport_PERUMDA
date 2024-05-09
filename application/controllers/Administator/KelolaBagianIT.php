<?php

defined('BASEPATH') or exit('No direct script access allowed');



class KelolaBagianIT extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

		$this->load->model('BagianITModel');

		$this->load->library('form_validation');

		$this->load->model('UserModel');

		$this->load->model('NotifikasiModel');

		$this->load->library('session');

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

		$this->load->library('table');

		$data['active_menu'] = 'KelolaBagianIT';

		$data['title'] = 'Kelola Bagian IT';

		$username = $this->session->userdata('username'); // Mendapatkan data username dari session



		// Mendapatkan Semua Notifikasi

        $data['notif'] = $this->NotifikasiModel->getAllNotification();

        $data['jml_notif'] = $this->NotifikasiModel->countAllNotif();



		$data['users'] = $this->UserModel->getUserById($username);

        $data['BagianIT'] = $this->BagianITModel->getAllData();

		$this->load->view("administator/templates/header", $data);

		$this->load->view("administator/templates/sidebar", $data);

		$this->load->view("administator/bagian_it/view", $data);

		$this->load->view("administator/templates/footer");

	}



	public function tambah()

	{

		$this->form_validation->set_rules("nama", "Nama Bagian IT", "required|is_unique[problemcategories.nama_kategori]");

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

			$data['active_menu'] = 'KelolaBagianIT';

			$data['title'] = 'Kelola Bagian IT';



			$this->load->view("administator/templates/header", $data);

			$this->load->view("administator/templates/sidebar", $data);

			$this->load->view('administator/bagian_it/tambah');

			$this->load->view("administator/templates/footer");

		} else {

			$this->BagianITModel->tambah_data();

			$this->session->set_flashdata('succes', 'Disimpan');

			redirect('Administator/KelolaBagianIT');

		}

	}



	public function ubah($kd)

	{

		$this->form_validation->set_rules("nama", "Nama Bagian IT", "required");

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

			$data['active_menu'] = 'KelolaBagianIT';

			$data['title'] = 'Kelola Bagian IT';

			$data['ubah'] = $this->BagianITModel->detail_data($kd);



			$this->load->view("administator/templates/header", $data);

			$this->load->view("administator/templates/sidebar", $data);

			$this->load->view('administator/bagian_it/ubah', $data);

			$this->load->view("administator/templates/footer");



		} else {

			$this->BagianITModel->ubah_data();

			$this->session->set_flashdata('succes', 'DiUbah');

			redirect('Administator/KelolaBagianIT');

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

		$this->BagianITModel->hapus_data($id);

		$this->session->set_flashdata('succes', 'Dihapus');

		redirect('Administator/KelolaBagianIT');

	}



}