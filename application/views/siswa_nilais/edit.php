<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('siswanilais/'.$siswa_nilai['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('guru_kelas_matpel_id'))) echo 'error'; ?>">
    <label class="control-label" for="guru_kelas_matpel_id">Mata Pelajaran</label>
    <div class="controls">
        <select class="span2" name="guru_kelas_matpel_id">
            <option value="">-Pilih Mata Pelajaran-</option>
            <?php if (!empty($guru_kelas_matpels)) { ?>
                <?php foreach ($guru_kelas_matpels as $guru_kelas_matpel): ?>
                    <option value="<?php echo $guru_kelas_matpel['id'] ?>" <?php echo $siswa_nilai['guru_kelas_matpel_id'] === $guru_kelas_matpel['id'] ? "selected" : "" ?>><?php echo $guru_kelas_matpel['nama_guru']."-".$guru_kelas_matpel['nama_mata_pelajaran']."-".$guru_kelas_matpel['semester']."-".$guru_kelas_matpel['nama_tahun_ajaran']."-".$guru_kelas_matpel['tingkat']." ".$guru_kelas_matpel['nama_jurusan']." ".$guru_kelas_matpel['nama_kelas'] ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('siswa_id'))) echo 'error'; ?>">
    <label class="control-label" for="siswa_id">Siswa</label>
    <div class="controls">
        <select class="span2" name="siswa_id">
            <option value="">-Pilih Siswa-</option>
            <?php if (!empty($siswas)) { ?>
                <?php foreach ($siswas as $siswa): ?>
                    <option value="<?php echo $siswa['id'] ?>" <?php echo $siswa_nilai['siswa_id'] === $siswa['id'] ? "selected" : "" ?>><?php echo $siswa["nis"]."-".$siswa['nama'] ?></option>
                <?php endforeach; ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jenis'))) echo 'error'; ?>">
    <label class="control-label" for="jenis">Jenis</label>
    <div class="controls">
        <select class="span2" name="jenis">
            <option value="">-Pilih Jenis-</option>
            <option value="absensi" <?php echo $siswa_nilai['jenis'] === "ABSENSI" ? "selected" : "" ?>>Absensi</option>
            <option value="tugas" <?php echo $siswa_nilai['jenis'] === "TUGAS" ? "selected" : "" ?>>Tugas</option>
            <option value="uts" <?php echo $siswa_nilai['jenis'] === "UTS" ? "selected" : "" ?>>UTS</option>
            <option value="uas" <?php echo $siswa_nilai['jenis'] === "UAS" ? "selected" : "" ?>>UAS</option>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $siswa_nilai['nama'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nilai'))) echo 'error'; ?>">
    <label class="control-label" for="nilai">Nilai</label>
    <div class="controls">
        <input class="positive" type="text" name="nilai" placeholder="Nilai..." value="<?php echo $siswa_nilai['nilai'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('siswanilais/'.$siswa_nilai['id']) ?>" class="btn">Kembali</a>
</div>
</form>