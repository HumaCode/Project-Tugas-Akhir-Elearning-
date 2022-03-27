<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-lg-3 col-6">

    <div class="small-box bg-info">
        <div class="inner">
            <h3><?= $jmlGuru ?></h3>
            <p>Daftar Guru</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-tie"></i>
        </div>
        <a href="<?= base_url('admin/guru') ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-6">

    <div class="small-box bg-success">
        <div class="inner">
            <h3><?= $jmlSiswa ?></h3>
            <p>Daftar Siswa</p>
        </div>
        <div class="icon">
            <i class="fas fa-user"></i>
        </div>
        <a href="<?= base_url('admin/siswa') ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-6">

    <div class="small-box bg-warning">
        <div class="inner">
            <h3><?= $jmlUser ?></h3>
            <p>Daftar User</p>
        </div>
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <a href="<?= base_url('admin/user') ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-6">

    <div class="small-box bg-danger">
        <div class="inner">
            <h3><?= $jmlKursus ?></h3>
            <p>Kursus</p>
        </div>
        <div class="icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <a href="<?= base_url('admin/kursus') ?>" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Halaman Dashboard Admin</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <h3>Selamat Datang Administrator</h3>
        </div>
    </div>
</div>


<?= $this->endsection(); ?>