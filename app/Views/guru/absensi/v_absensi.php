<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Absen </h3>

            <div class="card-tools">

                <button type="button" class="btn bg-cyan btn-flat btn-xs" onclick="tambah('<?= $id_kursus ?>', '<?= $id_sub_kursus ?>')"><i class="fas fa-plus"></i> Tambah Siswa</button>

            </div>
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

                    <div class="col-md-6">
                        <table class="">
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
                        <th width="200"><i class="fas fa-certificate"></i></th>
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
                                <button type="button" class="btn btn-warning btn-xs btn-flat" onclick="edit('<?= $a['id_absen'] ?>')"><i class="fa fa-pencil-alt"></i> &nbsp;Edit</button>
                                <button type="button" onclick="hapus(<?= $a['id_absen'] ?>)" class="btn btn-danger btn-xs btn-flat"><i class="fas fa-trash"></i> &nbsp;Hapus</button>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a href="<?= base_url('guru/subKursus/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
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
            url: "<?= site_url('guru/formLihatAbsen') ?>",
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

    // tombol edit
    function edit(id_absen) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/formEditAbsen') ?>",
            data: {
                id_absen: id_absen
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEdit').modal('show');
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


    // tombol tambah
    function tambah(id_kursus, id_sub_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/formTambahSiswaAbsensi') ?>",
            data: {
                id_kursus: id_kursus,
                id_sub_kursus: id_sub_kursus,
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();

                    $('#modalTambahAnggota').modal('show');
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

    // tombol hapus
    function hapus(id_absen) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ini.?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fas fa-check"></i> &nbsp;Ya, Hapus',
            cancelButtonText: '<i class="fas fa-ban"></i> &nbsp;Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('guru/hapusAbsen') ?>",
                    data: {
                        id_absen: id_absen
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            }).then((result) => {
                                window.location.reload();
                            })
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
        })
    }
</script>

<?= $this->endsection(); ?>