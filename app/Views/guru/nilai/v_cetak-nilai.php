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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/dist/css/adminlte.min.css?v=3.2.0">

    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image*">

    <style>
        .nilai,
        .title,
        .nama,
        .tengah,
        .number {
            text-align: center;
        }

        .ttd {
            float: right;
        }


        hr {
            margin-top: 0px;
            height: 5px;
            background-color: black;
        }

        .t2 {
            padding: 8px;
        }
    </style>

</head>

<body>


    <div class="container">


        <div class="row">
            <div class="col-md-3 text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxi6bneJ6M18K9dMm7yPQRDQKT5pG6t8TPEQ&usqp=CAU" width="100" alt="">
            </div>

            <div class="col-md-5 offset-md-1 ">
                <p class="text-center" style="font-size: 22px; margin-bottom:0px;"><strong>PEMERINTAH KABUPATEN PEKALONGAN</strong></p>
                <p class="text-center" style="font-size: 22px; margin-bottom:0px;"><strong>DINAS PENDIDIKAN DAN KEBUDAYAAN</strong></p>
                <p class="text-center" style="font-size: 27px; margin-bottom:0px;"><strong>SD NEGERI 01 WIRODITAN</strong></p>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <small style=" margin-bottom:0px;">Alamat : Jl. Raya Raya Bojong No. 45 Bojong. Telp. (0285) 4482928 Pekalongan 51156 E-mail : sdn01wiroditan@gmail.com</small>
            </div>
        </div>


        <hr>
        <br>
        <br>

        <div class=" text-center mb-2">

            <h3>Nilai Siswa <?= $kelas ?> Matapelajaran <?= $mapel ?> </h3>
            <span>Tahun Pelajaran <?= $ta['tahun'] ?> Semester <?= $ta['semester'] ?></span>
        </div>

        <table class="table table-bordered">
            <thead class="text-center bg-secondary">
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Nilai</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                foreach ($nilai as $n) { ?>
                    <tr>
                        <td class="text-center"><?= $i ?>.</td>
                        <td><?= $n['nama_siswa'] ?></td>
                        <td width="200" class="text-center"><?= $n['nis'] ?></td>
                        <td width="200" class="text-center"><?= ($n['nilai'] == 'Belum dinilai') ? '0' : $n['nilai'] ?></td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>

        <small>* KKM 65.</small>

        <br>
        <br>
        <br>
        <br>

        <div class="row">
            <div class="col-md-8 offset-md-3">
                <table class="float-right">
                    <tr>
                        <td></td>
                        <td style="text-align: center;">
                            Bojong, <?= tanggal_indonesia(date('Y-m-d'), false); ?>
                            <br>
                            <br>
                            <br>
                            <br>

                            <?= session()->get('nama_user') ?>
                            <br>
                            NIP : <?= session()->get('username') ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <script data-cfasync="false" src="<?= base_url() ?>/assets/vendor/adminLTE3/email-decode.min.js"></script>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>