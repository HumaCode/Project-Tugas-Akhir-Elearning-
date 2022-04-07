<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<?= $this->section('css'); ?>
<style>
    .detail {
        background-color: antiquewhite;
        border-radius: 20px;
    }

    .detail:hover {
        background-color: aqua;
        transition-duration: 1s;
    }
</style>
<?= $this->endsection(); ?>

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
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Preview Video</h3>
        </div>

        <div class="card-body">

            <div class="row">


                <div class="col-md-12">
                    <label for=""><strong>Keterangan :</strong></label>
                    <p class="text-justify">
                        <?= $materi['ket'] ?>
                    </p>
                </div>


                <div class="col-md-8">


                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" style="border-color: white;" src="https://www.youtube.com/embed/<?= $materi['url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 detail">
                        <table>
                            <tr>
                                <td width="100">Judul</td>
                                <td width="30">:</td>
                                <td><?= $materi['judul'] ?></td>
                            </tr>
                            <tr>
                                <td>Dibuat</td>
                                <td>:</td>
                                <td><?= tanggal_indonesia($materi['dibuat'], false) ?></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>
                                    Video
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('siswa/materi/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>