<?php

$format = substr($file, -4);

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
                        <div class="col-md-12">
                            <h3><?= $nama_kuis ?></h3>

                            <p class="text-justify"><?= $kuis ?></p>
                        </div>
                    </div>
                <?php } else if ($format == 'pptx' || $format == '.ppt') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <img src="<?= base_url('assets/img/powerpoint.png') ?>" class="img-fluid" alt="">
                            <p>Powerpoint</p>

                        </div>
                        <div class="col-md-8">
                            <h3><?= $nama_kuis ?></h3>

                            <p class="text-justify"><?= $kuis ?></p>

                            <a href="<?= base_url('admin/downloadFileKuis/' . $id_kuis) ?>"> Download File</a>
                        </div>
                    </div>

                <?php } else if ($format == 'jpeg' || $format == '.jpg' || $format == '.png') { ?>

                    <div class="row">
                        <div class="col-md-4 text-center">

                            <img src="<?= base_url('assets/img/jpg.png') ?>" class="img-fluid" alt="">
                            <p>Gambar</p>

                        </div>
                        <div class="col-md-8">
                            <h3><?= $nama_kuis ?></h3>

                            <p class="text-justify"><?= $kuis ?></p>

                            <a href="<?= base_url('admin/downloadFileKuis/' . $id_kuis) ?>"> Download File</a>
                        </div>
                    </div>

                <?php }  ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>