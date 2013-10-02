<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('absensis/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('siswa_id'))) echo 'error'; ?>">
    <label class="control-label" for="siswa_id">Siswa</label>
    <div class="controls">
        <select class="span3" name="siswa_id">
            <option value=""> </option>
            <?php if (!empty($siswas)) { ?>
                <?php foreach ($siswas as $siswa): ?>
                    <option value="<?php echo $siswa['id'] ?>" <?php echo $siswa_id === $siswa['id'] ? "selected" : "" ?>><?php echo $siswa['nis'] . '-' . $siswa['nama'] ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('kelas_bagian_id'))) echo 'error'; ?>">
    <label class="control-label" for="kelas_bagian_id">Kelas</label>
    <div class="controls">
        <select class="span3" name="kelas_bagian_id">
            <option value=""> </option>
            <?php if (!empty($kelas_bagians)) { ?>
                <?php foreach ($kelas_bagians as $kelas_bagian): ?>
                    <option value="<?php echo $kelas_bagian['id'] ?>" <?php echo $kelas_bagian_id === $kelas_bagian['id'] ? "selected" : "" ?>><?php echo get_full_kelas($kelas_bagian['id']) ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<!-- is_matpel = 1 -->
<div class="control-group <?php if (($this->session->flashdata('mata_pelajaran_id'))) echo 'error'; ?>">
    <label class="control-label" for="mata_pelajaran_id">Mata Pelajaran</label>
    <div class="controls">
        <select class="span3" name="mata_pelajaran_id">
            <option value=""> </option>
            <?php if (!empty($mata_pelajarans)) { ?>
                <?php foreach ($mata_pelajarans as $mata_pelajaran): ?>
                    <option value="<?php echo $mata_pelajaran['id'] ?>" <?php echo $mata_pelajaran_id === $mata_pelajaran['id'] ? "selected" : "" ?>><?php echo get_full_mata_pelajaran($mata_pelajaran['id']) ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('guru_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_id">Guru</label>
    <div class="controls">
        <select class="span3" name="guru_id">
            <option value=""> </option>
            <?php if (!empty($gurus)) { ?>
                <?php foreach ($gurus as $guru): ?>
                    <option value="<?php echo $guru['id'] ?>" <?php echo $guru_id === $guru['id'] ? "selected" : "" ?>><?php echo get_full_guru($guru['id']) ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<!-- end matpel -->
<div class="control-group <?php if (($this->session->flashdata('tanggal'))) echo 'error'; ?>">
    <label class="control-label" for="tanggal">Tanggal</label>
    <div class="controls">
        <select name="tanggal">
            <option value=""> </option>
            <?php for ($i = 1; $i <= 31; $i++) { ?>
                <option value="<?php echo $i ?>" <?php echo $tanggal === $i ? "selected" : "" ?>><?php echo $i ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('bulan'))) echo 'error'; ?>">
    <label class="control-label" for="bulan">Bulan</label>
    <div class="controls">
        <select name="bulan">
            <option value=""> </option>
            <?php foreach (months() as $key => $month) : ?>
                <option value="<?php echo $key + 1 ?>" <?php echo ($key+1) === ((int)$bulan) ? "selected" : "" ?>><?php echo $month ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tahun_ajaran_id'))) echo 'error'; ?>">
    <label class="control-label" for="tahun_ajaran_id">Tahun</label>
    <div class="controls">
        <select name="tahun_ajaran_id">
            <option value=""> </option>
            <?php if (!empty($tahun_ajarans)) { ?>
                <?php foreach ($tahun_ajarans as $tahun_ajaran): ?>
                    <option value="<?php echo $tahun_ajaran['id'] ?>" <?php echo $tahun_ajaran_id === $tahun_ajaran['id'] ? "selected" : "" ?>><?php echo $tahun_ajaran['nama'] ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('absensi'))) echo 'error'; ?>">
    <label class="control-label" for="absensi">Absensi</label>
    <div class="controls">
        <select name="absensi">
            <option value=""></option>
            <?php foreach (absensi() as $key => $absen) : ?>
                <option value="<?php echo $key+1 ?>" <?php echo $key === $absensi ? "selected" : "" ?>><?php echo $absen ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('keterangan'))) echo 'error'; ?>">
    <label class="control-label" for="keterangan">Keterangan</label>
    <div class="controls">
        <input type="text" name="keterangan" placeholder="Keterangan..." value="<?php echo $keterangan ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('absensis') ?>" class="btn">Kembali</a>
</div>
</form>
