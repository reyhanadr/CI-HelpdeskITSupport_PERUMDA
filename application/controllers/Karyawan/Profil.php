<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller{
    public function __construct(){
        parent::__construct();
		$this->load->helper('url'); 
		$this->load->model('UserModel');
		$this->load->model('RequestModel');
        $this->load->library('session');
		$this->load->model('NotifikasiModel');

    }

	public function index(){
		$data['active_menu'] = 'kelolaprofil';
		$data['title'] = 'Kelola Profil';
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
		if ($this->session->userdata('role_id') !== '2') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
		// Kueri Data User
		$username = $this->session->userdata('username');
		$data['users'] = $this->UserModel->getUserById($username);
		$data['tickets'] = $this->RequestModel->getTicketsWithDetails($username);
		// Mengambil user_id
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;

        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);

		// load view
		$this->load->view('karyawan/templates/header', $data);
		$this->load->view('karyawan/templates/sidebar', $data);
		$this->load->view('karyawan/kelolaprofil', $data);
		$this->load->view('karyawan/templates/footer');
	}

	public function tampilEditProfile($username){
		if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
		if ($this->session->userdata('role_id') !== '2') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
		$data['active_menu'] = 'kelolaprofil';
		$data['title'] = 'Kelola Profil';

		// Kueri Data User
		$data['users'] = $this->UserModel->getUserById($username);
		$data['tickets'] = $this->RequestModel->getTicketsWithDetails($username);
		// Mengambil kategori_id
		$user_id = $this->session->userdata('user_id');


        // Mendapatkan Notifikasi
		$data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);


		// load view
		$this->load->view('karyawan/templates/header', $data);
		$this->load->view('karyawan/templates/sidebar', $data);
		$this->load->view('karyawan/kelolaprofil', $data);
		$this->load->view('karyawan/templates/footer');
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
		redirect('Karyawan/Profil/tampilEditProfile/'.$username);

	}

	public function updateDataProfile($user_id)
	{
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

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
				redirect('Karyawan/Profil/tampilEditProfile/' . $username);
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

		redirect('Karyawan/Profil/tampilEditProfile/'.$username);
	}
	
}