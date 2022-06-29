<!-- Modal -->
<div class="modal fade" id="modalAbsen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Absensi Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field() ?>
            <input type="hidden" name="id_kursus" id="id_kursus" value="<?= $id_kursus ?>">
            <input type="hidden" name="id_sub_kursus" id="id_sub_kursus" value="<?= $id_sub_kursus ?>">

            <div class="modal-body">

                <div class="form-group text-center">
                    <label for="foto">Ambil Gambar(Webcam)</label>
                    <p class="text-danger">* Gunakan pakaian yang sopan / seragam sesuai dengan hari</p>

                    <div class="row">
                        <div class="col-md-5 m-auto" id="my_camera">

                        </div>
                    </div>
                    <p>
                        <button type="button" class="btn btn-sm btn-info mt-1" onclick="take_picture()">Ambil Gambar</button>
                    </p>
                </div>

                <div class="form-group">
                    <label for="foto">Preview</label>
                    <div class="row">

                        <div class="col-md-5 m-auto">
                            <div class="" id="results">

                            </div>
                        </div>

                        <input type="hidden" name="imagecam" class="image-tag">
                    </div>
                </div>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnupload">Upload</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();

            let form = $('.formupload')[0];

            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('siswa/upload') ?>",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.btnupload').prop('disable', 'disabled');
                    $('.btnupload').html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                complete: function(e) {
                    $('.btnupload').removeAttr('disable');
                    $('.btnupload').html(`Upload`);
                },
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.error,
                        })
                    } else {
                        $('#modalAbsen').modal('hide');


                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })

                    }
                },
                error: function(xhr, ajaxOption, thrownError) { // jika error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    })
</script>

<script>
    Webcam.set({
        width: 300,
        height: 230,
        image_format: 'jpeg',
        jpeg_quality: 200
    });
    Webcam.attach('#my_camera');

    function take_picture() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img src="' + data_uri + '">';
        })
    }
</script>