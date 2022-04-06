<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMateri extends Model
{
    protected $table = 'tb_materi';
    protected $primaryKey = 'id_materi';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_kursus', 'id_sub_kursus', 'judul', 'nama_file', 'url', 'ket', 'dibuat'];

    public function tampilData($id_sub_kursus)
    {
        return $this->db->table('tb_materi')
            ->join('tb_kursus', 'tb_kursus.id_kursus=tb_materi.id_kursus', 'left')
            ->join('tb_sub_kursus', 'tb_sub_kursus.id_sub_kursus=tb_materi.id_sub_kursus', 'left')
            ->where('tb_materi.id_sub_kursus', $id_sub_kursus)
            ->get()
            ->getResultArray();
    }

    public function tampilById($id_materi)
    {
        return $this->db->table('tb_materi')
            ->join('tb_kursus', 'tb_kursus.id_kursus=tb_materi.id_kursus', 'left')
            ->join('tb_sub_kursus', 'tb_sub_kursus.id_sub_kursus=tb_materi.id_sub_kursus', 'left')
            ->where('tb_materi.id_materi', $id_materi)
            ->get()
            ->getRowArray();
    }

    public function ubahMateri($id_materi, $updatedata)
    {
        $this->db->table($this->table)->where('id_materi', $id_materi)->update($updatedata);
    }

    public function tampilDataById($id_kursus)
    {
        return $this->db->table('tb_kursus')
            ->join('tb_mapel', 'tb_mapel.id_mapel=tb_kursus.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_kursus.id_kelas', 'left')
            ->join('tb_guru', 'tb_guru.id_guru=tb_kursus.id_guru', 'left')
            ->where('tb_kursus.id_kursus', $id_kursus)
            ->get()
            ->getRowArray();
    }
}
