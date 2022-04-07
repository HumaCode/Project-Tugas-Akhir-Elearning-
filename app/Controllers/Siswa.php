<?php

namespace App\Controllers;

use App\Models\ModelAbsensi;
use App\Models\ModelAnggota;
use App\Models\ModelChat;
use App\Models\ModelJawaban;
use App\Models\ModelKelas;
use App\Models\ModelKuis;
use App\Models\ModelKursus;
use App\Models\ModelMateri;
use App\Models\ModelSiswa;
use App\Models\ModelSubKursus;
use App\Models\ModelTa;
use App\Models\ModelUser;

class Siswa extends BaseController
{
    public function __construct()
    {
        $this->ModelKursus      = new ModelKursus();
        $this->ModelSiswa       = new ModelSiswa();
        $this->ModelAnggota     = new ModelAnggota();
        $this->ModelTa          = new ModelTa();
        $this->ModelSubKursus   = new ModelSubKursus();
        $this->ModelMateri      = new ModelMateri();
        $this->ModelKuis        = new ModelKuis();
        $this->ModelJawaban     = new ModelJawaban();
        $this->ModelAbsensi     = new ModelAbsensi();
        $this->ModelKelas       = new ModelKelas();
        $this->ModelUser        = new ModelUser();
        $this->ModelChat        = new ModelChat();
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
            'icon' => '<i class="fas fa-home"></i>'
        ];

