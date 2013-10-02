<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('groupprivileges/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('upriv_groups_ugrp_fk'))) echo 'error'; ?>">
    <label class="control-label" for="upriv_groups_ugrp_fk">Nama Grup</label>
    <div class="controls">
        <select class="span2" name="upriv_groups_ugrp_fk">
            <?php if (!empty($user_groups)) { ?>
                <?php foreach ($user_groups as $user_group): ?>
                    <option value="<?php echo $user_group['ugrp_id'] ?>" <?php echo $upriv_groups_ugrp_fk === $user_group['ugrp_id'] ? "selected" : "" ?>><?php echo $user_group['ugrp_name'] ?></option>
                <?php endforeach ?>
            <?php } else { ?>
                <option></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('upriv_groups_upriv_fk'))) echo 'error'; ?>">
    <label class="control-label" for="upriv_groups_upriv_fk">Nama Hak Akses</label>
    <div class="controls">
        <select class="span2" name="upriv_groups_upriv_fk">
            <?php if (!empty($privileges)) { ?>
                <?php foreach ($privileges as $privilege): ?>
                    <option value="<?php echo $privilege['upriv_id'] ?>" <?php echo $upriv_groups_upriv_fk === $privilege['upriv_id'] ? "selected" : "" ?>><?php echo $privilege['upriv_name'] ?></option>
                <?php endforeach ?>
            <?php } else { ?>
                <option></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('groupprivileges') ?>" class="btn">Kembali</a>
</div>
</form>
