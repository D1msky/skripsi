<!-- Modal -->
<div class="modal fade" id="modalDeleteTugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalDelete">Delete Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah data akan dihapus?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteTugas()">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalFakultas">Add Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTugas" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdTugas">ID Tugas</label>
                        <input type="text" class="form-control" id="txtIdTugas" placeholder="Masukan ID Tugas" disabled required>

                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtNamaTugas">Nama Tugas</label>
                        <input type="text" class="form-control" id="txtNamaTugas" placeholder="Masukan Nama Tugas" required>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="txtPersen">Persen Tugas</label>
                        <div class="input-right-icon">
                            <input type="number" class="form-control" id="txtPersen" min="1" max="100"  required>
                            <span class="span-right-input-icon">
                                <i class="">%</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtTglSelesai">Tanggal Kumpul</label>
                                <div class="input-group">
                                    <input class="form-control" data-date-format="yyyy-mm-dd" id="txtTglSelesai">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button">
                                            <i class="icon-regular i-Calendar-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="txtWaktuSelesai">Waktu Kumpul</label>
                                <input type="time" class="form-control" id="txtWaktuSelesai">
                            </div>
                        </div>
                    </div>
                    <input type="text" id="txtWaktuMulai" hidden disabled>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnTugas" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>