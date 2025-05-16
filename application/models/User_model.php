<?php
class User_model extends CI_Model {
    public function get_user($email, $password) {
        return $this->db->get_where('pengguna', [
            'email' => $email,
            'kata_sandi' => $password
        ])->row();
    }

    public function get_all_user() {
        return $this->db->get('pengguna')->result();
    }

    public function get_user_by_email($email) {
    return $this->db->get_where('pengguna', ['email' => $email])->row();
}

}
