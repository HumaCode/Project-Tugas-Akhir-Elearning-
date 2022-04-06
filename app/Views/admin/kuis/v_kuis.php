<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<?php

date_default_timezone_set('Asia/Jakarta');

// function tanggal indo
function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
    );

    $nama_bulan = array(
        1 =>
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    // format tanggal php
    //  2021-11-26

    $tahun = substr($tgl, 0, 4);
    $bulan = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text .= "$tanggal $bulan $tahun";
    }
    return $text;
}


?>

<div class="col-md-12">

    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kuis</h3>

            <div class="card-tools">
                <a href="<?= base_url('admin/tambahKuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" type="button" class="btn bg-cyan btn-flat btn-xs"><i class="fas fa-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">

            <table id="tb-materi" class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th width="200">Dibuat</th>
                        <th width="200">Nama Kuis</th>
                        <th>Pertemuan</th>
                        <th>Kuis</th>
                        <th width="200"><i class="fas fa-certificate"></i></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1;
                    foreach ($kuis as $k) : ?>


                        <tr>
                            <td class="text-center"><?= $i ?>.</td>
                            <td class="text-center"><?= tanggal_indonesia($k['dibuat'], false) ?></td>
                            <td><?= $k['nama_kuis'] ?></td>
                            <td class="text-center"><?= $k['pertemuan'] ?></td>
                            <td class="text-center" width="200">
                                <?php if ($k['file'] == 'Tidak ada file' && $k['url'] == null) { ?>
                                    Tidak ada file
                                <?php } else if ($k['file'] != 'Tidak ada file' && $k['url'] == null) { ?>
                                    Menggunakan File
                                <?php } else if ($k['file'] == 'Tidak ada file' && $k['url'] != null) { ?>
                                    Embed Youtube
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if ($k['url'] == null) { ?>
                                    <button type="button" class="btn btn-primary btn-flat btn-xs" onclick="detail('<?= $k['id_kuis'] ?>')"><i class="fa fa-eye"></i></button>
                                <?php } else { ?>
                                    <a href="<?= base_url('admin/lihatVideoKuis/' . $k['id_kuis'] . '/' . $k['id_kursus'] . '/' . $k['id_sub_kursus']) ?>" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-eye"></i></a>
                                <?php } ?>

                                <a href="<?= base_url('admin/editKuis/' . $k['id_kuis'] . '/' . $k['id_sub_kursus'] . '/' . $k['id_kursus']) ?>" class="btn btn-success btn-flat btn-xs"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-flat btn-xs" onclick="hapus('<?= $k['id_kuis'] ?>')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('admin/subKursus/' . $id_kursus) ?>" class="btn btn-sm btn-danger btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<?= $this->endsection(); ?>


<?= $this->section('script'); ?>

<script>
    let table;

    table = $('#tb-materi').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });


    // tombol hapus
    function hapus(id_kuis) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ini.`,
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
                    url: "<?= site_url('admin/hapusKuis') ?>",
                    data: {
                        id_kuis: id_kuis
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
                    error: function(xhr, ajaxOption, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                })
            }
        })
    }


    // tombol detail
    function detail(id_kuis) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/detailKuis') ?>",
            data: {
                id_kuis: id_kuis
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalDetail').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>

<?= $this->endsection(); ?>