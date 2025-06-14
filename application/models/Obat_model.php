<?php
class Obat_model extends CI_Model {
    public function get_all_obat() {
        return $this->db->get('pengguna')->result();
    }
    
    public function delete($id) {
        return $this->db->delete('obat', ['id_produk_obat' => $id]);
    }
    public function insert($data) {
        return $this->db->insert('obat', $data);
    }


}
