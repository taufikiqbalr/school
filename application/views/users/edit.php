<a href="<?php echo site_url('users/'.$user['uacc_id'].'/editpassword') ?>" class="btn btn-warning pull-right" style="margin-right: 10px">Ubah Password</a><br/>
<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('users/' . $user['uacc_id'] . '/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('uacc_username'))) echo 'error'; ?>">
    <label class="control-label" for="uacc_username">Username</label>
    <div class="controls">
        <input type="text" name="uacc_username" placeholder="Username..." value="<?php echo $user['uacc_username'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('uacc_email'))) echo 'error'; ?>">
    <label class="control-label" for="uacc_email">Email</label>
    <div class="controls">
        <input type="text" name="uacc_email" placeholder="Email..." value="<?php echo $user['uacc_email'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('uacc_group_fk'))) echo 'error'; ?>">
    <label class="control-label" for="uacc_group_fk">Grup</label>
    <div class="controls">
        <select class="span2" name="uacc_group_fk">
            <?php if (!empty($user_groups)) { ?>
                <?php foreach ($user_groups as $user_group): ?>
                    <option value="<?php echo $user_group['ugrp_id'] ?>" <?php echo $user['uacc_group_fk'] === $user_group['ugrp_id'] ? "selected" : "" ?>><?php echo $user_group['ugrp_name'] ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('users/' . $user['uacc_id']) ?>" class="btn">Kembali</a>
</div>
</form>