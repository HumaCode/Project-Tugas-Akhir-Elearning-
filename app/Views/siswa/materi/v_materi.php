<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <ul class="list-group">
        <?php if (empty($materi)) { ?>

            <div class="alert alert-danger text-center">
                Belum ada materi yang dikirim guru
            </div>

        <?php } else { ?>

            <div class="col-md-12">
                <?php if (!empty($absen['id_absen'])) { ?>
                    <?php if ($absen['absen'] == 0) { ?>
                        <marquee behavior="" direction="" class="text-danger">Jangan lupa untuk melakukan absensi</marquee>

                        <div class="row">
                            <?php if ($sub_kursus['tipe'] == 0) { ?>
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-secondary btn-sm btn-flat " id="t-absen" onclick="foto('<?= $id_kursus ?>', '<?= $id_sub_kursus ?>')">Absensi</button>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-secondary btn-sm btn-flat " id="t-absen" onclick="absensi('<?= $id_kursus ?>', '<?= $id_sub_kursus ?>')">Absensi</button>
                                </div>
                            <?php } ?>


                            <div class="col-md-10">
                                <button id="mulai" class="btn btn-secondary btn-sm"></button>
                            </div>
                        </div>

                    <?php } else if ($absen['absen'] != 0) { ?>

                        <strong class="text-success text-center">Kamu Sudah Absen</strong>
                        <button id="mulai" class="btn btn-secondary btn-sm"></button>

                    <?php } ?>
                <?php } ?>
            </div>

            <hr>

            <?php foreach ($materi as $m) :  ?>
                <li class="list-group-item mb-2 bg-lightblue" style="border-radius: 10px;"><strong><?= $m['judul'] ?></strong> <span class="badge badge-warning float-right "><a href="<?= base_url('siswa/lihatMateri/' . $m['id_materi'] . '/' . $id_kursus . '/' . $id_sub_kursus) ?>" class="text-dark">Lihat</a></span></li>
            <?php endforeach; ?>

        <?php } ?>
    </ul>
    <hr>

    <a href="<?= base_url('siswa/subKursus/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block mt-3">Kembali</a>
</div>

<div class="viewModal" style="display: none;"></div>

<?= $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<?= $this->endsection(); ?>

<script>
    // tombol absensi
    function foto(id_kursus, id_sub_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('siswa/formAbsen') ?>",
            data: {
                id_kursus: id_kursus,
                id_sub_kursus: id_sub_kursus
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalAbsen').modal('show');
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

    // tombol absensi
    function absensi(id_kursus, id_sub_kursus) {
        $.ajax({
            type: "post",
            url: "<?= site_url('siswa/formAbsen2') ?>",
            data: {
                id_kursus: id_kursus,
                id_sub_kursus: id_sub_kursus
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


    // Set a valid end date
    var countDownDate = new Date("<?= $sub_kursus['mulai'] ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the countdown date
        var distance = countDownDate - now;

        // Calculate Remaining Time
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("mulai").innerHTML = days + " : " + hours + " : " + minutes + " :  " + seconds + " ";

        // If the countdown is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("mulai").innerHTML = "<span class='text-white'>Waktu Absensi Sudah Habis</span>";
            document.getElementById("t-absen").style.display = "none";
        }
    }, 1000);
</script>



<?= $this->endsection(); ?>