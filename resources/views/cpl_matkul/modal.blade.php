<!-- Modal -->
<div class="modal fade" id="modalDeleteCpl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete">Delete Cpl</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah data akan dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteCpl()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCpl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalFakultas">Add Cpl</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="formCpl" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdCplMatkul">ID CPL MATKUL</label>
                        <input type="text" class="form-control" id="txtIdCplMatkul" placeholder="Masukan ID Cpl" required disabled>
                        
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdCpl">ID CPL</label>
                        <input type="text" class="form-control" id="txtIdCpl" placeholder="Masukan ID Cpl" required disabled>
                        
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtDeskripsiCPL">DESKRIPSI CPL</label>
                        <textarea class="form-control" id="txtDeskripsiCPL" rows="7" disabled></textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sBobot">Nilai</label>
                        <select id="sBobot" class="form-control" required>
                            <option value="">- Select Nilai-</option>
                            <option value="1">1 (Very Low)</option>
                            <option value="2">2 (Low)</option>
                            <option value="3">3 (Medium)</option>
                            <option value="4">4 (High)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnCpl" type="submit" class="btn btn-primary" >Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>