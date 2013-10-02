<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('kelas/create', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('tingkat'))) echo 'error'; ?>">
    <label class="control-label" for="tingkat">Tingkat</label>
    <div class="controls">
        <input type="text" name="tingkat" placeholder="Tingkat kelas" value="<?php echo $tingkat ?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="jurusan_id">Jurusan</label>
    <div class="controls">
        <select class="span2" name="jurusan_id">
            <?php if (!empty($jurusans)) { ?>
                <option value=""> </option>
                <?php foreach ($jurusans as $jurusan): ?>
                    <option value="<?php echo $jurusan['id'] ?>" <?php echo $jurusan_id === $jurusan['id'] ? "selected" : "" ?>><?php echo get_nama_jurusan($jurusan['id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('kelas') ?>" class="btn">Kembali</a>
</div>
</form>