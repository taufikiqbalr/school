<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('gurus/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('nip'))) echo 'error'; ?>">
    <label class="control-label" for="nip">NIP</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nip" placeholder="NIP..." value="<?php echo $nip ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $nama ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jenis_kelamin'))) echo 'error'; ?>">
    <label class="control-label" for="jenis_kelamin">Jenis Kelamin</label>
    <div class="controls">
        <select class="span2" name="jenis_kelamin">
            <option value="1" <?php echo $jenis_kelamin === "1" ? "selected" : "" ?>>Laki-Laki</option>
            <option value="0" <?php echo $jenis_kelamin === "0" ? "selected" : "" ?>>Perempuan</option>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tempat_lahir'))) echo 'error'; ?>">
    <label class="control-label" for="tempat_lahir">Tempat Lahir</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tempat" type="text" name="tempat_lahir" placeholder="Tempat Lahir..." value="<?php echo $tempat_lahir ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tanggal_lahir'))) echo 'error'; ?>">
    <label class="control-label" for="tanggal_lahir">Tanggal Lahir</label>
    <div class="controls">
        <div id="dp-guru-new-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
            <input class="span2" type="text" readonly="" value="<?php echo $tanggal_lahir ?>" name="tanggal_lahir">
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
    <label class="control-label" for="alamat">Alamat</label>
    <div class="controls">
        <textarea name="alamat" placeholder="Alamat..." value="<?php echo $alamat ?>"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rt">RT</label>
    <div class="controls">
        <input type="text" class="positive-integer" name="rt" placeholder="RT..." value="<?php echo $rt ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="rw">RW</label>
    <div class="controls">
        <input type="text" class="positive-integer" name="rw" placeholder="RW..." value="<?php echo $rw ?>">
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
<div class="control-group">
    <label class="control-label" for="kota">Kota</label>
    <div class="controls">
        <input type="text" name="kota" placeholder="Kota..." value="<?php echo $kota ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kodepos'))) echo 'error'; ?>">
    <label class="control-label" for="kodepos">Kode Pos</label>
    <div class="controls">
        <input type="text" class="positive-integer" name="kodepos" placeholder="Kode Pos..." value="<?php echo $kodepos ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="status">Status</label>
    <div class="controls">
        <input type="text" name="status" placeholder="Status..." value="<?php echo $status ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="no_telepon">No Telepon</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="no_telepon" placeholder="No Telepon..." value="<?php echo $no_telepon ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="no_handphone">No Handphone</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="no_handphone" placeholder="No Handphone..." value="<?php echo $no_handphone ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tanggal_pengangkatan'))) echo 'error'; ?>">
    <label class="control-label" for="tanggal_pengangkatan">Tanggal Pengangkatan</label>
    <div class="controls">
        <div id="dp-guru-new-tgl_pgkt" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
            <input class="span2" type="text" readonly="" value="<?php echo $tanggal_pengangkatan ?>" name="tanggal_pengangkatan">
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nuptk">NUPTK</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nuptk" placeholder="NUPTK..." value="<?php echo $nuptk ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nrg">NRG</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nrg" placeholder="NRG..." value="<?php echo $nrg ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nsg">NSG</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nsg" placeholder="NSG..." value="<?php echo $nsg ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('gurus') ?>" class="btn">Kembali</a>
</div>
</form>
