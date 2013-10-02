<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('staffs/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('nik'))) echo 'error'; ?>">
    <label class="control-label" for="nik">NIK</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="nik" placeholder="NIK..." value="<?php echo $nik ?>">
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
        <select class="span2" name="jenis_kelamin" id="staff-order">
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
        <div id="dp-staff-new-tgl_lhr" class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
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
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('staffs') ?>" class="btn">Kembali</a>
</div>
</form>
