<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Semua Kursus</h3>

            <div class="card-tools">
                <?php if (!empty($kursus)) { ?>
                    <a href="<?= base_url('admin/kursus') ?>" class="btn btn-warning btn-flat btn-xs"><i class="fas fa-redo-alt"></i> &nbsp;Segarkan</a>
                <?php } ?>
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> &nbsp;Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <hr>

                <?php if (empty($kursus)) { ?>
                    <div class="col-md-12">
                        <h3 class="p-3 text-center text-white" style="background: salmon;border-radius: 10px;">
                            Kursus belum tersedia
                        </h3>
                    </div>
                <?php } else { ?>

                    <div class="col-md-12">

                        <!-- pencarian -->
                        <form class="form-inline">
                            <label class="sr-only" for="keyword">Name</label>
                            <input type="text" class="form-control mb-3 mr-sm-2" name="keyword" id="keyword" placeholder="Pencarian">

                            <button type="submit" class="btn bg-cyan mb-3" name="submit"> Cari</button>
                        </form>

                    </div>


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

                                    <div class="text-danger mb-2"><?= $k['kelas'] ?></div>

                                    <a href="<?= base_url('admin/subKursus/' . $k['id_kursus']) ?>" class="btn bg-cyan btn-xs btn-flat">Lihat Kursus</a>
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
            url: "<?= site_url('admin/formTambahKursus') ?>",
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
            url: "<?= site_url('admin/formEditKursus') ?>",
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
                    url: "<?= site_url('admin/hapusKursus') ?>",
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