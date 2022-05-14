<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-12">


    <!-- flashdata -->
    <?php if (session()->getFlashdata('pesan')) { ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
    <?php } elseif (session()->getFlashdata('error')) {  ?>
        <div class="flash" data-flashdata="<?= session()->getFlashdata('error') ?>"></div>
    <?php } ?>

    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Guru</h3>

            <div class="card-tools">
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> Tambah</button>
                <button type="button" class="btn btn-success btn-flat btn-xs tombol-import"><i class="fa fa-file-excel"></i> Import Excel</button>
            </div>
        </div>
        <div class="card-body viewData">

        </div>
    </div>
</div>

<div class="col-12" id="accordion">
    <div class="card card-primary card-outline">
        <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
            <div class="card-header">
                <h4 class="card-title w-100 text-warning">
                    <i class="fas fa-exclamation-circle"></i> Petunjuk Menambahkan Guru
                </h4>
            </div>
        </a>
        <div id="collapseOne" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">* Petunjuk import data guru dengan excel <a href="" data-toggle="modal" data-target="#guru">Klik Disini</a>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<!-- Modal Petunjuk import-->
<div class="modal fade" id="guru" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Petunjuk Import dengan Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/Gguru.png') ?>" class="img-fluid">
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">* Samakan struktur tabel seperti gambar diatas.</li>
                    <li class="list-group-item">* Untuk email, silahkan diisikan email milik masing-masing guru.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> &nbsp;Kembali</button>
            </div>
        </div>
    </div>
</div>

<script>
    function dataGuru() {
        $.ajax({
            url: "<?= site_url('admin/ambilDataGuru') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewData').html(response.data);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }


    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');
        dataGuru();

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

        // tombol tambah
        $('.tombol-tambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formTambahGuru') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewModal').html(response.data).show();
                    $('#modalTambah').modal('show');
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        // tombol import guru
        $('.tombol-import').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formImportGuru') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewModal').html(response.data).show();
                    $('#modalImport').modal('show');
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    })
</script>

<?= $this->endsection(); ?>