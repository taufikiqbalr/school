<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-kelas a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<?php if (is_privilege('NEW_KELAS')) { ?>
    <?php echo form_open_multipart('kelas/upload'); ?>

    <input type="file" name="kelas" size="20" />

    <input type="submit" value="upload" />
    
    <a href="<?php echo base_url('upload/template_kelas.xls') ?>">Template Kelas</a>

    </form>
<?php } ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('kelas') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="kelas-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="kelas-column">
        <option value="tingkat" <?php echo $column === "tingkat" ? "selected" : "" ?>>Tingkat</option>
    </select>
    <button type="submit" class="btn">GO</button>
</form>

<?php echo form_open('kelas/deletes', 'id="tb_kelas_idx_frm"') ?>
<table class="table table-hover kelas_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="kelas_checkall" name="kelas_checkall" value="kelas_checkall" />
            </td>
            <td>Tingkat</td>
            <td>Jurusan</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_KELAS', $this->session->userdata('privileges'))) { ?>
                            <li>
                                <a href="#modal_kelas_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($kelas)) { ?>
            <?php foreach ($kelas as $key => $kela): ?>
                <tr>
                    <td>
                        <input class="kelas_index_ck" name="ids[]" type="checkbox" value="<?php echo $kela['id']; ?>">
                    </td>
                    <td>
                        <?php echo $kela['tingkat'] ?>
                    </td>
                    <td>
                        <?php echo get_nama_jurusan($kela['jurusan_id']) ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_KELAS', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('kelas/' . $kela['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_KELAS', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('kelas/' . $kela['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_KELAS', $this->session->userdata('privileges'))) { ?>
                                <a href="#modal_kelas_delete<?php echo $kela['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_kelas_delete<?php echo $kela['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Kelas</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus kelas tingkat <?php echo $kela['tingkat'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('kelas/' . $kela['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="4"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-kelas" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_KELAS', $this->session->userdata('privileges'))) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('kelas/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_kelas_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Kelas</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="kelas_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
