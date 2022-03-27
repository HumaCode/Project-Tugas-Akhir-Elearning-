<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSiswa extends Model
{
    protected $table = 'tb_siswa';
    protected $primaryKey = 'id_siswa';

    protected $allowedFields = ['nama_siswa', 'nis', 'email', 'password', 'role', 'foto', 'is_active', 'id_kelas'];

    public function joinTabel($id_siswa)
    {
        return $this->db->table('tb_siswa')
            ->join('tb_kelas', 'tb_kelas.id_kelas=tb_siswa.kelas_id', 'left')
            ->where('id_siswa', $id_siswa)
            ->get()
            ->getRowArray();
    }

    public function tampilSiswaByUsername($username)
    {
        return $this->db->table('tb_siswa')
            ->where('nis', $username)
            ->get()
            ->getRowArray();
    }

    public function tambah($simpanSiswa)
    {
        $this->db->table('tb_siswa')->insert($simpanSiswa);
    }

    public function edit($nis, $updateSiswa)
    {
        $this->db->table('tb_siswa')
            ->where('nis', $nis)
            ->update($updateSiswa);
    }

    public function editSiswa($id_siswa, $updateSiswa)
    {
        $this->db->table('tb_siswa')
            ->where('id_siswa', $id_siswa)
            ->update($updateSiswa);
    }

    public function hapusSiswa($id_siswa)
    {
        $this->db->table('tb_siswa')
            ->where('id_siswa', $id_siswa)
            ->delete();
    }

    public function tampilSiswaByKelas($id_kelas)
    {
        return $this->db->table($this->table)
            ->where('kelas_id', $id_kelas)
            ->orderBy('id_siswa', 'desc')
            ->get()
            ->getResultArray();
    }
}
