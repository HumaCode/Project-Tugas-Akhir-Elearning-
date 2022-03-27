<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKursus extends Model
{
    protected $table = 'tb_kursus';
    protected $primaryKey = 'id_kursus';
    // protected $useTimestamps = true;

    protected $allowedFields = ['id_mapel', 'id_kelas', 'id_guru', 'gambar'];

    public function tampilData()
    {
        return $this->db->table('tb_kursus')
            ->join('tb_mapel', 'tb_mapel.id_mapel=tb_kursus.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_kursus.id_kelas', 'left')
            ->join('tb_guru', 'tb_guru.id_guru=tb_kursus.id_guru', 'left')
            ->orderBy('tb_kursus.id_kursus', 'desc')
            ->get()
            ->getResultArray();
    }

    public function tampilByIdGuru($id_guru)
    {
        return $this->db->table('tb_kursus')
            ->join('tb_mapel', 'tb_mapel.id_mapel=tb_kursus.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_kursus.id_kelas', 'left')
            ->join('tb_guru', 'tb_guru.id_guru=tb_kursus.id_guru', 'left')
            ->where('tb_kursus.id_guru', $id_guru)
            ->orderBy('tb_kursus.id_kursus', 'desc')
            ->get()
            ->getResultArray();
    }

    public function jmlKursusGuru($id_guru)
    {
        return $this->db->table('tb_kursus')
            ->where('tb_kursus.id_guru', $id_guru)
            ->countAllResults();
    }

    public function tampilByKelas($id_kelas)
    {
        return $this->db->table('tb_kursus')
            ->join('tb_mapel', 'tb_mapel.id_mapel=tb_kursus.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_kursus.id_kelas', 'left')
            ->join('tb_guru', 'tb_guru.id_guru=tb_kursus.id_guru', 'left')
            ->where('tb_kursus.id_kelas', $id_kelas)
            ->orderBy('tb_kursus.id_kursus', 'desc')
            ->get()
            ->getResultArray();
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

    public function tambahKursus($simpanKursus)
    {
        $this->db->table('tb_kursus')->insert($simpanKursus);
    }

    public function updateKursus($id_kursus, $updateData)
    {
        $this->db->table('tb_kursus')
            ->where('id_kursus', $id_kursus)
            ->update($updateData);
    }

    public function search($keyword)
    {
        // $builder = $this->table('tb_kursus');
        // $builder->like('nama', $keyword);
        // return $builder;

        return $this->table('tb_kursus')
            ->join('tb_mapel', 'tb_mapel.id_mapel=tb_kursus.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_kursus.id_kelas', 'left')
            ->join('tb_guru', 'tb_guru.id_guru=tb_kursus.id_guru', 'left')
            ->orderBy('tb_kursus.id_kursus', 'desc')
            ->like('mapel', $keyword)
            ->orlike('nama_guru', $keyword)
            ->orlike('kelas', $keyword)
            ->get()
            ->getResultArray();
    }
}
