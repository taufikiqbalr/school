<script type="text/javascript">
    $(document).ready(function() {
        $("#pagination-siswa_nilai_akhir a").each(function() {
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
                <form class="form-inline" accept-charset="utf-8" method="get" action="<?php echo site_url('siswanilaiakhirs') ?>">
                    <input type="text" class="input-large" placeholder="Search..." name="cond" value="<?php echo $cond ?>"/>
                    <label>Sort</label>
                    <select class="span1" name="order" id="siswa_nilai_akhir-order">
                        <option value="asc" <?php echo $order === "asc" ? "selected" : "" ?>>Asc</option>
                        <option value="desc" <?php echo $order === "desc" ? "selected" : "" ?>>Desc</option>
                    </select>
                    <label>By</label>
                    <select class="span2" name="column" id="siswa_nilai_akhir-column">
                        <option value="kode" <?php echo $column === "kode" ? "selected" : "" ?>>Mata Pelajaran</option>
                        <option value="nis" <?php echo $column === "nis" ? "selected" : "" ?>>Siswa</option>
                        <option value="tingkat" <?php echo $column === "tingkat" ? "selected" : "" ?>>Kelas</option>
                        <option value="nama_tahun_ajaran" <?php echo $column === "nama_tahun_ajaran" ? "selected" : "" ?>>Tahun Ajaran</option>
                        <option value="semester" <?php echo $column === "semester" ? "selected" : "" ?>>Semester</option>
                        <option value="nilai_akhir" <?php echo $column === "nilai_akhir" ? "selected" : "" ?>>Nilai Akhir</option>
                    </select>
                    <button type="submit" class="btn">GO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('siswa_nilai_akhirs/deletes', 'id="tb_siswa_nilai_akhir_idx_frm"') ?>
<table class="table table-hover siswa_nilai_akhir_index">
    <thead>
        <tr>
            <td>Mata Pelajaran</td>
            <td>Kelas</td>
            <td>Tahun Ajaran</td>
            <td>Semester</td>
            <td>Siswa</td>
            <td>Nilai Akhir</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswa_nilai_akhirs)) { ?>
            <?php foreach ($siswa_nilai_akhirs as $key => $siswa_nilai_akhir): ?>
                <tr>
                    <td>
                        <?php echo $siswa_nilai_akhir['kode'] . ' - ' . $siswa_nilai_akhir['nama_mata_pelajaran'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai_akhir['tingkat'] . ' ' . $siswa_nilai_akhir['nama_jurusan'] . ' ' . $siswa_nilai_akhir['nama_kelas'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai_akhir['nama_tahun_ajaran'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai_akhir['semester'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai_akhir['nis'] . ' - ' . $siswa_nilai_akhir['nama_siswa'] ?>
                    </td>
                    <td>
                        <?php echo $siswa_nilai_akhir['nilai_akhir'] ?>
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
<div id="pagination-siswa_nilai_akhir" class="pagination-textlink pull-left"><?php echo $links; ?></div>
<div class="clearfix"></div>
