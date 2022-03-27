<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah User Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/simpanUser', ['class' => 'formUser']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <span class="text-danger">*Jika ingin menambahkan siswa, username diisikan dengan NIS siswa</span>
                <span class="text-danger">*Jika usernya siswa, email boleh dikosongkan ataupun diisi jika punya</span>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama User</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="nama" id="nama" placeholder="Masukan Nama User">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="username" id="username" placeholder="Masukan Username">
                            <div class="invalid-feedback errorUsername"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" style="border-radius: 0px;" name="email" id="email" placeholder="Masukan Email">
                            <div class="invalid-feedback errorEmail"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-sm" style="border-radius: 0px;" name="password" id="password" placeholder="Masukan Password">
                            <div class="invalid-feedback errorPassword"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control form-control-sm" style="border-radius: 0px;">
                        <option value="">-- Pilih --</option>
                        <option value="1">Admin</option>
                        <option value="2">Guru</option>
                        <option value="3">Siswa</option>
                    </select>
                    <div class="invalid-feedback errorRole"></div>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> Batal</button>
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

                        $('#modalTambah').modal('hide');
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