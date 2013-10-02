<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('users/' . $user['uacc_id'] . '/changepassword', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('current_password'))) echo 'error'; ?>">
    <label class="control-label" for="current_password">Current Password</label>
    <div class="controls">
        <input type="password" id="current_password" name="current_password" value=""/>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('new_password'))) echo 'error'; ?>">
    <label class="control-label" for="new_password">New Password</label>
    <div class="controls">
        <input type="password" id="new_password" name="new_password" value=""/>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('confirm_new_password'))) echo 'error'; ?>">
    <label class="control-label" for="confirm_new_password">Confirm New Password</label>
    <div class="controls">
        <input type="password" id="confirm_new_password" name="confirm_new_password" value=""/>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('users/' . $user['uacc_id'] . '/edit') ?>" class="btn">Kembali</a>
</div>
</form>