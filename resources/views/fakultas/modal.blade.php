<!-- Modal -->
<div class="modal fade" id="modalDeleteFakultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete">Delete Fakultas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah data akan dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteFakultas()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFakultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalFakultas">Add Fakultas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="formFakultas" class="needs-validation" action="javascript:InsertFakultas();" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdFakultas">ID Fakultas</label>
                        <input type="text" class="form-control" id="txtIdFakultas" placeholder="Masukan ID Fakultas" required>
                        
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtNamaFakultas">Nama Fakultas</label>
                        <input type="text" class="form-control" id="txtNamaFakultas" placeholder="Masukan Nama Fakultas" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtEmailFakultas">Email Fakultas</label>
                        <input type="email" class="form-control" id="txtEmailFakultas" placeholder="Masukan Email Fakultas" required>
                    </div>
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnFakultas" type="submit" class="btn btn-primary" >Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>