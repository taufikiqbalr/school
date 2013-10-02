<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('kelasbagians/'.$kelas_bagian['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if(($this->session->flashdata('kelas_id'))) echo 'error'; ?>">
    <label class="control-label" for="kelas_id">Kelas</label>
    <div class="controls">
        <label class="checkbox" for="kelas_id"><?php echo $kelas['tingkat'] ?></label>
        <input type="hidden" name="kelas_id" value="<?php echo $kelas_bagian['kelas_id'] ?>">
    </div>
</div>
<div class="control-group <?php if(($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Kelas Bagian</label>
    <div class="controls">
        <input type="text" name="nama" value="<?php echo $kelas_bagian['nama'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('kelas/'.$kelas_bagian['kelas_id']) ?>" class="btn">Kembali</a>
</div>
</form>
