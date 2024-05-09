<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotifikasiModel extends CI_Model
{
    public function tambah_notifikasi($data)
    {
        $this->db->insert('notification', $data);
    }

    public function getAllNotification()
    {
        $this->db->distinct();

        $this->db->select('notification.user_id, 
        notification.teknisi_id, 
        notification.role_id,
        notification.request_id, 
        notification.sesi_pesan, 
        notification.kategori_id, 
        notification.department_id, 
        notification.message_for_teknisi, 
        notification.message_for_karyawan, 
        notification.created_at, 
        notification.link,
        messages.status'); // Tambahkan kolom 'status' dari tabel 'messages'
        $this->db->join('messages', 'notification.sesi_pesan = messages.sesi_pesan', 'left'); // JOIN berdasarkan 'sesi_pesan'
        $this->db->order_by('created_at', 'desc'); // Urutkan berdasarkan timestamp desc (terbaru dulu)
        return $this->db->get('notification')->result();
    }

    public function countAllNotif(){
        $this->db->distinct();

        $this->db->select('notification.user_id, 
        notification.teknisi_id, 
        notification.role_id,
        notification.request_id, 
        notification.sesi_pesan, 
        notification.kategori_id, 
        notification.department_id, 
        notification.message_for_teknisi, 
        notification.message_for_karyawan, 
        notification.created_at, 
        notification.link,
        messages.status'); // Tambahkan kolom 'status' dari tabel 'messages'
        $this->db->join('messages', 'notification.sesi_pesan = messages.sesi_pesan', 'left'); // JOIN berdasarkan 'sesi_pesan'
        $this->db->order_by('created_at', 'desc'); // Urutkan berdasarkan timestamp desc (terbaru dulu)
        return $this->db->count_all_results('notification');

    }

    public function get_notifikasi_by_id($user_id)
    {
        $this->db->distinct();

        $this->db->select('notification.user_id, 
        notification.teknisi_id, 
        notification.role_id,
        notification.request_id, 
        notification.sesi_pesan, 
        notification.kategori_id, 
        notification.department_id, 
        notification.message_for_teknisi, 
        notification.message_for_karyawan, 
        notification.created_at, 
        notification.link,
        messages.status'); // Tambahkan kolom 'status' dari tabel 'messages'
        $this->db->where('user_id', $user_id);
        $this->db->join('messages', 'notification.sesi_pesan = messages.sesi_pesan', 'left'); // JOIN berdasarkan 'sesi_pesan'
        $this->db->order_by('created_at', 'desc'); // Urutkan berdasarkan timestamp desc (terbaru dulu)
        return $this->db->get('notification')->result();
    }

    public function count_notif_by_id($user_id)
    {
        $this->db->distinct();
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('notification');
    }

    public function get_notifikasi_unread($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 'UNREAD');
        $this->db->order_by('created_at', 'desc');
        return $this->db->get('notification')->result();
    }

    //teknisi
    public function get_notifikasi_by_kategori($kategori_id, $teknisi_id) {
        $this->db->distinct();
        $this->db->select('notification.id, 
                           notification.user_id, 
                           notification.teknisi_id, 
                           notification.role_id, 
                           notification.request_id, 
                           notification.sesi_pesan, 
                           notification.kategori_id, 
                           notification.department_id, 
                           notification.message_for_teknisi, 
                           notification.created_at, 
                           notification.link, 
                           supportticket.status, 
                           messages.status');
        $this->db->from('notification');
        $this->db->join('messages', 'notification.sesi_pesan = messages.sesi_pesan', 'left');
        $this->db->join('supportticket', 'notification.request_id = supportticket.request_id', 'left');
    
        $this->db->where("(
            (supportticket.status = 'PENGAJUAN' AND notification.teknisi_id IS NULL AND notification.kategori_id = '$kategori_id') 
            OR
            (supportticket.status = 'PROSES' AND notification.teknisi_id = '$teknisi_id') 
            OR 
            (messages.status = 'open' AND (messages.receiver_id IS NULL OR messages.receiver_id = '') AND notification.kategori_id = '$kategori_id')
            OR 
            (messages.status = 'taken' AND messages.receiver_id = '$teknisi_id') AND notification.message_for_teknisi IS NOT NULL
            OR
            (messages.status = 'closed' AND messages.receiver_id = '$teknisi_id') AND notification.message_for_teknisi IS NOT NULL

        )");
    
        $this->db->order_by('notification.created_at', 'desc');
        return $this->db->get()->result();
    }
    
    

    public function count_notif_by_kategori($kategori_id, $teknisi_id)
    {
        $this->db->distinct();
        $this->db->select('notification.id, 
                           notification.user_id, 
                           notification.teknisi_id, 
                           notification.role_id, 
                           notification.request_id, 
                           notification.sesi_pesan, 
                           notification.kategori_id, 
                           notification.department_id, 
                           notification.message_for_teknisi, 
                           notification.created_at, 
                           notification.link, 
                           supportticket.status AS support_status, 
                           messages.status AS message_status');
        $this->db->from('notification');
        $this->db->join('messages', 'notification.sesi_pesan = messages.sesi_pesan', 'left');
        $this->db->join('supportticket', 'notification.request_id = supportticket.request_id', 'left');
    
        $this->db->where("(
            (supportticket.status = 'PENGAJUAN' AND notification.teknisi_id IS NULL AND notification.kategori_id = '$kategori_id') 
            OR
            (supportticket.status = 'PROSES' AND notification.teknisi_id = '$teknisi_id') 
            OR 
            (messages.status = 'open' AND (messages.receiver_id IS NULL OR messages.receiver_id = '') AND notification.kategori_id = '$kategori_id')
            OR 
            (messages.status = 'taken' AND messages.receiver_id = '$teknisi_id') AND notification.message_for_teknisi IS NOT NULL
            OR
            (messages.status = 'closed' AND messages.receiver_id = '$teknisi_id') AND notification.message_for_teknisi IS NOT NULL
    
        )");
    
        $this->db->order_by('notification.created_at', 'desc');
        return $this->db->count_all_results();
    }
    
    

    public function get_notifikasi_unread_kategori($kategori_id)
    {
        $this->db->where('kategori_id', $kategori_id);
        $this->db->where('is_read', 'UNREAD');
        $this->db->order_by('created_at', 'desc');
        return $this->db->get('notification')->result();
    }
}