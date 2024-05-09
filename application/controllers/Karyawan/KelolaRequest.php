<?php
defined('BASEPATH') or exit('No direct script access allowed');
class KelolaRequest extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('RequestModel');
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
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Kelola Request';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['tickets'] = $this->RequestModel->getTicketsWithDetails($this->session->userdata('username'));
        $data['users'] = $this->UserModel->getUserById($username);
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/kelolarequest');
        $this->load->view('karyawan/templates/footer');
    }
    public function tampilTambahRequest() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Tambah Request';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Mendapatkan ID produk terakhir dari database
        $lastReqID = $this->RequestModel->getlastReqID();
        $newReqID = $this->incrementReqID($lastReqID);
        // Memanggil method dari model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['perangkat'] = $this->PerangkatModel->getPerangkatUserForTambahRequest($username);
        $data['kategori'] = $this->RequestModel->getKategori();
        // Kirim nilai $newReqID ke view menggunakan array data
        $data['newReqID'] = $newReqID;
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['tanggalHariIni'] = date("Y-m-d"); // Format: Tahun-Bulan-Tanggal (contoh: 2023-07-14)
        // Dapatkan user_id
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        // Load view form dan kirim data ke view
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/tambah-request', $data);
        $this->load->view('karyawan/templates/footer');
    }
    private function incrementReqID($lastReqID) {
        // Ambil angka dari ID produk terakhir
        $lastNumber = (int)substr($lastReqID, 4);
        // Increment angka
        $nextNumber = $lastNumber + 1;
        // Jika angka melebihi 999, kembalikan nilai awal "JM000"
        if ($nextNumber > 999) {
            return 'REQ0000';
        }
        // Format angka menjadi tiga digit dengan padding nol di depan
        $nextProductID = 'REQ' . sprintf('%04d', $nextNumber);
        return $nextProductID;
    }
    public function simpanRequest() {
        $request_id = $this->input->post('request_id');
        $user_id = $this->input->post('user_id');
        $role_id = $this->input->post('role_id');
        $perangkat_id = $this->input->post('perangkat_id');
        $kategori_id = $this->RequestModel->getKategoriByPerangkatID($perangkat_id)->kategori_id;
        $department_id = $this->input->post('department_id');
        $status = $this->input->post('status_perangkat');
        $deskripsi_permasalahan = $this->input->post('deskripsi_permasalahan');
        $prioritas = $this->input->post('prioritas');
        // Upload foto
        $config['upload_path'] = './assets/img/request/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);
        // Cek apakah perangkat dengan perangkat_id sudah diajukan sebelumnya
        $existing_request = $this->RequestModel->getExistingRequestByPerangkat($perangkat_id);
        if ($existing_request) {
            $this->session->set_flashdata('error', 'Perangkat sedang diajukan.');
            redirect('Karyawan/Kelolarequest');
        } else {
            if (!$this->upload->do_upload('foto')) {
                $error = $this->upload->display_errors();
                $data['upload_error'] = $error;
                $this->load->view('karyawan/kelolarequest', $data);
            } else {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                $data_request = array('request_id' => $request_id, 'user_id' => $user_id, 'role_id' => $role_id, 'perangkat_id' => $perangkat_id, 'kategori_id' => $kategori_id, 'department_id' => $department_id, 'status' => $status, 'deskripsi_permasalahan' => $deskripsi_permasalahan, 'prioritas' => $prioritas, 'foto' => $foto, 'tanggal_dibuat' => date('Y-m-d H:i:s', strtotime('now')));
                // Mengambil Data User yang sedang melakukan request untk dikirim pada tabel notif \
                $username = $this->session->userdata('username');
                $userData = $this->UserModel->getUserById($username);
                $perangkat = $this->PerangkatModel->getPerangkatById($perangkat_id);
                $data_notif = array('user_id' => $user_id, 'request_id' => $request_id, 'kategori_id' => $kategori_id, 'department_id' => $department_id, 'message_for_teknisi' => 'Perangkat ' . $perangkat->nama_perangkat . ' dari ' . $userData->nama . ' ' . $userData->nama_departemen . ' memiliki masalah dan butuh diperbaiki.', 'message_for_karyawan' => 'Anda telah mengajukan permintaan perbaikan untuk perangkat ' . $perangkat->nama_perangkat . '.', 'link' => 'Dashboard/Search?keyword=' . $request_id, 'is_read' => 'UNREAD');
                $this->RequestModel->simpan_request($data_request);
                $this->NotifikasiModel->tambah_notifikasi($data_notif);
                $this->RequestModel->updateStatusPerangkat($perangkat_id, $status);
                $this->session->set_flashdata('success', 'Request Support Ticket Telah Ditambahkan');
                redirect('Karyawan/KelolaRequest');
            }
        }
    }
    public function tampilEditRequest($request_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Edit Request';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kueri dari Model
        $data['users'] = $this->UserModel->getUserById($username);
        $data['request'] = $this->RequestModel->getRequestById($request_id);
        // Mengambil user_id
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        // Load view form dan kirim data ke view
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/edit-request', $data);
        $this->load->view('karyawan/templates/footer');
    }
    public function updateRequest($request_id) {
        $deskripsi = $this->input->post('deskripsi');
        $prioritas = $this->input->post('prioritas');
        $catatan = $this->input->post('catatan');
        // Upload foto baru (jika ada)
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/img/request/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('Karyawan/KelolaRequest/tampilEditRequest/' . $request_id);
            }
        }
        // Data yang akan diupdate
        $data = array('deskripsi_permasalahan' => $deskripsi, 'prioritas' => $prioritas, 'catatan' => $catatan);
        if (!empty($foto)) {
            $data['foto'] = $foto;
        }
        // Lakukan update
        $this->RequestModel->updateRequest($request_id, $data);
        $this->session->set_flashdata('success', 'Request telah diperbarui');
        redirect('Karyawan/KelolaRequest/');
    }
    public function setStatusToBerjalan($request_id) {
        // Ambil data request berdasarkan ID
        $request = $this->RequestModel->getRequestById($request_id);
        // Jika status saat ini adalah "FIXED", ubah menjadi "RUNNING"
        if ($request->status === 'SELESAI') {
            $this->RequestModel->updateStatusToBerjalan($request_id);
            // Set flash data untuk pesan sukses
            $this->session->set_flashdata('success', 'Status Perangkat Telah Berjalan Sepenuhnya.');
            redirect('Karyawan/KelolaRequest');
        } elseif ($request->status === 'PENGAJUAN') {
            // Set flash data untuk pesan error
            $this->session->set_flashdata('error', 'Perangkat Sedang Ditinjau untuk Perbaikan.');
            redirect('Karyawan/KelolaRequest');
        } elseif ($request->status === 'RUSAK') {
            // Set flash data untuk pesan error
            $this->session->set_flashdata('error', 'Perrangkat Tidak Dapat Berjalan dan Tidak Dapat Diperbaiki');
            redirect('Karyawan/KelolaRequest');
        }
    }
    public function BatalkanRequest($request_id) {
        // Ambil data request berdasarkan ID
        $this->RequestModel->updateToBatal($request_id);
        // Set flash data untuk pesan sukses
        $this->session->set_flashdata('success', 'Request Permasalahan Dibatalkan.');
        redirect('Karyawan/KelolaRequest');
    }
    public function DetailRequest($request_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '2') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Detail Request';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($data['users']->user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($data['users']->user_id);
        $data['supportticket'] = $this->RequestModel->getSupportTicketsWithDetailsForKaryawan($request_id);
        $getPerangkatId = $this->RequestModel->getPerangkatIdForRiwayat($request_id);
        // Menampilkan Riwayat Kerusakan
        $data['riwayat'] = $this->RequestModel->getRiwayatRequestByPerangkatId($getPerangkatId->perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/detail-request', $data);
        $this->load->view('karyawan/templates/footer');
    }
}
