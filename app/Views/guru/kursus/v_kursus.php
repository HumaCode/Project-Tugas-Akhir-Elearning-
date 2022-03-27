<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<?php

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
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Semua Kursus</h3>

            <div class="card-tools">
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (empty($kursus)) { ?>
                    <div class="col-12">
                        <div class="alert-danger alert-dismissible p-3 text-center">
                            Anda belum membuat kursus <br>
                            klik tambah untuk membuat kursus baru
                        </div>
                    </div>
                <?php } else { ?>
                    <?php foreach ($kursus as $k) { ?>
                        <div class="col-md-6 col-lg-6 col-xl-4 mb-2">
                            <div class="card mb-2" style="border-radius: 10px;">
                                <img class="card-img-top" src="<?= base_url('/assets/img/' . $k['gambar']) ?>" alt="Dist Photo 3" style="opacity: 0.7; border-radius: 10px;">
                                <div class="card-img-overlay">
                                    <h5 class="card-title"> <strong><?= $k['mapel'] ?></strong></h5>
                                    <br>
                                    Dibuat : <?= tanggal_indonesia($k['created_at'], false) ?>

                                    <p class="card-text pb-1 pt-1 text-white">
                                    <div style="width: 170px;background: transparent;">
                                        Guru : <?= $k['nama_guru'] ?>
                                    </div>

                                    <div class="text-danger mb-2"><?= $k['kelas'] ?></div> <br>

                                    <a href="<?= base_url('guru/subKursus/' . $k['id_kursus']) ?>" class="btn bg-cyan btn-xs btn-flat">Lihat Kursus</a>
                                    <button type="button" onclick="edit(<?= $k['id_kursus'] ?>)" class="btn btn-warning btn-xs btn-flat">Edit</button>
                                    <button type="button" onclick="hapus(<?= $k['id_kursus'] ?>)" class="btn btn-danger btn-xs btn-flat">Hapus</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // tombol tambah
    $('.tombol-tambah').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= site_url('guru/formTambahKursus') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewModal').html(response.data).show();
                $('#modalTambah').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Perintah tidak dapat diproses.!!',
                })
            }
        })
    })

    // tombol edit
    function edit(id_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/formEditKursus') ?>",
            data: {
                id_kursus: id_kursus
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

    // tombol hapus
    function hapus(id_kursus) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus kursus ini.?`,
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
                    url: "<?= site_url('guru/hapusKursus') ?>",
                    data: {
                        id_kursus: id_kursus
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