<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    public function cekEmail($email)
    {
        return $this->db->table('tb_user')
            ->where('email', $email)
            ->get()
            ->getRowArray();
    }

    public function loginSiswa($nis)
    {
        return $this->db->table('tb_user')
            ->where('username', $nis)
            ->get()
            ->getRowArray();
    }
}
