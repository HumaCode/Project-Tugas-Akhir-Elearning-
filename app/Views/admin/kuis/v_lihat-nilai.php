<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Lihat Nilai</h3>
        </div>

        <div class="card-body">

            <ul class="list-group">

                <?php if (empty($nilai)) { ?>
                    <h3 class="p-3 text-center text-white" style="background: salmon;border-radius: 10px;">
                        Belum ada kuis yang dibuat
                    </h3>
                <?php } else { ?>

                    <?php foreach ($nilai as $n) : ?>
                        <li class="list-group-item mb-2 lis bg-cyan" style="border-radius: 20px;"><strong><?= $n['nama_kuis'] ?></strong> <a href="<?= base_url('admin/daftarNilai/' . $n['id_kuis'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="float-right badge badge-success">Lihat</a></li>
                    <?php endforeach; ?>

                <?php } ?>

            </ul>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('admin/subKursus/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>