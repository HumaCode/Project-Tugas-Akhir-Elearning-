<?= $this->extend('layouts/template-frontend'); ?>

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
                    <a href="<?= base_url('siswa/pesanMasuk') ?>" class="nav-link">
                        <i class="fas fa-inbox"></i> Pesan Masuk
                        <span class="badge bg-primary float-right"><?= ($count_inbox == 0) ? '' : $count_inbox ?></span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="<?= base_url('siswa/pesanKeluar') ?>" class="nav-link">
                        <i class="far fa-envelope"></i> Pesan Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('siswa/kirim') ?>" class="nav-link">
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
            <h3 class="card-title">Pesan Masuk</h3>
            <div class="card-tools">

            </div>

        </div>

        <div class="card-body">
            <div class="mailbox-controls table-responsive">

                <table class="table table-bordered">
                    <thead class="text-center thead-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Dari</th>
                            <th>Pesan</th>
                            <th>Tanggal Kirim</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($messages)) { ?>
                            <tr>
                                <td colspan="6" class="text-center text-danger">Belum ada pesan masuk</td>
                            </tr>
                        <?php } else { ?>

                            <?php foreach ($messages as $key => $message) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $message['nama'] ?></td>
                                    <td>

                                        <a href="<?= base_url('siswa/lihatInbox/' . $message['id_chating']) ?>"><?= $message['pesan'] ?></a>

                                    </td>
                                    <td class="text-center"><?= tanggal_indonesia($message['tanggal'], false) ?></td>
                                    <td class="text-center"><?= ($message['dibaca'] == 0) ? '<span class="text-danger">Belum dibaca</span>' : '<span class="text-success">Dibaca</span>' ?></td>

                                </tr>
                            <?php endforeach; ?>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?= $this->endsection(); ?>