<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-siswa_nilai a").each(function() {
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
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('siswanilais') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="siswa_nilai-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="siswa_nilai-column">
                        <option value="nip" <?php echo $column === "nip" ? "selected" : "" ?>>Guru</option>
                        <option value="nis" <?php echo $column === "nis" ? "selected" : "" ?>>Siswa</option>
                        <option value="kode" <?php echo $column === "kode" ? "selected" : "" ?>>Mata Pelajaran</option>
                        <option value="tingkat" <?php echo $column === "tingkat" ? "selected" : "" ?>>Kelas</option>
                        <option value="nama_tahun_ajaran" <?php echo $column === "nama_tahun_ajaran" ? "selected" : "" ?>>Tahun Ajaran</option>
                        <option value="semester" <?php echo $column === "semester" ? "selected" : "" ?>>Semester</option>
                        <option value="jenis" <?php echo $column === "jenis" ? "selected" : "" ?>>Jenis</option>
                        <option value="nama" <?php echo $column === "nama" ? "selected" : "" ?>>Yg Ke</option>
                        <option value="nilai" <?php echo $column === "nilai" ? "selected" : "" ?>>Nilai</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('siswa_nilais/deletes', 'id="tb_siswa_nilai_idx_frm"') ?>
<table class="table table-hover siswa_nilai_index">
    <thead>
        <tr>
            <td>
                <input type="checkbox" id="siswa_nilai_checkall" name="siswa_nilai_checkall" value="siswa_nilai_checkall" />
            </td>
            <td>Guru</td>
            <td>Siswa</td>
            <td>Mata Pelajaran</td>
            <td>Kelas</td>
            <td>Tahun Ajaran</td>
            <td>Semester</td>
            <td>Jenis</td>
            <td>Yg Ke</td>
            <td>Nilai</td>
            <td>
                <div class="btn-group pull-right">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        Action
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (is_privilege('DELETE_NILAI_SISWA', $this->session->userdata('privileges'))) { ?>
                            <li>
                                <a href="#modal_siswa_nilai_deletes" data-toggle="modal">Hapus</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswa_nilais)) { ?>
            <?php foreach ($siswa_nilais as $key => $siswa_nilai): ?>
                <tr>
                    <td>
                        <input class="siswa_nilai_index_ck" name="ids[]" type="checkbox" value="<?php echo $siswa_nilai['id']; ?>">
                    </td>
                    <td>
                        <?php echo $siswa_nilai['nip'] . ' - ' . $siswa_nilai['nama_guru'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['nis'] . ' - ' . $siswa_nilai['nama_siswa'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['kode'] . ' - ' . $siswa_nilai['nama_mata_pelajaran'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['tingkat'] . ' ' . $siswa_nilai['nama_jurusan'] . ' ' . $siswa_nilai['nama_kelas'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['nama_tahun_ajaran'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['semester'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['jenis'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['nama'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai['nilai'] ?>
                    </td>
                    <td>
                        <p>
                            <?php if (is_guru('SHOW_NILAI_SISWA', $this->session->userdata('privileges'))) { ?>
                                <a href="<?php echo site_url('siswanilais/' . $siswa_nilai['id']) ?>" class="btn btn-mini">Lihat</a>
                            <?php } ?>
                            <?php if (is_guru_matpel($siswa_nilai['guru_kelas_matpel_id'], 'EDIT_NILAI_SISWA', $guru_kelas_matpel_ids)) { ?>
                                <a href="<?php echo site_url('siswanilais/' . $siswa_nilai['id'] . '/edit') ?>" class="btn btn-mini btn-warning">Ubah</a>
                            <?php } ?>
                            <?php if (is_guru_matpel($siswa_nilai['guru_kelas_matpel_id'], 'DELETE_NILAI_SISWA', $guru_kelas_matpel_ids)) { ?>
                                <a href="#modal_siswa_nilai_delete<?php echo $siswa_nilai['id'] ?>" class="btn btn-mini btn-danger" data-toggle="modal">Hapus</a>
                            <?php } ?>
                        </p>
                        <div id="modal_siswa_nilai_delete<?php echo $siswa_nilai['id'] ?>" class="modal hide fade">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>Hapus Data Nilai Siswa</h3>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin menghapus data nilai siswa <?php echo $siswa_nilai['kode'] ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Batal</a>
                                <a href="<?php echo site_url('siswanilais/' . $siswa_nilai['id'] . '/delete') ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="11"><p class="text-center">Data Kosong</p></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</form>
<div class="clearfix"></div>
<div class="pagination-text pull-left">Halaman <?php echo $cur_page; ?> dari <?php echo $num_pages; ?> dengan total <?php echo $total_rows; ?> data</div>
<div id="pagination-siswa_nilai" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
<?php if (is_guru_matpel($siswa_nilai['guru_kelas_matpel_id'], 'NEW_NILAI_SISWA', $guru_kelas_matpel_ids)) { ?>
    <div class="pull-right">
        <p>
            <a href="<?php echo site_url('siswanilais/new') ?>" class="btn btn-primary">Tambah</a>
        </p>
    </div>
<?php } ?>
<div class="clearfix"></div>
<div id="modal_siswa_nilai_deletes" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Hapus Data Nilai Siswa</h3>
    </div>
    <div class="modal-body">
        <p>Apakah anda yakin?</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Batal</a>
        <a href="#" class="btn btn-danger" id="siswa_nilai_idx_del" data-dismiss="modal">Hapus</a>
    </div>
</div>
