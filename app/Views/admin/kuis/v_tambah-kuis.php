<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-sm-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Tambah</h3>
        </div>
        <div class="card-body">

            <?= form_open_multipart('admin/prosesTambahKuis') ?>
            <?= csrf_field() ?>

            <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">
            <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">

            <div class="form-group">
                <label for="nama_kuis">Judul</label>
                <input type="text" name="nama_kuis" id="nama_kuis" class="form-control form-control-sm <?= $validation->hasError('nama_kuis') ? 'is-invalid' : '' ?>" style="border-radius: 0px;" placeholder="Masukan Judul">
                <p class="text-danger err"><strong><?= $validation->hasError('nama_kuis') ? $validation->getError('nama_kuis') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <label for="pertemuan">Pertemuan</label>
                <select name="pertemuan" id="pertemuan" class="form-control form-control-sm <?= $validation->hasError('pertemuan') ? 'is-invalid' : '' ?>" style="border-radius: 0px;">
                    <option value="">-- Pilih --</option>

                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <p class="text-danger err"><strong><?= $validation->hasError('pertemuan') ? $validation->getError('pertemuan') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <label for="">File</label>
                <div class="custom-file ">
                    <input type="file" name="file" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx,.mp4">
                    <label class="custom-file-label" for="file">Pilih File</label>
                    <div class="invalid-feedback errorFile"></div>
                </div>
                <div class="text-center">
                    <img src="" class="img-thumbnail img-preview" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="kuis">Keterangan</label>
                <textarea name="kuis" id="kuis"></textarea>
                <p class="text-danger err"><strong><?= $validation->hasError('kuis') ? $validation->getError('kuis') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat bg-cyan btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
            </div>

            <?= form_close() ?>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('admin/kuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-flat btn-block btn-danger">Kembali</a>
        </div>
    </div>
</div>

<?= $this->section('script'); ?>
<!-- ckeditor5 -->
<script src="<?= base_url() ?>/assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#kuis'), {
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
    }
</script>

<?= $this->endsection(); ?>