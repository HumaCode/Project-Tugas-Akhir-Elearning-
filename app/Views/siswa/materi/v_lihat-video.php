<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<?= $this->section('css'); ?>
<style>
    .detail {
        background-color: antiquewhite;
        border-radius: 20px;
    }

    .detail:hover {
        background-color: aqua;
        transition-duration: 1s;
    }
</style>
<?= $this->endsection(); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Preview Video</h3>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-8 mb-2">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" style="border-color: white; border-radius: 20px;" src="https://www.youtube.com/embed/<?= $materi['url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="card p-3 detail">
                        <table>
                            <tr>
                                <td width="100">Judul</td>
                                <td width="30">:</td>
                                <td><?= $materi['judul'] ?></td>
                            </tr>
                            <tr>
                                <td>Dibuat</td>
                                <td>:</td>
                                <td><?= tanggal_indonesia($materi['dibuat'], false) ?></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>
                                    Video
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="card p-3 detail">
                        <table>
                            <tr>
                                <td width="100">Keterangan :</td>
                            </tr>
                        </table>
                        <p class="text-justify"><?= $materi['ket'] ?></p>
                    </div>
                </div>

            </div>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('siswa/materi/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-danger btn-flat btn-block">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>