        return view('siswa/v_dashboard', $data);
    }

    public function kursus()
    {
        $username = session()->get('username');

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $id_kelas = $siswa['kelas_id'];
        $id_siswa = $siswa['id_siswa'];

        // dd($id_siswa);

        $data = [
            'title'         => 'Kursus Saya',
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kursus'        => $this->ModelKursus->tampilByKelas($id_kelas),
        ];

        return view('siswa/kursus/v_kursus', $data);
    }

    public function subKursus($id_kursus)
    {

        $username = session()->get('username');
        $kursus = $this->ModelKursus->tampilDataById($this->request->uri->getSegment(3));

        $k = $kursus['mapel'];

        $ta_aktif = $this->ModelTa->taAktif();

        $id_ta = $ta_aktif['id_ta'];


        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);
        $id_siswa = $siswa['id_siswa'];



        $data = [
            'title'     => 'Kursus ' . $k,
            'icon'      => '<i class="fas fa-graduation-cap"></i>',
            'kursus'    => $kursus,
            'id_kursus' => $id_kursus,
            'id_siswa'  => $id_siswa,
            'ta'        => $ta_aktif,
            'subKursus' => $this->ModelSubKursus->tampilSemua($id_kursus, $id_ta),
            'anggota'   => $this->ModelAnggota->tampilByIdSiswa($id_kursus, $id_siswa),
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id']) {
            return view('siswa/kursus/v_sub-kursus', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function lihatAnggota($id_kursus)
    {
        $username = session()->get('username');
        $kursus = $this->ModelKursus->tampilDataById($this->request->uri->getSegment(3));

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $k = $kursus['mapel'];


        $id_kelas = $kursus['id_kelas'];

        $data = [
            'title'         => 'Daftar Anggota Kursus ' . $k,
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'kursusId'      => $this->ModelKursus->tampilDataById($id_kursus),
            'anggota'       => $this->ModelAnggota->tampilDataById($id_kursus),
            'siswaByKelas'  => $this->ModelSiswa->tampilSiswaByKelas($id_kelas),
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id']) {
            return view('siswa/kursus/v_anggota', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function materi($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $username           = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $id_siswa = $siswa['id_siswa'];

        // data absen berdasarkan id kursus, id sub kursus dan id kelas
        // $absen = $this->ModelAbsensi->tampilByIdKelas($id_kursus, $id_sub_kursus, $id_siswa);

        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->tampilData($id_sub_kursus),
            'absen'         => $this->ModelAbsensi->tampilByIdKelas($id_kursus, $id_sub_kursus, $id_siswa),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'sub_kursus'    => $sub_kursus,
        ];


        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/materi/v_materi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function formAbsen()
    {
        if ($this->request->isAJAX()) {

            $id_kursus      = $this->request->getVar('id_kursus');
            $id_sub_kursus  = $this->request->getVar('id_sub_kursus');

            $data = [
                'id_kursus'     => $id_kursus,
                'id_sub_kursus' => $id_sub_kursus,
            ];

            $msg = [
                'success' => view('siswa/absen/v_modal-absen', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formAbsen2()
    {
        if ($this->request->isAJAX()) {

            date_default_timezone_set("Asia/Jakarta");

            $id_kursus      = $this->request->getVar('id_kursus');
            $id_sub_kursus  = $this->request->getVar('id_sub_kursus');

            $nis = session()->get('username');

            $siswa = $this->ModelSiswa->tampilSiswaByUsername($nis);

            $id_siswa = $siswa['id_siswa'];

            // tampil data absensi berdasarkan id kursus, ud sub kursus dan id kelas
            $absen = $this->ModelAbsensi->tampilByIdKelas($id_kursus, $id_sub_kursus, $id_siswa);

            $id_absen = $absen['id_absen'];

            $updatedata = [
                'absen'         => 1,
                'waktu'         => date('Y-m-d H:i:s')
            ];

            $this->ModelAbsensi->update($id_absen, $updatedata);

            $msg = [
                'success' => 'Kamu Berhasil Absen'
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function upload()
    {
        // jika ada request dari ajax
        if ($this->request->isAJAX()) {
            $id_kursus      = $this->request->getVar('id_kursus');
            $id_sub_kursus  = $this->request->getVar('id_sub_kursus');

            $nis = session()->get('username');

            $siswa = $this->ModelSiswa->tampilSiswaByUsername($nis);

            $id_siswa = $siswa['id_siswa'];

            // tampil data absensi berdasarkan id kursus, ud sub kursus dan id kelas
            $absen = $this->ModelAbsensi->tampilByIdKelas($id_kursus, $id_sub_kursus, $id_siswa);

            $id_absen = $absen['id_absen'];

            if ($this->request->getPost('imagecam') == '') {
                $msg = ['error' => 'Silahkan upload foto terlebih dahulu'];
                echo json_encode($msg);
            } else {


                // cek foto
                // $fotolama = $siswa['foto'];
                // if ($fotolama != null || $fotolama != '') {
                //     unlink($fotolama);
                // }

                date_default_timezone_set("Asia/Jakarta");

                $image = $this->request->getPost('imagecam');
                $image = str_replace('data:image/jpeg;base64,', '', $image);

                $image = base64_decode($image, true);
                $filename = date('H-i-s') . '.jpg';
                file_put_contents(FCPATH . './assets/img/absen/' .  $filename, $image);

                // $image->move('assets/img/absen', $id_siswa);


                $updatedata = [
                    'foto'          => $filename,
                    'absen'         => 1,
                    'waktu'         => date('Y-m-d H:i:s')
                ];

                $this->ModelAbsensi->update($id_absen, $updatedata);

                $msg = [
                    'success' => 'Kamu Berhasil Absen'
                ];

                echo json_encode($msg);
            }
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function downloadFileMateri($id_materi)
    {
        $materi = $this->ModelMateri->find($id_materi);

        return $this->response->download('assets/file/' . $materi['nama_file'], null);
    }

    public function lihatMateri($id_materi, $id_kursus, $id_sub_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(5);

        $username           = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $data = [
            'title'         => 'Lihat Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->tampilById($id_materi),
            'id_kursus'     => $id_kursus,
            'id_materi'     => $id_materi,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/materi/v_lihat-materi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function lihatVideoMateri($id_materi, $id_kursus, $id_sub_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(5);

        $username           = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->find($id_materi),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'id_materi'     => $id_materi,
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/materi/v_lihat-video', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function lihatVideoKuis($id_kuis, $id_kursus, $id_sub_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(5);

        $username           = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $data = [
            'title'         => 'Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->find($id_kuis),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'id_kuis'       => $id_kuis,
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/kuis/v_lihat-video', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function kuis($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $username           = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        // ambil data siswa berdasarkan username/session username
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $data = [
            'title'         => 'Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->tampilData($id_sub_kursus, $id_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/kuis/v_kuis', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function lihatKuis($id_kuis, $id_kursus, $id_sub_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(5);

        $sesi = session()->get('username');
        $siswa = $this->ModelSiswa->tampilSiswaByUsername($sesi);
        $id_siswa = $siswa['id_siswa'];

        $kursus = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);

        $data = [
            'title'         => 'Lihat Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->tampilById($id_kuis),
            'jawaban'       => $this->ModelJawaban->tampilById($id_kuis, $id_siswa),
            'id_kursus'     => $id_kursus,
            'id_kuis'       => $id_kuis,
            'id_sub_kursus' => $id_sub_kursus,
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_kelas'] == $siswa['kelas_id'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('siswa/kuis/v_lihat-kuis', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function downloadFileKuis($id_kuis)
    {
        $kuis = $this->ModelKuis->find($id_kuis);

        return $this->response->download('assets/file/' . $kuis['file'], null);
    }

    public function jawab()
    {
        $id_kuis        = $this->request->getVar('id_kuis');
        $id_sub_kursus  = $this->request->getVar('id_sub_kursus');
        $id_kursus      = $this->request->getVar('id_kursus');

        $sesi           = session()->get('username');
        $siswa          = $this->ModelSiswa->tampilSiswaByUsername($sesi);

        $kuis           = $this->ModelKuis->find($id_kuis);


        // validasi
        if ($this->validate([
            'jawab' => [
                'label' => 'Lembar Jawab',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'max_size[file,2024]',
                'errors' => [
                    'max_size' => 'Maksimal 2 MB.!!',
                ]
            ],
        ])) {

            $file = $this->request->getFile('file');

            if ($file->getError() == 4) {
                $data = [
                    'id_kuis'           => $id_kuis,
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'id_siswa'          => $siswa['id_siswa'],
                    'jawaban'           => $this->request->getVar('jawab'),
                    'jwb_file'          => 'Tidak ada file',
                    'dikirim'           => date('Y-m-d H:i:s')
                ];
            } else {
                $nama_file = $file->getRandomName();

                $data = [
                    'id_kuis'           => $id_kuis,
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'id_siswa'          => $siswa['id_siswa'],
                    'jawaban'           => $this->request->getVar('jawab'),
                    'jwb_file'          => $nama_file,
                    'dikirim'           => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelJawaban->insert($data);

            session()->setFlashdata('pesan', 'Jawaban kamu berhasil dikirim...!!!');
            return redirect()->to('siswa/lihatKuis/' . $id_kuis . '/'  . $id_kursus . '/' . $id_sub_kursus);
        } else {
            // jika tidak valid
            if ($kuis['url'] == null) {
                return redirect()->to('siswa/lihatKuis/' . $id_kuis . '/'  . $id_kursus . '/' . $id_sub_kursus)->withInput();
            } else {
                return redirect()->to('siswa/lihatVideoKuis/' . $id_kuis . '/'  . $id_kursus . '/' . $id_sub_kursus)->withInput();
            }
        }
    }

    public function profil()
    {
        $username = session()->get('username');

        $siswa = $this->ModelSiswa->tampilSiswaByUsername($username);

        $id_siswa = $siswa['id_siswa'];



        $data = [
            'title'     => 'Profil Saya',
            'icon'      => '<i class="fas fa-user"></i>',
            'profil'    => $this->ModelSiswa->joinTabel($id_siswa),
        ];

        return view('siswa/v_profil', $data);
    }

    public function formEditProfil()
    {
        if ($this->request->isAJAX()) {

            $id_siswa = $this->request->getVar('id_siswa');

            $row = $this->ModelSiswa->find($id_siswa);

            $data = [
                'id_siswa'      => $row['id_siswa'],
                'nama_siswa'    => $row['nama_siswa'],
                'nis'           => $row['nis'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'kelas'         => $row['kelas_id'],
            ];

            $msg = [
                'success'  => view('siswa/v_modal-edit-profil', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateProfil()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'nis' => [
                    'label' => 'NIS',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'is_unique[tb_user.email, id_user,{id_user}]',
                    'errors' => [
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'      => $validation->getError('nama'),
                        'nis'       => $validation->getError('nis'),
                        'email'     => $validation->getError('email'),
                        'kelas'     => $validation->getError('kelas')
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }

                $updateDataSiswa = [
                    'nama_siswa'    => htmlspecialchars($this->request->getVar('nama')),
                    'nis'           => htmlspecialchars($this->request->getVar('nis')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass,
                ];

                $updateDataUser = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('nis')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass,
                ];

                $id_siswa   = $this->request->getVar('id_siswa');
                $id_user    = $this->request->getVar('id_user');

                // masukan ke dalam tabel 
                $this->ModelSiswa->update($id_siswa, $updateDataSiswa);

                $this->ModelUser->update($id_user, $updateDataUser);

                // ubah session
                $this->session->set('nama_user', $updateDataUser['nama_user']);
                $this->session->set('username', $updateDataUser['username']);
                $this->session->set('email', $updateDataUser['email']);

                $msg = [
                    'success'  => 'Profil berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditFotoProfil()
    {
        if ($this->request->isAJAX()) {

            $id_siswa = $this->request->getVar('id_siswa');

            $row = $this->ModelSiswa->find($id_siswa);
            $data = [
                'id_siswa'  => $row['id_siswa'],
                'foto'      => $row['foto']
            ];

            $msg = [
                'success'  => view('siswa/v_modal-edit-foto-profil', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateFotoProfil()
    {
        if ($this->request->isAJAX()) {
            $id_siswa   = $this->request->getVar('id_siswa');
            $id_user    = $this->request->getVar('id_user');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'file' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[file]|mime_in[file,image/png,image/jpg,image/jpeg]|is_image[file]|max_size[file,1024]',
                    'errors' => [
                        'uploaded' => '{field} tidak boleh kosong.!!',
                        'mime_in' => 'Yang anda upload bukan format gambar.!!',
                        'max_size' => 'Maksimal 1 MB.!!',
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('file')
                    ]
                ];
            } else {
                // cek foto
                $cekdata = $this->ModelSiswa->find($id_siswa);
                $fotolama = $cekdata['foto'];
                if ($fotolama != 'default.png') {
                    unlink('assets/img/user/' . $fotolama);
                }

                $filefoto = $this->request->getFile('file');

                $filefoto->move('assets/img/user', $id_user . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => $filefoto->getName()
                ];

                $this->ModelSiswa->update($id_siswa, $updatedata);
                $this->ModelUser->update($id_user, $updatedata);

                // hapus sesion foto
                session()->remove('foto');

                // ubah session foto
                $this->session->set('foto', $updatedata['foto']);

                $msg = [
                    'success' => 'Berhasil diupload'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }


    // Chatting
    public function chat()
    {
        $data = [
            'title'         => 'Chat',
            'icon'          => '<i class="fas fa-comment"></i>',
            'count_inbox'   => $this->ModelChat->where('id_penerima', session()->get('id_user'))->where('is_read', 0)->countAllResults(),
        ];

        return view('siswa/chat/v_index', $data);
    }

    public function kirim()
    {
        $data = [
            'title'         => 'Kirim Pesan',
            'icon'          => '<i class="fas fa-comment"></i>',
            'user'          => $this->ModelUser->where('id_user !=', session()->get('id_user'))->findAll(),
        ];

        return view('siswa/chat/v_kirim', $data);
    }

    public function proses_kirim()
    {

        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'penerima' => [
                    'label' => 'Penerima',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'pesan' => [
                    'label' => 'Pesan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],

            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'penerima'      => $validation->getError('penerima'),
                        'pesan'         => $validation->getError('pesan'),
                    ]
                ];
            } else {
                $simpanPesan = [
                    'id_pengirim'   =>  session()->get('id_user'),
                    'id_penerima'   =>  htmlspecialchars($this->request->getVar('penerima')),
                    'pesan'         =>  htmlspecialchars($this->request->getVar('pesan')),
                    'is_read'       =>  0,
                    'created'       =>  date('Y-m-d H:i:s'),
                ];


                // masukan ke dalam tabel 
                $this->ModelChat->insert($simpanPesan);

                $msg = [
                    'success'  => 'Pesan berhasil dikirim'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function pesanKeluar()
    {
        $ModelChat    = new ModelChat();

        $messages = $ModelChat
            ->select('tb_user.nama_user AS nama, tb_chating.pesan AS pesan, tb_chating.id_chating AS id_chating, tb_chating.is_read AS dibaca, tb_chating.created AS tanggal')
            ->join('tb_user', 'tb_user.id_user=tb_chating.id_penerima', 'left')
            ->where('id_pengirim', $this->session->get('id_user'))
            ->orderBy('id_chating', 'desc')
            ->findAll();

        $data = [
            'title'             => 'Pesan Keluar',
            'icon'              => '<i class="far fa-envelope"></i>',
            'messages'          => $messages,
            'count_inbox'       => $this->ModelChat->where('id_penerima', session()->get('id_user'))->where('is_read', 0)->countAllResults(),
        ];

        return view('siswa/chat/v_pesan-keluar', $data);
    }

    public function lihatOutbox($id_chating)
    {
        $chat = $this->ModelChat->find($this->request->uri->getSegment(3));
        $pesan      = $this->ModelChat->find($id_chating);

        $id_chating     = $pesan['id_chating'];

        // dd($id_pengirim);

        $penerima   = $this->ModelUser->find($pesan['id_penerima']);
        $pengirim   = $this->ModelUser->find($pesan['id_pengirim']);

        // dd($pesanDari['id_penerima'] . ' ' . $pesan['id_pengirim']);

        $data = [
            'title'         => 'Pesan Keluar',
            'icon'          => '<i class="far fa-envelope"></i>',
            'pesan'         => $pesan,
            'penerima'      => $penerima,
            'pengirim'      => $pengirim,
        ];

        if ($chat['id_pengirim'] === session()->get('id_user')) {
            return view('siswa/chat/v_pesan-keluar-detail', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function hapusChatKeluar()
    {
        if ($this->request->isAJAX()) {
            $id_chating = $this->request->getVar('id_chating');

            // hapus data 
            $this->ModelChat->delete($id_chating);

            $msg = [
                'success'  => "Chating berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function pesanMasuk()
    {
        $ModelChat    = new ModelChat();

        $messages = $ModelChat
            ->select('tb_user.nama_user AS nama, tb_chating.pesan AS pesan, tb_chating.id_chating AS id_chating, tb_chating.is_read AS dibaca, tb_chating.created AS tanggal')
            ->join('tb_user', 'tb_user.id_user=tb_chating.id_pengirim', 'left')
            ->where('id_penerima', $this->session->get('id_user'))
            ->orderBy('id_chating', 'desc')
            ->findAll();

        $data = [
            'title'         => 'Pesan Masuk',
            'icon'          => '<i class="far fa-envelope"></i>',
            'messages'      => $messages,
            'count_inbox'   => $this->ModelChat->where('id_penerima', session()->get('id_user'))->where('is_read', 0)->countAllResults(),
        ];

        return view('siswa/chat/v_pesan-masuk', $data);
    }

    public function lihatInbox($id_chating)
    {
        $chat       = $this->ModelChat->find($this->request->uri->getSegment(3));
        $pesan      = $this->ModelChat->find($id_chating);
        $penerima   = $this->ModelUser->find($pesan['id_penerima']);
        $pengirim   = $this->ModelUser->find($pesan['id_pengirim']);

        if ($pesan['id_penerima'] == $this->session->id_user) {
            $pesan['is_read'] = 1;

            // update
            $this->ModelChat->update($id_chating, $pesan);
        }

        $data = [
            'title'         => 'Pesan Masuk',
            'icon'          => '<i class="far fa-envelope"></i>',
            'pesan'         => $pesan,
            'penerima'      => $penerima,
            'pengirim'      => $pengirim,
        ];

        if ($chat['id_penerima'] === session()->get('id_user')) {
            return view('siswa/chat/v_pesan-masuk-detail', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('siswa/v_forbidden', $data2);
        }
    }

    public function balasPesan()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'pesan' => [
                    'label' => 'Pesan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],

            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pesan'         => $validation->getError('pesan'),
                    ]
                ];
            } else {

                $penerima = $this->request->getVar('penerima');

                $simpanPesan = [
                    'id_pengirim'   =>  session()->get('id_user'),
                    'id_penerima'   =>  $penerima,
                    'pesan'         =>  htmlspecialchars($this->request->getVar('pesan')),
                    'is_read'       =>  0,
                    'created'       =>  date('Y-m-d H:i:s'),
                ];


                // masukan ke dalam tabel 
                $this->ModelChat->insert($simpanPesan);

                $msg = [
                    'success'  => 'Pesan berhasil dikirim'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }
}
