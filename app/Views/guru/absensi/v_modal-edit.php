<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Absen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('guru/prosesEditAbsen', ['class' => 'formAbsen']) ?>
            <?= csrf_field() ?>

            <input type="hidden" name="id_absen" value="<?= $id_absen ?>">
            <div class="modal-body">

                <div class="form-group">
                    <label for="">Absen Siswa</label>
                    <select name="absen" id="absen" class="form-control form-control-sm">
                        <option value="">Belum Absen</option>
                        <option value="1" <?= ($absen == 1) ? 'selected' : '' ?>>Masuk</option>
                        <option value="2" <?= ($absen == 2) ? 'selected' : '' ?>>Ijin</option>
                        <option value="3" <?= ($absen == 3) ? 'selected' : '' ?>>Sakit</option>
                        <option value="4" <?= ($absen == 4) ? 'selected' : '' ?>>Tidak Masuk</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> &nbsp;Kembali</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Simpan</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.formAbsen').submit(function() {
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
                    if (response.success) {
                        $('#modalEdit').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Perintah tidak dapat diproses.!!',
                    })
                }
            })
            return false;
        })
    })
</script>