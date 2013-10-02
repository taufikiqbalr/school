<?php echo $this->session->flashdata('message'); ?>

<form id="form-guru-edit" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'gurus/' . $guru['id'] . '/update' ?>">
    <div class="control-group <?php if (($this->session->flashdata('nip'))) echo 'error'; ?>">
        <label class="control-label" for="nip">NIP</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="nip" placeholder="NIP..." value="<?php echo $guru['nip'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
        <label class="control-label" for="nama">Nama</label>
        <div class="controls">
            <input type="text" name="nama" placeholder="Nama..." value="<?php echo $guru['nama'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('jenis_kelamin'))) echo 'error'; ?>">
        <label class="control-label" for="jenis_kelamin">Jenis Kelamin</label>
        <div class="controls">
            <select class="span2" name="jenis_kelamin" id="guru-order">
                <option value="1" <?php echo $guru['jenis_kelamin'] === "1" ? "selected" : "" ?>>Laki-Laki</option>
                <option value="0" <?php echo $guru['jenis_kelamin'] === "0" ? "selected" : "" ?>>Perempuan</option>
            </select>
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('tempat_lahir'))) echo 'error'; ?>">
        <label class="control-label" for="tempat_lahir">Tempat Lahir</label>
        <div class="controls">
            <input autocomplete="off" class="typeahead-tempat" type="text" name="tempat_lahir" placeholder="Tempat Lahir..." value="<?php echo $guru['tempat_lahir'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('tanggal_lahir'))) echo 'error'; ?>">
        <label class="control-label" for="tanggal_lahir">Tanggal Lahir</label>
        <div class="controls">
            <div id="dp-guru-edit-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
                <input class="span2" type="text" readonly="" value="<?php echo $guru['tanggal_lahir'] ?>" name="tanggal_lahir">
                <span class="add-on">
                    <i class="icon-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('agama'))) echo 'error'; ?>">
        <label class="control-label" for="agama">Agama</label>
        <div class="controls">
            <input autocomplete="off" class="typeahead-agama" type="text" name="agama" placeholder="Agama..." value="<?php echo $guru['agama'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('email'))) echo 'error'; ?>">
        <label class="control-label" for="email">E-Mail</label>
        <div class="controls">
            <input type="text" name="email" placeholder="E-Mail..." value="<?php echo $guru['email'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="alamat">Alamat</label>
        <div class="controls">
            <textarea name="alamat" placeholder="Alamat..." value="<?php echo $guru['alamat'] ?>"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="rt">RT</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="rt" placeholder="RT..." value="<?php echo $guru['rt'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="rw">RW</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="rw" placeholder="RW..." value="<?php echo $guru['rw'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="desa">Desa</label>
        <div class="controls">
            <input type="text" name="desa" placeholder="Desa..." value="<?php echo $guru['desa'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="kec">Kecamatan</label>
        <div class="controls">
            <input type="text" name="kec" placeholder="Kecamatan..." value="<?php echo $guru['kec'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="kec">Kota</label>
        <div class="controls">
            <input type="text" name="kec" placeholder="Kota..." value="<?php echo $guru['kota'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('kodepos'))) echo 'error'; ?>">
        <label class="control-label" for="kodepos">Kode Pos</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="kodepos" placeholder="Kode Pos..." value="<?php echo $guru['kodepos'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="status">Status</label>
        <div class="controls">
            <input type="text" name="status" placeholder="Status..." value="<?php echo $guru['status'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="no_telepon">No Telepon</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="no_telepon" placeholder="No Telepon..." value="<?php echo $guru['no_telepon'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="no_handphone">No Handphone</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="no_handphone" placeholder="No Handphone..." value="<?php echo $guru['no_handphone'] ?>">
        </div>
    </div>
    <div class="control-group <?php if (($this->session->flashdata('tanggal_pengangkatan'))) echo 'error'; ?>">
        <label class="control-label" for="tanggal_pengangkatan">Tanggal Pengangkatan</label>
        <div class="controls">
            <div id="dp-guru-edit-tgl_pgkt" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
                <input class="span2" type="text" readonly="" value="<?php echo $guru['tanggal_pengangkatan'] ?>" name="tanggal_pengangkatan">
                <span class="add-on">
                    <i class="icon-calendar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="nuptk">NUPTK</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="nuptk" placeholder="NUPTK..." value="<?php echo $guru['nuptk'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="nrg">NRG</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="nrg" placeholder="NRG..." value="<?php echo $guru['nrg'] ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="nsg">NSG</label>
        <div class="controls">
            <input class="positive-integer" type="text" name="nsg" placeholder="NSG..." value="<?php echo $guru['nsg'] ?>">
        </div>
    </div>
    <div class=" form-actions">
        <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
        <a href="<?php echo site_url('gurus/' . $guru['id']) ?>" class="btn">Kembali</a>
    </div>
</form>

<form id="form-guru_wali-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'guruwalis/deletes/' . $guru['id'] ?>">
    Wali:
    <table class="table table-hover guru_wali-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="guru_wali_checkall" name="guru_wali_checkall" value="guru_wali_checkall" />
                </td>
                <td>No</td>
                <td>Kelas</td>
                <td>Tahun Ajaran</td>
                <td>
                    <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('guruwalis/new/' . $guru['id']) ?>">Tambah</a>
                                <a href="#modal_guru_wali_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru_walis)) { ?>
                <?php foreach ($guru_walis as $key => $guru_wali): ?>
                    <tr>
                        <td>
                            <input class="guru_wali_edit_ck" name="ids[]" type="checkbox" value="<?php echo $guru_wali['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo get_full_kelas($guru_wali['kelas_bagian_id']) ?>
                        </td>
                        <td>
                            <?php echo get_nama_tahun_ajaran($guru_wali['tahun_ajaran_id']) ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('guruwalis/' . $guru_wali['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_guru_wali_delete<?php echo $guru_wali['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_guru_wali_delete<?php echo $guru_wali['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Wali</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus wali <?php echo get_full_kelas($guru_wali['kelas_bagian_id']) . ' ' . get_nama_tahun_ajaran($guru_wali['tahun_ajaran_id']) ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('guruwalis/' . $guru_wali['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5"><p class="text-center">Data Kosong</p></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>
<div id="modal_guru_wali_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Wali</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-guru_wali-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>

<form id="form-guru_ijazah-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'guruijazahs/deletes/' . $guru['id'] ?>">
    Ijazah:
    <table class="table table-hover guru_ijazah-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="guru_ijazah_checkall" name="guru_ijazah_checkall" value="guru_ijazah_checkall" />
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
                                <a href="<?php echo site_url('guruijazahs/new/' . $guru['id']) ?>">Tambah</a>
                                <a href="#modal_guru_ijazah_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru_ijazahs)) { ?>
                <?php foreach ($guru_ijazahs as $key => $guru_ijazah): ?>
                    <tr>
                        <td>
                            <input class="guru_ijazah_edit_ck" name="ids[]" type="checkbox" value="<?php echo $guru_ijazah['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $guru_ijazah['nama_instansi'] ?>
                        </td>
                        <td>
                            <?php echo $guru_ijazah['tingkat'] ?>
                        </td>
                        <td>
                            <?php echo $guru_ijazah['nama_gelar'] ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('guruijazahs/' . $guru_ijazah['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_guru_ijazah_delete<?php echo $guru_ijazah['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_guru_ijazah_delete<?php echo $guru_ijazah['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Ijazah</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus ijazah <?php echo $guru_ijazah['nama_instansi'] . ' ' . $guru_ijazah['tingkat'] . ' ' . $guru_ijazah['nama_gelar'] ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('guruijazahs/' . $guru_ijazah['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="modal_guru_ijazah_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Ijazah</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-guru_ijazah-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>

<form id="form-guru_mata_pelajaran-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'gurumatapelajarans/deletes/' . $guru['id'] ?>">
    Mengajar Matapelajaran:
    <table class="table table-hover guru_mata_pelajaran-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="guru_mata_pelajaran_checkall" name="guru_mata_pelajaran_checkall" value="guru_mata_pelajaran_checkall" />
                </td>
                <td>No</td>
                <td>Mata Pelajaran</td>
                <td>Kurikulum</td>
                <td>Tahun Ajaran</td>
                <td>
                    <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('gurumatapelajarans/new/' . $guru['id']) ?>">Tambah</a>
                                <a href="#modal_guru_mata_pelajaran_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru_mata_pelajarans)) { ?>
                <?php foreach ($guru_mata_pelajarans as $key => $guru_mata_pelajaran): ?>
                    <tr>
                        <td>
                            <input class="guru_mata_pelajaran_edit_ck" name="ids[]" type="checkbox" value="<?php echo $guru_mata_pelajaran['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo get_full_mata_pelajaran($guru_mata_pelajaran['mata_pelajaran_id']) ?>
                        </td>
                        <td>
                            <?php echo get_nama_kurikulum($guru_mata_pelajaran['kurikulum_id']) ?>
                        </td>
                        <td>
                            <?php echo get_nama_tahun_ajaran($guru_mata_pelajaran['tahun_ajaran_id']) ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('gurumatapelajarans/' . $guru_mata_pelajaran['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_guru_mata_pelajaran_delete<?php echo $guru_mata_pelajaran['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_guru_mata_pelajaran_delete<?php echo $guru_mata_pelajaran['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Mata Pelajaran</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus mata pelajaran <?php echo get_full_mata_pelajaran($guru_mata_pelajaran['mata_pelajaran_id']) . ' ' . get_nama_kurikulum($guru_mata_pelajaran['kurikulum_id']) . ' ' . get_nama_tahun_ajaran($guru_mata_pelajaran['tahun_ajaran_id']) ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('gurumatapelajarans/' . $guru_mata_pelajaran['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="modal_guru_mata_pelajaran_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Mata Pelajaran</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-guru_mata_pelajaran-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>

<form id="form-guru_kelas_matpel-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'gurukelasmatpels/deletes/' . $guru['id'] ?>">
    Mengajar Di Kelas:
    <table class="table table-hover guru_kelas_matpel-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="guru_kelas_matpel_checkall" name="guru_kelas_matpel_checkall" value="guru_kelas_matpel_checkall" />
                </td>
                <td>No</td>
                <td>Kelas</td>
                <td>
                    <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('gurukelasmatpels/new/' . $guru['id']) ?>">Tambah</a>
                                <a href="#modal_guru_kelas_matpel_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru_kelas_matpels)) { ?>
                <?php foreach ($guru_kelas_matpels as $key => $guru_kelas_matpel): ?>
                    <tr>
                        <td>
                            <input class="guru_kelas_matpel_edit_ck" name="ids[]" type="checkbox" value="<?php echo $guru_kelas_matpel['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo get_full_kelas($guru_kelas_matpel['kelas_bagian_id']) ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('gurukelasmatpels/' . $guru_kelas_matpel['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_guru_kelas_matpel_delete<?php echo $guru_kelas_matpel['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_guru_kelas_matpel_delete<?php echo $guru_kelas_matpel['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Kelas</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus kelas <?php echo get_full_kelas($guru_kelas_matpel['kelas_bagian_id']) ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('gurukelasmatpels/' . $guru_kelas_matpel['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="modal_guru_kelas_matpel_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Kelas</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-guru_kelas_matpel-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>
