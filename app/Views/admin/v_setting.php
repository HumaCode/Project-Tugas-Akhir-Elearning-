<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-12">
    <!-- flashdata -->
    <?php if (session()->getFlashdata('pesan')) { ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
    <?php } ?>

    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Setting
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool text-cyan" onclick="editFotoSekolah(<?= $setting['id_setting'] ?>)">
                    <i class="fas fa-image"></i> &nbsp; Lihat foto sekolah
                </button>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Landing Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Kritik dan Saran</a>
                </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">

                    <?= form_open_multipart('admin/ubahSetingan/' . $setting['id_setting']) ?>
                    <?= csrf_field() ?>


                    <div class="row">
                        <div class="col-md-3 p-3 m-auto">
                            <p>Logo</p>


                            <div class="text-center">
                                <img src="<?= base_url('assets/img/' . $setting['logo']) ?>" class="img-thumbnail img-preview">
                            </div>

                            <div class="custom-file mb-2">
                                <input type="file" name="foto" class="custom-file-input" id="file" onchange="previewImg()" accept=".jpg,.jpeg,.png">
                                <label class="custom-file-label" for="file">Pilih Foto</label>
                                <p class="text-danger pl-2"><strong><?= $validation->hasError('foto') ? $validation->getError('foto') : '' ?></strong></p>

                            </div>
                        </div>
                    </div>


                    <div class="form-group mt-2">
                        <label for="desk1">Deskripsi 1</label>
                        <textarea name="desk1" id="desk1" cols="30" rows="3" class="form-control"><?= $setting['desk1'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="desk2">Deskripsi 2</label>
                        <textarea name="desk2" id="desk2" cols="30" rows="3" class="form-control"><?= $setting['desk2'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="desk3">Deskripsi 3</label>
                        <textarea name="desk3" id="desk3" cols="30" rows="3" class="form-control"><?= $setting['desk3'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="desk4">Deskripsi 4</label>
                        <textarea name="desk4" id="desk4" cols="30" rows="3" class="form-control"><?= $setting['desk4'] ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control" id="nama_sekolah" value="<?= $setting['nama_sekolah'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="npsn">NPSN</label>
                                <input type="text" name="npsn" class="form-control" id="npsn" value="<?= $setting['npsn'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenjang">Jenjang Sekolah</label>
                                <input type="text" name="jenjang" class="form-control" id="jenjang" value="<?= $setting['jenjang'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_sekolah">Status Pendidikan</label>
                                <input type="text" name="status_sekolah" class="form-control" id="status_sekolah" value="<?= $setting['status_sekolah'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" value="<?= $setting['alamat'] ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kd_pos">Kode Pos</label>
                                <input type="text" name="kd_pos" class="form-control" id="kd_pos" value="<?= $setting['kd_pos'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rt">Rt</label>
                                <input type="text" name="rt" class="form-control" id="rt" value="<?= $setting['rt'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rw">Rw</label>
                                <input type="text" name="rw" class="form-control" id="rw" value="<?= $setting['rw'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kelurahan">Kelurahan</label>
                                <input type="text" name="kelurahan" class="form-control" id="kelurahan" value="<?= $setting['kelurahan'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="<?= $setting['kecamatan'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kabupaten">Kabupaten</label>
                                <input type="text" name="kabupaten" class="form-control" id="kabupaten" value="<?= $setting['kabupaten'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fb">Facebook</label>
                                <input type="text" name="fb" class="form-control" id="fb" value="<?= $setting['fb'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tlp">Telepon</label>
                                <input type="number" name="tlp" min="1" class="form-control" id="tlp" value="<?= $setting['tlp'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?= $setting['email'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="map">Map</label>
                        <textarea name="map" name="map" id="map" cols="30" rows="5" class="form-control"><?= $setting['map'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-flat bg-cyan btn-md"><i class="fas fa-save"></i> Ubah Setingan</button>
                    </div>

                    <?= form_close() ?>
                </div>


                <div class="tab-pane fade mb-3" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <?= form_open('admin/hapusKritikBanyak', ['class' => 'formHapusBanyak']) ?>
                    <p class="mb-3 mt-3">
                        <!-- tombol simpan banyak -->
                        <button type="submit" class="btn btn-danger btn-xs btn-flat"> <i class="fas fa-trash"></i> &nbsp; Hapus yang dipilih</button>
                    </p>

                    <table id="tb-kritik" class="table table-striped mt-3">
                        <thead class="table-dark text-center">
                            <th width="10" class="text-center">
                                <input type="checkbox" id="centangSemua">
                            </th>
                            <th>No</th>
                            <th>Email</th>
                            <th>Tanggal</th>
                            <th width="200"><i class=" fas fa-certificate"></i></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <?= form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // sweetalert flashdata
    const fd = $('.flash-data').data('flashdata');
    // jika ada flashDatanya maka jalankan sweetalertnya
    if (fd) {
        Swal.fire(
            'Berhasil',
            flashData,
            'success'
        )
    }



    function editFotoSekolah(id_setting) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditGambarSekolah') ?>",
            data: {
                id_setting: id_setting
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEditGambarSekolah').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function tampilDataKritikServerside() {
        var table = $('#tb-kritik').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/tampilDataKritikServerside') ?>",
                "type": "post"
            },
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }, {
                "targets": 1,
                "orderable": false
            }, ]
        })
    }

    $(document).ready(function() {
        tampilDataKritikServerside();

        // tombol centang semua
        $('#centangSemua').click(function() {

            if ($(this).is(':checked')) {
                $('.centangKritik').prop('checked', true);
            } else {
                $('.centangKritik').prop('checked', false);

            }
        })

        // tombol hapus banyak
        $('.formHapusBanyak').submit(function(e) {
            e.preventDefault();

            let jmlData = $('.centangKritik:checked');

            if (jmlData.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: 'Silahkan pilih data yang akan di hapus.',
                })
            } else {
                Swal.fire({
                    title: 'Hapus',
                    text: `Apakah yakin akan menghapus ${jmlData.length} data ..?`,
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

    // tombol detail
    function detail(id_kritik) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/detailKritik') ?>",
            data: {
                id_kritik: id_kritik
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalKritik').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }


    // tombol hapus
    function hapus(id_kritik) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ini.?`,
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
                    url: "<?= site_url('admin/hapusKritik') ?>",
                    data: {
                        id_kritik: id_kritik
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

    function previewImg() {
        const file = document.querySelector('#file');
        const sampulLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');

        sampulLabel.textContent = file.files[0].name;

        const fileSampul = new FileReader();
        // ambil url tempat penyimpanan gambar
        fileSampul.readAsDataURL(file.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>


<?= $this->endsection(); ?>