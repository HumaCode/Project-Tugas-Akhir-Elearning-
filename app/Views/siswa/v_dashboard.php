<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<h1>Selamat Datang <?= session()->get('nama_user') ?></h1>

<?= $this->endsection(); ?>