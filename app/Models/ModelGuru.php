<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGuru extends Model
{
    protected $table = 'tb_guru';
    protected $primaryKey = 'id_guru';

    protected $allowedFields = ['nama_guru', 'nip', 'email', 'password', 'role', 'foto', 'is_active'];


    public function tampilByEmail($email)
    {
        return $this->db->table($this->table)
            ->where('email', $email)
            ->get()
            ->getRowArray();
    }

    public function tambah($simpanGuru)
    {
        $this->db->table('tb_guru')->insert($simpanGuru);
    }

    public function edit($nip, $updateGuru)
    {
        $this->db->table($this->table)
            ->where('nip', $nip)
            ->update($updateGuru);
    }

    public function tampilGuruByNip($nip)
    {
        return $this->db->table('tb_guru')
            ->where('nip', $nip)
            ->get()
            ->getRowArray();
    }

    public function editGuru($id_guru, $updateGuru)
    {
        $this->db->table('tb_guru')
            ->where('id_guru', $id_guru)
            ->update($updateGuru);
    }

    public function hapus($id_guru)
    {
        $this->db->table('tb_guru')
            ->where('id_guru', $id_guru)
            ->delete();
    }

    public function hapusGuru($id_guru)
    {
        $this->db->table('tb_guru')
            ->where('id_guru', $id_guru)
            ->delete();
    }
}
