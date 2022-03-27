<?= $this->extend('layouts/template-frontend'); ?>

<?= $this->section('content'); ?>

<?php if (session()->get('role') == 3) { ?>
    <script>
        window.location.href = "<?= base_url('siswa') ?>";
    </script>
<?php  } else { ?>



    <div class="col-sm-5 mb-4 text-center mt-3">
        <img src="<?= base_url('assets/img/lock.png') ?>" class="img-fluid pad" width="300" alt="">
    </div>

    <!-- flashdata sweetalert -->
    <?php
    if (session()->getFlashdata('pesan')) { ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
    <?php } else if (session()->getFlashdata('logout')) { ?>
        <div class="logout" data-flashdata="<?= session()->getFlashdata('logout') ?>"></div>
    <?php } else { ?>
        <div class="flash" data-flashdata="<?= session()->getFlashdata('p') ?>"></div>
    <?php } ?>


    <div class="col-sm-7 ">
        <?= form_open('login/cekLoginSiswa') ?>
        <?= csrf_field(); ?>
        <div class="card card-outline card-lightblue">
            <div class="card-header">
                <h3><strong>Login Siswa</strong></h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="number" min="1" name="nis" id="nis" class="form-control form-control-sm" style="border-radius: 0;" placeholder="Masukan NIS" value="<?= old('nis') ?>">
                    <p class="text-danger pl-2 err"><strong><?= $validation->hasError('nis') ? $validation->getError('nis') : '' ?></strong></p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-sm" style="border-radius: 0;" placeholder="Masukan Password" value="<?= old('password') ?>">
                    <p class="text-danger pl-2 err"><strong><?= $validation->hasError('password') ? $validation->getError('password') : '' ?></strong></p>
                </div>

            </div>
            <div class="card-footer">
                <div class="row">
                    <button type="submit" class="btn bg-lightblue btn-flat btn-block"><i class="fas fa-save"></i> Login</button>

                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>

<?php } ?>




<?= $this->endsection(); ?>