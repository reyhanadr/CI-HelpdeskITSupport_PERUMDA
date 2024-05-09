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
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Kelola Request';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        $user_id = $this->session->userdata('user_id'); // Mendapatkan data username dari sessions
        $kategori_id = $this->session->userdata('kategori_id');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $ticketsNull = $this->RequestModel->getTicketsTeknisi($kategori_id, NULL);
        $ticketsByPenanggungJawab = $this->RequestModel->getTicketsTeknisi($kategori_id, $this->session->userdata('user_id'));
        $data['tickets'] = array_merge($ticketsNull, $ticketsByPenanggungJawab);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/kelolarequest');
        $this->load->view('teknisi/templates/footer');
    }
    public function requestPengajuan() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'request-pengajuan';
        $data['title'] = 'Request Pengajuan';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari sessions
        $user_id = $this->session->userdata('user_id'); // Mendapatkan data username dari sessions
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        $ticketPengajuan = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "PENGAJUAN", $this->session->userdata('user_id'));
        $ticketPengajuanNULL = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "PENGAJUAN", NULL);
        $data['tickets'] = array_merge($ticketPengajuan, $ticketPengajuanNULL);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/request-pengajuan');
        $this->load->view('teknisi/templates/footer');
    }
    public function requestProses() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'request-proses';
        $data['title'] = 'Request Proses';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari sessions
        $user_id = $this->session->userdata('user_id'); // Mendapatkan data username dari sessions
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        $data['tickets'] = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "PROSES", $this->session->userdata('user_id'));
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/request-proses');
        $this->load->view('teknisi/templates/footer');
    }
    public function requestSelesai() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'request-proses';
        $data['title'] = 'Request Selesai';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari sessions
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        $ticketsSelesai = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "SELESAI", $this->session->userdata('user_id'));
        $ticketsSelesaiNULL = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "SELESAI", "NULL");
        $ticketsRusak = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "RUSAK", $this->session->userdata('user_id'));
        $ticketsRusakNULL = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "RUSAK", "NULL");
        $ticketsBerjalan = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "DIPAKAI", $this->session->userdata('user_id'));
        $ticketsBerjalanNULL = $this->RequestModel->getTicketsTeknisiByStatus($kategori_id, "DIPAKAI", "NULL");
        // Gabungkan hanya jika data tidak null
        $data['tickets'] = array_merge(!is_null($ticketsSelesai) ? $ticketsSelesai : [], !is_null($ticketsSelesaiNULL) ? $ticketsSelesaiNULL : [], !is_null($ticketsRusak) ? $ticketsRusak : [], !is_null($ticketsRusakNULL) ? $ticketsRusakNULL : [], !is_null($ticketsBerjalan) ? $ticketsBerjalan : [], !is_null($ticketsBerjalanNULL) ? $ticketsBerjalanNULL : []);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/request-selesai');
        $this->load->view('teknisi/templates/footer');
    }
    public function DetailRequest($request_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Detail Request';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        $ticketsNull = $this->RequestModel->getTicketsTeknisi($kategori_id, NULL);
        $ticketsByPenanggungJawab = $this->RequestModel->getTicketsTeknisi($kategori_id, $this->session->userdata('user_id'));
        $data['tickets'] = array_merge($ticketsNull, $ticketsByPenanggungJawab);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['supportticket'] = $this->RequestModel->getSupportTicketsWithDetailsForTeknisi($request_id, $kategori_id);
        // Menampilkan Riwayat Kerusakan
        $data['riwayat'] = $this->RequestModel->getRiwayatRequestByPerangkatId($data['supportticket']->perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/detail-request', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function setStatusToTampil($request_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'kelolaRequest';
        $data['title'] = 'Setting Status';
        $username = $this->session->userdata('username'); // Mendapatkan data username dari session
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        // Ambil Data Ticket
        $ticketsNull = $this->RequestModel->getTicketsTeknisi($kategori_id, NULL);
        $ticketsByPenanggungJawab = $this->RequestModel->getTicketsTeknisi($kategori_id, $this->session->userdata('user_id'));
        $data['tickets'] = array_merge($ticketsNull, $ticketsByPenanggungJawab);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['supportticket'] = $this->RequestModel->getSupportTicketsWithDetailsForTeknisi($request_id, $kategori_id);
        $data['riwayat'] = $this->RequestModel->getRiwayatRequestByPerangkatId($data['supportticket']->perangkat_id);
        // Load view form dan kirim data ke view
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/set-status-req', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function setStatusToProses($request_id) {
        $user_idPenganggungJawab = $this->session->userdata('user_id');
        $username_penanggungJawab = $this->session->userdata('username');
        // Tambahkan timestamp saat ini ke dalam kolom tanggal_ditangani
        // Ambil data request berdasarkan ID
        $this->RequestModel->updateStatusToProses($request_id, $user_idPenganggungJawab);
        $this->session->set_flashdata('success', "Perangkat Segera Di Proses");
        // Mengambil Data Request untuk notifikasi
        $data['data_notif'] = $this->RequestModel->getSupportTicketsWithDetailsForTeknisi($request_id, $this->session->userdata('kategori_id'));
        $data_notif = array('
        user_id' => $data['data_notif']->user_id, 
        'teknisi_id' => $user_idPenganggungJawab, 
        'request_id' => $request_id, 
        'kategori_id' => $data['data_notif']->kategori_id, 
        'department_id' => $data['data_notif']->department_id, 
        'message_for_teknisi' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' dari ' . $data['data_notif']->nama . ' ' . $data['data_notif']->nama_departemen . ' Telah Diproses oleh ' . $username_penanggungJawab . '.', 'message_for_karyawan' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' Anda Telah Diproses.', 'link' => 'Dashboard/Search?keyword=' . $request_id, 'is_read' => 'UNREAD');
        $this->NotifikasiModel->tambah_notifikasi($data_notif);
        redirect('Teknisi/KelolaRequest/requestProses');
    }
    public function setStatusTo($request_id) {
        $status = $this->input->post('status');
        $catatan = $this->input->post('catatan_perbaikan');
        $user_id_penanggungjawab = $this->session->userdata('user_id');
        $username_penanggungJawab = $this->session->userdata('username');
        // Mengambil Data Request untuk notifikasi
        $data['data_notif'] = $this->RequestModel->getSupportTicketsWithDetailsForTeknisi($request_id, $this->session->userdata('kategori_id'));
        // Memeriksa status dan mengambil tindakan berdasarkan kondisi
        if ($status === 'RUSAK') {
            // Memanggil metode untuk mengubah status menjadi Rusak
            $this->RequestModel->updateStatusToRusak($request_id, $catatan, $user_id_penanggungjawab);
            $this->session->set_flashdata('success', "Status Perangkat Tidak Dapat Diperbaiki");
            // Buat Notifikasi
            $data_notif = array(
                'user_id' => $data['data_notif']->user_id, 
                'teknisi_id' => $user_id_penanggungjawab, 
                'request_id' => $request_id, 
                'kategori_id' => $data['data_notif']->kategori_id, 
                'department_id' => $data['data_notif']->department_id, 
                'message_for_teknisi' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' dari ' . $data['data_notif']->nama . ' ' . $data['data_notif']->nama_departemen . ' Tidak Dapat Diperbaiki oleh '. $username_penanggungJawab . '.', 'message_for_karyawan' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' Tidak Dapat Diperbaiki oleh ' . $this->session->userdata('username'), 'link' => 'Dashboard/Search?keyword=' . $request_id, 'is_read' => 'UNREAD');
            $this->NotifikasiModel->tambah_notifikasi($data_notif);
            redirect('Teknisi/KelolaRequest/requestSelesai');
        } elseif ($status === 'SELESAI') {
            // Memanggil metode untuk mengubah status menjadi SELESAII
            $this->RequestModel->updateStatusToSelesai($request_id, $catatan, $user_id_penanggungjawab);
            // Buat Notifikasi
            $data_notif = array(
                'user_id' => $data['data_notif']->user_id, 
                'teknisi_id' => $user_id_penanggungjawab, 
                'request_id' => $request_id, 
                'kategori_id' => $data['data_notif']->kategori_id, 
                'department_id' => $data['data_notif']->department_id, 
                'message_for_teknisi' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' dari ' . $data['data_notif']->nama . ' ' . $data['data_notif']->nama_departemen . ' Telah Diperbaiki oleh ' . $username_penanggungJawab . '.', 'message_for_karyawan' => 'Perangkat ' . $data['data_notif']->nama_perangkat . ' Telah Diperbaiki oleh ' . $this->session->userdata('username'), 'link' => 'Dashboard/Search?keyword=' . $request_id, 'is_read' => 'UNREAD');
            $this->NotifikasiModel->tambah_notifikasi($data_notif);
            $this->session->set_flashdata('success', "Status Perangkat Telah Dapat Diperbaiki");
            redirect('Teknisi/KelolaRequest/requestSelesai');
        } else {
            // Status tidak valid, Anda dapat menambahkan tindakan lain sesuai kebutuhan.
            // Misalnya, menampilkan pesan kesalahan atau mengarahkan pengguna ke halaman lain.
            $this->session->set_flashdata('failed', "Status Tidak Valid");
            redirect('Teknisi/KelolaRequest');
        }
    }
}
