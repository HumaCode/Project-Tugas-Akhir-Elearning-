<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>



<div class="col-md-4">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Kirim Ke</h3>
            <div class="card-tools">

            </div>

        </div>

        <div class="card-body">
            <div class="mailbox-controls">

                <?= form_open('chatSiswa/proses_kirim', ['class' => 'formKirim']) ?>
                <?= csrf_field() ?>

                <label for="">Penerima (User)</label>
                <div class="form-group">
                    <select class="form-control select2" name="penerima" id="penerima" style="width: 100%;">
                        <option value="">-- Pilih Penerima --</option>
                        <?php foreach ($user as $u) : ?>
                            <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?> | <?php if ($u['role'] == 1) {
                                                                                                echo 'Admin';
                                                                                            } else if ($u['role'] == 2) {
                                                                                                echo 'Guru';
                                                                                            } else {
                                                                                                echo 'Siswa';
                                                                                            } ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback errorPenerima"></div>
                </div>

                <br><br>
                <br>
                * Silahkan pilih penerima
            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="card card-cyan card-outline">
        <div class="card-header">Tulis Pesan</div>
        <div class="card-body">
            <div class="form-group">
                <textarea name="pesan" id="pesan" cols="30" rows="5" class="form-control" placeholder="Tulis pesan disini"></textarea>
                <div class="invalid-feedback errorPesan"></div>
            </div>
            <div class="form-group">
                <a href="<?= base_url('chatSiswa/index') ?>" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-arrow-left"></i> &nbsp;Kembali</a>
                <button type="submit" class="btn bg-cyan btn-flat btn-sm btnSimpan"><i class="fa fa-paper-plane"></i> &nbsp;Kirim</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formKirim').submit(function() {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSimpan').attr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnSimpan').removeAttr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa fa-paper-plane"></i>&nbsp; Kirim');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.penerima) {
                            $('#penerima').addClass('is-invalid');
                            $('.errorPenerima').html(response.error.penerima);
                        } else {
                            $('#penerima').remove('is-invalid');
                            $('.errorPenerima').html('');
                        }
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
                            window.location.href = '<?= base_url('chatSiswa/index') ?>';
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