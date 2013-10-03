<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-tahun_ajaran a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>
<div class="accordion" id="accordion2">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="float: right;">
                Advance <i class="icon-filter"></i> 
            </a>
            <div class="clearfix"></div>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
            <div class="accordion-inner">
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('tahunajarans') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="tahun_ajaran-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="tahun_ajaran-column">
                        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('tahun_ajarans/deletes', 'id="tb_tahun_ajaran_idx_frm"') ?>
<table class="table table-hover tahun_ajaran_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="tahun_ajaran_checkall" name="tahun_ajaran_checkall" value="tahun_ajaran_checkall" />
            </td>
            <td>Nama</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
                            <li>
                                <a href="#modal_tahun_ajaran_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tahun_ajarans)) { ?>
            <?php foreach ($tahun_ajarans as $key => $tahun_ajaran): ?>
                <tr>
                    <td>
                        <input class="tahun_ajaran_index_ck" name="ids[]" type="checkbox" value="<?php echo $tahun_ajaran['id']; ?>">
                    </td>
                    <td>
                        <?php echo $tahun_ajaran['nama'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('tahunajarans/' . $tahun_ajaran['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('tahunajarans/' . $tahun_ajaran['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
                                <a href="#modal_tahun_ajaran_delete<?php echo $tahun_ajaran['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_tahun_ajaran_delete<?php echo $tahun_ajaran['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Tahun Ajaran</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data tahun_ajaran <?php echo $tahun_ajaran['nama'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('tahunajarans/' . $tahun_ajaran['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="pagination-tahun_ajaran" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_TAHUN_AJARAN', $this->session->userdata('privileges'))) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('tahunajarans/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_tahun_ajaran_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Tahun Ajaran</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="tahun_ajaran_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
