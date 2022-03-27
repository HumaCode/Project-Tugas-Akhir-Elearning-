<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/updateUser', ['class' => 'formUser']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <span class="text-danger">*Jika tidak mengubah password, field password di kosongkan</span><br>
                <span class="text-danger">*Jika password di ubah, password minimal 8 karakter</span>
                <hr>
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <input type="hidden" name="passLama" value="<?= $password ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama User</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="nama" id="nama" value="<?= $nama_user ?>">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px; <?= ($role == 2 || $role == 3) ? 'cursor: not-allowed;' : '' ?>" name="username" id="username" value="<?= $username ?>" <?= ($role == 2 || $role == 3) ? 'readonly' : '' ?>>
                            <div class="invalid-feedback errorUsername"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" style="border-radius: 0px;" name="email" id="email" value="<?= $email ?>">
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
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control form-control-sm" style="border-radius: 0px;">
                        <option value="">-- Pilih --</option>
                        <option value="1" <?= ($role == 1) ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= ($role == 2) ? 'selected' : '' ?>>Guru</option>
                        <option value="3" <?= ($role == 3) ? 'selected' : '' ?>>Siswa</option>
                    </select>
                    <div class="invalid-feedback errorRole"></div>
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
        $('.formUser').submit(function() {
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
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUsername').html(response.error.username);
                        } else {
                            $('#username').remove('is-invalid');
                            $('.errorUsername').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').remove('is-invalid');
                            $('.errorEmail').html('');
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorPassword').html(response.error.password);
                        } else {
                            $('#password').remove('is-invalid');
                            $('.errorPassword').html('');
                        }
                        if (response.error.role) {
                            $('#role').addClass('is-invalid');
                            $('.errorRole').html(response.error.role);
                        } else {
                            $('#role').remove('is-invalid');
                            $('.errorRole').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        })

                        $('#modalEdit').modal('hide');
                        dataUser();
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