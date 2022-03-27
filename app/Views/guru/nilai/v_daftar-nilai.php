<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Nilai</h3>

            <div class="card-tools">



                <button type="button" onclick="detail('<?= $nilai['id_kuis'] ?>')" class="btn btn-warning btn-xs">
                    <i class="fa fa-eye"></i> &nbsp; Lihat Soal
                </button>

                <a href="<?= base_url('guru/cetakNilai/' . $nilai['id_kuis'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" target="_blank" class="btn btn-success btn-xs">
                    <i class="fa fa-print"></i> &nbsp; Cetak
                </a>
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
                        <th><i class="fas fa-certificate"></i></th>
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
                            <td class="text-center">
                                <a href="<?= base_url('guru/lihatJawaban/' . $j['id_jawaban'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn bg-cyan btn-xs btn-flat"><i class="fas fa-eye"></i>&nbsp; Lihat</a>
                                <button type="button" class="btn btn-danger btn-xs btn-flat" onclick="hapus('<?= $j['id_jawaban'] ?>')"><i class="fas fa-trash"></i>&nbsp; Hapus</button>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>

                </tbody>
            </table>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('guru/nilai/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    $(function() {
        $('#daftar-nilai').DataTable({
            "paging": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    })

    // tombol detail
    function detail(id_kuis) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/lihatSoal') ?>",
            data: {
                id_kuis: id_kuis,
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalDetail').modal('show');
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
    function hapus(id_jawaban) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus jawaban ini.?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Hapus',
            cancelButtonText: '<i class="fas fa-ban"></i> Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('guru/hapusJawaban') ?>",
                    data: {
                        id_jawaban: id_jawaban
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