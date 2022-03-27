<?= $this->extend('layouts/template-backend'); ?>

<?= $this->section('content'); ?>

<div class="col-md-9">
    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Dashboard Guru</h3>
        </div>

        <div class="card-body">
            <h3>Selamat datang Guru</h3>
        </div>
    </div>

</div>
<div class="col-md-3">


    <div class="card card-outline card-cyan">
        <div class="card-header">
            <h3 class="card-title">Info Lain</h3>
        </div>

        <div class="card-body">
            <div class="row bg-cyan p-2" style="border-radius: 10px;">

                <table>
                    <tr>
                        <td width="150">Kursus yang dibuat</td>
                        <td width="10">:</td>
                        <td><?= $jml ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

<?= $this->endsection(); ?>