<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('userprivileges/'.$user_privilege['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if(($this->session->flashdata('upriv_users_uacc_fk'))) echo 'error'; ?>">
    <label class="control-label" for="priv_name">Nama User</label>
    <div class="controls">
        <select class="span2" name="upriv_users_uacc_fk">
            <?php if (!empty($users)) { ?>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['uacc_id'] ?>" <?php echo $user_privilege['upriv_users_uacc_fk'] === $user['uacc_id'] ? "selected" : "" ?>><?php echo $user['uacc_username'] ?></option>
                <?php endforeach ?>
            <?php } else { ?>
                <option></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if(($this->session->flashdata('upriv_users_upriv_fk'))) echo 'error'; ?>">
    <label class="control-label" for="priv_desc">Nama Hak Akses</label>
    <div class="controls">
        <select class="span2" name="upriv_users_upriv_fk">
            <?php if (!empty($privileges)) { ?>
                <?php foreach ($privileges as $privilege): ?>
                    <option value="<?php echo $privilege['upriv_id'] ?>" <?php echo $user_privilege['upriv_users_upriv_fk'] === $privilege['upriv_id'] ? "selected" : "" ?>><?php echo $privilege['upriv_name'] ?></option>
                <?php endforeach ?>
            <?php } else { ?>
                <option></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('userprivileges/'.$user_privilege['id']) ?>" class="btn">Kembali</a>
</div>
</form>