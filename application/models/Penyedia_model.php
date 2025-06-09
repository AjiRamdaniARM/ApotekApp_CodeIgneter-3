<?php
class Penyedia_model extends CI_Model {
    public function get_all_penyedia() {
        return $this->db->get('pengguna')->result();
    }
    public function delete($id) {
        return $this->db->delete('penyedia', ['id_penyedia' => $id]);
    }
    public function insert($data) {
        return $this->db->insert('penyedia', $data);
    }


}
