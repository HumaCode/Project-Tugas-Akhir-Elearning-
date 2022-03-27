<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>


<div class="content-wrapper">
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Halaman tidak tersedia.</h3>
                <p>
                    Anda tidak boleh mengakses halaman ini.
                </p>

            </div>
        </div>
    </section>
</div>

</section>
<?= $this->endsection(); ?>