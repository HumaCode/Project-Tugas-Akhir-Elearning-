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

$format = substr($materi['nama_file'], -4);

?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Lihat Materi</h3>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-8 ">

                    <?php if ($format == 'file') { ?>
                        <div class="p-3 text-justify">
                            <?= $materi['ket'] ?>
                        </div>
                    <?php } else if ($format == 'pptx' || $format == '.ppt') {  ?>
                        <div class="row ">
                            <div class="col-md-4 text-center ">

                                <img src="<?= base_url('assets/img/powerpoint.png') ?>" class="img-fluid" alt="">

                            </div>
                            <div class="col-md-8">

                                <p class="text-justify"><?= $materi['ket'] ?></p>

                            </div>
                        </div>
                    <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>
                        <div class="row ">
                            <div class="col-md-4 text-center ">

                                <img src="<?= base_url('assets/img/jpg.png') ?>" class="img-fluid " alt="">

                            </div>
                            <div class="col-md-8">

                                <p class="text-justify"><?= $materi['ket'] ?></p>

                            </div>
                        </div>
                    <?php } else if ($format == 'docx' || $format == '.doc' || $format == '.pdf') { ?>
                        <div class="row">
                            <div class="col-md-4 text-center">

                                <img src="<?= base_url('assets/img/document.png') ?>" class="img-fluid" alt="">

                            </div>
                            <div class="col-md-8">

                                <p class="text-justify"><?= $materi['ket'] ?></p>

                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="col-md-4 ">
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
                                    <?php if ($format == 'file') { ?>
                                        Tidak Menggunakan File
                                    <?php } else if ($format == 'pptx' || $format == '.ppt') { ?>
                                        Powerpoint
                                    <?php } else if ($format == 'docx' || $format == '.doc' || $format == '.pdf') { ?>
                                        Document
                                    <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>
                                        Gambar
                                    <?php } else if ($format == '.mp4') { ?>
                                        Video
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if ($format != 'file') { ?>
                                        <a href="<?= base_url('siswa/downloadFileMateri/' . $id_materi) ?>"> Download File</a>
                                    <?php } ?>
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