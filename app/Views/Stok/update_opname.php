<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title">Edit Opname</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('opname-update/' . $data_opname['id_opname']) ?>" method="POST" class="form-horizontal form-edit">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_opname" value="<?= $data_opname['id_opname'] ?>">
                    <input type="hidden" name="id_obat" value="<?= $data_opname['id_obat'] ?>">
                    <div class="form-group row">
                        <label for="nama_obat" class="col-sm-4 col-form-label">Nama Obat</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_obat" value="<?= old('nama_obat', $data_opname['obat']) ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah', $data_opname['jumlah']) ?>">
                            <div class="invalid-feedback errorjumlah">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"><?= old('keterangan', $data_opname['keterangan']) ?></textarea>
                            <div class="invalid-feedback errorketerangan">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {

        $('.form-edit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btn-save').attr('disable', 'disabled');
                    $('.btn-save').html('<i class="fas fa-spinner fa-spin"></i>');
                },
                complete: function() {
                    $('.btn-save').removeAttr('disable', 'disabled');
                    $('.btn-save').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.jumlah) {
                            $('#jumlah').addClass('is-invalid');
                            $('.errorjumlah').html(response.error.jumlah);
                        } else {
                            $('#jumlah').removeClass('is-invalid');
                            $('.errorjumlah').html(' ');
                        }
                        if (response.error.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.errorketerangan').html(response.error.keterangan);
                        } else {
                            $('#keterangan').removeClass('is-invalid');
                            $('.errorketerangan').html('');
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.success
                        })
                        $('#modal-update').modal('hide');
                        getData()
                        getDataOpname()
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        title: xhr.status,
                        text: thrownError,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });


    });
</script>