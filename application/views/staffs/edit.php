<?php echo $this->session->flashdata('message'); ?>

<form id="form-staff-edit" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'staffs/' . $staff['id'] . '/update' ?>">
    <div class="control-group <?php if (($this->session->flashdata('nik'))) echo 'error'; ?>">
        <label class="control-label" for="nik">NIK</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="nik" placeholder="NIK..." value="<?php echo $staff['nik'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
        <label class="control-label" for="nama">Nama</label>
        <div class="controls">
            <input type="text" name="nama" placeholder="Nama..." value="<?php echo $staff['nama'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('jenis_kelamin'))) echo 'error'; ?>">
        <label class="control-label" for="jenis_kelamin">Jenis Kelamin</label>
        <div class="controls">
            <select class="span2" name="jenis_kelamin" id="staff-order">
                <option value="1" <?php echo $staff['jenis_kelamin'] === "1" ? "selected" : "" ?>>Laki-Laki</option>
                <option value="0" <?php echo $staff['jenis_kelamin'] === "0" ? "selected" : "" ?>>Perempuan</option>
            </select>
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('tempat_lahir'))) echo 'error'; ?>">
        <label class="control-label" for="tempat_lahir">Tempat Lahir</label>
        <div class="controls">
            <input autocomplete="off" class="typeahead-tempat" type="text" name="tempat_lahir" placeholder="Tempat Lahir..." value="<?php echo $staff['tempat_lahir'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('tanggal_lahir'))) echo 'error'; ?>">
        <label class="control-label" for="tanggal_lahir">Tanggal Lahir</label>
        <div class="controls">
            <div id="dp-staff-edit-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
                <input class="span2" type="text" readonly="" value="<?php echo $staff['tanggal_lahir'] ?>" name="tanggal_lahir">
                <span class="add-on">
                    <i class="icon-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('agama'))) echo 'error'; ?>">
        <label class="control-label" for="agama">Agama</label>
        <div class="controls">
            <input autocomplete="off" class="typeahead-agama" type="text" name="agama" placeholder="Agama..." value="<?php echo $staff['agama'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('email'))) echo 'error'; ?>">
        <label class="control-label" for="email">E-Mail</label>
        <div class="controls">
            <input type="text" name="email" placeholder="E-Mail..." value="<?php echo $staff['email'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="alamat">Alamat</label>
        <div class="controls">
            <textarea name="alamat" placeholder="Alamat..." value="<?php echo $staff['alamat'] ?>"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="status">Status</label>
        <div class="controls">
            <input type="text" name="status" placeholder="Status..." value="<?php echo $staff['status'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="no_telepon">No Telepon</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="no_telepon" placeholder="No Telepon..." value="<?php echo $staff['no_telepon'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="no_handphone">No Handphone</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="no_handphone" placeholder="No Handphone..." value="<?php echo $staff['no_handphone'] ?>">
        </div>
    </div>
    <div class=" form-actions">
        <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
        <a href="<?php echo site_url('staffs/' . $staff['id']) ?>" class="btn">Kembali</a>
    </div>
</form>

<form id="form-staff_ijazah-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'staffijazahs/deletes/' . $staff['id'] ?>">
    Ijazah:
    <table class="table table-hover staff_ijazah-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="staff_ijazah_checkall" name="staff_ijazah_checkall" value="staff_ijazah_checkall" />
                </td>
                <td>No</td>
                <td>Nama Instansi</td>
                <td>Tingkat</td>
                <td>Nama Gelar</td>
                <td>
                    <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('staffijazahs/new/' . $staff['id']) ?>">Tambah</a>
                                <a href="#modal_staff_ijazah_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($staff_ijazahs)) { ?>
                <?php foreach ($staff_ijazahs as $key => $staff_ijazah): ?>
                    <tr>
                        <td>
                            <input class="staff_ijazah_edit_ck" name="ids[]" type="checkbox" value="<?php echo $staff_ijazah['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $staff_ijazah['nama_instansi'] ?>
                        </td>
                        <td>
                            <?php echo $staff_ijazah['tingkat'] ?>
                        </td>
                        <td>
                            <?php echo $staff_ijazah['nama_gelar'] ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('staffijazahs/' . $staff_ijazah['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_staff_ijazah_delete<?php echo $staff_ijazah['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_staff_ijazah_delete<?php echo $staff_ijazah['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Ijazah</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus ijazah <?php echo $staff_ijazah['nama_instansi'] . ' ' . $staff_ijazah['tingkat'] . ' ' . $staff_ijazah['nama_gelar'] ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('staffijazahs/' . $staff_ijazah['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6"><p class="text-center">Data Kosong</p></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>
<div id="modal_staff_ijazah_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Ijazah</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-staff_ijazah-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>
