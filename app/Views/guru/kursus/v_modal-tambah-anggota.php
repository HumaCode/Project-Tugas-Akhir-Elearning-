<div class="modal fade" id="modalTambahAnggota">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Anggota Kursus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('guru/simpanAnggota/' . $id_kursus, ['class' => 'formAnggota']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">

                <div class="form-group">
                    <label for="">Tambah Anggota</label>
                    <select class="bootstrap-select form-control" name="anggota[]" data-width="100%" data-live-search="true" multiple required data-actions-box="true">
                        <?php foreach ($siswaByKelas as $key => $sbk) : ?>

                            <option value="<?= $sbk['id_siswa']; ?>"><?= $sbk['nama_siswa']; ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>

            </div>



            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fa fa-ban"></i> &nbsp;Batal</button>
                <button type="submit" class="btn bg-cyan btn-xs btn-flat btnSimpan"><i class="fas fa-save"></i> &nbsp;Tambah</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.bootstrap-select').selectpicker();
    });
</script>