<?= form_open('admin/hapusMapelBanyak', ['class' => 'formHapusBanyak']) ?>
<p class="mb-3">
    <!-- tombol simpan banyak -->
    <button type="submit" class="btn btn-danger btn-xs btn-flat"> <i class="fas fa-trash"></i> &nbsp; Hapus yang dipilih</button>
</p>

<table id="tb-mapel" class="table table-bordered table-hover">

    <thead class="thead-dark text-center">
        <tr>
            <th width="10" class="text-center">
                <input type="checkbox" id="centangSemua">
            </th>
            <th width="30">No</th>
            <th>Mapel</th>
            <th width="100"><i class="fas fa-certificate"></i></th>
        </tr>
    </thead>
    <tbody>


    </tbody>
</table>
<?= form_close() ?>

<script>
    function tampilDataMapelServerside() {
        var table = $('#tb-mapel').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/tampilDataMapelServerside') ?>",
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

        tampilDataMapelServerside();

        // tombol centang semua
        $('#centangSemua').click(function() {

            if ($(this).is(':checked')) {
                $('.centangMapel').prop('checked', true);
            } else {
                $('.centangMapel').prop('checked', false);

            }
        })

        // tombol hapus banyak
        $('.formHapusBanyak').submit(function(e) {
            e.preventDefault();

            let jmlData = $('.centangMapel:checked');

            if (jmlData.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: 'Silahkan pilih data yang akan di hapus.',
                })
            } else {
                Swal.fire({
                    title: 'Hapus Data Mapel',
                    text: `Apakah yakin akan menghapus ${jmlData.length} data mapel..?`,
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
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.success,
                                    })

                                    dataMapel();
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
    function edit(id_mapel) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/formEditMapel') ?>",
            data: {
                id_mapel: id_mapel
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
    function hapus(id_mapel, mapel) {
        Swal.fire({
            title: 'Hapus Data.',
            text: `Apakah kamu yakin akan menghapus mapel ${mapel}.`,
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
                    url: "<?= site_url('admin/hapusMapel') ?>",
                    data: {
                        id_mapel: id_mapel
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        })

                        dataMapel();

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
        })
    }
</script>