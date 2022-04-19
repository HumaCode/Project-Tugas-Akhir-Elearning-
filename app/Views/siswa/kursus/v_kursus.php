<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>



<div class="col-md-12">
    <div class="row">

        <?php if (empty($kursus)) { ?>
            <div class="col-12">
                <div class="alert-danger alert-dismissible p-3 text-center">
                    Kamu belum mengikuti kursus apapun.
                </div>
            </div>
        <?php } else { ?>

            <?php foreach ($kursus as $k) { ?>
                <div class="col-md-6 col-lg-6 col-xl-4 mb-2">
                    <div class="card mb-2" style="border-radius: 10px;">
                        <img class="card-img-top" src="<?= base_url('/assets/img/' . $k['gambar']) ?>" alt="Dist Photo 3" style="opacity: 0.7; border-radius: 10px;">
                        <div class="card-img-overlay">
                            <h5 class="card-title"> <strong><?= $k['mapel'] ?></strong></h5>
                            <br>
                            Dibuat : <?= tanggal_indonesia($k['created_at'], false) ?>

                            <p class="card-text pb-1 pt-1 text-white">
                            <div style="width: 170px;background: transparent;">
                                Guru : <?= $k['nama_guru'] ?>
                            </div>

                            <div class="text-danger mb-2"><?= $k['kelas'] ?></div> <br>


                            <a href="<?= base_url('siswa/subKursus/' . $k['id_kursus']) ?>" class="btn bg-cyan btn-xs btn-flat">Lihat Kursus</a>

                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>

    </div>
</div>


<?= $this->endsection(); ?>