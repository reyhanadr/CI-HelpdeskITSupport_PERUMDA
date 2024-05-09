<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('RequestModel');
        $this->load->model('PerangkatModel');
        $this->load->model('UserModel');
        $this->load->model('ChatModel');
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
        $data['active_menu'] = 'Dashboard';
        $data['title'] = 'Dashboard Teknisi';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        $user_id = $this->session->userdata('user_id');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $data['list_chat'] = $this->ChatModel->getHistoryMessages($kategori_id);
        // Ambil Data Ticket
        $ticketsNull = $this->RequestModel->getTicketsTeknisi($kategori_id, NULL);
        $ticketsByPenanggungJawab = $this->RequestModel->getTicketsTeknisi($kategori_id, $user_id);
        $data['tickets'] = array_merge($ticketsNull, $ticketsByPenanggungJawab);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        // Dapatkan jumlah Request
        $data['jml_pending'] = $this->UserModel->count_pengajuan_by_kategori_n_status($kategori_id, 'PENGAJUAN');
        $data['jml_fixed'] = $this->UserModel->count_fixed_by_kategori_n_status($user_id, $kategori_id, 'SELESAI');
        $data['jml_notfixed'] = $this->UserModel->count_fixed_by_kategori_n_status($user_id, $kategori_id, 'RUSAK');
        // Dapatkan Jumlah LIVE CHAT
        $data['jml_pesan'] = $this->ChatModel->countTotalMessagesByCategoryAndUser($user_id, $kategori_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/index', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function search() {
        $role_id = $this->session->userdata('role_id');
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($role_id !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $keyword = $this->input->get('keyword'); // Mendapatkan keyword pencarian dari input GET
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Definisi user dan role untuk fitur pencarian
        $user_id = $this->session->userdata('user_id');
        $role_id = $this->session->userdata('role_id');
        $kategori_id = $this->session->userdata('kategori_id');
        // Pencarian data berdasarkan keyword
        $data['tickets'] = $this->RequestModel->searchRequest($keyword, $user_id, $role_id);
        $data['list_chat'] = $this->ChatModel->searchMessages($user_id, $kategori_id, $keyword);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        // dapatkan data user untuk header
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
		if (!empty($data['tickets'])) {
            // Jika tidak ditemukan data organisasi, arahkan ke view data-request
            $data['active_menu'] = 'kelolaRequest';
			$data['title'] = 'Mencari Request Ticket';
            $this->load->view('teknisi/templates/header', $data);
            $this->load->view('teknisi/templates/sidebar', $data);
            $this->load->view('teknisi/kelolarequest');
            $this->load->view('teknisi/templates/footer');
        }if (!empty($data['list_chat'])) {
            // Jika ditemukan data organisasi, arahkan ke view data-perangkat
            $data['active_menu'] = 'Kelola Pesan';
			$data['title'] = 'Mencari Pesan';
			// hitung jumlah pesan
			$data['jml_pesan'] = $this->ChatModel->countTotalMessagesByCategoryAndUser($user_id, $kategori_id);
			$this->load->view('teknisi/templates/header', $data);
			$this->load->view('teknisi/templates/sidebar', $data);
			$this->load->view('teknisi/chat-list', $data);
			$this->load->view('teknisi/templates/footer');
        }else {
            // Jika tidak ditemukan data organisasi, arahkan ke view data-request
            $data['active_menu'] = 'kelolaRequest';
			$data['title'] = 'Pencarian Keyword: '. $keyword . ' Tidak Ditemukan';
			$data['keyword'] = $keyword;
            $this->load->view('errorSearchNotFound', $data);
        }
    }

    public function kelolaNotifikasi(){
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
            // Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
            redirect('Home/errorPage');
        }
        $data['active_menu'] = 'Dashboard';
        $data['title'] = 'Seluruh Notifikasi';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session
        $user_id = $this->session->userdata('user_id');
        
		$data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');

        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/kelolanotifikasi', $data);
        $this->load->view('teknisi/templates/footer');
    }
}
