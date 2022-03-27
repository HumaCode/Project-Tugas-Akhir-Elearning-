<?php

// agar template_frontend terkoneksi dengan database
$db = \Config\Database::connect();

$setting = $db->table('tb_setting')
    ->where('id_setting', 1)
    ->get()
    ->getRowArray();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elearning | <?= $title ?></title>

    <link rel="icon" href="<?= base_url('assets/img/' . $setting['logo']) ?>" type="image*">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/fontawesome-free/css/all.min.css">
    <!-- Select 2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/dist/css/adminlte.min.css">
    <!-- select -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugin/bootstrap-select/bootstrap-select.css">

    <!-- css custom -->
    <?= $this->renderSection('css'); ?>


    <style>
        .bg {
            background-image: url('<?= base_url('assets/img/bg.png') ?>');
        }

        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>


    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select 2 -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/dist/js/adminlte.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>
    <!-- select -->
    <script src="<?= base_url() ?>/assets/plugin/bootstrap-select/bootstrap-select.js"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">


    <?php


    // menghitung jumlah pesan yang masuk

    use App\Models\ModelChat;

    $session = session();
    $modelMessages = new ModelChat();
    $count_inbox = $modelMessages->where('id_penerima', $session->id_user)
        ->where('is_read', 0)
        ->countAllResults();


    ?>

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-cyan navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-sm-inline-block ">
                    <a href="" class="nav-link" style="color: white !important;"><?= $setting['nama_sekolah'] ?></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item d-sm-inline-block ">
                    <a href="<?= base_url('chat/index') ?>" class="nav-link"> <i class="far fa-comments"></i><span class="badge badge-danger navbar-badge"><?= ($count_inbox == 0) ? '' : $count_inbox ?></span></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar  elevation-4 sidebar-dark-cyan">
            <!-- Brand Logo -->
            <a href="<?= base_url('admin') ?>" class="brand-link">
                <img src="<?= base_url('assets/img/' . $setting['logo']) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 " style="opacity: .8">
                <span class="brand-text font-weight-light"><strong>Elearning</strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('assets/img/user/' .  session()->get('foto')) ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= session()->get('nama_user') ?></a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">


                        <?php if (session()->get('role') == 1) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin') ?>" class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>">
                                    <i class="fas fa-tachometer-alt nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>

                            <li class="nav-item <?= ($title == 'Daftar Guru' || $title == 'Daftar Siswa' || $title == 'Daftar User') ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Manajemen User
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/guru') ?>" class="nav-link <?= ($title == 'Daftar Guru') ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Guru</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/siswa') ?>" class="nav-link <?= ($title == 'Daftar Siswa') ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Siswa</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/user') ?>" class="nav-link <?= ($title == 'Daftar User') ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar User</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/mapel') ?>" class="nav-link <?= ($title == 'Daftar Matapelajaran') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Daftar Mapel
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/kelas') ?>" class="nav-link <?= ($title == 'Daftar Kelas') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-certificate"></i>
                                    <p>
                                        Daftar Kelas
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/ta') ?>" class="nav-link <?= ($title == 'Tahun Pelajaran') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-certificate"></i>
                                    <p>
                                        Tahun Pelajaran
                                    </p>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (session()->get('role') == 1) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/kursus') ?>" class="nav-link <?= ($title == 'Daftar Kursus') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Daftar Kursus
                                    </p>
                                </a>
                            </li>
                        <?php } else if (session()->get('role') == 2) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('guru') ?>" class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>">
                                    <i class="fas fa-tachometer-alt nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('guru/kursus') ?>" class="nav-link <?= ($title == 'Daftar Kursus') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Daftar Kursus
                                    </p>
                                </a>
                            </li>

                        <?php } ?>

                        <div class="user-panel mt-2 d-flex"></div>

                        <li class="nav-item">
                            <a href="<?= (session()->get('role') == 1) ? base_url('admin/profil') : base_url('guru/profil') ?>" class="nav-link <?= ($title == 'Profil Saya') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profil Saya
                                </p>
                            </a>
                        </li>

                        <?php if (session()->get('role') == 1) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/setting') ?>" class="nav-link <?= ($title == 'Setting') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>
                                        Setting
                                    </p>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $icon . ' ' . $title ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item text-primary">Elearning</li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- content -->
                        <?= $this->renderSection('content'); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="logout">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-warning"><i class="fas fa-exclamation-triangle"></i> Perhatian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda ingin logout dan mengakhiri sesi..?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal">Batal</button>
                        <a href="<?= base_url('auth/logoutAdminGuru') ?>" class="btn btn-primary btn-sm btn-flat">Ya, Logout</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Project Tugas Akhir
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2022 | <?= $setting['nama_sekolah'] ?>.</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- memanggil section script custom -->
    <?= $this->renderSection('script'); ?>

    <script>
        window.setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);

        // sweetalert flashdata
        const flashData = $('.flash-data').data('flashdata');
        // jika ada flashDatanya maka jalankan sweetalertnya
        if (flashData) {
            Swal.fire(
                'Berhasil',
                flashData,
                'success'
            )
        }

        // tombol hapus
        $('.tombol-hapus').on('click', function(e) {
            e.preventDefault();

            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda Yakin.?',
                text: "Data ini akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data'
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            })
        });

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>

</body>

</html>