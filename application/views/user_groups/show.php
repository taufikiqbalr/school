<?php echo $this->session->flashdata('message'); ?>

<form class="form-horizontal">
    <div class="control-group">
        <label class="control-label">Nama Grup</label>
        <div class="controls">
            <?php echo $user_group['ugrp_name']; ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Deskripsi Grup</label>
        <div class="controls">
            <?php echo $user_group['ugrp_desc']; ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Admin Grup</label>
        <div class="controls">
            <?php echo ($user_group['ugrp_admin'] === "1") ? "Ya" : "Tidak"; ?>
        </div>
    </div>
</form>
