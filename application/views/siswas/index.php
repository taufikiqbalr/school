<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-siswa a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<?php if (is_privilege('NEW_SISWA')) { ?>
    <?php echo form_open_multipart('siswas/upload'); ?>

    <input type="file" name="siswa" size="20" />

    <input type="submit" value="upload" />
    
    <a href="<?php echo base_url('upload/template_siswa.xls') ?>">Template Siswa</a>

    </form>
<?php } ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('siswas') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="siswa-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="siswa-column">
        <option value="nis" <?php echo $column === "nis" ? "selected" : "" ?>>NIS</option>
        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
        <option value="nohp" <?php echo $column === "nohp" ? "selected" : "" ?>>No Handphone</option>
        <option value="jk" <?php echo $column === "jk" ? "selected" : "" ?>>Jenis Kelamin</option>
    </select>
    <button type="submit" class="btn">GO</button>
</form>

<?php echo form_open('siswas/deletes', 'id="tb_siswa_idx_frm"') ?>
<table class="table table-hover siswa_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="siswa_checkall" name="siswa_checkall" value="siswa_checkall" />
            </td>
            <td>NIP</td>
            <td>Nama</td>
            <td>No Handphone</td>
            <td>Jenis Kelamin</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_SISWA', $this->session->userdata('privileges'))) { ?>
                            <li>
                                <a href="#modal_siswa_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswas)) { ?>
            <?php foreach ($siswas as $key => $siswa): ?>
                <tr>
                    <td>
                        <input class="siswa_index_ck" name="ids[]" type="checkbox" value="<?php echo $siswa['id']; ?>">
                    </td>
                    <td>
                        <?php echo $siswa['nis'] ?>
                    </td>
                    <td>
                        <?php echo $siswa['nama'] ?>
                    </td>
                    <td>
                        <?php echo $siswa['nohp'] ?>
                    </td>
                    <td>
                        <?php echo ($siswa['jk'] === "1") ? "Laki-Laki" : "Perempuan" ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_SISWA', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('siswas/' . $siswa['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_SISWA', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('siswas/' . $siswa['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_SISWA', $this->session->userdata('privileges'))) { ?>
                                <a href="#modal_siswa_delete<?php echo $siswa['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_siswa_delete<?php echo $siswa['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Siswa</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data siswa <?php echo $siswa['nip'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('siswas/' . $siswa['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="6"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-siswa" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_SISWA', $this->session->userdata('privileges'))) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('siswas/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_siswa_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Siswa</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="siswa_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
