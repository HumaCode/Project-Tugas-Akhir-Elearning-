<?php

namespace App\Controllers;

use App\Models\ModelAbsensi;
use App\Models\ModelAdmin;
use App\Models\ModelAnggota;
use App\Models\ModelChat;
use App\Models\ModelGuru;
use App\Models\ModelJawaban;
use App\Models\ModelKelas;
use App\Models\ModelKuis;
use App\Models\ModelKursus;
use App\Models\ModelMapel;
use App\Models\ModelMateri;
use App\Models\ModelSiswa;
use App\Models\ModelSubKursus;
use App\Models\ModelTa;
use App\Models\ModelUser;


class Guru extends BaseController
{
    public function __construct()
    {
        $this->ModelKursus       = new ModelKursus();
        $this->ModelGuru         = new ModelGuru();
        $this->ModelMapel        = new ModelMapel();
        $this->ModelKelas        = new ModelKelas();
        $this->ModelTa           = new ModelTa();
        $this->ModelSubKursus    = new ModelSubKursus();
        $this->ModelAnggota      = new ModelAnggota();
        $this->ModelSiswa        = new ModelSiswa();
        $this->ModelUser         = new ModelUser();
        $this->ModelMateri       = new ModelMateri();
        $this->ModelKuis         = new ModelKuis();
        $this->ModelAdmin        = new ModelAdmin();
        $this->ModelJawaban      = new ModelJawaban();
        $this->ModelAbsensi      = new ModelAbsensi();
        $this->ModelChat         = new ModelChat();
    }

    public function index()
    {
        $email = session()->get('email');

        $guru = $this->ModelGuru->tampilByEmail($email);
        $id_guru = $guru['id_guru'];

        $data = [
            'title' => 'Dashboard',
            'icon'  => '<i class="fas fa-tachometer-alt"></i>',
            'jml'   => $this->ModelKursus->jmlKursusGuru($id_guru)
        ];

        return view('guru/v_dashboard', $data);
    }

    public function kursus()
    {
        $nip = session()->get('username');

        // ambil data guru berdasarkan username/session username
        $guru = $this->ModelGuru->tampilGuruByNip($nip);

        $id_guru = $guru['id_guru'];

        $data = [
            'title'         => 'Daftar Kursus',
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kursus'        => $this->ModelKursus->tampilByIdGuru($id_guru),
        ];

        return view('guru/kursus/v_kursus', $data);
    }

