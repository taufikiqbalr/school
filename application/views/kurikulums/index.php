<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-kurikulum a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('kurikulums') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="kurikulum-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="kurikulum-column">
        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
        </select>
    <button type="submit" class="btn">GO</button>
</form>

<?php echo form_open('kurikulums/deletes', 'id="tb_kurikulum_idx_frm"') ?>
<table class="table table-hover kurikulum_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="kurikulum_checkall" name="kurikulum_checkall" value="kurikulum_checkall" />
            </td>
            <td>Nama</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_KURIKULUM', $this->session->userdata('privileges'))) { ?>
                        <li>
                            <a href="#modal_kurikulum_deletes" data-toggle="modal">Hapus</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($kurikulums)) { ?>
            <?php foreach ($kurikulums as $key => $kurikulum): ?>
                <tr>
                    <td>
                        <input class="kurikulum_index_ck" name="ids[]" type="checkbox" value="<?php echo $kurikulum['id']; ?>">
                    </td>
                    <td>
                        <?php echo $kurikulum['nama'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_KURIKULUM', $this->session->userdata('privileges'))) { ?>
                            <a href="<?php echo site_url('kurikulums/' . $kurikulum['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_KURIKULUM', $this->session->userdata('privileges'))) { ?>
                            <a href="<?php echo site_url('kurikulums/' . $kurikulum['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_KURIKULUM', $this->session->userdata('privileges'))) { ?>
                            <a href="#modal_kurikulum_delete<?php echo $kurikulum['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_kurikulum_delete<?php echo $kurikulum['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Kurikulum</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data kurikulum <?php echo $kurikulum['nama'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('kurikulums/' . $kurikulum['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="3"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-kurikulum" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_KURIKULUM', $this->session->userdata('privileges'))) { ?>
<div class="pull-right">
    <p>
        <a href="<?php echo site_url('kurikulums/new') ?>" class="btn btn-primary">Tambah</a>
    </p>
</div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_kurikulum_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Kurikulum</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="kurikulum_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
