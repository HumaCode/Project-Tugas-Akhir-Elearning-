<?= form_open('admin/simpanDataBanyak', ['class' => 'formSimpanBanyak']) ?>
<?= csrf_field() ?>
<table class="table table-bordered text-nowrap">

    <!-- tombol simpan banyak -->
    <button type="submit" class="btn btn-secondary btn-xs btn-flat btnSimpanBanyak float-right mb-3 ml-2"> <i class="fas fa-save"></i> &nbsp; Simpan Semua</button>

    <!-- tombol kembali -->
    <button type="button" class="btn btn-danger btn-xs btn-flat btnKembali float-right mb-3"> <i class="fas fa-arrow-circle-left"></i> &nbsp; Kembali</button>



    <thead class="table-dark text-center">
        <tr>
            <th>Kelas</th>
            <th width="70"><i class="fas fa-certificate"></i></th>
        </tr>
    </thead>
    <tbody class="formTambah">
        <tr>
            <td>
                <input type="text" name="kelas[]" class="form-control form-control-sm" style="border-radius: 0px;" placeholder="Masukan Kelas" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-primary btn-sm btn-flat btnTambahBanyak"><i class="fas fa-plus"></i></button>
            </td>
        </tr>
    </tbody>
</table>
<?= form_close() ?>

<script>
    $(document).ready(function(e) {

        // tombol submit
        $('.formSimpanBanyak').submit(function() {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSimpanBanyak').attr('disable', 'disabled');
                    $('.btnSimpanBanyak').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnSimpanBanyak').removeAttr('disable', 'disabled');
                    $('.btnSimpanBanyak').html('<i class="fas fa-save"></i>&nbsp; Simpan Semua');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: `${response.success}`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = ("<?= site_url('admin/kelas') ?>")
                            }
                        })

                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
            return false;
        })


        // tombol tambah form
        $('.btnTambahBanyak').click(function(e) {
            e.preventDefault();

            $('.formTambah').append(`
                <tr>
                    <td>
                        <input type="text" name="kelas[]" class="form-control form-control-sm" style="border-radius: 0px;" placeholder="Masukan Kelas" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-flat btnHapusForm"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `);
        })


        // tombol kembali
        $('.btnKembali').click(function(e) {
            e.preventDefault();

            dataKelas();
        })
    })

    // tombol hapus form banyak
    $(document).on('click', '.btnHapusForm', function(e) {
        e.preventDefault();

        $(this).parents('tr').remove()
    })
</script>