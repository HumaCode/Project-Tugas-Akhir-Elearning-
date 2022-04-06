<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>

        <div class="card-body">

            <?= form_open_multipart('admin/prosesEditMateri') ?>
            <?= csrf_field() ?>

            <input type="hidden" name="id_materi" id="id_materi" value="<?= $materi['id_materi'] ?>">
            <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">
            <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">

            <div class="form-group">
                <label for="judul">Materi</label>
                <input type="text" name="judul" class="form-control" value="<?= $materi['judul'] ?>">
                <p class="text-danger"><strong><?= $validation->hasError('judul') ? $validation->getError('judul') : '' ?></strong></p>
            </div>

            <div class="form-group">
                <label for="materi">Keterangan</label>
                <textarea name="ket" id="materi" class="form-control" rows="3" style="border-radius: 0px;"><?= $materi['ket'] ?></textarea>
                <p class="text-danger err"><strong><?= $validation->hasError('ket') ? $validation->getError('ket') : '' ?></strong></p>
            </div>

            <button type="button" class="btn btn-xs btn-flat btn-success" id="b">Upload File</button>
            <button type="button" class="btn btn-xs btn-flat btn-danger" id="bt">Batal</button>
            <button type="button" class="btn btn-xs" data-toggle="modal" data-target="#info"><i class="fas fa-info-circle"></i></button>

            <div class="form-group" id="g" style="display: none;">
                <label for="">File</label>

                <div class="custom-file ">
                    <input type="file" name="file" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png,.doc,.docx,.ppt,.pptx,.pdf">
                    <label class="custom-file-label" for="file">Pilih File</label>
                    <small class="text-danger">* jpg,jpeg,png,doc,docx,ppt,pptx,pdf</small><br>
                    <small class="text-danger">* Maks 1 Mb</small>
                </div>
            </div>
            <p class="text-danger err"><strong><?= $validation->hasError('file') ? $validation->getError('file') : '' ?></strong></p>
            <div class="text-center">
                <img src="" class="img-thumbnail img-preview" style="display: none;">
            </div>


            <button type="button" class="btn btn-xs btn-flat btn-success" id="v">Embed Video</button>
            <button type="button" class="btn btn-xs btn-flat btn-danger" id="vt">Batal</button>

            <div class="form-group" id="vv" <?php if ($materi['url'] == null) {
                                                echo "style= 'display: none;'";
                                            } else {
                                                echo "style= 'display: revert;'";
                                            }  ?>>
                <label for="url">Id Video</label>
                <input type="text" name="url" class="form-control" value="<?= $materi['url'] ?>">
            </div>
            <p class="text-danger err"><strong><?= $validation->hasError('url') ? $validation->getError('url') : '' ?></strong></p>

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

<!-- info modal -->
<!-- Modal -->
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                <p>Jika ingin menambahkan file klik tombol <strong>Upload File</strong> untuk memunculkan field upload file </p>
                <p>Begitu juga jika ingin menampilkan konten dari youtube, dengan cara embed id nya saja.</p>

                <p><strong>Contoh Embed Youtube</strong> <br>
                    https://www.youtube.com/watch?v=TEs3A4d-3U4 <br>

                    cukup copy idnya saja yaitu <strong>TEs3A4d-3U4</strong>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> &nbsp;Tutup</button>
            </div>
        </div>
    </div>
</div>


<?= $this->section('script'); ?>
<!-- ckeditor5 -->
<script src="<?= base_url() ?>/assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('#b').click(function() {
            document.getElementById("g").style.display = "revert";
        })
        $('#bt').click(function() {
            document.getElementById("g").style.display = "none";
        })

        $('#v').click(function() {
            document.getElementById("vv").style.display = "revert";
        })
        $('#vt').click(function() {
            document.getElementById("vv").style.display = "none";
        })
    })

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