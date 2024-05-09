<?php
defined('BASEPATH') or exit('No direct script access allowed');
class KelolaKaryawan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('KaryawanModel');
        $this->load->model('TeknisiModel');
        $this->load->model('PerangkatModel');
        $this->load->library('form_validation');
        $this->load->model('UserModel');
        $this->load->model('NotifikasiModel');
        $this->load->library('session');
    }
	public function validation_rulesForTambah() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_usernamefortambah');
		$this->form_validation->set_rules('karyawan_id', 'ID Karyawan', 'required|callback_unique_IDKaryawan');
    }
	public function validation_rulesForUbah() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_usernameforubah');
    }
    public function validation_rulesForTPerangkat() {
        $this->form_validation->set_rules('nomor_seri', 'Nomor Seri', 'required');
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
        $data['active_menu'] = 'KelolaKaryawan';
        $data['title'] = 'Kelola Karyawan';
        $data['karyawan'] = $this->KaryawanModel->getAllData(2);
        $this->load->view("administator/templates/header", $data);
        $this->load->view("administator/templates/sidebar", $data);
        $this->load->view("administator/karyawan/view", $data);
        $this->load->view("administator/templates/footer");
    }
    public function tambah() {
        $this->validation_rulesForTambah();
        if ($this->form_validation->run() == FALSE) {
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
            $data['active_menu'] = 'KelolaKaryawan';
            $data['title'] = 'Kelola Karyawan';
            $data['departemen'] = $this->KaryawanModel->getDepartments(); // Ambil data departemen dari model
            $this->load->view("administator/templates/header", $data);
            $this->load->view("administator/templates/sidebar", $data);
            $this->load->view('administator/karyawan/tambah', $data); // Tampilkan view dengan data
            $this->load->view("administator/templates/footer");
        } else {
            $this->KaryawanModel->tambah_data();
            $this->session->set_flashdata('succes', 'Disimpan');
            redirect('Administator/KelolaKaryawan');
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
			$linkDuplicateProfilKaryawan = base_url("index.php/Administator/KelolaKaryawan/detail/$user_idDuplikat");
		} else {
			$linkDuplicateProfilKaryawan = "";
		}

		$existing_username = $this->db->get_where('users')->row()->username;
	
		if ($username != $existing_username) {
			// Check if the new username is unique
			$is_unique = $this->db->where('username', $username)->count_all_results('users') == 0;
			
			if (!$is_unique) {
				$this->form_validation->set_message('unique_usernameforubah', "{field} sudah digunakan! oleh: <a target='blank' href='$linkDuplicateProfilKaryawan'>Profil Username Duplikat</a>");
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
			$linkDuplicateProfilKaryawan = base_url("index.php/Administator/KelolaKaryawan/detail/$user_idDuplikat");
			$this->form_validation->set_message('unique_usernamefortambah', "{field} sudah digunakan! oleh: <a target='blank' href='$linkDuplicateProfilKaryawan'>Profil Username Duplikat</a>");
			return false;
		}
	
		return true;
	}
    public function ubah($id) {
        $this->validation_rulesForUbah();
        if ($this->form_validation->run() == FALSE) {
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
            $data['active_menu'] = 'KelolaKaryawan';
            $data['title'] = 'Kelola Karyawan';
            $data['ubah'] = $this->KaryawanModel->detail_data($id);
            $data['departemen'] = $this->KaryawanModel->getDepartments(); // Ambil data departemen dari model
            $this->load->view("administator/templates/header", $data);
            $this->load->view("administator/templates/sidebar", $data);
            $this->load->view('administator/karyawan/ubah', $data);
            $this->load->view("administator/templates/footer");
        } else {
            $this->KaryawanModel->ubah_data();
            $this->session->set_flashdata('succes', 'DiUbah');
            redirect('Administator/KelolaKaryawan');
        }
    }
    public function detail($id) {
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
        $data['active_menu'] = 'KelolaKaryawan';
        $data['title'] = 'Detail';
        $data['detail'] = $this->KaryawanModel->detail_data($id);
        $data['departemen'] = $this->KaryawanModel->getDepartments(); // Ambil data departemen dari model
        // Kueri Data User
        $username = $this->session->userdata('username');
        $data['users'] = $this->UserModel->getUserById($username);
        // Memanggil method get_user_perangkat dari model
        $data['perangkatkaryawan'] = $this->KaryawanModel->getPerangkatUser_id($id);
        // load view
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/karyawan/detail', $data);
        $this->load->view('administator/templates/footer');
    }
    public function konfirmasiResetPassword($karyawan_id) {
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
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $user = $this->UserModel->get_user($username, $password);
        if ($user && $user->status == "Aktif") {
            $this->resetPASSWORD($karyawan_id);
            $this->session->set_flashdata('succes', 'Password User telah direset!.');
            // Jika berhasil mereset kata sandi, arahkan ke halaman detail karyawan dengan $user_id
            $user_id = $this->getUserIDFromKaryawanID($karyawan_id); // Gantilah dengan cara Anda mendapatkan $user_id dari $karyawan_id
            redirect('Administator/KelolaKaryawan/detail/' . $user_id);
        } else {
            $this->session->set_flashdata('gagal', 'Verifikasi Password Admin Gagal!.');
            $user_id = $this->getUserIDFromKaryawanID($karyawan_id); // Gantilah dengan cara Anda mendapatkan $user_id dari $karyawan_id
            redirect('Administator/KelolaKaryawan/detail/' . $user_id);
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
        $this->KaryawanModel->resetPassword($karyawan_id, $data);
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
        $this->KaryawanModel->nonaktivasi($user_id);
        // Set flash message jika perlu
        $this->session->set_flashdata('succes', 'Akun telah dinonaktifkan.');
        // Redirect kembali ke halaman yang sesuai atau memberikan respons sesuai kebutuhan Anda
        redirect('Administator/KelolaKaryawan/detail/' . $user_id); // Contoh pengalihan ke halaman daftar pengguna
        
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
        $this->KaryawanModel->aktivasi($user_id);
        // Set flash message jika perlu
        $this->session->set_flashdata('succes', 'Akun telah diaktifkan.');
        // Redirect kembali ke halaman yang sesuai atau memberikan respons sesuai kebutuhan Anda
        redirect('Administator/KelolaKaryawan/detail/' . $user_id); // Contoh pengalihan ke halaman daftar pengguna
        
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
        $data['active_menu'] = 'KelolaKaryawan';
        $data['title'] = 'Kelola Karyawan';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['perangkat'] = $this->PerangkatModel->getPerangkatWithDetailsById($perangkat_id);
        $data['riwayat_perangkat'] = $this->PerangkatModel->getSupportTicketsWithDetailsByPerangkatIdForKaryawan($perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/karyawan/detail-perangkat', $data);
        $this->load->view('administator/templates/footer');
    }
    public function TambahPerangkat($id) {
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
        $data['active_menu'] = 'KelolaKaryawan';
        $data['title'] = 'Kelola Karyawan';
        $data['user'] = $this->KaryawanModel->detail_data($id);
        $data['kategori'] = $this->TeknisiModel->getKategori();
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/karyawan/tambah-perangkat', $data);
        $this->load->view('administator/templates/footer');
    }
    public function simpanPerangkat() {
        $no_inventaris = $this->input->post('no_inventaris');
        $nomer_seri = $this->input->post('nomer_seri');
        $nama_perangkat = $this->input->post('nama_perangkat');
        $ipaddress = $this->input->post('ipaddress');
        $kategori_id = $this->input->post('kategori_id');
        $spesifikasi = $this->input->post('spesifikasi');
        $lokasi_fisik = $this->input->post('lokasi_fisik');
        $status_perangkat = $this->input->post('status_perangkat');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $user_id = $this->input->post('user_id');
        // Upload foto
        $config['upload_path'] = './assets/img/perangkat/'; // Sesuaikan dengan path penyimpanan
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2048KB (2MB)
        $this->load->library('upload', $config);
        if (strtotime($tanggal_masuk) > strtotime(date('Y-m-d'))) {
            $this->session->set_flashdata('error_upload', "Tanggal Masuk Tidak Boleh Lebih Besar dari Hari ini");
            redirect('Administator/KelolaKaryawan/TambahPerangkat/'. $user_id);
        }
        if (!$this->upload->do_upload('foto')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error_upload', 'Ukuran Gambar Terlalu Besar!', $error);
            redirect('Administator/KelolaKaryawan/TambahPerangkat/' . $user_id);
        } else {
            $upload_data = $this->upload->data();
            $foto = $upload_data['file_name'];
            // Data perangkat
            $data_perangkat = array(
                'no_inventaris' => $no_inventaris, 
                '$nomer_seri' => $nomer_seri, 
                'nama_perangkat' => $nama_perangkat, 
                'kategori_id' => $kategori_id, 
                'spesifikasi' => $spesifikasi, 
                'departemen_id' => $lokasi_fisik, 
                'status_perangkat' => $status_perangkat, 
                'user_id' => $user_id, 
                'foto' => $foto, 
                'tanggal_masuk' => $tanggal_masuk);
            if (!empty($ipaddress)) {
                $data_perangkat['ipaddress'] = $ipaddress;
            }
            $this->PerangkatModel->simpan_perangkat($data_perangkat);
            $this->session->set_flashdata('success', 'Perangkat Telah Ditambahkan');
            redirect('Administator/KelolaKaryawan/detail/' . $user_id);
        }
    }
    public function tampilEditPerangkat($perangkat_id) {
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
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Edit Perangkat';
        // Mendapatkan username dari session
        $username = $this->session->userdata('username');
        // Memanggil Method dari Model
        $data['users'] = $this->UserModel->getUserById($username);
        // Dapatkan data perangkat berdasarkan ID
        $data['perangkat'] = $this->PerangkatModel->getPerangkatById($perangkat_id);
        $data['kategori'] = $this->PerangkatModel->getKategori();
        $this->load->view('administator/templates/header', $data);
        $this->load->view('administator/templates/sidebar', $data);
        $this->load->view('administator/karyawan/edit-perangkat');
        $this->load->view('administator/templates/footer');
    }
    public function updatePerangkat($perangkat_id) {
        $no_inventaris = $this->input->post('no_inventaris');
        $nomer_seri = $this->input->post('nomer_seri');
        $nama_perangkat = $this->input->post('nama_perangkat');
        $ipaddress = $this->input->post('ipaddress');
        $kategori_id = $this->input->post('kategori_id');
        $spesifikasi = $this->input->post('spesifikasi');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        $user_id = $this->input->post('user_id');
        // Ubah Tanggal DY:MT:YR menjadi YR:M
        $status_perangkat = $this->input->post('status_perangkat');
        $catatan = $this->input->post('catatan');
        // Cek apakah ada file baru yang diunggah
        if ($_FILES['foto1']['name'] !== '') {
            // Upload foto baru
            $config['upload_path'] = './assets/img/perangkat/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto1')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_upload', 'Ukuran Gambar Terlalu Besar!', $error);
                redirect('Administator/KelolaKaryawan/tampilEditPerangkat/' . $perangkat_id . '/' . $user_id);
            } else {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                // Data perangkat
                $data_perangkat = array(
                    '$no_inventaris' => $no_inventaris, 
                    'nomer_seri' => $nomer_seri, 
                    'nama_perangkat' => $nama_perangkat, 
                    'kategori_id' => $kategori_id, 
                    'spesifikasi' => $spesifikasi, 
                    'status_perangkat' => $status_perangkat, 
                    'catatan' => $catatan, 
                    'user_id' => $user_id, 
                    'foto' => $foto, 
                    'tanggal_masuk' => $tanggal_masuk);
                if (!empty($ipaddress)) {
                    $data_perangkat['ipaddress'] = $ipaddress;
                }
                $this->PerangkatModel->update_perangkat($perangkat_id, $data_perangkat);
                $this->session->set_flashdata('success', 'Perangkat Telah Diperbarui');
                redirect('Administator/KelolaKaryawan/detail/' . $user_id);
            }
        } else {
            // Gunakan foto yang sudah ada
            $data_perangkat = array('nomer_seri' => $nomer_seri, 'nama_perangkat' => $nama_perangkat, 'kategori_id' => $kategori_id, 'spesifikasi' => $spesifikasi, 'status_perangkat' => $status_perangkat, 'catatan' => $catatan, 'user_id' => $user_id);
            $this->PerangkatModel->update_perangkat($perangkat_id, $data_perangkat);
            $this->session->set_flashdata('success', 'Perangkat Telah Diperbarui');
            redirect('Administator/KelolaKaryawan/detail/' . $user_id);
        }
    }
    public function hapusPerangkat($perangkat_id, $user_id) {
        if ($this->PerangkatModel->cekRelasiPerangkat($perangkat_id, $user_id)) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus perangkat. Ada data terkait yang masih ada. (Request)');
        } else {
            // Mencoba menghapus perangkat beserta data terkait menggunakan ON DELETE CASCADE
            $this->PerangkatModel->delete_perangkat($perangkat_id);
            $this->session->set_flashdata('success', 'Perangkat Telah Dihapus');
        }
        redirect('Administator/KelolaKaryawan/detail/' . $user_id);
    }
}
