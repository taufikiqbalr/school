<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('tahunajarans/'.$tahun_ajaran['id'].'/update', 'class="form-horizontal"') ?>

<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Tahun</label>
    <div class="controls">
        <input id="input-edit-ta-nama" autocomplete="off" class="positive-integer typeahead-tahun" type="text" name="nama" placeholder="Nama..." value="<?php echo $tahun_ajaran['nama'] ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('tahunajarans/'.$tahun_ajaran['id']) ?>" class="btn">Kembali</a>
</div>
</form>