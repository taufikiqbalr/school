<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('kelasbagians/create/'.$kelas_id, 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('kelas_id'))) echo 'error'; ?>">
    <label class="control-label" for="kelas_id">Kelas</label>
    <div class="controls">
        <label class="checkbox" for="kelas_id"><?php echo $kelas_tingkat ?></label>
        <input type="hidden" name="kelas_id" value="<?php echo $kelas_id ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Kelas Bagian</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama Kelas Bagian..." value="<?php echo $nama ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('kelas/'.$kelas_id) ?>" class="btn">Kembali</a>
</div>
</form>
