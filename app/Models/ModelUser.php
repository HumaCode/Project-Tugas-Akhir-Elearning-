<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    protected $useTimestamps = true;

    protected $allowedFields = ['nama_user', 'username', 'email', 'password', 'role', 'foto', 'is_active'];

    public function editUser($username, $updateData)
    {
        $this->db->table('tb_user')
            ->where('username', $username)
            ->update($updateData);
    }

    public function hapusUser($username)
    {
        $this->db->table('tb_user')
            ->where('username', $username)
            ->delete();
    }

    public function tampilUser()
    {
        return $this->db->table('tb_user')
            ->where('role !=', 3)
            ->where('id_user !=', session()->get('id_user'))
            ->get()
            ->getResultArray();
    }

    public function tampilBySession()
    {
        return $this->db->table('tb_user')
            ->where('id_user', session()->get('id_user'))
            ->get()
            ->getRowArray();
    }
}
