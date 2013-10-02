<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('jurusans/'.$jurusan['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input type="text" name="nama" placeholder="Nama..." value="<?php echo $jurusan['nama'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('jurusans/'.$jurusan['id']) ?>" class="btn">Kembali</a>
</div>
</form>