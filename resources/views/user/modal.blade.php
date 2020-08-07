<!-- Modal -->
<div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDelete">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah data akan dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteUser()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalUser">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formUser" class="needs-validation" action=""  novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdUser">ID User</label>
                        <input type="text" class="form-control" id="txtIdUser" placeholder="Masukan ID User" onkeyup="CekId(this)" maxlength="10"  required>
                        <div id="cekIdTrue" class="valid-feedback" style="display: none">ID User Tersedia</div>
                        <div id="cekIdFalse" class="invalid-feedback" style="display: none">ID User Sudah Tersedia</div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtNama">Nama</label>
                        <input type="text" class="form-control" id="txtNama" maxlength="200" placeholder="Masukan Nama User"  required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtPassword">Password</label>
                        <input type="password" class="form-control" id="txtPassword" placeholder="Masukan Password User" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picJenisKelamin">Jenis Kelamin</label>
                        <select id="sJenisKelamin" class="form-control" required>
                            <option value="">- Select Jenis Kelamin -</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picStatus">Status</label>
                        <select id="sStatus" class="form-control" required>
                            <option value="">- Select Status -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picProdi">Prodi</label>
                        <select id="sProdi" class="form-control" required>
                            <option value="">- Select Prodi -</option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnUser" type="submit" class="btn btn-primary" >Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>