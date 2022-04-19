<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Detail Pesan Masuk</h3>
        </div>
        <div class="card-body ">
            <table>
                <tr>
                    <td width="100"><strong>Dari</strong></td>
                    <td width="20"><strong>:</strong></td>
                    <td><strong><?= $pengirim['nama_user'] ?></strong></td>
                </tr>

                <tr>
                    <td width="100"><strong>Ke</strong></td>
                    <td width="20"><strong>:</strong></td>
                    <td><strong><?= $penerima['nama_user'] ?></strong></td>
                </tr>
            </table>
            <hr>
            <table>
                <tr>
                    <td width="100">Pesan</td>
                    <td width="20">:</td>
                    <td><?= $pesan['pesan'] ?></td>
                </tr>
            </table>
            <hr>
            <?= form_open('chat/balasPesan', ['class' => 'formBalas']) ?>
            <?= csrf_field() ?>

            <input type="hidden" name="penerima" value="<?= $pengirim['id_user'] ?>">

            <textarea name="pesan" id="pesan" cols="30" rows="5" class="form-control"></textarea>
            <div class="invalid-feedback errorPesan"></div>
            <button type="submit" class="btn btn-primary btn-sm btn-flat mt-2 btnKirim"><i class="fa fa-paper-plane"></i>&nbsp; Kirim Pesan</button>
            <?= form_close() ?>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('admin/pesanMasuk') ?>" class="btn btn-danger btn-sm btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formBalas').submit(function() {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnKirim').attr('disable', 'disabled');
                    $('.btnKirim').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnKirim').removeAttr('disable', 'disabled');
                    $('.btnKirim').html('<i class="fa fa-paper-plane"></i>&nbsp; Kirim Pesan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.pesan) {
                            $('#pesan').addClass('is-invalid');
                            $('.errorPesan').html(response.error.pesan);
                        } else {
                            $('#pesan').remove('is-invalid');
                            $('.errorPesan').html('');
                        }

                    } else {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            window.location.href = '<?= base_url('admin/pesanKeluar') ?>';
                        })

                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
            return false;
        })
    })
</script>

<?= $this->endsection(); ?>