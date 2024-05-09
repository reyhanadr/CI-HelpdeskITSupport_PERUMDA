<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function get_user($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users'); // Ganti 'users' dengan nama tabel user Anda
        return $query->row();
    }


    public function getUserById($username) {
        $this->db->select('users.*, roles.nama_role, departments.nama_departemen');
        $this->db->from('users');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->join('departments', 'departments.departemen_id = users.departemen_id');
        $this->db->where('users.username', $username);
        return $this->db->get()->row();
    }

    public function updateUserProfile($userId, $dataToUpdate)
    {
        // Fungsi ini digunakan untuk mengupdate profil pengguna
        $this->db->where('user_id', $userId);
        $this->db->update('users', $dataToUpdate);
    }


    public function updateProfil($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0;
    }
    public function count_fixed_by_user_n_status($user_id, $status_perangkat)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', $status_perangkat);
        return $this->db->count_all_results('supportticket');
    }
    public function count_perangkat_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('perangkat');
    }
    //teknisi
    public function getUserByIdTeknisi($username)
    {
        $this->db->select('users.*, roles.nama_role, departments.nama_departemen, problemcategories.nama_kategori');
        $this->db->from('users');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->join('departments', 'departments.departemen_id = users.departemen_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = users.kategori_id');
        $this->db->where('users.username', $username);
        return $this->db->get()->row();
    }
    public function count_fixed_by_kategori_n_status($teknisi_id, $kategori_id, $status_perangkat)
    {
        $this->db->where('kategori_id', $kategori_id);
        $this->db->where('status', $status_perangkat);
        $this->db->where('penanggung_jawab_perbaikan', $teknisi_id);
        return $this->db->count_all_results('supportticket');
    }

    public function count_pengajuan_by_kategori_n_status($kategori_id, $status_perangkat)
    {
        $this->db->where('kategori_id', $kategori_id);
        $this->db->where('status', $status_perangkat);
        return $this->db->count_all_results('supportticket');
    }

    public function count_perangkat_byuserid($user_id){
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('perangkat');
    }

    public function count_perangkat_by_kategori($kategori_id)
    {
        $this->db->where('kategori_id', $kategori_id);
        return $this->db->count_all_results('perangkat');
    }
    
}