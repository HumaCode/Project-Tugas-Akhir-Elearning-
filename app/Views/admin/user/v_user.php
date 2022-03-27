<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">User</h3>

            <div class="card-tools">
                <button type="button" class="btn bg-cyan btn-flat btn-xs tombol-tambah"><i class="fas fa-plus"></i> Tambah</button>
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
                    <i class="fas fa-exclamation-circle"></i> Petunjuk Menambahkan User
                </h4>
            </div>
        </a>
        <div id="collapseOne" class="collapse" data-parent="#accordion">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">* Jika ingin menambahkan siswa, username diisikan dengan NIS Siswa.</li>
                    <li class="list-group-item">* Jika statusnya admin ataupun guru, username boleh di isi NIP Guru.</li>
                    <li class="list-group-item">* Untuk user siswa, kolom email boleh di kosongkan, jika punya boleh di isi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    // function data user
    function dataUser() {
        $.ajax({
            url: "<?= site_url('admin/ambilDataUser') ?>",
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
        dataUser(); // menampilkan data User


        // tombol tambah
        $('.tombol-tambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('admin/formTambahUser') ?>",
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