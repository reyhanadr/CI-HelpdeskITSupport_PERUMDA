<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PerangkatModel extends CI_Model
{

    public function cekRelasiPerangkat($perangkat_id) {

        // Gantilah 'field_id_perangkat' dengan nama field yang mengacu pada perangkat
        $field_id_perangkat = 'perangkat_id';

        // Cek apakah ada data terkait
        $this->db->where($field_id_perangkat, $perangkat_id);
        $query = $this->db->get('supportticket');

        // Jika terdapat hasil (baris) dalam query, maka ada data terkait
        if ($query->num_rows() > 0) {
            return true;
        }

        // Jika tidak ada hasil dalam query, maka tidak ada data terkait
        return false;
    }
    public function getPerangkatUser($username)
    {
        $this->db->select('perangkat.*, users.username, users.nama, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('perangkat');
        $this->db->join('users', 'users.user_id = perangkat.user_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = perangkat.kategori_id ');
        $this->db->join('departments', 'departments.departemen_id = perangkat.departemen_id ');
        $this->db->where('users.username', $username);
        return $this->db->get()->result();
    }

    public function getPerangkatUserForTambahRequest($username)
    {
        $this->db->select('perangkat.*, users.username, users.nama, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('perangkat');
        $this->db->join('users', 'users.user_id = perangkat.user_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = perangkat.kategori_id ');
        $this->db->join('departments', 'departments.departemen_id = perangkat.departemen_id ');
        $this->db->where('users.username', $username);
        $this->db->where_in('perangkat.status_perangkat', array('SELESAI', 'DIPAKAI', 'RUSAK'));
        return $this->db->get()->result();
    }
    

    //get teknisi

    public function getPerangkatWithDetailsById($perangkat_id){
        $this->db->select('
            perangkat.*,
            departments.nama_departemen, 
            users.nama AS nama_user, 
            problemcategories.nama_kategori AS nama_kategori, 
        ');
        $this->db->from('perangkat');
        $this->db->join('departments', 'perangkat.departemen_id = departments.departemen_id');
        $this->db->join('users', 'perangkat.user_id = users.user_id');
        $this->db->join('problemcategories', 'perangkat.kategori_id = problemcategories.kategori_id');
        $this->db->where('perangkat.id', $perangkat_id);

        $query = $this->db->get();
        return $query->row(); // Menggunakan row() untuk mengambil satu baris data.
    }

    public function getSupportTicketsWithDetailsByPerangkatIdForKaryawan($perangkat_id) {
        $this->db->select('
            supportticket.request_id, 
            supportticket.user_id, 
            supportticket.role_id, 
            supportticket.perangkat_id, 
            supportticket.kategori_id, 
            supportticket.department_id, 
            supportticket.status, 
            supportticket.deskripsi_permasalahan, 
            supportticket.prioritas, 
            supportticket.foto, 
            supportticket.tanggal_dibuat, 
            supportticket.tanggal_ditangani, 
            supportticket.catatan, 
            supportticket.penanggung_jawab_perbaikan, 
            perangkat.nama_perangkat,
            perangkat.nomer_seri,  
            perangkat.ipaddress, 
            perangkat.tanggal_masuk, 
            departments.nama_departemen, 
            users.nama AS nama_user,
            penanggung.nama AS penanggung_jawab
        ');
        $this->db->from('supportticket');
        $this->db->join('perangkat', 'supportticket.perangkat_id = perangkat.id');
        $this->db->join('departments', 'supportticket.department_id = departments.departemen_id');
        $this->db->join('users', 'supportticket.user_id = users.user_id');
        $this->db->join('users AS penanggung', 'supportticket.penanggung_jawab_perbaikan = penanggung.user_id'); // Aliaskan tabel users sebagai penanggung
        $this->db->where('supportticket.perangkat_id', $perangkat_id);
        $query = $this->db->get();
        
        return $query->result(); // Menggunakan result() untuk mengambil semua hasil yang cocok.
    }
    

    public function getSupportTicketsWithDetailsForKaryawan($request_id) {
        $this->db->select('
            supportticket.request_id, 
            supportticket.user_id, 
            supportticket.role_id, 
            supportticket.perangkat_id, 
            supportticket.kategori_id, 
            supportticket.department_id, 
            supportticket.status, 
            supportticket.deskripsi_permasalahan, 
            supportticket.prioritas, 
            supportticket.foto, 
            supportticket.tanggal_dibuat, 
            supportticket.tanggal_ditangani, 
            supportticket.catatan, 
            supportticket.penanggung_jawab_perbaikan, 
            perangkat.nama_perangkat,
            perangkat.nomer_seri,  
            perangkat.ipaddress, 
            perangkat.tanggal_masuk, 
            departments.nama_departemen, 
            users.nama AS nama_user,
            penanggung.nama AS penanggung_jawab
        ');
        $this->db->from('supportticket');
        $this->db->join('perangkat', 'supportticket.perangkat_id = perangkat.id');
        $this->db->join('departments', 'supportticket.department_id = departments.departemen_id');
        $this->db->join('users', 'supportticket.user_id = users.user_id');
        $this->db->join('users AS penanggung', 'supportticket.penanggung_jawab_perbaikan = penanggung.user_id'); // Aliaskan tabel users sebagai penanggung
        $this->db->where('supportticket.request_id', $request_id);
        $query = $this->db->get();
        
        return $query->row(); // Menggunakan row() untuk mengambil satu baris data.
    }

    public function getPerangkatByKategoriId($kategori_id)
    {
        $this->db->select('perangkat.*, users.username, users.nama, problemcategories.nama_kategori');
        $this->db->from('perangkat');
        $this->db->join('users', 'users.user_id = perangkat.user_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = perangkat.kategori_id ');
        $this->db->where('perangkat.kategori_id', $kategori_id);
        return $this->db->get()->result();
    }

    public function simpan_perangkat($data)
    {
        return $this->db->insert('perangkat', $data);
    }
    public function getDepartemen()
    {
        $this->db->select('departemen_id, nama_departemen');
        $query = $this->db->get('departments');
        return $query->result();
    }

    public function getPerangkatById($perangkat_id)
    {
        $this->db->select('perangkat.*, departments.nama_departemen, users.nama');
        $this->db->from('perangkat');
        $this->db->join('departments', 'perangkat.departemen_id = departments.departemen_id');
        $this->db->join('users', 'perangkat.user_id = users.user_id');
        $this->db->where('perangkat.id', $perangkat_id);
        return $this->db->get()->row();
    }
    

    public function updatePerangkat($perangkat_id, $data)
    {
        $this->db->where('id', $perangkat_id);
        $this->db->update('perangkat', $data);
    }

    public function getKategori()
    {
        $this->db->select('kategori_id, nama_kategori');
        $query = $this->db->get('problemcategories');
        return $query->result();
    }
    public function update_perangkat($perangkat_id, $data)
    {
        $this->db->where('id', $perangkat_id);
        $this->db->update('perangkat', $data);
    }
    public function delete_perangkat($perangkat_id)
    {
        $this->db->where('id', $perangkat_id);
        $this->db->delete('perangkat');
    }
    public function searchPerangkat($keyword, $user_id)
    {
        $this->db->select('perangkat.*, problemcategories.nama_kategori, departments.nama_departemen, users.nama');
        $this->db->from('perangkat');
        $this->db->join('problemcategories', 'perangkat.kategori_id = problemcategories.kategori_id', 'left');
        $this->db->join('departments', 'perangkat.departemen_id = departments.departemen_id', 'left');
        $this->db->join('users', 'perangkat.user_id = users.user_id', 'left');
    
        $this->db->like('perangkat.nomer_seri', $keyword);
        $this->db->or_like('perangkat.nama_perangkat', $keyword);
        $this->db->or_like('perangkat.status_perangkat', $keyword);
        $this->db->or_like('perangkat.spesifikasi', $keyword);
        return $this->db->get()->result();
    }


    public function updateStatusPerangkat($perangkat_id, $new_status)
    {
        $this->db->where('id', $perangkat_id);
        $this->db->update('perangkat', ['status_perangkat' => $new_status]);
    }

}