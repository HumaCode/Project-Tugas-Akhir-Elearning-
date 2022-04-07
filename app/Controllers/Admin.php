<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAbsensi;
use App\Models\ModelAdmin;
use App\Models\ModelAnggota;
use App\Models\ModelChat;
use App\Models\ModelGuru;
use App\Models\ModelGuruServerside;
use App\Models\ModelJawaban;
use App\Models\ModelKelas;
use App\Models\ModelKelasServerside;
use App\Models\ModelKritik;
use App\Models\ModelKritikServerside;
use App\Models\ModelKuis;
use App\Models\ModelKursus;
use App\Models\ModelMapel;
use App\Models\ModelMapelServerside;
use App\Models\ModelMateri;
use App\Models\ModelSetting;
use App\Models\ModelSiswa;
use App\Models\ModelSiswaServerside;
use App\Models\ModelSubKursus;
use App\Models\ModelTa;
use App\Models\ModelTaServerside;
use App\Models\ModelUser;
use App\Models\ModelUserServerside;
use Config\Services;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->ModelMapel       = new ModelMapel();
        $this->ModelGuru        = new ModelGuru();
        $this->ModelKelas       = new ModelKelas();
        $this->ModelUser        = new ModelUser();
        $this->ModelSiswa       = new ModelSiswa();
        $this->ModelSetting     = new ModelSetting();
        $this->ModelKritik      = new ModelKritik();
        $this->ModelKursus      = new ModelKursus();
        $this->ModelSubKursus   = new ModelSubKursus();
        $this->ModelMateri      = new ModelMateri();
        $this->ModelTa          = new ModelTa();
        $this->ModelAnggota     = new ModelAnggota();
        $this->ModelKuis        = new ModelKuis();
        $this->ModelAdmin       = new ModelAdmin();
        $this->ModelJawaban     = new ModelJawaban();
        $this->ModelAbsensi     = new ModelAbsensi();
        $this->ModelChat        = new ModelChat();
    }

    public function index()
    {
        $data = [
            'title'                 => 'Dashboard',
            'icon'                  => '<i class="fas fa-tachometer-alt"></i>',
            'jmlGuru'               => $this->ModelAdmin->jmlGuru(),
            'jmlSiswa'              => $this->ModelAdmin->jmlSiswa(),
            'jmlUser'               => $this->ModelAdmin->jmlUser(),
            'jmlKursus'             => $this->ModelAdmin->jmlKursus()
        ];

        return view('admin/v_dashboard', $data);
    }

    public function guru()
    {
        $data = [
            'title' => 'Daftar Guru',
            'icon' => '<i class="fas fa-user-tie"></i>',
        ];

        return view('admin/guru/v_guru', $data);
    }

    public function ambilDataGuru()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/guru/v_tampil-guru')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataGuruServerside()
    {
        $request = Services::request();
        $datamodel = new ModelGuruServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $guru = ($list->is_active == 1) ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>';



                $row[] = "<center> " . $no . ". </center>";
                $row[] = $list->nama_guru;
                $row[] = $list->nip;
                $row[] = $list->email;
                $row[] = "<center>
                            <ul class=\"list-inline\">
                                <li class=\"list-inline-item\">
                                    <img src=\"" . base_url('assets/img/user/' . $list->foto . '?id=' . $list->id_guru) . "\" class=\"img-fluid mb-3 table-avatar\" alt=\"white sample\"/>
                                </li>
                            </ul>
                        </center>
                ";
                $row[] = "<center>$guru</center>";
                $row[] = "<center><button type=\"button\" class=\"btn btn-info btn-xs btn-flat\" onclick=\"detail('" . $list->id_guru . "')\"><i class=\"fas fa-eye\"></i>&nbsp; Detail</button> <button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_guru . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_guru . "', '" . $list->nama_guru . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function detailGuru()
    {
        if ($this->request->isAJAX()) {

            $id_guru = $this->request->getVar('id_guru');

            $row = $this->ModelGuru->find($id_guru);


            $data = [
                'nama_guru'    => $row['nama_guru'],
                'nip'           => $row['nip'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'foto'          => $row['foto'],
                'is_active'     => $row['is_active'],
            ];

            $msg = [
                'success'  => view('admin/guru/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formImportGuru()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('admin/guru/v_modal-import')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function uploadFileExcelGuru()
    {
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'fileExcel' => [
                'label' => 'Input File',
                'rules' => 'uploaded[fileExcel]|ext_in[fileExcel,xls,xlsx]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'ext_in' => 'Yang anda upload bukan format excel',
                ]
            ]
        ]);

        if (!$valid) {
            $error = [
                'error' => $validation->getError('fileExcel')
            ];

            $this->session->setFlashdata($error);

            return redirect()->to('/admin/guru');
        } else {

            $file_excel = $this->request->getFile('fileExcel');

            $ext = $file_excel->getClientExtension();

            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file_excel);

            // ambil sheet yg aktif
            $data  = $spreadsheet->getActiveSheet()->toArray();
            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue;
                }

                $nama_guru  = $row[1];
                $nip        = $row[2];
                $email      = $row[3];
                $password   = $row[4];


                // simpan ke database
                $db = \Config\Database::connect();

                $dataGuru = [
                    'nama_guru'     => $nama_guru,
                    'nip'           => $nip,
                    'email'         => $email,
                    'password'      => password_hash($password, PASSWORD_BCRYPT),
                    'foto'          => 'default.png',
                    'role'          => 2,
                    'is_active'     => 1,
                ];

                $dataUser = [
                    'nama_user'     => $nama_guru,
                    'username'      => $nip,
                    'email'         => $email,
                    'password'      => password_hash($password, PASSWORD_BCRYPT),
                    'role'          => 2,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                    'created_at'    => date('Y-m-d H:m:s'),
                    'updated_at'    => date('Y-m-d H:m:s'),
                ];

                $db->table('tb_guru')->insert($dataGuru);
                $db->table('tb_user')->insert($dataUser);
            }
            $this->session->setFlashdata('pesan', 'Berhasil menginport data');
            return redirect()->to('/admin/guru');
        }
    }

    public function formTambahGuru()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('admin/guru/v_modal-tambah')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanGuru()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Guru',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|is_unique[tb_guru.nip]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[tb_guru.email]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'min_length' => '{field} minimal 8 karakter..!!',
                    ]
                ],
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'      => $validation->getError('nama'),
                        'nip'       => $validation->getError('nip'),
                        'email'     => $validation->getError('email'),
                        'password'  => $validation->getError('password'),
                    ]
                ];
            } else {
                $simpanUser = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('nip')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'role'          => 2,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                ];

                $simpanGuru = [
                    'nama_guru'     => $this->request->getVar('nama'),
                    'nip'           => $this->request->getVar('nip'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'foto'          => 'default.png',
                    'role'          => 2,
                    'is_active'     => 1,
                ];


                // masukan ke dalam tabel 
                $this->ModelGuru->tambah($simpanGuru);
                $this->ModelUser->insert($simpanUser);

                $msg = [
                    'success'  => 'Data user berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditGuru()
    {
        if ($this->request->isAJAX()) {

            $id_guru = $this->request->getVar('id_guru');

            $row = $this->ModelGuru->find($id_guru);


            $data = [
                'id_guru'      => $row['id_guru'],
                'nama_guru'    => $row['nama_guru'],
                'nip'           => $row['nip'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'foto'          => $row['foto'],
                'is_active'     => $row['is_active'],
            ];

            $msg = [
                'success'  => view('admin/guru/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateGuru()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Guru',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[tb_guru.email, id_guru, {id_guru}]',
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
                        'nama'          => $validation->getError('nama'),
                        'email'         => $validation->getError('email'),
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }

                if ($this->request->getVar('is_active') == 1) {
                    $active = 1;
                } else {
                    $active = 0;
                }

                $updateData = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('nip')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass,
                    'is_active'     => $active,
                ];

                $updateGuru = [
                    'nama_guru'    => $this->request->getVar('nama'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => $pass,
                    'is_active'     => $active,
                ];

                $id_guru = $this->request->getVar('id_guru');
                $username = $this->request->getVar('nip');


                // masukan ke dalam tabel 
                $this->ModelGuru->editGuru($id_guru, $updateGuru);
                $this->ModelUser->editUser($username, $updateData);

                $msg = [
                    'success'  => 'Data guru berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusGuru()
    {
        if ($this->request->isAJAX()) {
            $id_guru = $this->request->getVar('id_guru');

            $data = $this->ModelGuru->find($id_guru);
            $nama_guru = $data['nama_guru'];
            $username = $data['nip'];

            // hapus foto 

            if ($data['foto'] != "default.png") {
                unlink('assets/img/user/' . $data['foto']);
            }


            // hapus data 
            $this->ModelGuru->hapusGuru($id_guru);
            $this->ModelUser->hapusUser($username);

            $msg = [
                'success'  => "$nama_guru berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function siswa()
    {
        $data = [
            'title' => 'Daftar Siswa',
            'icon' => '<i class="fas fa-user-alt"></i>',
        ];

        return view('admin/siswa/v_siswa', $data);
    }

    public function ambilDataSiswa()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/siswa/v_tampil-siswa')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataSiswaServerside()
    {
        $request = Services::request();
        $datamodel = new ModelSiswaServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $user = ($list->is_active == 1) ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>';
                $email = ($list->email == null || $list->email == '-') ? '<center>-</center>' : $list->email;

                $kelas =  ($list->kelas_id == 0) ? '<center><span class="text-danger">Belum dilengkapi</span></center>' : $list->kelas;


                $row[] = "<center> " . $no . ". </center>";
                $row[] = $list->nama_siswa;
                $row[] = $list->nis;
                $row[] = $email;
                $row[] = "<center>
                            <ul class=\"list-inline\">
                                <li class=\"list-inline-item\">
                                    <img src=\"" . base_url('assets/img/user/' . $list->foto . '?text=' . $list->id_siswa) . "\" class=\"img-fluid mb-2 table-avatar\" alt=\"white sample\"/>
                                </li>
                            </ul>
                        </center>
                ";
                $row[] = "<center>$kelas</center>";
                $row[] = "<center>$user</center>";
                $row[] = "<center><button type=\"button\" class=\"btn btn-info btn-xs btn-flat\" onclick=\"detail('" . $list->id_siswa . "')\"><i class=\"fas fa-eye\"></i>&nbsp; Detail</button> <button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_siswa . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_siswa . "', '" . $list->nama_siswa . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function detailSiswa()
    {
        if ($this->request->isAJAX()) {

            $id_siswa = $this->request->getVar('id_siswa');

            $row = $this->ModelSiswa->joinTabel($id_siswa);


            $data = [
                'nama_siswa'    => $row['nama_siswa'],
                'nis'           => $row['nis'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'foto'          => $row['foto'],
                'is_active'     => $row['is_active'],
                'kelas_id'      => $row['kelas'],
            ];

            $msg = [
                'success'  => view('admin/siswa/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formImportSiswa()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('admin/siswa/v_modal-import')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function uploadFileExcelSiswa()
    {
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'file' => [
                'label' => 'Input File',
                'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'ext_in' => 'Yang anda upload bukan format excel',
                ]
            ]
        ]);

        if (!$valid) {
            $error = [
                'error' => $validation->getError('file')
            ];

            $this->session->setFlashdata($error);

            return redirect()->to('/admin/siswa');
        } else {

            $file_excel = $this->request->getFile('file');

            $ext = $file_excel->getClientExtension();

            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file_excel);

            // ambil sheet yg aktif
            $data  = $spreadsheet->getActiveSheet()->toArray();
            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue;
                }

                $nama_siswa = $row[1];
                $nis        = $row[2];
                $email      = $row[3];
                $password   = $row[4];
                $kelas      = $row[5];

                $k = $this->ModelKelas->tampilByKelas($kelas);
                $kelas_id = $k['id_kelas'];

                // simpan ke database
                $db = \Config\Database::connect();

                $dataSiswa = [
                    'nama_siswa'    => $nama_siswa,
                    'nis'           => $nis,
                    'email'         => $email,
                    'password'      => password_hash($password, PASSWORD_BCRYPT),
                    'role'          => 3,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                    'kelas_id'      => $kelas_id,
                ];

                $dataUser = [
                    'nama_user'     => $nama_siswa,
                    'username'      => $nis,
                    'email'         => $email,
                    'password'      => password_hash($password, PASSWORD_BCRYPT),
                    'role'          => 3,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                    'created_at'    => date('Y-m-d H:m:s'),
                    'updated_at'    => date('Y-m-d H:m:s'),
                ];

                $db->table('tb_siswa')->insert($dataSiswa);
                $db->table('tb_user')->insert($dataUser);
            }
            $this->session->setFlashdata('pesan', 'Berhasil menginport data');
            return redirect()->to('/admin/siswa');
        }
    }

    public function formTambahSiswa()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kls' => $this->ModelKelas->tampilSemua()
            ];

            $msg = [
                'data' => view('admin/siswa/v_modal-tambah', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanSiswa()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'nis' => [
                    'label' => 'NIS',
                    'rules' => 'required|is_unique[tb_siswa.nis]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'min_length' => '{field} minimal 8 karakter..!!',
                    ]
                ],
                'kls' => [
                    'label' => 'Kelas',
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
                        'nama'      => $validation->getError('nama'),
                        'nis'       => $validation->getError('nis'),
                        'password'  => $validation->getError('password'),
                        'kls'       => $validation->getError('kls'),
                    ]
                ];
            } else {
                $email = htmlspecialchars($this->request->getVar('email'));
                if ($email == null) {
                    $e = '-';
                } else {
                    $e = htmlspecialchars($this->request->getVar('email'));
                }

                $simpanUser = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('nis')),
                    'email'         => $e,
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'role'          => 3,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                ];

                $simpanSiswa = [
                    'nama_siswa'    => $this->request->getVar('nama'),
                    'nis'           => $this->request->getVar('nis'),
                    'email'         => $e,
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'role'          => 3,
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                    'kelas_id'     => $this->request->getPost('kls'),
                ];

                // masukan ke dalam tabel 
                $this->ModelUser->insert($simpanUser);
                $this->ModelSiswa->tambah($simpanSiswa);

                $msg = [
                    'success'  => 'Data siswa berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditSiswa()
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
                'foto'          => $row['foto'],
                'kelas_id'      => $row['kelas_id'],
                'is_active'     => $row['is_active'],
                'kelas'         => $this->ModelKelas->findAll()
            ];

            $msg = [
                'success'  => view('admin/siswa/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateSiswa()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'nis' => [
                    'label' => 'NIS',
                    'rules' => 'required|is_unique[tb_siswa.nis, id_siswa,{id_siswa}]',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan siswa lain..!!',
                    ]
                ],
                'kelas' => [
                    'label' => 'Kelas',
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
                        'nama'      => $validation->getError('nama'),
                        'nis'       => $validation->getError('nis'),
                        'password'  => $validation->getError('password'),
                        'kelas'     => $validation->getError('kelas'),
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }

                if ($this->request->getVar('is_active') == 1) {
                    $active = 1;
                } else {
                    $active = 0;
                }

                $updateData = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('nis')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass,
                    'is_active'     => $active,
                ];

                $updateSiswa = [
                    'nama_siswa'    => $this->request->getVar('nama'),
                    'nis'           => $this->request->getVar('nis'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => $pass,
                    'is_active'     => $active,
                    'kelas_id'     => $this->request->getVar('kelas'),
                ];

                $id_siswa = $this->request->getVar('id_siswa');
                $username = $this->request->getVar('nis');


                // masukan ke dalam tabel 
                $this->ModelSiswa->editSiswa($id_siswa, $updateSiswa);
                $this->ModelUser->editUser($username, $updateData);

                $msg = [
                    'success'  => 'Data user berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusSiswa()
    {
        if ($this->request->isAJAX()) {
            $id_siswa = $this->request->getVar('id_siswa');

            $data = $this->ModelSiswa->find($id_siswa);
            $nama_siswa = $data['nama_siswa'];
            $username = $data['nis'];

            // hapus foto 

            if ($data['foto'] != "default.png") {
                unlink('assets/img/user/' . $data['foto']);
            }

            // hapus data 
            $this->ModelSiswa->hapusSiswa($id_siswa);
            $this->ModelUser->hapusUser($username);

            $msg = [
                'success'  => "$nama_siswa berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function user()
    {
        $data = [
            'title' => 'Daftar User',
            'icon' => '<i class="fas fa-users"></i>',
        ];

        return view('admin/user/v_user', $data);
    }

    public function ambilDataUser()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('admin/user/v_tampil-user')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataUserServerside()
    {
        $request = Services::request();
        $datamodel = new ModelUserServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                if ($list->role == 1) {
                    $status = "<span class=\"badge bg-cyan\">Admin</span>";
                } else if ($list->role == 2) {
                    $status = "<span class=\"badge bg-success\">Guru</span>";
                } else {
                    $status = "<span class=\"badge bg-secondary\">Siswa</span>";
                }

                $user = ($list->is_active == 1) ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>';
                $email = ($list->email == null || $list->email == '-') ? '<center>-</center>' : $list->email;


                $row[] = "<center> " . $no . ". </center>";
                $row[] = $list->nama_user;
                $row[] = $list->username;
                $row[] = "<center>
                            <ul class=\"list-inline\">
                                <li class=\"list-inline-item\">
                                    <img src=\"" . base_url('assets/img/user/' . $list->foto . '?text=' . $list->id_user) . "\" class=\"img-fluid mb-2 table-avatar\" alt=\"white sample\"/>
                                </li>
                            </ul>
                        </center>
                ";

                $row[] = $email;
                $row[] = "<center>$status</center>";
                $row[] = "<center>$user</center>";
                $row[] = "<center><button type=\"button\" class=\"btn btn-info btn-xs btn-flat\" onclick=\"detail('" . $list->id_user . "')\"><i class=\"fas fa-eye\"></i>&nbsp; Detail</button> <button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_user . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_user . "', '" . $list->nama_user . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function detailUser()
    {
        if ($this->request->isAJAX()) {

            $id_user = $this->request->getVar('id_user');

            $row = $this->ModelUser->find($id_user);


            $data = [
                'nama_user'     => $row['nama_user'],
                'username'      => $row['username'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'role'          => $row['role'],
                'foto'          => $row['foto'],
                'is_active'     => $row['is_active'],
                'created_at'    => $row['created_at'],
            ];

            $msg = [
                'success'  => view('admin/user/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formTambahUser()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/user/v_modal-tambah')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanUser()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[tb_user.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'min_length' => '{field} minimal 8 karakter..!!',
                    ]
                ],
                'role' => [
                    'label' => 'Role',
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
                        'nama'      => $validation->getError('nama'),
                        'username'  => $validation->getError('username'),
                        'email'     => $validation->getError('email'),
                        'password'  => $validation->getError('password'),
                        'role'      => $validation->getError('role'),
                    ]
                ];
            } else {

                $simpanUser = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('username')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'role'          => $this->request->getVar('role'),
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                ];

                $simpanSiswa = [
                    'nama_siswa'    => $this->request->getVar('nama'),
                    'nis'           => $this->request->getVar('username'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'role'          => $this->request->getVar('role'),
                    'foto'          => 'default.png',
                    'is_active'     => 1,
                ];

                $simpanGuru = [
                    'nama_guru'     => $this->request->getVar('nama'),
                    'nip'           => $this->request->getVar('username'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'foto'          => 'default.png',
                    'role'          => $this->request->getVar('role'),
                    'is_active'     => 1,
                ];

                $level = $this->request->getVar('role');
                // masukan ke dalam tabel 
                if ($level == 1) {
                    $this->ModelUser->insert($simpanUser);
                } else if ($level == 2) {
                    $this->ModelUser->insert($simpanUser);
                    $this->ModelGuru->insert($simpanGuru);
                } else {
                    $this->ModelUser->insert($simpanUser);
                    $this->ModelSiswa->insert($simpanSiswa);
                }

                $msg = [
                    'success'  => 'Data user berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditUser()
    {
        if ($this->request->isAJAX()) {

            $id_user = $this->request->getVar('id_user');

            $row = $this->ModelUser->find($id_user);


            $data = [
                'id_user'       => $row['id_user'],
                'nama_user'     => $row['nama_user'],
                'username'      => $row['username'],
                'email'         => $row['email'],
                'password'      => $row['password'],
                'role'          => $row['role'],
                'foto'          => $row['foto'],
                'is_active'     => $row['is_active'],
            ];

            $msg = [
                'success'  => view('admin/user/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateUser()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama User',
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
                    'rules' => 'is_unique[tb_user.email, id_user,{id_user}]',
                    'errors' => [
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ],
                'role' => [
                    'label' => 'Role',
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
                        'nama'      => $validation->getError('nama'),
                        'username'  => $validation->getError('username'),
                        'email'     => $validation->getError('email'),
                        'password'  => $validation->getError('password'),
                        'role'      => $validation->getError('role'),
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }

                if ($this->request->getVar('is_active') == 1) {
                    $active = 1;
                } else {
                    $active = 0;
                }

                $updateData = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('username')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass,
                    'role'          => $this->request->getVar('role'),
                    'is_active'     => $active,
                ];

                $updateSiswa = [
                    'nama_siswa'    => $this->request->getVar('nama'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => $pass,
                    'role'          => $this->request->getVar('role'),
                    'is_active'     => $active,
                ];

                $updateGuru = [
                    'nama_guru'    => $this->request->getVar('nama'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => $pass,
                    'role'          => $this->request->getVar('role'),
                    'is_active'     => $active,
                ];

                $id_user = $this->request->getVar('id_user');
                $nis = $this->request->getVar('username');
                $nip = $this->request->getVar('username');
                $level = $this->request->getVar('role');


                // masukan ke dalam tabel 
                if ($level == 1) {
                    $this->ModelUser->update($id_user, $updateData);
                } else if ($level == 2) {
                    $this->ModelUser->update($id_user, $updateData);
                    $this->ModelGuru->edit($nip, $updateGuru);
                } else {
                    $this->ModelUser->update($id_user, $updateData);
                    $this->ModelSiswa->edit($nis, $updateSiswa);
                }

                $msg = [
                    'success'  => 'Data user berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusUser()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');


            $data = $this->ModelUser->find($id_user);

            $nama_user  = $data['nama_user'];

            $username   = $data['username'];
            $nip        = $data['username'];



            $guru   = $this->ModelGuru->tampilGuruByNip($nip);
            $siswa  = $this->ModelSiswa->tampilSiswaByUsername($username);

            // dd($siswa['id_siswa']);

            // hapus foto 
            if ($data['foto'] != "default.png") {
                unlink('assets/img/user/' . $data['foto']);
            }

            // hapus data 
            if ($data['role'] == 1) {
                $this->ModelUser->delete($id_user);
            } else if ($data['role'] == 2) {
                $id_guru = $guru['id_guru'];

                $this->ModelUser->delete($id_user);
                $this->ModelGuru->hapus($id_guru);
            } else {
                $id_siswa = $siswa['id_siswa'];

                $this->ModelUser->delete($id_user);
                $this->ModelSiswa->delete($id_siswa);
            }

            $msg = [
                'success'  => "$nama_user berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formImportUser()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/user/v_modal-import')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function mapel()
    {
        $data = [
            'title' => 'Daftar Matapelajaran',
            'icon' => '<i class="fas fa-book"></i>',
            'tampildata' => $this->ModelKelas->findAll()
        ];

        return view('admin/mapel/v_mapel', $data);
    }

    public function ambilDataMapel()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'tampildata' => $this->ModelMapel->orderBy('id_mapel', 'desc')->findAll()
            ];

            $msg = [
                'data' => view('admin/mapel/v_tampil-mapel', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataMapelServerside()
    {
        $request = Services::request();
        $datamodel = new ModelMapelServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $row[] = " <input type=\"checkbox\" name=\"id_mapel[]\" class=\"centangMapel\" value=\" $list->id_mapel  \">";
                $row[] = "<center> " . $no . ". </center>";
                $row[] = $list->mapel;
                $row[] = "<center><button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_mapel . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_mapel . "', '" . $list->mapel . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function formTambahMapel()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/mapel/v_modal-tambah')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanMapel()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'mapel' => [
                    'label' => 'Matapelajaran',
                    'rules' => 'required|is_unique[tb_mapel.mapel]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah ada..!!'
                    ]
                ]
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'mapel' => $validation->getError('mapel')
                    ]
                ];
            } else {
                $simpanData = [
                    'mapel' => htmlspecialchars($this->request->getVar('mapel'))
                ];

                // masukan ke dalam tabel 
                $this->ModelMapel->insert($simpanData);

                $msg = [
                    'success'  => 'Data mapel berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditMapel()
    {
        if ($this->request->isAJAX()) {

            $id_mapel = $this->request->getVar('id_mapel');

            $row = $this->ModelMapel->find($id_mapel);
            $data = [
                'id_mapel'  => $row['id_mapel'],
                'mapel'     => $row['mapel']
            ];

            $msg = [
                'success'  => view('admin/mapel/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateMapel()
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
                ]
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'mapel' => $validation->getError('mapel')
                    ]
                ];
            } else {
                $updateData = [
                    'mapel' => htmlspecialchars($this->request->getVar('mapel'))
                ];

                $id_mapel = $this->request->getVar('id_mapel');

                // masukan ke dalam tabel 
                $this->ModelMapel->update($id_mapel, $updateData);

                $msg = [
                    'success'  => 'Data mapel berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusMapel()
    {
        if ($this->request->isAJAX()) {
            $id_mapel = $this->request->getVar('id_mapel');

            $data = $this->ModelMapel->find($id_mapel);
            $mapel = $data['mapel'];

            // hapus data 
            $this->ModelMapel->delete($id_mapel);

            $msg = [
                'success'  => "$mapel berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusMapelBanyak()
    {
        if ($this->request->isAJAX()) {
            $id_mapel = $this->request->getVar('id_mapel');

            // hitung jumlahnya
            $jmlData = count($id_mapel);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelMapel->delete($id_mapel[$i]);
            }

            $msg = [
                'success' => "$jmlData data mapel berhasil dihapus."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formTambahMapelBanyak()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/mapel/v_form-tambah-banyak')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanDataMapelBanyak()
    {
        if ($this->request->isAJAX()) {

            $mapel = $this->request->getVar('mapel');

            // hitung jumlahnya
            $jmlData = count($mapel);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelMapel->insert([
                    'mapel' => $mapel[$i],
                ]);
            }

            $msg = [
                'success' => "$jmlData data mapel berhasil ditambahkan."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function kelas()
    {
        $data = [
            'title' => 'Daftar Kelas',
            'icon' => '<i class="fas fa-certificate"></i>',
            'tampildata' => $this->ModelKelas->findAll()
        ];

        return view('admin/kelas/v_kelas', $data);
    }

    public function ambilDataKelas()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'tampildata' => $this->ModelKelas->orderBy('id_kelas', 'desc')->findAll()
            ];

            $msg = [
                'data' => view('admin/kelas/v_tampil-kelas', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataKelasServerside()
    {
        $request = Services::request();
        $datamodel = new ModelKelasServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $row[] = " <input type=\"checkbox\" name=\"id_kelas[]\" class=\"centangKelas\" value=\" $list->id_kelas  \">";
                $row[] = "<center> " . $no . ". </center>";
                $row[] = $list->kelas;
                $row[] = "<center><button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_kelas . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_kelas . "', '" . $list->kelas . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function formTambahKelas()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/kelas/v_modal-tambah')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanKelas()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelas' => [
                    'label' => 'Kelas',
                    'rules' => 'required|is_unique[tb_kelas.kelas]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah ada..!!'
                    ]
                ]
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'kelas' => $validation->getError('kelas')
                    ]
                ];
            } else {
                $simpanData = [
                    'kelas' => htmlspecialchars($this->request->getVar('kelas'))
                ];

                // masukan ke dalam tabel 
                $this->ModelKelas->insert($simpanData);

                $msg = [
                    'success'  => 'Data kelas berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditKelas()
    {
        if ($this->request->isAJAX()) {

            $id_kelas = $this->request->getVar('id_kelas');

            $row = $this->ModelKelas->find($id_kelas);
            $data = [
                'id_kelas'  => $row['id_kelas'],
                'kelas'     => $row['kelas']
            ];

            $msg = [
                'success'  => view('admin/kelas/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateKelas()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelas' => [
                    'label' => 'Kelas',
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
                        'kelas' => $validation->getError('kelas')
                    ]
                ];
            } else {
                $updateData = [
                    'kelas' => htmlspecialchars($this->request->getVar('kelas'))
                ];

                $id_kelas = $this->request->getVar('id_kelas');

                // masukan ke dalam tabel 
                $this->ModelKelas->update($id_kelas, $updateData);

                $msg = [
                    'success'  => 'Data kelas berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusKelas()
    {
        if ($this->request->isAJAX()) {
            $id_kelas = $this->request->getVar('id_kelas');

            $data = $this->ModelKelas->find($id_kelas);
            $kelas = $data['kelas'];

            // hapus data 
            $this->ModelKelas->delete($id_kelas);

            $msg = [
                'success'  => "$kelas berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formTambahKelasBanyak()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/kelas/v_form-tambah-banyak')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanDataBanyak()
    {
        if ($this->request->isAJAX()) {

            $kelas = $this->request->getVar('kelas');

            // hitung jumlahnya
            $jmlData = count($kelas);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelKelas->insert([
                    'kelas' => $kelas[$i],
                ]);
            }

            $msg = [
                'success' => "$jmlData data kelas berhasil ditambahkan."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusKelasBanyak()
    {
        if ($this->request->isAJAX()) {
            $id_kelas = $this->request->getVar('id_kelas');

            // hitung jumlahnya
            $jmlData = count($id_kelas);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelKelas->delete($id_kelas[$i]);
            }

            $msg = [
                'success' => "$jmlData data kelas berhasil dihapus."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function ta()
    {
        $data = [
            'title' => 'Tahun Pelajaran',
            'icon' => '<i class="fas fa-certificate"></i>',
            'tampildata' => $this->ModelTa->findAll()
        ];

        return view('admin/ta/v_ta', $data);
    }

    public function ambilDataTa()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'tampildata' => $this->ModelTa->orderBy('tahun', 'desc')->findAll()
            ];

            $msg = [
                'data' => view('admin/ta/v_tampil-ta', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function tampilDataTaServerside()
    {
        $request = Services::request();
        $datamodel = new ModelTaServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                if ($list->status == 0) {
                    $tombol = "<a href=\" " . base_url('admin/statusAktif/' . $list->id_ta) . " \" class=\"btn btn-xs btn-flat btn-success\">Aktifkan</a>";
                } else {
                    $tombol = "<a href=\" # \" class=\"btn btn-xs btn-flat btn-danger\" style=\"cursor:not-allowed;\">Nonaktifkan</a>";
                }

                $row[] = " <input type=\"checkbox\" name=\"id_ta[]\" class=\"centangTa\" value=\" $list->id_ta  \">";
                $row[] = "<center> " . $no . ". </center>";
                $row[] = "<center> " . $list->tahun . "</center> ";
                $row[] = "<center> " . $list->semester . "</center> ";
                $row[] = "<center> " . $tombol . "</center> ";
                $row[] = "<center><button type=\"button\" class=\"btn btn-warning btn-xs btn-flat\" onclick=\"edit('" . $list->id_ta . "')\"><i class=\"fas fa-pencil-alt\"></i>&nbsp; Edit</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_ta . "', '" . $list->tahun . "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function statusAktif($id_ta)
    {
        $data = [
            'status' => 1
        ];

        // reset status
        $this->ModelTa->resetStatus();


        $this->ModelTa->aktifkan($id_ta, $data);

        // flashdata
        session()->setFlashdata('pesan', 'Tahun pelajaran berhasil diaktifkan');
        return redirect()->to('/admin/ta');
    }

    public function formTambahTa()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/ta/v_modal-tambah')
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function simpanTa()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'tahun' => [
                    'label' => 'Tahun',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'semester' => [
                    'label' => 'Semester',
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
                        'tahun'     => $validation->getError('tahun'),
                        'semester'  => $validation->getError('semester')
                    ]
                ];
            } else {
                $simpanData = [
                    'tahun' => htmlspecialchars($this->request->getVar('tahun')),
                    'semester' => htmlspecialchars($this->request->getVar('semester')),
                ];

                // masukan ke dalam tabel 
                $this->ModelTa->insert($simpanData);

                $msg = [
                    'success'  => 'Data tahun pelajaran berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function formEditTa()
    {
        if ($this->request->isAJAX()) {

            $id_ta = $this->request->getVar('id_ta');

            $row = $this->ModelTa->find($id_ta);
            $data = [
                'id_ta'         => $row['id_ta'],
                'tahun'         => $row['tahun'],
                'semester'      => $row['semester'],
            ];

            $msg = [
                'success'  => view('admin/ta/v_modal-edit', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateTa()
    {
        if ($this->request->isAJAX()) {

            // validasi 
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'tahun' => [
                    'label' => 'Tahun',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong..!!',
                    ]
                ],
                'semester' => [
                    'label' => 'Semester',
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
                        'tahun' => $validation->getError('tahun'),
                        'semester' => $validation->getError('semester'),
                    ]
                ];
            } else {
                $updateData = [
                    'tahun' => htmlspecialchars($this->request->getVar('tahun')),
                    'semester' => htmlspecialchars($this->request->getVar('semester')),
                ];

                $id_ta = $this->request->getVar('id_ta');

                // masukan ke dalam tabel 
                $this->ModelTa->update($id_ta, $updateData);

                $msg = [
                    'success'  => 'Data tahun pelajaran berhasil diedit'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusTa()
    {
        if ($this->request->isAJAX()) {
            $id_ta = $this->request->getVar('id_ta');

            $data = $this->ModelTa->find($id_ta);
            $statusTa = $data['status'];

            if ($statusTa == 1) {
                $msg = [
                    'error'  => "Tahun pelajaran masih aktif"
                ];
            } else {
                // hapus data 
                $this->ModelTa->delete($id_ta);

                $msg = [
                    'success'  => "Tahun pelajaran berhasil dihapus"
                ];
            }


            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusTaBanyak()
    {
        if ($this->request->isAJAX()) {
            $id_ta = $this->request->getVar('id_ta');



            // hitung jumlahnya
            $jmlData = count($id_ta);


            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelTa->delete($id_ta[$i]);
            }
            $msg = [
                'success' => "$jmlData data tahun pelajaran berhasil dihapus."
            ];



            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function kursus()
    {

        // cari data berdasarkan pencarian 
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $kursus = $this->ModelKursus->search($keyword);
        } else {
            $kursus = $this->ModelKursus->tampilData();
        }


        $data = [
            'title'         => 'Daftar Kursus',
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'validation'    => \Config\Services::validation(),
            'kursus'        => $kursus,
        ];

        return view('admin/kursus/v_kursus', $data);
    }

    public function formTambahKursus()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'mapel' => $this->ModelMapel->findAll(),
                'kelas' => $this->ModelKelas->where('id_kelas !=', 0)->findAll(),
                'guru' => $this->ModelGuru->findAll()
            ];

            $msg = [
                'data' => view('admin/kursus/v_modal-tambah', $data)
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
                'guru' => [
                    'label' => 'Guru',
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
                        'mapel'      => $validation->getError('mapel'),
                        'kelas'       => $validation->getError('kelas'),
                        'guru'     => $validation->getError('guru'),
                    ]
                ];
            } else {
                $simpanKursus = [
                    'id_mapel'          => htmlspecialchars($this->request->getVar('mapel')),
                    'id_kelas'          => htmlspecialchars($this->request->getVar('kelas')),
                    'id_guru'           => htmlspecialchars($this->request->getVar('guru')),
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
                'mapel' => $this->ModelMapel->findAll(),
                'kelas' => $this->ModelKelas->where('id_kelas !=', 0)->findAll(),
                'guru' => $this->ModelGuru->findAll()
            ];

            $msg = [
                'success'  => view('admin/kursus/v_modal-edit', $data)
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
                'guru' => [
                    'label' => 'Guru',
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
                        'mapel' => $validation->getError('mapel'),
                        'kelas' => $validation->getError('kelas'),
                        'guru' => $validation->getError('guru'),
                    ]
                ];
            } else {
                $updateData = [
                    'id_mapel' => htmlspecialchars($this->request->getVar('mapel')),
                    'id_kelas' => htmlspecialchars($this->request->getVar('kelas')),
                    'id_guru' => htmlspecialchars($this->request->getVar('guru')),
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

    public function lihatAnggota($id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $k = $kursus['mapel'];
        $row = $this->ModelKursus->tampilDataById($id_kursus);

        $kursusKelas = $row['id_kelas'];

        $data = [
            'title'         => 'Daftar Anggota Kursus ' . $k,
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'kursusId'      => $this->ModelKursus->tampilDataById($id_kursus),
            'anggota'       => $this->ModelAnggota->tampilDataById($id_kursus),
            'siswaByKelas'  => $this->ModelSiswa->tampilSiswaByKelas($kursusKelas),
        ];

        return view('admin/kursus/v_anggota', $data);
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
                'success'  => view('admin/kursus/v_modal-tambah-anggota', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
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

    public function simpanAnggotaKelas($id_kursus)
    {

        $anggota = $this->request->getVar('anggota');


        $this->ModelAnggota->tambahAnggota($id_kursus, $anggota);


        return redirect()->to(base_url('admin/lihatAnggota/' . $id_kursus));
    }

    public function updateAnggota()
    {
        $id_kursus = $this->request->getVar('edit_id');

        $anggota = $this->request->getVar('anggota_edit');

        $this->ModelAnggota->updateAnggota($id_kursus, $anggota);

        return redirect()->to(base_url('admin/lihatAnggota/' . $id_kursus));
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

    public function subKursus($id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $k = $kursus['mapel'];

        $ta_aktif = $this->ModelTa->taAktif();

        $id_ta = $ta_aktif['id_ta'];


        $data = [
            'title'     => 'Kursus ' . $k,
            'icon'      => '<i class="fas fa-graduation-cap"></i>',
            'kursus'    => $kursus,
            'id_kursus' => $id_kursus,
            'ta'        => $ta_aktif,
            'subKursus' => $this->ModelSubKursus->tampilSemua($id_kursus, $id_ta)
        ];

        return view('admin/kursus/v_sub-kursus', $data);
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
                'success' => view('admin/kursus/v_modal-tambahSubKursus', $data)
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
                ],
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'sesi'  => $validation->getError('sesi'),
                        'tipe'  => $validation->getError('tipe'),
                        'mulai' => $validation->getError('mulai'),
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
                'success'  => view('admin/kursus/v_modal-editSubKursus', $data)
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
                    'label' => 'Tanggal Mulai',
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
                        'sesi'  => $validation->getError('sesi'),
                        'tipe'  => $validation->getError('tipe'),
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

    public function absensiSiswa($id_sub_kursus, $id_kursus)
    {
        $uri_id_kursus      = $this->request->uri->getSegment(4);

        $kursus             = $this->ModelKursus->tampilDataById($uri_id_kursus);
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



        return view('admin/absensi/v_absensi', $data);
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
                'success'  => view('admin/absensi/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function materi($id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->tampilData($id_sub_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('admin/materi/v_materi', $data);
    }

    public function tambahMateri($id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Tambah Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'validation'    => \Config\Services::validation()
        ];

        return view('admin/materi/v_tambah-materi', $data);
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
            return redirect()->to('admin/materi/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('admin/tambahMateri/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
        }
    }

    public function downloadFileMateri($id_materi)
    {
        $materi = $this->ModelMateri->find($id_materi);

        return $this->response->download('assets/file/' . $materi['nama_file'], null);
    }

    public function editMateri($id_materi, $id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Edit Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'materi'        => $this->ModelMateri->find($id_materi),
            'validation'    => \Config\Services::validation()
        ];

        return view('admin/materi/v_edit-materi', $data);
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
            'ket' => [
                'label' => 'Keterangan',
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
            return redirect()->to('admin/materi/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('admin/editMateri/' . $id_materi . '/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
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
                'url'           => $row['url'],
                'ket'           => $row['ket'],
            ];

            $msg = [
                'success'  => view('admin/materi/v_modal-detail', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function lihatVideoMateri($id_materi, $id_kursus, $id_sub_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);


        $data = [
            'title'         => 'Materi ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'materi'        => $this->ModelMateri->find($id_materi),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('admin/materi/v_lihat-video', $data);
    }

    public function hapusMateri()
    {
        if ($this->request->isAJAX()) {
            $id_materi = $this->request->getVar('id_materi');


            // hapus file 
            $materi = $this->ModelMateri->find($id_materi);

            if ($materi['nama_file'] != 'Tidak ada file') {
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

    public function kuis($id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'kuis'          => $this->ModelKuis->tampilData($id_sub_kursus, $id_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('admin/kuis/v_kuis', $data);
    }

    public function  tambahKuis($id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Tambah Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'validation'    => \Config\Services::validation()
        ];

        return view('admin/kuis/v_tambah-kuis', $data);
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
            return redirect()->to('admin/kuis/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('admin/tambahKuis/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
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
                'success'  => view('admin/kuis/v_modal-detail', $data)
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

        return view('admin/kuis/v_lihat-video', $data);
    }

    public function editKuis($id_kuis, $id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Edit Kuis ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fas fa-graduation-cap"></i>',
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
            'kuis'          => $this->ModelKuis->tampilById($id_kuis),
            'validation'    => \Config\Services::validation()
        ];

        return view('admin/kuis/v_edit-kuis', $data);
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
                    'nama_kuis'         => htmlspecialchars($this->request->getVar('nama_kuis')),
                    'pertemuan'         => htmlspecialchars($this->request->getVar('pertemuan')),
                    'file'              => 'Tidak ada file',
                    'url'               => $url,
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
                    'url'               => $url,
                    'kuis'              => $this->request->getVar('kuis'),
                    'dibuat'            => date('Y-m-d H:i:s')
                ];

                // masukan ke folder
                $file->move('assets/file', $nama_file);
            }

            // masukan ke dalam model
            $this->ModelKuis->update($id_kuis, $data);

            session()->setFlashdata('pesan', 'Kuis berhasil diedit...!!!');
            return redirect()->to('admin/kuis/'  . $id_sub_kursus . '/' . $id_kursus);
        } else {
            // jika tidak valid
            return redirect()->to('admin/editKuis/' . $id_kuis . '/' . $id_sub_kursus . '/' . $id_kursus)->withInput();
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

    public function lihatNilai($id_sub_kursus, $id_kursus)
    {
        $kursus = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Nilai Siswa ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fa fa-file"></i>',
            'nilai'         => $this->ModelAdmin->tampilKuisByIdSubKursus($id_sub_kursus, $id_kursus),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('admin/kuis/v_lihat-nilai', $data);
    }

    public function daftarNilai($id_kuis, $id_sub_kursus, $id_kursus)
    {

        $kursus             = $this->ModelKursus->tampilDataById($id_kursus);

        $data = [
            'title'         => 'Daftar Nilai Mapel ' . $kursus['mapel'] . ' ' . $kursus['kelas'],
            'icon'          => '<i class="fa fa-file"></i>',
            'jawaban'       => $this->ModelJawaban->tampilJawabanById($id_kuis, $id_kursus, $id_sub_kursus),
            'nilai'         => $this->ModelJawaban->tampilNilaiById($id_kuis, $id_kursus, $id_sub_kursus),
            'kuis'          => $this->ModelKuis->tampilById($id_kuis),
            'id_kursus'     => $id_kursus,
            'id_sub_kursus' => $id_sub_kursus,
        ];

        return view('admin/nilai/v_daftar-nilai', $data);
    }


    public function downloadJawaban($id_jawaban)
    {
        $jawaban = $this->ModelJawaban->find($id_jawaban);

        return $this->response->download('assets/file/' . $jawaban['jwb_file'], null);
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

        return  view('admin/nilai/v_cetak-nilai', $data);
    }



    public function profil()
    {
        $id_user = session()->get('id_user');

        $data = [
            'title'     => 'Profil Saya',
            'icon'      => '<i class="fas fa-user"></i>',
            'profil'    => $this->ModelUser->find($id_user),
        ];

        return view('admin/v_profil', $data);
    }

    public function formEditProfil()
    {
        if ($this->request->isAJAX()) {

            $id_user = $this->request->getVar('id_user');

            $row = $this->ModelUser->find($id_user);
            $data = [
                'id_user'   => $row['id_user'],
                'nama_user' => $row['nama_user'],
                'username'  => $row['username'],
                'email'     => $row['email'],
                'password'  => $row['password'],
            ];

            $msg = [
                'success'  => view('admin/v_modal-edit-profil', $data)
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
                    'rules' => 'required|is_unique[tb_user.email, id_user,{id_user}]',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong..!!',
                        'is_unique' => '{field} sudah digunakan user lain..!!',
                    ]
                ]
            ]);

            // jika tidak valid
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'      => $validation->getError('nama'),
                        'username'  => $validation->getError('username'),
                        'email'     => $validation->getError('email')
                    ]
                ];
            } else {

                if ($this->request->getVar('password') == null) {
                    $pass = $this->request->getVar('passLama');
                } else {
                    $pass = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
                }

                $updateData = [
                    'nama_user'     => htmlspecialchars($this->request->getVar('nama')),
                    'username'      => htmlspecialchars($this->request->getVar('username')),
                    'email'         => htmlspecialchars($this->request->getVar('email')),
                    'password'      => $pass
                ];

                $id_user = $this->request->getVar('id_user');

                // masukan ke dalam tabel 
                $this->ModelUser->update($id_user, $updateData);

                // ubah session
                $this->session->set('nama_user', $updateData['nama_user']);
                $this->session->set('username', $updateData['username']);
                $this->session->set('email', $updateData['email']);

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

            $row = $this->ModelUser->find($id_user);
            $data = [
                'id_user'  => $row['id_user'],
                'foto'     => $row['foto']
            ];

            $msg = [
                'success'  => view('admin/v_modal-edit-foto-profil', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateFotoProfil()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');

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
                $cekdata = $this->ModelUser->find($id_user);
                $fotolama = $cekdata['foto'];
                if ($fotolama != 'default.png') {
                    unlink('assets/img/user/' . $fotolama);
                }

                $filefoto = $this->request->getFile('file');

                $filefoto->move('assets/img/user', $id_user . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => $filefoto->getName()
                ];

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

    public function setting()
    {
        $id_setting = 1;
        $data = [
            'title'         => 'Setting',
            'icon'          => '<i class="fas fa-cog"></i>',
            'validation'    => \Config\Services::validation(),
            'setting'       => $this->ModelSetting->find($id_setting),
            'kritik'        => $this->ModelKritik->findAll(),
        ];

        return view('admin/v_setting', $data);
    }

    public function tampilDataKritikServerside()
    {
        function tanggal_indonesia($tgl, $tampil_hari = true)
        {
            $nama_hari = array(
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
            );

            $nama_bulan = array(
                1 =>
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );

            // format tanggal php
            //  2021-11-26

            $tahun = substr($tgl, 0, 4);
            $bulan = $nama_bulan[(int) substr($tgl, 5, 2)];
            $tanggal = substr($tgl, 8, 2);
            $text = '';

            if ($tampil_hari) {
                $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
                $hari = $nama_hari[$urutan_hari];
                $text .= "$hari, $tanggal $bulan $tahun";
            } else {
                $text .= "$tanggal $bulan $tahun";
            }
            return $text;
        }

        $request = Services::request();
        $datamodel = new ModelKritikServerside($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $email = ($list->email == '' || $list->email == null) ? 'Anonim' : $list->email;

                $row[] = " <input type=\"checkbox\" name=\"id_kritik[]\" class=\"centangKritik\" value=\" $list->id_kritik  \">";
                $row[] = "<center> " . $no . ". </center>";
                $row[] = $email;
                $row[] = tanggal_indonesia($list->created_at, false);
                $row[] = "<center><button type=\"button\" class=\"btn btn-info btn-xs btn-flat\" onclick=\"detail('" . $list->id_kritik . "')\"><i class=\"fa fa-eye\"></i>&nbsp; Detail</button> <button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"hapus('" . $list->id_kritik .  "')\"><i class=\"fas fa-trash\"></i>&nbsp; Hapus</button></center> ";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function detailKritik()
    {
        if ($this->request->isAJAX()) {

            $id_kritik = $this->request->getVar('id_kritik');

            $row = $this->ModelKritik->find($id_kritik);


            $data = [
                'kritik'     => $row['kritik'],
                'saran'      => $row['saran'],
            ];

            $msg = [
                'success'  => view('admin/v_modal-detail-kritik', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function ubahSetingan($id_setting)
    {
        if ($this->validate([
            'foto' => [
                'label' => 'Foto',
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/png,image/jpg]',
                'errors' => [
                    'max_size' => 'Ukuran {field} maksimal 1 Mb',
                    'mime_in' => '{field} yang anda upload bukan foto..!!',
                ]
            ]
        ])) {

            $file = $this->request->getFile('foto');

            if ($file->getError() == 4) {
                $data = [
                    'desk1'             => htmlspecialchars($this->request->getVar('desk1')),
                    'desk2'             => htmlspecialchars($this->request->getVar('desk2')),
                    'desk3'             => htmlspecialchars($this->request->getVar('desk3')),
                    'desk3'             => htmlspecialchars($this->request->getVar('desk3')),
                    'desk4'             => htmlspecialchars($this->request->getVar('desk4')),
                    'nama_sekolah'      => htmlspecialchars($this->request->getVar('nama_sekolah')),
                    'npsn'              => htmlspecialchars($this->request->getVar('npsn')),
                    'jenjang'           => htmlspecialchars($this->request->getVar('jenjang')),
                    'status_sekolah'    => htmlspecialchars($this->request->getVar('status_sekolah')),
                    'alamat'            => htmlspecialchars($this->request->getVar('alamat')),
                    'rt'                => htmlspecialchars($this->request->getVar('rt')),
                    'rw'                => htmlspecialchars($this->request->getVar('rw')),
                    'kd_pos'            => htmlspecialchars($this->request->getVar('kd_pos')),
                    'kelurahan'         => htmlspecialchars($this->request->getVar('kelurahan')),
                    'kecamatan'         => htmlspecialchars($this->request->getVar('kecamatan')),
                    'kabupaten'         => htmlspecialchars($this->request->getVar('kabupaten')),
                    'email'             => htmlspecialchars($this->request->getVar('email')),
                    'fb'                => htmlspecialchars($this->request->getVar('fb')),
                    'tlp'               => htmlspecialchars($this->request->getVar('tlp')),
                    'map'               => htmlspecialchars($this->request->getVar('map')),
                ];
            } else {



                $nama_file = $file->getRandomName();

                $setting = $this->ModelSetting->find($id_setting);

                $logo_lama = $setting['logo'];

                if ($logo_lama != '') {
                    unlink('assets/img/' . $logo_lama);
                }


                $data = [
                    'desk1'             => htmlspecialchars($this->request->getVar('desk1')),
                    'desk2'             => htmlspecialchars($this->request->getVar('desk2')),
                    'desk3'             => htmlspecialchars($this->request->getVar('desk3')),
                    'desk3'             => htmlspecialchars($this->request->getVar('desk3')),
                    'desk4'             => htmlspecialchars($this->request->getVar('desk4')),
                    'nama_sekolah'      => htmlspecialchars($this->request->getVar('nama_sekolah')),
                    'npsn'              => htmlspecialchars($this->request->getVar('npsn')),
                    'jenjang'           => htmlspecialchars($this->request->getVar('jenjang')),
                    'status_sekolah'    => htmlspecialchars($this->request->getVar('status_sekolah')),
                    'alamat'            => htmlspecialchars($this->request->getVar('alamat')),
                    'rt'                => htmlspecialchars($this->request->getVar('rt')),
                    'rw'                => htmlspecialchars($this->request->getVar('rw')),
                    'kd_pos'            => htmlspecialchars($this->request->getVar('kd_pos')),
                    'kelurahan'         => htmlspecialchars($this->request->getVar('kelurahan')),
                    'kecamatan'         => htmlspecialchars($this->request->getVar('kecamatan')),
                    'kabupaten'         => htmlspecialchars($this->request->getVar('kabupaten')),
                    'email'             => htmlspecialchars($this->request->getVar('email')),
                    'fb'                => htmlspecialchars($this->request->getVar('fb')),
                    'tlp'               => htmlspecialchars($this->request->getVar('tlp')),
                    'map'               => htmlspecialchars($this->request->getVar('map')),
                    'logo'              => $nama_file,
                ];

                // upload logo
                $file->move('assets/img/', $nama_file);
            }


            $this->ModelSetting->update($id_setting, $data);

            // tampilkan flashdata
            session()->setFlashdata('pesan', 'Setting berhasil diubah..');
            return redirect()->to('admin/setting');
        } else {
            // jika error
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to('/admin/setting');
        }
    }

    public function formEditGambarSekolah()
    {
        if ($this->request->isAJAX()) {

            $id_setting = $this->request->getVar('id_setting');

            $row = $this->ModelSetting->find($id_setting);
            $data = [
                'id_setting'   => $row['id_setting'],
                'foto' => $row['foto'],
            ];

            $msg = [
                'success'  => view('admin/v_modal-edit-foto-sekolah', $data)
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function updateFotoSekolah()
    {
        if ($this->request->isAJAX()) {
            $id_setting = $this->request->getVar('id_setting');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]|max_size[foto,1524]',
                    'errors' => [
                        'uploaded' => '{field} tidak boleh kosong.!!',
                        'mime_in' => 'Yang anda upload bukan format gambar.!!',
                        'max_size' => 'Maksimal 1.5 MB.!!',
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('foto')
                    ]
                ];
            } else {
                // cek foto
                $cekdata = $this->ModelSetting->find($id_setting);
                $fotolama = $cekdata['foto'];
                if ($fotolama != null || $fotolama != '') {
                    unlink('assets/img/' . $fotolama);
                }

                $filefoto = $this->request->getFile('foto');
                $f = date('Ymd');

                $filefoto->move('assets/img/', $f . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => $filefoto->getName()
                ];

                $this->ModelSetting->update($id_setting, $updatedata);


                $msg = [
                    'success' => 'Foto berhasil diubah'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusKritik()
    {
        if ($this->request->isAJAX()) {
            $id_kritik = $this->request->getVar('id_kritik');

            // hapus data 
            $this->ModelKritik->delete($id_kritik);

            $msg = [
                'success'  => "Data berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }

    public function hapusKritikBanyak()
    {
        if ($this->request->isAJAX()) {
            $id_kritik = $this->request->getVar('id_kritik');

            // hitung jumlahnya
            $jmlData = count($id_kritik);

            for ($i = 0; $i < $jmlData; $i++) {
                $this->ModelKritik->delete($id_kritik[$i]);
            }

            $msg = [
                'success' => "$jmlData data berhasil dihapus."
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }



    // chatting

    public function chat()
    {
        $data = [
            'title'         => 'Chat',
            'icon'          => '<i class="fas fa-comment"></i>',
            'count_inbox'   => $this->ModelChat->where('id_penerima', session()->get('id_user'))->where('is_read', 0)->countAllResults(),
        ];

        return view('admin/chat/v_index', $data);
    }

    public function kirim()
    {
        $data = [
            'title'         => 'Kirim Pesan',
            'icon'          => '<i class="fas fa-comment"></i>',
            'user'          => $this->ModelUser->where('id_user !=', session()->get('id_user'))->findAll(),
        ];

        return view('admin/chat/v_kirim', $data);
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

        return view('admin/chat/v_pesan-keluar', $data);
    }

    public function lihatOutbox($id_chating)
    {
        $chat = $this->ModelChat->find($this->request->uri->getSegment(3));
        $pesan      = $this->ModelChat->find($id_chating);
        $penerima   = $this->ModelUser->find($pesan['id_penerima']);
        $pengirim   = $this->ModelUser->find($pesan['id_pengirim']);

        $data = [
            'title'         => 'Pesan Keluar',
            'icon'          => '<i class="far fa-envelope"></i>',
            'pesan'         => $pesan,
            'penerima'      => $penerima,
            'pengirim'      => $pengirim,

        ];

        if ($chat['id_pengirim'] === session()->get('id_user')) {
            return view('admin/chat/v_pesan-keluar-detail', $data);
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

        return view('admin/chat/v_pesan-masuk', $data);
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
            return view('admin/chat/v_pesan-masuk-detail', $data);
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
