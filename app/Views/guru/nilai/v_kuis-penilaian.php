<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Penilaian</h3>
        </div>

        <div class="card-body">

            <ul class="list-group">
                <?php foreach ($kuis as $k) { ?>
                    <li class="list-group-item bg-cyan mb-2 lis" style="border-radius: 20px;"><?= $k['nama_kuis'] ?> <a href="<?= base_url('guru/daftarNilai/' . $k['id_kuis'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="float-right badge badge-success">Lihat</a></li>
                <?php } ?>
            </ul>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('guru/subKursus/' . $id_kursus) ?>" class="btn btn-flat btn-danger btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>