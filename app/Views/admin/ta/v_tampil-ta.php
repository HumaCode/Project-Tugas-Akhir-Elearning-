<?= form_open('admin/hapusTaBanyak', ['class' => 'formHapusBanyak']) ?>
<p class="mb-3">
    <!-- tombol simpan banyak -->
    <button type="submit" class="btn btn-danger btn-xs btn-flat"> <i class="fas fa-trash"></i> &nbsp; Hapus yang dipilih</button>
</p>

<table id="tb-ta" class="table table-bordered table-hover">

    <thead class="thead-dark text-center">
        <tr>
            <th width="10" class="text-center">
                <input type="checkbox" id="centangSemua">
            </th>
            <th width="30">No</th>
            <th>Tahun</th>
            <th>Semester</th>
            <th>Status</th>
            <th width="100"><i class="fas fa-certificate"></i></th>
        </tr>
    </thead>
    <tbody>


    </tbody>
</table>
<?= form_close() ?>

<script>
    function tampilDataTaServerside() {
        var table = $('#tb-ta').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/tampilDataTaServerside') ?>",
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

        tampilDataTaServerside();

        // tombol centang semua
        $('#centangSemua').click(function() {

            if ($(this).is(':checked')) {
                $('.centangTa').prop('checked', true);
            } else {
                $('.centangTa').prop('checked', false);

            }
        })

        // tombol hapus banyak
        $('.formHapusBanyak').submit(function(e) {
            e.preventDefault();

            let jmlData = $('.centangTa:checked');

            if (jmlData.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: 'Silahkan pilih data yang akan di hapus.',
                })
            } else {
                Swal.fire({
                    title: 'Hapus Data Tahun Pelajaran',
                    text: `Apakah yakin akan menghapus ${jmlData.length} data tahun pelajaran..?`,
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
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                if (response.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.error,
                                    })

                                    dataTa();
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.success,
                                    })

                                    dataTa();
                                }
                            },
                            error: function(xhr, ajaxOption, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        })
                    }
                })
            }
            return false;
        })
    })

    // tombol edit
    function edit(id_ta) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditTa') ?>",
            data: {
                id_ta: id_ta
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
    function hapus(id_ta, tahun) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus tahun pelajaran ${tahun}.`,
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
                    url: "<?= site_url('admin/hapusTa') ?>",
                    data: {
                        id_ta: id_ta
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.error,
                            })
                            dataTa();
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            })
                            dataTa();
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