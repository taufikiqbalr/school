<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-staff a").each(function() {
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
        <div id="collapseOne" class="accordion-body collapse out">
            <div class="accordion-inner">
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('staffs') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="staff-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="staff-column">
                        <option value="nik" <?php echo $column === "nik" ? "selected" : "" ?>>NIK</option>
                        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
                        <option value="no_handphone" <?php echo $column === "no_handphone" ? "selected" : "" ?>>No Handphone</option>
                        <option value="jenis_kelamin" <?php echo $column === "jenis_kelamin" ? "selected" : "" ?>>Jenis Kelamin</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('staffs/deletes', 'id="tb_staff_idx_frm"') ?>
<table class="table table-hover staff_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="staff_checkall" name="staff_checkall" value="staff_checkall" />
            </td>
            <td>NIK</td>
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
                        <?php if (is_privilege('DELETE_STAFF')) { ?>
                            <li>
                                <a href="#modal_staff_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($staffs)) { ?>
            <?php foreach ($staffs as $key => $staff): ?>
                <tr>
                    <td>
                        <input class="staff_index_ck" name="ids[]" type="checkbox" value="<?php echo $staff['id']; ?>">
                    </td>
                    <td>
                        <?php echo $staff['nik'] ?>
                    </td>
                    <td>
                        <?php echo $staff['nama'] ?>
                    </td>
                    <td>
                        <?php echo $staff['no_handphone'] ?>
                    </td>
                    <td>
                        <?php echo ($staff['jenis_kelamin'] === "1") ? "Laki-Laki" : "Perempuan" ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('NEW_STAFF')) { ?>
                                <?php if (!empty($staff['user_id'])){ ?>
                                    <a href="<?php echo base_url();?>cam/shot.php?act=g&id=<?php echo $staff['user_id'];?>" target="_blank" class="btn btn-mini btn-success">Foto</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if (is_privilege('SHOW_STAFF')) { ?>
                                <a href="<?php echo site_url('staffs/' . $staff['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_STAFF')) { ?>
                                <a href="<?php echo site_url('staffs/' . $staff['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_STAFF')) { ?>
                                <a href="#modal_staff_delete<?php echo $staff['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_staff_delete<?php echo $staff['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Staff</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data staff <?php echo $staff['nik'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('staffs/' . $staff['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="pagination-staff" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_STAFF')) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('staffs/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_staff_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Staff</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="staff_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
