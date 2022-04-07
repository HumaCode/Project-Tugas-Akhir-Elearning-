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
                    <label for=""><strong>Soal :</strong></label>
                    <p class="text-justify">
                        <?= $kuis['kuis'] ?>
                    </p>
                </div>


                <div class="col-md-8">


                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" style="border-color: white;" src="https://www.youtube.com/embed/<?= $kuis['url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="col-md-4">
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
                                    Video
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <?= form_open_multipart('siswa/jawab') ?>
            <?= csrf_field() ?>

            <input type="hidden" name="id_kuis" id="id_kuis" value="<?= $id_kuis ?>">
            <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">
            <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">

            <div class="form-group mt-3">
                <label for="jawab">Lembar Jawab</label>
                <textarea name="jawab" id="jawab" class="form-control" rows="3" style="border-radius: 0px;"></textarea>
                <p class="text-danger err"><strong><?= $validation->hasError('jawab') ? $validation->getError('jawab') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <label for="">File</label>

                <div class="custom-file ">
                    <input type="file" name="file" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx,.pdf">
                    <label class="custom-file-label" for="file">Pilih File</label>
                </div>

                <small>* Jika jawaban berupa file, silahkan upload file.</small>
                <p class="text-danger err"><strong><?= $validation->hasError('file') ? $validation->getError('file') : '' ?></strong></p>
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