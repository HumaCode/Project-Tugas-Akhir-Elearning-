<?php

namespace App\Controllers;

use App\Models\ModelChat;
use App\Models\ModelUser;

class ChatSiswa extends BaseController
{
    public function __construct()
    {
        $this->ModelChat    = new ModelChat();
        $this->ModelUser    = new ModelUser();
    }

    public function index()
    {
        $data = [
            'title' => 'Chat',
            'icon' => '<i class="fas fa-comment"></i>'
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
                    'created'        =>  date('Y-m-d H:i:s'),
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
            'title'     => 'Pesan Keluar',
            'icon'      => '<i class="far fa-envelope"></i>',
            'messages'     => $messages,
        ];

        return view('siswa/chat/v_pesan-keluar', $data);
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
        ];

        return view('siswa/chat/v_pesan-masuk', $data);
    }

    public function lihatInbox($id_chating)
    {
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

        return view('siswa/chat/v_pesan-masuk-detail', $data);
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
                    'created'        =>  date('Y-m-d H:i:s'),
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

    public function lihat($id_chating)
    {
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

        return view('siswa/chat/v_pesan-keluar-detail', $data);
    }

    public function hapusChatKeluar()
    {
        if ($this->request->isAJAX()) {
            $id_chating = $this->request->getVar('id_chating');

            // hapus data 
            $this->ModelChat->delete($id_chating);

            $msg = [
                'success'  => "Chatting berhasil dihapus"
            ];

            echo json_encode($msg);
        } else {
            exit("Maaf permintaan tidak dapat di proses");
        }
    }
}
