<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('guruwalis/create/'.$guru_id, 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('guru_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_id">Guru</label>
    <div class="controls">
        <label class="checkbox" for="guru_id"><?php echo $guru_nama ?></label>
        <input type="hidden" name="guru_id" value="<?php echo $guru_id ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kelas_bagian_id'))) echo 'error'; ?>">
    <label class="control-label" for="kelas_bagian_id">Kelas</label>
    <div class="controls">
        <select class="span2" name="kelas_bagian_id">
            <?php if (!empty($kelas_bagians)) { ?>
                <?php foreach ($kelas_bagians as $kelas_bagian): ?>
                    <option value="<?php echo $kelas_bagian['id'] ?>" <?php echo $kelas_bagian_id === $kelas_bagian['id'] ? "selected" : "" ?>><?php echo get_full_kelas($kelas_bagian['id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                    <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tahun_ajaran_id'))) echo 'error'; ?>">
    <label class="control-label" for="tahun_ajaran_id">Tahun Ajaran</label>
    <div class="controls">
        <select class="span2" name="tahun_ajaran_id">
            <?php if (!empty($tahun_ajarans)) { ?>
                <?php foreach ($tahun_ajarans as $tahun_ajaran): ?>
                    <option value="<?php echo $tahun_ajaran['id'] ?>" <?php echo $tahun_ajaran_id === $tahun_ajaran['id'] ? "selected" : "" ?>><?php echo get_nama_tahun_ajaran($tahun_ajaran['id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                    <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('gurus/'.$guru_id) ?>" class="btn">Kembali</a>
</div>
</form>
