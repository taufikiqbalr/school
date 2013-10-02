<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('gurumatapelajarans/create/'.$guru_id, 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('guru_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_id">Guru</label>
    <div class="controls">
        <label class="checkbox" for="guru_id"><?php echo $guru_nama ?></label>
        <input type="hidden" name="guru_id" value="<?php echo $guru_id ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('mata_pelajaran_id'))) echo 'error'; ?>">
    <label class="control-label" for="mata_pelajaran_id">Mata Pelajaran</label>
    <div class="controls">
        <select class="span2" name="mata_pelajaran_id">
            <?php if (!empty($mata_pelajarans)) { ?>
                <?php foreach ($mata_pelajarans as $mata_pelajaran): ?>
                    <option value="<?php echo $mata_pelajaran['id'] ?>" <?php echo $mata_pelajaran_id === $mata_pelajaran['id'] ? "selected" : "" ?>><?php echo get_full_mata_pelajaran($mata_pelajaran['id']) ?></option>
                <?php endforeach; ?>
            <?php }else { ?>
                    <option value=""> </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('semester'))) echo 'error'; ?>">
    <label class="control-label" for="semester">Semester</label>
    <div class="controls">
        <select class="span2" name="semester">
            <option value="1" <?php echo $semester === "1" ? "selected" : "" ?>>Ganjil</option>
            <option value="2" <?php echo $semester === "2" ? "selected" : "" ?>>Genap</option>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kurikulum_id'))) echo 'error'; ?>">
    <label class="control-label" for="kurikulum_id">Kurikulum</label>
    <div class="controls">
        <select class="span2" name="kurikulum_id">
            <?php if (!empty($kurikulums)) { ?>
                <?php foreach ($kurikulums as $kurikulum): ?>
                    <option value="<?php echo $kurikulum['id'] ?>" <?php echo $kurikulum_id === $kurikulum['id'] ? "selected" : "" ?>><?php echo get_nama_kurikulum($kurikulum['id']) ?></option>
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
