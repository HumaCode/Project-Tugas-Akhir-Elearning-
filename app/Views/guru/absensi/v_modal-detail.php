<div class="modal fade" id="modaLihat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lihat Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="text-center">
                    <?php if (empty($foto)) { ?>
                        <?php if ($absen != 0) { ?>
                            <span style="background-color: green; padding: 10px;border-radius: 10px;color: white;">Siswa sudah melakukan absen</span>
                        <?php } else { ?>
                            <span style="background-color: salmon; padding: 10px;border-radius: 10px;color: white;">Siswa belum melakukan absen</span>
                        <?php } ?>
                    <?php } else {  ?>
                        <img src="<?= base_url('assets/img/absen/' . $foto) ?>" class="img-fluid" style="border-radius: 20px;" alt="">
                    <?php } ?>
                </div>

            </div>

            <div class="modal-footer ">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> &nbsp;Kembali</button>
            </div>

        </div>
    </div>
</div>