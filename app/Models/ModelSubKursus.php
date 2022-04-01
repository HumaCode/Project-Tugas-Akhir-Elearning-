<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSubKursus extends Model
{
    protected $table = 'tb_sub_kursus';
    protected $primaryKey = 'id_sub_kursus';
    // protected $useTimestamps = true;

    protected $allowedFields = ['id_kursus', 'sub_kursus', 'id_ta', 'tipe', 'mulai'];

    public function tampilSemua($id_kursus, $id_ta)
    {
        return $this->db->table('tb_sub_kursus')
            ->where('id_kursus', $id_kursus)
            ->where('id_ta', $id_ta)
            ->get()
            ->getResultArray();
    }

    public function tampilDataById($id_sub_kursus)
    {
        return $this->db->table('tb_sub_kursus')
            ->where('id_sub_kursus', $id_sub_kursus)
            ->get()
            ->getRowArray();
    }
}
