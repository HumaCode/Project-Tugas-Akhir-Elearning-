<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMapel extends Model
{
    protected $table = 'tb_mapel';
    protected $primaryKey = 'id_mapel';

    protected $allowedFields = ['mapel'];
}
