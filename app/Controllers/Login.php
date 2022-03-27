<?php

namespace App\Controllers;

use App\Models\ModelAuth;

class Login extends BaseController
{
    public function __construct()
    {
        $this->ModelAuth = new ModelAuth();
    }

    public function index()
    {
        $data = [
            'title' => 'Login Siswa',
            'validation' => \Config\Services::validation(),
            'icon' => '<i class="fas fa-sign-in-alt"></i>'
        ];

        return view('siswa/v_login', $data);
    }

    public function cekLoginSiswa()
    {
        // validasi
        if ($this->validate([
            'nis' => [
                'label' => 'NIS',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong.!!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak boleh kosong.!!',
                ],
            ]
        ])) {

            // jika valid
            $nis = $this->request->getPost('nis');
            $password = $this->request->getPost('password');

            $cek_login = $this->ModelAuth->loginSiswa($nis);


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

                        // flashdata
                        session()->setFlashdata('login', 'Anda berhasil login');
                        return redirect()->to('/siswa');
                    } else {
                        session()->setFlashdata('p', 'NIS atau Password Salah.!!');
                        return redirect()->to('/login');
                    }
                } else {
                    session()->setFlashdata('p', 'Akun belum di aktivasi, Silahkan hubungi admin.!!');
                    return redirect()->to('/login');
                }
            } else {
                session()->setFlashdata('p', 'NIS atau Password Salah.!!');
                return redirect()->to('/login');
            }
        } else {
            // jika error
            return redirect()->to('/login')->withInput();
        };
    }

    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/login');
    }
}
