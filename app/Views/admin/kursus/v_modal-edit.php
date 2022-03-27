<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kursus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/updateKursus', ['class' => 'formKursus']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">

                <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mapel">Matapelajaran</label>
                            <select name="mapel" id="mapel" class="form-control form-control-sm" style="border-radius: 0px;">
                                <?php foreach ($mapel as $m) { ?>
                                    <?php if ($m['id_mapel'] == $id_mapel) { ?>
                                        <option value="<?= $m['id_mapel'] ?>" selected><?= $m['mapel'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $m['id_mapel'] ?>"><?= $m['mapel'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorMapel"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control form-control-sm" style="border-radius: 0px;">
                                <?php foreach ($kelas as $k) { ?>
                                    <?php if ($k['id_kelas'] == $id_kelas) { ?>
                                        <option value="<?= $k['id_kelas'] ?>" selected><?= $k['kelas'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $k['id_kelas'] ?>"><?= $k['kelas'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorKelas"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guru">Guru</label>
                    <select name="guru" id="guru" class="form-control form-control-sm" style="border-radius: 0px;">
                        <?php foreach ($guru as $g) { ?>
                            <?php if ($g['id_guru'] == $id_guru) { ?>
                                <option value="<?= $g['id_guru'] ?>" selected><?= $g['nama_guru'] ?></option>
                            <?php } else { ?>
                                <option value="<?= $g['id_guru'] ?>"><?= $g['nama_guru'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback errorGuru"></div>
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

<script>
    $(document).ready(function() {
        $('.formKursus').submit(function() {
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
                        if (response.error.mapel) {
                            $('#mapel').addClass('is-invalid');
                            $('.errorMapel').html(response.error.mapel);
                        } else {
                            $('#mapel').remove('is-invalid');
                            $('.errorMapel').html('');
                        }

                        if (response.error.kelas) {
                            $('#kelas').addClass('is-invalid');
                            $('.errorKelas').html(response.error.kelas);
                        } else {
                            $('#kelas').remove('is-invalid');
                            $('.errorKelas').html('');
                        }

                        if (response.error.guru) {
                            $('#guru').addClass('is-invalid');
                            $('.errorGuru').html(response.error.guru);
                        } else {
                            $('#guru').remove('is-invalid');
                            $('.errorGuru').html('');
                        }
                    } else {
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
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
            return false;
        })
    })
</script>