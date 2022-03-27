<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('admin/pesanMasuk') ?>" class="nav-link">
                        <i class="fas fa-inbox"></i> Pesan Masuk
                        <span class="badge bg-primary float-right"><?= ($count_inbox == 0) ? '' : $count_inbox ?></span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="<?= base_url('admin/pesanKeluar') ?>" class="nav-link">
                        <i class="far fa-envelope"></i> Pesan Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/kirim') ?>" class="nav-link">
                        <i class="far fa-file-alt"></i> Kirim Pesan
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-9">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Menu Chating</h3>
            <div class="card-tools">

            </div>

        </div>

        <div class="card-body">
            <div class="mailbox-controls">

                <h2>Selamat datang di halaman chating</h2>


            </div>
        </div>
    </div>
</div>


<?= $this->endsection(); ?>