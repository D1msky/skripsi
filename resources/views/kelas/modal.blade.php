<!-- Modal -->
<div class="modal fade" id="modalDeleteKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalDelete">Delete Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah data akan dihapus?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button id="btnDeleteUser" type="button" class="btn btn-danger" onclick="DeleteKelas()">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalKelas">Add Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formKelas" class="needs-validation" action="" novalidate>
                    <div class="col-md-12 form-group mb-3">
                        <label for="txtIdKelas">ID Kelas</label>
                        <input type="text" class="form-control" id="txtIdKelas" placeholder="Masukan ID Kelas" required>

                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picKelas">Matakuliah</label>
                        <select id="sMatakuliah" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" data-tokens="">- Select Matakuliah -</option>

                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sDosen">Dosen 1</label>
                        <select id="sDosen" class="form-control selectpicker" data-live-search="true" required>
                            <option value="" data-tokens="">- Select Dosen 1 -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sDosen2">Dosen 2</label>
                        <select id="sDosen2" class="form-control selectpicker" data-live-search="true" >
                            <option value="" data-tokens="">- Select Dosen 2 -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sDosen3">Dosen 3</label>
                        <select id="sDosen3" class="form-control selectpicker" data-live-search="true">
                            <option value="" data-tokens="">- Select Dosen 2 -</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sGroup">Group</label>
                        <select id="sGroup" class="form-control" required>
                            <option value="">- Select Group -</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="sSemester">Semester</label>
                        <select id="sSemester" class="form-control" required>
                            <option value="">- Select Semester -</option>
                            <option value="GENAP">GENAP</option>
                            <option value="GANJIL">GANJIL</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="picKelas">Tahun Ajaran</label>
                        <select id="sThnAjaran" class="form-control" required>
                            <option value="">- Select Tahun Ajaran -</option>
                           
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