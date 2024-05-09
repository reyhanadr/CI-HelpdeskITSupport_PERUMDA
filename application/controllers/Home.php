<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect('Home/loginPage');
        }else{
            switch ($this->session->userdata('role_id')) {
                case '1':
                    redirect('Administator/Dashboard');
                    break;
                case '2':
                    redirect('Karyawan/Dashboard');
                    break;
                case '3':
                    redirect('Teknisi/Dashboard');
                    break;
            }
        }
    }

    public function loginPage(){
        $this->load->view("login");
    }

    public function login() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $user = $this->UserModel->get_user($username, $password);
        
        if ($user && $user->status == "Aktif") {
            $session_data = array(
                'user_id' => $user->user_id,
                'username' => $user->username,
                'role_id' => $user->role_id, // Assume 'role' field in the database
                'kategori_id' => $user->kategori_id, // Assume 'kategori_id' field in the database
                'logged_in' => TRUE
            );
            
            // Check if 'kategori_id' is not null before adding it to session data
            if ($user->kategori_id !== null) {
                $session_data['kategori'] = $user->kategori_id; // Assume 'kategori_id' field in the database
            }
            
            $this->session->set_userdata($session_data);
            
            // Redirect based on user role
            switch ($user->role_id) {
                case '1':
                    redirect('Administator/Dashboard');
                    break;
                case '2':
                    redirect('Karyawan/Dashboard');
                    break;
                case '3':
                    redirect('Teknisi/Dashboard');
                    break;
            }
        } elseif (!$user) {
            $this->session->set_flashdata('error', 'Username atau Password Salah.');
            redirect('Home/loginPage');
        } else {
            $this->session->set_flashdata('error', 'Akun Anda Tidak Aktif atau Tidak Ada.');
            redirect('Home/loginPage');
        }
    }
    
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('Home');
    }

    public function errorPage() {
        $this->load->view("error_404");
    }
}
