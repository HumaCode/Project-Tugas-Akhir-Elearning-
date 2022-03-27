<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Kelas</h3>

            <div class="card-tools">
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> Tambah</button>
                <button type="button" class="btn btn-success btn-flat btn-xs tombol-tambah-banyak"><i class="fas fa-plus"></i> <i class="fas fa-plus"></i> Tambah Lebih</button>
            </div>
        </div>
        <div class="card-body viewData">

        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // function data kelas
    function dataKelas() {
        $.ajax({
            url: "<?= site_url('admin/ambilDataKelas') ?>",
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
        dataKelas(); // menampilkan data kelas


        // tombol tambah
        $('.tombol-tambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formTambahKelas') ?>",
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

        // tombol tambah banyak
        $('.tombol-tambah-banyak').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formTambahKelasBanyak') ?>",
                dataType: "json",
                beforeSend: function() {
                    $('.viewData').html('<center style="font-size: 100px; color: cyan;"><i class="fa fa-spin fa-spinner"></i></center>');
                },
                success: function(response) {
                    $('.viewData').html(response.data).show();
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    });
</script>

<?= $this->endsection(); ?>