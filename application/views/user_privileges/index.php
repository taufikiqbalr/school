<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-user_privilege a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('userprivileges') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="user_privilege-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="user_privilege-column">
        <option value="username" <?php echo $column === "username" ? "selected" : "" ?>>Nama User</option>
        <option value="upriv_name" <?php echo $column === "upriv_name" ? "selected" : "" ?>>Nama Hak Akses</option>
    </select>
    <button type="submit" class="btn">GO</button>
</form>

<?php echo form_open('userprivileges/deletes', 'id="tb_user_privilege_idx_frm"') ?>
<table class="table table-hover user_privilege_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="user_privilege_checkall" name="user_privilege_checkall" value="user_privilege_checkall" />
            </td>
            <td>Nama User</td>
            <td>Nama Hak Akses</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_HAK_AKSES_GRUP')) { ?>
                        <li>
                            <a href="#modal_user_privilege_deletes" data-toggle="modal">Hapus</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($user_privileges)) { ?>
            <?php foreach ($user_privileges as $key => $user_privilege): ?>
                <tr>
                    <td>
                        <input class="user_privilege_index_ck" name="ids[]" type="checkbox" value="<?php echo $user_privilege['id']; ?>">
                    </td>
                    <td>
                        <?php echo $user_privilege['username'] ?>
                    </td>
                    <td>
                        <?php echo $user_privilege['upriv_name'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_HAK_AKSES_GRUP')) { ?>
                            <a href="<?php echo site_url('userprivileges/' . $user_privilege['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_HAK_AKSES_GRUP')) { ?>
                            <a href="<?php echo site_url('userprivileges/' . $user_privilege['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_HAK_AKSES_GRUP')) { ?>
                            <a href="#modal_user_privilege_delete<?php echo $user_privilege['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_user_privilege_delete<?php echo $user_privilege['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Hak Akses</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus hak akses <?php echo $user_privilege['username'] ?> - <?php echo $user_privilege['upriv_name'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('userprivileges/' . $user_privilege['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="pagination-user_privilege" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_HAK_AKSES_GRUP')) { ?>
<div class="pull-right">
    <p>
        <a href="<?php echo site_url('userprivileges/new') ?>" class="btn btn-primary">Tambah</a>
    </p>
</div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_user_privilege_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Hak Akses</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="user_privilege_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
