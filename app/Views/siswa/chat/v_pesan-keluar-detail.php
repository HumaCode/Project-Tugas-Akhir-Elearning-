<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-cyan card-outline">
        <div class="card-header">
            <h3 class="card-title">Detail Pesan Keluar</h3>
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
        </div>
        <div class="card-footer">
            <a href="<?= base_url('siswa/pesanKeluar') ?>" class="btn btn-danger btn-sm btn-block btn-flat">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>