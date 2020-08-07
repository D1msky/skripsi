<!-- Modal -->
<div class="modal fade" id="modalDeleteCPL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalDelete">Delete CPL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah data akan dihapus?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteCPL()">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCPL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalCPL">Add CPL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCPL" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdCPL">ID CPL</label>
                        <input type="text" class="form-control" id="txtIdCPL" disabled required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtKdCPL">KD CPL</label>
                        <input type="text" class="form-control" id="txtKdCPL" placeholder="Masukan KD CPL"  maxlength="10" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picCPL">Prodi</label>
                        <select id="sProdi" class="form-control"required>
                            <option value="" >- Select Prodi -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picCPL">Kategori CPL</label>
                        <select id="sKatCpl" class="form-control"required>
                            <option value="" >- Select Kategori CPL -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtDeskripsiCPL">Deskripsi CPL</label>
                        <textarea class="form-control" id="txtDeskripsiCPL" rows="5" ></textarea>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnCPL" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>