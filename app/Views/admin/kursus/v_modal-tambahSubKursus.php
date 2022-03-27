<div class="modal fade" id="modalTambahSubKursus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Sub Kursus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/simpanSubKursus', ['class' => 'formSubKursus']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $kursus ?>">
                <input type="hidden" name="id_ta" id="id_ta" value="<?= $ta_aktif ?>">

                <div class="form-group">
                    <label for="sesi">Sesi Kursus</label>
                    <input type="text" name="sesi" id="sesi" class="form-control form-control-sm" style="border-radius: 0px;" placeholder="Sesi Sub Kursus">
                    <div class="invalid-feedback errorSesi"></div>
                </div>

                <div class="form-group">
                    <label for="mulai">Mulai</label>
                    <input type="datetime-local" name="mulai" id="mulai" class="form-control form-control-sm" style="border-radius: 0px;" placeholder="Mulai">
                    <div class="invalid-feedback errorMulai"></div>
                </div>

            </div>


            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> &nbsp;Batal</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('.formSubKursus').submit(function() {
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
                    $('.btnSimpan').html('<i class="fas fa-save"></i>&nbsp; Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.sesi) {
                            $('#sesi').addClass('is-invalid');
                            $('.errorSesi').html(response.error.sesi);
                        } else {
                            $('#sesi').remove('is-invalid');
                            $('.errorSesi').html('');
                        }
                        if (response.error.mulai) {
                            $('#mulai').addClass('is-invalid');
                            $('.errorMulai').html(response.error.mulai);
                        } else {
                            $('#mulai').remove('is-invalid');
                            $('.errorMulai').html('');
                        }
                    } else {
                        $('#modalTambahSubKursus').modal('hide');

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