    public function formTambahKursus()
    {
        if ($this->request->isAJAX()) {

            $nip = session()->get('username');

            // ambil data guru berdasarkan username/session username
            $guru = $this->ModelGuru->tampilGuruByNip($nip);



            $data = [
                'mapel'     => $this->ModelMapel->findAll(),
                'kelas'     => $this->ModelKelas->where('id_kelas !=', 0)->findAll(),
                'id_guru'   => $guru['id_guru'],
            ];

            $msg = [
                'data' => view('guru/kursus/v_modal-tambah', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanKursus()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'mapel' => [
                    'label' => 'Matapelajaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'kelas' => [
                    'label' => 'Kelas',
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
                        'mapel'         => $validation->getError('mapel'),
                        'kelas'         => $validation->getError('kelas'),
                    ]
                ];
            } else {
                $id_guru = $this->request->getVar('id_guru');

                $simpanKursus = [
                    'id_mapel'          => htmlspecialchars($this->request->getVar('mapel')),
                    'id_kelas'          => htmlspecialchars($this->request->getVar('kelas')),
                    'id_guru'           => $id_guru,
                    'gambar'            => 'kursus.jpg',
                    'created_at'        => date('Y-m-d H:m:s'),
                    'updated_at'        => date('Y-m-d H:m:s'),
                ];


                // masukan ke dalam tabel 
                $this->ModelKursus->tambahKursus($simpanKursus);

                $msg = [
                    'success'  => 'Kursus baru berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditKursus()
    {
        if ($this->request->isAJAX()) {

            $id_kursus = $this->request->getVar('id_kursus');

            $row = $this->ModelKursus->find($id_kursus);

            $data = [
                'id_kursus'  => $row['id_kursus'],
                'id_mapel'   => $row['id_mapel'],
                'id_kelas'   => $row['id_kelas'],
                'id_guru'    => $row['id_guru'],
                'mapel'      => $this->ModelMapel->findAll(),
                'kelas'      => $this->ModelKelas->where('id_kelas !=', 0)->findAll(),
            ];

            $msg = [
                'success'  => view('guru/kursus/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateKursus()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'mapel' => [
                    'label' => 'Matapelajaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'kelas' => [
                    'label' => 'kelas',
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
                        'mapel' => $validation->getError('mapel'),
                        'kelas' => $validation->getError('kelas'),
                    ]
                ];
            } else {
                $updateData = [
                    'id_mapel' => htmlspecialchars($this->request->getVar('mapel')),
                    'id_kelas' => htmlspecialchars($this->request->getVar('kelas')),
                    'updated_at' => date('Y-m-d H:m:s')
                ];

                $id_kursus = $this->request->getVar('id_kursus');

                // masukan ke dalam tabel 
                $this->ModelKursus->updateKursus($id_kursus, $updateData);

                $msg = [
                    'success'  => 'Kursus berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusKursus()
    {
        if ($this->request->isAJAX()) {
            $id_kursus = $this->request->getVar('id_kursus');


            // hapus data 
            $this->ModelKursus->delete($id_kursus);

            $msg = [
                'success'  => "Kursus berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function subKursus($id_kursus)
    {
        $nip = session()->get('username');
        $kursus = $this->ModelKursus->tampilDataById($this->request->uri->getSegment(3));

        $k = $kursus['mapel'];

        $ta_aktif = $this->ModelTa->taAktif();

        $id_ta = $ta_aktif['id_ta'];
        $guru = $this->ModelGuru->tampilGuruByNip($nip);



        $data = [
            'title'     => 'Kursus ' . $k,
            'icon'      => '<i class="fas fa-graduation-cap"></i>',
            'kursus'    => $kursus,
            'id_kursus' => $id_kursus,
            'ta'        => $ta_aktif,
            'subKursus' => $this->ModelSubKursus->tampilSemua($id_kursus, $id_ta)
        ];

        if ($kursus['id_guru'] == $guru['id_guru']) {
            return view('guru/kursus/v_sub-kursus', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function formTambahSubKursus()
    {
        if ($this->request->isAJAX()) {

            $id_kursus = $this->request->getVar('id_kursus');
            $kursus = $this->ModelKursus->find($id_kursus);

            // tahun pelajaran yang sedang aktif
            $ta_aktif = $this->ModelTa->taAktif();

            $data = [
                'kursus'    => $kursus['id_kursus'],
                'ta_aktif'  => $ta_aktif['id_ta']
            ];

            $msg = [
                'success' => view('guru/kursus/v_modal-tambahSubKursus', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanSubKursus()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'sesi' => [
                    'label' => 'Sesi Sub Kursus',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'tipe' => [
                    'label' => 'Tipe Absensi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'mulai' => [
                    'label' => 'Tanggal Mulai',
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
                        'sesi'  => $validation->getError('sesi'),
                        'tipe'  => $validation->getError('tipe'),
                        'mulai' => $validation->getError('mulai')
                    ]
                ];
            } else {
                $id_kursus  = $this->request->getVar('id_kursus');
                $id_ta      = $this->request->getVar('id_ta');



                $simpanData = [
                    'id_kursus'     => $id_kursus,
                    'sub_kursus'    => htmlspecialchars($this->request->getVar('sesi')),
                    'id_ta'         => $id_ta,
                    'tipe'          => $this->request->getVar('tipe'),
                    'mulai'         => $this->request->getVar('mulai')
                ];

                // masukan ke dalam tabel 
                $this->ModelSubKursus->insert($simpanData);

                $msg = [
                    'success'  => 'Sub Kursus berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditSubKursus()
    {
        if ($this->request->isAJAX()) {

            $id_sub_kursus = $this->request->getVar('id_sub_kursus');

            // tahun pelajaran yang sedang aktif
            $ta_aktif = $this->ModelTa->taAktif();

            $row = $this->ModelSubKursus->find($id_sub_kursus);

            $data = [
                'id_sub_kursus' => $row['id_sub_kursus'],
                'sub_kursus'    => $row['sub_kursus'],
                'tipe'          => $row['tipe'],
                'mulai'         => $row['mulai'],
                'ta_aktif'      => $ta_aktif['id_ta']
            ];

            $msg = [
                'success'  => view('guru/kursus/v_modal-editSubKursus', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateSubKursus()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'sesi' => [
                    'label' => 'Sesi Sub Kursus',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'tipe' => [
                    'label' => 'Tipe',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'mulai' => [
                    'label' => 'Tannggal Mulai',
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
                        'sesi' => $validation->getError('sesi'),
                        'tipe' => $validation->getError('tipe'),
                        'mulai' => $validation->getError('mulai'),
                    ]
                ];
            } else {
                $id_ta = $this->request->getVar('id_ta');

                $updateData = [
                    'sub_kursus'    => htmlspecialchars($this->request->getVar('sesi')),
                    'id_ta'         => $id_ta,
                    'tipe'          => $this->request->getVar('tipe'),
                    'mulai'         => $this->request->getVar('mulai')
                ];

                $id_sub_kursus = $this->request->getVar('id_sub_kursus');

                // masukan ke dalam tabel 
                $this->ModelSubKursus->update($id_sub_kursus, $updateData);

                $msg = [
                    'success'  => 'Sub Kursus berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusSubKursus()
    {
        if ($this->request->isAJAX()) {
            $id_sub_kursus = $this->request->getVar('id_sub_kursus');

            $data = $this->ModelSubKursus->find($id_sub_kursus);
            $subKursus = $data['sub_kursus'];

            // hapus data 
            $this->ModelSubKursus->delete($id_sub_kursus);

            $msg = [
                'success'  => "$subKursus berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }


    public function lihatAnggota($id_kursus)
    {
        $nip = session()->get('username');
        $kursus = $this->ModelKursus->tampilDataById($this->request->uri->getSegment(3));

        $k = $kursus['mapel'];

        $row = $this->ModelKursus->tampilDataById($id_kursus);

        $id_kelas = $row['id_kelas'];
        $guru = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Daftar Peserta Kursus ' . $k,
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'kursusId'      => $this->ModelKursus->tampilDataById($id_kursus),
            'anggota'       => $this->ModelAnggota->tampilDataById($id_kursus),
            'siswaByKelas'  => $this->ModelSiswa->tampilSiswaByKelas($id_kelas),
        ];

        if ($kursus['id_guru'] == $guru['id_guru']) {
            return view('guru/kursus/v_anggota', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function tampilAnggotaByIdKursus()
    {
        $id_kursus  = $this->request->getVar('id_kursus');

        $data = $this->ModelAnggota->tampilDataByIdKursus($id_kursus);

        foreach ($data as $result) {
            $value[] = (float) $result->id_siswa;
        }
        echo json_encode($value);
    }

    public function formTambahAnggota()
    {
        if ($this->request->isAJAX()) {

            $id_kursus = $this->request->getVar('id_kursus');

            $row = $this->ModelKursus->tampilDataById($id_kursus);

            $id_kelas = $row['id_kelas'];


            $data = [
                'id_kursus'         => $row['id_kursus'],
                'siswaByKelas'      => $this->ModelSiswa->tampilSiswaByKelas($id_kelas),
            ];

            $msg = [
                'success'  => view('guru/kursus/v_modal-tambah-anggota', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanAnggota($id_kursus)
    {

        $anggota = $this->request->getVar('anggota');


        $this->ModelAnggota->tambahAnggota($id_kursus, $anggota);


        return redirect()->to(base_url('guru/lihatAnggota/' . $id_kursus));
    }

    public function updateAnggota()
    {
        $id_kursus = $this->request->getVar('edit_id');

        $anggota = $this->request->getVar('anggota_edit');

        $this->ModelAnggota->updateAnggota($id_kursus, $anggota);

        return redirect()->to(base_url('guru/lihatAnggota/' . $id_kursus));
    }

    public function hapusAnggota()
    {
        if ($this->request->isAJAX()) {

            $id_anggota = $this->request->getVar('id_anggota');

            // hitung jumlahnya
            $jmlData = count($id_anggota);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelAnggota->delete($id_anggota[$i]);
            }


            $msg = [
                'success' => "$jmlData anggota kelas berhasil dihapus."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function absensiSiswa($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);
        $id_kelas           = $kursus['id_kelas'];



        $data = [
            'title'         => 'Absensi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'absensi'       => $this->ModelAbsensi->tampilData($id_kursus, $id_sub_kursus, $id_kelas),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'kursus'        => $kursus,
            'jmlSiswa'      => $this->ModelAbsensi->jumlahSiswa($id_kursus, $id_sub_kursus, $id_kelas),
            'belumAbsen'    => $this->ModelAbsensi->jumlahBelumAbsen($id_kursus, $id_sub_kursus, $id_kelas),
            'masuk'         => $this->ModelAbsensi->jumlahMasuk($id_kursus, $id_sub_kursus, $id_kelas),
            'ijin'          => $this->ModelAbsensi->jumlahIjin($id_kursus, $id_sub_kursus, $id_kelas),
            'sakit'         => $this->ModelAbsensi->jumlahSakit($id_kursus, $id_sub_kursus, $id_kelas),
            'alpa'          => $this->ModelAbsensi->jumlahAlpa($id_kursus, $id_sub_kursus, $id_kelas),
        ];



        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/absensi/v_absensi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function formTambahSiswaAbsensi()
    {
        if ($this->request->isAJAX()) {

            $id_kursus      = $this->request->getVar('id_kursus');
            $id_sub_kursus  = $this->request->getVar('id_sub_kursus');

            $row = $this->ModelKursus->tampilDataById($id_kursus);

            $id_kelas = $row['id_kelas'];


            $data = [
                'id_kursus'         => $row['id_kursus'],
                'id_sub_kursus'     => $id_sub_kursus,
                'id_kelas'          => $id_kelas,
                'siswaByKelas'      => $this->ModelSiswa->tampilSiswaByKelas($id_kelas),
            ];

            $msg = [
                'success'  => view('guru/absensi/v_modal-tambah-anggota', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanAnggotaAbsen()
    {

        $id_kursus          = $this->request->getVar('id_kursus');
        $id_sub_kursus      = $this->request->getVar('id_sub_kursus');
        $id_kelas           = $this->request->getVar('id_kelas');


        $anggota = $this->request->getVar('anggota');


        $this->ModelAbsensi->tambahAnggota($id_kursus, $id_sub_kursus, $id_kelas, $anggota);


        session()->setFlashdata('pesan', 'Siswa berhasil ditambahkan...!!!');
        return redirect()->to(base_url('guru/absensiSiswa/' . $id_sub_kursus . '/' . $id_kursus));
    }

    public function formEditAbsen()
    {
        if ($this->request->isAJAX()) {

            $id_absen = $this->request->getVar('id_absen');

            $row = $this->ModelAbsensi->find($id_absen);

            $data = [
                'id_absen'  => $row['id_absen'],
                'absen'     => $row['absen'],
            ];

            $msg = [
                'success'  => view('guru/absensi/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function prosesEditAbsen()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');

            $id_absen = $this->request->getVar('id_absen');


            $updateData = [
                'absen' => htmlspecialchars($this->request->getVar('absen')),
                'waktu' => date('Y-m-d H:i:s')
            ];



            // masukan ke dalam tabel 
            $this->ModelAbsensi->update($id_absen, $updateData);

            $msg = [
                'success'  => 'Absensi berhasil diedit'
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusAbsen()
    {
        if ($this->request->isAJAX()) {
            $id_absen = $this->request->getVar('id_absen');


            // hapus file 
            $absen = $this->ModelAbsensi->find($id_absen);

            if ($absen['foto'] == null) {
            } else {
                if ($absen['foto'] != "") {
                    unlink('assets/img/absen/' . $absen['foto']);
                }
            }

            // hapus data 
            $this->ModelAbsensi->delete($id_absen);

            $msg = [
                'success'  => "Siswa berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formLihatAbsen()
    {
        if ($this->request->isAJAX()) {

            $id_absen = $this->request->getVar('id_absen');

            $row = $this->ModelAbsensi->find($id_absen);

            $data = [
                'foto'      => $row['foto'],
                'absen'     => $row['absen'],
            ];

            $msg = [
                'success'  => view('guru/absensi/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function materi($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->tampilData($id_sub_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];



        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/materi/v_materi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function tambahMateri($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Tambah Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/materi/v_tambah-materi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function prosesTambahMateri()
    {
        $id_sub_kursus  = $this->request->getVar('id_sub_kursus');
        $id_kursus      = $this->request->getVar('id_kursus');


        // validasi
        if ($this->validate([
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'max_size[file,1048]',
                'errors' => [
                    'max_size' => '{field} maksimal 1 MB..!!',
                ]
            ],
            'ket' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
        ])) {

            $file = $this->request->getFile('file');

            if ($this->request->getVar('url') == '') {
                $url = null;
            } else {
                $url = htmlspecialchars($this->request->getVar('url'));
            }

            if ($file->getError() == 4) {
                $data = [
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'judul'             => htmlspecialchars($this->request->getVar('judul')),
                    'nama_file'         => 'Tidak ada file',
                    'url'               => $url,
                    'ket'               => $this->request->getVar('ket'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];
            } else {
                $nama_file = $file->getRandomName();

                $data = [
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'judul'             => htmlspecialchars($this->request->getVar('judul')),
                    'nama_file'         => $nama_file,
                    'url'               => $url,
                    'ket'               => $this->request->getVar('ket'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelMateri->insert($data);

            session()->setFlashdata('pesan', 'Materi baru berhasil dibuat...!!!');
            return redirect()->to('guru/materi/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('guru/tambahMateri/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
        }
    }

    public function downloadFileMateri($id_materi)
    {
        $materi = $this->ModelMateri->find($id_materi);

        return $this->response->download('assets/file/' . $materi['nama_file'], null);
    }

    public function editMateri($id_materi, $id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(5);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(4);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Edit Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'materi'        => $this->ModelMateri->find($id_materi),
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/materi/v_edit-materi', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function prosesEditMateri()
    {
        $id_materi        = $this->request->getVar('id_materi');
        $id_sub_kursus  = $this->request->getVar('id_sub_kursus');
        $id_kursus      = $this->request->getVar('id_kursus');


        // validasi
        if ($this->validate([
            'judul' => [
                'label' => 'Judul Materi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'max_size[file,1024]',
                'errors' => [
                    'max_size' => '{field} maksimal 1 MB..!!',
                ]
            ],
            'ket' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
        ])) {

            $file = $this->request->getFile('file');

            if ($this->request->getVar('url') == '') {
                $url = null;
            } else {
                $url = htmlspecialchars($this->request->getVar('url'));
            }

            if ($file->getError() == 4) {
                $data = [
                    'judul'             => htmlspecialchars($this->request->getVar('judul')),
                    'url'               => $url,
                    'ket'               => $this->request->getVar('ket'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];
            } else {
                $nama_file = $file->getRandomName();

                // hapus file 
                $materi = $this->ModelMateri->find($id_materi);

                if ($materi['nama_file'] != 'Tidak ada file') {
                    if ($materi['nama_file'] != "") {
                        unlink('assets/file/' . $materi['nama_file']);
                    }
                }

                $data = [
                    'judul'             => htmlspecialchars($this->request->getVar('judul')),
                    'nama_file'         => $nama_file,
                    'url'               => $url,
                    'ket'               => $this->request->getVar('ket'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelMateri->update($id_materi, $data);

            session()->setFlashdata('pesan', 'Materi berhasil diedit...!!!');
            return redirect()->to('guru/materi/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('guru/editMateri/' . $id_materi . '/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
        }
    }

    public function hapusMateri()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');


            // hapus file 
            $materi = $this->ModelMateri->find($id_materi);

            if ($materi['nama_file'] == 'Tidak ada file') {
            } else {
                if ($materi['nama_file'] != "") {
                    unlink('assets/file/' . $materi['nama_file']);
                }
            }

            // hapus data 
            $this->ModelMateri->delete($id_materi);

            $msg = [
                'success'  => "Materi berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function detailMateri()
    {
        if ($this->request->isAJAX()) {

            $id_materi = $this->request->getVar('id_materi');

            $row = $this->ModelMateri->find($id_materi);


            $data = [
                'id_materi'     => $row['id_materi'],
                'id_kursus'     => $row['id_kursus'],
                'id_sub_kursus' => $row['id_sub_kursus'],
                'nama_file'     => $row['nama_file'],
                'ket'           => $row['ket'],
            ];

            $msg = [
                'success'  => view('guru/materi/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function lihatVideoMateri($id_materi, $id_kursus, $id_sub_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(5);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->find($id_materi),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/materi/v_lihat-video', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function kuis($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);


        $data = [
            'title'         => 'Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->tampilData($id_sub_kursus, $id_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/kuis/v_kuis', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function  tambahKuis($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Tambah Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/kuis/v_tambah-kuis', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function prosesTambahKuis()
    {
        $id_sub_kursus  = $this->request->getVar('id_sub_kursus');
        $id_kursus      = $this->request->getVar('id_kursus');


        // validasi
        if ($this->validate([
            'nama_kuis' => [
                'label' => 'Nama Kuis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'pertemuan' => [
                'label' => 'Pertemuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'max_size[file,1048]',
                'errors' => [
                    'max_size' => '{field} maksimal 1 MB..!!',
                ]
            ],
            'kuis' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
        ])) {

            $file = $this->request->getFile('file');

            if ($this->request->getVar('url') == '') {
                $url = null;
            } else {
                $url = htmlspecialchars($this->request->getVar('url'));
            }

            if ($file->getError() == 4) {
                $data = [
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'nama_kuis'         => htmlspecialchars($this->request->getVar('nama_kuis')),
                    'pertemuan'         => htmlspecialchars($this->request->getVar('pertemuan')),
                    'file'              => 'Tidak ada file',
                    'url'               => $url,
                    'kuis'              => $this->request->getVar('kuis'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];
            } else {
                $nama_file = $file->getRandomName();

                $data = [
                    'id_kursus'         => $id_kursus,
                    'id_sub_kursus'     => $id_sub_kursus,
                    'nama_kuis'         => htmlspecialchars($this->request->getVar('nama_kuis')),
                    'pertemuan'         => htmlspecialchars($this->request->getVar('pertemuan')),
                    'file'              => $nama_file,
                    'url'               => $url,
                    'kuis'              => $this->request->getVar('kuis'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelKuis->insert($data);

            session()->setFlashdata('pesan', 'Kuis baru berhasil dibuat...!!!');
            return redirect()->to('guru/kuis/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('guru/tambahKuis/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
        }
    }

    public function detailKuis()
    {
        if ($this->request->isAJAX()) {

            $id_kuis = $this->request->getVar('id_kuis');

            $row = $this->ModelKuis->tampilById($id_kuis);


            $data = [
                'id_kuis'       => $row['id_kuis'],
                'id_kursus'     => $row['id_kursus'],
                'id_sub_kursus' => $row['id_sub_kursus'],
                'nama_kuis'     => $row['nama_kuis'],
                'file'          => $row['file'],
                'kuis'          => $row['kuis'],
            ];

            $msg = [
                'success'  => view('guru/kuis/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function downloadFileKuis($id_kuis)
    {
        $kuis = $this->ModelKuis->find($id_kuis);

        return $this->response->download('assets/file/' . $kuis['file'], null);
    }

    public function lihatVideoKuis($id_kuis, $id_kursus, $id_sub_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->find($id_kuis),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('guru/kuis/v_lihat-video', $data);
    }

    public function editKuis($id_kuis, $id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(5);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(4);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Edit Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'kuis'          => $this->ModelKuis->tampilById($id_kuis),
            'validation'    => \Config\Services::validation()
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/kuis/v_edit-kuis', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function prosesEditKuis()
    {
        $id_kuis        = $this->request->getVar('id_kuis');
        $id_sub_kursus  = $this->request->getVar('id_sub_kursus');
        $id_kursus      = $this->request->getVar('id_kursus');


        // validasi
        if ($this->validate([
            'nama_kuis' => [
                'label' => 'Nama Kuis',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'pertemuan' => [
                'label' => 'Pertemuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'max_size[file,20024]',
                'errors' => [
                    'max_size' => 'Maksimal 20 MB.!!',
                ]
            ],
            'kuis' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong..!!',
                ]
            ],
        ])) {

            $file = $this->request->getFile('file');

            if ($file->getError() == 4) {
                $data = [
                    'nama_kuis'         => htmlspecialchars($this->request->getVar('nama_kuis')),
                    'pertemuan'         => htmlspecialchars($this->request->getVar('pertemuan')),
                    'kuis'              => $this->request->getVar('kuis'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];
            } else {
                $nama_file = $file->getRandomName();

                // hapus file 
                $kuis = $this->ModelKuis->find($id_kuis);

                if ($kuis['file'] != 'Tidak ada file') {
                    if ($kuis['file'] != "") {
                        unlink('assets/file/' . $kuis['file']);
                    }
                }

                $data = [
                    'nama_kuis'         => htmlspecialchars($this->request->getVar('nama_kuis')),
                    'pertemuan'         => htmlspecialchars($this->request->getVar('pertemuan')),
                    'file'              => $nama_file,
                    'kuis'              => $this->request->getVar('kuis'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelKuis->update($id_kuis, $data);

            session()->setFlashdata('pesan', 'Kuis berhasil diedit...!!!');
            return redirect()->to('guru/kuis/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('guru/editKuis/' . $id_kuis . '/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
        }
    }

    public function hapusKuis()
    {
        if ($this->request->isAJAX()) {
            $id_kuis = $this->request->getVar('id_kuis');


            // hapus file 
            $kuis = $this->ModelKuis->find($id_kuis);

            if ($kuis['file'] != 'Tidak ada file') {
                if ($kuis['file'] != "") {
                    unlink('assets/file/' . $kuis['file']);
                }
            }
            // hapus data 
            $this->ModelKuis->delete($id_kuis);

            $msg = [
                'success'  => "Kuis berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function nilai($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(3);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Nilai Siswa',
            'icon'          => '<i class="fa fa-file"></i>',
            'kuis'          => $this->ModelKuis->tampilData($id_sub_kursus, $id_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/nilai/v_kuis-penilaian', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function daftarNilai($id_kuis, $id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(5);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(4);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);

        $data = [
            'title'         => 'Daftar Nilai Mapel ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fa fa-file"></i>',
            'jawaban'       => $this->ModelJawaban->tampilJawabanById($id_kuis, $id_kursus, $id_sub_kursus),
            'nilai'         => $this->ModelJawaban->tampilNilaiById($id_kuis, $id_kursus, $id_sub_kursus),
            'id_kuis'       => $id_kuis,
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/nilai/v_daftar-nilai', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function lihatJawaban($id_jawaban, $id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(5);
        $uri_id_sub_kursus  = $this->request->uri->getSegment(4);

        $nip                = session()->get('username');
        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
        $sub_kursus         = $this->ModelSubKursus->tampilDataById($uri_id_sub_kursus);
        $guru               = $this->ModelGuru->tampilGuruByNip($nip);


        $data = [
            'title'         => 'Jawaban Mapel ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fa fa-file"></i>',
            'jawaban'       => $this->ModelJawaban->tampilJawabanByIdJawaban($id_jawaban),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        if ($kursus['id_guru'] == $guru['id_guru'] && $kursus['id_kursus'] == $sub_kursus['id_kursus']) {
            return view('guru/nilai/v_lihat-jawaban', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
        }
    }

    public function lihatSoal()
    {
        if ($this->request->isAJAX()) {

            $id_kuis        = $this->request->getVar('id_kuis');

            $row = $this->ModelKuis->tampilById($id_kuis);


            $data = [
                'id_kuis'       => $row['id_kuis'],
                'id_kursus'     => $row['id_kursus'],
                'id_sub_kursus' => $row['id_sub_kursus'],
                'nama_kuis'     => $row['nama_kuis'],
                'file'          => $row['file'],
                'url'           => $row['url'],
                'kuis'          => $row['kuis'],
            ];

            $msg = [
                'success'  => view('guru/kuis/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function downloadJawaban($id_jawaban)
    {
        $jawaban = $this->ModelJawaban->find($id_jawaban);

        return $this->response->download('assets/file/' . $jawaban['jwb_file'], null);
    }

    public function beriNilai()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nilai' => [
                    'label' => 'Nilai',
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
                        'nilai' => $validation->getError('nilai')
                    ]
                ];
            } else {

                $id_jawaban = $this->request->getVar('id_jawaban');

                $simpanData = [
                    'nilai' => htmlspecialchars($this->request->getVar('nilai'))
                ];

                // masukan ke dalam tabel 
                $this->ModelJawaban->update($id_jawaban, $simpanData);

                $msg = [
                    'success'  => 'Nilai berhasil disubmit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function cetakNilai($id_kuis, $id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);


        $data = [
            'title'         => 'Cetak Nilai' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fa fa-file"></i>',
            'nilai'         => $this->ModelJawaban->tampilJawabanById($id_kuis, $id_kursus, $id_sub_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'mapel'         => $kursus['mapel'],
            'kelas'         => $kursus['kelas'],
            'ta'            => $this->ModelTa->taAktif(),
        ];

        return  view('guru/nilai/v_cetak-nilai', $data);
    }

    public function hapusJawaban()
    {
        if ($this->request->isAJAX()) {

            $jawaban = $this->request->getVar('id_jawaban');

            // hapus file 
            $jawaban = $this->ModelJawaban->find($jawaban);

            if ($jawaban['jwb_file'] != 'Tidak ada file') {
                if ($jawaban['jwb_file'] != "") {
                    unlink('assets/file/' . $jawaban['jwb_file']);
                }
            }

            // hapus data 
            $this->ModelJawaban->delete($jawaban);

            $msg = [
                'success'  => "Jawaban berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function profil()
    {
        $data = [
            'title'         => 'Profil Saya',
            'icon'          => '<i class="fas fa-user"></i>',
            'profil'        => $this->ModelUser->tampilBySession(),
            'validation'    => \Config\Services::validation(),

        ];

        return view('guru/v_profil', $data);
    }

    public function formEditProfil()
    {
        if ($this->request->isAJAX()) {

            $id_user = $this->request->getVar('id_user');


            // memanggil id guru
            $guru = $this->ModelGuru->tampilByEmail(session()->get('email'));

            $id_guru = $guru['id_guru'];

            $row = $this->ModelUser->find($id_user);
            $data = [
                'id_guru'   => $id_guru,
                'id_user'   => $row['id_user'],
                'nama_user' => $row['nama_user'],
                'username'  => $row['username'],
                'email'     => $row['email'],
                'password'  => $row['password'],
            ];

            $msg = [
                'success'  => view('guru/v_modal-edit-profil', $data)
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
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[tb_guru.email, id_guru,{id_guru}]',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'      => $validation->getError('nama'),
                        'username'  => $validation->getError('username'),
                        'email'     => $validation->getError('email'),
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }


                $updateUser = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('username')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass
                ];

                $updateGuru = [
                    'nama_guru'     => htmlspecialchars($this->request->getVar('nama')),
                    'nip'           => htmlspecialchars($this->request->getVar('username')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass
                ];

                $id_user = $this->request->getVar('id_user');
                $id_guru = $this->request->getVar('id_guru');

                // masukan ke dalam tabel 
                $this->ModelUser->update($id_user, $updateUser);
                $this->ModelGuru->update($id_guru, $updateGuru);

                // $this->session->remove('nama_user');
                // $this->session->remove('username');
                // $this->session->remove('email');

                // ubah session
                $this->session->set('nama_user', $updateUser['nama_user']);
                $this->session->set('username', $updateUser['username']);
                $this->session->set('email', $updateUser['email']);

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

            $id_user = $this->request->getVar('id_user');

            // memanggil id guru
            $guru = $this->ModelGuru->tampilByEmail(session()->get('email'));

            $id_guru = $guru['id_guru'];

            $row = $this->ModelUser->find($id_user);
            $data = [
                'id_guru'  => $id_guru,
                'id_user'  => $row['id_user'],
                'foto'     => $row['foto']
            ];

            $msg = [
                'success'  => view('guru/v_modal-edit-foto-profil', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateFotoProfil()
    {
        if ($this->request->isAJAX()) {


            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'file' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[file]|mime_in[file,image/png,image/jpg,image/jpeg]|is_image[file]|max_size[file,1024]',
                    'errors' => [
                        'uploaded'  => '{field} tidak boleh kosong.!!',
                        'mime_in'   => 'Yang anda upload bukan format gambar.!!',
                        'max_size'  => 'Maksimal 1 MB.!!',
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
                $id_user = $this->request->getVar('id_user');
                $id_guru = $this->request->getVar('id_guru');

                // cek foto
                $cekdata = $this->ModelUser->find($id_user);
                $fotolama = $cekdata['foto'];
                if ($fotolama != 'default.png') {
                    unlink('assets/img/user/' . $fotolama);
                }

                $filefoto = $this->request->getFile('file');

                $filefoto->move('assets/img/user', $id_user . '.' . $filefoto->getExtension());

                $updateData = [
                    'foto' => $filefoto->getName()
                ];

                $this->ModelUser->update($id_user, $updateData);
                $this->ModelGuru->update($id_guru, $updateData);

                // ubah session foto
                $this->session->set('foto', $updateData['foto']);

                $msg = [
                    'success' => 'Foto profil berhasil diubah.!'
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

        return view('guru/chat/v_index', $data);
    }

    public function kirim()
    {
        $data = [
            'title'         => 'Kirim Pesan',
            'icon'          => '<i class="fas fa-comment"></i>',
            'user'          => $this->ModelUser->where('id_user !=', session()->get('id_user'))->findAll(),
        ];

        return view('guru/chat/v_kirim', $data);
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

        return view('guru/chat/v_pesan-keluar', $data);
    }

    public function lihatOutbox($id_chating)
    {

        $chat = $this->ModelChat->find($this->request->uri->getSegment(3));

        // dd($chat['id_pengirim']);

        $pesan      = $this->ModelChat->find($id_chating);

        $id_chating     = $pesan['id_chating'];

        // dd($pesan['id_pengirim'] . ' ' . $chat['id_pengirim']);

        $penerima   = $this->ModelUser->find($pesan['id_penerima']);
        $pengirim   = $this->ModelUser->find($pesan['id_pengirim']);

        // dd($chat['id_chating'] . ' ' . $pesan['id_chating']);

        $data = [
            'title'         => 'Pesan Keluar',
            'icon'          => '<i class="far fa-envelope"></i>',
            'pesan'         => $pesan,
            'penerima'      => $penerima,
            'pengirim'      => $pengirim,
        ];

        if ($chat['id_pengirim'] === session()->get('id_user')) {
            return view('guru/chat/v_pesan-keluar-detail', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
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

        return view('guru/chat/v_pesan-masuk', $data);
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
            return view('guru/chat/v_pesan-masuk-detail', $data);
        } else {
            $data2 = [
                'title' => 'Halaman Tidak Tersedia',
                'icon'  => ''
            ];
            return view('guru/v_forbidden', $data2);
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
