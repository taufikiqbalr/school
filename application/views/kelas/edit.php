<?php echo $this->session->flashdata('message'); ?>

<form id="form-kelas-edit" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'kelas/' . $kela['id'] . '/update' ?>">
    <div class="control-group <?php if (($this->session->flashdata('tingkat'))) echo 'error'; ?>">
        <label class="control-label" for="tingkat">Tingkat</label>
        <div class="controls">
            <input type="text" name="tingkat" value="<?php echo $kela['tingkat'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="jurusan_id">Jurusan</label>
        <div class="controls">
            <select class="span2" name="jurusan_id">
                <?php if (!empty($jurusans)) { ?>
                    <option value=""> </option>
                    <?php foreach ($jurusans as $jurusan): ?>
                        <option value="<?php echo $jurusan['id'] ?>" <?php echo $kela['jurusan_id'] === $jurusan['id'] ? "selected" : "" ?>><?php echo get_nama_jurusan($jurusan['id']) ?></option>
                    <?php endforeach; ?>
                <?php }else { ?>
                    <option value=""> </option>
                <?php } ?>
            </select>
        </div>
    </div>
</form>

<form id="form-kelas_bagian-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'kelasbagians/deletes/' . $kela['id'] ?>">
    Bagian:
    <table class="table table-hover kelas_bagian-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="kelas_bagian_checkall" name="kelas_bagian_checkall" value="kelas_bagian_checkall" />
                </td>
                <td>No</td>
                <td>Tingkat</td>
                <td>
                    <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('kelasbagians/new/' . $kela['id']) ?>">Tambah</a>
                                <a href="#modal_kelas_bagian_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kelas_bagians)) { ?>
                <?php foreach ($kelas_bagians as $key => $kelas_bagian): ?>
                    <tr>
                        <td>
                            <input class="kelas_bagian_edit_ck" name="ids[]" type="checkbox" value="<?php echo $kelas_bagian['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $kelas_bagian['nama'] ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('kelasbagians/' . $kelas_bagian['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_kelas_bagian_delete<?php echo $kelas_bagian['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_kelas_bagian_delete<?php echo $kelas_bagian['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Kelas Bagian</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus kelas bagian <?php echo $kelas_bagian['nama'] ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('kelasbagians/' . $kelas_bagian['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4"><p class="text-center">Data Kosong</p></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>

<div id="modal_kelas_bagian_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Kelas Bagian</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-kelas_bagian-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>

<div class=" form-actions text-center">
    <a href="#" id="submit-kelas-edit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</a>
    <a href="<?php echo site_url('kelas/' . $kela['id']) ?>" class="btn">Kembali</a>
</div>
