<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyModel extends Model
{
    protected $table            = 'buy';
    protected $useTimestamps = true;
    protected $allowedFields    = ['buyid', 'userid', 'supplier', 'discount'];

    public function getAll($id = null)
    {
        if ($id === null) {
            return $this->db->table('buy_detail as BD')
                ->select('O.nama AS obat, BD.amount AS jumlah, B.supplier, date(B.created_at) tgl')
                ->join('buy B', 'B.buyid = BD.buyid')
                ->join('obat O', 'O.id_obat=BD.id_obat', 'LEFT')
                ->get()->getResultArray();
        } else {
            return $this->db->table('buy_detail as BD')
                ->select('O.nama AS obat, BD.amount AS jumlah, B.supplier, date(B.created_at) tgl')
                ->join('buy B', 'B.buyid = BD.buyid')
                ->join('obat O', 'O.id_obat = BD.id_obat', 'LEFT')
                ->where('BD.buyid', $id)
                ->get()->getResultArray();
        }
    }

    public function getLaporan($id = null)
    {
        if ($id === null) {
            return $this->db->table('buy_detail AS BD')
                ->select('B.buyid, B.userid, B.supplier, date(B.created_at) tgl_transaksi, B.discount, U.username, U.fullname AS namaadm, SUM(BD.total_price) total')
                ->join('buy B', 'BD.buyid = B.buyid')
                ->join('users U', 'U.id = B.userid')
                ->groupBy('B.buyid')
                ->orderBy('tgl_transaksi', 'DESC')
                ->get()->getResultArray();
        } else {
            return $this->db->table('buy_detail AS BD')
                ->select('B.buyid, B.userid, B.supplier, date(B.created_at) tgl_transaksi, B.discount, U.username, U.fullname AS namaadm, SUM(BD.total_price) total')
                ->join('buy B', 'BD.buyid = B.buyid')
                ->join('users U', 'U.id = B.userid', 'LEFT')
                ->where('B.buyid', $id)
                ->groupBy('B.buyid')
                ->orderBy('tgl_transaksi', 'DESC')
                ->get()->getResultArray();
        }
    }


    public function getRows()
    {
        $this->db->table('buy AS B')
            ->select('*')
            ->where('MONTH(B.created_at) = MONTH(CURDATE())')
            ->get();
        return $this->countAllResults();
    }

    public function buyGrafik()
    {
        $this->select('DATE_FORMAT(buy.created_at,  "%b") AS tgl, SUM(bd.total_price) AS total')
            ->join('buy_detail bd', 'bd.buyid = buy.buyid', 'RIGHT')
            ->where('YEAR(buy.created_at) = YEAR(CURDATE())')
            ->groupBy('tgl')
            ->orderBy('tgl', 'DESC');
        return $this->get()->getResultArray();
    }
}
