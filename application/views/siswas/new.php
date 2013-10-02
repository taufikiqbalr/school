<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('siswas/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('nis'))) echo 'error'; ?>">
    <label class="control-label" for="nip">NIS</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nis" placeholder="NIS..." value="<?php echo $nis ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $nama ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jk'))) echo 'error'; ?>">
    <label class="control-label" for="jk">Jenis Kelamin</label>
    <div class="controls">
        <select class="span2" name="jk" id="siswa-order">
            <option value="1" <?php echo $jk === "1" ? "selected" : "" ?>>Laki-Laki</option>
            <option value="0" <?php echo $jk === "0" ? "selected" : "" ?>>Perempuan</option>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tmptlhr'))) echo 'error'; ?>">
    <label class="control-label" for="tmptlhr">Tempat Lahir</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tempat" type="text" name="tmptlhr" placeholder="Tempat Lahir..." value="<?php echo $tmptlhr ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tgllhr'))) echo 'error'; ?>">
    <label class="control-label" for="tgllhr">Tanggal Lahir</label>
    <div class="controls">
        <div id="dp-siswa-new-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
            <input class="span2" type="text" readonly="" value="<?php echo $tgllhr ?>" name="tgllhr">
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('agama'))) echo 'error'; ?>">
    <label class="control-label" for="agama">Agama</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-agama" type="text" name="agama" placeholder="Agama..." value="<?php echo $agama ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('email'))) echo 'error'; ?>">
    <label class="control-label" for="email">E-Mail</label>
    <div class="controls">
        <input type="text" name="email" placeholder="E-Mail..." value="<?php echo $email ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almt">Alamat</label>
    <div class="controls">
        <textarea name="almt" placeholder="Alamat..." value="<?php echo $almt ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rt">RT</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rt" placeholder="RT..." value="<?php echo $rt ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rw">RW</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rw" placeholder="RW..." value="<?php echo $rw ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="desa">Desa</label>
    <div class="controls">
        <input type="text" name="desa" placeholder="Desa..." value="<?php echo $desa ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kec">Kecamatan</label>
    <div class="controls">
        <input type="text" name="kec" placeholder="Kecamatan..." value="<?php echo $kec ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kodepos'))) echo 'error'; ?>">
    <label class="control-label" for="kodepos">Kode Pos</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="kodepos" placeholder="Kode Pos..." value="<?php echo $kodepos ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('notel'))) echo 'error'; ?>">
    <label class="control-label" for="notel">No Telepon</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="notel" placeholder="No Telepon..." value="<?php echo $notel ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nohp'))) echo 'error'; ?>">
    <label class="control-label" for="nohp">No Handphone</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nohp" placeholder="No Handphone..." value="<?php echo $nohp ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tahun_masuk'))) echo 'error'; ?>">
    <label class="control-label" for="tahun_masuk">Tahun Masuk</label>
    <div class="controls">
        <input autocomplete="off" class="positive-integer typeahead-tahun" type="text" name="tahun_masuk" placeholder="Tahun Masuk..." value="<?php echo $tahun_masuk ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmsekolah">Nama Sekolah</label>
    <div class="controls">
        <input type="text" name="nmsekolah" placeholder="Nama Sekolah..." value="<?php echo $nmsekolah ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almtsekolah">Alamat Sekolah</label>
    <div class="controls">
        <input type="text" name="almtsekolah" placeholder="Alamat Sekolah..." value="<?php echo $almtsekolah ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="noijasah">No Ijazah</label>
    <div class="controls">
        <input type="text" name="noijasah" placeholder="No Ijazah..." value="<?php echo $noijasah ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nilaiijasah">Nilai Ijazah</label>
    <div class="controls">
        <input type="text" name="nilaiijasah" placeholder="Nilai Ijazah..." value="<?php echo $nilaiijasah ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nilaiskl">Nilai SKL</label>
    <div class="controls">
        <input type="text" name="nilaiskl" placeholder="Nilai SKL..." value="<?php echo $nilaiskl ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmbpk">Nama Bapak</label>
    <div class="controls">
        <input type="text" name="nmbpk" placeholder="Nama Bapak..." value="<?php echo $nmbpk ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pendidikanbpk">Pendidikan Bapak</label>
    <div class="controls">
        <input type="text" name="pendidikanbpk" placeholder="Pendidikan Bapak..." value="<?php echo $pendidikanbpk ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pkrjbpk">Pekerjaan Bapak</label>
    <div class="controls">
        <input type="text" name="pkrjbpk" placeholder="Pekerjaan Bapak..." value="<?php echo $pkrjbpk ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nmibu">Nama Ibu</label>
    <div class="controls">
        <input type="text" name="nmibu" placeholder="Nama Ibu..." value="<?php echo $nmibu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pendidikanibu">Pendidikan Ibu</label>
    <div class="controls">
        <input type="text" name="pendidikanibu" placeholder="Pendidikan Ibu..." value="<?php echo $pendidikanibu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="pkrjibu">Pekerjaan Ibu</label>
    <div class="controls">
        <input type="text" name="pkrjibu" placeholder="Pekerjaan Ibu..." value="<?php echo $pkrjibu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="almtortu">Alamat</label>
    <div class="controls">
        <textarea name="almtortu" placeholder="Alamat..." value="<?php echo $almtortu ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rtortu">RT</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rtortu" placeholder="RT..." value="<?php echo $rtortu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rwortu">RW</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="rwortu" placeholder="RW..." value="<?php echo $rwortu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="desaortu">Desa</label>
    <div class="controls">
        <input type="text" name="desaortu" placeholder="Desa..." value="<?php echo $desaortu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kecortu">Kecamatan</label>
    <div class="controls">
        <input type="text" name="kecortu" placeholder="Kecamatan..." value="<?php echo $kecortu ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kotaortu">Kota</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tempat" type="text" name="kotaortu" placeholder="Kota..." value="<?php echo $kotaortu ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kodeposortu'))) echo 'error'; ?>">
    <label class="control-label" for="kodeposortu">Kode Pos</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="kodeposortu" placeholder="Kode Pos..." value="<?php echo $kodeposortu ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tlportu'))) echo 'error'; ?>">
    <label class="control-label" for="tlportu">No Telepon</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="tlportu" placeholder="No Telepon..." value="<?php echo $tlportu ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('penghasilanortu'))) echo 'error'; ?>">
    <label class="control-label" for="penghasilanortu">Penghasilan</label>
    <div class="controls">
        <select class="span3" name="penghasilanortu">
            <option value="">- Pilih Penghasilan -</option>
            <option value="1" <?php echo $penghasilanortu === "1" ? "selected" : "" ?>>&lt; Rp. 500.000</option>
            <option value="2" <?php echo $penghasilanortu === "2" ? "selected" : "" ?>>Rp. 500.000 - Rp. 1.000.000</option>
            <option value="3" <?php echo $penghasilanortu === "3" ? "selected" : "" ?>>Rp. 1.000.000 - Rp. 1.500.000</option>
            <option value="4" <?php echo $penghasilanortu === "4" ? "selected" : "" ?>>Rp. 1.500.000 - Rp. 2.000.000</option>
            <option value="5" <?php echo $penghasilanortu === "5" ? "selected" : "" ?>>Rp. 2.000.000 - Rp. 3.000.000</option>
            <option value="6" <?php echo $penghasilanortu === "6" ? "selected" : "" ?>>Rp. 3.000.000 - Rp. 5.000.000</option>
            <option value="7" <?php echo $penghasilanortu === "7" ? "selected" : "" ?>>&gt; Rp. 5.000.000</option>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('siswas') ?>" class="btn">Kembali</a>
</div>
</form>
