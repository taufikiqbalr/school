<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('matapelajarans/'.$mata_pelajaran['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('kode'))) echo 'error'; ?>">
    <label class="control-label" for="kode">Kode</label>
    <div class="controls">
        <input type="text" name="kode" placeholder="Kode..." value="<?php echo $mata_pelajaran['kode'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $mata_pelajaran['nama'] ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('jumlah_jam'))) echo 'error'; ?>">
    <label class="control-label" for="jumlah_jam">Jumlah Jam</label>
    <div class="controls">
        <input class="positive-integer" type="text" name="jumlah_jam" placeholder="Jumlah Jam..." value="<?php echo $mata_pelajaran['jumlah_jam'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('matapelajarans/'.$mata_pelajaran['id']) ?>" class="btn">Kembali</a>
</div>
</form>