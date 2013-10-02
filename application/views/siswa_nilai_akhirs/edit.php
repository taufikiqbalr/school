<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('siswanilais/'.$siswa_nilai_akhir['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group">
    <label class="control-label">Mata Pelajaran</label>
    <div class="controls">
        <?php echo $siswa_nilai_akhir['kode'].' - '.$siswa_nilai_akhir['nama_mata_pelajaran'] ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Kurikulum</label>
    <div class="controls">
        <?php echo $siswa_nilai_akhir['nama_kurikulum']; ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Kelas</label>
    <div class="controls">
        <?php echo $siswa_nilai_akhir['tingkat'].' '.$siswa_nilai_akhir['nama_jurusan'].' '.$siswa_nilai_akhir['nama_kelas'] ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Tahun Ajaran</label>
    <div class="controls">
        <?php echo $siswa_nilai['nama_tahun_ajaran']; ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Semester</label>
    <div class="controls">
        <?php echo $siswa_nilai['semester'] === "1" ? "Ganjil" : "Genap"; ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Siswa</label>
    <div class="controls">
        <?php echo $siswa_nilai_akhir['nis'].' - '.$siswa_nilai_akhir['nama_siswa'] ?>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nilai_akhir'))) echo 'error'; ?>">
    <label class="control-label" for="nilai_akhir">Nilai Akhir</label>
    <div class="controls">
        <input class="positive" type="text" name="nilai_akhir" placeholder="Nilai Akhir..." value="<?php echo $siswa_nilai_akhir['nilai_akhir'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('siswanilaiakhirs/'.$siswa_nilai_akhir['id']) ?>" class="btn">Kembali</a>
</div>
</form>