<!-- Modal -->
<div class="modal fade" id="modalDeleteKlsUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalDelete">Delete Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah data akan dihapus?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteKlsUser()">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKlsUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalKlsUser"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formKlsUser" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdKlsUser">ID Kelas User</label>
                        <input type="text" class="form-control" id="txtIdKlsUser" required disabled>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sMahasiswa">ID Mahasiswa</label>
                        <select id="sMahasiswa" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" data-tokens="">- Select ID Mahasiswa -</option>

                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnKelas" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>