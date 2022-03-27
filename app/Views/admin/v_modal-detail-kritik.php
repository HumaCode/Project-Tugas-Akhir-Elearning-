<!-- Modal -->
<div class="modal fade" id="modalKritik" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>Kritik</th>
                            <th>Saran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-justify"><?= $kritik ?></td>
                            <td class="text-justify"><?= $saran ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs btn-flat" data-dismiss="modal"><i class="fas fa-ban"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>