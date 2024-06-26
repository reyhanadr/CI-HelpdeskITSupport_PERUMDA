<?phpredirect('Home/errorPage');
defined('BASEPATH') or exit('No direct script access allowed');

class KelolaPerangkat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('PerangkatModel');
        $this->load->model('UserModel');
        $this->load->model('NotifikasiModel');

    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }
        if ($this->session->userdata('role_id') !== '3') {
			// Jika bukan admin, arahkan kembali ke halaman login atau tindakan lain yang sesuai
			redirect('Home/errorPage');
		}
        $data['active_menu'] = 'kelolaPerangkat';
        $data['title'] = 'Login Page';
        $username = $this->session->userdata('username'); // Mendapatkan username dari session
        $kategori_id = $this->session->userdata('kategori_id'); // Mendapatkan kategori dari session


        // Memanggil method perangkat dari model
        $data['users'] = $this->UserModel->getUserByIdTeknisi($username);
        $user = $this->UserModel->getUserByIdTeknisi($username);
        $kategori_id = $user->kategori_id;
        $data['perangkat'] = $this->PerangkatModel->getPerangkatByKategoriId($kategori_id);


        // Mendapatkan Notifikasi
         $data['notif'] = $this->NotifikasiModel->get_notifikasi_by_kategori($kategori_id, $this->session->userdata('user_id'));
        $data['jml_notif'] = $this->NotifikasiModel->count_notif_by_kategori($kategori_id, $this->session->userdata('user_id'));

        $this->load->view('teknisi/templates/header', $data);
        $this->load->view('teknisi/templates/sidebar', $data);
        $this->load->view('teknisi/kelolaperangkat');
        $this->load->view('teknisi/templates/footer');
    }


}