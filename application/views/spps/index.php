<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-spp a").each(function() {
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
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('spps') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="spp-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="spp-column">
                        <option value="nis" <?php echo $column === "nis" ? "selected" : "" ?>>NIS</option>
                        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
                        <option value="bulan_tempo" <?php echo $column === "bulan_tempo" ? "selected" : "" ?>>Bulan</option>
                        <option value="tahun_tempo" <?php echo $column === "tahun_tempo" ? "selected" : "" ?>>Tahun</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('spps/deletes', 'id="tb_spp_idx_frm"') ?>
<table class="table table-hover spp_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="spp_checkall" name="spp_checkall" value="spp_checkall" />
            </td>
            <td>NIS</td>
            <td>Nama</td>
            <td>Bulan</td>
            <td>Tahun</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_SPP')) { ?>
                            <li>
                                <a href="#modal_spp_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($spps)) { ?>
            <?php foreach ($spps as $key => $spp): ?>
                <tr>
                    <td>
                        <input class="spp_index_ck" name="ids[]" type="checkbox" value="<?php echo $spp['id']; ?>">
                    </td>
                    <td>
                        <?php echo $spp['nis'] ?>
                    </td>
                    <td>
                        <?php echo $spp['nama'] ?>
                    </td>
                    <td>
                        <?php echo get_month($spp['bulan_tempo']) ?>
                    </td>
                    <td>
                        <?php echo $spp['tahun_tempo'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_SPP')) { ?>
                                <a href="<?php echo site_url('spps/' . $spp['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_SPP')) { ?>
                                <a href="<?php echo site_url('spps/' . $spp['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_SPP')) { ?>
                                <a href="#modal_spp_delete<?php echo $spp['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_spp_delete<?php echo $spp['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data SPP</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data spp <?php echo $spp['nis'] . ' ' . get_month($spp['bulan_tempo']) . ' ' . $spp['tahun_tempo'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('spps/' . $spp['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="pagination-spp" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_SPP')) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('spps/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_spp_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data SPP</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="spp_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
