<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Preview Video</h3>
        </div>

        <div class="card-body text-center">

            <video class="img-fluid " style="border-radius: 30px;" controls>
                <source src="<?= base_url('assets/file/' . $materi['nama_file']) ?>" type="video/mp4">
            </video>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('siswa/lihatMateri/' . $id_materi . '/' . $id_kursus . '/' . $id_sub_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>