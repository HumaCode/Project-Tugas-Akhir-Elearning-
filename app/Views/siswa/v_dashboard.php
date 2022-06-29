<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>


<div class="col-md-12">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Home</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <h1>Selamat Datang <?= session()->get('nama_user') ?></h1>

            <ul class=" list-group mt-3">
                <li class="list-group-item">1.&nbsp; Awali kegiatan dengan berdoa terlebih dahulu.</li>
                <li class="list-group-item">2.&nbsp; Jika mengalami kesulitan jangan malu untuk bertanya kepada orang tua maupun guru.</li>
                <li class="list-group-item">3.&nbsp; Awali dengan kata "tolong" jika hendak meminta bantuan kepada orang lain.</li>
                <li class="list-group-item">4.&nbsp; Dan jangan lupa untuk mengucapkan "terima kasih" setelah di bantu.</li>
            </ul>

        </div>
        <div class="card-footer">
            <marquee behavior="" direction="" class="text-danger">Ketika menggunakan aplikasi ini hendaknya di dampingi oleh orang tua ataupun saudara, dan jangan malu untuk bertanya ketika mengalami kesulitan</marquee>
        </div>
    </div>
</div>




<?= $this->endsection(); ?>