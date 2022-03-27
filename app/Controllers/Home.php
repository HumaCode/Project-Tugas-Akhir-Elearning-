<?php

namespace App\Controllers;

use App\Models\ModelKritik;
use App\Models\ModelSetting;

class Home extends BaseController
{
    public function __construct()
    {
        $this->ModelSetting =  new ModelSetting();
        $this->ModelKritik =  new ModelKritik();
    }

    public function index()
    {
        $id_setting = 1;

        $data = [
            'setting' => $this->ModelSetting->find($id_setting)
        ];

        return view('landing_page', $data);
    }

    public function kritik()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kritik' => [
                    'label' => 'Kolom Kritik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'saran' => [
                    'label' => 'Kolom Saran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ]
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'kritik' => $validation->getError('kritik'),
                        'saran' => $validation->getError('saran')
                    ]
                ];
            } else {
                $simpanData = [
                    'email' => htmlspecialchars($this->request->getVar('email')),
                    'kritik' => htmlspecialchars($this->request->getVar('kritik')),
                    'saran' => htmlspecialchars($this->request->getVar('saran')),
                ];

                // masukan ke dalam tabel 
                $this->ModelKritik->insert($simpanData);

                $msg = [
                    'success'  => 'Kritik dan Saran anda berhasil terkirim'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }
}
