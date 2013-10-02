<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('privileges/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('priv_name'))) echo 'error'; ?>">
    <label class="control-label" for="priv_name">Nama Hak Akses</label>
    <div class="controls">
        <input type="text" name="priv_name" placeholder="Nama Hak Akses..." value="<?php echo $priv_name ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('priv_desc'))) echo 'error'; ?>">
    <label class="control-label" for="priv_desc">Deskripsi Hak Akses</label>
    <div class="controls">
        <input type="text" name="priv_desc" placeholder="Deskripsi Hak Akses..." value="<?php echo $priv_desc ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('privileges') ?>" class="btn">Kembali</a>
</div>
</form>
