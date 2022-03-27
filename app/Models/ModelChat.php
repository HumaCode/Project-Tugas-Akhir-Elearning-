<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelChat extends Model
{
    protected $table = 'tb_chating';
    protected $primaryKey = 'id_chating';

    protected $allowedFields = ['id_pengirim', 'id_penerima', 'pesan', 'is_read', 'created'];


    public function tampilByPengirim($id_user)
    {
        return $this->db->table('tb_chating')
            ->join('tb_guru', 'tb_guru.id_guru=tb_chating.id_penerima', 'left')
            ->join('tb_user', 'tb_user.id_user=tb_chating.id_pengirim', 'left')
            ->where('id_pengirim', $id_user)
            ->orderBy('id_chating', 'desc')
            ->get()
            ->getResultArray();
    }

    public function tampilByChating($id_chating, $id_penerima)
    {
        return $this->db->table('tb_chating')
            ->join('tb_guru', 'tb_guru.id_guru=tb_chating.id_penerima', 'left')
            ->join('tb_user', 'tb_user.id_user=tb_chating.id_pengirim', 'left')
            ->where('id_chating', $id_chating)
            ->where('id_penerima', $id_penerima)
            ->get()
            ->getRowArray();
    }

    public function tampilByIdPenerima($id_penerima)
    {
        return $this->db->table('tb_chating')
            ->join('tb_user', 'tb_user.id_user=tb_chating.id_pengirim', 'left')
            ->where('id_penerima', $id_penerima)
            ->get()
            ->getRowArray();
    }
}
