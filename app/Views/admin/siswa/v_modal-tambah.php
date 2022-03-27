<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Siswa Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/simpanSiswa', ['class' => 'formSiswa']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <small>* Jika tidak mempunyai email boleh disosongkan.</small>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Siswa</label>
                            <input type="text" class="form-control form-control-sm" style="border-radius: 0px;" name="nama" id="nama" placeholder="Masukan Nama Siswa">
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="number" min="1" class="form-control form-control-sm" style="border-radius: 0px;" name="nis" id="nis" placeholder="Masukan NIS">
                            <div class="invalid-feedback errorNis"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" style="border-radius: 0px;" name="email" id="email" placeholder="Masukan Email">
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
                    <label for="kls">Kelas</label>
                    <select name="kls" id="kls" class="form-control form-control-sm" style="border-radius: 0px;">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($kls as $k) : ?>
                            <option value="<?= $k['id_kelas'] ?>"><?= $k['kelas'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback errorKelas"></div>
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