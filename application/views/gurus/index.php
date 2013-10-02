<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-guru a").each(function() {
            var g = "&order=<?php echo $order ?>&column=<?php echo $column ?>&cond=<?php echo $cond ?>";
            var href = $(this).attr('href');
            $(this).attr('href', href + g);
        });
    });
</script>

<?php echo $this->session->flashdata('message'); ?>

<?php if (is_privilege('NEW_GURU')) { ?>
    <?php echo form_open_multipart('gurus/upload'); ?>

    <input type="file" name="guru" size="20" />

    <input type="submit" value="upload" />
    
    <a href="<?php echo base_url('upload/template_guru.xls') ?>">Template Guru</a>

    </form>
<?php } ?>

<form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('gurus') ?>">
    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
    <label>Sort</label>
    <select class="span1" name="order" id="guru-order">
        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
    </select>
    <label>By</label>
    <select class="span2" name="column" id="guru-column">
        <option value="nip" <?php echo $column === "nip" ? "selected" : "" ?>>NIP</option>
        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Nama</option>
        <option value="no_handphone" <?php echo $column === "no_handphone" ? "selected" : "" ?>>No Handphone</option>
        <option value="jenis_kelamin" <?php echo $column === "jenis_kelamin" ? "selected" : "" ?>>Jenis Kelamin</option>
    </select>
    <button type="submit" class="btn">GO</button>
</form>

<?php echo form_open('gurus/deletes', 'id="tb_guru_idx_frm"') ?>
<table class="table table-hover guru_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="guru_checkall" name="guru_checkall" value="guru_checkall" />
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
                        <?php if (is_privilege('DELETE_GURU')) { ?>
                            <li>
                                <a href="#modal_guru_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($gurus)) { ?>
            <?php foreach ($gurus as $key => $guru): ?>
                <tr>
                    <td>
                        <input class="guru_index_ck" name="ids[]" type="checkbox" value="<?php echo $guru['id']; ?>">
                    </td>
                    <td>
                        <?php echo $guru['nip'] ?>
                    </td>
                    <td>
                        <?php echo $guru['nama'] ?>
                    </td>
                    <td>
                        <?php echo $guru['no_handphone'] ?>
                    </td>
                    <td>
                        <?php echo ($guru['jenis_kelamin'] === "1") ? "Laki-Laki" : "Perempuan" ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_privilege('SHOW_GURU')) { ?>
                                <a href="<?php echo site_url('gurus/' . $guru['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_privilege('EDIT_GURU')) { ?>
                                <a href="<?php echo site_url('gurus/' . $guru['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_privilege('DELETE_GURU')) { ?>
                                <a href="#modal_guru_delete<?php echo $guru['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_guru_delete<?php echo $guru['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Guru</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data guru <?php echo $guru['nip'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('gurus/' . $guru['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
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
<div id="pagination-guru" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_privilege('NEW_GURU')) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('gurus/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_guru_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Guru</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="guru_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
