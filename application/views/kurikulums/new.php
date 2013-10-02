<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('kurikulums/create', 'class="form-horizontal"') ?>
<div class="control-group <?php if (($this->session->flashdata('nama'))) echo 'error'; ?>">
    <label class="control-label" for="nama">Nama</label>
    <div class="controls">
        <input autocomplete="off" class="positive-integer typeahead-tahun" type="text" name="nama" placeholder="Nama..." value="<?php echo $nama ?>">
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('kurikulums') ?>" class="btn">Kembali</a>
</div>
</form>
