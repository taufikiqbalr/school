<?php echo $this->session->flashdata('message'); ?>

<?php echo form_open('spps/create', 'class="form-horizontal"') ?>
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
<div class="control-group <?php if (($this->session->flashdata('bulan_tempo'))) echo 'error'; ?>">
    <label class="control-label" for="bulan_tempo">Bulan</label>
    <div class="controls">
        <select name="bulan_tempo">
            <option value=""> </option>
            <?php foreach (months() as $key => $month) : ?>
                <option value="<?php echo $key + 1 ?>" <?php echo ($key+1) === ((int)$bulan_tempo) ? "selected" : "" ?>><?php echo $month ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tahun_tempo'))) echo 'error'; ?>">
    <label class="control-label" for="tahun_tempo">Tahun</label>
    <div class="controls">
        <input autocomplete="off" class="typeahead-tahun" type="text" name="tahun_tempo" placeholder="Tahun..." value="<?php echo $tahun_tempo ?>">
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('biaya'))) echo 'error'; ?>">
    <label class="control-label" for="biaya">Biaya</label>
    <div class="controls">
        <div class="input-prepend input-append">
        <span class="add-on">Rp</span>
        <input name="biaya" class="positive-integer" type="text" placeholder="Biaya..." value="<?php echo $biaya ?>">
        <span class="add-on">.00</span>
        </div>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('bayar'))) echo 'error'; ?>">
    <label class="control-label" for="bayar">Bayar</label>
    <div class="controls">
        <div class="input-prepend input-append">
        <span class="add-on">Rp</span>
        <input name="bayar" class="positive-integer" type="text" placeholder="Bayar..." value="<?php echo $bayar ?>">
        <span class="add-on">.00</span>
        </div>
    </div>
</div>
<div class="control-group <?php if (($this->session->flashdata('tanggal_bayar'))) echo 'error'; ?>">
    <label class="control-label" for="tanggal_bayar">Tanggal Bayar</label>
    <div class="controls">
        <div class="input-append date" data-date-format="yyyy-mm-dd" data-date="2012-12-12">
            <input name="tanggal_bayar" class="span2" type="text" readonly="" value="<?php echo $tanggal_bayar ?>">
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>
    </div>
</div>
<div class=" form-actions">
    <button type="submit" name="submit" class="btn btn-success button-save" data-loading-text="Menyimpan...">Simpan</button>
    <a href="<?php echo site_url('spps') ?>" class="btn">Kembali</a>
</div>
</form>
