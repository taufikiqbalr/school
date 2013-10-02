<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('gurukelasmatpels/'.$guru_kelas_matpel['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if(($this->session->flashdata('guru_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_id">Guru</label>
    <div class="controls">
        <label class="checkbox" for="guru_id"><?php echo $guru['nama'] ?></label>
        <input type="hidden" name="guru_id" value="<?php echo $guru_kelas_matpel['guru_id'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kelas_bagian_id'))) echo 'error'; ?>">
    <label class="control-label" for="kelas_bagian_id">Kelas</label>
    <div class="controls">
        <select class="span2" name="kelas_bagian_id">
            <?php if (!empty($kelas_bagians)) { ?>
                <?php foreach ($kelas_bagians as $kelas_bagian): ?>
                    <option value="<?php echo $kelas_bagian['id'] ?>" <?php echo $guru_kelas_matpel['kelas_bagian_id'] === $kelas_bagian['id'] ? "selected" : "" ?>><?php echo get_full_kelas($kelas_bagian['id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                    <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('guru_mata_pelajaran_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_mata_pelajaran_id">Mata Pelajaran</label>
    <div class="controls">
        <select class="span2" name="guru_mata_pelajaran_id">
            <?php if (!empty($guru_mata_pelajarans)) { ?>
                <?php foreach ($guru_mata_pelajarans as $guru_mata_pelajaran): ?>
                    <option value="<?php echo $guru_mata_pelajaran['id'] ?>" <?php echo $guru_kelas_matpel['guru_mata_pelajaran_id'] === $guru_mata_pelajaran['id'] ? "selected" : "" ?>><?php echo get_full_mata_pelajaran($guru_mata_pelajaran['mata_pelajaran_id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                    <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('gurus/'.$guru_kelas_matpel['guru_id']) ?>" class="btn">Kembali</a>
</div>
</form>
