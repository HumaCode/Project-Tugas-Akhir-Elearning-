<!-- Modal -->
<div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail <?= $nama_user ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4 text-center mt-3">
                        <img src="<?= base_url('assets/img/user/' . $foto) ?>" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8">
                        <table class="mt-1">
                            <tr>
                                <td width="100">Nama</td>
                                <td>:</td>
                                <td><?= $nama_user ?></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td><?= $username ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?= ($email == null) ? '-' : $email ?></td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>:</td>
                                <td>
                                    <?php if ($role == 1) { ?>
                                        <span class="badge badge-info">Admin</span>
                                    <?php } else if ($role == 2) { ?>
                                        <span class="badge badge-success">Guru</span>
                                    <?php } else { ?>
                                        <span class="badge badge-secondary">Siswa</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Status Akun</td>
                                <td>:</td>
                                <td><?= ($is_active == 1) ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>' ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Daftar</td>
                                <td>:</td>
                                <td><?= tanggal_indonesia($created_at, false) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>