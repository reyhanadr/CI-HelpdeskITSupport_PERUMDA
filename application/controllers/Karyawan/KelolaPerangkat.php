<?php
defined('BASEPATH') or exit('No direct script access allowed');
class KelolaPerangkat extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('PerangkatModel');
        $this->load->model('UserModel');
        $this->load->model('NotifikasiModel');
    }
    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Kelola Perangkat';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        // Memanggil method get_user_perangkat dari model
        $data['perangkat'] = $this->PerangkatModel->getPerangkatUser($username);
        $data['users'] = $this->UserModel->getUserById($username);
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/kelolaperangkat');
        $this->load->view('karyawan/templates/footer');
    }
    public function DetailPerangkat($perangkat_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $this->load->model('RequestModel');
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Detail Perangkat';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($data['users']->user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($data['users']->user_id);
        $data['perangkat'] = $this->PerangkatModel->getPerangkatWithDetailsById($perangkat_id);
        $data['riwayat_perangkat'] = $this->RequestModel->getRiwayatRequestByPerangkatId($perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/detail-perangkat', $data);
        $this->load->view('karyawan/templates/footer');
    }
    public function tampilTambahPerangkat() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Tambah Perangkat';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        // Memanggil method dari model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['kategori'] = $this->PerangkatModel->getKategori();
        // Mengambil user_id
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/tambah-perangkat', $data);
        $this->load->view('karyawan/templates/footer');
    }
    public function simpanPerangkat() {
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

        if (!$this->upload->do_upload('foto')) {
            $error = $this->upload->display_errors();
            $data['upload_error'] = $error;
            $this->load->view('karyawan/kelolaperangkat', $data);
        } else {
            $upload_data = $this->upload->data();
            $foto = $upload_data['file_name'];
            // Data perangkat
            $data_perangkat = array(
                'nomer_seri' => $nomer_seri, 
                'nama_perangkat' => $nama_perangkat, 
                'kategori_id' => $kategori_id, 
                'spesifikasi' => $spesifikasi, 
                'departemen_id' => $lokasi_fisik, 
                'status_perangkat' => $status_perangkat, 
                'user_id' => $user_id, 
                'foto' => $foto,
                'tanggal_masuk' => $tanggal_masuk
            );
            if (!empty($ipaddress)) {
                $data_perangkat['ipaddress'] = $ipaddress;
            }
            $this->PerangkatModel->simpan_perangkat($data_perangkat);
            $this->session->set_flashdata('success', 'Perangkat Telah Ditambahkan');
            redirect('karyawan/Kelolaperangkat');
        }
    }
    public function tampilEditPerangkat($perangkat_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Edit Perangkat';
        // Mendapatkan username dari session
        $username = $this->session->userdata('username');
        
        // Memanggil Method dari Model
        $data['users'] = $this->UserModel->getUserById($username);
        // Dapatkan data perangkat berdasarkan IDs
        $data['perangkat'] = $this->PerangkatModel->getPerangkatById($perangkat_id);
        $data['kategori'] = $this->PerangkatModel->getKategori();
        // Mengambil user_id
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/edit-perangkat');
        $this->load->view('karyawan/templates/footer');
    }
    public function updatePerangkat($perangkat_id) {
        $nomer_seri = $this->input->post('nomer_seri');
        $nama_perangkat = $this->input->post('nama_perangkat');
        $ipaddress = $this->input->post('ipaddress');
        $kategori_id = $this->input->post('kategori_id');
        $spesifikasi = $this->input->post('spesifikasi');
        $tanggal_masuk = $this->input->post('tanggal_masuk');
        // Ubah Tanggal DY:MT:YR menjadi YR:M
        $status_perangkat = $this->input->post('status_perangkat');
        $catatan = $this->input->post('catatan');
        // Mendapatkan user_id dari session
        $user_id = $this->session->userdata('user_id');
        // Cek apakah ada file baru yang diunggah
        if ($_FILES['foto']['name'] !== '') {
            // Upload foto baru
            $config['upload_path'] = './assets/img/perangkat/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_upload', $error);
                redirect('Karyawan/KelolaPerangkat/tampilEditPerangkat/' . $perangkat_id);
            } else {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                // Data perangkat
                $data_perangkat = array(
                    'nomer_seri' => $nomer_seri, 
                    'nama_perangkat' => $nama_perangkat, 
                    'kategori_id' => $kategori_id, 
                    'spesifikasi' => $spesifikasi, 
                    'status_perangkat' => $status_perangkat, 
                    'catatan' => $catatan, 
                    'user_id' => $user_id, 
                    'foto' => $foto,
                    'tanggal_masuk' => $tanggal_masuk
                );
                if (!empty($ipaddress)) {
                    $data_perangkat['ipaddress'] = $ipaddress;
                }
                $this->PerangkatModel->update_perangkat($perangkat_id, $data_perangkat);
                $this->session->set_flashdata('success', 'Perangkat Telah Diperbarui');
                redirect('Karyawan/KelolaPerangkat');
            }
        } else {
            // Gunakan foto yang sudah ada
            $data_perangkat = array(
                'nomer_seri' => $nomer_seri, 
                'nama_perangkat' => $nama_perangkat, 
                'kategori_id' => $kategori_id, 
                'spesifikasi' => $spesifikasi, 
                'status_perangkat' => $status_perangkat, 
                'catatan' => $catatan, 
                'user_id' => $user_id,
                'tanggal_masuk' => $tanggal_masuk
            );
            if (!empty($ipaddress)) {
                $data_perangkat['ipaddress'] = $ipaddress;
            }
            $this->PerangkatModel->update_perangkat($perangkat_id, $data_perangkat);
            $this->session->set_flashdata('success', 'Perangkat Telah Diperbarui');
            redirect('Karyawan/KelolaPerangkat');
        }
    }
    public function hapusPerangkat($perangkat_id) {
        if ($this->PerangkatModel->cekRelasiPerangkat($perangkat_id)) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus perangkat. Ada data terkait yang masih ada. (Request)');
        } else {
            // Mencoba menghapus perangkat beserta data terkait menggunakan ON DELETE CASCADE
            $this->PerangkatModel->delete_perangkat($perangkat_id);
            $this->session->set_flashdata('success', 'Perangkat Telah Dihapus');
        }
        redirect('Karyawan/KelolaPerangkat');
    }
}
