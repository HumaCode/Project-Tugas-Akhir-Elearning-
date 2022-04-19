<?= $this->extend('layouts/template-backend'); ?>

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

    .ti {
        border-bottom: 2px solid;
        width: 100%;
    }
</style>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>

<?php


$format = substr($jawaban['jwb_file'], -4);

?>

<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title"><strong><?= $jawaban['nama_siswa'] ?></strong> | <?= $jawaban['sub_kursus'] ?></h3>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-8">

                    <?php if ($format == 'file') { ?>
                        <div class="row detail p-2">
                            <h4 class="ti">Jawaban : </h4>

                            <div class="col-md-12">

                                <p class="text-justify"><?= $jawaban['jawaban'] ?></p>
                            </div>
                        </div>

                    <?php } else if ($format == 'docx' || $format == '.dox') { ?>
                        <div class="row">
                            <div class="col-md-4 text-center">

                                <img src="<?= base_url('assets/img/document.png') ?>" class="img-fluid" alt="">

                            </div>
                            <div class="col-md-8">

                                <p class="text-justify"><?= $jawaban['jawaban'] ?></p>

                            </div>
                        </div>
                    <?php } else if ($format == 'pptx' || $format == '.ppt') { ?>
                        <div class="row">
                            <div class="col-md-4 text-center">

                                <img src="<?= base_url('assets/img/powerpoint.png') ?>" class="img-fluid" alt="">

                            </div>
                            <div class="col-md-8">

                                <p class="text-justify"><?= $jawaban['jawaban'] ?></p>

                            </div>
                        </div>
                    <?php } else if ($format == '.pdf') { ?>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">

                                    <iframe src="<?= base_url('assets/file/' . $jawaban['jwb_file']) ?>" height="1350px">
                                    </iframe>

                                </div>
                            </div>
                        </div>
                    <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>
                        <div class="row">


                            <p class="text-justify"><?= $jawaban['jawaban'] ?></p>
                            <div class="col-md-12 text-center ">

                                <div class="filter-item" data-category="1" data-sort="white sample">
                                    <a href="<?= base_url('assets/file/' . $jawaban['jwb_file']) ?>" data-toggle="lightbox" data-title="<?= $jawaban['nama_kuis'] ?>">
                                        <img src="<?= base_url('assets/file/' . $jawaban['jwb_file']) ?>" class="img-fluid mb-2" alt="white sample" />
                                    </a>
                                </div>

                            </div>
                        </div>

                    <?php } else if ($format == '.mp4') { ?>
                        <div class="row">
                            <p class="text-justify"><?= $jawaban['jawaban'] ?></p>
                            <div class="col-md-12 text-center">

                                <video class="img-fluid " style="border-radius: 30px;" controls>
                                    <source src="<?= base_url('assets/file/' . $jawaban['jwb_file']) ?>" type="video/mp4">
                                </video>

                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="col-md-4 ">
                    <div class="card p-3 detail">
                        <table>
                            <tr>
                                <td>Dikirim</td>
                                <td>:</td>
                                <td><?= tanggal_indonesia($jawaban['dikirim'], false) ?></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>
                                    <?php if ($format == 'file') { ?>
                                        Tidak Menggunakan File
                                    <?php } else if ($format == 'docx' || $format == '.doc') { ?>
                                        Document
                                    <?php } else if ($format == '.ppt' || $format == 'pptx') { ?>
                                        Powerpoint
                                    <?php } else if ($format == '.pdf') { ?>
                                        PDF
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
                                        <a href="<?= base_url('guru/downloadJawaban/' . $jawaban['id_jawaban']) ?>"> Download File</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>
                    <?= form_open('guru/beriNilai', ['class' => 'formNilai']) ?>
                    <?= csrf_field() ?>

                    <input type="hidden" name="id_jawaban" id="id_jawaban" value="<?= $jawaban['id_jawaban'] ?>">

                    <label for=""><?= ($jawaban['nilai'] == 'Belum dinilai') ? 'Nilai Sekarang' : 'Siswa sudah dinilai' ?></label>
                    <div class="form-row align-items-center">
                        <div class="col-sm-6 my-1">

                            <label class="sr-only" for="nilai">Nilai</label>
                            <input type="number" min="1" name="nilai" class="form-control " id="nilai" placeholder="<?= $jawaban['nilai'] ?>">
                            <div class="invalid-feedback errorNilai"></div>
                        </div>
                        <div class="col-auto my-1">
                            <?php if ($jawaban['nilai'] == 'Belum dinilai') {  ?>
                                <button type="submit" class="btn btn-primary btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Submit</button>
                            <?php } else { ?>
                                <button type="submit" class="btn btn-success btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Edit</button>
                            <?php } ?>
                        </div>
                    </div>

                    <?= form_close() ?>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="<?= base_url('guru/daftarNilai/' . $jawaban['id_kuis'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');
    })

    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });

    $(document).ready(function() {
        $('.formNilai').submit(function() {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSimpan').attr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnSimpan').removeAttr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fas fa-save"></i>&nbsp; Submit');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nilai) {
                            $('#nilai').addClass('is-invalid');
                            $('.errorNilai').html(response.error.nilai);
                        } else {
                            $('#nilai').remove('is-invalid');
                            $('.errorNilai').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
            return false;
        })
    })
</script>

<?= $this->endsection(); ?>