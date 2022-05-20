<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Daftar Peserta</h3>

            <div class="card-tools">
                <?php if (empty($anggota)) { ?>
                    <button type="button" class="btn bg-cyan btn-flat btn-xs" onclick="tambah('<?= $id_kursus ?>')"><i class="fas fa-plus"></i> Tambah Peserta</button>
                <?php } else { ?>
                    <a href="#" class="btn bg-success btn-flat btn-xs update-record" data-id_kursus="<?= $id_kursus ?>"><i class="fa fa-edit"></i> Edit Peserta</a>
                <?php } ?>
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

            <?= form_open('guru/hapusAnggota', ['class' => 'formHapusBanyak']) ?>

            <p class="py-3">
                <!-- tombol hapus banyak -->
                <button type="submit" class="btn btn-danger btn-xs btn-flat float-right"> <i class="fas fa-trash"></i> &nbsp; Hapus yang dipilih</button>
            </p>
            <table class="table table-bordered">
                <thead id="tb-anggota" class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th width="10" class="text-center">
                            <input type="checkbox" id="centangSemua">
                        </th>

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
                                <td class="text-center">
                                    <input type="checkbox" name="id_anggota[]" class="centangAnggota" value="<?= $a['id_anggota'] ?>">
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    <?php } ?>
                </tbody>
            </table>
            <?= form_close() ?>
        </div>
        <div class="card-footer">
            <a href="<?= base_url('guru/subKursus/' . $id_kursus) ?>" class="btn btn-sm btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<!-- Modal Update anggota-->
<form action="<?= site_url('guru/updateAnggota'); ?>" method="post">
    <div class="modal fade" id="UpdateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="form-group">
                        <label class="">Daftar Siswa</label>
                        <select class="bootstrap-select strings form-control" name="anggota_edit[]" data-width="100%" data-live-search="true" multiple required data-actions-box="true">
                            <?php foreach ($siswaByKelas as $sbk) : ?>

                                <option value="<?= $sbk['id_siswa']; ?>"><?= $sbk['nama_siswa']; ?></option>

                            <?php endforeach; ?>
                        </select>

                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="edit_id" required>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="viewModal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('.bootstrap-select').selectpicker();

        //GET UPDATE
        $('.update-record').on('click', function() {
            var id_kursus = $(this).data('id_kursus');
            $(".strings").val('');
            $('#UpdateModal').modal('show');
            $('[name="edit_id"]').val(id_kursus);

            //AJAX REQUEST TO GET SELECTED PRODUCT
            $.ajax({
                url: "<?php echo site_url('guru/tampilAnggotaByIdKursus'); ?>",
                method: "POST",
                data: {
                    id_kursus: id_kursus
                },
                cache: false,
                success: function(data) {
                    var item = data;
                    var val1 = item.replace("[", "");
                    var val2 = val1.replace("]", "");
                    var values = val2;
                    $.each(values.split(","), function(i, e) {
                        $(".strings option[value='" + e + "']").prop("selected", true).trigger('change');
                        $(".strings").selectpicker('refresh');

                    });
                }

            });
            return false;
        });



        // tombol centang semua
        $('#centangSemua').click(function() {

            if ($(this).is(':checked')) {
                $('.centangAnggota').prop('checked', true);
            } else {
                $('.centangAnggota').prop('checked', false);
            }
        })

        // tombol hapus banyak
        $('.formHapusBanyak').submit(function(e) {
            e.preventDefault();

            let jmlData = $('.centangAnggota:checked');

            if (jmlData.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: 'Silahkan pilih data yang akan di hapus.',
                })
            } else {
                Swal.fire({
                    title: 'Hapus Anggota Kelas',
                    text: `Apakah yakin akan menghapus ${jmlData.length} anggota kelas ini..?`,
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
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
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
            return false;
        })


    })


    // tombol tambah
    function tambah(id_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/formTambahAnggota') ?>",
            data: {
                id_kursus: id_kursus
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


    // tombol edit
    function edit(id_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('guru/formEditAnggota') ?>",
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
</script>

<?= $this->endsection(); ?>