<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Absen </h3>


        </div>

        <div class="card-body">

            <div class="card p-2 bg-cyan">

                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td width="200">Jumlah Siswa <?= $kursus['kelas'] ?></td>
                                <td width="20">=</td>
                                <td><?= $jmlSiswa ?> Siswa</td>
                            </tr>
                            <tr>
                                <td>Jumlah Siswa Belum Absen</td>
                                <td>=</td>
                                <td><?= $belumAbsen ?> Siswa</td>
                            </tr>
                            <tr>
                                <td>Jumlah Siswa Masuk</td>
                                <td>=</td>
                                <td><?= $masuk ?> Siswa</td>
                            </tr>
                        </table>

                    </div>

                    <div class="col-sm-6">
                        <table class="mr-auto">
                            <tr>
                                <td width="200">Jumlah Siswa Ijin</td>
                                <td width="20">=</td>
                                <td><?= $ijin ?> Siswa</td>
                            </tr>
                            <tr>
                                <td>Jumlah Siswa Sakit</td>
                                <td>=</td>
                                <td><?= $sakit ?> Siswa</td>
                            </tr>
                            <tr>
                                <td>Jumlah Siswa Tidak Masuk</td>
                                <td>=</td>
                                <td><?= $alpa ?> Siswa</td>
                            </tr>
                        </table>
                    </div>

                </div>




            </div>


            <table id="tb-absen" class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Status</th>
                        <th>Tanggal Absen</th>
                        <th width="100"><i class="fas fa-certificate"></i></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1;
                    foreach ($absensi as $a) { ?>
                        <tr>
                            <td class="text-center"><?= $i ?>.</td>
                            <td><?= $a['nama_siswa'] ?></td>
                            <td class="text-center"><?= $a['nis'] ?></td>
                            <td class="text-center">
                                <?php if ($a['absen'] == 0) {  ?>
                                    <strong>Belum Absen</strong>
                                <?php } else if ($a['absen'] == 1) {  ?>
                                    <strong class="text-success">Masuk</strong>
                                <?php } else if ($a['absen'] == 2) {  ?>
                                    <strong class="text-primary">Ijin</strong>
                                <?php }
                                if ($a['absen'] == 3) {  ?>
                                    <strong class="text-warning">Sakit</strong>
                                <?php }
                                if ($a['absen'] == 4) {  ?>
                                    <strong class="text-danger">Tidak Masuk</strong>
                                <?php } ?>
                            </td>
                            <td class="text-center"><?= ($a['waktu'] == null) ? '-' : tanggal_indonesia($a['waktu']) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn bg-cyan btn-xs btn-flat" onclick="lihat('<?= $a['id_absen'] ?>')"><i class="fas fa-eye"></i> &nbsp;Lihat</button>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a href="<?= base_url('admin/subKursus/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>


<div class="viewModal" style="display: none;"></div>


<script>
    $(document).ready(function() {
        $('.bootstrap-select').selectpicker();

        $('#tb-absen').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    })

    // tombol lihat
    function lihat(id_absen) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formLihatAbsen') ?>",
            data: {
                id_absen: id_absen
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modaLihat').modal('show');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Perintah tidak dapat diproses.!!',
                })
            }
        })
    }
</script>

<?= $this->endsection(); ?>