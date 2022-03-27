<table id="tb-guru" class="table table-bordered table-hover projects">
    <thead class="thead-dark text-center">
        <tr>
            <th width="30">No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Status User</th>
            <th width="200"><i class="fas fa-certificate"></i></th>
        </tr>
    </thead>
    <tbody>


    </tbody>
</table>

<script>
    function tampilDataGuruServerside() {
        var table = $('#tb-guru').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/tampilDataGuruServerside') ?>",
                "type": "post"
            },
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }, ]
        })
    }

    $(document).ready(function() {
        tampilDataGuruServerside();
    })

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

    // tombol detail
    function detail(id_guru) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/detailGuru') ?>",
            data: {
                id_guru: id_guru
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
    function edit(id_guru) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditGuru') ?>",
            data: {
                id_guru: id_guru
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
    function hapus(id_guru, nama_guru) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus data ${nama_guru}.`,
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
                    url: "<?= site_url('admin/hapusGuru') ?>",
                    data: {
                        id_guru: id_guru
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            })
                            dataGuru();
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