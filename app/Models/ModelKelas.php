<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';

    protected $allowedFields = ['kelas'];

    public function tampilSemua()
    {
        return $this->db->table('tb_kelas')
            ->get()
            ->getResultArray();
    }

    public function tampilByKelas($kelas)
    {
        return $this->db->table('tb_kelas')
            ->where('kelas', $kelas)
            ->get()
            ->getRowArray();
    }
}
