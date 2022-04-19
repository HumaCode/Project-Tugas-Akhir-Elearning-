<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Nilai</h3>

            <div class="card-tools">
                <?php if (isset($nilai)) { ?>
                    <a href="<?= base_url('admin/cetakNilai/' . $nilai['id_kuis'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" target="_blank" class="btn btn-success btn-xs">
                        <i class="fa fa-print"></i> &nbsp; Cetak
                    </a>
                <?php } ?>
            </div>
        </div>



        <div class="card-body">

            <table id="daftar-nilai" class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="70">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Nilai</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $i = 1;
                    foreach ($jawaban as $j) { ?>
                        <tr>
                            <td class="text-center"><?= $i ?>.</td>
                            <td><?= $j['nama_siswa'] ?></td>
                            <td class="text-center"><?= $j['nis'] ?></td>
                            <td class="text-center">
                                <?php if ($j['nilai'] == 'Belum dinilai') { ?>
                                    <strong>Belum dinilai</strong>
                                <?php } else if ($j['nilai'] <= 64) { ?>
                                    <strong class="text-danger"><?= $j['nilai'] ?></strong>
                                <?php } else if ($j['nilai'] >= 65) { ?>
                                    <strong class="text-success"><?= $j['nilai'] ?></strong>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>

                </tbody>
            </table>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('admin/lihatNilai/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#daftar-nilai').DataTable({
            "paging": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    })
</script>

<?= $this->endsection(); ?>