<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function jmlGuru()
    {
        return $this->db->table('tb_guru')
            ->countAllResults();
    }

    public function jmlSiswa()
    {
        return $this->db->table('tb_siswa')
            ->countAllResults();
    }

    public function jmlUser()
    {
        return $this->db->table('tb_user')
            ->countAllResults();
    }

    public function jmlKursus()
    {
        return $this->db->table('tb_kursus')
            ->countAllResults();
    }

    public function tampilKuisByIdSubKursus($id_sub_kursus, $id_kursus)
    {
        return $this->db->table('tb_kuis')
            ->where('id_sub_kursus', $id_sub_kursus)
            ->where('id_kursus', $id_kursus)
            ->get()
            ->getResultArray();
    }
}
