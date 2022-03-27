<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAnggota extends Model
{
    protected $table = 'tb_anggota';
    protected $primaryKey = 'id_anggota';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_kursus', 'id_siswa'];


    public function tampilDataById($id_kursus)
    {
        return $this->db->table($this->table)
            ->join('tb_kursus', 'tb_kursus.id_kursus=tb_anggota.id_kursus', 'left')
            ->join('tb_siswa', 'tb_siswa.id_siswa=tb_anggota.id_siswa', 'left')
            ->where('tb_anggota.id_kursus', $id_kursus)
            ->get()
            ->getResultArray();
    }

    public function tampilByIdSiswa($id_kursus, $id_siswa)
    {
        return $this->db->table($this->table)
            ->where('id_siswa', $id_siswa)
            ->where('id_kursus', $id_kursus)
            ->get()
            ->getRowArray();
    }

    public function tampilDataByIdKursus($id_kursus)
    {
        return $this->db->table($this->table)
            ->join('tb_kursus', 'tb_kursus.id_kursus=tb_anggota.id_kursus', 'left')
            ->join('tb_siswa', 'tb_siswa.id_siswa=tb_anggota.id_siswa', 'left')
            ->where('tb_anggota.id_kursus', $id_kursus)
            ->get()
            ->getResult();
    }

    public function tambahAnggota($id_kursus, $anggota)
    {

        $result = array();
        foreach ($anggota as $key => $val) {


            $result[] = array(
                'id_kursus'         => $id_kursus,
                'id_siswa'          => $_POST['anggota'][$key]
            );
        }

        $builder  = $this->db->table('tb_anggota');
        //MULTIPLE INSERT TABLE
        $builder->insertBatch($result);
    }

    public function updateAnggota($id_kursus, $anggota)
    {
        //DELETE DETAIL PACKAGE
        $this->db->table('tb_anggota')->delete(['id_kursus' => $id_kursus]);

        $result = array();
        foreach ($anggota as $key => $val) {
            $result[] = array(
                'id_kursus'             => $id_kursus,
                'id_siswa'              => $_POST['anggota_edit'][$key]
            );
        }

        $builder  = $this->db->table('tb_anggota');
        //MULTIPLE INSERT TABLE
        $builder->insertBatch($result);
    }
}
