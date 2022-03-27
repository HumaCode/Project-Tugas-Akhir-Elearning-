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
    <title>E-learning | <?= $title ?></title>

    <link rel="icon" href="<?= base_url('assets/img/' . $setting['logo']) ?>" type="image*">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/ekko-lightbox/ekko-lightbox.css">

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
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>

    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>


</head>

<body class="hold-transition layout-top-nav">

    <?php


    // menghitung jumlah pesan yang masuk

    use App\Models\ModelChat;

    $session = session();
    $modelMessages = new ModelChat();
    $count_inbox = $modelMessages->where('id_penerima', $session->id_user)
        ->where('is_read', 0)
        ->countAllResults();


    ?>


    <div class="wrapper ">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-lightblue fixed-top">
            <div class="container">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <img src="<?= base_url('assets/img/' . $setting['logo']) ?>" alt="Elearning" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><strong>E-learning</strong></span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php if (session()->get('role') == 3) { ?>

                    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="<?= base_url('siswa') ?>" class="nav-link <?= ($title == 'Home') ? 'active' : '' ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('siswa/kursus') ?>" class="nav-link <?= ($title == 'Kursus Saya') ? 'active' : '' ?>">Kursus Saya</a>
                            </li>
                        </ul>

                    </div>
                <?php } ?>

                <!-- Right navbar links -->
                <?php if (session()->get('role') == '') { ?>

                <?php } else if (session()->get('role') == 3) { ?>
                    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                        <li class="nav-item d-sm-inline-block ">
                            <a href="<?= base_url('siswa/chat') ?>" class="nav-link"> <i class="far fa-comments"></i><span class="badge badge-danger navbar-badge"><?= ($count_inbox == 0) ? '' : $count_inbox ?></span></a>
                        </li>


                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><strong><?= session()->get('nama_user') ?></strong></a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="<?= base_url('siswa/profil') ?>" class="dropdown-item"><i class="fas fa-user"></i> &nbsp; Profil Saya </a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="<?= base_url('login/logout') ?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout </a></li>

                                <!-- End Level two -->
                            </ul>
                        </li>

                    </ul>
                <?php } ?>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg mt-5">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container mt-5">
                    <?php if (session()->get('role') == '') { ?>
                        <marquee behavior="" direction="">Silahkan login terlebih dahulu,&nbsp; jika mengalami kendala silahkan hubungi guru ataupun admin.</marquee>
                    <?php } ?>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> <?= $icon . ' ' . $title ?></h1>
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
                <div class="container">
                    <div class="row">

                        <!-- content -->
                        <?= $this->renderSection('content'); ?>

                    </div>
                </div>
            </div>
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

    <!-- REQUIRED SCRIPTS -->


    <!-- memanggil section script custom -->
    <?= $this->renderSection('script'); ?>


    <script>
        $(document).ready(function() {


            // sweetalert flashdata
            const flashData = $('.flash-data').data('flashdata');
            const flash = $('.flash').data('flashdata');
            const login = $('.login').data('flashdata');
            const logout = $('.logout').data('flashdata');
            // jika ada flashDatanya maka jalankan sweetalertnya
            if (flashData) {
                Swal.fire(
                    'Berhasil',
                    flashData,
                    'success'
                )
            }

            if (flash) {
                Swal.fire(
                    'Gagal',
                    flash,
                    'error'
                )
            }

            if (login) {
                Swal.fire({
                    icon: 'success',
                    title: login,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 2500,
                })
            }

            if (logout) {
                Swal.fire({
                    icon: 'success',
                    title: logout,
                    text: 'Terimakasih..',
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3000,
                })
            }
        })
    </script>

</body>

</html>