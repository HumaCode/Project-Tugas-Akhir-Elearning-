<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Tambah</h3>
        </div>

        <div class="card-body">

            <?= form_open_multipart('admin/prosesTambahMateri') ?>
            <?= csrf_field() ?>

            <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">
            <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">

            <div class="form-group">
                <label for="judul">Materi</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukan Judul Materi">
                <p class="text-danger"><strong><?= $validation->hasError('judul') ? $validation->getError('judul') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <label for="">File</label>

                <div class="custom-file ">
                    <input type="file" name="file" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx,.mp4,.pdf">
                    <label class="custom-file-label" for="file">Pilih File</label>
                </div>
            </div>
            <div class="text-center">
                <img src="" class="img-thumbnail img-preview" style="display: none;">
            </div>


            <div class="form-group">
                <label for="materi">Keterangan</label>
                <textarea name="ket" id="materi" class="form-control" rows="3" style="border-radius: 0px;"></textarea>
                <p class="text-danger err"><strong><?= $validation->hasError('ket') ? $validation->getError('ket') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat bg-cyan btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
            </div>

            <?= form_close() ?>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('admin/materi/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-block">Kembali</a>
        </div>
    </div>
</div>


<?= $this->section('script'); ?>
<!-- ckeditor5 -->
<script src="<?= base_url() ?>/assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#materi'), {
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