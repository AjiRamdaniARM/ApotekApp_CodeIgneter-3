<?php
class barang_masuk extends CI_Model {
    public function get_all_obat() {
        return $this->db->get('pengguna')->result();
    }
    
   public function delete_by_kode_obat($kode_obat) {
     return $this->db->delete('barang_masuk', ['kode_obat' => $kode_obat]);
}

    public function insert($data) {
        return $this->db->insert('barang_masuk', $data);
    }


}
