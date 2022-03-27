<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tahun Pelajaran <?= $ta['tahun'] . ' | Semester ' . $ta['semester'] ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <h4>Selamat Datang <?= session()->get('nama_user') ?> di halaman <?= $title . ' ' . $kursus['kelas'] ?></h4>
            <div class="row">
                <div class="col-md-12 ">
                    <a href="<?= base_url('siswa/lihatAnggota/' . $id_kursus) ?>" class="btn btn-success btn-flat btn-sm float-right mr-3"><i class="fas fa-eye"></i>&nbsp; Lihat Anggota</a>
                </div>
            </div>
            <hr>

            <?php if (!$subKursus) { ?>
                <div class=" p-3 text-center" style="background: salmon;border-radius: 10px;">
                    Belum ada Sesi Kursus
                </div>
            <?php } else { ?>
                <?php if (isset($anggota['id_siswa'])) { ?>

                    <?php foreach ($subKursus as $sk) { ?>
                        <div class="col-md-12" id="accordion">
                            <div class="card card-cyan card-outline">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne<?= $sk['id_sub_kursus'] ?>">
                                    <div class="card-header ">
                                        <h3 class="card-title w-100 text-cyan d-inline">
                                            <i class="fas fa-exclamation-circle"></i> <?= $sk['sub_kursus'] ?>
                                        </h3>
                                    </div>
                                </a>
                                <div id="collapseOne<?= $sk['id_sub_kursus'] ?>" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <a href="<?= base_url('siswa/materi/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn btn-warning btn-flat btn-xs"><i class="fa fa-eye"></i> &nbsp;Materi</a>
                                                <a href="<?= base_url('siswa/kuis/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn bg-lightblue btn-flat btn-xs"><i class="fa fa-eye"></i> &nbsp;Kuis</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } else { ?>
                    <div class="bg-cyan p-3 text-center">
                        <h3>Kamu belum terdaftar di dalam kursus ini, Silahkan hubungi guru yang bersangkutan</h3>
                    </div>
                <?php } ?>

            <?php } ?>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('siswa/kursus') ?>" class="btn btn-sm btn-danger btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>


<?= $this->endsection(); ?>