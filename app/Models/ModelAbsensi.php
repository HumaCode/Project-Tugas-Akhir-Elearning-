<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAbsensi extends Model
{
    protected $table = 'tb_absen';
    protected $primaryKey = 'id_absen';
    protected $useTimestamps = false;

    protected $allowedFields = ['id_sub_kursus', 'id_kursus', 'id_siswa', 'id_kelas', 'foto', 'absen', 'waktu'];


    public function tampilData($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->join('tb_siswa', 'tb_siswa.id_siswa=tb_absen.id_siswa', 'left')
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->get()
            ->getResultArray();
    }

    public function tampilByIdKelas($id_kursus, $id_sub_kursus, $id_siswa)
    {
        return $this->db->table($this->table)
            ->join('tb_siswa', 'tb_siswa.id_siswa=tb_absen.id_siswa', 'left')
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_siswa', $id_siswa)
            ->get()
            ->getRowArray();
    }

    // jumlah siswa 
    public function jumlahSiswa($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->countAllResults();
    }

    // siswa belum absen
    public function jumlahBelumAbsen($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->where('tb_absen.absen', 0)
            ->countAllResults();
    }

    // siswa masuk
    public function jumlahMasuk($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->where('tb_absen.absen', 1)
            ->countAllResults();
    }

    // siswa ijin
    public function jumlahIjin($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->where('tb_absen.absen', 2)
            ->countAllResults();
    }

    // siswa sakit
    public function jumlahSakit($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->where('tb_absen.absen', 3)
            ->countAllResults();
    }

    // siswa alpa
    public function jumlahAlpa($id_kursus, $id_sub_kursus, $id_kelas)
    {
        return $this->db->table($this->table)
            ->where('tb_absen.id_kursus', $id_kursus)
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->where('tb_absen.id_kelas', $id_kelas)
            ->where('tb_absen.absen', 4)
            ->countAllResults();
    }

    public function tampilDataByIdSubKursus($id_sub_kursus)
    {
        return $this->db->table($this->table)
            ->join('tb_siswa', 'tb_siswa.id_siswa=tb_absen.id_siswa', 'left')
            ->where('tb_absen.id_sub_kursus', $id_sub_kursus)
            ->get()
            ->getResultArray();
    }


    public function tambahAnggota($id_kursus, $id_sub_kursus, $id_kelas, $anggota)
    {

        $result = array();
        foreach ($anggota as $key => $val) {


            $result[] = array(
                'id_sub_kursus'     => $id_sub_kursus,
                'id_kursus'         => $id_kursus,
                'id_siswa'          => $_POST['anggota'][$key],
                'id_kelas'          => $id_kelas,
            );
        }

        $builder  = $this->db->table($this->table);
        //MULTIPLE INSERT TABLE
        $builder->insertBatch($result);
    }

    public function updateAnggota($id_sub_kursus, $anggota, $id_kursus)
    {
        //DELETE DETAIL PACKAGE
        $this->db->table('tb_anggota')->delete(['id_sub_kursus' => $id_sub_kursus]);

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
