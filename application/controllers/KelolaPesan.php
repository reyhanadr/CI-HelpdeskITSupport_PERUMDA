<?php
defined('BASEPATH') or exit('No direct script access allowed');
class KelolaPesan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('RequestModel');
        $this->load->model('PerangkatModel');
        $this->load->model('UserModel');
        $this->load->model('NotifikasiModel');
        $this->load->model('ChatModel');
    }
    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-view';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');
        // Mendapatkan List Pesan
        $kategori_id = $this->session->userdata('kategori');
        $data['list_chat'] = $this->ChatModel->getHistoryMessages($kategori_id);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $user_id);
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $user_id);
        // hitung jumlah pesan
        $data['jml_pesan'] = $this->ChatModel->countTotalMessagesByCategoryAndUser($user_id, $kategori_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/chat-list', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function pesanPengajuan() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-pengajuan';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');
        // Mendapatkan List Pesan
        $kategori_id = $this->session->userdata('kategori');
        $data['list_chat'] = $this->ChatModel->getHistoryMessagesByStatus($kategori_id, "open");
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        // hitung jumlah pesan
        $data['jml_pesan'] = $this->ChatModel->countTotalMessagesByStatusPengajuan('open', $kategori_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/chat-list', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function pesanBerlangsung() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-pengajuan';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');
        // Mendapatkan List Pesan
        $kategori_id = $this->session->userdata('kategori');
        $data['list_chat'] = $this->ChatModel->getHistoryMessagesByStatusNReceiverId($kategori_id, "taken", $user_id);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        // hitung jumlah pesan
        $data['jml_pesan'] = $this->ChatModel->getTotalMessagesByStatus($kategori_id, "taken", $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/chat-list', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function pesanBerakhir() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-pengajuan';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');
        // Mendapatkan List Pesan
        $kategori_id = $this->session->userdata('kategori');
        $data['list_chat'] = $this->ChatModel->getHistoryMessagesByStatusNReceiverId($kategori_id, "closed", $user_id);
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));
        // hitung jumlah pesan
        $data['jml_pesan'] = $this->ChatModel->getTotalMessagesByStatus($kategori_id, "closed", $user_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/chat-list', $data);
        $this->load->view('teknisi/templates/footer');
    }
    public function requestPesan() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-view';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['tickets'] = $this->RequestModel->getTicketsWithDetails($username);
        $data['users'] = $this->UserModel->getUserById($username);
        // mengambil data kategori
        $data['kategori'] = $this->PerangkatModel->getKategori();
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        if($this->ChatModel->cekPesanSebelumnya($user_id, 'open') || $this->ChatModel->cekPesanSebelumnya($user_id, 'taken') ){
            $data['cekPesanSebelumnya'] = $this->ChatModel->cekPesanSebelumnya($user_id, 'open');
            $data['cekPesanSebelumnya'] = $this->ChatModel->cekPesanSebelumnya($user_id, 'taken');
            redirect('KelolaPesan/chatroom/' . $data['cekPesanSebelumnya']->sesi_pesan); // Arahkan ke chatroom dengan sesi yang benar
        }
        $this->load->view('karyawan/templates/header', $data);
        $this->load->view('karyawan/templates/sidebar', $data);
        $this->load->view('karyawan/chat-kategori', $data);
        $this->load->view('karyawan/templates/footer');
    }
    private function incrementSesi_Pesan($lastSesiPesan) {
        // Ambil angka dari ID produk terakhir
        $lastNumber = (int)substr($lastSesiPesan, 4);
        // Increment angka
        $nextNumber = $lastNumber + 1;
        // Jika angka melebihi 999, kembalikan nilai awal "JM000"
        if ($nextNumber > 999) {
            return 'PES0000';
        }
        // Format angka menjadi tiga digit dengan padding nol di depan
        $nextProductID = 'PES' . sprintf('%04d', $nextNumber);
        return $nextProductID;
    }
    public function akhiriChat($sesi_pesan) {
        $data['get_sesiPesan'] = $this->ChatModel->getChatsBySesiForNotif($sesi_pesan, 'taken');
        // Ambil kategori_id berdasarkan sesi_pesan dari URL
        $data['kategori_id'] = $this->ChatModel->getKategoriIdBySesiPesan($sesi_pesan);
        $data_notif = array(
        'user_id' => $data['get_sesiPesan']->sender_id, 
        'teknisi_id' => $data['get_sesiPesan']->receiver_id, 
        'sesi_pesan' => $sesi_pesan, 
        'kategori_id' => $data['get_sesiPesan']->kategori_id, 
        'department_id' => $data['get_sesiPesan']->department_id, 
        'message_for_teknisi' => 'Anda Mengakhiri Chat dari ' . $data['get_sesiPesan']->sender_nama . ' Dengan Sesi Pesan ' . $sesi_pesan, 'message_for_karyawan' => 'Live Chat Anda Telah Diakhiri Oleh ' . $data['get_sesiPesan']->receiver_nama . '.', 
        'link' => 'KelolaPesan/chatroom/'. $sesi_pesan, 'is_read' => 'UNREAD');
        $this->ChatModel->endMessage($this->session->userdata('user_id'), $sesi_pesan); // Panggil fungsi untuk mengakhiri chat
        $this->NotifikasiModel->tambah_notifikasi($data_notif);
        // Redirect atau lakukan tindakan lain sesuai kebutuhan
        redirect('KelolaPesan/'); // Arahkan ke chatroom dengan sesi yang benar
        
    }
    public function start_chat() {
        $lastSesiPesan = $this->ChatModel->getLastSesiPesan();
        $newSesiPesan = $this->incrementSesi_Pesan($lastSesiPesan);
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-view';
        $data['title'] = 'Chat Page';
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserById($username);
        $user = $this->UserModel->getUserById($username);
        $user_id = $user->user_id;
        // mendapatkan departemen karyawan untuk notifikasi
        $depart_user = $user->departemen_id;
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        // ambil input yang diperlukan untuk memulai percakapan
        $kategori_id = $this->input->post('kategori_id');
        $message = $this->input->post('message');
        $data['getKategori'] = $this->ChatModel->getKategoriById($kategori_id);
        // Input Data Ke Tabel Messages
        $this->ChatModel->startChat($user_id, $newSesiPesan, $kategori_id, $message);
        // ambil data untuk notif
        $data_notif = array('user_id' => $user_id, 'sesi_pesan' => $newSesiPesan, 'kategori_id' => $kategori_id, 'department_id' => $depart_user, 'message_for_teknisi' => 'Terdapat Pesan Baru dari ' . $user->nama . ' Dengan Sesi Pesan ' . $newSesiPesan, 'message_for_karyawan' => 'Anda Telah Mengajukan Live Chat untuk kategori ' . $data['getKategori']->nama_kategori . '.', 'link' => 'KelolaPesan/chatroom/' . $newSesiPesan, 'is_read' => 'UNREAD');
        $this->NotifikasiModel->tambah_notifikasi($data_notif);
        redirect('KelolaPesan/chatroom/' . $newSesiPesan); // Arahkan ke chatroom dengan sesi yang benar
        
    }
    public function getNewMessages($sesi_pesan) {
        $user_id_loggedin = $this->session->userdata('user_id');
        $chats = $this->ChatModel->getChatsBySesi($user_id_loggedin, $sesi_pesan);
        // Mengembalikan pesan baru sebagai respons JSON
        echo json_encode($chats);
    }
    public function chatroom($sesi_pesan) {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-view';
        $data['title'] = 'Chat Page';
        $username_loggedin = $this->session->userdata('username'); // mendapatkan username yang sedang login
        $user_id_loggedin = $this->session->userdata('user_id'); // mendapatkan user_id yang sedang login
        $kategori_id_loggedin = $this->session->userdata('kategori_id'); // mendapatkan kategori_id yang sedang login
        // Menampilkan isi chat dari database dari karyawan dan tekni
        $data['chats'] = $this->ChatModel->getChatsBySesi($user_id_loggedin, $sesi_pesan);
        $data['chats_teknisi'] = $this->ChatModel->getChatsByRole($sesi_pesan, 3);
        // Mendapatkan status pesan berdasarkan sesi
        $data['get_receiver_status'] = $this->ChatModel->getReceiverIdAndStatusBySesi($sesi_pesan);
        // Ambil Data Sesi Pesan dan kategori_id agar dapat mengirim pesan baru
        $data['sesi_pesan'] = $sesi_pesan;
        // Ambil kategori_id berdasarkan sesi_pesan dari URL
        $data['kategori_id'] = $this->ChatModel->getKategoriIdBySesiPesan($sesi_pesan);
        if ($this->session->userdata('role_id') == 2 && $data['get_receiver_status']->status == "closed") {
            $this->load->view('chat-closed', $data);
        }
        // Jika Login Sebagai Teknisi
        elseif ($this->session->userdata('role_id') == 3) {
            $data['users'] = $this->UserModel->getUserByIdTeknisi($username_loggedin);
            // Mendapatkan Notifikasi Teknisi
            $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id_loggedin, $this->session->userdata('user_id'));
            $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id_loggedin, $this->session->userdata('user_id'));
            // View
            $this->load->view('teknisi/templates/header', $data);
            $this->load->view('teknisi/templates/sidebar', $data);
            $this->load->view('chat-room', $data);
            $this->load->view('teknisi/templates/footer');
            // Jika Login sebagai Karyawan
            
        } elseif ($this->session->userdata('role_id') == 2 && $data['get_receiver_status']->status != "closed") {
            $data['users'] = $this->UserModel->getUserById($username_loggedin);
            // Mendapatkan Notifikasi Karyawan
            $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id_loggedin);
            $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id_loggedin);
            // View
            $this->load->view('karyawan/templates/header', $data);
            $this->load->view('karyawan/templates/sidebar', $data);
            $this->load->view('chat-room', $data);
            $this->load->view('karyawan/templates/footer');
        }
    }
    public function terimaPesanTeknisi($sesi_pesan) {
        $notif_for_karyawan = $this->ChatModel->getChatsBySesiForNotif($sesi_pesan, 'open');
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $user_id = $this->session->userdata('user_id');
        // Update data row 1 sesuai sesi pesan
        $this->ChatModel->updateMessageStatus($user_id, $sesi_pesan);
        // ambil data untuk notif
        $data_notif = array(
            'user_id' => $notif_for_karyawan->sender_id, 
            'teknisi_id' => $this->session->userdata('user_id'), 
            'sesi_pesan' => $sesi_pesan, 
            'kategori_id' => $notif_for_karyawan->kategori_id, 
            'department_id' => $notif_for_karyawan->departemen_id, 
            'message_for_teknisi' => $notif_for_karyawan->receiver_nama . 'Menerima Live Chat dari ' . $notif_for_karyawan->sender_nama . ' Dengan Sesi Pesan: ' . $sesi_pesan, 'message_for_karyawan' => 'Live Chat Anda Telah Diterima Oleh ' . $this->session->userdata('username') . '.' . ' Dengan Sesi Pesan: ' . $sesi_pesan . '.', 
            'link' => 'KelolaPesan/chatroom/' . $sesi_pesan, 'is_read' => 'UNREAD');
        $this->NotifikasiModel->tambah_notifikasi($data_notif);
        redirect('KelolaPesan/chatroom/' . $sesi_pesan . '/refresh', 'refresh'); // Arahkan ke chatroom dengan sesi yang benar
        
    }
    public function kirimPesan() {
        $sesi_pesan = $this->input->post('sesi_pesan');
        $kategori_id = $this->input->post('kategori_id');
        $sender_id = $this->input->post('sender_id');
        $receiver_id = $this->input->post('receiver_id');
        $status = $this->input->post('status');
        $message = trim($this->input->post('message')); // Trim pesan untuk menghapus spasi ekstra
        $media = ""; // Inisialisasi variabel gambar
        // Validasi pesan teks hanya jika pengguna mengirim teks saja
        if (empty($message) && empty($_FILES['media']['name'])) {
            // Tampilkan pesan kesalahan jika pesan teks kosong dan tidak ada media yang diunggah
            redirect('KelolaPesan/chatroom/' . $sesi_pesan . '?error=Pesan tidak boleh kosong jika tidak ada media');
            return;
        }
        // Memeriksa apakah ada file gambar yang diunggah
        if ($_FILES['media']['name']) {
            $config['upload_path'] = './assets/img/media/'; // Lokasi penyimpanan gambar
            $config['allowed_types'] = 'jpg|jpeg|png|mp4|avi|mov';
            $config['max_size'] = 20480; // Batasan ukuran file (dalam KB)
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('media')) {
                $uploaded_data = $this->upload->data();
                $media = $uploaded_data['file_name'];
            }
        }
        // Menyimpan pesan ke dalam database
        $data = array('sesi_pesan' => $sesi_pesan, 'sender_id' => $sender_id, 'receiver_id' => $receiver_id, 'kategori_id' => $kategori_id, 'status' => $status, 'message' => $message, 'image' => $media, // Simpan nama file gambar dalam database
        'timestamp' => date('Y-m-d H:i:s'));
        $this->ChatModel->save_message($data);
        $username = $this->session->userdata('username');
        $user = $this->UserModel->getUserById($username);
        $role_id = $this->session->userdata('role_id');
        // Ambil kategori_id berdasarkan sesi_pesan dari URL
        $data['getKategori'] = $this->ChatModel->getKategoriById($kategori_id);
        // mendapatkan departemen karyawan untuk notifikasi
        $depart_user = $user->departemen_id;
        // ambil data untuk notif
        $data_notif = array('user_id' => $receiver_id, 'teknisi_id' => $sender_id, 'sesi_pesan' => $sesi_pesan, 'kategori_id' => $kategori_id, 'department_id' => $depart_user, 'link' => 'KelolaPesan/chatroom/' . $sesi_pesan, 'is_read' => 'UNREAD');
        // Inisialisasi pesan
        $message_for_karyawan = '';
        // Memeriksa apakah ada pesan teks atau media
        if (!empty($message)) {
            // Jika ada pesan teks
            if ($role_id == 3) {
                $message_for_karyawan = $user->nama . ' Pesan: ' . $message;
                $data_notif['message_for_karyawan'] = $message_for_karyawan;
            } elseif ($role_id == 2) {
                $message_for_teknisi = $user->nama . ' Pesan: ' . $message;
                $data_notif['message_for_teknisi'] = $message_for_teknisi;
            }
        } else {
            if ($role_id == 3) {
                $message_for_karyawan = $user->nama . ' Mengirim Media: ' . $media . ' dengan Sesi Pesan: ' . $sesi_pesan;
                $data_notif['message_for_karyawan'] = $message_for_karyawan;
            } elseif ($role_id == 2) {
                $message_for_teknisi = $user->nama . ' Pesan: ' . $message;
                $data_notif['message_for_teknisi'] = $message_for_teknisi;
            }
        }
        // Simpan pesan ke dalam data notifikasi
        $this->NotifikasiModel->tambah_notifikasi($data_notif);
        redirect('KelolaPesan/chatroom/' . $sesi_pesan); // Arahkan ke chatroom dengan sesi yang benar
        
    }
    // Cari Pesan
    public function cariPesan() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        $data['active_menu'] = 'pesan-view';
        $data['title'] = 'Chat Page';
        $keywords = $this->input->get('cariPesan'); // Ambil query pencarian dari URL parameter 'cariPesan'
        // Mendapatkan data username dari session
        $username = $this->session->userdata('username');
        $user_id = $this->session->userdata('user_id');
        // Kemudian Anda bisa meneruskan data username ke model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user_id = $this->session->userdata('user_id');
        // Mendapatkan Notifikasi
        $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_id($user_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_id($user_id);
        // Model cari pesan
        $kategori_id = $this->session->userdata('kategori');
        $data['list_chat'] = $this->ChatModel->searchMessages($user_id, $kategori_id, $keywords);
        // hitung jumlah pesan
        $data['jml_pesan'] = $this->ChatModel->countTotalMessagesByCategoryAndUser($user_id, $kategori_id);
        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/chat-list', $data);
        $this->load->view('teknisi/templates/footer');
    }

    public function cekPesan(){

    }
    // public function markNotificationAsRead() {
    //     $notifId = $this->input->post('notif_id');
    //     // Panggil model atau metode yang akan mengubah status notifikasi
    //     $this->NotifikasiModel->markNotificationAsRead($notifId);
    //     // Berikan respons sesuai kebutuhan, misalnya pesan sukses atau status
    //     echo 'Success';
    // }
    // public function getPesan() {
    //     $sender_id = $this->input->get('sender_id');
    //     $receiver_id = $this->input->get('receiver_id');
    //     $messages = $this->Chat_model->get_messages($sender_id, $receiver_id);
    //     echo json_encode($messages);
    // }
}
