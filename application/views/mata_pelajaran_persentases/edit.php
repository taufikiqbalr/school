<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('matapelajaranpersentases/' . $mata_pelajaran_persentase['id'] . '/update', 'class="form-horizontal"') ?>

<div class="control-group">
    <label class="control-label" for="guru">Guru</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['nip'] . ' - ' . $mata_pelajaran_persentase['nama_guru'] ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="mata_pelajaran">Mata Pelajaran</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['kode'] . ' - ' . $mata_pelajaran_persentase['nama_mata_pelajaran'] ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="kelas">Kelas</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['tingkat'] . ' ' . $mata_pelajaran_persentase['nama_jurusan'] . ' ' . $mata_pelajaran_persentase['nama_kelas'] ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="nama_kurikulum">Kurikulum</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['nama_kurikulum']; ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="tahun_ajaran">Tahun Ajaran</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['nama_tahun_ajaran']; ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="semester">Semester</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['semester'] === "1" ? "Ganjil" : "Genap"; ?>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jenis'))) echo 'error'; ?>">
    <label class="control-label" for="jenis">Jenis</label>
    <div class="controls">
        <?php echo $mata_pelajaran_persentase['jenis']; ?>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('persentase'))) echo 'error'; ?>">
    <label class="control-label" for="persentase">Persentase</label>
    <div class="controls">
        <div class="input-append">
            <input class="positive" type="text" name="persentase" placeholder="Persentase..." value="<?php echo $mata_pelajaran_persentase['persentase'] ?>">
            <span class="add-on">%</span>
        </div>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('matapelajaranpersentases/' . $mata_pelajaran_persentase['id']) ?>" class="btn">Kembali</a>
</div>
</form>