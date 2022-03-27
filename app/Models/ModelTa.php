<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTa extends Model
{
    protected $table = 'tb_ta';
    protected $primaryKey = 'id_ta';
    protected $useTimestamps = false;

    protected $allowedFields = ['tahun', 'semester', 'status'];


    public function resetStatus()
    {
        $this->db->table('tb_ta')
            ->update(['status' => 0]);
    }

    public function taAktif()
    {
        return $this->db->table($this->table)
            ->where('status', 1)
            ->get()
            ->getRowArray();
    }

    public function aktifkan($id_ta, $data)
    {
        $this->db->table($this->table)->where('id_ta', $id_ta)->update($data);
    }

    public function nonaktifkan($id_ta, $data)
    {
        $this->db->table($this->table)->where('id_ta', $id_ta)->update($data);
    }
}
