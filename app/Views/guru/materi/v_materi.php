<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">

    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Materi</h3>

            <div class="card-tools">
                <a href="<?= base_url('guru/tambahMateri/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn bg-cyan btn-flat btn-xs"><i class="fas fa-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">

            <table id="tb-materi" class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Dibuat</th>
                        <th>Materi</th>
                        <th>Keterangan</th>
                        <th width="200"><i class="fas fa-certificate"></i></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1;
                    foreach ($materi as $m) : ?>
                        <tr>
                            <td class="text-center"><?= $i ?></td>
                            <td><?= tanggal_indonesia($m['dibuat'], false) ?></td>
                            <td><?= $m['judul'] ?></td>
                            <td class="text-center" width="200">
                                <?php if ($m['nama_file'] == 'Tidak ada file' && $m['url'] == null) { ?>
                                    Tidak ada file
                                <?php } else if ($m['nama_file'] != 'Tidak ada file' && $m['url'] == null) { ?>
                                    Menggunakan File
                                <?php } else if ($m['nama_file'] == 'Tidak ada file' && $m['url'] != null) { ?>
                                    Embed Youtube
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if ($m['url'] == null) { ?>
                                    <?php if ($m['nama_file'] == 'Tidak ada file') { ?>
                                        <button type="button" class="btn btn-primary btn-flat btn-xs" onclick="detail('<?= $m['id_materi'] ?>')"><i class="fa fa-eye"></i></button>
                                    <?php } else { ?>
                                        <a href="<?= base_url('guru/downloadFileMateri/' . $m['id_materi']) ?>" class="btn btn-warning btn-flat btn-xs"> <i class="fa fa-download"></i></a>
                                    <?php  } ?>
                                <?php } else { ?>
                                    <a href="<?= base_url('guru/lihatVideoMateri/' . $m['id_materi'] . '/' . $m['id_kursus'] . '/' . $m['id_sub_kursus']) ?>" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-eye"></i></a>
                                <?php } ?>


                                <a href="<?= base_url('guru/editMateri/' . $m['id_materi'] . '/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-success btn-flat btn-xs"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-flat btn-xs" onclick="hapus('<?= $m['id_materi'] ?>')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('guru/subKursus/' . $id_kursus) ?>" class="btn btn-sm btn-danger btn-block btn-flat">Kembali</a>
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
    function hapus(id_materi) {
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
                    url: "<?= site_url('guru/hapusMateri') ?>",
                    data: {
                        id_materi: id_materi
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

    // tombol detail
    function detail(id_materi) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/detailMateri') ?>",
            data: {
                id_materi: id_materi
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
</script>

<?= $this->endsection(); ?>