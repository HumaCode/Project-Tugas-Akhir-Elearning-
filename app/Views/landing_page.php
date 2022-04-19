<!doctype html>
<html lang="en" id="home">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?= base_url('assets/img/' . $setting['logo']) ?>" type="image*">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/fontawesome-free/css/all.min.css">
    <!-- Fansybox -->
    <link href="<?= base_url() ?>/assets/plugin/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" rel="stylesheet">


    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">

    <title>E-Learning</title>

    <style>
        .bg {
            background-image: url('<?= base_url('assets/img/bg.png') ?>');
        }
    </style>
</head>

<body class="bg">

    <!-- nav bar  -->
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand page-scroll" href="#home">Elearning</a>
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#deskripsi">Deskripsi <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#profil">Profile <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#map">Map <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#qna">Kritik dan Saran <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown dropleft">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= base_url('auth') ?>"><i class="fas fa-user-tie"></i> Guru/Admin</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('login') ?>"><i class="fas fa-user"></i> Siswa</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- AKHIR NAVBAR -->

    <!-- coreusel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= base_url('assets/img/1.png') ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/img/2.png') ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('assets/img/3.png') ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- AWAL DESKRIPSI -->
    <section class="deskripsi" id="deskripsi">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">Deskripsi</h2>
                    <hr>
                </div>
            </div>

            <div class="row text-justify">
                <div class="col-sm-6 ">
                    <p class="pKiri"><?= $setting['desk1'] ?></p>
                    <p class="pKiri"><?= $setting['desk2'] ?></p>
                </div>
                <div class="col-sm-6">
                    <p class="pKanan"><?= $setting['desk3'] ?></p>
                    <p class="pKanan"><?= $setting['desk4'] ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- AKHIR ABOUT -->

    <!-- AWAL PROFILE -->
    <section class="portfolio" id="profil">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">Profil</h2>
                    <hr>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-5 offset-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?= base_url('assets/img/' . $setting['foto']) ?>" class="perbesar img-fluid">
                                <img src="<?= base_url('assets/img/' . $setting['foto']) ?>" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <table>
                        <tr>
                            <td>Nama Sekolah</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['nama_sekolah'] ?></td>
                        </tr>
                        <tr>
                            <td>NPSN</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['npsn'] ?></td>
                        </tr>
                        <tr>
                            <td>Jenjang Pendidikan</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['jenjang'] ?></td>
                        </tr>
                        <tr>
                            <td>Status Sekolah</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['status_sekolah'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat Sekolah</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td>RT / RW</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['rt'] . '/' . $setting['rw'] ?></td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['kd_pos'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['kelurahan'] ?></td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['kecamatan'] ?></td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $setting['kabupaten'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-9 offset-sm-3">
                    <i class="fa fa-at mr-5"> Email : <?= $setting['email'] ?></i> <i class="fa fa-facebook mr-5"> Facebook : <?= $setting['fb'] ?></i> <i class="fa fa-phone"> Telepon : <?= $setting['tlp'] ?></i>
                </div>
            </div>
        </div>


    </section>
    <!-- AKHIR PROFIL -->

    <!-- AWAL MAP -->
    <section class="map" id="map">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">Map</h2>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 ">
                    <div class="embed-responsive embed-responsive-4by3">

                        <iframe src="<?= $setting['map'] ?>" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- AKHIR MAP -->

    <!-- CONTACT -->
    <section class="portfolio contact" id="qna">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2>Kritik dan Saran</h2>
                    <hr>
                </div>
            </div>

            <div class="row ">
                <div class="col-sm-8 offset-sm-2">
                    <?= form_open('home/kritik', ['class' => 'formKritik']) ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="masukan email kamu" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="kritik">Kritik</label>
                        <textarea class="form-control" name="kritik" id="kritik" rows="10"></textarea>
                        <div class="invalid-feedback errorKritik"></div>
                    </div>

                    <div class="form-group">
                        <label for="saran">Saran</label>
                        <textarea class="form-control" name="saran" id="saran" rows="10"></textarea>
                        <div class="invalid-feedback errorSaran"></div>
                    </div>

                    <button class="btn btn-primary mb-4 btn-kirim" type="submit">KIRIM</button>
                    <button class="btn btn-danger mb-4" type="reset">RESET</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </section>
    <!-- AKHIR CONTACT -->

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-12">
                    <p>&copy; copyright 2020 | Built by. <a href="http://instagram.com/amirzakaria986671">amirzakaria98</a>.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- AKHIR FOOTER -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/vendor/adminLTE3/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Fancy box -->
    <script src="<?= base_url() ?>/assets/plugin/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script>
        $(document).ready(function() {
            $('.perbesar').fancybox();
        });
    </script>
    <!-- SweetAlert -->
    <script src="<?= base_url() ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>


    <script src="<?= base_url() ?>/assets/js/jquery.easing.1.3.js"></script>
    <script src="<?= base_url() ?>/assets/js/script.js"></script>



    <script>
        const flashData = $('.flash-data').data('flashdata');

        // jika ada flashDatanya maka jalankan sweetalertnya
        if (flashData) {
            Swal.fire(
                'Kritik dan Saran',
                'Berhasil ' + flashData,
                'success'
            )
        }

        // form kritik
        $('.formKritik').submit(function() {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnKirim').attr('disable', 'disabled');
                    $('.btnKirim').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnKirim').removeAttr('disable', 'disabled');
                    $('.btnKirim').html('<i class="fas fa-save"></i>&nbsp; Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.kritik) {
                            $('#kritik').addClass('is-invalid');
                            $('.errorKritik').html(response.error.kritik);
                        } else {
                            $('#kritik').remove('is-invalid');
                            $('.errorKritik').html('');
                        }

                        if (response.error.saran) {
                            $('#saran').addClass('is-invalid');
                            $('.errorSaran').html(response.error.saran);
                        } else {
                            $('#saran').remove('is-invalid');
                            $('.errorSaran').html('');
                        }
                    } else {
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
            return false;
        })
    </script>
</body>

</html>