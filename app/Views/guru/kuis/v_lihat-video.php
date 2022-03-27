<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Preview Video</h3>
        </div>
        <div class="card-body text-center">


            <video class="img-fluid" controls>
                <source src="<?= base_url('assets/file/' . $kuis['file']) ?>" type="video/mp4">
            </video>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('guru/kuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-block btn-danger btn-flat">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>