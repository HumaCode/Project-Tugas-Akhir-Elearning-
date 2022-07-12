<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Landing Page</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="<?= base_url() ?>/landing/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?= base_url() ?>/landing/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="<?= base_url() ?>/landing/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="<?= base_url('assets/img/' . $setting['logo']) ?>" type="image*">

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/landing/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <!-- <div class="loader_bg">
        <div class="loader"><img src="<?= base_url() ?>/landing/images/loading.gif" alt="#" /></div>
    </div> -->
    <!-- end loader -->
    <div class="wrapper">
        <!-- end loader -->
        <div class="sidebar">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="fa fa-arrow-left"></i>
                </div>
                <ul class="list-unstyled components">
                    <li class=""> <a href="#">Home</a> </li>
                    <li><a href="#about" class="">Tentang Kami </a> </li>
                    <li><a href="#contact">Kontak </a> </li>
                </ul>
            </nav>
        </div>
        <div id="content">
            <!-- header -->
            <header>
                <!-- header inner -->
                <div class="header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                                <div class="full">
                                    <div class="center-desk">
                                        <div class="logo">
                                            <a href="index.html"><img src="<?= base_url('assets/img/' . $setting['logo']) ?>" width="50" alt="#" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                                <ul class="btn">

                                    <li class="dropdown dropleft"><a href="#" class="dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item text-dark" href="<?= base_url('auth') ?>"><i class="fa fa-user"></i> &nbsp Guru/Admin</a>
                                            <div class="dropdown-divider "></div>
                                            <a class="dropdown-item text-dark" href="<?= base_url('login') ?>"><i class="fa fa-users"></i> &nbsp Siswa</a>
                                        </div>
                                    </li>
                                    <li><button type="button" id="sidebarCollapse">
                                            <img src="<?= base_url() ?>/landing/images/menu_icon.png" alt="#" />
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- end header inner -->
            <!-- end header -->
            <!-- banner -->
            <div id="myCarousel" class="carousel slide banner_main" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container-fluid">
                            <div class="carousel-caption">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                        <div class="text-bg">
                                            <h1>Halo..<br> Selamat Datang <br></h1>
                                            <p>Di Aplikasi Elearning SD Negeri 01 Wiroditan</p>
                                            <a class="read_more" href="#">Mulai</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                        <div class="images_box">
                                            <figure><img src="<?= base_url() ?>/landing/images/img2.png"></figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid ">
                            <div class="carousel-caption">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                        <div class="text-bg">
                                            <h1>Halo..<br> Selamat Datang <br></h1>
                                            <p>Di Aplikasi Elearning SD Negeri 01 Wiroditan</p>
                                            <a class="read_more" href="#">Mulai</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                        <div class="images_box">
                                            <figure><img src="<?= base_url() ?>/landing/images/img2.png"></figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid">
                            <div class="carousel-caption ">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                        <div class="text-bg">
                                            <h1>Halo..<br> Selamat Datang <br></h1>
                                            <p>Di Aplikasi Elearning SD Negeri 01 Wiroditan</p>
                                            <a class="read_more" href="#">Mulai</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                        <div class="images_box">
                                            <figure><img src="<?= base_url() ?>/landing/images/img2.png"></figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                    <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <!-- end banner -->
            <!-- about -->
            <div id="about" class="about">
                <div class="container-fluid">
                    <div class="row d_flex">
                        <div class="col-md-6">
                            <div class="about_img">
                                <figure><img src="<?= base_url('assets/img/' . $setting['foto']) ?>" style="border-radius: 20px;" alt="#" /></figure>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="titlepage">
                                <h2>Tentang <span class="blu">Kami</span></h2>

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
                    </div>
                </div>
            </div>
            <!-- end about -->


            <!-- request -->
            <div id="contact" class="choose_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="titlepage">
                                <h2>Kritik <span class="white">dan Saran</span></h2>
                            </div>
                        </div>
                    </div>
                    <?= form_open('home/kritik', ['class' => 'formKritik']) ?>
                    <?= csrf_field() ?>
                    <div class="row">

                        <div class="col-md-6">
                            <div id="request" class="main_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="contactus" placeholder="Masukan Email" type="email" name="Email">
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-white">Kritik</p>
                                        <textarea class="textarea" placeholder="Kritik" name="kritik" id="kritik"> </textarea>
                                        <div class="invalid-feedback errorKritik"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-white">Saran</p>
                                        <textarea class="textarea" placeholder="Saran" name="saran" id="saran"> </textarea>
                                        <div class="invalid-feedback errorSaran"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="send_btn btnKirim" type="submit">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="embed-responsive embed-responsive-4by3">

                                <iframe src="<?= $setting['map'] ?>" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>

                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <!-- end request -->
            <!--  footer -->
            <footer>
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-8 col-sm-6">
                                        <div class="address">
                                            <h3>Alamat </h3>
                                        </div>
                                        <ul class="location_icon">
                                            <li><?= $setting['alamat'] . ' Rt: ' . $setting['rt'] . '/Rw: ' . $setting['rw'] . ' kel. ' . $setting['kelurahan'] . '  kec. ' . $setting['kecamatan'] . '  kab. ' . $setting['kabupaten'] ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="address">
                                            <h3>Links</h3>
                                            <ul class="Menu_footer">
                                                <li class="active"> <a href="#">Home</a> </li>
                                                <li><a href="#about">Tentang Kami </a> </li>
                                                <li><a href="#contact">Kontak </a> </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">

                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                        <div class="address">
                                            <h3>Sosial Media</h3>
                                        </div>
                                        <ul class="social_icon">
                                            <li><a href="#"><?= $setting['fb'] ?> <i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"> <?= $setting['email'] ?><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                                            <li><a href="#"> <?= $setting['tlp'] ?><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="copyright">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Copyright 2019 | <?= $setting['nama_sekolah'] ?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end footer -->
        </div>
        <div class="overlay"></div>
        <!-- Javascript files-->
        <script src="<?= base_url() ?>/landing/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>/landing/js/popper.min.js"></script>
        <script src="<?= base_url() ?>/landing/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>/landing/js/jquery-3.0.0.min.js"></script>

        <!-- SweetAlert -->
        <script src="<?= base_url() ?>/assets/vendor/sweetalert/sweetalert2.all.min.js"></script>


        <!-- sidebar -->
        <script src="<?= base_url() ?>/landing/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?= base_url() ?>/landing/js/custom.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function() {
                    $('#sidebar').removeClass('active');
                    $('.overlay').removeClass('active');
                });

                $('#sidebarCollapse').on('click', function() {
                    $('#sidebar').addClass('active');
                    $('.overlay').addClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>



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
                        $('.btnKirim').html('Kirim');
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.kritik) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.error.kritik,
                                })
                                return false;
                            }

                            if (response.error.saran) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.error.saran,
                                })
                                return false;
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