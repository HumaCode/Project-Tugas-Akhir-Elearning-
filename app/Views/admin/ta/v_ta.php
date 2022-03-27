<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<!-- flashdata -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>

<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Tahun Pelajaran</h3>

            <div class="card-tools">
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> Tambah</button>
            </div>
        </div>
        <div class="card-body viewData">

        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // function data ta
    function dataTa() {
        $.ajax({
            url: "<?= site_url('admin/ambilDataTa') ?>",
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
        dataTa(); // menampilkan data ta


        // tombol tambah
        $('.tombol-tambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formTambahTa') ?>",
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
    });
</script>

<?= $this->endsection(); ?>