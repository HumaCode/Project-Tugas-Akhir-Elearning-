<?= $this->extend('layouts/template-frontend'); ?>

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


<div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-cyan card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/img/user/' . session()->get('foto')) ?>" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center"><?= session()->get('nama_user') ?></h3>

            <p class="text-muted text-center"><?= $profil['kelas'] ?>
            </p>

            <ul class="list-group list-group-unbordered mb-2">
                <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?= $profil['email'] ?></a>
                </li>
                <li class="list-group-item">
                    <b>Password</b> <a class="float-right">********</a>
                </li>
            </ul>

            <button type="button" onclick="editFoto(<?= $profil['id_siswa'] ?>)" class="btn bg-cyan btn-block btn-flat"><b>Ubah Foto</b></button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>

<div class="col-md-9">
    <div class="card card-outline card-cyan">
        <div class="card-header ">
            <h2 class="card-title">Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="edit(<?= $profil['id_siswa'] ?>)">
                        <i class="fas fa-pencil-alt text-cyan"></i>
                    </button>
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped mt-2 mb-3">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?= $profil['nama_siswa'] ?></td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td><?= $profil['nis'] ?></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>:</td>
                    <td>
                        <span class="badge badge-info"><?= ($profil['role'] == 3) ? 'Siswa' : '' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Status Akun</td>
                    <td>:</td>
                    <td><?= ($profil['is_active'] == 1) ? '<span class="text-success">Aktif</span>' : '<span class="text-danger">Tidak Aktif</span>' ?></td>
                </tr>
                <tr>
                    <td>Tanggal Daftar Aplikasi</td>
                    <td>:</td>
                    <td><?= tanggal_indonesia(session()->get('created_at'), false) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // tombol edit profil
    function edit(id_siswa) {
        $.ajax({
            type: "post",
            url: "<?= site_url('siswa/formEditProfil') ?>",
            data: {
                id_siswa: id_siswa
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEditProfil').modal('show');
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

    // tombol edit foto
    function editFoto(id_siswa) {
        $.ajax({
            type: "post",
            url: "<?= site_url('siswa/formEditFotoProfil') ?>",
            data: {
                id_siswa: id_siswa
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEditFotoProfil').modal('show');
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