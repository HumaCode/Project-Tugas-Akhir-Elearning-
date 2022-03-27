<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/simpanKelas', ['class' => 'formKelas']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="kelas" id="kelas" placeholder="Masukan Kelas">
                    <div class="invalid-feedback errorKelas"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-xs btn-flat" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formKelas').submit(function() {
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
                        if (response.error.kelas) {
                            $('#kelas').addClass('is-invalid');
                            $('.errorKelas').html(response.error.kelas);
                        } else {
                            $('#kelas').remove('is-invalid');
                            $('.errorKelas').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        })

                        $('#modalTambah').modal('hide');
                        dataKelas();
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