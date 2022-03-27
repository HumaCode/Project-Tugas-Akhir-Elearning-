<div class="modal fade" id="modalEditGambarSekolah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Foto Sekolah</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('', ['class' => 'formFotoSekolah']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" name="id_setting" value="<?= $id_setting ?>">
                <div class="custom-file mb-2">
                    <input type="file" name="foto" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png">
                    <label class="custom-file-label" for="file">Pilih Foto</label>
                    <div class="invalid-feedback errorFoto"></div>
                </div>
                <div class="text-center">
                    <img src="<?= base_url('assets/img/' . $foto) ?>" class="img-thumbnail img-preview">
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> &nbsp; Batal</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnSimpan').click(function(e) {
            e.preventDefault();

            let form = $('.formFotoSekolah')[0];

            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('admin/updateFotoSekolah') ?>",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.btnSimpan').prop('disable', 'disabled');
                    $('.btnSimpan').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete: function(e) {
                    $('.btnSimpan').removeAttr('disable');
                    $('.btnSimpan').html(`<i class="fa save"></i>&nbsp; Simpan`);
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.foto) {
                            $('#file').addClass('is-invalid');
                            $('.errorfoto').html(response.error.foto);
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.error.foto,
                        })
                    } else {
                        window.location.href = '/admin/setting';

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        })
                        $('#modalEditGambarSekolah').modal('hide');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) { // jika error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

    })
</script>

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