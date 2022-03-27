<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<?php
date_default_timezone_set('Asia/Jakarta');

// function tanggal indo
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

// echo date_default_timezone_get()


// menghitung jumlah pesan yang masuk

use App\Models\ModelChat;

$session = session();
$modelMessages = new ModelChat();
$count_inbox = $modelMessages->where('id_penerima', $session->id_user)
    ->where('is_read', 0)
    ->countAllResults();


?>


<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('chat/pesanMasuk') ?>" class="nav-link">
                        <i class="fas fa-inbox"></i> Pesan Masuk
                        <span class="badge bg-primary float-right"><?= ($count_inbox == 0) ? '' : $count_inbox ?></span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="<?= base_url('chat/pesanKeluar') ?>" class="nav-link">
                        <i class="far fa-envelope"></i> Pesan Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('chat/kirim') ?>" class="nav-link">
                        <i class="far fa-file-alt"></i> Kirim Pesan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-9">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Pesan Masuk</h3>
            <div class="card-tools">

            </div>

        </div>

        <div class="card-body">
            <div class="mailbox-controls table-responsive">

                <table class="table table-bordered">
                    <thead class="text-center thead-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Dari</th>
                            <th>Pesan</th>
                            <th>Tanggal Kirim</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($messages as $key => $message) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $message['nama'] ?></td>
                                <td>

                                    <a href="<?= base_url('chat/lihatInbox/' . $message['id_chating']) ?>"><?= $message['pesan'] ?></a>

                                </td>
                                <td class="text-center"><?= tanggal_indonesia($message['tanggal'], false) ?></td>
                                <td class="text-center"><?= ($message['dibaca'] == 0) ? '<span class="text-danger">Belum dibaca</span>' : '<span class="text-success">Dibaca</span>' ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?= $this->endsection(); ?>