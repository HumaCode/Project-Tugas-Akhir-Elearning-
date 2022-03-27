<div class="modal fade" id="modalEditProfil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/updateProfil', ['class' => 'formProfil']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <span class="text-danger">* Jika tidak mengubah password, field password dikosongi.</span><br>
                <hr>
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <input type="hidden" name="passLama" value="<?= $password ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="nama" id="nama" value="<?= $nama_user ?>">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="username" id="username" value="<?= $username ?>">
                            <div class="invalid-feedback errorUsername"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" style="border-radius: 0px;" name="email" id="email" value="<?= $email ?>">
                            <div class="invalid-feedback errorEmail"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-sm" style="border-radius: 0px;" name="password" id="password">
                        </div>
                    </div>
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
        $('.formProfil').submit(function() {
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
                    } else {
                        $('#modalEditProfil').modal('hide');

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