<?php

$format = substr($nama_file, -4);

?>

<!-- Modal -->
<div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php if ($format == 'file') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <img src="<?= base_url('assets/img/no-file.png') ?>" class="img-fluid" alt="">
                            <p>Tidak ada file</p>

                        </div>
                        <div class="col-md-8">

                            <p class="text-justify"><?= $ket ?></p>
                        </div>
                    </div>
                <?php } else if ($format == 'pptx' || $format == '.ppt') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <img src="<?= base_url('assets/img/powerpoint.png') ?>" class="img-fluid" alt="">
                            <p>Powerpoint</p>

                        </div>
                        <div class="col-md-8">

                            <p class="text-justify"><?= $ket ?></p>

                            <a href="<?= base_url('guru/downloadFileMateri/' . $id_materi) ?>"> Download File</a>
                        </div>
                    </div>

                <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <img src="<?= base_url('assets/img/jpg.png') ?>" class="img-fluid" alt="">
                            <p>Gambar</p>

                        </div>
                        <div class="col-md-8">

                            <p class="text-justify"><?= $ket ?></p>

                            <a href="<?= base_url('guru/downloadFileMateri/' . $id_materi) ?>"> Download File</a>
                        </div>
                    </div>

                <?php } else if ($format == '.mp4') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <a href="<?= base_url('guru/lihatVideoMateri/' . $id_materi . '/' . $id_kursus . '/' . $id_sub_kursus) ?>">
                                <img src="<?= base_url('assets/img/video.png') ?>" class="img-fluid" alt="">
                            </a>
                            <p>Video</p>

                        </div>
                        <div class="col-md-8">

                            <p class="text-justify"><?= $ket ?></p>

                            <a href="<?= base_url('guru/downloadFileMateri/' . $id_materi) ?>" target="_blank"> Download File</a>
                        </div>
                    </div>

                <?php } ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>