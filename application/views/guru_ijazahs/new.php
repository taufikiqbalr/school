<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('guruijazahs/create/'.$guru_id, 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('guru_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_id">Guru</label>
    <div class="controls">
        <label class="checkbox" for="guru_id"><?php echo $guru_nama ?></label>
        <input type="hidden" name="guru_id" value="<?php echo $guru_id ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama_instansi'))) echo 'error'; ?>">
    <label class="control-label" for="nama_instansi">Nama Instansi</label>
    <div class="controls">
        <input type="text" name="nama_instansi" placeholder="Nama Instansi..." value="<?php echo $nama_instansi ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tingkat'))) echo 'error'; ?>">
    <label class="control-label" for="tingkat">Tingkat</label>
    <div class="controls">
        <input type="text" name="tingkat" placeholder="Tingkat..." value="<?php echo $tingkat ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama_gelar'))) echo 'error'; ?>">
    <label class="control-label" for="nama_gelar">Nama Gelar</label>
    <div class="controls">
        <input type="text" name="nama_gelar" placeholder="Nama Gelar..." value="<?php echo $nama_gelar ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('gurus/'.$guru_id) ?>" class="btn">Kembali</a>
</div>
</form>
