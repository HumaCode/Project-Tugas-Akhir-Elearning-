<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Lihat Nilai</h3>
        </div>

        <div class="card-body">

            <ul class="list-group">

                <?php foreach ($nilai as $n) : ?>
                    <li class="list-group-item"><strong><?= $n['nama_kuis'] ?></strong> <a href="<?= base_url('guru/daftarNilai/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="float-right badge badge-warning">Lihat</a></li>
                <?php endforeach; ?>

            </ul>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('guru/subKursus/' . $id_kursus . '/' . $id_sub_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>