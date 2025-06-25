<?php
class transaksi extends CI_Model {
    public function get_all_transaksi() {
        return $this->db->get('pengguna')->result();
    }
    
    public function delete($kode_transaksi) {
        return $this->db->delete('transaksi', ['kode_transaksi' => $kode_transaksi]);
    }
    public function insert($data) {
        return $this->db->insert('kode_transaksi', $data);
    }


}
