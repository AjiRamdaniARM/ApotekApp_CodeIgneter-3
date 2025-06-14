<?php
class Kategori_Obat extends CI_Model {
    public function get_all_kategori() {
        return $this->db->get('kategori_obat')->result();
    }
    public function delete($id) {
        return $this->db->delete('kategori_obat', ['id_kategori_obat' => $id]);
    }
    public function insert($data) {
        return $this->db->insert('kategori_obat', $data);
    }
}
