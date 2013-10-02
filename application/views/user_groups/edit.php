<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('usergroups/'.$user_group['ugrp_id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if(($this->session->flashdata('group_name'))) echo 'error'; ?>">
    <label class="control-label" for="group_name">Nama Grup</label>
    <div class="controls">
        <input type="text" name="group_name" value="<?php echo $user_group['ugrp_name'] ?>">
    </div>
</div>
<div class="control-group <?php if(($this->session->flashdata('group_desc'))) echo 'error'; ?>">
    <label class="control-label" for="group_desc">Deskripsi Grup</label>
    <div class="controls">
        <input type="text" name="group_desc" value="<?php echo $user_group['ugrp_desc'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('group_admin'))) echo 'error'; ?>">
    <label class="control-label" for="group_admin">Grup Admin</label>
    <div class="controls">
        <input type="checkbox" name="group_admin" value="1" <?php if(!empty($user_group['ugrp_admin'])){if($user_group['ugrp_admin']==="1") echo 'checked';} ?>>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('usergroups/'.$user_group['ugrp_id']) ?>" class="btn">Kembali</a>
</div>
</form>