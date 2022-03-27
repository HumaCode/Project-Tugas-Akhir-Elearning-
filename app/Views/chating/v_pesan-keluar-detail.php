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

?>

<div class="col-md-12">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Detail Pesan Keluar</h3>
        </div>
        <div class="card-body ">
            <table>
                <tr>
                    <td width="100"><strong>Dari</strong></td>
                    <td width="20"><strong>:</strong></td>
                    <td><strong><?= $pengirim['nama_user'] ?></strong></td>
                </tr>

                <tr>
                    <td width="100"><strong>Ke</strong></td>
                    <td width="20"><strong>:</strong></td>
                    <td><strong><?= $penerima['nama_user'] ?></strong></td>
                </tr>
            </table>
            <hr>
            <table>
                <tr>
                    <td width="100">Pesan</td>
                    <td width="20">:</td>
                    <td><?= $pesan['pesan'] ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="<?= base_url('chat/pesanKeluar') ?>" class="btn btn-danger btn-sm btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>