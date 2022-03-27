<div class="modal fade" id="modalTambah">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tahun Pelajaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/simpanTa', ['class' => 'formTa']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="tahun" id="tahun" placeholder="Masukan Tahun">
                    <div class="invalid-feedback errorTahun"></div>
                </div>
                <div class="form-group">
                    <label for="tahun">Semester</label>
                    <select name="semester" id="semester" class="form-control form-control-sm" style="border-radius: 0px;">
                        <option value="">-- Pilih --</option>
                        <option value="1">Ganjil (1)</option>
                        <option value="2">Genap (2)</option>
                    </select>
                    <div class="invalid-feedback errorSemester"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fa fa-ban"></i> &nbsp;Batal</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formTa').submit(function() {
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
                        if (response.error.tahun) {
                            $('#tahun').addClass('is-invalid');
                            $('.errorTahun').html(response.error.tahun);
                        } else {
                            $('#tahun').remove('is-invalid');
                            $('.errorTahun').html('');
                        }

                        if (response.error.semester) {
                            $('#semester').addClass('is-invalid');
                            $('.errorSemester').html(response.error.semester);
                        } else {
                            $('#semester').remove('is-invalid');
                            $('.errorSemester').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        })

                        $('#modalTambah').modal('hide');
                        dataTa();
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