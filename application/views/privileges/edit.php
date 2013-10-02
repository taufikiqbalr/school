<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('privileges/'.$privilege['upriv_id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if(($this->session->flashdata('priv_name'))) echo 'error'; ?>">
    <label class="control-label" for="priv_name">Nama Hak Akses</label>
    <div class="controls">
        <input type="text" name="priv_name" value="<?php echo $privilege['upriv_name'] ?>">
    </div>
</div>
<div class="control-group <?php if(($this->session->flashdata('priv_desc'))) echo 'error'; ?>">
    <label class="control-label" for="priv_desc">Deskripsi Hak Akses</label>
    <div class="controls">
        <input type="text" name="priv_desc" value="<?php echo $privilege['upriv_desc'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('privileges/'.$privilege['upriv_id']) ?>" class="btn">Kembali</a>
</div>
</form>