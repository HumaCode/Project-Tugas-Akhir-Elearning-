<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">

    <div class="col-md-12">
        <?php if (empty($kuis)) { ?>
            <div class="col-12">
                <div class="alert-warning alert-dismissible p-3 text-center">
                    Anda belum memiliki kuis <br>
                </div>
            </div>
        <?php } else { ?>
            <ul class="list-group">
                <?php foreach ($kuis as $k) :  ?>
                    <li class="list-group-item mb-2 bg-lightblue" style="border-radius: 10px;"> <strong><?= $k['pertemuan'] . '. ' . $k['nama_kuis'] ?></strong> <span class="badge badge-warning float-right ">
                            <?php if ($k['url'] == null) { ?>
                                <a href="<?= base_url('siswa/lihatKuis/' . $k['id_kuis'] . '/' . $id_kursus . '/' . $id_sub_kursus) ?>" class="text-dark">Lihat</a></span>
                    <?php } else { ?>
                        <a href="<?= base_url('siswa/lihatVideoKuis/' . $k['id_kuis'] . '/' . $id_kursus . '/' . $id_sub_kursus) ?>" class="text-dark">Lihat</a></span>
                    <?php } ?>


                    </li>
                <?php endforeach; ?>
            </ul>
            <hr>
        <?php } ?>

        <a href="<?= base_url('siswa/subKursus/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block mt-3">Kembali</a>
    </div>

</div>


<?= $this->endsection(); ?>