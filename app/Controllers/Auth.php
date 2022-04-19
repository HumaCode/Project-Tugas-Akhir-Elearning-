<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAuth;
use App\Models\ModelSetting;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->ModelAuth    = new ModelAuth();
        $this->ModelSetting = new ModelSetting();
    }

    public function index()
    {
        $id_setting = 1;

        $data = [
            'title' => 'Login Guru & Admin',
            'validation' =>  \Config\Services::validation(),
            'setting' => $this->ModelSetting->find($id_setting)
        ];

        return view('v_login', $data);
    }

    public function loginAdminGuru()
    {
        // validasi
        if ($this->validate([
            'email' => [
                'label' => 'E-Mail',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.!!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.!!',
                ],
            ]
        ])) {
            // jika valid
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $cek_login = $this->ModelAuth->cekEmail($email);

            if ($cek_login) {
                // cek aktivasi
                if ($cek_login['is_active'] == 1) {
                    // buat session
                    if (password_verify($password, $cek_login['password'])) {
                        // buat session
                        $sesi = [
                            'id_user'       => $cek_login['id_user'],
                            'nama_user'     => $cek_login['nama_user'],
                            'username'      => $cek_login['username'],
                            'email'         => $cek_login['email'],
                            'role'          => $cek_login['role'],
                            'foto'          => $cek_login['foto'],
                            'is_active'     => $cek_login['is_active'],
                            'created_at'    => $cek_login['created_at'],
                        ];

                        $this->session->set($sesi);

                        if (session()->get('role') == 1) {
                            // arahkan ke halaman admin
                            return redirect()->to('admin');
                        } else if (session()->get('role') == 2) {
                            // arahkan ke halaman guru
                            return redirect()->to('guru');
                        }
                    } else {
                        session()->setFlashdata('p', 'Email atau Password Salah.!!');
                        return redirect()->to('/auth');
                    }
                } else {
                    session()->setFlashdata('p', 'Akun belum diaktivasi, silahkan hubungi admin.!!');
                    return redirect()->to('/auth');
                }
            } else {
                session()->setFlashdata('p', 'Email atau Password Salah.!!');
                return redirect()->to('/auth');
            }
        } else {
            // jika error
            return redirect()->to('/auth')->withInput();
        };
    }


    public function logoutAdminGuru()
    {
        $this->session->destroy();

        // flashdata
        session()->setFlashdata('pesan', 'Anda berhasil logout');
        return redirect()->to('/auth');
    }
}
