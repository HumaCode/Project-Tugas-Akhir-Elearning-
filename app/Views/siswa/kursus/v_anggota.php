<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Anggota</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body ">

            <div class="card p-2">
                <table>
                    <tr>
                        <td width="150"><strong>Guru Pengampu</strong></td>
                        <td width="20"><strong>:</strong></td>
                        <td><strong><?= $kursusId['nama_guru'] ?></strong></td>
                    </tr>

                    <tr>
                        <td><strong>NIP</strong></td>
                        <td><strong>:</strong></td>
                        <td><strong><?= $kursusId['nip'] ?></strong></td>
                    </tr>

                    <tr>
                        <td><strong>Kelas</strong></td>
                        <td><strong>:</strong></td>
                        <td><strong><?= $kursusId['kelas'] ?></strong></td>
                    </tr>
                </table>
            </div>

            <table class="table table-bordered">
                <thead id="tb-anggota" class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>

                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($anggota)) { ?>
                        <tr>
                            <td colspan="4" class="text-center text-danger">Belum ada anggota kursus yang ditambahkan</td>
                        </tr>
                    <?php } else { ?>
                        <?php $i = 1;
                        foreach ($anggota as $a) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $a['nama_siswa'] ?></td>
                                <td width="100" class="text-center"><?= $a['nis'] ?></td>
                            </tr>
                        <?php $i++;
                        } ?>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('siswa/subKursus/' . $id_kursus) ?>" class="btn btn-sm btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>


<?= $this->endsection(); ?>