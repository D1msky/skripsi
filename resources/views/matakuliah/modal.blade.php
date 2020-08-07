<!-- Modal -->
<div class="modal fade" id="modalDeleteMatakuliah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete">Delete Matakuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah data akan dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteMatakuliah()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalMatakuliah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalMatakuliah">Add Matakuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="formMatakuliah" class="needs-validation" action="javascript:InsertMatakuliah();" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdMatakuliah">ID Matakuliah</label>
                        <input type="text" class="form-control" id="txtIdMatakuliah" placeholder="Masukan ID Matakuliah" onkeyup="CekId(this)" required>
                        <div id="cekIdTrue" class="valid-feedback" style="display: none">ID Matakuliah Tersedia</div>
                        <div id="cekIdFalse" class="invalid-feedback" style="display: none">ID Matakuliah Sudah Tersedia</div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtNamaMatakuliah">Nama Matakuliah</label>
                        <input type="text" class="form-control" id="txtNamaMatakuliah" placeholder="Masukan Nama Matakuliah" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtSingkatanMatakuliah">Singkatan Matakuliah</label>
                        <input type="text" class="form-control" id="txtSingkatanMatakuliah" maxlength="8" placeholder="Masukan Singkatan Matakuliah" onkeyup="CekSingkatan(this)" required>
                        <div id="cekSingkatanTrue" class="valid-feedback" style="display: none">Singkatan Tersedia</div>
                        <div id="cekSingkatanFalse" class="invalid-feedback" style="display: none">Singkatan Sudah Tersedia</div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtSks">SKS</label>
                        <input type="number" class="form-control" id="txtSks" placeholder="Masukan SKS Matakuliah" required>
                    </div>
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnMatakuliah" type="submit" class="btn btn-primary">Save changes</button>
                    
                </div>
                </form>
            </div>
        </div>
    </div>