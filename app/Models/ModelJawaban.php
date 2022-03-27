<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJawaban extends Model
{
    protected $table = 'tb_jawaban';
    protected $primaryKey = 'id_jawaban';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_kuis', 'id_kursus', 'id_sub_kursus', 'id_siswa', 'jawaban', 'jwb_file', 'nilai', 'dikirim'];


    public function tampilById($id_kuis, $id_siswa)
    {
        return $this->db->table($this->table)
            ->where('id_kuis', $id_kuis)
            ->where('id_siswa', $id_siswa)
            ->countAllResults();
    }

    public function tampilJawabanById($id_kuis, $id_kursus, $id_sub_kursus)
    {
        return $this->db->table($this->table)
            ->join('tb_kursus', 'tb_jawaban.id_kursus=tb_kursus.id_kursus', 'left')
            ->join('tb_siswa', 'tb_jawaban.id_siswa=tb_siswa.id_siswa', 'left')
            ->join('tb_kuis', 'tb_jawaban.id_kuis=tb_kuis.id_kuis', 'left')
            ->where('tb_jawaban.id_kuis', $id_kuis)
            ->where('tb_jawaban.id_kursus', $id_kursus)
            ->where('tb_jawaban.id_sub_kursus', $id_sub_kursus)
            ->get()
            ->getResultArray();
    }

    public function tampilNilaiById($id_kuis, $id_kursus, $id_sub_kursus)
    {
        return $this->db->table($this->table)
            ->join('tb_kursus', 'tb_jawaban.id_kursus=tb_kursus.id_kursus', 'left')
            ->join('tb_siswa', 'tb_jawaban.id_siswa=tb_siswa.id_siswa', 'left')
            ->join('tb_kuis', 'tb_jawaban.id_kuis=tb_kuis.id_kuis', 'left')
            ->where('tb_jawaban.id_kuis', $id_kuis)
            ->where('tb_jawaban.id_kursus', $id_kursus)
            ->where('tb_jawaban.id_sub_kursus', $id_sub_kursus)
            ->get()
            ->getRowArray();
    }

    public function tampilJawabanByIdJawaban($id_jawaban)
    {
        return $this->db->table($this->table)
            ->join('tb_kursus', 'tb_jawaban.id_kursus=tb_kursus.id_kursus', 'left')
            ->join('tb_siswa', 'tb_jawaban.id_siswa=tb_siswa.id_siswa', 'left')
            ->join('tb_kuis', 'tb_jawaban.id_kuis=tb_kuis.id_kuis', 'left')
            ->join('tb_sub_kursus', 'tb_jawaban.id_sub_kursus=tb_sub_kursus.id_sub_kursus', 'left')
            ->where('tb_jawaban.id_jawaban', $id_jawaban)
            ->get()
            ->getRowArray();
    }
}
