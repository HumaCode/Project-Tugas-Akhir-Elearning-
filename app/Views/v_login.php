<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elearning | <?= $title ?></title>

    <link rel="icon" href="<?= base_url('assets/img/' . $setting['logo']) ?>" type="image*">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/dist/css/adminlte.min.css">

    <style>
        .bg {
            background-image: url('<?= base_url('assets/img/bg.png') ?>');
        }
    </style>

</head>

<body class="hold-transition login-page bg">




    <div class="login-box">
        <div class="card card-outline card-lightblue mt-4">
            <div class="card-header text-center">
                <a href="<?= base_url() ?>" class="h1"><b>E</b>-Learning</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan login terlebih dahulu</p>

                <!-- flashdata sweetalert -->
                <?php
                if (session()->getFlashdata('pesan')) { ?>
                    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
                <?php } else { ?>
                    <div class="flash" data-flashdata="<?= session()->getFlashdata('p') ?>"></div>
                <?php } ?>

                <?= form_open('auth/loginAdminGuru') ?>
                <?= csrf_field() ?>
                <p class="text-danger"><?= $validation->hasError('email') ? $validation->getError('email') : '' ?></p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <p class="text-danger"><?= $validation->hasError('password') ? $validation->getError('password') : '' ?></p>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary"> <i class="fas fa-globe"></i>
                            <a href="<?= base_url() ?>" class="text-dark"> Landing Page</a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close() ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>

    <script>
        // sweetalert flashdata
        const flashData = $('.flash-data').data('flashdata');
        const flash = $('.flash').data('flashdata');
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
    </script>

</body>

</html>