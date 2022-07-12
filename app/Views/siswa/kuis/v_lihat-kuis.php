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

$format = substr($kuis['file'], -4);

?>

<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

<div class="col-md-12">
    <?php if ($jawaban == 0) { ?>

        <div class="card card-outline card-cyan">
            <div class="card-header">
                <h3 class="card-title">Lihat Kuis</h3>
            </div>

            <div class="card-body">

                <div class="row">
                    <?php if ($format == '.pdf') { ?>
                        <div class="col-md-12 m-auto">

                            <div class="card">

                                <iframe src="<?= base_url('assets/file/' . $kuis['file']) ?>" height="1000">
                                </iframe>
                            </div>

                        </div>
                    <?php } ?>

                    <div class="col-md-8 ">

                        <?php if ($format == 'file') { ?>
                            <div class="p-3 text-justify">
                                <?= $kuis['kuis'] ?>
                            </div>
                        <?php } else if ($format == 'pptx' || $format == '.ppt') {  ?>
                            <div class="row ">
                                <div class="col-md-4 text-center ">

                                    <img src="<?= base_url('assets/img/powerpoint.png') ?>" class="img-fluid" alt="">

                                </div>
                                <div class="col-md-8">

                                    <p class="text-justify"><?= $kuis['kuis'] ?></p>

                                </div>
                            </div>
                        <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>
                            <div class="row ">
                                <p class="text-justify"><?= $kuis['kuis'] ?></p>
                                <div class="col-md-6 m-auto">

                                    <div class="filter-item" data-category="1" data-sort="white sample">
                                        <a href="<?= base_url('assets/file/' . $kuis['file']) ?>" data-toggle="lightbox" data-title="<?= $kuis['nama_kuis'] ?>">
                                            <img src="<?= base_url('assets/file/' . $kuis['file']) ?>" class="img-fluid mb-2" alt="white sample" />
                                        </a>
                                    </div>

                                </div>
                            </div>

                        <?php } else if ($format == 'docx' || $format == '.doc') { ?>
                            <div class="row">
                                <div class="col-md-4 text-center">

                                    <img src="<?= base_url('assets/img/document.png') ?>" class="img-fluid" alt="">

                                </div>
                                <div class="col-md-8">

                                    <p class="text-justify"><?= $kuis['kuis'] ?></p>

                                </div>
                            </div>

                        <?php } ?>

                    </div>
                    <?php if ($format != '.pdf') { ?>
                        <div class="col-md-4 ">
                            <div class="card p-3 detail">
                                <table>
                                    <tr>
                                        <td width="100">Judul</td>
                                        <td width="30">:</td>
                                        <td><?= $kuis['nama_kuis'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dibuat</td>
                                        <td>:</td>
                                        <td><?= tanggal_indonesia($kuis['dibuat'], false) ?></td>
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
                                                <a href="<?= base_url('siswa/downloadFileKuis/' . $id_kuis) ?>"> Download File</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <hr>
                <hr>

                <?= form_open_multipart('siswa/jawab') ?>
                <?= csrf_field() ?>

                <input type="hidden" name="id_kuis" id="id_kuis" value="<?= $id_kuis ?>">
                <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">
                <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">

                <div class="form-group">
                    <label for="jawab">Lembar Jawab</label>
                    <textarea name="jawab" id="jawab" class="form-control" rows="3" style="border-radius: 0px;"></textarea>
                    <p class="text-danger err"><strong><?= $validation->hasError('jawab') ? $validation->getError('jawab') : '' ?></strong></p>
                </div>

                <div class="form-group">
                    <label for="">File</label>

                    <div class="custom-file ">
                        <input type="file" name="file" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx,.mp4,.pdf">
                        <label class="custom-file-label" for="file">Pilih File</label>
                    </div>

                    <small>* Jika jawaban berupa file, silahkan upload file.</small>
                </div>
                <div class="text-center">
                    <img src="" class="img-thumbnail img-preview" style="display: none;">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-flat bg-cyan "> Submit</button>
                </div>


                <?= form_close() ?>

            </div>

            <div class="card-footer">
                <a href="<?= base_url('siswa/kuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
            </div>
        </div>

    <?php } else { ?>
        <div class="alert alert-success alert-dismissible text-center">
            Kamu sudah menjawab kuis ini..
        </div>

        <a href="<?= base_url('siswa/kuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>


    <?php } ?>
</div>

<?= $this->section('script'); ?>
<!-- ckeditor5 -->
<script src="<?= base_url() ?>/assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#jawab'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    }
                ]
            }
        })
        .catch(error => {
            console.log(error);
        });
</script>

<?= $this->endsection(); ?>


<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });

    function previewImg() {
        const file = document.querySelector('#file');
        const sampulLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');

        sampulLabel.textContent = file.files[0].name;

        const fileSampul = new FileReader();
        // ambil url tempat penyimpanan gambar
        fileSampul.readAsDataURL(file.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    };
</script>

<?= $this->endsection(); ?>