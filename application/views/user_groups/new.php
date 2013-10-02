<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('usergroups/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('group_name'))) echo 'error'; ?>">
    <label class="control-label" for="group_name">Nama Grup</label>
    <div class="controls">
        <input type="text" name="group_name" placeholder="Nama Grup..." value="<?php echo $group_name ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('group_desc'))) echo 'error'; ?>">
    <label class="control-label" for="group_desc">Deskripsi Grup</label>
    <div class="controls">
        <input type="text" name="group_desc" placeholder="Deskripsi Grup..." value="<?php echo $group_desc ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('group_admin'))) echo 'error'; ?>">
    <label class="control-label" for="group_admin">Grup Admin</label>
    <div class="controls">
        <input type="checkbox" name="group_admin" value="1" <?php if(!empty($group_admin)){if($group_admin==="1") echo 'checked';} ?>>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('usergroups') ?>" class="btn">Kembali</a>
</div>
</form>
