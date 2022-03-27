<?= $this->extend('layouts/template-backend'); ?>

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
                    <button type="button" class="btn bg-primary btn-flat btn-sm float-right" onclick="tambah(<?= $kursus['id_kursus'] ?>)"><i class="fas fa-plus"></i>&nbsp; Tambah</button>
                    <a href="<?= base_url('admin/lihatAnggota/' . $id_kursus) ?>" class="btn btn-success btn-flat btn-sm float-right mr-3"><i class="fas fa-eye"></i>&nbsp; Lihat Anggota</a>
                </div>
            </div>
            <hr>

            <?php if (!$subKursus) { ?>
                <h3 class="p-3 text-center text-white" style="background: salmon;border-radius: 10px;">
                    Belum ada Sesi Kursus
                </h3>
            <?php } else { ?>
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
                                            <a href="<?= base_url('admin/lihatNilai/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn btn-secondary btn-flat btn-xs"><i class="fas fa-file-alt"></i> &nbsp;Daftar Nilai</a>
                                            <a href="<?= base_url('admin/absensiSiswa/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn bg-cyan btn-flat btn-xs"><i class="fa fa-eye"></i> &nbsp;Absensi Siswa</a>
                                            <a href="<?= base_url('admin/materi/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn btn-warning btn-flat btn-xs"><i class="fa fa-eye"></i> &nbsp;Materi</a>
                                            <a href="<?= base_url('admin/kuis/' . $sk['id_sub_kursus'] . '/' . $sk['id_kursus']) ?>" class="btn bg-lightblue btn-flat btn-xs"><i class="fa fa-eye"></i> &nbsp;Kuis</a>
                                            <button type="button" class="btn btn-success btn-flat btn-xs" onclick="edit(<?= $sk['id_sub_kursus']  ?>)"><i class="fas fa-pencil-alt"></i> &nbsp;Edit</button>
                                            <button type="button" class="btn btn-danger btn-flat btn-xs" onclick="hapus(<?= $sk['id_sub_kursus'] ?>)"><i class="fas fa-trash"></i> &nbsp;Hapus</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>

        <div class="card-footer">
            <a href="<?= base_url('admin/kursus') ?>" class="btn btn-sm btn-danger btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>
<div class="viewModal" style="display: none;"></div>


<script>
    // tombol tambah subKursus
    function tambah(id_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formTambahSubKursus') ?>",
            data: {
                id_kursus: id_kursus
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalTambahSubKursus').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    // tombol edit subKursus
    function edit(id_sub_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditSubKursus') ?>",
            data: {
                id_sub_kursus: id_sub_kursus,
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEditSubKursus').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    // tombol hapus
    function hapus(id_sub_kursus) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ini..?`,
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
                    url: "<?= site_url('admin/hapusSubKursus') ?>",
                    data: {
                        id_sub_kursus: id_sub_kursus,
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