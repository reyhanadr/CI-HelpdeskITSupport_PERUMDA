<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RequestModel extends CI_Model
{

    public function getExistingRequestByPerangkat($perangkat_id){
        $this->db->where('perangkat_id', $perangkat_id);
        $this->db->where_in('status', ['PENGAJUAN', 'PROSES']);
        return $this->db->get('supportticket')->row();
    }
    
    public function getTicketsWithDetails($username){
        $this->db->select('supportticket.*, users.user_id as user_id_supportticket, penanggung.nama as nama_penanggung_jawab, roles.nama_role, perangkat.nama_perangkat, problemcategories.nama_kategori, departments.nama_departemen, perangkat.ipaddress, perangkat.tanggal_masuk');
        $this->db->from('supportticket');
        $this->db->join('users', 'users.user_id = supportticket.user_id');
        $this->db->join('users as penanggung', 'penanggung.user_id = supportticket.penanggung_jawab_perbaikan', 'left');
        $this->db->join('roles', 'roles.role_id = users.role_id', 'left');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id', 'left');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = supportticket.kategori_id', 'left');
        $this->db->join('departments', 'departments.departemen_id = supportticket.department_id', 'left');
        $this->db->order_by('supportticket.request_id', 'DESC');

        $this->db->where('users.username', $username); // Filter berdasarkan username

        return $this->db->get()->result();


    }
    
    
    

    //teknisi
    public function getTicketsTeknisi($kategori_id, $penanggungJawab){
        $this->db->select('supportticket.*, users.username, users.nama, perangkat.nama_perangkat,perangkat.ipaddress, perangkat.tanggal_masuk, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('supportticket');
        $this->db->join('users', 'users.user_id = supportticket.user_id');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id');
        $this->db->join('departments', 'departments.departemen_id = supportticket.department_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = supportticket.kategori_id'); // Perbaikan disini
        $this->db->where('problemcategories.kategori_id', $kategori_id);
        $this->db->where('supportticket.penanggung_jawab_perbaikan', $penanggungJawab);
        $this->db->order_by('supportticket.tanggal_dibuat', 'DESC');

        return $this->db->get()->result();
    }

    public function getTicketsTeknisiByStatus($kategori_id, $status, $penanggungJawab){
        $this->db->select('supportticket.*, users.username, users.nama, perangkat.nama_perangkat,perangkat.ipaddress, perangkat.tanggal_masuk, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('supportticket');
        $this->db->join('users', 'users.user_id = supportticket.user_id');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id');
        $this->db->join('departments', 'departments.departemen_id = supportticket.department_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = supportticket.kategori_id'); // Perbaikan disini
        $this->db->where('problemcategories.kategori_id', $kategori_id);
        $this->db->where('supportticket.status', $status);
        $this->db->where('supportticket.penanggung_jawab_perbaikan', $penanggungJawab);
        $this->db->order_by('supportticket.tanggal_dibuat', 'DESC');

        return $this->db->get()->result();
    }

    

    public function getSupportTicketsWithDetailsForTeknisi($request_id, $kategori_id) {
        $this->db->select('supportticket.request_id, supportticket.user_id, supportticket.role_id, supportticket.perangkat_id, supportticket.kategori_id, supportticket.department_id, supportticket.status, supportticket.deskripsi_permasalahan, supportticket.prioritas, supportticket.foto, supportticket.tanggal_dibuat, supportticket.tanggal_ditangani, supportticket.catatan, supportticket.penanggung_jawab_perbaikan, perangkat.nama_perangkat,perangkat.nomer_seri,  departments.nama_departemen, users.nama, perangkat.ipaddress, perangkat.tanggal_masuk');
        $this->db->from('supportticket');
        $this->db->join('perangkat', 'supportticket.perangkat_id = perangkat.id');
        $this->db->join('departments', 'supportticket.department_id = departments.departemen_id');
        $this->db->join('users', 'supportticket.user_id = users.user_id');
        $this->db->where('supportticket.request_id', $request_id);
        $this->db->where('supportticket.kategori_id', $kategori_id);
        $query = $this->db->get();
        
        return $query->row(); // Menggunakan row() untuk mengambil satu baris data.
        
    }

    public function getSupportTicketsWithDetailsForKaryawan($request_id) {
        $this->db->select('supportticket.*, users.nama AS nama_user, penanggung.nama as nama_penanggung_jawab, roles.nama_role, perangkat.nama_perangkat, problemcategories.nama_kategori, departments.nama_departemen, perangkat.nomer_seri, perangkat.ipaddress');
        $this->db->from('supportticket');
        $this->db->join('users', 'users.user_id = supportticket.user_id');
        $this->db->join('users as penanggung', 'penanggung.user_id = supportticket.penanggung_jawab_perbaikan', 'left');
        $this->db->join('roles', 'roles.role_id = users.role_id', 'left');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id', 'left');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = supportticket.kategori_id', 'left');
        $this->db->join('departments', 'departments.departemen_id = supportticket.department_id', 'left');
        $this->db->where('supportticket.request_id', $request_id);
        $query = $this->db->get();
        
        return $query->row(); // Menggunakan row() untuk mengambil satu baris data.




    }    

    public function updateStatusToProses($request_id, $penanggungJawabPerbaikan){
        $data_st = array(
            'status' => 'PROSES', // Gantilah 'PROSES' sesuai dengan status yang sesuai
            'penanggung_jawab_perbaikan' => $penanggungJawabPerbaikan
        );
    
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data_st);
    
        // Dapatkan perangkat_id terlebih dahulu dari tabel supportticket
        $this->db->select('perangkat_id');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get('supportticket');
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perangkat_id = $row->perangkat_id;
    
            // Sekarang, update status_perangkat pada tabel perangkat
            $data_perangkat = array(
                'status_perangkat' => 'PROSES' // Gantilah 'PROSES' sesuai dengan status yang sesuai
            );
    
            $this->db->where('id', $perangkat_id);
            $this->db->update('perangkat', $data_perangkat);
        }
    }

    public function updateStatusToRusak($request_id, $catatan, $penanggung_jawab){
        // Data untuk memperbarui status di tabel supportticket
        $data_st = array(
            'status' => 'RUSAK', // Gantilah 'PROSES' sesuai dengan status yang sesuai
            'catatan' => $catatan,
            'tanggal_ditangani' => date('Y-m-d H:i:s', strtotime('now')),
            'penanggung_jawab_perbaikan ' => $penanggung_jawab
        );
    
        // Memperbarui status di tabel supportticket
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data_st);
    
        // Mengambil perangkat_id dari tabel supportticket
        $this->db->select('perangkat_id');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get('supportticket');
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perangkat_id = $row->perangkat_id;
    
            // Data untuk memperbarui status_perangkat di tabel perangkat
            $data_perangkat = array(
                'status_perangkat' => 'RUSAK'
            );
    
            // Memperbarui status_perangkat di tabel perangkat
            $this->db->where('id', $perangkat_id);
            $this->db->update('perangkat', $data_perangkat);
        }
    }

    public function updateStatusToSelesai($request_id, $catatan, $penanggung_jawab){
        // Data untuk memperbarui status di tabel supportticket
        $data_st = array(
            'status' => 'SELESAI', // Gantilah 'PROSES' sesuai dengan status yang sesuai
            'catatan' => $catatan,
            'tanggal_ditangani' => date('Y-m-d H:i:s', strtotime('now')),
            'penanggung_jawab_perbaikan ' => $penanggung_jawab
        );
    
        // Memperbarui status di tabel supportticket
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data_st);
    
        // Mengambil perangkat_id dari tabel supportticket
        $this->db->select('perangkat_id');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get('supportticket');
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perangkat_id = $row->perangkat_id;
    
            // Data untuk memperbarui status_perangkat di tabel perangkat
            $data_perangkat = array(
                'status_perangkat' => 'SELESAI'
            );
    
            // Memperbarui status_perangkat di tabel perangkat
            $this->db->where('id', $perangkat_id);
            $this->db->update('perangkat', $data_perangkat);
        }
    }  

    
    public function updateStatusToBerjalan($request_id){
        $data_st = array(
            'status' => 'DIPAKAI' // Gantilah 'PROSES' sesuai dengan status yang sesuai
        );
    
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data_st);
    
        // Dapatkan perangkat_id terlebih dahulu dari tabel supportticket
        $this->db->select('perangkat_id');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get('supportticket');
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perangkat_id = $row->perangkat_id;
    
            // Sekarang, update status_perangkat pada tabel perangkat
            $data_perangkat = array(
                'status_perangkat' => 'DIPAKAI' // Gantilah 'PROSES' sesuai dengan status yang sesuai
            );
    
            $this->db->where('id', $perangkat_id);
            $this->db->update('perangkat', $data_perangkat);
        }
    }
    
    public function getRiwayatRequestByPerangkatId($perangkat_id) {
        $this->db->select('supportticket.*, users.nama as nama_penanggung_jawab');
        $this->db->from('supportticket');
        $this->db->join('users', 'supportticket.penanggung_jawab_perbaikan = users.user_id', 'left');
        $this->db->where('supportticket.perangkat_id', $perangkat_id);
        $this->db->order_by('supportticket.tanggal_dibuat', 'DESC');
    
        return $this->db->get()->result();
    }
    
    
    
    

    public function getLastReqID()
    {
        $this->db->select_max('request_id');
        $this->db->like('request_id', 'REQ', 'after'); // Hanya ambil ID yang dimulai dengan "REQ"
        $this->db->where('LENGTH(request_id)', 7); // Filter hanya ID produk dengan panjang 5 karakter
        $query = $this->db->get('supportticket');
        $result = $query->row_array();

        // Jika tidak ada data dengan ID "JM", kembalikan nilai awal yaitu "JM000"
        if ($result['request_id'] === null) {
            return 'REQ0000';
        }

        return $result['request_id'];
    }
    public function getKategori()
    {
        $this->db->select('kategori_id, nama_kategori');
        $query = $this->db->get('problemcategories');
        return $query->result();
    }

    public function getKategoriByPerangkatID($perangkat_id)
    {
        $this->db->select('kategori_id');
        $this->db->where('id', $perangkat_id); // Filter hanya ID produk dengan panjang 5 karakter
        $query = $this->db->get('perangkat');
        return $query->row();
    }

    public function simpan_request($data_request)
    {
        $this->db->insert('supportticket', $data_request);
    }

    public function tambah_notifikasi($data)
    {
        $this->db->insert('notification', $data);
    }

    public function updateStatusPerangkat($perangkat_id, $status)
    {
        $data = array(
            'status_perangkat' => $status
        );

        $this->db->where('id', $perangkat_id);
        $this->db->update('perangkat', $data);
    }

    public function getRequestById($request_id)
    {
        $this->db->select('supportticket.*, perangkat.nama_perangkat, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('supportticket');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id');
        $this->db->join('problemcategories', 'problemcategories.kategori_id = supportticket.kategori_id');
        $this->db->join('departments', 'departments.departemen_id = supportticket.department_id');
        $this->db->where('request_id', $request_id);
        return $this->db->get()->row();
    }

    public function updateRequest($request_id, $data)
    {
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data);
    }

    public function updateStatusRequest($request_id, $newStatus)
    {
        $data = array('status' => $newStatus);
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data);
    }


    public function searchRequest($keyword, $user_id, $role_id)
    {
        $this->db->select('supportticket.*, users.nama, perangkat.nama_perangkat, problemcategories.nama_kategori, departments.nama_departemen');
        $this->db->from('supportticket');
        $this->db->join('users', 'supportticket.user_id = users.user_id', 'left');
        $this->db->join('perangkat', 'supportticket.perangkat_id = perangkat.id', 'left');
        $this->db->join('problemcategories', 'perangkat.kategori_id = problemcategories.kategori_id', 'left');
        $this->db->join('departments', 'supportticket.department_id = departments.departemen_id', 'left');
    
        $this->db->or_like('problemcategories.nama_kategori', $keyword); // Tambahkan alias 'problemcategories' sebelum kolom
        $this->db->or_like('perangkat.nama_perangkat', $keyword); // Tambahkan alias 'problemcategories' sebelum kolom
        $this->db->or_like('departments.nama_departemen', $keyword); // Tambahkan alias 'departments' sebelum kolom
        $this->db->or_like('supportticket.request_id', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
        $this->db->or_like('supportticket.status', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
        $this->db->or_like('supportticket.deskripsi_permasalahan', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
        $this->db->or_like('supportticket.prioritas', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
        $this->db->or_like('supportticket.tanggal_dibuat', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
        $this->db->or_like('supportticket.tanggal_ditangani', $keyword); // Tambahkan alias 'supportticket' sebelum kolom
    
        if ($role_id == '2') {
            // Jika peran pengguna adalah karyawan
            $this->db->where('supportticket.user_id', $user_id);
        } elseif ($role_id == '3') {
            // Jika peran pengguna adalah teknisi
            $this->db->where('supportticket.penanggung_jawab_perbaikan', $user_id);
        }
    
        return $this->db->get()->result();
    }
    

    public function updateStatusAndDateRequest($request_id, $newStatus, $currentDate)
    {
        $data = array(
            'status' => $newStatus,
            'tanggal_ditangani' => $currentDate
        );

        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data);
    }

    // Fungsi untuk melatih model
    public function trainModel($trainingData, $labels)
    {
        // Di dalam Controller Anda
        $this->load->library('svm_lib');

        $model = $this->svm_lib->train($trainingData, $labels);
        // Simpan model ke file jika diperlukan
        $this->svm_lib->saveModel('svm_model.model', $model);
    }

    // Fungsi untuk memprediksi prioritas
    public function predictPriority($features)
    {
        $this->load->library('svm_lib');


        // Load model yang telah dilatih sebelumnya
        $model = $this->svm_lib->loadModel('svm_model.model');
        // Lakukan prediksi
        $predictedPriority = $this->svm_lib->predict($model, $features);
        return $predictedPriority;
    }

    public function getPerangkatById($perangkat_id){
        $this->db->select('nama_perangkat');
        $this->db->where('id', $perangkat_id);
        return $this->db->get('perangkat')->row();
    }
    public function getKategoriById($kategori_id){
        $this->db->select('nama_kategori');
        $this->db->where('kategori_id', $kategori_id);
        return $this->db->get('problemcategories')->row();
    }

    public function getPerangkatIdForRiwayat($request_id){
        $this->db->select('supportticket.*');
        $this->db->from('supportticket');
        $this->db->join('perangkat', 'perangkat.id = supportticket.perangkat_id', 'left');
    
        $this->db->where('supportticket.request_id', $request_id); // Filter berdasarkan username
    
        return $this->db->get()->row();
    }

    public function updateToBatal($request_id){
        $data_st = array(
            'status' => 'DIBATALKAN', // Gantilah 'PROSES' sesuai dengan status yang sesuai
        );
    
        $this->db->where('request_id', $request_id);
        $this->db->update('supportticket', $data_st);
    
        // Dapatkan perangkat_id terlebih dahulu dari tabel supportticket
        $this->db->select('perangkat_id');
        $this->db->where('request_id', $request_id);
        $query = $this->db->get('supportticket');
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $perangkat_id = $row->perangkat_id;
    
            // Sekarang, update status_perangkat pada tabel perangkat
            $data_perangkat = array(
                'status_perangkat' => 'DIPAKAI' // Gantilah 'PROSES' sesuai dengan status yang sesuai
            );
    
            $this->db->where('id', $perangkat_id);
            $this->db->update('perangkat', $data_perangkat);
        }
    }



}