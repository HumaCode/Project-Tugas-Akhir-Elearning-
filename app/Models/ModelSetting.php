<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSetting extends Model
{
    protected $table = 'tb_setting';
    protected $primaryKey = 'id_setting';

    protected $allowedFields = ['desk1', 'desk2', 'desk3', 'desk4', 'nama_sekolah', 'npsn', 'jenjang', 'status_sekolah', 'alamat', 'rt', 'rw', 'kd_pos', 'kelurahan', 'kecamatan', 'kabupaten', 'email', 'fb', 'tlp', 'map', 'foto', 'logo'];
}
