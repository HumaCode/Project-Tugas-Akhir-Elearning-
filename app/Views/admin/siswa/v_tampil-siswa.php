<table id="tb-siswa" class="table table-bordered table-hover projects">
    <thead class="thead-dark text-center">
        <tr>
            <th width="30">No</th>
            <th>Nama</th>
            <th>NIS</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Kelas</th>
            <th>Status User</th>
            <th width="200"><i class="fas fa-certificate"></i></th>
        </tr>
    </thead>
    <tbody>


    </tbody>
</table>

<script>
    function tampilDataSiswaServerside() {
        var table = $('#tb-siswa').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/tampilDataSiswaServerside') ?>",
                "type": "post"
            },
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }, {
                "targets": 1,
                "orderable": false
            }, ]
        })
    }

    $(document).ready(function() {
        tampilDataSiswaServerside();
    })

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

    // tombol detail
    function detail(id_siswa) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/detailSiswa') ?>",
            data: {
                id_siswa: id_siswa
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalDetail').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    // tombol edit
    function edit(id_siswa) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditSiswa') ?>",
            data: {
                id_siswa: id_siswa
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.viewModal').html(response.success).show();
                    $('#modalEdit').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    // tombol hapus
    function hapus(id_siswa, nama_siswa) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ${nama_siswa}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Hapus',
            cancelButtonText: '<i class="fas fa-ban"></i> Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('admin/hapusSiswa') ?>",
                    data: {
                        id_siswa: id_siswa
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            })
                            dataSiswa();
                        }
                    },
                    error: function(xhr, ajaxOption, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                })
            }
        })
    }
</script>