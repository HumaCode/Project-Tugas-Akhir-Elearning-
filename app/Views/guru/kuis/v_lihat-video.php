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
                        <iframe class="embed-responsive-item" style="border-color: white;  border-radius: 20px;" src="https://www.youtube.com/embed/<?= $kuis['url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="col-md-4 bg-cyan p-3 mb-2" style="border-radius: 20px;">
                    <small>Keterangan :</small>
                    <p class="text-justify"><?= $kuis['kuis'] ?></p>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <a href="<?= base_url('guru/kuis/' . $id_sub_kursus . '/' . $id_kursus) ?>" class="btn btn-block btn-danger btn-flat">Kembali</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');
    })
</script>

<?= $this->endsection(); ?>