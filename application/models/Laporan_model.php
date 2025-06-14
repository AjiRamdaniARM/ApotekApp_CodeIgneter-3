<?php
class Laporan_model extends CI_Model
{
    public function getLaporanPendapatan($start, $end)
    {
        return $this->db
            ->where('DATE(tanggal_transaksi) >=', $start)
            ->where('DATE(tanggal_transaksi) <=', $end)
            ->order_by('tanggal_transaksi', 'DESC')
            ->get('transaksi')
            ->result_array();
    }

    public function getTotalPendapatan($start, $end)
    {
        $this->db->select_sum('total_harga');
        $this->db->where('DATE(tanggal_transaksi) >=', $start);
        $this->db->where('DATE(tanggal_transaksi) <=', $end);
        $result = $this->db->get('transaksi')->row_array();
        return $result['total_harga'] ?? 0;
    }
}

