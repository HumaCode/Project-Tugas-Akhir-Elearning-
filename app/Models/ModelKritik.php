<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKritik extends Model
{
    protected $table = 'tb_kritik';
    protected $primaryKey = 'id_kritik';
    protected $useTimestamps = true;

    protected $allowedFields = ['email', 'kritik', 'saran'];
}
