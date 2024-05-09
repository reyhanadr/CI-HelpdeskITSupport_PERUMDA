<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Profil extends CI_Controller

{

	public function __construct()

	{

		parent::__construct();

		$this->load->helper('url');

		$this->load->model('UserModel');

		$this->load->model('RequestModel');

		$this->load->library('session');

		$this->load->model('NotifikasiModel');



	}



	public function index()

	{



	}



	public function tampilEditProfile($username){

		if (!$this->session->userdata('logged_in')) {

            redirect('Home/loginPage');

        }

		if ($this->session->userdata('role_id') !== '3') {

			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai

			redirect('Home/errorPage');

		}

		$data['active_menu'] = 'kelolaprofil';

		$data['title'] = 'Kelola Profil';



		// Kueri Data User

        // Kemudian Anda bisa meneruskan data username ke model

        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);

        $user = $this->UserModel->getUserByIdTeknisi($username);

        $kategori_id = $user->kategori_id;

        $ticketsNull = $this->RequestModel->getTicketsTeknisi($kategori_id, NULL);

        $ticketsByPenanggungJawab = $this->RequestModel->getTicketsTeknisi($kategori_id, $this->session->userdata('user_id'));

        $data['tickets'] = array_merge($ticketsNull, $ticketsByPenanggungJawab);

		// Mengambil kategori_id

        $kategori_id = $data['users']->kategori_id; // Mendapatkan kategori dari session





        // Mendapatkan Notifikasi Teknisi

        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));

        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));



		// load view

		$this->load->view('teknisi/templates/header', $data);

		$this->load->view('teknisi/templates/sidebar', $data);

		$this->load->view('teknisi/kelolaprofil', $data);

		$this->load->view('teknisi/templates/footer');

	}



	public function gantiPassword(){

		$user_id = $this->input->post('user_id');

		$username = $this->input->post('username');

		$old_password = md5($this->input->post('old_password'));

		$new_password = $this->input->post('new_password');

		$cekOldPassword = $this->UserModel->get_user($username, $old_password);

		if($cekOldPassword){

			$data['password'] = md5($new_password);

			$this->UserModel->updateProfil($user_id, $data);

			$this->session->set_flashdata('success', 'Password berhasil diperbarui');

		}else{

			$this->session->set_flashdata('error', 'Tidak dapat memperbarui password karena password lama salah!');

		}

		redirect('Teknisi/Profil/tampilEditProfile/'.$username);



	}



	public function updateDataProfile($user_id)

	{

		

		$nama = $this->input->post('nama');

		$username = $this->input->post('username');

		$email = $this->input->post('email');

		$password = $this->input->post('password');

		$username_loggedin = $this->session->userdata('username');



		// Memeriksa apakah username yang baru sudah ada di database

		$existingUser = $this->UserModel->getUserById($username);



		if ($existingUser && $existingUser->username != $user_id){

			// Jika username sudah ada dan bukan milik user yang sedang diedit

			$this->session->set_flashdata('error', 'Username sudah digunakan. Harap pilih username lain.');

			redirect('Teknisi/Profil/tampilEditProfile/' . $username_loggedin);

		}



		// Memeriksa apakah ada file foto yang diupload

		if ($_FILES['foto']['name']) {

			$config['upload_path'] = './assets/img/users/'; // Lokasi penyimpanan foto

			$config['allowed_types'] = 'jpg|jpeg|png';

			$config['max_size'] = 2048; // Batasan ukuran file (dalam KB)



			$this->load->library('upload', $config);



			if ($this->upload->do_upload('foto')) {

				$uploaded_data = $this->upload->data();

				$foto = $uploaded_data['file_name'];



				// Mengupdate data produk beserta foto

				$data = array(

					'nama' => $nama,

					'username' => $username,

					'email' => $email,

					'foto_user' => $foto

				);



				// Memeriksa apakah password diisi atau tidak

				if (!empty($password)) {

					$data['password'] = md5($password);

				}



				$this->UserModel->updateProfil($user_id, $data);

				$this->session->set_userdata($data);

				$this->session->set_flashdata('success', 'Profile berhasil diperbarui');

			} else {

				$error = $this->upload->display_errors();

				$this->session->set_flashdata('error', $error);

				redirect('Teknisi/Profil/tampilEditProfile/' . $username);

				$this->session->set_flashdata('error', 'Profile gagal diperbarui');

			}

		} else {

			// Jika tidak ada foto yang diupload, hanya mengupdate data profil tanpa foto

			$data = array(

				'nama' => $nama,

				'email' => $email,

				'username' => $username

			);



			// Memeriksa apakah password diisi atau tidak

			if (!empty($password)) {

				$data['password'] = md5($password);

			}

			$this->session->set_userdata($data);



			$this->UserModel->updateProfil($user_id, $data);

			$this->session->set_flashdata('success', 'Profile berhasil diperbarui');

		}



		redirect('Teknisi/Profil/tampilEditProfile/'.$username);

	}



}