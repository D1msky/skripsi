<!-- Modal -->
<div class="modal fade" id="modalDeleteProdi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete">Delete Prodi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah data akan dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteProdi()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProdi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalFakultas">Add Prodi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="formProdi" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdProdi">ID Prodi</label>
                        <input type="text" class="form-control" id="txtIdProdi" pattern="^[a-zA-Z0-9]+$" required>
                        
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtNamaProdi">Nama Prodi</label>
                        <input type="text" class="form-control" id="txtNamaProdi" maxlength="100" placeholder="Masukan Nama Prodi" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtSingkatanProdi">Singkatan Prodi</label>
                        <input type="text" class="form-control" id="txtSingkatanProdi" maxlength="8" onkeyup="CekSingkatan(this)" placeholder="Masukan Singkatan Prodi" required>
                        <div id="cekSingkatanTrue" class="valid-feedback" style="display: none">Singkatan Tersedia</div>
                        <div id="cekSingkatanFalse" class="invalid-feedback" style="display: none">Singkatan SudahTersedia</div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtEmailProdi">Email Prodi</label>
                        <input type="email" class="form-control" id="txtEmailProdi" placeholder="Masukan Email Prodi"  required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picFakultas">Fakultas</label>
                        <select id="sFakultas" class="form-control" required>
                            <option value="">- Select Fakultas -</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnProdi" type="submit" class="btn btn-primary" >Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>