<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-user_group a").each(function() {
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
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('usergroups') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="user_group-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="user_group-column">
                        <option value="ugrp_name" <?php echo $column === "ugrp_name" ? "selected" : "" ?>>Nama Grup</option>
                        <option value="ugrp_desc" <?php echo $column === "ugrp_desc" ? "selected" : "" ?>>Deskripsi Grup</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('usergroups/deletes', 'id="tb_user_group_idx_frm"') ?>
<table class="table table-hover user_group_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="user_group_checkall" name="user_group_checkall" value="user_group_checkall" />
            </td>
            <td>Nama Grup</td>
            <td>Deskripsi Grup</td>
            <td>Grup Admin</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_GRUP_USER', $this->session->userdata('privileges'))) { ?>
                            <li>
                                <a href="#modal_user_group_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($user_groups)) { ?>
            <?php foreach ($user_groups as $key => $user_group): ?>
                <tr>
                    <td>
                        <input class="user_group_index_ck" name="ids[]" type="checkbox" value="<?php echo $user_group['ugrp_id']; ?>">
                    </td>
                    <td>
                        <?php echo $user_group['ugrp_name'] ?>
                    </td>
                    <td>
                        <?php echo $user_group['ugrp_desc'] ?>
                    </td>
                    <td>
                        <?php echo ($user_group['ugrp_admin'] === "1") ? "Ya" : "Tidak" ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_GRUP_USER', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('usergroups/' . $user_group['ugrp_id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_GRUP_USER', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('usergroups/' . $user_group['ugrp_id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_GRUP_USER', $this->session->userdata('privileges'))) { ?>
                                <a href="#modal_user_group_delete<?php echo $user_group['ugrp_id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_user_group_delete<?php echo $user_group['ugrp_id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Grup User</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus grup user <?php echo $user_group['ugrp_name'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('usergroups/' . $user_group['ugrp_id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="5"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-user_group" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_GRUP_USER', $this->session->userdata('privileges'))) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('usergroups/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_user_group_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Grup User</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="user_group_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
