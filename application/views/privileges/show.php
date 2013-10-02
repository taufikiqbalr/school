<?php echo $this->session->flashdata('message'); ?>

<form class="form-horizontal">
    <div class="control-group">
        <label class="control-label">Nama Hak Akses</label>
        <div class="controls">
            <?php echo $privilege['upriv_name']; ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Deskripsi Hak Akses</label>
        <div class="controls">
            <?php echo $privilege['upriv_desc']; ?>
        </div>
    </div>
</form>