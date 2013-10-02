<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('siswas/' . $siswa['id'] . '/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('nis'))) echo 'error'; ?>">
    <label class="control-label" for="nis">NIS</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nis" placeholder="NIS..." value="<?php echo $siswa['nis'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $siswa['nama'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jk'))) echo 'error'; ?>">
    <label class="control-label" for="jk">Jenis Kelamin</label>
    <div class="controls">
        <select class="span2" name="jk" id="siswa-order">
            <option value="1" <?php echo $siswa['jk'] === "1" ? "selected" : "" ?>>Laki-Laki</option>
            <option value="0" <?php echo $siswa['jk'] === "0" ? "selected" : "" ?>>Perempuan</option>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tmptlhr'))) echo 'error'; ?>">
    <label class="control-label" for="tmptlhr">Tempat Lahir</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tempat" type="text" name="tmptlhr" placeholder="Tempat Lahir..." value="<?php echo $siswa['tmptlhr'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tgllhr'))) echo 'error'; ?>">
    <label class="control-label" for="tgllhr">Tanggal Lahir</label>
    <div class="controls">
        <div id="dp-siswa-new-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
            <input class="span2" type="text" readonly="" value="<?php echo $siswa['tgllhr'] ?>" name="tgllhr">
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('agama'))) echo 'error'; ?>">
    <label class="control-label" for="agama">Agama</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-agama" type="text" name="agama" placeholder="Agama..." value="<?php echo $siswa['agama'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('email'))) echo 'error'; ?>">
    <label class="control-label" for="email">E-Mail</label>
    <div class="controls">
        <input type="text" name="email" placeholder="E-Mail..." value="<?php echo $siswa['email'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('notel'))) echo 'error'; ?>">
    <label class="control-label" for="notel">No Telepon</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="notel" placeholder="No Telepon..." value="<?php echo $siswa['notel'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nohp'))) echo 'error'; ?>">
    <label class="control-label" for="nohp">No Handphone</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nohp" placeholder="No Handphone..." value="<?php echo $siswa['nohp'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tahun_masuk'))) echo 'error'; ?>">
    <label class="control-label" for="tahun_masuk">Tahun Masuk</label>
    <div class="controls">
        <input autocomplete="off" class="positive-integer typeahead-tahun" type="text" name="tahun_masuk" placeholder="Tahun Masuk..." value="<?php echo $siswa['tahun_masuk'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="tahun_keluar">Tahun Keluar</label>
    <div class="controls">
        <input autocomplete="off" class="positive-integer typeahead-tahun" type="text" name="tahun_keluar" placeholder="Tahun Keluar..." value="<?php echo $siswa['tahun_keluar'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almt">Alamat</label>
    <div class="controls">
        <textarea name="almt" placeholder="Alamat..." value="<?php echo $siswa['almt'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rt">RT</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rt" placeholder="RT..." value="<?php echo $siswa['rt'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rw">RW</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rw" placeholder="RW..." value="<?php echo $siswa['rw'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="desa">Desa</label>
    <div class="controls">
        <input type="text" name="desa" placeholder="Desa..." value="<?php echo $siswa['desa'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kec">Kecamatan</label>
    <div class="controls">
        <input type="text" name="kec" placeholder="Kecamatan..." value="<?php echo $siswa['kec'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kodepos'))) echo 'error'; ?>">
    <label class="control-label" for="kodepos">Kode Pos</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="kodepos" placeholder="Kode Pos..." value="<?php echo $siswa['kodepos'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmsekolah">Nama Sekolah</label>
    <div class="controls">
        <input type="text" name="nmsekolah" placeholder="Nama Sekolah..." value="<?php echo $siswa['nmsekolah'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almtsekolah">Alamat Sekolah</label>
    <div class="controls">
        <textarea name="almtsekolah" placeholder="Alamat Sekolah..." value="<?php echo $siswa['almtsekolah'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="noijasah">No Ijazah</label>
    <div class="controls">
        <input type="text" name="noijasah" placeholder="No Ijazah..." value="<?php echo $siswa['noijasah'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nilaiijasah">Nilai Ijazah</label>
    <div class="controls">
        <input type="text" name="nilaiijasah" placeholder="Nilai Ijazah..." value="<?php echo $siswa['nilaiijasah'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nilaiskl">Nilai SKL</label>
    <div class="controls">
        <input type="text" name="nilaiskl" placeholder="Nilai SKL..." value="<?php echo $siswa['nilaiskl'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmbpk">Nama Bapak</label>
    <div class="controls">
        <textarea name="nmbpk" placeholder="Nama Bapak..." value="<?php echo $siswa['nmbpk'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pendidikanbpk">Pendidikan Bapak</label>
    <div class="controls">
        <textarea name="pendidikanbpk" placeholder="Pendidikan Bapak..." value="<?php echo $siswa['pendidikanbpk'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pkrjbpk">Pekerjaan Bapak</label>
    <div class="controls">
        <textarea name="pkrjbpk" placeholder="Pekerjaan Bapak..." value="<?php echo $siswa['pkrjbpk'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmibu">Nama Ibu</label>
    <div class="controls">
        <textarea name="nmibu" placeholder="Nama Ibu..." value="<?php echo $siswa['nmibu'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pendidikanibu">Pendidikan Ibu</label>
    <div class="controls">
        <textarea name="pendidikanibu" placeholder="Pendidikan Ibu..." value="<?php echo $siswa['pendidikanibu'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pkrjibu">Pekerjaan Ibu</label>
    <div class="controls">
        <textarea name="pkrjibu" placeholder="Pekerjaan Ibu..." value="<?php echo $siswa['pkrjibu'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almtortu">Alamat</label>
    <div class="controls">
        <textarea name="almtortu" placeholder="Alamat..." value="<?php echo $siswa['almtortu'] ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rtortu">RT</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rtortu" placeholder="RT..." value="<?php echo $siswa['rtortu'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rwortu">RW</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rwortu" placeholder="RW..." value="<?php echo $siswa['rwortu'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="desaortu">Desa</label>
    <div class="controls">
        <input type="text" name="desaortu" placeholder="Desa..." value="<?php echo $siswa['desaortu'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kecortu">Kecamatan</label>
    <div class="controls">
        <input type="text" name="kecortu" placeholder="Kecamatan..." value="<?php echo $siswa['kecortu'] ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kotaortu">Kota</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tempat" type="text" name="kotaortu" placeholder="Kota..." value="<?php echo $siswa['kotaortu'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kodeposortu'))) echo 'error'; ?>">
    <label class="control-label" for="kodeposortu">Kode Pos</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="kodeposortu" placeholder="Kode Pos..." value="<?php echo $siswa['kodeposortu'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tlportu'))) echo 'error'; ?>">
    <label class="control-label" for="tlportu">No Telepon</label>
    <div class="controls">
        <input type="text" name="tlportu" placeholder="Kecamatan..." value="<?php echo $siswa['tlportu'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('penghasilanortu'))) echo 'error'; ?>">
    <label class="control-label" for="penghasilanortu">Penghasilan</label>
    <div class="controls">
        <select class="span3" name="penghasilanortu">
            <option value="">- Pilih Penghasilan -</option>
            <option value="1" <?php echo $siswa['penghasilanortu'] === "1" ? "selected" : "" ?>>&lt; Rp. 500.000</option>
            <option value="2" <?php echo $siswa['penghasilanortu'] === "2" ? "selected" : "" ?>>Rp. 500.000 - Rp. 1.000.000</option>
            <option value="3" <?php echo $siswa['penghasilanortu'] === "3" ? "selected" : "" ?>>Rp. 1.000.000 - Rp. 1.500.000</option>
            <option value="4" <?php echo $siswa['penghasilanortu'] === "4" ? "selected" : "" ?>>Rp. 1.500.000 - Rp. 2.000.000</option>
            <option value="5" <?php echo $siswa['penghasilanortu'] === "5" ? "selected" : "" ?>>Rp. 2.000.000 - Rp. 3.000.000</option>
            <option value="6" <?php echo $siswa['penghasilanortu'] === "6" ? "selected" : "" ?>>Rp. 3.000.000 - Rp. 5.000.000</option>
            <option value="7" <?php echo $siswa['penghasilanortu'] === "7" ? "selected" : "" ?>>&gt; Rp. 5.000.000</option>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('siswas/' . $siswa['id']) ?>" class="btn">Kembali</a>
</div>
</form>

<form id="form-siswa_kelas-edit" accept-charset="utf-8" method="post" action="<?php echo base_url() . 'siswakelas/deletes/' . $siswa['id'] ?>">
    Kelas:
    <table class="table table-hover siswa_kelas-edit">
        <thead>
            <tr>
                <td>
                    <input type="checkbox" id="siswa_kelas_checkall" name="siswa_kelas_checkall" value="siswa_kelas_checkall" />
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
                                <a href="<?php echo site_url('siswakelas/new/' . $siswa['id']) ?>">Tambah</a>
                                <a href="#modal_siswa_kelas_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($siswa_kelas)) { ?>
                <?php foreach ($siswa_kelas as $key => $siswa_kela): ?>
                    <tr>
                        <td>
                            <input class="siswa_kelas_edit_ck" name="ids[]" type="checkbox" value="<?php echo $siswa_kela['id']; ?>">
                        </td>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo get_full_kelas($siswa_kela['kelas_bagian_id']) ?>
                        </td>
                        <td>
                            <?php echo get_nama_tahun_ajaran($siswa_kela['tahun_ajaran_id']) ?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo site_url('siswakelas/' . $siswa_kela['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                                <a href="#modal_siswa_kelas_delete<?php echo $siswa_kela['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            </p>
                            <div id="modal_siswa_kelas_delete<?php echo $siswa_kela['id'] ?>" class="modal hide fade">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>Hapus Kelas</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin menghapus kelas <?php echo get_full_kelas($siswa_kela['kelas_bagian_id']) . ' ' . get_nama_tahun_ajaran($siswa_kela['tahun_ajaran_id']) ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                    <a href="<?php echo site_url('siswakelas/' . $siswa_kela['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="modal_siswa_kelas_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Kelas</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="submit-siswa_kelas-deletes" data-dismiss="modal">Hapus</a>
    </div>
</div>