<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


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

                <div class="col-md-4 bg-cyan p-3 mb-2" style="border-radius: 20px;">
                    <table>
                        <tr>
                            <td width="80"><small>Judul</small></td>
                            <td width="20"><small>:</small></td>
                            <td><small><?= $materi['judul'] ?></small></td>
                        </tr>
                        <tr>
                            <td><small>Dibuat</small></td>
                            <td><small>:</small></td>
                            <td><small><?= tanggal_indonesia($materi['dibuat']) ?></small></td>
                        </tr>
                    </table>
                    <hr style="border-top: 3px solid black; border-radius: 5px;">
                    <small>Keterangan :</small>
                    <p class="text-justify"><?= $materi['ket'] ?></p>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <a href="<?= base_url('admin/materi/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-block btn-danger btn-flat">Kembali</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');
    })
</script>

<?= $this->endsection(); ?>