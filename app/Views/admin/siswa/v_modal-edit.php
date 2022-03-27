<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Siswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/updateSiswa', ['class' => 'formSiswa']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <span class="text-danger">*Jika tidak mengubah password, field password di kosongkan</span><br>
                <span class="text-danger">*Jika tidak punya email, field email boleh dikosongkan</span>
                <hr>
                <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">
                <input type="hidden" name="passLama" value="<?= $password ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Siswa</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="nama" id="nama" value="<?= $nama_siswa ?>">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px; cursor: not-allowed;" name="nis" id="nis" value="<?= $nis ?>" readonly>
                            <div class="invalid-feedback errorNis"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" style="border-radius: 0px;" name="email" id="email" value="<?= ($email == '-' || $email == null) ? '' : $email ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-sm" style="border-radius: 0px;" name="password" id="password">
                            <div class="invalid-feedback errorPassword"></div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control form-control-sm" style="border-radius: 0px;">
                        <?php foreach ($kelas as $k) { ?>
                            <?php if ($k['id_kelas'] == $kelas_id) { ?>
                                <option value="<?= $k['id_kelas'] ?>" selected><?= $k['kelas'] ?></option>
                            <?php } else { ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= $k['kelas'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback errorKelas"></div>
                </div>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="is_active" id="is_active" value="1" <?= ($is_active == 1) ? ' checked' : '' ?>>
                    <label for="is_active" class="custom-control-label">Aktif</label>
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
        $('.formSiswa').submit(function() {
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
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').remove('is-invalid');
                            $('.errorNama').html('');
                        }
                        if (response.error.nis) {
                            $('#nis').addClass('is-invalid');
                            $('.errorNis').html(response.error.nis);
                        } else {
                            $('#nis').remove('is-invalid');
                            $('.errorNis').html('');
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorPassword').html(response.error.password);
                        } else {
                            $('#password').remove('is-invalid');
                            $('.errorPassword').html('');
                        }
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

                        $('#modalEdit').modal('hide');
                        dataSiswa();
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